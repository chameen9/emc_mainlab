<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>@yield('title') - EMC Main Lab</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <link rel="stylesheet" href="font/iconsmind-s/css/iconsminds.css" />
        <link rel="stylesheet" href="font/simple-line-icons/css/simple-line-icons.css" />

        <link rel="stylesheet" href="css/vendor/bootstrap.min.css" />
        <link rel="stylesheet" href="css/vendor/bootstrap.rtl.only.min.css" />
        <link rel="stylesheet" href="css/vendor/fullcalendar.min.css" />
        <link rel="stylesheet" href="css/vendor/dataTables.bootstrap4.min.css" />
        <link rel="stylesheet" href="css/vendor/datatables.responsive.bootstrap4.min.css" />
        <link rel="stylesheet" href="css/vendor/perfect-scrollbar.css" />
        <link rel="stylesheet" href="css/vendor/bootstrap-stars.css" />
        <link rel="stylesheet" href="css/vendor/nouislider.min.css" />
        <link rel="stylesheet" href="css/vendor/bootstrap-datepicker3.min.css" />
        <link rel="stylesheet" href="css/vendor/component-custom-switch.min.css" />
        <link rel="stylesheet" href="css/main.css" />
        <link rel="icon" type="image/x-icon" href="img/favicon.ico">

        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

        <style>
            #calendar {
                width: 100%;
                min-height: 600px;    /* Ensures proper display */
                padding: 10px;        /* Adds space inside */
                background: white;    /* Matches card background */
                border-radius: 8px;   /* Smooth shape */
                box-sizing: border-box;
            }

            .fc {
                font-size: 14px;      /* Optional: match your UI */
            }
        </style>

    </head>

    <body id="app-container" class="menu-default show-spinner">
        <nav class="navbar fixed-top">
            <div class="d-flex align-items-center navbar-left">
                <a href="#" class="menu-button d-none d-md-block">
                    <svg class="main" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 9 17">
                        <rect x="0.48" y="0.5" width="7" height="1" />
                        <rect x="0.48" y="7.5" width="7" height="1" />
                        <rect x="0.48" y="15.5" width="7" height="1" />
                    </svg>
                    <svg class="sub" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 17">
                        <rect x="1.56" y="0.5" width="16" height="1" />
                        <rect x="1.56" y="7.5" width="16" height="1" />
                        <rect x="1.56" y="15.5" width="16" height="1" />
                    </svg>
                </a>

                <a href="#" class="menu-button-mobile d-xs-block d-sm-block d-md-none">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 17">
                        <rect x="0.5" y="0.5" width="25" height="1" />
                        <rect x="0.5" y="7.5" width="25" height="1" />
                        <rect x="0.5" y="15.5" width="25" height="1" />
                    </svg>
                </a>

                <a class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block"
                    href="javascript:void(0);" onclick="copyToClipboard('/reserve')">Copy Link</a>
                <script>
                    function copyToClipboard(text) {
                        navigator.clipboard.writeText(window.location.origin + text).then(() => {
                            alert('Link copied to clipboard!');
                        });
                    }
                </script>

                <a class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block"
                    href="{{ route('studentBooking') }}" >Visit Link</a>
            </div>


            <a class="navbar-logo" href="">
                Esoft Metro Campus - Main Lab
                <!-- <span class="logo-single"></span> -->
            </a>

            <div class="navbar-right">
                <div class="header-icons d-inline-block align-middle">

                    <div class="d-none d-md-inline-block align-text-bottom mr-3">
                        <div class="custom-switch custom-switch-primary-inverse custom-switch-small pl-1" 
                            data-toggle="tooltip" data-placement="left" title="Dark Mode">
                            <input class="custom-switch-input" id="switchDark" type="checkbox" checked>
                            <label class="custom-switch-btn" for="switchDark"></label>
                        </div>
                    </div>


                    <button class="header-icon btn btn-empty d-none d-sm-inline-block" type="button" id="fullScreenButton">
                        <i class="simple-icon-size-fullscreen"></i>
                        <i class="simple-icon-size-actual"></i>
                    </button>

                </div>

                <div class="user d-inline-block">
                    <button class="btn btn-empty p-0" type="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <span class="name">{{ auth()->user()->name ?? 'Guest' }}</span>
                        <span>
                            @if(auth()->user()->image)
                            <img
                                src="{{ asset('img/profiles/' . (auth()->user()->image ?? 'default.png')) }}"
                                alt="Profile Picture"
                                style="width:35px;height:35px;"
                            >
                            @else
                            <img
                                src="{{ asset('img/profiles/default.png') }}"
                                alt="Profile Picture"
                                style="width:35px;height:35px;"
                            >
                            @endif
                        </span>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right mt-3">
                        <a class="dropdown-item" href="#editProfile" data-toggle="modal">Profile</a>
                        <a class="dropdown-item" href="#changePassword" data-toggle="modal">Change Password</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">Logout</button>
                        </form>
                        

                    </div>
                </div>
            </div>
        </nav>
        <div class="menu">
            <div class="main-menu">
                <div class="scroll">
                    <ul class="list-unstyled">
                        <li class="{{ trim($__env->yieldContent('nav')) === 'dashboard' ? 'active' : '' }}">
                            <a href="{{route('index')}}">
                                <i class="simple-icon-menu"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="{{ trim($__env->yieldContent('nav')) === 'calendar' ? 'active' : '' }}">
                            <a href="{{route('calendar')}}">
                                <i class="simple-icon-calendar"></i> Calendar
                            </a>
                        </li>
                        <li class="{{ trim($__env->yieldContent('nav')) === 'students' ? 'active' : '' }}">
                            <a href="{{route('students')}}">
                                <i class="simple-icon-graduation"></i> Students
                            </a>
                        </li>
                        <li class="{{ trim($__env->yieldContent('nav')) === 'computers' ? 'active' : '' }}">
                            <a href="{{route('getComputers')}}">
                                <i class="simple-icon-screen-desktop"></i> Computers
                            </a>
                        </li>
                        <li class="{{ trim($__env->yieldContent('nav')) === 'batches' ? 'active' : '' }}">
                            <a href="{{route('batches')}}">
                                <i class="simple-icon-notebook"></i> Batches
                            </a>
                        </li>
                        <li class="{{ trim($__env->yieldContent('nav')) === 'holidays' ? 'active' : '' }}">
                            <a href="{{route('holidays')}}">
                                <i class="simple-icon-event"></i> Holidays
                            </a>
                        </li>
                        <li class="{{ trim($__env->yieldContent('nav')) === 'users' ? 'active' : '' }}">
                            <a href="{{route('users')}}">
                                <i class="simple-icon-user"></i> Users
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
        <main>
            @yield('content')
        </main>

        <footer class="page-footer">
            <div class="footer-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <p class="mb-0 text-muted">Esoft Metro Campus Galle 2025</p>
                        </div>
                        <div class="col-sm-6 d-none d-sm-block">
                            <ul class="breadcrumb pt-0 pr-0 float-right">
                                <li class="breadcrumb-item mb-0">
                                    <a href="tel:+94912231253" class="btn-link">Call</a>
                                </li>
                                <li class="breadcrumb-item mb-0">
                                    <a href="https://maps.app.goo.gl/2t535R7AQmrjkURq6" class="btn-link">Visit</a>
                                </li>
                                <li class="breadcrumb-item mb-0">
                                    <a href="https://www.esoft.lk" class="btn-link">Web</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Change Password Modal -->
        <div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Change Your Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('changePassword') }}">
                        @csrf
                        <div class="modal-body">
                            
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="name" name="name"
                                            placeholder="Enter Name" value="{{ Auth::user()->name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="role" name="role"
                                            placeholder="Enter Role" value="{{ ucfirst(Auth::user()->role) }}" readonly>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="email" name="email"
                                            placeholder="Enter Email" value="{{ Auth::user()->email }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="current_password">Current Password *</label>
                                        <input type="password" class="form-control" id="current_password" name="current_password"
                                            placeholder="Enter Current Password" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="password">New Password *</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="Enter New Password" required>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="confirm_password">Confirm Password *</label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                                            placeholder="Enter Confirm Password" required>
                                    </div>
                                </div>
                            </div>


                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Profile Modal -->
        <div class="modal fade" id="editProfile" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Your Profile</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('editProfile') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="name">Name *</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Enter Name" value="{{ Auth::user()->name }}" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <input type="text" class="form-control" id="role" name="role"
                                            placeholder="Enter Role" value="{{ ucfirst(Auth::user()->role) }}" readonly>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Enter Email" value="{{ Auth::user()->email }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="select-from-library-container mb-1">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-xl-12">

                                        <!-- Clickable upload area -->
                                        <div class="select-from-library-button sfl-single mb-5"
                                            id="imagePicker">
                                            <div class="card d-flex flex-row mb-4 media-thumb-container justify-content-center align-items-center">
                                                Click to change profile picture
                                            </div>
                                        </div>

                                        <!-- Hidden file input -->
                                        <input type="file"
                                            id="imageInput"
                                            name="image"
                                            accept="image/*"
                                            hidden>

                                        <!-- Preview -->
                                        <div class="selected-library-item sfl-selected-item mb-5 d-none"
                                            id="imagePreviewWrapper" style="display: block;">
                                            <div class="card d-flex flex-row media-thumb-container">
                                                <a class="d-flex align-self-center">
                                                    <img src=""
                                                        alt="uploaded image"
                                                        class="list-media-thumbnail responsive border-0"
                                                        id="imagePreview"
                                                        style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;" />
                                                </a>

                                                <div class="d-flex flex-grow-1 min-width-zero">
                                                    <div class="card-body align-self-center">
                                                        <p class="list-item-heading mb-1 truncate"
                                                        id="imageName"></p>
                                                    </div>

                                                    <div class="pl-1 align-self-center">
                                                        <a href="#"
                                                        class="btn-link"
                                                        id="removeImage">
                                                            <i class="simple-icon-trash"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Image Upload Preview Script -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {

                const imagePicker = document.getElementById('imagePicker');
                const imageInput = document.getElementById('imageInput');
                const imagePreviewWrapper = document.getElementById('imagePreviewWrapper');
                const imagePreview = document.getElementById('imagePreview');
                const imageName = document.getElementById('imageName');
                const removeImage = document.getElementById('removeImage');

                // Click card → open file chooser
                imagePicker.addEventListener('click', function () {
                    imageInput.click();
                });

                // File selected → show preview
                imageInput.addEventListener('change', function () {
                    const file = this.files[0];

                    if (!file) return;

                    // DEBUG (remove later)
                    console.log('Selected file:', file);

                    if (!file.type.startsWith('image/')) {
                        alert('Please select an image file');
                        return;
                    }

                    const reader = new FileReader();

                    reader.onload = function (e) {
                        imagePreview.src = e.target.result;
                        imageName.textContent = file.name;
                        imagePreviewWrapper.classList.remove('d-none');
                    };

                    reader.readAsDataURL(file);
                });

                // Remove image
                removeImage.addEventListener('click', function (e) {
                    e.preventDefault();
                    imageInput.value = '';
                    imagePreview.src = '';
                    imageName.textContent = '';
                    imagePreviewWrapper.classList.add('d-none');
                });

            });
        </script>

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

        <script src="js/vendor/jquery-3.3.1.min.js"></script>
        <script src="js/vendor/bootstrap.bundle.min.js"></script>
        <script src="js/vendor/Chart.bundle.min.js"></script>
        <script src="js/vendor/chartjs-plugin-datalabels.js"></script>
        <script src="js/vendor/moment.min.js"></script>
        <!-- <script src="js/vendor/fullcalendar.min.js"></script> -->
        <script src="js/vendor/datatables.min.js"></script>
        <script src="js/vendor/perfect-scrollbar.min.js"></script>
        <script src="js/vendor/progressbar.min.js"></script>
        <script src="js/vendor/jquery.barrating.min.js"></script>
        <script src="js/vendor/nouislider.min.js"></script>
        <script src="js/vendor/bootstrap-datepicker.js"></script>
        <script src="js/vendor/Sortable.js"></script>
        <script src="js/vendor/mousetrap.min.js"></script>
        <script src="js/dore.script.js"></script>
        <script src="js/scripts.js"></script>
        <script src="js/vendor/bootstrap-notify.min.js"></script>
    </body>

</html>