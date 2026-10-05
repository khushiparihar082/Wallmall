<div class="row">
    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="avatar-sm font-size-20 me-3">
                        <span class="avatar-title bg-soft-primary text-primary rounded">
                            <img src="<?= base_url($_assets_path . 'assets/images/delivery.png') ?>" alt="" class="svg-dashboard-size">
                        </span>
                    </div>
                    <div class="flex-1">
                        <div class="font-size-16 mt-2">Total Delivered</div>
                    </div>
                </div>
                <h4 class="mt-4" id="total_delivered">0</h4>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="avatar-sm font-size-20 me-3">
                        <span class="avatar-title bg-soft-primary text-primary rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="svg-dashboard-size">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                            </svg>
                        </span>
                    </div>
                    <div class="flex-1">
                        <div class="font-size-16 mt-2">Total Pending</div>
                    </div>
                </div>
                <h4 class="mt-4" id="total_pending">0</h4>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="avatar-sm font-size-20 me-3">
                        <span class="avatar-title bg-soft-primary text-primary rounded">
                            <img src="<?= base_url($_assets_path . 'assets/images/delivery.png') ?>" alt="" class="svg-dashboard-size">
                        </span>
                    </div>
                    <div class="flex-1">
                        <div class="font-size-16 mt-2">Not Delivered</div>
                    </div>
                </div>
                <h4 class="mt-4" id="order_not_delivered">0</h4>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="avatar-sm font-size-20 me-3">
                        <span class="avatar-title bg-soft-primary text-primary rounded">
                            <img src="<?= base_url($_assets_path . 'assets/images/delivery.png') ?>" alt="" class="svg-dashboard-size">
                        </span>
                    </div>
                    <div class="flex-1">
                        <div class="font-size-16 mt-2">Exchange Pending</div>
                    </div>
                </div>
                <h4 class="mt-4" id="exchange_pending">0</h4>
            </div>
        </div>
    </div>
</div>
<script>
    function get_delivered_dashboard_data(parameter = {}) {
        $.ajax({
            url: "<?= base_url(route_to('delivered_dashboard_api')) ?>",
            method: 'POST',
            data: parameter,
            success: function(response) {
                if (response.status === 200) {
                    var data = JSON.parse(response.data);
                    $('#total_delivered').text(data.counts.order_delivered) ?? 0
                    $('#total_pending').text(data.counts.pending_orders) ?? 0
                    $('#order_not_delivered').text(data.counts.order_not_delivered) ?? 0
                    $('#exchange_pending').text(data.counts.pending_verification) ?? 0
                    
                }
            },
            error: function(error) {
                console.error("Error fetching data:", error);
            }
        });
    }
    // Fetch and display data on page load
    $(document).ready(function() {
        get_delivered_dashboard_data(); // Existing function to get dashboard data
    });
</script>