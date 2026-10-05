<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="WithdrawalReqListTable" class="table table-striped table-bordered dt-responsive nowrap table-nowrap align-middle table-sm"></table>
        </div>
    </div>
</div>
<div class="offcanvas offcanvas-end offcanvas-product" tabindex="-1" id="customerlist" aria-labelledby="customerlistLable"></div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Withdrawal Request Status Update</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="status_input" name="status" placeholder="Enter Status">
                <input type="hidden" class="form-control" id="modal_requested_amount" name="status" placeholder="Enter Status">
                <input type="hidden" class="form-control" id="modal_customer_id" name="status" placeholder="Enter Status">
                <input type="hidden" class="form-control" id="modal_withdrawal_id" name="status" placeholder="Enter Status">
                <div class="mb-3">
                    <label class="form-label">Remark</label>
                    <div>
                        <input type="text" class="form-control" id="remark" name="remark" placeholder="Enter Remark" value="<?= @$remark ?>" />
                    </div>
                    <span class="error-message" id="error-remark"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="Status_update()">Save changes</button>
            </div>
        </div>
    </div>
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
                title: "Request Amount",
                data: "requested_amount"
            },
            {
                title: "Remark",
                data: "remark"
            },
            {
                title: "Current Balance",
                data: "current_balance",
                render: function(data) {
                    return parseFloat(data).toFixed(2);
                }
            },

            {
                title: "Status",
                data: "status"
            },
            {
                title: "Action",
                data: null,
                render: function(data, type, row, meta) {
                    var actionButtons = "";
                    if (row.status == "pending") {
                        actionButtons += '<button class="btn btn-warning btn-sm openModal" ' +
                            'data-status="approved" ' +
                            'data-withdrawal-id="' + row.withdraw_id + '" ' +
                            'data-customer-id="' + row.customer_id + '" ' +
                            'data-requested-amount="' + row.requested_amount + '" ' +
                            'data-bs-toggle="modal" data-bs-target="#exampleModal">Approve</button>';

                        actionButtons += '<button class="btn btn-primary btn-sm openModal" ' +
                            'data-status="rejected" ' +
                            'data-withdrawal-id="' + row.withdraw_id + '" ' +
                            'data-customer-id="' + row.customer_id + '" ' +
                            'data-requested-amount="' + row.requested_amount + '" ' +
                            'data-bs-toggle="modal" data-bs-target="#exampleModal">Reject</button>';
                    }
                    return actionButtons;
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
        parameter['status'] = 'pending';
        DataTableInitialized(
            'WithdrawalReqListTable',
            "<?= base_url(route_to('getWithdrawalRequestList_api')) ?>",
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
<script>
    document.addEventListener("click", function(e) {

        if (e.target.classList.contains("openModal")) {

            // status set
            document.getElementById("status_input").value = e.target.getAttribute("data-status");

            // hidden inputs set
            document.getElementById("modal_withdrawal_id").value =
                e.target.getAttribute("data-withdrawal-id");

            document.getElementById("modal_customer_id").value =
                e.target.getAttribute("data-customer-id");

            document.getElementById("modal_requested_amount").value =
                e.target.getAttribute("data-requested-amount");
        }

    });

    function Status_update() {
        debugger
        const remark = $('#remark').val();
        const status = $('#status_input').val();
        const request_amount = $('#modal_requested_amount').val();
        const withdrawal_id = $('#modal_withdrawal_id').val();
        const customer_id = $('#modal_customer_id').val();

        const url = "<?= base_url(route_to('getUpdateWithdrawalRequest_api')); ?>";

        if (remark == '') {
            toastr.error('Please enter remark');
            return;
        }

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                customer_id: customer_id,
                requested_amount: request_amount,
                status: status,
                remark: remark,
                withdrawal_id: withdrawal_id
            },
            success: function(response) {
                if (response.status == 200) {
                    toastr.success(response.message);
                    location.reload();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                console.error("Error fetching data:", xhr);
            }
        });
    }
</script>