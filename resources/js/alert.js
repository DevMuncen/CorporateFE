/**
 * Standardized SweetAlert2 Notifications for CorporateFE
 */
window.Alert = {
    success: (title, message = '') => {
        return Swal.fire({
            icon: 'success',
            title: title,
            text: message,
            confirmButtonColor: '#053363' // Brand primary
        });
    },

    error: (title, message = '') => {
        return Swal.fire({
            icon: 'error',
            title: title,
            text: message,
            confirmButtonColor: '#053363'
        });
    },

    confirm: (title, message = '', confirmText = 'Ya, lanjutkan') => {
        return Swal.fire({
            title: title,
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#053363',
            cancelButtonColor: '#6e7a89',
            confirmButtonText: confirmText,
            cancelButtonText: 'Batal'
        });
    },

    toast: (message, type = 'success') => {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        return Toast.fire({
            icon: type,
            title: message
        });
    },
    
    handleApiErrors: (error, formElement = null) => {
        // Clear previous errors if formElement is provided
        if (formElement) {
            formElement.querySelectorAll('.text-red-500').forEach(el => el.classList.add('hidden'));
            formElement.querySelectorAll('.form-control').forEach(el => el.classList.remove('border-red-500'));
        }

        if (error.errors && Object.keys(error.errors).length > 0) {
            // Validation errors
            let errorList = '<ul class="text-left">';
            for (const [field, messages] of Object.entries(error.errors)) {
                errorList += `<li>- ${messages[0]}</li>`;
                
                // Show inline error if element exists
                if (formElement) {
                    const errorSpan = formElement.querySelector(`#${field}-error`);
                    const inputField = formElement.querySelector(`[name="${field}"]`);
                    
                    if (errorSpan) {
                        errorSpan.innerHTML = messages[0];
                        errorSpan.classList.remove('hidden');
                    }
                    if (inputField) {
                        inputField.classList.add('border-red-500');
                    }
                }
            }
            errorList += '</ul>';
            
            return Swal.fire({
                icon: 'error',
                title: error.message || 'Validation Error',
                html: errorList,
                confirmButtonColor: '#053363'
            });
        } else {
            // General error
            return window.Alert.error('Error', error.message || 'Something went wrong.');
        }
    }
};
