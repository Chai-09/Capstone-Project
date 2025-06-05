
document.addEventListener('DOMContentLoaded', function () {
    const paymentForm = document.getElementById('step2Payment');
    const paymentSubmitBtn = document.getElementById('paymentSubmission');

    if (paymentSubmitBtn) {
        paymentSubmitBtn.addEventListener('click', function (event) {
            event.preventDefault(); 

            if (paymentForm.checkValidity()) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Please review all information before submitting.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#00753F',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Confirm'
                }).then((result) => {
                    if (result.isConfirmed) {
                        paymentSubmitBtn.disabled = true;
                        paymentSubmitBtn.textContent = 'Submitting...';
                        paymentForm.submit(); // Only submit here
                    }
                });
            } else {
                paymentForm.reportValidity(); // Show native HTML5 validation
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const successMessage = document.querySelector('meta[name="success-message"]');
    if (successMessage) {
        Swal.fire({
            title: 'Success!',
            text: successMessage.content,
            icon: 'success',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    }
});

function viewProof(fileUrl) {

    const isPDF = fileUrl.toLowerCase().endsWith('.pdf');

    if (isPDF) {
        Swal.fire({
            title: 'Proof of Payment (PDF)',
            html: `<iframe src="${fileUrl}" width="100%" height="500px" style="border:none;"></iframe>`,
            width: '90%',
            confirmButtonText: 'Close',
            customClass: {
                confirmButton: 'btn-submit'
            }
        });
    } else {      
    Swal.fire({
        imageUrl: fileUrl,
        imageAlt: 'Proof of Payment',
        width: 'auto',
        imageHeight: 'auto',
        padding: '1em',
        confirmButtonText: 'Close',
        customClass: {
            confirmButton: 'btn-submit'
        }
    });
}
}

window.viewProof = viewProof; // expose to global scope
