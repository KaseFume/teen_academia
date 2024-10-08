document.querySelectorAll('.nav-item').forEach(item => {
    item.addEventListener('click', function () {
        document.querySelector('.nav-item.active').classList.remove('active');
        this.classList.add('active');
    });
});
