<!-- Permanent Student Event Modal -->
<div class="modal fade" id="newPermanentIndividualEventModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('permanentIndividualEventStore') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Permanent Student Event</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-6">
                            <label>Student ID *</label>
                            <input type="text" name="student_id" class="form-control" placeholder="Enter Student ID" required>
                        </div>
                        <div class="col-6">
                            <label>Email *</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter Student Email" required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-6">
                            <label>Day *</label>
                            <select id="p_day" name="day" class="form-control" required>
                                <option value="">Pick a Day</option>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                                <option value="Sunday">Sunday</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label>Duration *</label>
                            <select id="p_duration" name="duration" class="form-control" required>
                                <option value="">Pick a Duration</option>
                                <option value="1">01 Month</option>
                                <option value="2">02 Month</option>
                                <option value="3">03 Month</option>
                                <option value="4">04 Month</option>
                                <option value="5">05 Month</option>
                                <option value="6">06 Month</option>
                                <option value="7">07 Month</option>
                                <option value="8">08 Month</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="start">Start Time *</label>
                                <select name="start" class="form-control select2-single" id="start" data-width="100%" required>
                                    <option value="">Pick a Time</option>
                                    <option value="08:00">08:00</option>
                                    <option value="08:15">08:15</option>
                                    <option value="08:30">08:30</option>
                                    <option value="08:45">08:45</option>

                                    <option value="09:00">09:00</option>
                                    <option value="09:15">09:15</option>
                                    <option value="09:30">09:30</option>
                                    <option value="09:45">09:45</option>

                                    <option value="10:00">10:00</option>
                                    <option value="10:15">10:15</option>
                                    <option value="10:30">10:30</option>
                                    <option value="10:45">10:45</option>

                                    <option value="11:00">11:00</option>
                                    <option value="11:15">11:15</option>
                                    <option value="11:30">11:30</option>
                                    <option value="11:45">11:45</option>

                                    <option value="12:00">12:00</option>
                                    <option value="12:15">12:15</option>
                                    <option value="12:30">12:30</option>
                                    <option value="12:45">12:45</option>

                                    <option value="13:00">13:00</option>
                                    <option value="13:15">13:15</option>
                                    <option value="13:30">13:30</option>
                                    <option value="13:45">13:45</option>

                                    <option value="14:00">14:00</option>
                                    <option value="14:15">14:15</option>
                                    <option value="14:30">14:30</option>
                                    <option value="14:45">14:45</option>

                                    <option value="15:00">15:00</option>
                                    <option value="15:15">15:15</option>
                                    <option value="15:30">15:30</option>
                                    <option value="15:45">15:45</option>

                                    <option value="16:00">16:00</option>
                                    <option value="16:15">16:15</option>
                                    <option value="16:30">16:30</option>
                                    <option value="16:45">16:45</option>

                                    <option value="17:00">17:00</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="end">End Time *</label>
                                <select name="end" class="form-control select2-single" id="end" data-width="100%" required>
                                    <option value="">Pick a Time</option>
                                    <option value="08:00">08:00</option>
                                    <option value="08:15">08:15</option>
                                    <option value="08:30">08:30</option>
                                    <option value="08:45">08:45</option>

                                    <option value="09:00">09:00</option>
                                    <option value="09:15">09:15</option>
                                    <option value="09:30">09:30</option>
                                    <option value="09:45">09:45</option>

                                    <option value="10:00">10:00</option>
                                    <option value="10:15">10:15</option>
                                    <option value="10:30">10:30</option>
                                    <option value="10:45">10:45</option>

                                    <option value="11:00">11:00</option>
                                    <option value="11:15">11:15</option>
                                    <option value="11:30">11:30</option>
                                    <option value="11:45">11:45</option>

                                    <option value="12:00">12:00</option>
                                    <option value="12:15">12:15</option>
                                    <option value="12:30">12:30</option>
                                    <option value="12:45">12:45</option>

                                    <option value="13:00">13:00</option>
                                    <option value="13:15">13:15</option>
                                    <option value="13:30">13:30</option>
                                    <option value="13:45">13:45</option>

                                    <option value="14:00">14:00</option>
                                    <option value="14:15">14:15</option>
                                    <option value="14:30">14:30</option>
                                    <option value="14:45">14:45</option>

                                    <option value="15:00">15:00</option>
                                    <option value="15:15">15:15</option>
                                    <option value="15:30">15:30</option>
                                    <option value="15:45">15:45</option>

                                    <option value="16:00">16:00</option>
                                    <option value="16:15">16:15</option>
                                    <option value="16:30">16:30</option>
                                    <option value="16:45">16:45</option>

                                    <option value="17:00">17:00</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-6">
                            <label>Type *</label>
                            <select id="p_description" name="description" class="form-control" required>
                                <option value="Practical">Practical</option>
                                <option value="Exam">Exam</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label>Course *</label>
                            <select id="p_course" class="form-control" name="course_id" required>
                                <option value="">Pick a Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->course_code }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-6">
                            <label>Module *</label>
                            <select id="p_module" name="module" class="form-control" required>
                                <option value="">Pick the Course First</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label>Batch *</label>
                            <select id="p_batch" name="batch_id" class="form-control" required>
                                <option value="">Pick the Course First</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="form-group" id="p_computerSection">
                                <label for="p_computer">Computer *</label>
                                <select name="computer_id" id="p_computer" class="form-control" required>
                                    <option value="">Pick a Computer</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-12">
                            <div id="p_softwareDetails" class="mt-2" style="display:none;">
                                <h6>Software Availability:</h6>
                                <div id="p_softwareBadges"></div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function () {

                            const computerSelect  = document.getElementById("p_computer");
                            const softwareDetails = document.getElementById("p_softwareDetails");
                            const softwareBadges  = document.getElementById("p_softwareBadges");

                            // Load computers immediately (permanent booking)
                            loadActiveComputers();

                            function loadActiveComputers() {
                                computerSelect.innerHTML = '<option value="">Pick a Computer</option>';

                                fetch('/get-computers')
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error("Server returned " + response.status);
                                        }
                                        return response.json();
                                    })
                                    .then(computers => {
                                        computers.forEach(computer => {
                                            const option = document.createElement('option');
                                            option.value = computer.id;
                                            option.textContent = computer.computer_label;
                                            computerSelect.appendChild(option);
                                        });
                                    })
                                    .catch(error => {
                                        console.error("Error loading computers:", error);
                                    });
                            }

                            // Fetch software availability when computer is selected
                            computerSelect.addEventListener('change', function () {

                                const computerId = this.value;
                                softwareBadges.innerHTML = "";

                                if (!computerId) {
                                    softwareDetails.style.display = "none";
                                    return;
                                }

                                fetch(`/get-computer-details/${computerId}`)
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error("Server returned " + response.status);
                                        }
                                        return response.json();
                                    })
                                    .then(data => {

                                        Object.entries(data.software).forEach(([software, availability]) => {

                                            const value = String(availability).toLowerCase();
                                            const isAvailable = ["available", "yes", "true", "1"].includes(value);

                                            const badge = document.createElement('span');
                                            badge.className = `badge ${isAvailable ? 'badge-success' : 'badge-danger'}`;
                                            badge.style.margin = "4px";
                                            badge.textContent = software;

                                            softwareBadges.appendChild(badge);
                                        });

                                        softwareDetails.style.display = "block";
                                    })
                                    .catch(error => {
                                        console.error("Error loading software details:", error);
                                    });
                            });

                        });
                    </script>

                    <div class="row mt-3">
                        <div class="col-12">
                            <p style="text-align: justify;">
                                <b>Important</b>
                                <ul>
                                    <li>
                                        Student will reserve the Confirmation Email with Reserved dates and Skipped Days after creation.
                                    </li>
                                    <li>
                                        The student will receive email reminders about this booking one day in advance, sent to the email address entered here.
                                    </li>
                                    <li>
                                        If you are scheduling Batch Exams or Batch Practicals, make sure to cancel these bookings in advance.
                                    </li>
                                    <li>
                                        These bookings will appear in the calendar for the selected duration, just like normal individual bookings.
                                    </li>
                                </ul>
                            </p>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Create Permanent Event</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const courseSelect = document.getElementById('p_course');
        const moduleSelect = document.getElementById('p_module');
        const batchSelect  = document.getElementById('p_batch');

        courseSelect.addEventListener('change', function () {

            const courseId = this.value;

            // Reset dropdowns
            moduleSelect.innerHTML = '<option value="Any">Any</option>';
            batchSelect.innerHTML  = '<option value="">Pick a Batch</option>';

            if (!courseId) {
                return;
            }

            /* Load Modules */
            fetch(`/get-modules/${courseId}`)
                .then(response => response.json())
                .then(modules => {
                    modules.forEach(module => {
                        const option = document.createElement('option');
                        option.value = module.module_number;
                        option.text  = `${module.module_number} - ${module.name}`;
                        moduleSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error loading modules:', error);
                });

            /* Load Batches */
            fetch(`/get-batches/${courseId}`)
                .then(response => response.json())
                .then(batches => {
                    batches.forEach(batch => {
                        const option = document.createElement('option');
                        option.value = batch.id;
                        option.text  = batch.batch_number;
                        batchSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error loading batches:', error);
                });

        });

    });
</script>