<div class="card border-card">
    <form id="<?= $form_id ?>" action="<?= base_url(route_to('third_party_integration_update_api')) ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="third_party_integration_id" value="<?= $integration['data']['third_party_integration_id'] ?>">
        <!-- Card Header with Logo -->
        <div class="card-header d-flex align-items-center">
            <img src="<?= base_url($integration['data']['third_party_integration_image']) ?>" alt="Logo" class="logo-image">
            <h5 class="mb-0"><?= $integration['data']['third_party_integration_heading'] ?></h5>
        </div>

        <!-- Card Body -->
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <h5 class="text-blue">Testing Mode</h5>
                    <div class="row">
                        <?php foreach ($integration['fields'] as $field): ?>
                            <div class="col-12">
                                <?= createDynamicFieldHtml($field, 'third_party_integration_testing_data[', ']', $integration['data']['third_party_integration_testing_data']) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-6 border-start border-black">
                    <h5 class="text-blue">Production Mode</h5>
                    <div class="row">
                        <?php foreach ($integration['fields'] as $field): ?>
                            <div class="col-12">
                                <?= createDynamicFieldHtml($field, 'third_party_integration_production_data[', ']', $integration['data']['third_party_integration_production_data']) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-4">
                    <div class="form-check form-switch">
                        <input type="hidden" name="third_party_integration_is_production" value="0">
                        <input class="form-check-input" type="checkbox" id="third_party_integration_is_production" name="third_party_integration_is_production" <?= ($integration['data']['third_party_integration_is_production'] == 1) ? "checked" : "" ?>>
                        <label for="third_party_integration_is_production">Is Production</label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-check form-switch">
                        <input type="hidden" name="third_party_integration_is_active" value="0">
                        <input class="form-check-input" type="checkbox" id="third_party_integration_is_active" name="third_party_integration_is_active" <?= ($integration['data']['third_party_integration_is_active'] == 1) ? "checked" : "" ?>>
                        <label for="third_party_integration_is_active">Is Active</label>
                    </div>
                </div>
                <div class="col-4">
                    <button type="button" onclick="submitFormWithAjax('<?= $form_id ?>',true,true,successCallback,errorCallback)" class="btn btn-primary me-2">Save <?= $integration['data']['third_party_integration_heading'] ?> Setting</button>
                </div>
            </div>
        </div>
    </form>
</div>