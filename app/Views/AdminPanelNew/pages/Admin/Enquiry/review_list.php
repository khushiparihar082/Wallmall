<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>
            Review List
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="table-responsive">
                <table id="reviewTable" class="table table-striped table-bordered dt-responsive nowrap table-nowrap align-middle" style="border-collapse: collapse; border-spacing: 0; width: 100%;"></table>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="RightSlideBox" aria-labelledby="RightSlideBoxLabel">

</div>

<script>
    function successDataTableCallbackFunction(response) {
        var columns = [{
                title: "Customer ID",
                data: "customer_id"
            },
            {
                title: "Customer Name",
                data: "fullname"
            },
            {
                title: "Product Name",
                data: "product_name",

            },
            {
                title: "Variant ID",
                data: "variant_name",

            },
            {
                title: "Rating",
                data: "customer_rating",

            },
        
            // {
            //     title: "Customer Status",
            //     data: "customer_review_status",
            //     render: function(data, type, row) {
            //         var checked = data == 1 ? 'checked' : '';
            //         return `
            // <div class="form-check form-switch">
            //     <input class="form-check-input" type="checkbox" id="isActiveSwitch_${row.customer_review_id}" ${checked} onchange="change_customer_review_status(event, ${row.customer_review_id})">
            // </div>`;
            //     }
            // },


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



    function fetchTableData(parameter = {}) {
        DataTableInitialized(
            'reviewTable', // table_id
            "<?= base_url(route_to('review_list_api')) ?>", // url
            'POST', // method
            parameter, // parameter
            successDataTableCallbackFunction // dataTableSuccessCallBack
        );
    }


    function change_customer_review_status(event, customer_review_id) {

        var isChecked = event.target.checked; // Determine if the checkbox is checked or unchecked

        // Toggle the checked state based on the isChecked variable
        $('#isActiveSwitch_' + customer_review_id).prop('checked', isChecked);

        var customer_review_status = isChecked ? 1 : 0; // Set customer_review_status to 1 if checked, 0 if unchecked

        $.ajax({
            type: "POST",
            url: "<?= base_url(route_to('review_update_api')) ?>",
            data: {
                customer_review_id: customer_review_id,
                customer_review_status: customer_review_status,

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
    $(document).ready(function() {
        fetchTableData({
            _autojoin: "Y",
            _select: "*"
        });

    });
</script>