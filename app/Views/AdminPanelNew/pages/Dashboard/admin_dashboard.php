<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<div class="row">
    <div class="col-xl-3">
        <div class="card bg-primary">
            <div class="card-body">
                <div class="text-white-50">
                    <h5 class="text-white"><span id="user_count"></span> + New Users</h5>
                    <div>
                        <a href="<?= base_url(route_to('customer_list')) ?>" class="btn btn-outline-success btn-sm">View more</a>
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-8">
                        <div class="mt-4">
                            <img src="<?= base_url($_assets_path . 'assets/images/widget-img.png') ?>" alt="widget-img" class="img-fluid mx-auto d-block">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-9">
        <div class="row">
            <!-- First Row -->
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
                                <div class="font-size-16 mt-2">New Orders</div>
                            </div>
                        </div>
                        <h4 class="mt-4" id="new_orders">0</h4>

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
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
                                    </svg>
                                </span>
                            </div>
                            <div class="flex-1">
                                <div class="font-size-16 mt-2">Pending Refund</div>
                            </div>
                        </div>
                        <h4 class="mt-4" id="pending_verification">0</h4>

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
                                <div class="font-size-16 mt-2">Pending Orders</div>
                            </div>
                        </div>
                        <h4 class="mt-4" id="pending_orders">0</h4>

                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <div class="avatar-sm font-size-20 me-3">
                                <span class="avatar-title bg-soft-primary text-primary rounded">
                                    <img src="<?= base_url($_assets_path . 'assets/images/shipped.png') ?>" alt="" class="svg-dashboard-size">
                                </span>
                            </div>
                            <div class="flex-1">
                                <div class="font-size-16 mt-2">Order Shipped</div>
                            </div>
                        </div>
                        <h4 class="mt-4" id="order_shipped">0</h4>

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
                                <div class="font-size-16 mt-2">Order Delivered</div>
                            </div>
                        </div>
                        <h4 class="mt-4" id="order_delivered">0</h4>

                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <div class="avatar-sm font-size-20 me-3">
                                <span class="avatar-title bg-soft-primary text-primary rounded">
                                    <i class="mdi mdi-account-multiple-outline"></i>
                                </span>
                            </div>
                            <div class="flex-1">
                                <div class="font-size-16 mt-2">Not Delivered</div>
                            </div>
                        </div>
                        <h4 class="mt-4" id="order_not_delivered">00</h4>
                    </div>
                </div>
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
                        <a href="<?= base_url(route_to('wishlist_list')) ?>" class="row align-items-center">
                            <div class="col-8">
                                <p class="mb-2 text-secondary">New Visitors</p>
                                <h4 class="mb-0" id="new_visitors">0</h4>
                            </div>

                        </a>
                    </div>
                    <div class="py-3 border-bottom">
                        <a href="<?= base_url(route_to('cart_list')) ?>" class="row align-items-center">
                            <div class="col-8">
                                <p class="mb-2 text-secondary">Product Wishlists</p>
                                <h4 class="mb-0" id="product_wishlist">0</h4>
                            </div>

                        </a>
                    </div>
                    <div class="pt-3">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <p class="mb-2">Revenue</p>
                                <h4 class="mb-0" id="revenue">0</h4>
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
                <h4 class="card-title mb-4">Monthly Sales Report</h4>
                <div id="sales-monthly" class="apex-charts"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Inbox</h4>

                <ul class="inbox-wid list-unstyled" id="inbox_box">


                </ul>

                <div class="text-center">
                    <a href=" <?= base_url(route_to('contact_us_list')) ?>" class="btn btn-primary btn-sm">Load more</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8">
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
</div>


