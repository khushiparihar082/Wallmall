<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0 font-size-18"><?= @$_page_title ?></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0 text-black">
                    <li class="breadcrumb-item"><a href="javascript: void(0);" class="text-black"><?= @$_breadcrumb1 ?></a></li>
                    <?php if(isset($_breadcrumb2)):  ?>
                        <li class="breadcrumb-item active text-secondary"><?= @$_breadcrumb2 ?></li>
                    <?php endif ?>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->