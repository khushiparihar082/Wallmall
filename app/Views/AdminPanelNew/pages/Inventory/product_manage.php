<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-end mb-2">
            <div>
                <a href="<?= base_url(route_to('create_product')) ?>" type="button">
                    <button class="btn add_form_btn"><i class="bx bx-plus me-2"></i>Add Product</button>
                </a>


                <button class="btn btn-secondary text-white" type="button" data-bs-toggle="modal" data-bs-target="#importProductModal">
                    <i class="bx bx-import"></i> Import Product
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table id="productTable" class="table table-striped table-bordered dt-responsive nowrap table-nowrap align-middle table-sm"></table>
        </div>
    </div>
</div>
<div class="offcanvas offcanvas-end offcanvas-product" tabindex="-1" id="viewproduct" aria-labelledby="viewproductLable"></div>
</div>

<!-- Import Product Modal -->
<div class="modal fade" id="importProductModal" tabindex="-1" aria-labelledby="importProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importProductModalLabel">Import Product</h5>
                <button id='md-close' type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <button type="button" class="btn bg-l-blue mt-3 text-center">
                    <a class="btn btn-primary" href="<?= base_url() ?>ImportProductTemplate.xlsx" download>
                        <i class="fa fa-check-square" aria-hidden="true"></i> Download Sheet
                    </a>
                </button>
                <!-- Add your import product form here -->
                <!-- <form id="importfile"> -->
                <form method="post" enctype="multipart/form-data" id='enquiryImportCsv' name='importfile'>
                    <div class="mb-3">
                        <label for="productFile" class="form-label">Upload File</label>
                        <input class="form-control" type='file' name="csv" id="csvImportFile" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Import</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $("form[name='importfile']").on("submit", function(ev) {
        ev.preventDefault(); // Prevent the default form submission

        var formData = new FormData(this); // Create FormData from the form

        $.ajax({
            url: '<?= route_to('ImportProductByExcel') ?>',
            type: "POST",
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status === 200) {
                    toastr.success(response.message);
                    $.each(JSON.parse(response.data), function(key, value) {
                        toastr.success(value);
                    });
                    $('#md-close').click();
                } else if (response.status === 422) {
                    toastr.error(response.message);
                    $.each(response.errors[0], function(key, value) {
                        toastr.error(value);
                    });
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                toastr.error('An error occurred while importing the product.');
            }
        });
    });


    var DeleteApiUrl = "<?= base_url(route_to('product_delete_api')) ?>"

    function successCallback(response) {
        if (response.status == 200 || response.status == 201) {
            $(".offcanvas button[data-bs-dismiss='offcanvas']").click();
            fetchTableData({});
        }
    }

    function errorCallback(response) {
        console.log(response);
    }

    function deleteProduct(product_id) {
        deleteRow({
                "product_id": product_id
            }).then((response) => {
                fetchTableData();
            })
            .catch((error) => {
                console.error("Deletion failed or cancelled:", error);
            });
    }

    function ProductDisplay(product_id) {
        $.ajax({
            type: "post",
            url: "<?= base_url(route_to("ProductView")) ?>",
            data: {
                product_id: product_id,
            },
            success: function(response) {
                $("#viewproduct").html("");
                $("#viewproduct").html(response);
            }
        });
    }

    function successDataTableCallbackFunction(response) {
        var columns = [{
                title: "Product ID",
                data: "product_id"
            },
            {
                title: "Product Name",
                data: "product_name"
            },

            {
                title: "Category",
                data: "category_name"
            },
            {
                title: "Search Count",
                data: "total_search_count"
            },
             {
                title: "View Count",
                data: "view_count"
            },
            {
                "title": "Variant",
                "data": null,
                "render": function(data, type, row) {
                    return `
            <a href="<?= base_url(route_to('variant_list', '')) ?>/${row.product_id}" class="btn btn-sm btn-primary">
                View (${row.variants.length})
            </a>
        `;
                }
            },

            {
                title: "Default Variant",
                data: null,
                render: function(data, type, row) {
                    var variants = row.variants || [];
                    var dropdown = `<select class="form-select" placeholder="Default Variant" onchange="change_default_variant(event, ${row.product_id},${row.is_active})">`;
                    dropdown += `<option value="" disabled selected>Select Default Variant</option>`; // Changed value to empty string and added 'selected' attribute
                    variants.forEach(function(variant) {
                        var selectedFlag = (row.variant_id == variant.variant_id) ? 'selected' : ''; // Adjusted condition for selected option
                        dropdown += `<option value="${variant.variant_id}" ${selectedFlag}>${variant.variant_name}</option>`;
                    });
                    dropdown += `</select>`;

                    dropdown += '</select>';
                    return dropdown;
                }
            },
            {
                title: "Is Active",
                data: "is_active",
                render: function(data, type, row) {
                    var checked = data == 1 ? 'checked' : ''; // Check if data is 1 (true) to set checked attribute
                    return `
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="isActiveSwitch_${row.product_id}" ${checked} onchange="change_is_active(event, ${row.product_id})">
            </div>`;
                }
            },

            {
                "title": "Actions",
                "data": null,
                "render": function(data, type, row) {
                    return `
                            <a class="btn btn-sm btn-info" href="<?= base_url(route_to('create_product')) ?>/${row.product_id }" >
                                <i class="bx bx-edit-alt"></i>
                            </a>
                            <button class="btn btn-sm btn-danger" onclick="deleteProduct(${row.product_id })">
                                <i class="bx bx-trash-alt"></i>
                            </button>
                              <button class="btn btn-primary btn-sm" type="button" onclick="ProductDisplay('${row.product_id}')" data-bs-toggle="offcanvas" data-bs-target="#viewproduct" aria-controls="viewproduct">
                                <i class="mdi mdi-file-eye-outline"></i>
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

    function afterTableViewCallbackFunction(data) {
        // $('.selectize').selectize({
        //     placeholder: "Select Default Variant"
        // });
    }

    function change_default_variant(event, product_id, is_active) {
        var default_variant_id = event.target.value; // Get the selected default variant ID from the event

        $.ajax({
            type: "POST",
            url: "<?= base_url(route_to('product_update_api')) ?>",
            data: {
                product_id: product_id,
                variant_id: default_variant_id,
                is_active: is_active,
            },
            success: function(response) {
                if (response.status == 200) {
                    toastr.success("Default Variant Change Successfully");
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX request error:", error);
            }
        });

        console.log("Event:", event);
        console.log("Product ID:", product_id);
    }


    function change_is_active(event, product_id) {

        var isChecked = event.target.checked; // Determine if the checkbox is checked or unchecked

        // Toggle the checked state based on the isChecked variable
        $('#isActiveSwitch_' + product_id).prop('checked', isChecked);

        var is_active = isChecked ? 1 : 0; // Set is_active to 1 if checked, 0 if unchecked

        $.ajax({
            type: "POST",
            url: "<?= base_url(route_to('product_update_api')) ?>",
            data: {
                product_id: product_id,
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
        parameter._autojoin = "Y";
        parameter._select = "*";
        parameter._otherFilters = {
            'top_search': true,
            'variants': true,
            'variants_filters': {
                '_autojoin': 'Y',
                '_select': '*',
            },
        };
        DataTableInitialized(
            'productTable', // table_id
            "<?= base_url(route_to('product_list_api')) ?>", // url
            'POST', // methodt
            parameter, // parameter
            successDataTableCallbackFunction, // dataTableSuccessCallBack
            {}, // headers 
            afterTableViewCallbackFunction
        );
    }
    $(document).ready(function() {
        fetchTableData({});
    });



    document.getElementById('importProductForm').addEventListener('submit', function(event) {
        event.preventDefault();
        // Handle file upload and import logic here
        const fileInput = document.getElementById('productFile');
        const file = fileInput.files[0];
        if (file) {
            // Implement the logic to process the file
            console.log('File ready for import:', file);
            // Close the modal after import
            var myModalEl = document.getElementById('importProductModal');
            var modal = bootstrap.Modal.getInstance(myModalEl);
            modal.hide();
        } else {
            alert('Please select a file to import.');
        }
    });
</script>