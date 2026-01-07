<!-- New Individual Event Modal -->
<div class="modal fade" id="newIndividualEventModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Student Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('individualEventStore') }}">
                @csrf
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="student_id">Student ID *</label>
                                <input type="text" class="form-control" id="student_id" name="student_id"
                                    placeholder="Enter Student ID" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="date">Date *</label>
                                <input type="date" class="form-control" id="date" name="date"
                                    placeholder="Pick a Date" autocomplete="off" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="description">Type *</label>
                                <select name="description" class="form-control select2-single" id="idescription" data-width="100%" required>
                                    <option value="">Pick a Type</option>
                                    <option value="Exam">Exam</option>
                                    <option value="Practical">Practical</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="course">Course *</label>
                                <select name="course" class="form-control select2-single" id="icourse" data-width="100%" required>
                                    <option value="">Pick a Course</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->course_code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="module">Module *</label>
                                <select name="module" class="form-control select2-single" id="imodule" data-width="100%" required>
                                    <option value="">Pick the Course First</option>
                                    
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="batch">Batch *</label>
                                <select name="batch" class="form-control select2-single" id="ibatch" data-width="100%" required>
                                    <option value="">Pick the Course First</option>
                                    
                                </select>
                            </div>
                        </div>
                    </div>

                    <script>
                    document.addEventListener("DOMContentLoaded", function() {

                        document.getElementById('icourse').addEventListener('change', function () {
                            let courseId = this.value;

                            // Reset dropdowns
                            let batchSelect = document.getElementById('ibatch');
                            let moduleSelect = document.getElementById('imodule');

                            batchSelect.innerHTML = '<option value="">Pick your Batch</option>';
                            moduleSelect.innerHTML = '<option value="">Pick a Module</option>';

                            if (courseId === "") {
                                return;
                            }

                            // ✅ Load Batches
                            fetch(`/get-batches/${courseId}`)
                                .then(response => response.json())
                                .then(data => {
                                    data.forEach(function(batch) {
                                        let option = document.createElement('option');
                                        option.value = batch.id;
                                        option.text  = batch.batch_number;
                                        batchSelect.appendChild(option);
                                    });
                                })
                                .catch(error => console.log("Error loading batches:", error));

                            // ✅ Load Modules
                            fetch(`/get-modules/${courseId}`)
                                .then(response => response.json())
                                .then(data => {
                                    data.forEach(function(module) {
                                        let option = document.createElement('option');
                                        option.value = module.module_number;
                                        option.text  = module.module_number + " - " + module.name;
                                        moduleSelect.appendChild(option);
                                    });
                                })
                                .catch(error => console.log("Error loading modules:", error));
                        });

                    });
                    </script>

                    <div class="row">
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

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="lab">Notes (Optional)</label>
                                <input type="text" name="notes" class="form-control" id="notes" placeholder="Enter any notes here">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group" id="computerSection" style="display:none;">
                                <label for="icomputer">Computer *</label>
                                <select name="computer_id" id="icomputer" class="form-control select2-single">
                                    <option value="">Pick a Computer</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div id="softwareDetails" style="display:none;" class="mt-2">
                                <h6>Software Availability:</h6>
                                <div id="softwareBadges"></div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function () {

                            const typeSelect        = document.getElementById("idescription");
                            const computerSection   = document.getElementById("computerSection");
                            const computerSelect    = document.getElementById("icomputer");
                            const softwareDetails   = document.getElementById("softwareDetails");
                            const softwareList      = document.getElementById("softwareList");

                            // Hide initially
                            computerSection.style.display = "none";
                            softwareDetails.style.display = "none";

                            // ✅ When type is changed
                            typeSelect.addEventListener("change", function () {
                                if (this.value === "Practical") {
                                    computerSection.style.display = "block";
                                    loadActiveComputers();
                                } else {
                                    computerSection.style.display = "none";
                                    softwareDetails.style.display = "none";
                                }
                            });

                            // ✅ Fetch available computers (active only)
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
                                            let option = document.createElement('option');
                                            option.value = computer.id;
                                            option.text = computer.computer_label;
                                            computerSelect.appendChild(option);
                                        });
                                    })
                                    .catch(error => {
                                        console.error("Error loading computers:", error);
                                        alert("Unable to load computers. Please check server logs.");
                                    });
                            }

                            // ✅ When student selects a computer → fetch software availability
                            computerSelect.addEventListener('change', function () {

                                let computerId = this.value;

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

                                    softwareBadges.innerHTML = ""; // Clear previous results

                                    Object.entries(data.software).forEach(([software, available]) => {

                                        let value = (available ?? "").toString().trim().toLowerCase();

                                        const isAvailable = ["available", "yes", "true", "1", "ok"].includes(value);

                                        // Create a badge div
                                        let badge = document.createElement('span');
                                        badge.classList.add('badge', isAvailable ? 'badge-success' : 'badge-danger');
                                        badge.style.margin = "3px";
                                        badge.textContent = software;

                                        softwareBadges.appendChild(badge);
                                    });

                                    softwareDetails.style.display = "block";
                                })
                                    .catch(error => {
                                        console.error("Error loading computer details:", error);
                                        alert("Cannot load computer details. Check your route or controller.");
                                    });
                            });

                        });
                    </script>


                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Event</button>
                </div>
            </form>
        </div>
    </div>
</div>