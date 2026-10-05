<div class="card form_bg">
<div class="card-body">
        <div class="offcanvas-header mb-3">
            <div class="">
                <h5 id="Add_outdoor_mediaLabel"> Add Contact</h5>
            </div>
        </div>
    <form autocomplete="on" id="form" method="POST" class="card-body" enctype="multipart/form-data" action="<?= @$ApiUrl ?>">
        <input type="hidden" name="website_profile_id" value="<?= @$website_profile_id ?>">
        <!-- Input Fields Start -->
        <div class="row offcanvas-body">
            <div class="col-4">
                <label for="contact_mobile" class="form-label">Contact Mobile</label>
                <input autocomplete="off" type="number" class="form-control" id="contact_mobile" name="contact_mobile" value="<?= @$contact_mobile ?>" placeholder="Enter Number">
                <span class="error-message" id="contact_mobile-error"></span>
            </div>
            <div class="col-4">
                <label for="contact_whatsapp" class="form-label">Contact Whatsapp</label>
                <input autocomplete="off" type="number" class="form-control" id="contact_whatsapp" name="contact_whatsapp" value="<?= @$contact_whatsapp ?>" placeholder="Enter Number">
                <span class="error-message" id="contact_whatsapp-error"></span>
            </div>
            <div class="col-4 mb-4">
                <label for="contact_email" class="form-label">Contact Email</label>
                <input autocomplete="off" type="email" class="form-control" id="contact_email" name="contact_email" value="<?= @$contact_email ?>" placeholder="Enter Email">
                <span class="error-message" id="contact_email-error"></span>
            </div>
        
            <div class="col-12 mb-4">
                <label for="contact_page_title" class="form-label">Contact Tag Title</label>
                <input class="form-control" name="contact_page_seo_title" id="contact_page_seo_title" rows="3" value="<?= @$contact_page_seo_title ?>">
            </div>
            <div class="col-12 mb-4">
                <label for="contact_page_seo_keyword" class="form-label">Contact Meta Keyword</label>
                <input class="form-control" name="contact_page_seo_keyword" id="contact_page_seo_keyword" rows="3" value="<?= @$contact_page_seo_keyword ?>">
            </div>
            <div class="col-12 mb-4">
                <label for="contact_page_seo_description" class="form-label">Contact Meta Description</label>
                <textarea class="form-control" name="contact_page_seo_description" id="contact_page_seo_description" rows="3"><?= @$contact_page_seo_description ?></textarea>
            </div>

            <div class="col-12 mb-4">
                <label for="contact_page_content">Contact Page</label>
                <textarea class="form-control ckeditor-active" name="contact_page_content" id="contact_page_content" cols="20" rows="5" placeholder="Enter Contact "><?= @$contact_page_content ?></textarea>
            </div>
            <div class="col-12 mb-4">
                <label for="google_embaded_iframe">Google Embaded Iframe</label>
                <textarea class="form-control" name="google_embaded_iframe" id="google_embaded_iframe" cols="20" rows="5" placeholder="Enter Contact "><?= @$google_embaded_iframe ?></textarea>
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