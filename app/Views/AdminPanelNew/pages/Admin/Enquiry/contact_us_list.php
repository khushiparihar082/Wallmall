<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>
            ContactUs List
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="table-responsive">
                <table id="contactUsTable" class="table table-striped table-bordered dt-responsive nowrap table-nowrap align-middle" style="border-collapse: collapse; border-spacing: 0; width: 100%;"></table>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="RightSlideBox" aria-labelledby="RightSlideBoxLabel">

</div>

<script>
  

    function successDataTableCallbackFunction(response) {
        var columns = [{
                title: "Name",
                data: "fullname"
            },
            {
                title: "Email",
                data: "email"
            },
            {
                title: "Message",
                data: "message",
              
            },
            {
                title: "Inquiry",
                data: "order_inquiry",
            },
            {
                title: "Date",
                data: "created_at",
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

   

    function fetchTableData(parameter = {}) {
        DataTableInitialized(
            'contactUsTable', // table_id
            "<?= base_url(route_to('contact_list_api')) ?>", // url
            'POST', // method
            parameter, // parameter
            successDataTableCallbackFunction // dataTableSuccessCallBack
        );
    }
    $(document).ready(function() {
        fetchTableData();

    });
</script>