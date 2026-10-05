<div class="card form_bg">
<div class="card-body">
        <div class="offcanvas-header mb-3">
            <div class="">
                <h5 id="Add_outdoor_mediaLabel"> Add Career</h5>
            </div>
        </div>
    <form autocomplete="on" id="form" class="card-body" method="POST" enctype="multipart/form-data" action="<?= @$ApiUrl ?>">
        <input type="hidden" name="website_profile_id" value="<?= @$website_profile_id ?>">
        <!-- Input Fields Start -->
        <div class="row offcanvas-body">
            <div class="col-4">
                <label for="career_mobile" class="form-label">Career Mobile</label>
                <input autocomplete="off" type="number" class="form-control" id="career_mobile" name="career_mobile" value="<?= @$career_mobile ?>" placeholder="Enter Number">
                <span class="error-message" id="career_mobile-error"></span>
            </div>
            <div class="col-4">
                <label for="career_whatsapp" class="form-label">Career Whatsapp</label>
                <input autocomplete="off" type="number" class="form-control" id="career_whatsapp" name="career_whatsapp" value="<?= @$career_whatsapp ?>" placeholder="Enter Number">
                <span class="error-message" id="career_whatsapp-error"></span>
            </div>
            <div class="col-4 mb-4">
                <label for="career_email" class="form-label">Career Email</label>
                <input autocomplete="off" type="email" class="form-control" id="career_email" name="career_email" value=" <?= @$career_email ?>" placeholder="Enter Email">
                <span class="error-message" id="career_email-error"></span>
            </div>

            <div class="col-12 mb-4">
                <label for="career_page_seo_title" class="form-label">Career Tag Title</label>
                <input class="form-control" name="career_page_seo_title" id="career_page_seo_title" rows="3" value="<?= @$career_page_seo_title ?>">
            </div>
            <div class="col-12 mb-4">
                <label for="career_page_seo_keyword" class="form-label">Career Meta Keyword</label>
                <input class="form-control" name="career_page_seo_keyword" id="career_page_seo_keyword" rows="3" value="<?= @$career_page_seo_keyword ?>">
            </div>
            <div class="col-12 mb-4">
                <label for="career_page_seo_description" class="form-label">Career Meta Description</label>
                <textarea class="form-control" name="career_page_seo_description" id="career_page_seo_description" rows="3"><?= @$career_page_seo_description ?></textarea>
            </div>

            <div class="col-12 mb-4">
                <label for="career_page_content">Career Page</label>
                <textarea class="form-control ckeditor-active" name="career_page_content" id="career_page_content" cols="20" rows="5" placeholder="Enter Career "><?= @$career_page_content ?></textarea>
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