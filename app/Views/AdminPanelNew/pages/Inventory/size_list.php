<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-end table_btn_div mb-2">
            <button class="btn add_form_btn" onclick="editSize()" type="button" data-bs-toggle="offcanvas" data-bs-target="#RightSlideBox" aria-controls="RightSlideBox">
                <i class="bx bxs-user-plus"></i> Add Size
            </button>
        </div>
        <div class="table-responsive">
            <div class="table-responsive">
                <table id="sizeTable" class="table table-striped table-bordered dt-responsive nowrap table-nowrap align-middle" style="border-collapse: collapse; border-spacing: 0; width: 100%;"></table>
            </div>
        </div>
    </div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="RightSlideBox" aria-labelledby="RightSlideBoxLabel">

    </div>




    <script>
        var DeleteApiUrl = "<?= base_url(route_to('size_delete_api')) ?>"

        function successCallback(response) {
            if (response.status == 200 || response.status == 201) {

                $(".offcanvas button[data-bs-dismiss='offcanvas']").click();
                fetchTableData();
            }
        }

        function errorCallback(response) {
            console.log(response);
        }

        function deleteSize(size_id) {
            deleteRow({
                    "size_id": size_id
                }).then((response) => {
                    fetchTableData();
                })
                .catch((error) => {
                    console.error("Deletion failed or cancelled:", error);
                });
        }

        function editSize(size_id = null) {
            $.ajax({
                type: "get",
                url: "<?= base_url(route_to("SizeCreateUpdate")) ?>" + (size_id ? "/" + size_id : ""),
                success: function(response) {
                    $("#RightSlideBox").html("");
                    $("#RightSlideBox").html(response);

                }
            });
        }

        function successDataTableCallbackFunction(response) {
            var columns = [{
                    title: "Size ID",
                    data: "size_id"
                },
                {
                    title: "Size Name",
                    data: "size_name"
                },

                {
                    "title": "Actions",
                    "data": null,
                    "render": function(data, type, row) {
                        return `
                            <button class="btn btn-sm btn-info" onclick="editSize(${row.size_id  })" data-bs-toggle="offcanvas" data-bs-target="#RightSlideBox" aria-controls="RightSlideBox">
                                <i class="bx bx-edit-alt"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteSize(${row.size_id  })">
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
                'sizeTable', // table_id
                "<?= base_url(route_to('size_list_api')) ?>", // url
                'POST', // method
                parameter, // parameter
                successDataTableCallbackFunction // dataTableSuccessCallBack
            );
        }
        $(document).ready(function() {
            fetchTableData();
        });
    </script>