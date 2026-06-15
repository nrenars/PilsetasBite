document.addEventListener('DOMContentLoaded', () => {
    const alert = document.querySelector('.alert');

    if (alert) {
        setTimeout(() => {
            alert.classList.add('hide');

            setTimeout(() => {
                alert.remove();
            }, 400);
        }, 4000);
    }
});