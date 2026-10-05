<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-end table_btn_div mb-2">
            <button class="add_form_btn" onclick="editColor()" type="button" data-bs-toggle="offcanvas" data-bs-target="#RightSlideBox" aria-controls="RightSlideBox">
                <i class="bx bxs-user-plus"></i> Add Color
            </button>
        </div>
        <div class="table-responsive">
            <div class="table-responsive">
                <table id="addcolorTable" class="table table-striped table-bordered dt-responsive nowrap table-nowrap align-middle" style="border-collapse: collapse; border-spacing: 0; width: 100%;"></table>
            </div>
        </div>
    </div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="RightSlideBox" aria-labelledby="RightSlideBoxLabel">

    </div>

    <script>
        var DeleteApiUrl = "<?= base_url(route_to('color_delete_api')) ?>"

        function successCallback(response) {
            if (response.status == 200 || response.status == 201) {
                $(".offcanvas button[data-bs-dismiss='offcanvas']").click();
                fetchTableData();
            }
        }

        function errorCallback(response) {
            console.log(response);
        }

        function deleteColor(color_id) {
            deleteRow({
                    "color_id": color_id
                }).then((response) => {
                    fetchTableData();
                })
                .catch((error) => {
                    console.error("Deletion failed or cancelled:", error);
                });
        }

        function editColor(color_id = null) {
            $.ajax({
                type: "get",
                url: "<?= base_url(route_to("ColorCreateUpdate")) ?>" + (color_id ? "/" + color_id : ""),
                success: function(response) {
                    $("#RightSlideBox").html("");
                    $("#RightSlideBox").html(response);

                }
            });
        }

        function successDataTableCallbackFunction(response) {
            var columns = [{
                    title: "Color ID",
                    data: "color_id"
                },
                {
                    title: "Color Name",
                    data: "color_name"
                },
                {
                    title: "Color Code",
                    data: "color_code",
                    render: function(data, type, row) {
                        return `<div style="background-color:${data}; width:20px; height:20px; border-radius:50%;"></div>`;
                    }
                },
                {
                    title: "Image",
                    data: null,
                    "render": function(data, type, row) {
                        return `
                    <img class="image-fluid" style="height:auto; width:100px" src="<?= base_url() ?>/${row.color_image }" onclick="enlargeImage(event)">
                    `;
                    }
                },
                // {
                //     title: "Active",
                //     data: "is_active"
                // },

                {
                    "title": "Actions",
                    "data": null,
                    "render": function(data, type, row) {
                        return `
                            <button class="btn btn-sm btn-info" onclick="editColor(${row.color_id  })" data-bs-toggle="offcanvas" data-bs-target="#RightSlideBox" aria-controls="RightSlideBox">
                                <i class="bx bx-edit-alt"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteColor(${row.color_id  })">
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
                'addcolorTable', // table_id
                "<?= base_url(route_to('color_list_api')) ?>", // url
                'POST', // method
                parameter, // parameter
                successDataTableCallbackFunction // dataTableSuccessCallBack
            );
        }
        $(document).ready(function() {
            fetchTableData();
        });
    </script>