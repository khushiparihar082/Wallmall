<div class="row">
    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="avatar-sm font-size-20 me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="svg-dashboard-size">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>

                    </div>
                    <div class="flex-1">
                        <div class="font-size-16 mt-2">Total Revenue</div>
                    </div>
                </div>
                <h4 class="mt-4" id="revenue">0</h4>

            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="avatar-sm font-size-20 me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="svg-dashboard-size">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>

                    </div>
                    <div class="flex-1">
                        <div class="font-size-16 mt-2">Pending Refunds</div>
                    </div>
                </div>
                <h4 class="mt-4" id="pending_refund">0</h4>

            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="avatar-sm font-size-20 me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="svg-dashboard-size">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="font-size-16 mt-2">Pending Verify</div>
                    </div>
                </div>
                <h4 class="mt-4" id="pending_verify">0</h4>

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-3">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Overview</h4>

                <div>
                    <div class="pb-3 border-bottom">
                        <a href="" class="row align-items-center">
                            <div class="col-8">
                                <p class="mb-2 text-secondary">Incoming</p>
                                <h4 class="mb-0" id="incoming">0</h4>
                            </div>
                        
                        </a>
                    </div>
                    <div class="py-3 border-bottom">
                        <a href="" class="row align-items-center">
                            <div class="col-8">
                                <p class="mb-2 text-secondary">Outgoing</p>
                                <h4 class="mb-0" id="outgoing">0</h4>
                            </div>
                            
                        </a>
                    </div>
                    <div class="pt-3">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <p class="mb-2">Revenue</p>
                                <h4 class="mb-0" id="total_revenue">0</h4>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Second Card (Sales Report) -->
    <div class="col-xl-9 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Sales Report</h4>
                <div id="sales-monthly" class="apex-charts"></div>
            </div>
        </div>
    </div>
</div>
<script>
    function get_finance_dashboard_data(parameter = {}) {
        $.ajax({
            url: "<?= base_url(route_to('finance_dashboard_api')) ?>",
            method: 'POST',
            data: parameter,
            success: function(response) {
                if (response.status === 200) {
                    var data = JSON.parse(response.data);
                    if (data.revenue < 0) {
                        $('#total_revenue').text(data.revenue).css('color', 'red'); // Set the text color to red for negative values
                    } else {
                        $('#total_revenue').text(data.revenue).css('color', 'black'); // Reset the color for positive or zero values
                    }
                    if (data.revenue < 0) {
                        $('#revenue').text(data.revenue).css('color', 'red'); // Set the text color to red for negative values
                    } else {
                        $('#revenue').text(data.revenue).css('color', 'black'); // Reset the color for positive or zero values
                    }
                    $('#incoming').text(data.total_order_amount) ?? 0;
                    $('#outgoing').text(data.total_return_amount) ?? 0;
                    $('#pending_verify').text(data.counts.pending_verification) ?? 0
                    $('#pending_refund').text(data.counts.pending_refund) ?? 0
                    
                    createLineChart(
                        "#sales-monthly", // The chart container ID
                        [{
                            name: 'Sales',
                            data: data.sales
                        }], // The series data
                        data.months, // The x-axis categories
                        {
                            xAxisTitle: 'Month', // Optional chart customization
                            colors: ['#f46a6a'], // Optional color customization
                            legendPosition: 'bottom' // Optional legend customization
                        }
                    );
                }
            },
            error: function(error) {
                console.error("Error fetching data:", error);
            }
        });
    }
    // Fetch and display data on page load
    $(document).ready(function() {
        get_finance_dashboard_data(); // Existing function to get dashboard data
    });
</script>