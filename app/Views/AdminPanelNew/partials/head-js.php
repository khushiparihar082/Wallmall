<script>
    <?= $_head_js_code ?>
</script>
<!-- Dynamic js Load -->
<?php if (isset($_head_js_files) && is_array($_head_js_files)) : ?>
    <?php foreach ($_head_js_files as $key => $_head_js_file) : ?>
        <?php if (is_string($_head_js_file)) : ?>
            <script src="<?= base_url($_head_js_file) ?>"></script>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>