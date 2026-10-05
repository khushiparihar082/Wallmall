<div class="card form_bg">
  <!-- <div class="card-header d-flex justify-content-between align-items-center">
        <//?= (isset($blog_id) && !empty($blog_id)) ? "Update" : "Add" ?> BlogPost</h5>
        <a href="<//?= base_url(route_to('BlogPostView')) ?>" class="btn btn-secondary">Back</a>
    </div> -->
  <div class="card-body">
    <div class="error-message-box d-none">
      <p id="error-message"></p>
    </div>
    <div class="success-message-box d-none">
      <p id="success-message"></p>
    </div>

    <div class="row offcanvas-body">
      <form id="form" method="POST" enctype="multipart/form-data" action="<?= @$ApiUrl ?>">
        <input type="hidden" name="blog_id" id="blog_id" value="<?= @$blog_id ?>">
        <input type="hidden" name="blog_featured_image" id="blog_featured_image" value="<?= @$blog_featured_image ?>">
        <input type="hidden" name="user_id" id="user_id" value="<?= @$_SESSION['user_id'] ?>">

        <div class="offcanvas-header mb-3">
          <div class="">
            <h5 id="Add_outdoor_mediaLabel"> <?= (isset($blog_id) && !empty($blog_id)) ? "Update" : "Add" ?>
              BlogPost</h5>
          </div>
          <a href="<?= base_url(route_to('BlogPostView')) ?>"> <button class="btn export_btn me-2" type="button"><i class="fas fa-backward"></i></button></a>
        </div>
        <div class="row">
          <div class="col-md-12">
            <!-- Add Prodcut Detail -->
            <div class="card-body">
              <div class="row">
                <div class="form-group col-md-6 mb-3">
                  <label class="form-label" for="blog_author_name">Author name</label>
                  <input type="text" placeholder="Author name" id="blog_author_name" name="blog_author_name" class="form-control" value="<?= @$blog_author_name ?>">
                  <span class="error-message" id="error-blog_author_name"></span>
                </div>

                <div class="form-group col-md-6 mb-3">
                  <label for="blog_title">Headline<span class="text-danger">*</span></label>
                  <input type="text" placeholder="Enter Headling" id="blog_title" name="blog_title" class="form-control" value="<?= @$blog_title ?>">
                  <span class="error-message" id="error-blog_title"></span>
                </div>

                <div class="form-group col-md-12 mb-3">
                  <label class="form-label" for="blog_short_content">Short Content</label>
                  <textarea class="form-control ckeditor-active" name="blog_short_content" id="blog_short_content" cols="20" rows="5" placeholder="Short Contant"><?= @$blog_short_content ?></textarea>
                  <span class="error-message" id="error-blog_short_content"></span>
                </div>
                <div class="form-group col-md-12 mb-3">
                  <label class="form-label" for="blog_long_content">Long Content</label>
                  <textarea class="form-control ckeditor-active" name="blog_long_content" id="blog_long_content" cols="20" rows="5" placeholder="Long Contant"><?= @$blog_long_content ?></textarea>
                  <span class="error-message" id="error-blog_long_content"></span>
                </div>
                <div class="mb-3">
                  <label class="form-label">Tag Title</label>
                  <div>
                    <input type="text" class="form-control" id="blog_seo_title" name="blog_seo_title" placeholder="Enter Tag Title" value="<?= @$blog_seo_title ?>" />
                  </div>
                  <span class="error-message" id="error-blog_seo_title"></span>
                </div>
                <div class="mb-3">
                  <label class="form-label">Meta Keywords</label>
                  <div>
                    <input type="text" class="form-control" id="blog_seo_keyword" name="blog_seo_keyword" placeholder="Enter Meta Keywords" value="<?= @$blog_seo_keyword ?>" />
                  </div>
                  <span class="error-message" id="error-blog_seo_keyword"></span>
                </div>

                <span class="error-message" id="error-long_content"></span>
                <div class="mb-3">
                  <label class="form-label">Meta Description</label>
                  <div>
                    <textarea class="form-control" name="blog_seo_description" id="blog_seo_description" cols="20" rows="5" placeholder="Enter Meta Description"><?= @$blog_seo_description ?></textarea>
                  </div>
                  <span class="error-message" id="error-blog_seo_description"></span>
                </div>
                <div class="form-group col-md-4 mb-3">
                  <label class="form-label" for="published_at">Publish date</label>
                  <input type="date" placeholder="Publish Date" id="published_at" name="published_at" class="form-control" value="<?= isset($published_at) ? date('Y-m-d', strtotime($published_at)) : '' ?>">
                  <span class="error-message" id="error-published_at"></span>
                </div>

                <div class="form-group col-md-4 mb-3">
                  <img class="image-fluid" style="height:auto; width:100px; margin-bottom:20px;" id="featured_image_display" onclick="enlargeImage(event)" src="<?= (isset($blog_featured_image) && !empty($blog_featured_image)) ? base_url($blog_featured_image) : "" ?>">
                  <?php if (isset($blog_featured_image) && !empty($blog_featured_image)) : ?>
                    <button type="button" class="btn btn-danger ms-2" onclick="deleteImage('blog_featured_image', 'featured_image_display')"><i class="bx bx-trash-alt"></i></button>
                  <?php endif; ?>
                  <label class="form-label">Upload Files</label>
                  <input type="file" name="featured_image_upload" id="featured_image_upload" class="form-control" onchange="uploadImage('featured_image_upload','blogpost','blog_featured_image','featured_image_display')">
                  <span class="error-message" id="error-featured_image"></span>
                  <input type="text" placeholder="Alt text" id="blog_alt_text" name="blog_alt_text" class="form-control" value="<?= @$blog_alt_text ?>">
                  <p class="my-1 font_size_11">The image must be uploaded under 500KB.<span class="text-danger">*</span></p>
                </div>

                <div class="form-group col-md-4 mb-3">
                  <label class="form-label">Status <span class="text-danger">*</span></label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="blog_status" id="draft" value="draft" <?= (isset($blog_status) && $blog_status == "draft") ? "checked" : "" ?> />
                    <label class="form-check-label" for="draft">Draft</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="blog_status" id="published" value="published" <?= (isset($blog_status) && $blog_status == "published") ? "checked" : "" ?> />
                    <label class="form-check-label" for="published">Published</label>
                  </div>
                  <span class="error-message" id="error-blog_status"></span>
                </div>

              </div>
            </div>
          </div>
          <div>
            <button type="button" onclick="submitFormWithAjax('form',true,true,successCallback,errorCallback)" class="btn btn-primary waves-effect waves-light me-1">
              Submit
            </button>
            <button type="reset" class="btn btn-secondary waves-effect" onclick="window.location.href='<?= base_url(route_to('BlogPostView')) ?>'">
              Cancel
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <script>
    function successCallback(response) {
      if (response.status == 201) {
        var data = JSON.parse(response.data);
        console.log(response.data);
        window.location.href = '<?= base_url(route_to('BlogPostView')) ?>';
      }
      if (response.status == 200) {
        window.location.href = '<?= base_url(route_to('BlogPostView')) ?>';
      }
    }

    function errorCallback(response) {
      console.log(response);
    }
  </script>