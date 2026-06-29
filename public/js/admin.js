// Admin JavaScript functions

document.addEventListener('DOMContentLoaded', function() {
    // Handle all delete forms
    const deleteForms = document.querySelectorAll('form[data-delete-form]');
    
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const message = this.getAttribute('data-confirm-message') || 'Are you sure you want to delete this item?';
            
            if (confirm(message)) {
                this.submit();
            }
        });
    });

    // Handle delete buttons in btn-group
    const deleteButtons = document.querySelectorAll('button[type="submit"][form-action="delete"]');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const form = this.closest('form');
            if (form) {
                const message = form.getAttribute('data-confirm-message') || 'Are you sure you want to delete this item?';
                if (!confirm(message)) {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }
            }
        });
    });

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Helper function to handle delete with custom confirmation
function confirmDelete(message) {
    return confirm(message || 'Are you sure you want to delete this item?');
}