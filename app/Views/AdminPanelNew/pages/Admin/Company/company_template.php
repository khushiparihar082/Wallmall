<div class="card form_bg">
    <div class="card-body">
        <form id="form" method="POST" enctype="multipart/form-data" action="" class="row offcanvas-body">
            <div class="mb-3">
                <label class="form-label">Select For </label>
                <select name="user_type" id="user_type" placeholder="Select Role" tabindex="-1" style="display: none;" class="selectized">
                    <option value="admin" selected="selected"> Forgot Password</option>
                    <option value="admin" selected="selected"> Forgot Password</option>
                </select>
            </div>
            <div class="mb-3">
                <p class="mb-0"><label class="form-label">Status</label></p>
                <div class="form-check form-check-inline">
                <span class="text-danger">*</span>
                    <input class="form-check-input" type="checkbox" name="is_active" id="active" value="1">
                    <label class="form-check-label" for="active">Email Send</label>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Email Subject</label>
                <input type="text" id="" name="" class="form-control" placeholder="Email Subject" value="">
                <span class="error-message" id="error"></span>
            </div>

            <div class="mb-3 col-md-6">
                <label class="form-label">E-Mail CC</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter a valid e-mail" value="">
                <span class="error-message" id="error"></span>
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">E-Mail Attachment</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter a valid e-mail" value="">
                <span class="error-message" id="error"></span>
            </div>

            <div class="mb-3">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="is_active" id="active" value="1">
                    <label class="form-check-label" for="active">SMS Send</label>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">SMS Template Name</label>
                <input type="text" id="" name="" class="form-control" placeholder="Email Subject" value="">
                <span class="error-message" id="error"></span>
            </div>
            <div class="mb-3">
                <label class="form-label">SMS Message</label>
                <input type="text" id="" name="" class="form-control" placeholder="Email Subject" value="">
                <span class="error-message" id="error"></span>
            </div>
            <div class="mb-3">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="is_active" id="active" value="1">
                    <label class="form-check-label" for="active">WhatsApp Send</label>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">WhatsApp Message</label>
                <input type="text" id="" name="" class="form-control" placeholder="Email Subject" value="">
                <span class="error-message" id="error"></span>
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">WhatsApp Attachment</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter a valid e-mail" value="">
                <span class="error-message" id="error"></span>
            </div>

            <div>
                <div>
                    <button type="button" onclick="submitFormWithAjax('form',true,false,successCallback,errorCallback)" class="btn btn-primary waves-effect waves-light me-1">
                        Submit
                    </button>
                    <button type="reset" class="btn btn-secondary waves-effect">
                        Cancel
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>