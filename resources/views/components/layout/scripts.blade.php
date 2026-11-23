<script src="{{ asset('assets/js/vendor.min.js') }}?v={{ time() }}"></script>
<script src="{{ asset('assets/js/theme/app.init.js') }}?v={{ time() }}"></script>
<script src="{{ asset('assets/js/theme/app.min.js') }}?v={{ time() }}"></script>
<script src="{{ asset('assets/js/theme.js') }}?v={{ time() }}"></script>

<!-- Solar Icons -->
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

<!-- SweetAlert2 (Standardized Alert Engine) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Universal SweetAlert2 Bridge: Guarantee NO native browser alert() or confirm() is ever displayed.
    (function() {
        if (typeof Swal !== 'undefined') {
            window.alert = function(msg) {
                return Swal.fire({
                    title: 'Perhatian',
                    text: String(msg ?? ''),
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#2563eb'
                });
            };

            if (!window.Alert) {
                window.Alert = {
                    success: (title, message = '') => Swal.fire({ icon: 'success', title: title, text: message, confirmButtonColor: '#2563eb' }),
                    error: (title, message = '') => Swal.fire({ icon: 'error', title: title, text: message, confirmButtonColor: '#2563eb' }),
                    warning: (title, message = '') => Swal.fire({ icon: 'warning', title: title, text: message, confirmButtonColor: '#2563eb' }),
                    confirm: (title, message = '', confirmText = 'Ya, lanjutkan') => Swal.fire({
                        title: title,
                        text: message,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#2563eb',
                        cancelButtonColor: '#6e7a89',
                        confirmButtonText: confirmText,
                        cancelButtonText: 'Batal'
                    }),
                    toast: (message, type = 'success') => {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                        return Toast.fire({ icon: type, title: message });
                    }
                };
            }
        }
    })();
</script>

{{ $slot ?? '' }}
@stack('scripts')