<div class="row">
    <div class="col-xl-5">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Overall Sales Analytics</h4>

                <div class="row align-items-center">
                    <div class="col-sm-7">
                        <div id="incoming-outgoing-chart" class="apex-charts"></div>
                    </div>
                    <div class="col-sm-5">
                        <div>
                            <div class="row">
                                <div class="col-6 col-md-12">
                                    <div class="py-3">
                                        <p class="mb-1 text-truncate"><i class="mdi mdi-circle text-success me-1"></i> Incoming
                                        </p>
                                        <h5 id="incoming">0</h5>
                                    </div>
                                </div>
                                <div class="col-6 col-md-12">
                                    <div class="py-3">
                                        <p class="mb-1 text-truncate"><i class="mdi mdi-circle text-danger me-1"></i>
                                            Outgoing</p>
                                        <h5 id="outgoing">0</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-7">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Monthly Reviews</h4>
                <div class="mb-4">
                    <h5><span class="text-primary">500</span>+ Satisfied clients</h5>
                </div>
                <div class="mb-3">
                    <i class="fas fa-quote-left h4 text-primary"></i>
                </div>
                <div id="review_slider" class="carousel slide review-carousel" data-ride="carousel">
                    <div class="carousel-inner" id="review_box">

                    </div>
                    <a class="carousel-control-prev" href="#review_slider" role="button" data-bs-slide="prev">
                        <i class="mdi mdi-chevron-left carousel-control-icon"></i>
                    </a>
                    <a class="carousel-control-next" href="#review_slider" role="button" data-bs-slide="next">
                        <i class="mdi mdi-chevron-right carousel-control-icon"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-5">
        <div class="card">
            <div class="card-body">

                <!-- Title + View All -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Overall Visit Analytics</h4>
                    <div class="d-flex align-items-center gap-2">
                        <a href="<?= base_url(route_to('share_reference_detail')) ?>">
                        <span class="small">View All</span>
                        </a>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                </div>

                <!-- Top Traffic Sources -->
                <p class="small fw-semibold mb-3">Top Traffic Sources</p>

                <div class="d-flex flex-column">

                    <!-- Direct -->
                    <div class="d-flex justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <!-- Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="26" height="26" x="0" y="0" viewBox="0 0 479.447 479.447" style="enable-background:new 0 0 512 512" xml:space="preserve" class="hovered-paths">
                                <g>
                                    <path d="M239.446.022c-8.594 0-17.182.462-25.727 1.383-7.832.8-15.568 2.112-23.2 3.704a219.68 219.68 0 0 0-4.432.976A239.735 239.735 0 0 0 67.831 72.301a257.357 257.357 0 0 0-8.8 9.488c-87.06 99.948-76.612 251.548 23.337 338.608 95.688 83.349 239.723 77.803 328.719-12.656a248.136 248.136 0 0 0 8.8-9.488 239.597 239.597 0 0 0 59.56-158.232c0-132.549-107.452-240-240.001-239.999zM78.495 84.301c1.264-1.312 2.576-2.568 3.864-3.84 1.488-1.464 2.968-2.936 4.488-4.352 1.336-1.248 2.712-2.448 4.08-3.664 1.544-1.368 3.08-2.736 4.664-4.056 1.392-1.176 2.824-2.304 4.248-3.44 1.6-1.28 3.2-2.56 4.848-3.792a154.97 154.97 0 0 1 4.424-3.2c1.656-1.184 3.32-2.4 5.008-3.504a214.122 214.122 0 0 1 4.576-3 166.785 166.785 0 0 1 5.168-3.2 260.346 260.346 0 0 1 10.056-5.704c1.6-.853 3.2-1.688 4.8-2.504a233.35 233.35 0 0 1 5.512-2.68c1.6-.76 3.264-1.52 4.912-2.24 1.88-.8 3.784-1.6 5.688-2.4 1.656-.68 3.304-1.344 4.976-1.984 1.936-.736 3.896-1.424 5.856-2.112a248.54 248.54 0 0 1 5.04-1.72c1.992-.64 4-1.232 6.016-1.816 1.688-.488 3.36-.992 5.056-1.448.648-.168 1.296-.304 1.944-.472a198.501 198.501 0 0 0-51.128 83.024 268.7 268.7 0 0 1-54.816-21.096c.264-.28.488-.56.72-.8zm-11.504 12.88a277.951 277.951 0 0 0 60.712 24.16 415.133 415.133 0 0 0-16.152 110.68h-95.92a223.516 223.516 0 0 1 51.36-134.84zm0 285.68a223.545 223.545 0 0 1-51.36-134.84h95.92a415.093 415.093 0 0 0 16.152 110.68 278.14 278.14 0 0 0-60.712 24.16zm114.736 73.568c-1.616-.408-3.288-.936-4.952-1.424-2.024-.592-4.056-1.184-6.056-1.832-1.688-.544-3.352-1.128-5.016-1.712a190.556 190.556 0 0 1-5.88-2.12 219.712 219.712 0 0 1-4.952-1.968c-1.912-.8-3.824-1.6-5.72-2.4a208.937 208.937 0 0 1-4.872-2.224c-1.864-.88-3.72-1.776-5.6-2.704-1.6-.8-3.2-1.6-4.8-2.472-1.808-.968-3.6-1.96-5.392-2.984-1.6-.888-3.12-1.8-4.664-2.728a195.557 195.557 0 0 1-5.216-3.256c-1.52-.968-3.04-1.952-4.536-2.96a221.149 221.149 0 0 1-5.064-3.552c-1.464-1.048-2.928-2.096-4.368-3.2a206.328 206.328 0 0 1-4.896-3.832c-1.416-1.128-2.824-2.248-4.208-3.408-1.6-1.328-3.144-2.712-4.696-4.088-1.36-1.208-2.728-2.4-4.056-3.632-1.528-1.424-3.008-2.904-4.496-4.368-1.288-1.272-2.6-2.528-3.864-3.832-.232-.248-.456-.504-.688-.744a268.507 268.507 0 0 1 54.816-21.104 198.55 198.55 0 0 0 51.128 83.024c-.648-.168-1.304-.304-1.952-.48zm49.72 6.96c-34.232-4.864-64.24-40.592-83.12-93.352a406.55 406.55 0 0 1 83.12-9.784v103.136zm0-119.136a421.293 421.293 0 0 0-88.144 10.512 400.211 400.211 0 0 1-15.752-106.744h103.896v96.232zm0-112.232H127.551a400.13 400.13 0 0 1 15.752-106.744 421.434 421.434 0 0 0 88.144 10.512v96.232zm0-112.232a406.124 406.124 0 0 1-83.12-9.784c18.88-52.76 48.888-88.488 83.12-93.352v103.136zm180.456-22.608a223.545 223.545 0 0 1 51.36 134.84h-95.92a415.093 415.093 0 0 0-16.152-110.68 278.24 278.24 0 0 0 60.712-24.16zm-114.8-73.576c1.68.416 3.352.944 5.016 1.432 2.024.592 4.056 1.184 6.056 1.832 1.688.544 3.352 1.128 5.016 1.712 1.968.68 3.936 1.376 5.88 2.12 1.664.632 3.304 1.296 4.952 1.968 1.912.8 3.824 1.6 5.72 2.4 1.632.72 3.256 1.461 4.872 2.224 1.864.88 3.72 1.776 5.6 2.704 1.6.8 3.2 1.6 4.8 2.472 1.808.968 3.6 1.96 5.392 2.984 1.6.888 3.12 1.8 4.664 2.728a195.557 195.557 0 0 1 5.216 3.256c1.52.968 3.04 1.952 4.536 2.96a220.35 220.35 0 0 1 5.056 3.544 185.57 185.57 0 0 1 4.384 3.2c1.648 1.24 3.264 2.528 4.888 3.824 1.408 1.12 2.824 2.24 4.208 3.408 1.6 1.328 3.144 2.712 4.696 4.088 1.36 1.208 2.728 2.4 4.056 3.632 1.528 1.424 3.008 2.904 4.496 4.368 1.288 1.272 2.6 2.528 3.864 3.832.232.248.456.504.688.744a268.507 268.507 0 0 1-54.816 21.104 198.54 198.54 0 0 0-51.192-83.016c.648.168 1.304.304 1.952.48zm-49.656-6.952c34.232 4.864 64.24 40.592 83.12 93.352a406.55 406.55 0 0 1-83.12 9.784V16.653zm0 119.136a421.293 421.293 0 0 0 88.144-10.512 400.211 400.211 0 0 1 15.752 106.744H247.447v-96.232zm0 112.232h103.896a400.13 400.13 0 0 1-15.752 106.744 421.426 421.426 0 0 0-88.144-10.512v-96.232zm0 215.368V360.253c27.97.39 55.824 3.669 83.12 9.784-18.88 52.76-48.888 88.488-83.12 93.352zm152.952-67.648c-1.264 1.304-2.568 2.56-3.856 3.832-1.488 1.464-2.976 2.944-4.504 4.368-1.328 1.24-2.696 2.4-4.056 3.64-1.552 1.376-3.096 2.752-4.68 4.08-1.4 1.168-2.824 2.296-4.248 3.432-1.6 1.28-3.2 2.56-4.848 3.792a154.97 154.97 0 0 1-4.424 3.2c-1.656 1.184-3.32 2.4-5.008 3.504a186.92 186.92 0 0 1-4.576 2.992 158.284 158.284 0 0 1-5.176 3.2c-1.6.936-3.128 1.848-4.704 2.752a238.159 238.159 0 0 1-10.144 5.456 233.35 233.35 0 0 1-5.512 2.68c-1.6.76-3.264 1.52-4.912 2.24-1.88.8-3.784 1.6-5.688 2.4-1.656.672-3.304 1.344-4.968 1.976-1.952.744-3.912 1.44-5.88 2.12a205.317 205.317 0 0 1-5.016 1.712c-2 .648-4 1.24-6.04 1.824-1.672.496-3.352.992-5.04 1.448-.648.168-1.296.304-1.944.472a198.501 198.501 0 0 0 51.128-83.024 268.7 268.7 0 0 1 54.816 21.096c-.264.288-.488.568-.72.808zm11.504-12.88a277.951 277.951 0 0 0-60.712-24.16 415.133 415.133 0 0 0 16.152-110.68h95.92a223.512 223.512 0 0 1-51.36 134.84z" fill="#000000" opacity="1" data-original="#000000" class="hovered-path"></path>
                                </g>
                            </svg>
                            <span class="fs-5">Direct</span>
                        </div>
                        <span class="fs-5" id="direct_count">0</span>
                    </div>

                    <!-- Facebook -->
                    <div class="d-flex justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="26" height="26" x="0" y="0" viewBox="0 0 176 176" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                <g>
                                    <g data-name="Layer 2">
                                        <g data-name="01.facebook">
                                            <circle cx="88" cy="88" r="88" fill="#3a559f" opacity="1" data-original="#3a559f" class=""></circle>
                                            <path fill="#ffffff" d="m115.88 77.58-1.77 15.33a2.87 2.87 0 0 1-2.82 2.57h-16l-.08 45.45a2.05 2.05 0 0 1-2 2.07H77a2 2 0 0 1-2-2.08V95.48H63a2.87 2.87 0 0 1-2.84-2.9l-.06-15.33a2.88 2.88 0 0 1 2.84-2.92H75v-14.8C75 42.35 85.2 33 100.16 33h12.26a2.88 2.88 0 0 1 2.85 2.92v12.9a2.88 2.88 0 0 1-2.85 2.92h-7.52c-8.13 0-9.71 4-9.71 9.78v12.81h17.87a2.88 2.88 0 0 1 2.82 3.25z" opacity="1" data-original="#ffffff"></path>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                            <span class="fs-5">Facebook</span>
                        </div>
                        <span class="fs-5" id="facebook_count">0</span>
                    </div>

                    <!-- Whatsapp -->
                    <div class="d-flex justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="26" height="26" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                <g>
                                    <path d="M256.064 0h-.128C114.784 0 0 114.816 0 256c0 56 18.048 107.904 48.736 150.048l-31.904 95.104 98.4-31.456C155.712 496.512 204 512 256.064 512 397.216 512 512 397.152 512 256S397.216 0 256.064 0z" style="" fill="#4caf50" data-original="#4caf50" class=""></path>
                                    <path d="M405.024 361.504c-6.176 17.44-30.688 31.904-50.24 36.128-13.376 2.848-30.848 5.12-89.664-19.264-75.232-31.168-123.68-107.616-127.456-112.576-3.616-4.96-30.4-40.48-30.4-77.216s18.656-54.624 26.176-62.304c6.176-6.304 16.384-9.184 26.176-9.184 3.168 0 6.016.16 8.576.288 7.52.32 11.296.768 16.256 12.64 6.176 14.88 21.216 51.616 23.008 55.392 1.824 3.776 3.648 8.896 1.088 13.856-2.4 5.12-4.512 7.392-8.288 11.744-3.776 4.352-7.36 7.68-11.136 12.352-3.456 4.064-7.36 8.416-3.008 15.936 4.352 7.36 19.392 31.904 41.536 51.616 28.576 25.44 51.744 33.568 60.032 37.024 6.176 2.56 13.536 1.952 18.048-2.848 5.728-6.176 12.8-16.416 20-26.496 5.12-7.232 11.584-8.128 18.368-5.568 6.912 2.4 43.488 20.48 51.008 24.224 7.52 3.776 12.48 5.568 14.304 8.736 1.792 3.168 1.792 18.048-4.384 35.52z" style="" fill="#fafafa" data-original="#fafafa"></path>
                                </g>
                            </svg>
                            <span class="fs-5">Whatsapp</span>
                        </div>
                        <span class="fs-5" id="whatsapp_count">0</span>
                    </div>

                    <!-- Twitter -->
                    <div class="d-flex justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="26" height="26" x="0" y="0" viewBox="0 0 1227 1227" style="enable-background:new 0 0 512 512" xml:space="preserve" class="hovered-paths">
                                <g>
                                    <path d="M613.5 0C274.685 0 0 274.685 0 613.5S274.685 1227 613.5 1227 1227 952.315 1227 613.5 952.315 0 613.5 0z" fill="#000000" opacity="1" data-original="#000000" class="hovered-path"></path>
                                    <path fill="#ffffff" d="m680.617 557.98 262.632-305.288h-62.235L652.97 517.77 470.833 252.692H260.759l275.427 400.844-275.427 320.142h62.239l240.82-279.931 192.35 279.931h210.074L680.601 557.98zM345.423 299.545h95.595l440.024 629.411h-95.595z" opacity="1" data-original="#ffffff" class=""></path>
                                </g>
                            </svg>
                            <span class="fs-5">Twitter</span>
                        </div>
                        <span class="fs-5" id="twitter_count">0</span>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>



