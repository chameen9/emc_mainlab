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

                @if(trim($__env->yieldContent('nav')) === 'calendar')
                    <a class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block"
                        href="#eventGuide" data-toggle="modal"><span class="simple-icon-info"></span></a>
                @endif
            </div>


            <a class="navbar-logo" href="">
                EMC Galle
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
                        <a class="dropdown-item" href="{{route('userGuide')}}">User Guide</a>
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
                        <li class="{{ trim($__env->yieldContent('nav')) === 'people' ? 'active' : '' }}">
                            <a href="{{route('people')}}">
                                <i class="simple-icon-user"></i> People
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
        @include('Partials.Profile.changePassword')

        <!-- Edit Profile Modal -->
        @include('Partials.Profile.editProfile')

        <!-- Event Guide Modal -->
        @include('Partials.Calendar.eventGuideModal')

        <!-- Success Notification -->
        @include('Partials.Global.successNotification')

        <!-- Error Notification -->
        @include('Partials.Global.errorNotification')

        <!-- Validation Errors Notification -->
        @include('Partials.Global.validationErrorsNotification')

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

        <!-- Calendar Dark Mode Toggle Script -->
        <script>
            $(document).ready(function () {
                const switchDark = $('#switchDark');

                function applyDarkMode(isDark) {
                    if (isDark) {
                        $('body').addClass('dark-mode');
                    } else {
                        $('body').removeClass('dark-mode');
                    }
                }

                // Initial state
                applyDarkMode(switchDark.is(':checked'));

                // On toggle
                switchDark.on('change', function () {
                    applyDarkMode(this.checked);
                });
            });
        </script>

    </body>

</html>