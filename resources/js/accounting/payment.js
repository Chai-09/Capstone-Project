document.addEventListener('DOMContentLoaded', function () {
    let myDropzone = null;
    let uploadedFile = null;

    window.viewProof = function (fileUrl) {
        const isPDF = fileUrl.toLowerCase().endsWith('.pdf');

        if (isPDF) {
            window.open(fileUrl, '_blank');
        } else {
            Swal.fire({
                title: 'Proof of Payment',
                imageUrl: fileUrl,
                imageAlt: 'Proof of Payment',
                width: 450,
                padding: '1em',
                confirmButtonText: 'Close',
            });
        }
    }

    let currentProofUrl = ''; // Global variable

    window.viewProofFromModal = function () {
    if (currentProofUrl) {
        viewProof(currentProofUrl);
    } else {
        Swal.fire({
        icon: 'info',
        title: 'No receipt uploaded',
        text: 'This applicant did not submit a proof of payment.'
        });
    }
    }

    window.viewInfo = function (data) {
        const oldForm = document.getElementById('updateForm');
        const newForm = oldForm.cloneNode(true);
        oldForm.replaceWith(newForm);

        document.getElementById('idNumber').innerText = data.id || 'N/A';
        document.getElementById('applicantName').innerText = `${data.applicant_fname} ${data.applicant_mname} ${data.applicant_lname}`;
        document.getElementById('gradeLevel').innerText = `${data.incoming_grlvl} ${data.incoming_strand || ''}`.trim();
        document.getElementById('contactNumber').innerText = data.applicant_contact_number;
        document.getElementById('guardianName').innerText =`${data.guardian_fname} ${data.guardian_mname ? data.guardian_mname + '.' : ''} ${data.guardian_lname}`.trim();


        document.getElementById('paymentTime').innerText = new Date(data.created_at).toLocaleString();
        document.getElementById('paymentMethod').innerText = data.payment_method;
        document.getElementById('paymentType').innerText = data.payment_for
        ? (data.payment_for === 'resched' ? 'Reschedule' : 'First-Time')
        : 'N/A';

        const proofContainer = document.getElementById('proofContainer');
        const fileUrl = `/storage/${data.proof_of_payment}`;
        currentProofUrl = fileUrl;  

        document.getElementById('acceptStatus').checked = data.payment_status === 'approved';
        document.getElementById('denyStatus').checked = data.payment_status === 'denied';
        document.getElementById('remarks').value = data.remarks || '';
        document.getElementById('ocr_number').value = data.ocr_number || '';

        document.getElementById('acceptStatus').addEventListener('change', toggleApprovedFields);
        document.getElementById('denyStatus').addEventListener('change', toggleApprovedFields);

        toggleApprovedFields();

        document.getElementById('paymentId').value = data.id;
        newForm.action = `/accountant/payment-decision/${data.id}`;

        newForm.addEventListener('submit', function (e) {
            const isApproved = document.getElementById('acceptStatus')?.checked;

            if (isApproved) {
                const ocrValue = document.getElementById('ocr_number').value.trim();
                const files = myDropzone ? myDropzone.getAcceptedFiles() : [];
                const hasFile = files.length > 0;

                // Validate OCR and Dropzone presence
                if (!ocrValue || !hasFile) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Missing Required Fields',
                        text: 'Please upload a receipt and enter the OCR number before submitting.'
                    });
                    return;
                }

                // Validate file size
                const file = files[0];
                if (file.size > 2 * 1024 * 1024) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'File Too Large',
                        text: 'The uploaded receipt must be 2MB or less.'
                    });
                    return;
                }

                // Handle file queue
                if (myDropzone.getQueuedFiles().length > 0) {
                    e.preventDefault();
                    myDropzone.processQueue();
                }
            }
        });


        new bootstrap.Modal(document.getElementById('infoModal')).show();
    }

    function toggleApprovedFields() {
        const isApproved = document.getElementById('acceptStatus')?.checked;
        const approvedFields = document.getElementById('approvedFields');
        if (!approvedFields) return;

        approvedFields.style.display = isApproved ? 'block' : 'none';

        if (!isApproved) {
            document.getElementById('ocr_number').value = '';
            document.getElementById('receipt').value = '';
            if (myDropzone) {
                try {
                    myDropzone.removeAllFiles(true);
                    myDropzone.destroy();
                    myDropzone = null;
                    document.getElementById('receiptDropzone').innerHTML = '';
                } catch (err) {
                    console.warn('Dropzone destroy failed:', err);
                }
            }
        } else {
            if (!myDropzone) {
                myDropzone = new Dropzone("#receiptDropzone", {
                    url: window.uploadReceiptUrl,
                    autoProcessQueue: false,
                    maxFiles: 1,
                    acceptedFiles: "image/*,.pdf",
                    addRemoveLinks: true,
                    dictRemoveFile: 'Remove',
                    headers: {
                        'X-CSRF-TOKEN': window.csrfToken
                    },
                    success: function (file, response) {
                        uploadedFile = response.file_path;
                        document.getElementById('receipt').value = uploadedFile;
                        document.getElementById('updateForm').submit();
                    },
                    removedfile: function (file) {
                        if (uploadedFile) {
                            fetch(window.deleteReceiptUrl, {
                                method: "POST",
                                headers: {
                                    'X-CSRF-TOKEN': window.csrfToken,
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({ file_path: uploadedFile })
                            });
                            uploadedFile = null;
                            document.getElementById('receipt').value = '';
                        }
                        file.previewElement.remove();
                    }
                });
            }
        }
    }
});
