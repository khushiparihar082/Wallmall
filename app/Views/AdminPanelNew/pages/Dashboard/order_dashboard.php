<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="avatar-sm font-size-20 me-3">
                        <span class="avatar-title bg-soft-primary text-primary rounded">
                            <i class="mdi mdi-tag-plus-outline"></i>
                        </span>
                    </div>
                    <div class="flex-1">
                        <div class="font-size-16 mtweekly_sales-2">Today Orders</div>
                    </div>
                </div>
                <h4 class="mt-4" id="today_orders">0</h4>

            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
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
                        <div class="font-size-16 mt-2">Pending Orders</div>
                    </div>
                </div>
                <h4 class="mt-4" id="pending_orders">0</h4>

            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="avatar-sm font-size-20 me-3">
                        <span class="avatar-title bg-soft-primary text-primary rounded">
                            <img src="<?= base_url($_assets_path . 'assets/images/shipped.png') ?>" alt="" class="svg-dashboard-size">
                        </span>
                    </div>
                    <div class="flex-1">
                        <div class="font-size-16 mt-2">Shipped Orders</div>
                    </div>
                </div>
                <h4 class="mt-4" id="shipped_orders">0</h4>

            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="avatar-sm font-size-20 me-3">
                        <span class="avatar-title bg-soft-primary text-primary rounded">
                            <img src="<?= base_url($_assets_path . 'assets/images/delivery.png') ?>" alt="" class="svg-dashboard-size">
                        </span>
                    </div>
                    <div class="flex-1">
                        <div class="font-size-16 mt-2">Delivered Orders</div>
                    </div>
                </div>
                <h4 class="mt-4" id="delivered_orders">0</h4>

            </div>
        </div>
    </div>
    <div class="row">
        <!-- Previous Week Sales Report Column -->
        <div class="col-xl-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Previous Week Sales Report</h4>
                    <div id="sales_weekly" class="apex-charts"></div>
                </div>
            </div>
        </div>

        <!-- Yearly Sales Report Column -->
        <div class="col-xl-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Yearly Sales Report</h4>
                    <div id="sales_yearly" class="apex-charts"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Latest Transactions</h4>

                <div class="table-responsive">
                    <table class="table table-centered" id="order_table">

                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Order Refund To Customer</h4>

                <div class="table-responsive">
                    <table class="table table-centered" id="order_refund_table">

                    </table>
                </div>
            </div>
        </div>
    </div>


    <script>
        function get_order_dashboard_data(parameter = {}) {
            $.ajax({
                url: "<?= base_url(route_to('order_dashboard_api')) ?>",
                method: 'POST',
                data: parameter,
                success: function(response) {
                    debugger
                    if (response.status === 200) {
                        var data = JSON.parse(response.data);
                        $('#today_orders').text(data.today_order_count.total_orders_today) ?? 0;
                        $('#pending_orders').text(data.counts.pending_orders) ?? 0;
                        $('#delivered_orders').text(data.counts.order_delivered) ?? 0;
                        $('#shipped_orders').text(data.counts.delivery_shipped) ?? 0

                        let weeklySales = [];
                        let weeklyLabels = [];

                        if (Array.isArray(data.weekly_sales)) {
                            data.weekly_sales.forEach(item => {
                                weeklySales.push(Number(item.total_sales) || 0);
                                weeklyLabels.push(item.week_name);
                            });
                        }

                        createLineChart(
                            "#sales_weekly",
                            [{
                                name: 'Weekly Sales',
                                data: weeklySales
                            }],
                            weeklyLabels
                        );

                        createLineChart(
                            "#sales_yearly", // The chart container ID
                            [{
                                name: 'Sales',
                                data: data.sales
                            }], // The series data
                            data.years, // The x-axis categories
                            {
                                xAxisTitle: 'Year', // Optional chart customization
                                colors: ['#f46a6a'], // Optional color customization
                                legendPosition: 'bottom' // Optional legend customization
                            }
                        );
                        var columns = [{
                                title: "Date",
                                data: "order_date"
                            },
                            {
                                title: "Order NO.",
                                data: "order_number"
                            },
                            {
                                title: "Customer Name",
                                data: "fullname"
                            }, // Consider mapping customer_id to customer name
                            {
                                title: "Amount",
                                data: "order_total"
                            },
                            {
                                title: "Payment Status",
                                data: "payment_mode"
                            }
                        ];
                        DataTableInitialized('order_table', null, "POST", {}, null, {}, null, data.list_data, columns);

                        var columns = [{
                                title: "Date",
                                data: "order_date"
                            },
                            {
                                title: "Order NO.",
                                data: "order_number"
                            },
                            {
                                title: "Customer Name",
                                data: "fullname"
                            },
                            {
                                title: "Amount",
                                data: "order_total"
                            },
                            {
                                title: "Order Status",
                                data: "order_status"
                            },
                            {
                                title: "Payment Status",
                                data: "payment_mode"
                            }
                        ];
                        DataTableInitialized('order_refund_table', null, "POST", {}, null, {}, null, data.refund_data, columns);
                    }
                },
                error: function(error) {
                    console.error("Error fetching data:", error);
                }
            });
        }
        // Fetch and display data on page load
        $(document).ready(function() {
            get_order_dashboard_data(); // Existing function to get dashboard data
        });
    </script>
    