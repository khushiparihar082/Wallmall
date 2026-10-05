<div class="offcanvas-header">
    <h5 class="offcanvas-title" id="RightSlideBoxLabel"><?= (isset($user_id) && !empty($user_id)) ? "Update" : "Add" ?> Role User</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body">
    <div class="error-message-box d-none">
        <p id="error-message"></p>
    </div>
    <div class="success-message-box d-none">
        <p id="success-message"></p>
    </div>
    <form id="form" method="POST" enctype="multipart/form-data" action="<?= @$ApiUrl ?>">
        <input type="hidden" name="user_id" id="user_id" value="<?= @$user_id ?>">
        <div class="mb-3">
            <label class="form-label">Employee Name</label>
            <input type="text" id="fullname" name="fullname" class="form-control" placeholder="Employee Name" value="<?= @$fullname ?>">
            <span class="error-message" id="error-fullname"></span>
        </div>

        <div class="mb-3">
            <label class="form-label">E-Mail</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Enter a valid e-mail" value="<?= @$email ?>" />
            <span class="error-message" id="error-email"></span>
        </div>

        <div class="mb-3">
            <label class="form-label">Mobile Number</label>
            <input name="mobile" id="mobile" type="number" class="form-control" placeholder="Enter Mobile numbers" value="<?= @$mobile ?>" />
            <span class="error-message" id="error-mobile"></span>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" />
            <span class="error-message" id="error-password"></span>
        </div>

        <div class="mb-3">
            <label class="form-label">User Role</label>
            <select name="user_type" id="user_type" placeholder="Select Role">
                <option value="" <?= (!isset($user_type) || empty($user_type)) ? "selected" : "" ?>>Select User Role</option>
                <option value="admin" <?= (isset($user_type) && $user_type == "admin") ? "selected" : "" ?>>Admin</option>
                <option value="inventory" <?= (isset($user_type) && $user_type == "inventory") ? "selected" : "" ?>>Inventory</option>
                <option value="finance" <?= (isset($user_type) && $user_type == "finance") ? "selected" : "" ?>>Finance</option>
                <option value="order" <?= (isset($user_type) && $user_type == "order") ? "selected" : "" ?>>Order</option>
                <option value="delivery" <?= (isset($user_type) && $user_type == "delivery") ? "selected" : "" ?>>Delivery</option>
            </select>
            <span class="error-message" id="error-user_type"></span>
        </div>


        <div class="mb-3">
            <p class="mb-0"><label class="form-label">Status</label></p>
            <div class="form-check form-check-inline">
                <span class="text-danger">*</span>
                <input class="form-check-input" type="radio" name="is_active" id="active" value="1" <?= (isset($is_active) && $is_active == 1) ? "checked" : "" ?> />
                <label class="form-check-label" for="active">Active</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is_active" id="inactive" value="0" <?= (isset($is_active) && $is_active == 0) ? "checked" : "" ?> />
                <label class="form-check-label" for="inactive">InActive</label>
            </div>
            <span class="error-message" id="error-fullname"></span>
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