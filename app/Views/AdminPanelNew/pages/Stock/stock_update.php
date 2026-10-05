<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>
            Inventory Stock
        </h4>
        <h6>

        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="table-responsive">
                <table id="stockTable" class="table table-striped table-bordered dt-responsive nowrap table-nowrap align-middle" style="border-collapse: collapse; border-spacing: 0; width: 100%;"></table>
            </div>
        </div>
    </div>
</div>

</div>


<script>
    function successCallback(response) {
        if (response.status == 200 || response.status == 201) {
            fetchTableData();
        }
    }

    function errorCallback(response) {
        console.log(response);
    }


    function updateQuantity(stock_id, variant_id) {
        var quantity = $(`#quantity_${variant_id}`).val();
        var url = "<?= base_url(route_to('stockDeleteCreate')) ?>";
        $.ajax({
            type: "post",
            url: url,
            data: {
                stock_id: stock_id,
                variant_id: variant_id,
                quantity: quantity
            },
            success: function(response) {
                if (response.status == 201 || response.status == 200) {
                    toastr.success("Stock Update Successfully");
                    fetchTableData();
                } else {
                    response.error(response.message);
                    fetchTableData();
                }
            },
            error: function(error) {
                console.error('Error updating quantity:', error);
                //alert('An error occurred while updating quantity.');
            }
        });
    }

    function successDataTableCallbackFunction(response) {
        var columns = [{
                title: "ID",
                data: "stock_id"
            },
            {
                title: "SKU Code",
                data: null,
                visible: true,
                "render": function(data, type, row) {
                    return row.product_id + '-' + row.variant_id;
                }
            },

            {
                title: "Item Name With Variant",
                data: "variant_name",
                render: function(data, type, row) {
                    return row.product_name + " - " + row.variant_name;
                }

            },
            {
                title: "Stock Update Date",
                data: "updated_at",
                visible: true,
            },
            {
                title: "Stock",
                data: "quantity",
                visible: true,
            },
            {
                title: "Qty",
                data: null,
                render: function(data, type, row) {
                    return `<input type="number" style="width:100px;padding:.47rem .75rem;color: var(--bs-body-color);" id="quantity_${row.variant_id}" value="${row.quantity}">`;
                }
            },
            {
                "title": "Actions",
                "data": null,
                "render": function(data, type, row) {
                    return `
            <button class="btn btn-sm btn-info" onclick="updateQuantity(${row.stock_id},${row.variant_id})">
                <i class="fa fa-check"></i>
            </button>
        `;
                }
            }

        ];
        if (response.status == 200) {
            let data = JSON.parse(response.data);
            let totalCount = data.length;
            $("h6").text("Total Stock: " + totalCount);
            return {
                "status": response.status,
                "columns": columns,
                "data": data
            };
        } else {
            $("h6").text("Total Stock: " + 0);
            return {
                "status": response.status,
                "columns": columns,
                "data": {}
            };
        }
    }


    function fetchTableData(parameter = {}) {
        DataTableInitialized(
            'stockTable', // table_id
            "<?= base_url(route_to('ProductWiseStockList')) ?>", // url
            'POST', // method
            parameter, // parameter
            successDataTableCallbackFunction // dataTableSuccessCallBack
        );
    }
    $(document).ready(function() {
        fetchTableData();

    });
</script>