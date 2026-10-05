<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>
            Cart List
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="table-responsive">
                <table id="cartTable" class="table table-striped table-bordered dt-responsive nowrap table-nowrap align-middle" style="border-collapse: collapse; border-spacing: 0; width: 100%;"></table>
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
                title: "Product Name",
                data: "product_name",

            },
            {
                title: "Variant ID",
                data: "variant_name",

            },
            {
                title: "Quantity",
                data: "cart_quantity",

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
    function fetchTableData(parameter = {}) {
        DataTableInitialized(
            'cartTable', // table_id
            "<?= base_url(route_to('cart_list_api')) ?>", // url
            'POST', // method
            parameter, // parameter
            successDataTableCallbackFunction // dataTableSuccessCallBack
        );
    }


    $(document).ready(function() {
        fetchTableData({
            _autojoin: "Y",
            _select: "*"
        });

    });
</script>