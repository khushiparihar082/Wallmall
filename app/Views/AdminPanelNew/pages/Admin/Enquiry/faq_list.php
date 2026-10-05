<div class="card">
    <div class="card-body">
        <div class="offcanvas-header mb-3 d-flex justify-content-between align-items-center">
            <h4>
                FAQ List
            </h4>
            <div>
                <a href="<?= base_url(route_to('faq_create_update')) ?>" class="btn add_form_btn" type="button">
                    <i class="bx bxs-user-plus"></i> Add Question
                </a>
                <a href="<?= base_url(route_to('faq_list')) ?>" class="btn btn-secondary">Back</a>
            </div>
        </div>
        <div class="table-responsive">
            <div class="table-responsive">
                <table id="offerTable" class="table table-striped table-bordered dt-responsive nowrap table-nowrap align-middle table-sm"></table>
            </div>
        </div>
    </div>
</div>

</div>


<script>
    var DeleteApiUrl = "<?= base_url(route_to('faq_delete_api')) ?>"

    function successCallback(response) {
        if (response.status == 200 || response.status == 201) {
            fetchTableData({});
        }
    }

    function errorCallback(response) {
        console.log(response);
    }

    function deleteFaq(faq_id) {
        deleteRow({
                "faq_id": faq_id
            }).then((response) => {
                fetchTableData({});
            })
            .catch((error) => {
                console.error("Deletion failed or cancelled:", error);
            });
    }


    function successDataTableCallbackFunction(response) {
        var columns = [
            {
                title: "FAQ Question",
                data: "faq_question"
            },
            {
                title: "FAQ answer",
                data: "faq_answer"
            },
            {
                title: "Status",
                data: "faq_status",
                render: function(data, type, row) {
                    var checked = data == "published" ? 'checked' : '';
                    var draftChecked = data == "draft" ? 'checked' : '';
                    return `
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="isActiveSwitch_${row.faq_id}" ${checked} onchange="change_status(event, ${row.faq_id})">
                <label class="form-check-label" for="isActiveSwitch_${row.faq_id}">${data}</label>
            </div>`;
                }
            },
            {
                "title": "Actions",
                "data": null,
                "render": function(data, type, row) {
                    return `
                        
                            <a class="btn btn-sm btn-info" href="<?= base_url(route_to('faq_create_update')) ?>/${row.faq_id }" >
                                <i class="bx bx-edit-alt"></i>
                            </a>
                             <button class="btn btn-sm btn-danger" onclick="deleteFaq(${row.faq_id })">
                                <i class="bx bx-trash-alt"></i>
                            </button>
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

    function fetchTableData() {

        DataTableInitialized(
            'offerTable', // table_id
            "<?= base_url(route_to('faq_list_api')) ?>", // url
            'POST', {}, successDataTableCallbackFunction, {},
        );
    }

    function change_status(event, faq_id) {

        var isChecked = event.target.checked;

        $('#isActiveSwitch_' + faq_id).prop('checked', isChecked);

        var faq_status = isChecked ? 'published' : 'draft';

        $.ajax({
            type: "POST",
            url: "<?= base_url(route_to('faq_update_api')) ?>",
            data: {
                faq_id: faq_id,
                faq_status: faq_status,

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
        fetchTableData();
    });
</script>