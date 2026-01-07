<!-- @if ($message = Session::get('error'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: "{!! $message !!}",
                showConfirmButton: false,
                timer: 6000,
                // toast: true,
            });
        });
    </script>
@endif  -->

@if ($message = Session::get('error'))
<script>
    document.addEventListener("DOMContentLoaded", function () {
        $.notify(
            {
                message: "{{ $message }}"
            },
            {
                type: "danger",
                allow_dismiss: true,
                newest_on_top: true,
                placement: {
                    from: "top",
                    align: "right"
                },
                delay: 4000,
                animate: {
                    enter: "animated fadeInDown",
                    exit: "animated fadeOutUp"
                }
            }
        );
    });
</script>
@endif