<!-- Event Display Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Event Details </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-4"><strong>Title:</strong></div>
                    <div class="col-8" id="modalTitle"></div>
                </div>

                <div class="row mb-2">
                    <div class="col-4"><strong>Start Time:</strong></div>
                    <div class="col-8" id="modalStart"></div>
                </div>

                <div class="row mb-2">
                    <div class="col-4"><strong>End Time:</strong></div>
                    <div class="col-8" id="modalEnd"></div>
                </div>

                <hr>

                <div class="row mb-2">
                    <div class="col-4"><strong>Lab:</strong></div>
                    <div class="col-8" id="modalLab"></div>
                </div>

                <div class="row mb-2">
                    <div class="col-4"><strong>Batch:</strong></div>
                    <div class="col-8" id="modalBatch"></div>
                </div>

                <div class="row mb-2">
                    <div class="col-4"><strong>Invigilator:</strong></div>
                    <div class="col-8" id="modalLecturer"></div>
                </div>

                <div class="row mb-2">
                    <div class="col-4"><strong>Module:</strong></div>
                    <div class="col-8" id="modalModule"></div>
                </div>

                <hr>

                <div class="row mb-2">
                    <div class="col-4"><strong>Description:</strong></div>
                    <div class="col-8" id="modalDescription"></div>
                </div>

                <div class="row mb-2">
                    <div class="col-4"><strong>Students Count:</strong></div>
                    <div class="col-8" id="modalStudents"></div>
                </div>

                <div class="row mb-2">
                    <div class="col-4"><strong>Created By:</strong></div>
                    <div class="col-8" id="createdBy"></div>
                </div>

                <div class="row mb-2">
                    <div class="col-4"><strong>Notes:</strong></div>
                    <div class="col-8" id="modalNotes"></div>
                </div>

                <div class="row mb-2">
                    <div class="col-4"><strong>Computer:</strong></div>
                    <div class="col-8" id="modalComputerId"></div>
                </div>

                <div class="row mb-2">
                    <div class="col-4"><strong>Status:</strong></div>
                    <div class="col-8" id="modalStatus"></div>
                </div>
                
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary"
                    data-dismiss="modal">Close</button> -->
                    <form action="{{route('bookingComplete')}}" method="post">
                        @csrf
                        <input type="hidden" name="booking_id" id="modalBookingID">
                        <button type="submit" class="btn btn-success">Complete</button>
                    </form>

                    <form action="{{route('bookingCancel')}}" method="post">
                        @csrf
                        <input type="hidden" name="booking_id" id="modalBookingCancelID">
                        <button type="submit" class="btn btn-warning">Cancel</button>
                    </form>

                    <form action="{{route('bookingDelete')}}" method="post">
                        @csrf
                        <input type="hidden" name="booking_id" id="modalBookingDeleteID">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
            </div>
        </div>
    </div>
</div>