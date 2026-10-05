<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div class="h-100">

        <!-- <div class="user-wid text-center py-4">
            <div class="user-img">
                <img src="<//?= base_url($_assets_path . $_user_image_url) ?>" alt=""
                    class="avatar-md mx-auto rounded-circle">
            </div>

            <div class="mt-3">
                <a href="javascript: void(0);" class="text-body fw-medium font-size-16"><//?= @$_user_name ?></a>
                <p class="text-muted mt-1 mb-0 font-size-13"><//?= @$_role_name ?></p>
            </div>
        </div> -->

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <div class="navbar-brand-box p-0 m-0">
                    <a href="/" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="<?= base_url($_assets_path . 'assets/images/the-hillmen-logo.png') ?>" alt="logo" height="20">
                        </span>
                        <span class="logo-lg">
                            <img src="<?= base_url($_assets_path . 'assets/images/the-hillmen-logo.png') ?>" alt="logo" height="60">
                        </span>
                    </a>

                    <a href="/" class="logo logo-light">
                    <span class="logo-sm">
                            <img src="<?= base_url($_assets_path . 'assets/images/the-hillmen-logo.png') ?>" alt="logo" height="20">
                        </span>
                        <span class="logo-lg">
                            <img src="<?= base_url($_assets_path . 'assets/images/the-hillmen-logo.png') ?>" alt="logo" height="60">
                        </span>
                    </a>
                </div>

                <?php foreach ($_menus as $module) : ?>
                <?php if ($module['visibility']) : ?>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="<?= $module['module_icon'] ?>"></i>
                        <span><?= lang($module['module_title']) ?></span>
                    </a>

                    <ul class="sub-menu" aria-expanded="true">
                        <?php foreach ($module['menus'] as $menuItem) : ?>
                        <?php if ($menuItem['visibility']) : ?>
                        <?php if (!empty($menuItem['sub_menus'])) : ?>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <span><?= lang($menuItem['title']) ?></span>
                                <?php if ($menuItem['badge_count'] > 0) : ?>
                                <span
                                    class="badge rounded-pill bg-info float-end"><?= $menuItem['badge_count'] ?></span>
                                <?php endif; ?>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <?php foreach ($menuItem['sub_menus'] as $subMenuItem) : ?>
                                <?php if ($subMenuItem['visibility']) : ?>
                                <li><a href="<?= $subMenuItem['url'] ?>"><?= lang($subMenuItem['title']) ?></a></li>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <?php else : ?>
                        <li>
                            <a href="<?= $menuItem['url'] ?>" class="waves-effect">
                                <span><?= lang($menuItem['title']) ?></span>
                                <?php if ($menuItem['badge_count'] > 0) : ?>
                                <span
                                    class="badge rounded-pill bg-info float-end"><?= $menuItem['badge_count'] ?></span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php endif; ?>

                        <?php endforeach; ?>
                    </ul>
                </li>
                <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->