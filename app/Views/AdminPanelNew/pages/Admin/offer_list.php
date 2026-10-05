<div class="card">
    <div class="card-body">
        <div class="offcanvas-header mb-3 d-flex justify-content-between align-items-center">
            <h4>
                Offer List
            </h4>
            <div>
                <a href="<?= base_url(route_to('create_offer')) ?>" class="btn add_form_btn" type="button">
                    <i class="bx bxs-user-plus"></i> Add offer
                </a>
                <a href="<?= base_url(route_to('offer_list')) ?>" class="btn btn-secondary">Back</a>
            </div>
        </div>
        <div class="table-responsive">
            <div class="table-responsive">
                <table id="offerTable" class="table table-striped table-bordered dt-responsive nowrap table-nowrap align-middle table-sm"></table>
            </div>
        </div>

        <div class="offcanvas offcanvas-end" tabindex="-1" id="viewproduct">
    <div class="offcanvas-header">
        <h5>Offer Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <p><strong>Offer Name:</strong> <span id="view_offer_name"></span></p>
        <p><strong>Offer Title:</strong> <span id="view_offer_title"></span></p>
        <p><strong>Offer Type:</strong> <span id="view_offer_type"></span></p>
        <p><strong>Offer From:</strong> <span id="view_offer_from"></span></p>
        <p><strong>Offer To:</strong> <span id="view_offer_to"></span></p>
        <p><strong>Discount:</strong> <span id="view_offer_discount"></span></p>
        <p><strong>Status:</strong> <span id="view_is_active"></span></p>
    </div>
</div>
    </div>
</div>

</div>


<script>
    var DeleteApiUrl = "<?= base_url(route_to('offer_delete_api')) ?>"

    function successCallback(response) {
        if (response.status == 200 || response.status == 201) {
            fetchTableData({});
        }
    }

    function errorCallback(response) {
        console.log(response);
    }

    function deleteProduct(offer_id) {
        deleteRow({
                "offer_id": offer_id
            }).then((response) => {
                fetchTableData({});
            })
            .catch((error) => {
                console.error("Deletion failed or cancelled:", error);
            });
    }


    function successDataTableCallbackFunction(response) {
        var columns = [{
                title: "Offer Name",
                data: "offer_name"
            },
            {
                title: "Offer Title",
                data: "offer_title"
            },
            {
                title: "Offer Type",
                data: "offer_type"
            },

            {
                title: "Offer From",
                data: "offer_from",
                render: function(data, type, row) {
                    var date = new Date(data);
                    var options = {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    };
                    return date.toLocaleDateString('en-GB', options);
                }
            },
            {
                title: "Offer To",
                data: "offer_to",
                render: function(data, type, row) {
                    var date = new Date(data);
                    var options = {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    };
                    return date.toLocaleDateString('en-GB', options);
                }
            },
            {
                title: "Discount",
                data: "offer_discount"
            },
            {
                title: "Is Active",
                data: "is_active",
                render: function(data, type, row) {
                    var checked = data == 1 ? 'checked' : '';
                    return `
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="isActiveSwitch_${row.offer_id}" ${checked} onchange="change_is_active(event, ${row.offer_id})">
            </div>`;
                }
            },
            {
                "title": "Actions",
                "data": null,
                "render": function(data, type, row) {
                    return `
                            <a href="<?= base_url(route_to('offer_items', '')) ?>/${row.offer_id}" class="btn btn-primary">
                                Add Offer Products
                            </a>
                           <button class="btn btn-primary btn-sm" type="button"
    onclick='OfferDisplay(${JSON.stringify(row)})'
    data-bs-toggle="offcanvas" data-bs-target="#viewproduct">
    <i class="mdi mdi-file-eye-outline"></i>
</button>
  <a class="btn btn-sm btn-info" href="<?= base_url(route_to('create_offer')) ?>/${row.offer_id }" >
                                <i class="bx bx-edit-alt"></i>
                            </a>
                             <button class="btn btn-sm btn-danger" onclick="deleteProduct(${row.offer_id })">
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
            "<?= base_url(route_to('offer_list_api')) ?>", // url
            'POST', {}, successDataTableCallbackFunction, {},
        );
    }

    function change_is_active(event, offer_id) {

        var isChecked = event.target.checked; // Determine if the checkbox is checked or unchecked

        // Toggle the checked state based on the isChecked variable
        $('#isActiveSwitch_' + offer_id).prop('checked', isChecked);

        var is_active = isChecked ? 1 : 0; // Set is_active to 1 if checked, 0 if unchecked

        $.ajax({
            type: "POST",
            url: "<?= base_url(route_to('offer_update_api')) ?>",
            data: {
                offer_id: offer_id,
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
    function OfferDisplay(row) {
    console.log(row); // debugging ke liye

    $('#view_offer_name').text(row.offer_name);
    $('#view_offer_title').text(row.offer_title);
    $('#view_offer_type').text(row.offer_type);
    $('#view_offer_from').text(formatDate(row.offer_from));
    $('#view_offer_to').text(formatDate(row.offer_to));
    $('#view_offer_discount').text(row.offer_discount);

    $('#view_is_active').text(row.is_active == 1 ? 'Active' : 'Inactive');
}

// date format function (reuse)
function formatDate(dateStr) {
    var date = new Date(dateStr);
    return date.toLocaleDateString('en-GB', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}
</script>