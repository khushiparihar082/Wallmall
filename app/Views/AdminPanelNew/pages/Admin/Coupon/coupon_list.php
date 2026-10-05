<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-end table_btn_div mb-2">
            <a href="<?= base_url(route_to('coupon_create_update')) ?>">
                <button class="add_form_btn"><i class="bx bx-plus me-2"></i>Add Coupon</button>
            </a>
        </div>
        <div class="table-responsive">
            <div class="table-responsive">
                <table id="couponTable" class="table table-striped table-bordered dt-responsive nowrap table-nowrap align-middle" style="border-collapse: collapse; border-spacing: 0; width: 100%;"></table>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="RightSlideBox" aria-labelledby="RightSlideBoxLabel">

</div>




<script>
    var DeleteApiUrl = "<?= base_url(route_to('coupon_delete_api')) ?>"
    var parameter = {};
    parameter.coupon_type = 'multi_customer_coupon';

    function errorCallback(response) {
        console.log(response);
    }

    function deleteCoupon(coupon_id) {
        deleteRow({
                "coupon_id": coupon_id
            }).then((response) => {
                fetchTableData({});
            })
            .catch((error) => {
                console.error("Deletion failed or cancelled:", error);
            });
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
                title: "Is Active",
                data: "is_active",
                render: function(data, type, row) {
                    var checked = data == 1 ? 'checked' : '';
                    return `
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="isActiveSwitch_${row.coupon_id}" ${checked} onchange="change_is_active(event, ${row.coupon_id})">
            </div>`;
                }
            },
            {
                "title": "Actions",
                "data": null,
                "render": function(data, type, row) {
                    return `
                            <a href="<?= base_url(route_to('coupon_create_update')) ?>/${row.coupon_id}" class="btn btn-sm btn-info">
                                <i class="bx bx-edit-alt"></i>
                            </a>
                            <button class="btn btn-sm btn-danger" onclick="deleteCoupon(${row.coupon_id })">
                                <i class="bx bx-trash-alt"></i>
                            </button>
                        `;
                }
            }
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

    function change_is_active(event, coupon_id) {

        var isChecked = event.target.checked; // Determine if the checkbox is checked or unchecked

        // Toggle the checked state based on the isChecked variable
        $('#isActiveSwitch_' + coupon_id).prop('checked', isChecked);

        var is_active = isChecked ? 1 : 0; // Set is_active to 1 if checked, 0 if unchecked

        $.ajax({
            type: "POST",
            url: "<?= base_url(route_to('coupon_update_api')) ?>",
            data: {
                coupon_id: coupon_id,
                is_active: is_active,
            },
            success: function(response) {
                if (response.status == 200) {
                    toastr.success("Changed Successfully");
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX request error:", error);
            }
        });
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