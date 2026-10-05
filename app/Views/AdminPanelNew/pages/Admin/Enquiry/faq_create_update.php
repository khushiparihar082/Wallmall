<div class="card form_bg">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 id="Add_outdoor_mediaLabel"> <?= (isset($faq_id) && !empty($faq_id)) ? "Update" : "Add" ?>
            FAQ</h5>
        <a href="<?= base_url(route_to('faq_list')) ?>" class="btn btn-secondary">Back</a>
    </div>
    <div class="card-body">
        <div class="error-message-box d-none">
            <p id="error-message"></p>
        </div>
        <div class="success-message-box d-none">
            <p id="success-message"></p>
        </div>

        <div class="row offcanvas-body">
            <form id="form" class="card-body" method="POST" enctype="multipart/form-data" action="<?= @$ApiUrl ?>">
                <input type="hidden" name="faq_id" value="<?= @$faq_id ?>">
                <!-- Initial FAQ fields -->
                <div class="faq-fields">
                    <div class="mb-3">
                        <label for="faq_question" class="form-label">FAQ Question</label>
                        <input type="text" class="form-control" id="faq_question" name="faq_question" placeholder="Enter Question....." value="<?= @$faq_question ?>">
                    </div>
                    <div class="mb-3">
                        <label for="faq_answer" class="form-label">FAQ Answer</label>
                        <textarea class="form-control" id="faq_answer" name="faq_answer" rows="3" placeholder="Enter Answer....."><?= @$faq_answer ?></textarea>
                    </div>
                </div>

                <button type="button" onclick="submitFormWithAjax('form',true,true,successCallback,errorCallback)" class="btn btn-primary waves-effect waves-light me-1">
                    Submit
                </button>
            </form>

        </div>
    </div>

    <script>
        function successCallback(response) {
            if (response.status == 201 || response.status == 200) {
                var data = JSON.parse(response.data);
                console.log(response.data);
                window.location.href = '<?= base_url(route_to('faq_list')) ?>';
            }
        }

        function errorCallback(response) {
            console.log(response);
        }
    </script>