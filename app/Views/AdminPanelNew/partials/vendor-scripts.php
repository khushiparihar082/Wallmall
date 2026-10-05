<!-- JAVASCRIPT -->

<script src="<?= base_url($_assets_path . 'assets/libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url($_assets_path . 'assets/libs/toastr/toastr.min.js') ?>"></script>
<script src="<?= base_url($_assets_path . 'assets/libs/metismenu/metisMenu.min.js') ?>"></script>
<script src="<?= base_url($_assets_path . 'assets/libs/simplebar/simplebar.min.js') ?>"></script>
<script src="<?= base_url($_assets_path . 'assets/libs/node-waves/waves.min.js') ?>"></script>
<script src="<?= base_url($_assets_path . 'assets/libs/jquery-sparkline/jquery.sparkline.min.js') ?>"></script>
<!-- apexcharts -->
<script src="<?= base_url($_assets_path . 'assets/libs/apexcharts/apexcharts.min.js') ?>"></script>
<!-- jquery.vectormap map -->
<script src="<?= base_url($_assets_path . 'assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') ?>"></script>
<script src="<?= base_url($_assets_path . 'assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') ?>"></script>
<!-- <script src="<#?= base_url($_assets_path . 'assets/js/pages/dashboard.init.js') ?>"></script> -->
<!-- parsley plugin -->
<script src="<?= base_url($_assets_path . 'assets/libs/parsleyjs/parsley.min.js') ?>"></script>
<!-- validation init -->
<script src="<?= base_url($_assets_path . 'assets/js/pages/form-validation.init.js') ?>"></script>
<!-- Text Editor -->
<!--tinymce js-->
<script src="<?= base_url($_assets_path . 'assets/libs/tinymce/tinymce.min.js') ?>"></script>
<!-- init js -->
<script src="<?= base_url($_assets_path . 'assets/js/pages/form-editor.init.js') ?>"></script>
<!-- end -->
<!-- Multiple uploads images drag and drop -->
<script src="<?= base_url($_assets_path . 'assets/libs/dropzone/min/dropzone.min.js') ?>"></script>
<!-- end -->

<!-- Required datatable js -->
<script src="<?= base_url($_assets_path . 'assets/libs/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url($_assets_path . 'assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<!-- Buttons examples -->
<script src="<?= base_url($_assets_path . 'assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') ?>">
</script>
<script src="<?= base_url($_assets_path . 'assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') ?>">
</script>
<script src="<?= base_url($_assets_path . 'assets/libs/jszip/jszip.min.js') ?>"></script>
<script src="<?= base_url($_assets_path . 'assets/libs/pdfmake/build/pdfmake.min.js') ?>"></script>
<!-- <script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.10/pdfmake.min.js' integrity='sha512-w61kvDEdEhJPJLSAJpuL+RWp1+zTBUUpgPaP+6pcqCk78wQkOaExjnGWrVbovojeisWGQS7XZKz+gr3L+GPYLg==' crossorigin='anonymous'></script> -->
<!-- <script src="<#?= base_url($_assets_path . 'assets/libs/pdfmake/build/vfs_fonts.js') ?>"></script> -->

<script src="<?= base_url($_assets_path . 'assets/libs/datatables.net-buttons/js/buttons.html5.min.js') ?>"></script>
<script src="<?= base_url($_assets_path . 'assets/libs/datatables.net-buttons/js/buttons.print.min.js') ?>"></script>
<script src="<?= base_url($_assets_path . 'assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') ?>"></script>
<!-- Responsive examples -->
<script src="<?= base_url($_assets_path . 'assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') ?>">
</script>
<script src="<?= base_url($_assets_path . 'assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') ?>">
</script>

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>


<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

