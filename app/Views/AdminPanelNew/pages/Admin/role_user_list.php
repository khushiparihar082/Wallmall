<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-end table_btn_div mb-2">
            <button class="add_form_btn" onclick="editUser()" type="button" data-bs-toggle="offcanvas" data-bs-target="#RightSlideBox" aria-controls="RightSlideBox">
                <i class="bx bxs-user-plus"></i> Add Role
            </button>
        </div>
        <div class="table-responsive">
            <div class="table-responsive">
                <table id="usersTable" class="table table-striped table-bordered dt-responsive nowrap table-nowrap align-middle" style="border-collapse: collapse; border-spacing: 0; width: 100%;"></table>
            </div>
        </div>
    </div>
</div>

<!-- Add Role user form offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="RightSlideBox" aria-labelledby="RightSlideBoxLabel">

</div>
<script>
    var DeleteApiUrl = "<?= base_url(route_to('user_delete_api')) ?>"

    function successCallback(response) {
        if (response.status == 200 || response.status == 201) {
            $(".offcanvas button[data-bs-dismiss='offcanvas']").click();
            fetchTableData();
        }
    }

    function errorCallback(response) {
        console.log(response);
    }

    function deleteUser(user_id) {
        deleteRow({
                "user_id": user_id
            }).then((response) => {
                fetchTableData();
            })
            .catch((error) => {
                console.error("Deletion failed or cancelled:", error);
            });
    }

    function editUser(user_id = null) {
        $.ajax({
            type: "get",
            url: "<?= base_url(route_to("UserRoleCreateUpdateComponent")) ?>" + (user_id ? "/" + user_id : ""),
            success: function(response) {
                $("#RightSlideBox").html("");
                $("#RightSlideBox").html(response);
                $("#user_type").selectize({});
            }
        });
    }

    function successDataTableCallbackFunction(response) {
        var columns = [{
                title: "User ID",
                data: "user_id"
            },
            {
                title: "User Name",
                data: "fullname"
            },
            {
                title: "Email",
                data: "email"
            },
            {
                title: "Mobile",
                data: "mobile"
            },
            {
                title: "Role",
                data: "user_type"
            },
            {
                title: "Active",
                data: "is_active"
            },
            {
                "title": "Actions",
                "data": null,
                "render": function(data, type, row) {
                    return `
                            <button class="btn btn-sm btn-info" onclick="editUser(${row.user_id})" data-bs-toggle="offcanvas" data-bs-target="#RightSlideBox" aria-controls="RightSlideBox">
                                <i class="bx bx-edit-alt"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteUser(${row.user_id})">
                                <i class="bx bx-trash-alt"></i>
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
        DataTableInitialized(
            'usersTable', // table_id
            "<?= base_url(route_to('user_list_api')) ?>", // url
            'POST', // method
            parameter, // parameter
            successDataTableCallbackFunction // dataTableSuccessCallBack
        );
    }
    $(document).ready(function() {
        fetchTableData();
    });
</script>