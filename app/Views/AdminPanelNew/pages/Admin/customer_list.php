<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="customerListTable" class="table table-striped table-bordered dt-responsive nowrap table-nowrap align-middle table-sm"></table>
        </div>
    </div>
</div>
<div class="offcanvas offcanvas-end offcanvas-product" tabindex="-1" id="customerlist" aria-labelledby="customerlistLable"></div>
</div>

<div id="showsuccess" style="display:none; color:green;"></div>
<div id="showdanger" style="display:none; color:red;"></div>

<script>
      function ReviewDisplay(customer_id) {
        $.ajax({
            type: "post",
            url: "<?= base_url(route_to('ReviewView')) ?>",
            data: {
                customer_id: customer_id,
               
            },
            success: function(response) {
                $("#customerlist").html("");
                $("#customerlist").html(response);
            }
        });
    }
    function ReferDisplay(customer_id) {
        $.ajax({
            type: "post",
            url: "<?= base_url(route_to('ReferView')) ?>",
            data: {
                customer_id: customer_id,
               
            },
            success: function(response) {
                $("#customerlist").html("");
                $("#customerlist").html(response);
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

    function deleteCustomerList(customer_id) {
        deleteRow({
                "customer_id": customer_id
            }).then((response) => {
                fetchTableData({
                    _autojoin: "Y",
                    _select: "*"
                });
            })
            .catch((error) => {
                console.error("Deletion failed or cancelled:", error);
            });
    }



    function successDataTableCallbackFunction(response) {
        var columns = [{
                title: "ID",
                data: "customer_id"
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
                title: "UPI Id",
                data: "customer_upi_id"
            },
            {
                title: "Last Activity",
                data: "last_activity_date"
            },
            {
                title: "Total Orders",
                data: "customer_id",
                render: function(data, type, row) {
                    return `<a href="<?= base_url(route_to('all_order')) ?>?customer_id=${data}" class="btn btn-info btn-sm">${row.total_order}</a>`;
                }
            },
            {
                title: "Status",
                data: "is_active",
                render: function(data, type, row) {
                    var checked = data == 1 ? 'checked' : '';
                    return `
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="isActiveSwitch_${row.customer_id}" ${checked} onchange="change_is_active(event, ${row.customer_id})">
            </div>`;
                }
            },
            {
                title: "Actions",
                data: null,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-primary btn-sm" type="button" onclick="ReviewDisplay('${row.customer_id}')"data-bs-toggle="offcanvas" data-bs-target="#customerlist" aria-controls="customerlist">
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

    function change_is_active(event, customer_id) {

        var isChecked = event.target.checked; // Determine if the checkbox is checked or unchecked

        // Toggle the checked state based on the isChecked variable
        $('#isActiveSwitch_' + customer_id).prop('checked', isChecked);

        var is_active = isChecked ? 1 : 0; // Set is_active to 1 if checked, 0 if unchecked

        $.ajax({
            type: "POST",
            url: "<?= base_url(route_to('customer_update_api')) ?>",
            data: {
                customer_id: customer_id,
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

    function fetchTableData(parameter = {}) {
        parameter._selectOther =
            "IFNULL((SELECT SUM(order_total) FROM `order` WHERE `order`.`customer_id` = customer.`customer_id`), 0) AS total_order";
        DataTableInitialized(
            'customerListTable',
            "<?= base_url(route_to('customer_list_api')) ?>",
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