<!-- New Batch Event Modal -->
<div class="modal fade" id="newEventModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newEventModalLabel">New Batch Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('eventStore') }}">
                @csrf
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-12">
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
                                <select name="description" class="form-control select2-single" id="description" data-width="100%" required>
                                    <option value="">Pick a Type</option>
                                    <option value="Batch Exam">Batch Exam</option>
                                    <option value="Batch Practical">Batch Practical</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="course">Course *</label>
                                <select name="course" class="form-control select2-single" id="course" data-width="100%" required>
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
                                <select name="module" class="form-control select2-single" id="module" data-width="100%" required>
                                    <option value="">Pick the Course First</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="batch">Batch *</label>
                                <select name="batch" class="form-control select2-single" id="batch" data-width="100%" required>
                                    <option value="">Pick the Course First</option>
                                    
                                </select>
                            </div>
                        </div>
                    </div>

                    <script>
                    document.addEventListener("DOMContentLoaded", function() {

                        document.getElementById('course').addEventListener('change', function () {
                            let courseId = this.value;

                            // Reset dropdowns
                            let batchSelect = document.getElementById('batch');
                            let moduleSelect = document.getElementById('module');

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
                        <div class="col-6">
                            <div class="form-group">
                                <label for="lab">LAB *</label>
                                <select name="lab" class="form-control select2-single" id="lab" data-width="100%" required>
                                    <!-- <option value="">Pick a Course</option> -->
                                    @foreach($labs as $lab)
                                        <option value="{{ $lab->id }}">{{ $lab->lab_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="invigilator">Invigilator *</label>
                                <select name="invigilator" class="form-control select2-single" id="invigilator" data-width="100%" required>
                                    @foreach($invigilators as $invigilator)
                                        <option value="{{ $invigilator->name }}">{{ $invigilator->name }}</option>
                                    @endforeach
                                    <option value="Other">Other</option>
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