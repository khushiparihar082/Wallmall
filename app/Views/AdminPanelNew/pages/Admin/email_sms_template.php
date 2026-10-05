<h4>Email & Sms Template</h4>
<div class="container mb-3">
    <label for="template_id"> Select Template</label>
    <select name="template_id" id="template_id" onchange="get_template_form()">
        <option value="" selected>Select Template</option>
        <?php foreach ($templates as $template): ?>
            <option value="<?php echo $template['template_id']; ?>"><?php echo $template['template_heading']; ?></option>
        <?php endforeach; ?>
    </select>
</div>

<div class="container" id="template_form">

</div>

<script>
    function get_template_form() {
        debugger;
        var selectizeControl = $('#template_id')[0].selectize; // Get Selectize control
        var template_id = selectizeControl.getValue(); // Get the selected value

        // Run AJAX if a value is selected
        if (template_id) {
            $.ajax({
                url: '<?= base_url(route_to('email_sms_template_form')) ?>', // Replace with your API URL
                type: 'POST',
                data: {
                    template_id: template_id
                },
                dataType: 'html',
                processData: true,
                success: function(response) {
                    $('#template_form').html(response);
                    // Ck Editor
                    // var textareaId = 'email_body';
                    // CKEDITOR.replace(textareaId);

                    // // Handle CKEditor change event
                    // CKEDITOR.instances[textareaId].on("change", function() {
                    //     // Update corresponding textarea's value with CKEditor's data
                    //     $("#" + textareaId).val(CKEDITOR.instances[textareaId].getData());
                    // });
                    // Sms Message Word Count
                    $('.sms-textarea').each(function() {
                        // Create a small element to display the character count
                        $(this).before('<small class="char-count">0 characters</small>');

                        // Initialize character count on page load
                        let initialCount = $(this).val().length;
                        $(this).prev('.char-count').text(initialCount + " characters");

                        // On keyup, update the character count
                        $(this).on('keyup', function() {
                            let currentLength = $(this).val().length;
                            let charCountElement = $(this).prev('.char-count');

                            // Update the character count display
                            charCountElement.text(currentLength + " characters");

                            // Change the color to red if length exceeds 160, else reset color
                            if (currentLength > 160) {
                                charCountElement.css('color', 'red');
                            } else {
                                charCountElement.css('color', 'black');
                            }
                        });
                    });
                },
                error: function(xhr, status, error) {
                    // Handle any errors
                    console.log('Error: ' + error);
                }
            });
        } else {
            alert("Please select a template");
        }
    }

    function successCallback(response) {}

    function errorCallback(response) {
        console.log(response);
    }

    $(document).ready(function() {
        $('#template_id').selectize({
            placeholder: "Select Template",
            allowEmptyOption: true, // Allow the first empty option
            create: false,
        });
        // Loop through all textareas with class .sms-textarea
    });
</script>