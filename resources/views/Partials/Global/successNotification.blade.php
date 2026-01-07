<!-- @if ($message = Session::get('success'))
        <<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{!! $message !!}",
                showConfirmButton: false,
                timer: 3000,
                // toast: true,
            });
        });
    </script>
    <a href="#" class="btn btn-outline-primary rounded notify-btn mb-1" data-from="top"
        data-align="left">Top Left</a>

    <div class="alert alert-success alert-dismissible fade show rounded mb-0" role="alert">
        <strong>Holy guacamole!</strong> You should check in on some of those fields below.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif -->

@if ($message = Session::get('success'))
<script>
    document.addEventListener("DOMContentLoaded", function () {
        $.notify(
            {
                message: "{{ $message }}"
            },
            {
                type: "success",
                allow_dismiss: true,
                newest_on_top: true,
                placement: {
                    from: "top",
                    align: "right"
                },
                delay: 3000,
                animate: {
                    enter: "animated fadeInDown",
                    exit: "animated fadeOutUp"
                }
            }
        );
    });
</script>
@endif