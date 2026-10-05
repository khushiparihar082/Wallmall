<div class="card form_bg">
<div class="card-body">
        <div class="offcanvas-header mb-3">
            <div class="">
                <h5 id="Add_outdoor_mediaLabel"> Add Support</h5>
            </div>
        </div>
    <form autocomplete="on" id="form" class="card-body" method="POST" enctype="multipart/form-data" action="<?= @$ApiUrl ?>">
        <input type="hidden" name="website_profile_id" value="<?= @$website_profile_id ?>">
        <!-- Input Fields Start -->
        <div class="row offcanvas-body">
            <div class="col-4">
                <label for="support_mobile" class="form-label">Support Mobile</label>
                <input autocomplete="off" type="number" class="form-control" id="support_mobile" name="support_mobile" value="<?= @$support_mobile ?>" placeholder="Enter Number">
                <span class="error-message" id="support_mobile-error"></span>
            </div>
            <div class="col-4">
                <label for="support_whatsapp" class="form-label">Support Whatsapp</label>
                <input autocomplete="off" type="number" class="form-control" id="support_whatsapp" name="support_whatsapp" value="<?= @$support_whatsapp ?>" placeholder="Enter Number">
                <span class="error-message" id="support_whatsapp-error"></span>
            </div>
            <div class="col-4 mb-4">
                <label for="support_email" class="form-label">Support Email</label>
                <input autocomplete="off" type="email" class="form-control" id="support_email" name="support_email" value="<?= @$support_email ?>" placeholder="Enter Email">
                <span class="error-message" id="support_email-error"></span>
            </div>

            <div class="col-12 mb-4">
                <label for="support_page_seo_title" class="form-label">Support Tag Title</label>
                <input class="form-control" name="support_page_seo_title" id="support_page_seo_title" rows="3"value="<?= @$support_page_seo_title ?>">
            </div>
            <div class="col-12 mb-4">
                <label for="support_page_seo_keyword" class="form-label">Support Meta Keyword</label>
                <input class="form-control" name="support_page_seo_keyword" id="support_page_seo_keyword" rows="3"value="<?= @$support_page_seo_keyword ?>">
            </div>

            <div class="col-12 mb-4">
                <label for="support_page_seo_description" class="form-label">Support Meta Description</label>
                <textarea class="form-control" name="support_page_seo_description" id="support_page_seo_description" rows="3"><?= @$support_page_seo_description ?></textarea>
            </div>


            <div class="col-12 mb-4">
                <label for="support_page_content">Support Page</label>
                <textarea class="form-control ckeditor-active" name="support_page_content" id="support_page_content" cols="20" rows="5" placeholder="Enter support_page_content "><?= @$support_page_content ?></textarea>
            </div>
        </div>
        <!-- Input Fields End -->
        <div>
            <button type="button" class="btn btn-primary m-4 p-2" style="width: 200px;" onclick="submitFormWithAjax('form',true,true,successCallback,errorCallback)">Save</button>
        </div>
    </form>
</div>
</div>
<script>
    function successCallback(response) {
        if (response.status == 201 || response.status == 200) {
            var data = JSON.parse(response.data);
            console.log(response.data);
            setTimeout(() => {
                window.location.href = '<?= base_url(route_to('default_dashboard')) ?>';
            }, 2000);
        }
    }

    function errorCallback(response) {
        console.log(response);
    }
</script>