<!-- @if (count($errors)>0)
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let errorMessages = `{!! implode('<br>', $errors->all()) !!}`;

            Swal.fire({
                icon: 'error',
                title: 'Validation Error!',
                html: errorMessages, // Use HTML to display multiple errors
                //timer: 5000, // Auto-close after 5 seconds
                showConfirmButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK'
                // toast: true,
                // position: 'top-end'
            });
        });
    </script>
@endif -->

@if (count($errors)>0)
<script>
    document.addEventListener("DOMContentLoaded", function () {

        let errorMessages = `{!! implode('<br>', $errors->all()) !!}`;

        $.notify(
            {
                message: errorMessages
            },
            {
                type: "warning",
                allow_dismiss: true,
                newest_on_top: true,
                timer: 5000,
                placement: {
                    from: "top",
                    align: "right"
                }
            }
        );

    });
</script>
@endif