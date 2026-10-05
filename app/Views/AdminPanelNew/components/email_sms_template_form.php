<div class="card border-card">
    <form id="<?= $template_type ?>" action="<?= base_url(route_to('email_sms_template_update_api')) ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="template_id" value="<?= $template_id ?>">
        <!-- Card Header with Logo -->
        <div class="card-header">
            <div class="row">
                <div class="col-9">
                    <h3 class="mb-0"><?= $template_heading ?></h3>
                </div>
                <div class="col-3">
                    <button type="button" class="btn btn-outline-info" onclick="modalCreateAndShow('<?= $template_id ?>','<?= $template_heading ?> Placeholders','<?= $template_placeholder ?>')">Placeholder</button>
                </div>
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <h5 class="text-blue">Email Template</h5>
                    <div class="row">
                        <div class="form-group col-12 mb-3">
                            <label class="form-label" for="email_subject">Email Subject</label>
                            <input type="text" placeholder="Email Subject" id="email_subject" name="email_subject" class="form-control" value="<?= @$email_subject ?>">
                            <span class="error-message" id="error-email_subject"></span>
                        </div>

                        <div class="form-group col-12 mb-3">
                            <label class="form-label" for="email_cc">Email CC</label>
                            <input type="email" placeholder="Email CC" id="email_cc" name="email_cc" class="form-control" value="<?= @$email_cc ?>">
                            <span class="error-message" id="error-email_cc"></span>
                        </div>

                        <div class="form-group col-12 mb-3">
                            <label class="form-label" for="email_body">Email Body</label>
                            <textarea type="text" placeholder="Email Body" id="email_body" name="email_body" class="form-control ckeditor"><?= @$email_body ?></textarea>
                            <span class="error-message" id="error-email_body"></span>
                        </div>
                        <div class="form-check form-switch col-6 mb-3">
                            <input type="hidden" name="email_attachment" value="0">
                            <input class="form-check-input" type="checkbox" id="email_attachment" name="email_attachment" <?= ($email_attachment == 1) ? "checked" : "" ?>>
                            <label for="email_attachment">Email Attachment</label>
                        </div>
                        <div class="form-check form-switch col-6 mb-3">
                            <input type="hidden" name="email_send" value="0">
                            <input class="form-check-input" type="checkbox" id="email_send" name="email_send" <?= ($email_send == 1) ? "checked" : "" ?>>
                            <label for="email_send">Send Email</label>
                        </div>
                    </div>
                </div>

                <!-- SMS -->
                <div class="col-6 border-start border-black">
                    <h5 class="text-blue">Sms Mode</h5>
                    <div class="row">
                        <div class="form-group col-12 mb-3">
                            <label class="form-label" for="sms_template_name">Sms Template Name</label>
                            <input type="text" placeholder="Sms Template Name" id="sms_template_name" name="sms_template_name" class="form-control" value="<?= @$sms_template_name ?>">
                            <span class="error-message" id="error-sms_template_name"></span>
                        </div>

                        <div class="form-group col-12 mb-3">
                            <label class="form-label" for="sms_dlt_id">Sms DLT Template ID</label>
                            <input type="text" placeholder="Sms Message" id="sms_dlt_id" name="sms_dlt_id" class="form-control" value="<?= @$sms_dlt_id ?>">
                            <span class="error-message" id="error-sms_dlt_id"></span>
                        </div>

                        <div class="form-group col-12 mb-3">
                            <label title="Each Sms Length 160 Character including Space" class="form-label" for="sms_message">Sms Message</label>
                            <textarea placeholder="Sms Message" rows="5" id="sms_message" name="sms_message" class="form-control sms-textarea"><?= @$sms_message ?></textarea>
                            <span class="error-message" id="error-sms_message"></span>
                        </div>
                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-10 form-check form-switch">
                                <input type="hidden" name="sms_send" value="0">
                                <input class="form-check-input" type="checkbox" id="sms_send" name="sms_send" <?= ($sms_send == 1) ? "checked" : "" ?>>
                                <label for="sms_send">Send Sms</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="col-12">
                <button type="button" onclick="submitFormWithAjax('<?= $template_type ?>',true,true,successCallback,errorCallback)" class="btn btn-primary me-2">Save <?= $template_heading ?> Setting</button>
            </div>
        </div>
    </form>
</div>