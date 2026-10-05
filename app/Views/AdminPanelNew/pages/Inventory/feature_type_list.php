<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-end table_btn_div mb-2">
            <button class="add_form_btn" onclick="editFeature()" type="button" data-bs-toggle="offcanvas" data-bs-target="#RightSlideBox" aria-controls="RightSlideBox">
                <i class="bx bxs-user-plus"></i> Add Feature Type
            </button>
        </div>
        <div class="table-responsive">
            <div class="table-responsive">
                <table id="featureTable" class="table table-striped table-bordered dt-responsive nowrap table-nowrap align-middle" style="border-collapse: collapse; border-spacing: 0; width: 100%;"></table>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="RightSlideBox" aria-labelledby="RightSlideBoxLabel">

</div>




<script>
    var DeleteApiUrl = "<?= base_url(route_to('featureType_delete_api')) ?>"

    function successCallback(response) {
        if (response.status == 200 || response.status == 201) {
            $(".offcanvas button[data-bs-dismiss='offcanvas']").click();
            fetchTableData();
        }
    }

    function errorCallback(response) {
        console.log(response);
    }

    function deleteFeature(feature_type_id) {
        deleteRow({
                "feature_type_id": feature_type_id
            }).then((response) => {
                fetchTableData();
            })
            .catch((error) => {
                console.error("Deletion failed or cancelled:", error);
            });
    }

    function editFeature(feature_type_id = null) {
        $.ajax({
            type: "get",
            url: "<?= base_url(route_to("FeatureTypeCreateUpdate")) ?>" + (feature_type_id ? "/" + feature_type_id : ""),
            success: function(response) {
                $("#RightSlideBox").html("");
                $("#RightSlideBox").html(response);

            }
        });
    }

    function successDataTableCallbackFunction(response) {
        var columns = [{
                title: "Feature Type ID",
                data: "feature_type_id"
            },
            {
                title: "Feature Name",
                data: "feature_type_name"
            },
            {
                title: "Description",
                data: "feature_type_description"
            },
            {
                title: "Image",
                data: null,
                "render": function(data, type, row) {
                    return `
                    <img class="image-fluid" style="height:auto; width:100px" src="<?= base_url() ?>/${row.feature_type_image }" onclick="enlargeImage(event)">
                    `;
                }
            },

            // {
            //     title: "SEO Keywords",
            //     data: "feature_type_seo_keyword"
            // },
            // {
            //     title: "SEO Description",
            //     data: "feature_type_seo_description"
            // },
            {
                title: "Is Active",
                data: "is_active",
                render: function(data, type, row) {
                    var checked = data == 1 ? 'checked' : ''; // Check if data is 1 (true) to set checked attribute
                    return `
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="isActiveSwitch_${row.feature_id}" ${checked} onchange="change_is_active(event, ${row.feature_type_id})">
            </div>`;
                }
            },
            {
                "title": "Actions",
                "data": null,
                "render": function(data, type, row) {
                    return `
                            <button class="btn btn-sm btn-info" onclick="editFeature(${row.feature_type_id })" data-bs-toggle="offcanvas" data-bs-target="#RightSlideBox" aria-controls="RightSlideBox">
                                <i class="bx bx-edit-alt"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteFeature(${row.feature_type_id })">
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
            'featureTable', // table_id
            "<?= base_url(route_to('featureType_list_api')) ?>", // url
            'POST', // method
            parameter, // parameter
            successDataTableCallbackFunction // dataTableSuccessCallBack
        );
    }

    function change_is_active(event, feature_type_id) {

        var isChecked = event.target.checked; // Determine if the checkbox is checked or unchecked

        // Toggle the checked state based on the isChecked variable
        $('#isActiveSwitch_' + feature_type_id).prop('checked', isChecked);

        var is_active = isChecked ? 1 : 0; // Set is_active to 1 if checked, 0 if unchecked

        $.ajax({
            type: "POST",
            url: "<?= base_url(route_to('featureType_update_api')) ?>",
            data: {
                feature_type_id: feature_type_id,
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
    $(document).ready(function() {
        fetchTableData();
    });
</script>