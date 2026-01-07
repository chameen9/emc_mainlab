<!-- Event Guide Modal -->
<div class="modal fade" id="eventGuide" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Event Guide</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    <strong>Colour Guide:</strong>
                    <div class="row">
                        <div class="col-6">
                            <p>Individual Events:</p>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-2">
                                <span class="mr-2" style="background-color: #d45284ff; width: 12px; height: 12px; border-radius: 50%; display: inline-block;" ></span>
                                <span class="text-small">Exam</span>
                            </div>

                            <div class="d-flex align-items-center mb-2">
                                <span class="mr-2" style="background-color: #55ade3ff; width: 12px; height: 12px; border-radius: 50%; display: inline-block;" ></span>
                                <span class="text-small">Practical</span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6"><p>Batch Events</p></div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-2">
                                <span class="mr-2" style="background-color: #961446ff; width: 12px; height: 12px; border-radius: 50%; display: inline-block;" ></span>
                                <span class="text-small">Batch Exam</span>
                            </div>

                            <div class="d-flex align-items-center mb-2">
                                <span class="mr-2" style="background-color: #1b6898ff; width: 12px; height: 12px; border-radius: 50%; display: inline-block;" ></span>
                                <span class="text-small">Batch Practical</span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6"><p>Event Status</p></div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-2">
                                <span class="mr-2" style="background-color: #28A745; width: 12px; height: 12px; border-radius: 50%; display: inline-block;" ></span>
                                <span class="text-small">Completed</span>
                            </div>

                            <div class="d-flex align-items-center mb-2">
                                <span class="mr-2" style="background-color: #E0A800; width: 12px; height: 12px; border-radius: 50%; display: inline-block;" ></span>
                                <span class="text-small">Cancelled</span>
                            </div>

                            <div class="d-flex align-items-center mb-2">
                                <span class="mr-2" style="background-color: #C82333; width: 12px; height: 12px; border-radius: 50%; display: inline-block;" ></span>
                                <span class="text-small">Deleted</span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6"><p>Other Events</p></div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-2">
                                <span class="mr-2" style="background-color: #FBB05C; width: 12px; height: 12px; border-radius: 50%; display: inline-block;" ></span>
                                <span class="text-small">Holidays</span>
                            </div>
                        </div>
                    </div>
                </p>
                <p style="text-align: justify;">
                    <strong>Creating Events:</strong><br>
                    Read docs for more details. Go to <b><a href="{{route('userGuide')}}">Docs.</a></b>
                </p>
                <p style="text-align: justify;">
                    <strong>Marking Events:</strong><br>
                    Make sure to mark events as "Completed" once they are done. If an event is cancelled or deleted, update its status accordingly to keep the records accurate.
                </p>
                <p style="text-align: justify;">
                    <strong>Computer Selection for Practical Events:</strong><br>
                    When scheduling a practical event for an individual student, selecting a computer is mandatory. This ensures that the student has access to the required resources during their practical session. <br>
                    After selecting a computer for a practical event, the system will display the software installed on that computer. This helps in verifying if the necessary software is available for the student's practical work.
                </p>
                <p style="text-align: justify;">
                    <strong>Reservation Availability:</strong><br>
                    Systems works as FIFO (First In First Out) basis. If a slot is already booked for a particular date and time, new reservations cannot be made for that same slot.
                    Also no one can reserve a any lab, any slot on a holiday.
                </p>
            </div>
        </div>
    </div>
</div>