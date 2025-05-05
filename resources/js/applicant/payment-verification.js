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
            width: 700,
            confirmButtonText: 'Close',
            customClass: {
                confirmButton: 'btn-submit'
            }
        });
    } else {      
    Swal.fire({
        imageUrl: fileUrl,
        imageAlt: 'Proof of Payment',
        width: 500,
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
