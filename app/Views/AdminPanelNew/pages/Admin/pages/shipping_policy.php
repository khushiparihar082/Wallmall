<div class="card form_bg">
    <div class="card-body">
        <div class="offcanvas-header mb-4">
            <div class="">
                <h5 id="Add_outdoor_mediaLabel"> Add Shipping Policy</h5>
            </div>
        </div>
        <form autocomplete="on" id="form" method="POST" class="row offcanvas-body" enctype="multipart/form-data" action="<?= @$ApiUrl ?>">
            <input type="hidden" name="website_profile_id" value="<?= @$website_profile_id ?>">
            <!-- Input Fields Start -->
            <div class="col-12 mb-3">
                <label for="shipping_policy_page_seo_title" class="form-label">Shipping and Policy Tag Title</label>
                <input class="form-control" name="shipping_policy_page_seo_title" id="shipping_policy_page_seo_title" rows="3" value="<?= @$shipping_policy_page_seo_title ?>">
            </div>
            <div class="col-12 mb-3">
                <label for="shipping_policy_page_seo_keyword" class="form-label">Shipping and Policy Meta Keyword</label>
                <input class="form-control" name="shipping_policy_page_seo_keyword" id="shipping_policy_page_seo_keyword" rows="3" value="<?= @$shipping_policy_page_seo_keyword ?>">
            </div>

            <div class="col-12 mb-3">
                <label for="shipping_policy_page_seo_description" class="form-label">Shipping and Policy Meta Description</label>
                <textarea class="form-control" name="shipping_policy_page_seo_description" id="shipping_policy_page_seo_description" rows="3"><?= @$shipping_policy_page_seo_description ?></textarea>
            </div>

            <div class="col-12 mb-3">
                <label for="shipping_policy_page_content">Shipping and Policy</label>
                <textarea class="form-control ckeditor-active" name="shipping_policy_page_content" id="shipping_policy_page_content" cols="20" rows="5" placeholder="Enter Shipping and Policy"><?= @$shipping_policy_page_content ?></textarea>
                <!-- Input Fields End -->
            </div>
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