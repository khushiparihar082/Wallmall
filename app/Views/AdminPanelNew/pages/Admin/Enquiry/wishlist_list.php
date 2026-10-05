<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>
            Wishlist List
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="table-responsive">
                <table id="wishlistTable" class="table table-striped table-bordered dt-responsive nowrap table-nowrap align-middle" style="border-collapse: collapse; border-spacing: 0; width: 100%;"></table>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="RightSlideBox" aria-labelledby="RightSlideBoxLabel">

</div>

<script>
  

    function successDataTableCallbackFunction(response) {
        var columns = [{
                title: "ID",
                data: "customer_wishlist_id"
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
                title: "Date",
                data: "created_at",

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
            'wishlistTable', // table_id
            "<?= base_url(route_to('wishlist_list_api')) ?>", // url
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