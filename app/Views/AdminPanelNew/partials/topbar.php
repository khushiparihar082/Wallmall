<header id="page-topbar">
    <div class="navbar-header">
        <div class="container-fluid">
            <div class="float-end">

                <div class="dropdown d-inline-block d-lg-none ms-2">
                    <button type="button" class="btn header-item noti-icon waves-effect"
                        id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="mdi mdi-magnify"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-search-dropdown">

                        <form class="p-3">
                            <div class="m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="<?= lang('Files.Search') ?>"
                                        aria-label="Recipient's username">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit"><i
                                                class="mdi mdi-magnify"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="dropdown d-none d-lg-inline-block ms-1">
                    <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                        <i class="mdi mdi-fullscreen"></i>
                    </button>
                </div>

                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item noti-icon waves-effect"
                        id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="mdi mdi-bell-outline"></i>
                        <?php if (isset($_notification_count) && $_notification_count > 0) : ?>
                            <span class="badge rounded-pill bg-danger"><?= $_notification_count ?></span>
                        <?php endif; ?>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-notifications-dropdown">

                        <!-- HEADER -->
                        <div class="p-3 border-bottom">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 class="m-0"><?= lang('Files.Notifications') ?></h6>
                            </div>
                        </div>

                        <!-- NOTIFICATION LIST -->
                        <div data-simplebar style="max-height: 230px;">
                            <?php if (!empty($_notifications)) : ?>
                                <?php foreach ($_notifications as $notification) : ?>

                                    <div class="notification-item px-1 py-1 border-bottom">
                                        <div class="d-flex align-items-start justify-content-between">

                                            <!-- LEFT CONTENT -->
                                            <a href="<?= $notification['url'] ?>" class="text-reset d-flex flex-grow-1">
                                                <div class="avatar-xs me-3">
                                                    <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                        <i class="bx bx-cart"></i>
                                                    </span>
                                                </div>

                                                <div class="flex-1">
                                                    <h6 class="mt-0 mb-1"><?= esc($notification['title']) ?></h6>
                                                    <p class="mb-1 text-muted font-size-12">
                                                        <?= esc($notification['body']) ?>
                                                    </p>
                                                    <p class="mb-0 text-muted font-size-11">
                                                        <i class="mdi mdi-clock-outline"></i>
                                                        <?= $notification['created_at'] ?>
                                                    </p>
                                                </div>
                                            </a>

                                            <!-- DELETE BUTTON -->
                                            <button
                                                class="btn btn-sm btn-link text-danger notification-delete-btn ms-2"
                                                data-id="<?= $notification['firebase_messaging_notification_id'] ?>">
                                                <i class="mdi mdi-close font-size-16"></i>
                                            </button>

                                        </div>
                                    </div>

                                <?php endforeach; ?>
                            <?php else : ?>
                                <p class="text-center p-3 text-muted mb-0">Not Found Any Notification</p>
                            <?php endif; ?>
                        </div>

                    </div>

                </div>
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <!-- <img class="rounded-circle header-profile-user"
                            src="</?= base_url($_assets_path . $_user_image_url) ?>" alt="Header Avatar"> -->
                        <span class="d-none d-xl-inline-block ms-1"><?= @$_user_name ?></span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item text-danger" href="<?= base_url(route_to('admin_logout_page')) ?>"><i
                                class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
                            <?= lang('Files.Logout') ?></a>
                    </div>
                </div>
            </div>
            <div>

                <button type="button" class="btn btn-sm px-3 font-size-16 header-item toggle-btn waves-effect"
                    id="vertical-menu-btn">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
            </div>
        </div>
    </div>
</header>

<script>
    $(document).on('click', '.notification-delete-btn', function() {
        var notificationId = $(this).data('id');


        $.ajax({
            type: "POST",
            url: "<?= base_url(route_to('deleteNotification')) ?>",
            data: {
                notification_id: notificationId

            },
            success: function(response) {
                if (response.status == 200) {
                    toastr.success("Delete Successfully");
                    window.location.reload();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX request error:", error);
            }
        });
    });
    function updateNotificationCount() {
    let count = $('.notification-item-wrapper').length;

    if (count === 0) {
        $('#notification-container').html(
            '<p class="text-center p-3 text-muted">Not Found Any Notification</p>'
        );
    }

    $('.notification-count').text(count);
}
</script>