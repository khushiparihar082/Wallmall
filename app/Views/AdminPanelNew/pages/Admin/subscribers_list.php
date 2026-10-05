

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="subscriberListTable" class="table table-striped table-bordered dt-responsive nowrap table-nowrap align-middle table-sm"></table>
        </div>
    </div>
</div>
<div class="offcanvas offcanvas-end offcanvas-product" tabindex="-1" id="subscriberlist" aria-labelledby="subscriberlistLable"></div>
</div>

<div id="showsuccess" style="display:none; color:green;"></div>
<div id="showdanger" style="display:none; color:red;"></div>

<script>
  
    function successCallback(response) {
        if (response.status == 200 || response.status == 201) {
            $(".offcanvas button[data-bs-dismiss='offcanvas']").click();
            fetchTableData({});
        }
    }

    function errorCallback(response) {
        console.log(response);
    }


    function successDataTableCallbackFunction(response) {
        var columns = [{
                title: "ID",
                data: "subscriber_id"
            },
            {
                title: "Email",
                data: "email"
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
            'subscriberListTable',
            "<?= base_url(route_to('subscriber_list_api')) ?>",
            'POST',
            parameter,
            successDataTableCallbackFunction,
        );
    }

    $(document).ready(function() {
        fetchTableData({});
    });
</script>