<script>
    function get_admin_dashboard_data(parameter = {}) {
        $.ajax({
            url: "<?= base_url(route_to('admin_dashboard_api')) ?>",
            method: 'POST',
            data: parameter,
            success: function(response) {
                if (response.status === 200) {
                    var data = JSON.parse(response.data);
                    $('#new_orders').text(data.counts.new_orders) ?? 0;
                    $('#new_customers').text(data.counts.new_customers) ?? 0;
                    $('#pending_verification').text(data.counts.pending_verification) ?? 0;
                    $('#pending_approval').text(data.counts.pending_approval) ?? 0;
                    $('#pending_orders').text(data.counts.pending_orders) ?? 0;
                    $('#ready_shipped').text(data.counts.ready_to_shipped) ?? 0;
                    $('#order_shipped').text(data.counts.delivery_shipped) ?? 0;
                    $('#order_delivered').text(data.counts.order_delivered) ?? 0;
                    $('#order_not_delivered').text(data.counts.order_not_delivered) ?? 0;
                    // Update the revenue text and apply color based on the value
                    if (data.revenue < 0) {
                        $('#revenue').text(data.revenue).css('color', 'red'); // Set the text color to red for negative values
                    } else {
                        $('#revenue').text(data.revenue).css('color', 'black'); // Reset the color for positive or zero values
                    }

                    $('#product_wishlist').text(data.total_product_count_sum) ?? 0;
                    $('#new_visitors').text(data.total_visitor_count_sum) ?? 0;
                    $('#user_count').text(data.user_data_count) ?? 0;
                    // $('#review').text() ?? 0;
                    $('#customer_name').text(data.fullname) ?? 0;
                    $('#product_name').text(data.product_name) ?? 0;
                    $('#incoming').text(data.total_order_amount) ?? 0;
                    $('#outgoing').text(data.total_refund_amount) ?? 0;
                    $('#whatsapp_count').text(data.source_count.whatsapp_total_customer_search_count) ?? 0;
                    $('#twitter_count').text(data.source_count.twitter_total_customer_search_count) ?? 0;
                    $('#facebook_count').text(data.source_count.facebook_total_customer_search_count) ?? 0;
                    $('#direct_count').text(data.source_count.direct_total_customer_search_count) ?? 0;
                    var incoming = data.total_order_amount;
                    var outgoing = data.total_refund_amount;
                    updateChart(incoming, outgoing);
                    // Update the chart with the months and sales data
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
                    var review_box = ``;

                    // foreach on javascript array
                    data.customer_review.forEach(function(review, index) {
                        var firstLetter = review.fullname.charAt(0).toUpperCase();

                        // ⭐ Generate star rating HTML
                        var rating = parseInt(review.customer_rating || 0);
                        var starsHtml = '';
                        for (var i = 1; i <= 5; i++) {
                            if (i <= rating) {
                                starsHtml += `<i class="fa fa-star text-warning"></i>`; // filled star
                            } else {
                                starsHtml += `<i class="fa fa-star text-muted"></i>`; // empty star
                            }
                        }

                        review_box += `
        <div class="carousel-item ${index == 0 ? 'active' : ''}">
            <div>
                <p id="review_text">${review.customer_review}</p>

                <!-- ⭐ Rating stars -->
                <div class="mb-2" id="review_rating">${starsHtml}</div>

                <div class="d-flex align-items-start mt-4">
                    <div class="avatar-sm me-3">
                        <span class="avatar-title bg-soft-primary text-primary rounded-circle">
                            ${firstLetter}
                        </span>
                    </div>
                    <div class="flex-1">
                        <h5 class="font-size-16 mb-1" id="customer_name">${review.fullname}</h5>
                        <p class="mb-2" id="product_name">${review.product_name}</p>
                    </div>
                </div>
            </div>
        </div>
    `;
                    });

                    $('#review_box').html(review_box);

                    var inbox_box = ``;
                    data.inbox_data.forEach(function(inbox) {
                        inbox_box += `

                    <li class="inbox-list-item">
                        <a href="javascript: void(0);">
                            <div class="d-flex align-items-start">
                                <div class="me-3 align-self-center">
                                    <img src="<?= base_url($_assets_path . 'assets/images/the-hillmen-logo.png') ?>" alt="avatar-3" class="avatar-sm rounded-circle">
                                </div>
                                <div class="flex-1 overflow-hidden">
                                    <h5 class="font-size-16 mb-1">${inbox.fullname}</h5>
                                    <p class="text-truncate mb-0">${inbox.message}</p>
                                </div>
                                <div class="font-size-12 ms-auto">
                    ${inbox.order_inquiry}
                                </div>
                            </div>
                        </a>
                    </li>
                    `;
                    })
                    $('#inbox_box').html('');
                    $('#inbox_box').html(inbox_box);
                }
            },
            error: function(error) {
                console.error("Error fetching data:", error);
            }
        });
    }

    function updateChart(incoming, outgoing) {
        var options = {
            series: [incoming, outgoing], // Pass the validated amounts
            chart: {
                height: 200,
                type: 'donut',
            },
            labels: ["Incoming", "Outgoing"],
            plotOptions: {
                pie: {
                    donut: {
                        size: '25%'
                    }
                }
            },
            legend: {
                show: false,
            },
            colors: ['#45cb85', '#ff715b'],
        };

        var chart = new ApexCharts(document.querySelector("#incoming-outgoing-chart"), options);
        chart.render();
    }

    // Fetch and display data on page load
    $(document).ready(function() {
        get_admin_dashboard_data(); // Existing function to get dashboard data
    });
</script>