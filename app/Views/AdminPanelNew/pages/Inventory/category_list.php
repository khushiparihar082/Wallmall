<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-end table_btn_div mb-2">
            <button class="add_form_btn" onclick="editCategory()" type="button" data-bs-toggle="offcanvas" data-bs-target="#RightSlideBox" aria-controls="RightSlideBox">
                <i class="bx bxs-user-plus"></i> Add Category
            </button>
        </div>
        <div class="table-responsive">
            <div class="table-responsive">
                <table id="categoryTable" class="table table-striped table-bordered dt-responsive nowrap table-nowrap align-middle" style="border-collapse: collapse; border-spacing: 0; width: 100%;"></table>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="RightSlideBox" aria-labelledby="RightSlideBoxLabel">

</div>




<script>
    var DeleteApiUrl = "<?= base_url(route_to('category_delete_api')) ?>"

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

    function deleteCategory(category_id) {
        deleteRow({
                "category_id": category_id
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

    function editCategory(category_id = null) {
        $.ajax({
            type: "get",
            url: "<?= base_url(route_to("CategoryCreateUpdate")) ?>" + (category_id ? "/" + category_id : ""),
            success: function(response) {
                $("#RightSlideBox").html("");
                $("#RightSlideBox").html(response);
                initializeSelectize('category_type_id', {}, "<?= base_url(route_to('categoryType_list_api')) ?>", {}, "category_type_id", "category_type_name", selected_category_type_id)
            }
        });
    }

    function successDataTableCallbackFunction(response) {
        var columns = [{
                title: "Category ID",
                data: "category_id"
            },
            {
                title: "Category Name",
                data: "category_name"
            },
            {
                title: "Category Type",
                data: "category_type_name"
            },
            {
                title: "Description",
                data: "category_description"
            },
            {
                title: "Image",
                data: null,
                "render": function(data, type, row) {
                    return `
                    <img class="image-fluid" style="height:auto; width:100px" src="<?= base_url() ?>/${row.category_image }" onclick="enlargeImage(event)">
                    `;
                }
            },

            // {
            //     title: "SEO Keywords",
            //     data: "category_seo_keyword"
            // },
            // {
            //     title: "SEO Description",
            //     data: "category_seo_description"
            // },
            {
                title: "Is Active",
                data: "is_active",
                render: function(data, type, row) {
                    var checked = data == 1 ? 'checked' : '';
                    return `
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="isActiveSwitch_${row.category_id}" ${checked} onchange="change_is_active(event, ${row.category_id})">
            </div>`;
                }
            },
            {
                "title": "Actions",
                "data": null,
                "render": function(data, type, row) {
                    return `
                            <button class="btn btn-sm btn-info" onclick="editCategory(${row.category_id })" data-bs-toggle="offcanvas" data-bs-target="#RightSlideBox" aria-controls="RightSlideBox">
                                <i class="bx bx-edit-alt"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteCategory(${row.category_id })">
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

    function change_is_active(event, category_id) {

        var isChecked = event.target.checked; // Determine if the checkbox is checked or unchecked

        // Toggle the checked state based on the isChecked variable
        $('#isActiveSwitch_' + category_id).prop('checked', isChecked);

        var is_active = isChecked ? 1 : 0; // Set is_active to 1 if checked, 0 if unchecked

        $.ajax({
            type: "POST",
            url: "<?= base_url(route_to('category_update_api')) ?>",
            data: {
                category_id: category_id,
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
        DataTableInitialized(
            'categoryTable', // table_id
            "<?= base_url(route_to('category_list_api')) ?>", // url
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