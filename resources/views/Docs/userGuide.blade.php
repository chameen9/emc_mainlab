@extends('Layouts.master')

@section('title', 'User Guide')
@section('nav', 'user-guide')

@section('content')
<div class="container-fluid">

    <div class="row mb-4">
        <div class="col-12">
            <h1>User Guide</h1>
            <p class="text-muted">
                This guide explains how to use the Main Lab Booking System, what each section does,
                and how bookings, conflicts, and notifications are handled.
            </p>
            <div class="separator mb-4"></div>
        </div>
    </div>

    <!-- Dashboard -->
    <div class="card mb-4">
        <div class="card-body">
            <h4><span class="iconsminds-statistic"></span> Dashboard</h4>
            <p>
                The dashboard provides a quick overview of the system.
            </p>
            <ul>
                <li>Overall monthly usage in the Main Lab</li>
                <li>Total bookings for this week and this month</li>
                <li>Total batch events for this week and this month</li>
                <li>Trending Batch, Student & Busiest day in last month</li>
                <li>Overall completetion task vise</li>
            </ul>
            <p class="text-muted">
                This page is mainly for monitoring and does not affect bookings directly.
            </p>
        </div>
    </div>

    <!-- Calendar View -->
    <div class="card mb-4">
        <div class="card-body">
            <h4><span class="simple-icon-calendar"></span> Calendar View</h4>
            <p>
                The Calendar View shows all bookings visually by date and time.
            </p>

            <ul>
                <li>Day, Week, and Month views are available</li>
                <li>Each booking is color-coded based on its type</li>
                <li>Clicking on a booking opens detailed information</li>
            </ul>

            <p><strong>Booking Colors & New Events:</strong></p>
            <ul>
                <li>Click on the <span class="simple-icon-info"></span> info icon in the Top Navigation Panel</li>
            </ul>

            <p class="text-muted">
                The calendar is read-only for viewing. All new bookings are created using the booking forms.
            </p>
        </div>
    </div>

    <!-- Task View -->
    <div class="card mb-4">
        <div class="card-body">
            <h4><span class="iconsminds-check"></span> Task View (Table View)</h4>
            <p>
                The Task View displays bookings in a table format.
            </p>

            <ul>
                <li>Default view shows today’s bookings</li>
                <li>You can switch between Day, Week, and Month</li>
                <li>Search by Student ID or Batch</li>
                <li>Click a row to open booking details</li>
            </ul>

            <p class="text-muted">
                This view is useful for administrators who prefer lists over calendars.
            </p>
        </div>
    </div>

    <!-- Temporary Booking -->
    <div class="card mb-4">
        <div class="card-body">
            <h4><span class="iconsminds-student-male"></span> Temporary Student Booking</h4>
            <p>
                Temporary bookings are one-time reservations for a specific date.
            </p>

            <ul>
                <li>Used for exams or practical sessions</li>
                <li>System checks for batch exams, batch practicals, and holidays</li>
                <li>Computer conflicts are checked automatically</li>
            </ul>

            <p><strong>Important Rules:</strong></p>
            <ul>
                <li>Bookings cannot overlap with batch exams or holidays</li>
                <li>Practical bookings must have a computer selected</li>
                <li>If a conflict exists, the booking will be rejected</li>
            </ul>
        </div>
    </div>

    <!-- Permanent Booking -->
    <div class="card mb-4">
        <div class="card-body">
            <h4><span class="iconsminds-repeat"></span> Permanent Student Booking</h4>
            <p>
                Permanent bookings reserve the lab weekly for a fixed duration.
            </p>

            <ul>
                <li>Select a day (e.g. every Thursday)</li>
                <li>Select duration in months</li>
                <li>Computer selection is mandatory</li>
            </ul>

            <p><strong>How conflicts are handled:</strong></p>
            <ul>
                <li>If a batch exam, practical, or holiday exists on a date, that date is skipped</li>
                <li>Valid dates are reserved automatically</li>
                <li>Skipped and reserved dates are emailed to the student</li>
            </ul>
        </div>
    </div>

    <!-- Batch Events -->
    <div class="card mb-4">
        <div class="card-body">
            <h4>
                <span class="iconsminds-student-hat"></span>
                Batch Events
            </h4>

            <p>
                Batch Events are used to schedule lab sessions for an entire batch,
                such as examinations and practical sessions. These events have
                higher priority than individual student bookings.
            </p>

            <p><strong>Types of Batch Events:</strong></p>
            <ul>
                <li><strong>Batch Exam</strong> – Reserves the entire lab for an examination</li>
                <li><strong>Batch Practical</strong> – Reserves the lab for practical sessions</li>
            </ul>

            <p><strong>Important Rules:</strong></p>
            <ul>
                <li>Batch Events block all individual student bookings during the selected time</li>
                <li>Individual and permanent bookings are automatically rejected or skipped if a batch event exists</li>
                <li>Batch Events should always be created before scheduling individual bookings</li>
            </ul>

            <p><strong>What happens when a conflict exists:</strong></p>
            <ul>
                <li>Temporary student bookings cannot be created during batch events</li>
                <li>Permanent bookings automatically skip the conflicted dates</li>
                <li>Skipped dates are clearly listed in confirmation emails</li>
            </ul>

            <p class="text-muted">
                Tip: Always schedule Batch Exams and Batch Practicals in advance to avoid
                conflicts with student reservations.
            </p>
        </div>
    </div>


    <!-- Batches -->
    <div class="card mb-4">
        <div class="card-body">
            <h4><span class="iconsminds-student-male-female"></span> Batches</h4>
            <p>
                Batch management allows administrators to manage academic batches.
            </p>

            <ul>
                <li>Assign or change batch owners (lecturers)</li>
                <li>Update batch status</li>
                <li>Maintain accurate student counts</li>
            </ul>
        </div>
    </div>

    <!-- Computer & Software Management -->
    <div class="card mb-4">
        <div class="card-body">
            <h4>
                <span class="iconsminds-computer"></span>
                Computer & Software Management
            </h4>

            <p>
                This section is used to manage all computers available in the lab and
                the software installed on each machine. These details are critical
                when scheduling practical sessions and permanent bookings.
            </p>

            <p><strong>What you can manage here:</strong></p>
            <ul>
                <li>Add and maintain lab computers</li>
                <li>Activate or deactivate computers</li>
                <li>Record installed software for each computer</li>
            </ul>

            <p><strong>How the system uses this information:</strong></p>
            <ul>
                <li>Only <strong>active computers</strong> can be reserved</li>
                <li>For practical bookings, a computer selection is mandatory</li>
                <li>Software availability is displayed when selecting a computer</li>
                <li>Conflicting computer reservations are automatically blocked</li>
            </ul>

            <p><strong>Important Notes:</strong></p>
            <ul>
                <li>Inactive computers will not appear in booking forms</li>
                <li>Software details help ensure students receive the required tools</li>
                <li>Permanent bookings require a fixed computer assignment</li>
            </ul>

            <p class="text-muted">
                Tip: Keep software information up to date to avoid scheduling issues
                during practical sessions.
            </p>
        </div>
    </div>


    <!-- Holidays -->
    <div class="card mb-4">
        <div class="card-body">
            <h4><span class="iconsminds-palm-tree"></span> Holidays</h4>
            <p>
                Holidays block all lab reservations.
            </p>

            <ul>
                <li>Can be see the Holidays for this month</li>
                <li>Make sure to add neccessary holidays in here</li>
                <li>No bookings can be created on holidays</li>
                <li>Permanent bookings automatically skip holidays</li>
            </ul>
        </div>
    </div>

    <!-- Emails & Notifications -->
    <div class="card mb-4">
        <div class="card-body">
            <h4><span class="iconsminds-mail-send"></span> Emails & Notifications</h4>
            <p>
                The system automatically sends emails for important actions.
            </p>

            <ul>
                <li>Booking confirmation emails</li>
                <li>Completion and cancellation notifications</li>
                <li>Reminder emails sent one day before the booking</li>
                <li>Lecturers will recieve emails for their Batch Events</li>
                <li>Students from External Link will recive this all kind of emails</li>
            </ul>

            <p class="text-muted">
                Reminder emails are sent automatically by a scheduled background task.
            </p>
        </div>
    </div>

    <!-- People Management -->
    <div class="card mb-4">
        <div class="card-body">
            <h4>
                <span class="iconsminds-user"></span>
                People Management (Admin Only)
            </h4>

            <p>
                People Management is used to manage all individuals who interact with
                the system, including administrative users and lecturers. This section
                ensures that responsibilities, access levels, and academic ownership
                are clearly defined.
            </p>

            <p><strong>Who is managed here:</strong></p>
            <ul>
                <li><strong>System Users</strong> – administrators and coordinators who operate the system</li>
                <li><strong>Lecturers</strong> – academic staff responsible for batches and lab activities</li>
            </ul>

            <p><strong>User Management:</strong></p>
            <ul>
                <li>Create and manage system user accounts</li>
                <li>Assign roles(Admin/Invigilator) and access permissions</li>
                <li>User will recieve the Password for created user account via email</li>
            </ul>

            <p><strong>Lecturer Management:</strong></p>
            <ul>
                <li>Add and maintain lecturer profiles</li>
                <li>Assign lecturers as batch owners</li>
                <li>Display lecturer details in bookings and notifications</li>
            </ul>

            <p><strong>How the system uses this information:</strong></p>
            <ul>
                <li>Bookings record the creator and assigned lecturer</li>
                <li>Batch ownership is linked to lecturers</li>
                <li>Email notifications reference lecturer and user details</li>
            </ul>

            <p><strong>Security & Accountability:</strong></p>
            <ul>
                <li>All actions are tied to authenticated users</li>
                <li>Role-based access prevents unauthorized operations</li>
                <li>Lecturer assignments ensure academic responsibility</li>
            </ul>

            <p class="text-muted">
                Tip: Keep lecturer and user records accurate to ensure correct ownership,
                notifications, and reporting.
            </p>
        </div>
    </div>

    <!-- Best Practices -->
    <div class="card mb-4">
        <div class="card-body">
            <h4><span class="iconsminds-idea-2"></span> Best Practices</h4>
            <ul>
                <li>Create batch exams and holidays before individual bookings</li>
                <li>Check Task View daily for conflicts</li>
                <li>Cancel unused bookings early</li>
                <li>Verify student email addresses for permanent bookings</li>
            </ul>
        </div>
    </div>

    <!-- Developer Information -->
    <div class="card mb-4">
        <div class="card-body">
            <h4>
                <span class="iconsminds-gear"></span>
                Developer Information
            </h4>

            <p>
                Developed by <b><a href="www.linkedin.com/in/chameensandeepa">Chameen Sandeepa</a></b> using Laravel framework.
            </p>

            <p>
                This system was designed and developed to manage lab reservations
                and resource allocation efficiently within the lab environment.
            </p>

            <p>
                The system is continuously improved based on institutional requirements,
                operational feedback, and academic scheduling policies.
            </p>

            <p class="text-muted">
                For enhancements, bug reports, or system-related improvements,
                please contact the system administrator or development team.
            </p>
        </div>
    </div>


</div>
@endsection