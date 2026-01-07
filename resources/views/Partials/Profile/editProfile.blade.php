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