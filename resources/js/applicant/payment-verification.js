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

window.viewProof = viewProof; // expose to global scope