<!-- slider js -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<!-- Datatable init js -->
<script src="<?= base_url($_assets_path . 'assets/js/pages/datatables.init.js') ?>"></script>
<script src="<?= base_url($_assets_path . 'assets/js/app.js') ?>"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js' integrity='sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==' crossorigin='anonymous'></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Firebase Messaging Notification -->
<script src="<?= base_url('firebase-app.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<script>
    function uploadImage(file_input_id, for_param, input_field_for_image, img_div_id, is_crop = false, crop_x_ratio = null, crop_y_ratio = null) {
        // Get the file input element
        var fileInput = document.getElementById(file_input_id);

        // Check if a file was selected
        if (fileInput.files.length > 0) {
            var file = fileInput.files[0];
            var formData = new FormData();
            var cropper;

            // Append the file and other parameters to FormData
            formData.append('file', file);
            formData.append('for', for_param);

            // Read the file as a data URL
            var reader = new FileReader();
            reader.onload = function(e) {
                if (is_crop) {
                    // Show SweetAlert2 popup with the image
                    Swal.fire({
                        title: 'Crop Image',
                        html: '<div class="img-fluid"><img id="cropImage" src="' + e.target.result + '"></div>',
                        showCancelButton: true,
                        confirmButtonText: 'Crop & Upload',
                        cancelButtonText: 'Cancel',
                        width: '40%',
                        customClass: {
                            popup: 'custom-swal-popup'
                        },
                        didOpen: () => {
                            var image = document.getElementById('cropImage');
                            cropper = new Cropper(image, {
                                aspectRatio: crop_x_ratio && crop_y_ratio ? crop_x_ratio / crop_y_ratio : NaN,
                                viewMode: 0,
                            });
                        },
                        preConfirm: () => {
                            return new Promise((resolve) => {
                                var canvas = cropper.getCroppedCanvas();
                                if (!canvas) {
                                    Swal.showValidationMessage('Could not crop image. Please try again.');
                                    return;
                                }
                                canvas.toBlob((blob) => {
                                    // Convert cropped canvas to blob (file object)
                                    const file = new File([blob], 'croppedImage.jpeg', {
                                        type: 'image/jpeg'
                                    });
                                    formData.delete('file');
                                    formData.append('file', file);
                                    // Make AJAX request
                                    $.ajax({
                                        url: '<?= base_url(route_to('file_upload_image_api')) ?>', // Replace with your API endpoint URL
                                        type: 'POST',
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: function(response) {
                                            // Upon success, update the input field and image display
                                            if (response.status == 200) {
                                                toastr.success(response.message);
                                                response = JSON.parse(response.data);
                                                $('#' + input_field_for_image).val(response.image_path); // Assuming your API returns image_url
                                                $('#' + img_div_id).attr('src', response.image_path_url);
                                                resolve();
                                            } else {
                                                toastr.error(response.message);
                                                Swal.showValidationMessage(response.message);
                                            }
                                        },
                                        error: function(xhr, status, error) {
                                            // Handle errors here
                                            console.error('Error uploading image:', error);
                                            Swal.showValidationMessage('Error uploading image. Please try again.');
                                        }
                                    });
                                }, 'image/jpeg');
                            });
                        },
                        willClose: () => {
                            // Destroy the cropper instance
                            if (cropper) {
                                cropper.destroy();
                            }
                        }
                    });
                } else {
                    // No cropping, directly upload the file
                    formData.append('file', file);
                    $.ajax({
                        url: '<?= base_url(route_to('file_upload_image_api')) ?>', // Replace with your API endpoint URL
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            debugger;

                            // Upon success, update the input field and image display
                            if (response.status == 200) {
                                toastr.success(response.message);
                                response = JSON.parse(response.data);
                                $('#' + input_field_for_image).val(response.image_path); // Assuming your API returns image_url
                                $('#' + img_div_id).attr('src', response.image_path_url);
                            } else {
                                toastr.error(response.message);
                                Swal.showValidationMessage(response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle errors here
                            console.error('Error uploading image:', error);
                            Swal.showValidationMessage('Error uploading image. Please try again.');
                        }
                    });
                }
            };
            reader.readAsDataURL(file);
        } else {
            alert('Please select a file to upload.');
        }
    }

    function deleteImage(inputFieldId, imgElementId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
        }).then((result) => {
            if (result.isConfirmed) {

                var image_file_path = $("#" + inputFieldId).val();

                // Remove the image from the display
                document.getElementById(imgElementId).src = '';

                // Optionally, you can make an AJAX request to delete the image from the server
                $.ajax({
                    url: '<?= base_url(route_to('file_delete_image_api')) ?>', // Replace with your API endpoint URL
                    type: 'POST',
                    data: {
                        image_file_path: image_file_path
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            toastr.success(response.message);
                            $("#" + inputFieldId).val("");
                            $("#" + imgElementId).src("");
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error deleting image:', error);
                        toastr.error('Error deleting image. Please try again.');
                    }
                });
            }
        });
    }
</script>