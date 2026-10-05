<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
        </div>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between table_btn_div mb-2">
            <h4>
                <?= @$product_data['product_name'] ?> (<?= @$product_data['product_code'] ?>)
            </h4>
            <div>
                <a href="<?= base_url(route_to('variant_create_update', $product_id)) ?>" class="btn add_form_btn me-2" type="button">
                    <i class="bx bxs-user-plus"></i> Add Variant
                </a>
                <a href="<?= base_url(route_to('product_manage', $product_id)) ?>" class="btn btn-secondary">Back</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="table-responsive">
                    <table id="variantTable" class="table table-striped table-bordered dt-responsive nowrap table-nowrap align-middle" style="border-collapse: collapse; border-spacing: 0; width: 100%;"></table>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas offcanvas-end offcanvas-product" tabindex="-1" id="viewproduct" aria-labelledby="viewproductLable"></div>
    <script>
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

        function deleteProduct(variant_id) {
            deleteRow({
                    "variant_id": variant_id
                }).then((response) => {
                    fetchTableData({});
                })
                .catch((error) => {
                    console.error("Deletion failed or cancelled:", error);
                });
        }

        function VariantDisplay(variant_id) {
            $.ajax({
                type: "post",
                url: "<?= base_url(route_to("VariantView")) ?>",
                data: {
                    variant_id: variant_id,
                },
                success: function(response) {
                    $("#viewproduct").html("");
                    $("#viewproduct").html(response);
                }
            });
        }


        function successDataTableCallbackFunction(response) {
            var columns = [{
                    title: "SKU Code",
                    data: "variant_sku_code"
                },
                {
                    title: "Variant Name",
                    data: "variant_name"
                },
                {
                    title: "Color",
                    data: "color_name",
                },
                {
                    title: "Size",
                    data: "size_name",
                },
                {
                    title: "Price",
                    data: "selling_price"
                },
                 {
                    title: "COD Cost",
                    data: "cod_charges"
                },
                // {
                //     title: "In Stock",
                //     data: "minimum_stock"
                // },
                {
                    title: "Is Active",
                    data: "is_active",
                    render: function(data, type, row) {
                        var checked = data == 1 ? 'checked' : ''; // Check if data is 1 (true) to set checked attribute
                        var sizes = row.sizes || [];
                        var sizesJson = encodeURIComponent(JSON.stringify(sizes));
                        return `
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="isActiveSwitch_${row.variant_id}" ${checked} onchange="change_is_active(event, ${row.variant_id},'${sizesJson}')">
            </div>`;
                    }
                },

                // {
                //     title: "Default Size",
                //     data: null,
                //     render: function(data, type, row) {
                //         var sizes = row.sizes || [];
                //         var sizesJson = encodeURIComponent(JSON.stringify(sizes));
                //         var dropdown = `<select class="form-select" placeholder="Default Variant" onchange="change_default_size(event, ${row.variant_id}, '${sizesJson}')">`;
                //         dropdown += `<option value="" disabled selected>Select Default Variant</option>`; // Changed value to empty string and added 'selected' attribute
                //         sizes.forEach(function(size) {
                //             var selectedFlag = (row.size_id == size.size_id) ? 'selected' : ''; // Adjusted condition for selected option
                //             dropdown += `<option value="${size.size_id}" ${selectedFlag}>${size.size_name}</option>`;
                //         });
                //         dropdown += `</select>`;
                //         return dropdown;
                //     }
                // },
                {
                    "title": "Actions",
                    "data": null,
                    "render": function(data, type, row) {
                        return `

                          <a href="<?= base_url(route_to('variant_create_update', '')) ?>${row.product_id}/${row.variant_id}" class="btn btn-sm btn-info">
                                <i class="bx bx-edit-alt"></i>
                            </a>
                             <button class="btn btn-primary btn-sm" type="button" onclick="VariantDisplay('${row.variant_id}')" data-bs-toggle="offcanvas" data-bs-target="#viewproduct" aria-controls="viewproduct">
                                <i class="mdi mdi-file-eye-outline"></i>
                            </button>
                          <div class="mt-2 d-none">
                                <input type="checkbox" id="switch9" switch="dark" checked />
                                <label class="form-label" for="switch9" data-on-label="Active" data-off-label="Block"></label>
                            </div>
                        `;
                    }
                }
            ];
            if (response.status == 200) {
                debugger
                var data = JSON.parse(response.data);
                var variants = data[0].variants;
                return {
                    "status": response.status,
                    "columns": columns,
                    "data": variants
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

        // function change_default_size(event, variant_id, sizesJson) {
        //     var sizes = JSON.parse(decodeURIComponent(sizesJson));
        //     console.log('sizes list:', sizes);
        //     var size_ids = [];
        //     sizes.forEach(function(size) {
        //         size_ids.push(size.size_id);
        //     });
        //     var default_size_id = event.target.value;

        //     $.ajax({
        //         type: "POST",
        //         url: "<?= base_url(route_to('variant_update_api')) ?>",
        //         data: {
        //             variant_id: variant_id,
        //             size_id: default_size_id,
        //             sizes: size_ids,
        //             selected_update:true
        //         },
        //         success: function(response) {
        //             if (response.status == 200) {
        //                 toastr.success("Default Size Changed Successfully");
        //             } else {
        //                 toastr.error(response.message);
        //             }
        //         },
        //         error: function(xhr, status, error) {
        //             console.error("AJAX request error:", error);
        //         }
        //     });
        // }

        function change_is_active(event, variant_id, sizesJson) {
            var sizes = JSON.parse(decodeURIComponent(sizesJson));
            var size_ids = sizes.map(function(size) {
                return size.size_id;
            });

            var isChecked = event.target.checked; // Determine if the checkbox is checked or unchecked

            // Toggle the checked state based on the isChecked variable
            $('#isActiveSwitch_' + variant_id).prop('checked', isChecked);

            var is_active = isChecked ? 1 : 0; // Set is_active to 1 if checked, 0 if unchecked

            $.ajax({
                type: "POST",
                url: "<?= base_url(route_to('variant_update_api')) ?>",
                data: {
                    variant_id: variant_id,
                    is_active: is_active,
                    sizes: size_ids,
                    selected_update:true
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
            parameter['product-product_id'] = '<?= $product_id ?>';
            parameter._autojoin = "Y";
            parameter._select = "*";
            parameter._otherFilters = {
                'variants': true,
                'variants_filters': {
                    '_autojoin': 'Y',
                    '_select': '*',
                },
                'sizes': true,
                'sizes_filters': {
                    '_autojoin': 'Y',
                    '_select': '*',
                },
            };
            DataTableInitialized(
                'variantTable', // table_id
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
    </script>