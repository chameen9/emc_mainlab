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