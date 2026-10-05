<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="shareReferenceListTable" class="table table-striped table-bordered dt-responsive nowrap table-nowrap align-middle table-sm"></table>
        </div>
    </div>
</div>
<div class="offcanvas offcanvas-end offcanvas-product" tabindex="-1" id="customerlist" aria-labelledby="customerlistLable"></div>
</div>

<div id="showsuccess" style="display:none; color:green;"></div>
<div id="showdanger" style="display:none; color:red;"></div>

<script>
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
                title: "ID",
                data: null,
                render: function(data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                title: "Customer Name",
                data: "fullname"
            },
            {
                title: "Product Name",
                data: "product_name"
            },
            {
            title: "Sources",
            data: "sources",
            render: function(data, type, row) {
                if (!data || data.length === 0) {
                    return "-";
                }

                let sourceList = data.map(function(item) {
                    return item.source_name + " (" + item.customer_search_count + ")";
                });

                return sourceList.join(", ");
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
        DataTableInitialized(
            'shareReferenceListTable',
            "<?= base_url(route_to('share_reference_customer_list')) ?>",
            'POST',
            parameter,
            successDataTableCallbackFunction,
        );
    }

    $(document).ready(function() {
        fetchTableData({
            _autojoin: "Y",
            _select: "*"
        });
    });
</script>