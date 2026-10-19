<script src="{{ asset('assets/js/vendor.min.js') }}?v={{ time() }}"></script>
<script src="{{ asset('assets/js/theme/app.init.js') }}?v={{ time() }}"></script>
<script src="{{ asset('assets/js/theme/app.min.js') }}?v={{ time() }}"></script>
<script src="{{ asset('assets/js/theme.js') }}?v={{ time() }}"></script>

<!-- Solar Icons -->
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

<!-- SweetAlert2 (Standardized Alert Engine) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{ $slot ?? '' }}
@stack('scripts')
