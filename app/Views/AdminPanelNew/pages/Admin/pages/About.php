<div class="card form_bg">
<div class="card-body">
        <div class="offcanvas-header mb-3">
            <div class="">
                <h5 id="Add_outdoor_mediaLabel"> Add About</h5>
            </div>
        </div>
    <form autocomplete="on" id="form" class="card-body" method="POST" enctype="multipart/form-data" action="<?= @$ApiUrl ?>">
        <input type="hidden" name="website_profile_id" value="<?= @$website_profile_id ?>">
        <!-- Input Fields Start -->
        <div class="row offcanvas-body">
            <div class="col-12 mb-4">
                <label for="about_company" class="form-label">About Company</label>
                <textarea class="form-control" name="about_company" id="about_company" rows="3"><?= @$about_company ?></textarea>
            </div>
         
            <div class="col-12 mb-4">
                <label for="about_page_seo_title" class="form-label">About Tag Title</label>
                <input type="text" class="form-control" name="about_page_seo_title" id="about_page_seo_title" value="<?= @$about_page_seo_title ?>">
            </div>
            <div class="col-12 mb-4">
                <label for="about_page_seo_keyword" class="form-label">About Meta Keyword</label>
                <input type="text" class="form-control" name="about_page_seo_keyword" id="about_page_seo_keyword" value="<?= @$about_page_seo_keyword ?>">
            </div>
            <div class="col-12 mb-4">
                <label for="about_page_seo_description" class="form-label">About Meta Description</label>
                <textarea class="form-control" name="about_page_seo_description" id="about_page_seo_description" rows="3"><?= @$about_page_seo_description ?></textarea>
            </div>
            <div class="col-12 mb-4">
                <label for="about_page_content" class="form-label">About Page Content</label>
                <textarea class="form-control ckeditor-active" name="about_page_content" id="about_page_content" cols="20" rows="5" placeholder="Enter About"><?= @$about_page_content ?></textarea>
            </div>
        </div>
        <!-- Input Fields End -->
        <div>
            <button type="button" class="btn btn-primary m-4 p-2" style="width: 200px;" onclick="submitFormWithAjax('form', true, true, successCallback, errorCallback)">Save</button>
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