<script src="{{ url('/assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ url('/assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ url('/assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ url('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ url('/assets/vendor/libs/hammer/hammer.js') }}"></script>
<script src="{{ url('/assets/vendor/libs/node-waves/node-waves.js') }}"></script>
<script src="{{ url('/vendor/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script src="{{ url('assets/vendor/libs/sweetalert2/custom.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ url('/assets/vendor/js/menu.js') }}"></script>
<script src="{{ url('/assets/js/axios.min.js') }}"></script>
<script src="{{ url('/assets/js/main.js') }}"></script>
<script src="{{ url('/assets/js/dosenSearch.js') }}"></script>
<script src="{{ url('/assets/js/form-handler.js') }}"></script>

{{-- libs --}}
<script src="{{ url('assets/vendor/libs/quill/katex.js') }}"></script>
<script src="{{ url('assets/vendor/libs/quill/quill.js') }}"></script>

<script>
$(document).ready(function() {
    $(document).on('submit', '.delete_record', function(e) {
        var form = $(this);
        if (!form.data('confirmed')) { // Check if the form has not been confirmed for submission
            e.preventDefault(); // If it hasn't, prevent the form from submitting
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Semua data yang terkait akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-outline-danger ms-1'
                },
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.data('confirmed', true); // Set a flag to indicate the form has been confirmed for submission
                    form.submit();
                }
            });
        }
    });
});
</script>


@stack('scripts')
@yield('scripts')
