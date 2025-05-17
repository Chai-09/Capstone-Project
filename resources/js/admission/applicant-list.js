document.addEventListener('DOMContentLoaded', () => {
  if (window.flashSuccess) {
    Swal.fire({
      icon: 'success',
      title: window.flashSuccess,
      confirmButtonText: 'OK',
      customClass: {
        popup: 'swal2-border-radius'
      }
    });
  }
});
