<script>
    <?= $_script_js_code ?>
</script>
<!-- Dynamic js Load -->
<?php if (isset($_script_files) && is_array($_script_files)) : ?>
    <?php foreach ($_script_files as $key => $_script_file) : ?>
        <?php if (is_string($_script_file)) : ?>
            <script src="<?= base_url($_script_file) ?>"></script>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>