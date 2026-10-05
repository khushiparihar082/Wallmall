<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>
            <?php
            switch ($form_type) {
                case 'contact_us':
                    echo "Contact Us Enquire List";
                    break;
                case 'sales':
                    echo "Sales Enquire List";
                    break;
                case 'career':
                    echo "Career Enquire List";
                    break;
                case 'support':
                    echo "Support Enquire List";
                    break;
                default:
            }
            ?>
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="table-responsive">
                <table id="enquireTable" class="table table-striped table-bordered dt-responsive nowrap table-nowrap align-middle" style="border-collapse: collapse; border-spacing: 0; width: 100%;"></table>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="RightSlideBox" aria-labelledby="RightSlideBoxLabel">

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
    function successDataTableCallbackFunction(response) {
        var columns = [{
                title: "ID",
                data: "form_submissions_id"
            },
            {
                title: "Name",
                data: "name"
            },
            {
                title: "Email",
                data: "email"
            },
            {
                title: "mobile",
                data: "mobile"
            },
            {
                title: "Message",
                data: "message"
            },
            <?php if ($form_type == 'sales') : ?> {
                    title: "Product Name",
                    data: "product_name"
                },
            <?php endif; ?>
            <?php if ($form_type == 'career' || $form_type == 'support') : ?> {
                    title: "Attachment",
                    data: "attachment_url"
                },
            <?php endif; ?> {
                title: "Remark",
                data: "status_remark"
            },
            {
                title: "Status",
                data: "status",
                render: function(data, type, row) {
                    var status = data;
                    var dataJson = encodeURIComponent(JSON.stringify(row));
                    var dropdown = `<select class="selectize" placeholder="Default status" onchange="change_default_status(event,'${dataJson}')">`;
                    dropdown += `<option value="" disabled ${!row.status ? 'selected' : ''}>Select Status</option>`;
                    dropdown += `<option value="pending" ${(status == "pending")?"selected":""}>Pending</option>`;
                    dropdown += `<option value="partial_pending" ${(status == "partial_pending")?"selected":""}>Partial Pending</option>`;
                    dropdown += `<option value="resolved" ${(status == "resolved")?"selected":""}>Resolved</option>`;
                    dropdown += `</select>`;
                    return dropdown;
                }
            }

        ];
        if (response.status == 200) {
            return {
                status: response.status,
                columns: columns,
                data: JSON.parse(response.data)
            };
        } else {
            return {
                status: response.status,
                columns: columns,
                data: []
            };
        }
    }

    function change_default_status(event, dataJson) {
        var data = JSON.parse(decodeURIComponent(dataJson));
        data.status = event.target.value;
        Swal.fire({
            title: 'Enter Remark',
            input: 'textarea',
            inputPlaceholder: 'Type your remark here...',
            showCancelButton: true,
            confirmButtonText: 'Update Status',
            cancelButtonText: 'Cancel',
            preConfirm: (remark) => {
                if (!remark) {
                    Swal.showValidationMessage('Remark is required');
                }
                return remark;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                data.status_remark = result.value;
                $.ajax({
                    type: "POST",
                    url: "<?= base_url(route_to('enquire_update_api')) ?>",
                    data: data,
                    success: function(response) {
                        if (response.status == 200) {
                            toastr.success("Status Change Successfully");
                            fetchTableData();
                        } else {
                            toastr.error(response.message);
                            fetchTableData();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX request error:", error);
                    }
                });
            }
        });
    }

    function afterTableViewCallbackFunction(data) {
        $('.selectize').selectize({
            placeholder: "Select Default Status"
        });
    }

    function fetchTableData(parameter = {}) {
        parameter._autojoin = 'Y';
        parameter._select = '*';
        parameter["form_submissions-form_type"] = '<?= $form_type ?>';
        DataTableInitialized(
            'enquireTable', // table_id
            "<?= base_url(route_to('enquire_list_api')) ?>", // url
            'POST', // method
            parameter, // parameter
            successDataTableCallbackFunction, {}, // headers 
            afterTableViewCallbackFunction
        );
    }
    $(document).ready(function() {
        fetchTableData();

    });
</script>