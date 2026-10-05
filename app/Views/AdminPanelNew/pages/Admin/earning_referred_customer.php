<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="ReferredcustomerListTable" class="table table-striped table-bordered dt-responsive nowrap table-nowrap align-middle table-sm"></table>
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
                title: "Fullname",
                data: "fullname"
            },
            {
                title: "Mobile",
                data: "mobile"
            },
            {
                title: "Email",
                data: "email"
            },
            {
                title: "Total Earn",
                data: "total_earning",
                render: function(data) {
                    return parseFloat(data).toFixed(2);
                }
            },
            {
                title: "Total Withdrawal",
                data: "total_withdrawal"
            },
            {
                title: "Remaining Amount",
                data: "remaining",
                render: function(data) {
                    return parseFloat(data).toFixed(2);
                }
            },
            {
                "title": "Referred Customers",
                "data": null,
                "render": function(data, type, row) {
                    return `
           <a href="<?= base_url('Auth/Admin/Pages/EarnReferredCustomers') ?>/${row.customer_id}/1" 
   class="btn btn-sm btn-primary">
    Level-1 Customers
</a>
 <a href="<?= base_url('Auth/Admin/Pages/EarnReferredCustomers') ?>/${row.customer_id}/2" 
   class="btn btn-sm btn-primary">
    Level-2 Customers
</a>
        `;
                }
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
        parameter['customer_id'] = '<?= $customer_id ?>';
        parameter['level'] = '<?= $level ?>';
        DataTableInitialized(
            'ReferredcustomerListTable',
            "<?= base_url(route_to('getLevel2ReferredEarnCustomer_api')) ?>",
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