<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="product_variant" class="table table-striped table-bordered dt-responsive nowrap table-nowrap align-middle table-sm"></table>
        </div>
    </div>
</div>
<div class="offcanvas offcanvas-end offcanvas-product" tabindex="-1" id="review" aria-labelledby="viewproductLable"></div>
</div>

<div id="showsuccess" style="display:none; color:green;"></div>
<div id="showdanger" style="display:none; color:red;"></div>

<script>
    function ReviewDisplay(variant_id) {
        $.ajax({
            type: "post",
            url: "<?= base_url(route_to('ReviewView')) ?>",
            data: {
                variant_id: variant_id,

            },
            success: function(response) {
                $("#review").html("");
                $("#review").html(response);
                $('#review_table').DataTable({
                    "paging": true, // Enable pagination
                    "lengthChange": true, // Allow changing page length
                    "searching": true, // Enable search box
                    "ordering": true, // Enable column sorting
                    "info": true, // Show table info (Showing 1 to X of Y entries)
                    "autoWidth": false // Disable auto-width
                });
            }
        });
    }

    function successCallback(response) {
        if (response.status == 200 || response.status == 201) {
            $(".offcanvas button[data-bs-dismiss='offcanvas']").click();
            fetchTableData({
                _autojoin: "Y",
                _select: "*"
            });
        }
    }

    function errorCallback(response) {
        console.log(response);
    }

    function successDataTableCallbackFunction(response) {
        var columns = [{
                title: "Sku Code",
                data: "variant_id",
                render: function(data, type, row) {
                    return `${row.product_id}-${row.variant_id}`;
                }
            },
            {
                title: "Product Name",
                data: null,
                render: function(data, type, row) {
                    return `${row.product_name} ${row.variant_name}`;
                }
            },
            {
                title: "Category Type",
                data: "category_type_name"
            },
            {
                title: "Category",
                data: "category_name"
            },
            {
                title: "Brand",
                data: "brand_name"
            },
            {
                title: "Stock",
                data: "stock"
            },
            {
                title: '<span data-toggle="tooltip" title="Total Order Quantity">TOQ</span>',
                data: "order_qty"
            },
            {
                title: '<span data-toggle="tooltip" title="Total Return Quantity">TRQ</span>',
                data: "return_qty"
            },
            {
                title: '<span data-toggle="tooltip" title="Total Exchange Quantity">TEQ</span>',
                data: "exchange_qty"
            },


            {
                title: "Actions",
                data: null,
                render: function(data, type, row) {
                    return `
                            <button class="btn btn-primary btn-sm" type="button" onclick="ReviewDisplay('${row.variant_id}')"data-bs-toggle="offcanvas" data-bs-target="#review" aria-controls="review">
                                <i class="mdi mdi-file-eye-outline"></i> Reviews
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


    function fetchTableData(parameter = {}) {
        parameter._selectOther =
            "IFNULL((SELECT quantity FROM `stock` WHERE `stock`.`variant_id` = product_variant.`variant_id`), 0) AS stock,IFNULL((SELECT SUM(order_qty) FROM `order_item` WHERE `order_item`.`variant_id` = product_variant.`variant_id`), 0) as order_qty,IFNULL((SELECT SUM(exchange_qty) FROM `order_item` WHERE `order_item`.`variant_id` = product_variant.`variant_id`), 0) as exchange_qty,IFNULL((SELECT SUM(return_qty) FROM `order_item` WHERE `order_item`.`variant_id` = product_variant.`variant_id`), 0) as return_qty";
        DataTableInitialized(
            'product_variant',
            "<?= base_url(route_to('variant_list_api')) ?>",
            'POST',
            parameter,
            successDataTableCallbackFunction,
        );
    }

    $(document).ready(function() {
        fetchTableData({
            _autojoin: "F",
            _select: "*"
        });
    });
</script>