// Select/Deselect all users
document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
    checkbox.addEventListener('click', function() {
        if (this.id === 'select-all') {
            document.querySelectorAll('input[type="checkbox"]').forEach(box => {
                box.checked = this.checked;
            });
        }
    });
});
