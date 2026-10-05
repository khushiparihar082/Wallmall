<div class="card">
    <div class="card-body">
        <div class="card form_bg">
            <!-- Input Fields Start -->
            <form id="form" class="card-body" method="POST" enctype="multipart/form-data" action="<?= @$ApiUrl ?>">
                <input type="hidden" name="website_profile_id" value="<?= @$website_profile_id ?>">
                <div class="row mt-4 offcanvas-body">
                    <div class="form-group col-md-3 mb-4">
                        <label for="refer_coupon_value" class="form-label">Refer Value</label>
                        <input autocomplete="off" type="number" class="form-control" id="refer_coupon_value" name="refer_coupon_value" value="<?= @$refer_coupon_value ?>" placeholder="Enter Refer Value">
                        <span class="error-message" id="error-refer_coupon_value"></span>
                    </div>

                    <div class="form-group col-md-3 mb-4">
                        <label for="refer_coupon_min_order_value" class="form-label">Min Order Amount</label>
                        <input autocomplete="off" type="number" class="form-control" id="refer_coupon_min_order_value" name="refer_coupon_min_order_value" value="<?= @$refer_coupon_min_order_value ?>" placeholder="Enter Min Order Amount">
                        <span class="error-message" id="error-refer_coupon_min_order_value"></span>
                    </div>

                    <div class="form-group col-md-3 mb-4">
                        <label for="refer_coupon_max_order_value" class="form-label">Max Order Amount</label>
                        <input autocomplete="off" type="number" class="form-control" id="refer_coupon_max_order_value" name="refer_coupon_max_order_value" value="<?= @$refer_coupon_max_order_value ?>" placeholder="Enter Max Order Amount">
                        <span class="error-message" id="error-refer_coupon_max_order_value"></span>
                    </div>

                    <div class="form-group col-md-3 mb-4">
                        <label for="refer_coupon_valid_days" class="form-label">Valid Days</label>
                        <input autocomplete="off" type="number" class="form-control" id="refer_coupon_valid_days" name="refer_coupon_valid_days" value="<?= @$refer_coupon_valid_days ?>" placeholder="Enter Valid Days">
                        <span class="error-message" id="error-refer_coupon_valid_days"></span>
                    </div>
                    <div class="form-group col-md-3 mb-4">
                        <label for="refer_coupon_calculation_type" class="form-label">Refer Calc. Type</label>
                        <select name="refer_coupon_calculation_type" class="form-control" id="refer_coupon_calculation_type">
                            <option value="percentage" <?= (isset($refer_coupon_calculation_type) && $refer_coupon_calculation_type == 'percentage') ? 'selected' : "" ?>>Percentage</option>
                            <option value="amount" <?= (isset($refer_coupon_calculation_type) && $refer_coupon_calculation_type == 'amount') ? 'selected' : "" ?>>Amount</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3 mb-4">
                        <label for="refer_coupon_send" class="form-label">Refer Code Send When</label>
                        <select name="refer_coupon_send" class="form-control" id="refer_coupon_send">
                            <option value="after_registration" <?= (isset($refer_coupon_send) && $refer_coupon_send == 'after_registration') ? 'selected' : "" ?>>After Registration</option>
                            <option value="after_order_placed" <?= (isset($refer_coupon_send) && $refer_coupon_send == 'after_order_placed') ? 'selected' : "" ?>>After Order Placed</option>
                            <option value="after_delivered" <?= (isset($refer_coupon_send) && $refer_coupon_send == 'after_delivered') ? 'selected' : "" ?>>After Delivered</option>
                        </select>
                    </div>


                    <div class="form-group col-md-3 mb-4">
                        <label for="is_refer_coupon_active" class="form-label">Refer Coupon Is Active</label>
                        <select name="is_refer_coupon_active" class="form-control" id="is_refer_coupon_active">
                            <option value="0" <?= (isset($is_refer_coupon_active) && $is_refer_coupon_active == '0') ? 'selected' : "" ?>>Inactive</option>
                            <option value="1" <?= (isset($is_refer_coupon_active) && $is_refer_coupon_active == '1') ? 'selected' : "" ?>>Active</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3 mb-4">
                        <button type="button" class="btn btn-primary m-4 p-2" onclick="submitFormWithAjax('form', true, true, successCallback, errorCallback)">Save Setting</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="couponTable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"></table>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="RightSlideBox" aria-labelledby="RightSlideBoxLabel">
    </div>
</div>


<div class="offcanvas offcanvas-end" tabindex="-1" id="RightSlideBox" aria-labelledby="RightSlideBoxLabel">

</div>




<script>
    var parameter = {};
    parameter.coupon_type = 'ref_coupon';

    function errorCallback(response) {
        console.log(response);
    }

    function successCallback(response) {
        console.log(response);
    }

    function successDataTableCallbackFunction(response) {
        var columns = [{
                title: "Coupon Name",
                data: "coupon_name"
            },
            {
                title: "Coupon Code",
                data: "coupon_code"
            },
            {
                title: "Coupon From",
                data: "coupon_from"
            },

            {
                title: "Coupon To",
                data: "coupon_to"
            },
            {
                title: '<span data-toggle="tooltip" title="Calculation Type">CT</span>',
                data: "calculation_type",
                'render': function(data, type, row) {
                    return (data == 'percentage') ? "Per" : "Amt"
                }
            },
            {
                title: "Value",
                data: "coupon_value",
            },
            {
                title: '<span data-toggle="tooltip" title="Per Customer Coupon Use">PCCU</span>',
                data: "repeat_no"
            },
            {
                title: '<span data-toggle="tooltip" title="Total Customer Coupon Use">TCCU</span>',
                data: "max_use_coupon_count"
            },
            {
                title: '<span data-toggle="tooltip" title="Minimum Order Value">Min_OA</span>',
                data: "min_order_value"
            },
            {
                title: '<span data-toggle="tooltip" title="Maximum Order Value">Max_OA</span>',
                data: "max_order_value"
            },
            {
                title: 'Description',
                data: "coupon_description"
            },
        ];


        if (response.status == 200) {
            return {
                "status": response.status,
                "columns": columns,
                "data": JSON.parse(response.data)
            };
        } else {
            return {
                "status": response.status,
                "columns": columns,
                "data": {}
            };
        }
    }

    function fetchTableData() {
        DataTableInitialized(
            'couponTable', // table_id
            "<?= base_url(route_to('coupon_list_api')) ?>", // url
            'POST', // method
            parameter, // parameter
            successDataTableCallbackFunction // dataTableSuccessCallBack
        );
    }
    $(document).ready(function() {
        fetchTableData({});
    });
</script>