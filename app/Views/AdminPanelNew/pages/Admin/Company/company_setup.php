<div class="card form_bg">
    <form autocomplete="on" id="form" method="POST" enctype="multipart/form-data" action="<?= @$ApiUrl ?>">

        <div class="accordion position-relative" id="accordionExample">
            <div class="row">
                <div class="col-2">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#companydetail" aria-expanded="true" aria-controls="companydetail">
                        Company Details
                    </button>
                </div>
                <div class="col-2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#contactinformation" aria-expanded="false" aria-controls="contactinformation">
                        Contact Information
                    </button>
                </div>
                <div class="col-2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#websiteinformation" aria-expanded="false" aria-controls="websiteinformation">
                        Website Information
                    </button>
                </div>
                <div class="col-2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#urlinformation" aria-expanded="false" aria-controls="urlinformation">
                        Social Media and Urls
                    </button>
                </div>
                <div class="col-2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#seoIntegration" aria-expanded="false" aria-controls="seoIntegration">
                        SEO Information
                    </button>
                </div>
            </div>

            <div class="accordion-item">
                <div id="companydetail" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <input type="hidden" name="firm_logo_url" id="firm_logo_url" value="<?= @$firm_logo_url ?>">
                    <input type="hidden" name="website_profile_id" id="website_profile_id" value="<?= @$website_profile_id ?>">
                    <div class="accordion-body">
                        <div class="container">
                            <h3 class="mb-0 mt-3 text-secondary">Company Details</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <label for="firm_name" class="form-label">Firm Name</label>
                                        <input autocomplete="off" type="text" class="form-control" id="firm_name" name="firm_name" placeholder="Firm Name" value="<?= @$firm_name ?>">
                                        <span class="error-message" id="firm_name-error"></span>
                                    </div>
                                </div>
                                <div class="form-group col-md-4 mb-3">
                                    <img class="image-fluid" style="height:auto; width:100px" id="firm_logo_url_display" src="<?= base_url() ?>/<?= @$firm_logo_url ?>">
                                    <label class="form-label">Upload Files</label>
                                    <input type="file" id="firm_logo_url_upload" class="form-control" onchange="uploadImage('firm_logo_url_upload','firmLogo','firm_logo_url','firm_logo_url_display')">
                                    <span class="error-message" id="error-firm_logo_url_upload"></span>
                                    <p class="my-1 font_size_11">The image must be uploaded under 500KB.<span class="text-danger">*</span></p>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="firm_slogan" class="form-label">Slogan</label>
                                        <textarea class="form-control" name="firm_slogan" id="firm_slogan" cols="20" rows="5" placeholder="Firm slogna"><?= @$firm_slogan ?></textarea>
                                        <span class="error-message" id="error-firm_slogan"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="firm_address" class="form-label">Address</label>
                                        <textarea class="form-control" name="firm_address" id="firm_address" rows="3"><?= @$firm_address ?></textarea>
                                        <span class="error-message" id="firm_address-error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="firm_cin_no" class="form-label">CIN No</label>
                                        <input autocomplete="off" type="text" class="form-control" id="firm_cin_no" name="firm_cin_no" value="<?= @$firm_cin_no ?>" placeholder="CIN No">
                                        <span class="error-message" id="firm_cin_no-error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="firm_gst_no" class="form-label">GST No</label>
                                        <input autocomplete="off" type="text" class="form-control" id="firm_gst_no" name="firm_gst_no" value="<?= @$firm_gst_no ?>" placeholder="GST No">
                                        <span class="error-message" id="firm_gst_no-error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="firm_pan_no" class="form-label">PAN No</label>

                                        <input autocomplete="off" type="text" class="form-control" id="firm_pan_no" name="firm_pan_no" value="<?= @$firm_pan_no ?>" placeholder="PAN No">
                                        <span class="error-message" id="firm_pan_no-error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo"></h2>
                <div id="contactinformation" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="text-secondary">Contact Information</h4>
                                    <hr>
                                </div>
                                <div class="col-4">
                                    <label for="contact_mobile" class="form-label"><i class="fa-solid fa-phone me-2" aria-hidden="true"></i>Contact Mobile</label>
                                    <input autocomplete="off" type="number" class="form-control" id="contact_mobile" name="contact_mobile" value="<?= @$contact_mobile ?>" placeholder="Enter Number">
                                    <span class="error-message" id="contact_mobile-error"></span>
                                </div>
                                <div class="col-4">
                                    <label for="contact_whatsapp" class="form-label"><i class="fa-solid fa-phone me-2" aria-hidden="true"></i>Contact Whatsapp</label>
                                    <input autocomplete="off" type="number" class="form-control" id="contact_whatsapp" name="contact_whatsapp" value="<?= @$contact_whatsapp ?>" placeholder="Enter Number">
                                    <span class="error-message" id="contact_whatsapp-error"></span>
                                </div>
                                <div class="col-4">
                                    <label for="contact_email" class="form-label">Contact Email</label>
                                    <input autocomplete="off" type="email" class="form-control" id="contact_email" name="contact_email" value="<?= @$contact_email ?>" placeholder="Enter Email">
                                    <span class="error-message" id="contact_email-error"></span>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12">
                                    <hr>
                                    <h4 class="text-secondary">Sale Information</h4>
                                    <hr>
                                </div>
                                <div class="col-4">
                                    <label for="sales_mobile" class="form-label"><i class="fa-solid fa-phone me-2" aria-hidden="true"></i>Sales Mobile</label>
                                    <input autocomplete="off" type="number" class="form-control" id="sales_mobile" name="sales_mobile" value="<?= @$sales_mobile ?>" placeholder="Enter Number">
                                    <span class="error-message" id="sales_mobile-error"></span>
                                </div>
                                <div class="col-4">
                                    <label for="sales_whatsapp" class="form-label"><i class="fa-solid fa-phone me-2" aria-hidden="true"></i>Sales Whatsapp</label>
                                    <input autocomplete="off" type="number" class="form-control" id="sales_whatsapp" name="sales_whatsapp" value="<?= @$sales_whatsapp ?>" placeholder="Enter Number">
                                    <span class="error-message" id="sales_whatsapp-error"></span>
                                </div>
                                <div class="col-4">
                                    <label for="sales_email" class="form-label">Sales Email</label>
                                    <input autocomplete="off" type="email" class="form-control" id="sales_email" name="sales_email" value="<?= @$sales_email ?>" placeholder="Enter Email">
                                    <span class="error-message" id="sales_email-error"></span>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12">
                                    <hr>
                                    <h4 class="text-secondary">Support Information</h4>
                                    <hr>
                                </div>
                                <div class="col-4">
                                    <label for="support_mobile" class="form-label"><i class="fa-solid fa-phone me-2" aria-hidden="true"></i>Support Mobile</label>
                                    <input autocomplete="off" type="number" class="form-control" id="support_mobile" name="support_mobile" value="<?= @$support_mobile ?>" placeholder="Enter Number">
                                    <span class="error-message" id="support_mobile-error"></span>
                                </div>
                                <div class="col-4">
                                    <label for="support_whatsapp" class="form-label"><i class="fa-solid fa-phone me-2" aria-hidden="true"></i>Support Whatsapp</label>
                                    <input autocomplete="off" type="number" class="form-control" id="support_whatsapp" name="support_whatsapp" value="<?= @$support_whatsapp ?>" placeholder="Enter Number">
                                    <span class="error-message" id="support_whatsapp-error"></span>
                                </div>
                                <div class="col-4">
                                    <label for="support_email" class="form-label">Support Email</label>
                                    <input autocomplete="off" type="email" class="form-control" id="support_email" name="support_email" value="<?= @$support_email ?>" placeholder="Enter Email">
                                    <span class="error-message" id="support_email-error"></span>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12">
                                    <hr>
                                    <h4 class="text-secondary">Career Information</h4>
                                    <hr>
                                </div>
                                <div class="col-4">
                                    <label for="career_mobile" class="form-label"><i class="fa-solid fa-phone me-2" aria-hidden="true"></i>Career Mobile</label>
                                    <input autocomplete="off" type="number" class="form-control" id="career_mobile" name="career_mobile" value="<?= @$career_mobile ?>" placeholder="Enter Number">
                                    <span class="error-message" id="career_mobile-error"></span>
                                </div>
                                <div class="col-4">
                                    <label for="career_whatsapp" class="form-label"><i class="fa-solid fa-phone me-2" aria-hidden="true"></i>Career Whatsapp</label>
                                    <input autocomplete="off" type="number" class="form-control" id="career_whatsapp" name="career_whatsapp" value="<?= @$career_whatsapp ?>" placeholder="Enter Number">
                                    <span class="error-message" id="career_whatsapp-error"></span>
                                </div>
                                <div class="col-4">
                                    <label for="career_email" class="form-label">Career Email</label>
                                    <input autocomplete="off" type="email" class="form-control" id="career_email" name="career_email" value=" <?= @$career_email ?>" placeholder="Enter Email">
                                    <span class="error-message" id="career_email-error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree"></h2>
                <div id="websiteinformation" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="container">
                            <h3 class="mb-0 mt-3 text-secondary">Website Information</h3>
                            <hr>
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <label for="about_company" class="form-label">About company</label>
                                    <textarea class="form-control" name="about_company" id="about_company" rows="3"><?= @$about_company ?></textarea>
                                </div>
                                <div class="col-12 mb-4">
                                    <label for="terms_conditions" class="form-label">Terms and conditions</label>
                                    <textarea class="form-control" name="terms_conditions" id="terms_conditions" rows="3"><?= @$terms_conditions ?></textarea>
                                </div>
                                <div class="col-12 mb-4">
                                    <label for="privacy_policy" class="form-label">Privacy and policies</label>
                                    <textarea class="form-control" name="privacy_policy" id="privacy_policy" rows="3"><?= @$privacy_policy ?></textarea>
                                </div>
                                <div class="col-12 mb-4">
                                    <label for="return_policy" class="form-label">Return Policy</label>
                                    <textarea class="form-control" name="return_policy" id="return_policy" rows="3"><?= @$return_policy ?></textarea>
                                </div>
                                <div class="col-12 mb-4">
                                    <label for="refund_policy" class="form-label">Refund policy</label>
                                    <textarea class="form-control" name="refund_policy" id="refund_policy" rows="3"><?= @$refund_policy ?></textarea>
                                </div>
                                <div class="col-12 mb-4">
                                    <label for="disclaimer_content" class="form-label">Disclaimer content</label>
                                    <textarea class="form-control" name="disclaimer_content" id="disclaimer_content" rows="3"><?= @$disclaimer_content ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree"></h2>
                <div id="urlinformation" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="container">
                            <h3 class="mb-0 mt-3 text-secondary">Social Media And Urls</h3>
                            <hr>
                            <div class="row input-row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="google_maps_url" class="form-label"><i class="fa-solid fa-link me-2" aria-hidden="true"></i>Google Maps URL</label>
                                        <div class="col-md-4 p-0">
                                        </div>
                                        <div>
                                            <input autocomplete="off" type="text" class="form-control" id="google_maps_url" name="google_maps_url" value="<?= @$google_maps_url ?>" placeholder="Google Maps URL">
                                            <span class="error-message" id="google_maps_url-error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="website_url" class="form-label"><i class="fa-solid fa-link me-2" aria-hidden="true"></i>Website URL</label>
                                        <div class="col-md-4 p-0">
                                        </div>
                                        <div>
                                            <input autocomplete="off" type="text" class="form-control" id="website_url" name="website_url" value="<?= @$website_url ?>" placeholder="Website URL">
                                            <span class="error-message" id="website_url-error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="play_store_url" class="form-label"><i class="fa-solid fa-link me-2" aria-hidden="true"></i>Play Store URL</label>
                                        <div class="col-md-4 p-0">
                                        </div>
                                        <div>
                                            <input autocomplete="off" type="text" class="form-control" id="play_store_url" name="play_store_url" value="<?= @$play_store_url ?>" placeholder="Play Store URL">
                                            <span class="error-message" id="play_store_url-error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="app_store_url" class="form-label"><i class="fa-solid fa-link me-2" aria-hidden="true"></i>App Store URL</label>
                                        <div class="col-md-4 p-0">
                                        </div>
                                        <div>
                                            <input autocomplete="off" type="text" class="form-control" id="app_store_url" name="app_store_url" value="<?= @$app_store_url ?>" placeholder="App Store URL">
                                            <span class="error-message" id="app_store_url-error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="facebook_url" class="form-label"><i class="fa-solid fa-link me-2" aria-hidden="true"></i>Facebook URL</label>
                                        <div class="col-md-4 p-0">
                                        </div>
                                        <div>
                                            <input autocomplete="off" type="text" class="form-control" id="facebook_url" name="facebook_url" value="<?= @$facebook_url ?>" placeholder="Facebook URL">
                                            <span class="error-message" id="facebook_url-error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="instagram_url" class="form-label"><i class="fa-solid fa-link me-2" aria-hidden="true"></i>Instagram URL</label>
                                        <div class="col-md-4 p-0">
                                        </div>
                                        <div>
                                            <input autocomplete="off" type="text" class="form-control" id="instagram_url" name="instagram_url" value="<?= @$instagram_url ?>" placeholder="Instagram URL">
                                            <span class="error-message" id="instagram_url-error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="twitter_url" class="form-label"><i class="fa-solid fa-link me-2" aria-hidden="true"></i>Twitter URL</label>
                                        <div class="col-md-4 p-0">
                                        </div>
                                        <div>
                                            <input autocomplete="off" type="text" class="form-control" id="twitter_url" name="twitter_url" value="<?= @$twitter_url ?>" placeholder="Twitter URL">
                                            <span class="error-message" id="twitter_url-error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="linkedin_url" class="form-label"><i class="fa-solid fa-link me-2" aria-hidden="true"></i>LinkedIn URL</label>
                                        <div class="col-md-4 p-0">
                                        </div>
                                        <div>
                                            <input autocomplete="off" type="text" class="form-control" id="linkedin_url" name="linkedin_url" value="<?= @$linkedin_url ?>" placeholder="LinkedIn URL">
                                            <span class="error-message" id="linkedin_url-error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="youtube_url" class="form-label"><i class="fa-solid fa-link me-2" aria-hidden="true"></i>YouTube URL</label>
                                        <div class="col-md-4 p-0">
                                        </div>
                                        <div>
                                            <input autocomplete="off" type="text" class="form-control" id="youtube_url" name="youtube_url" value="<?= @$youtube_url ?>" placeholder="YouTube URL">
                                            <span class="error-message" id="youtube_url-error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="telegram_url" class="form-label"><i class="fa-solid fa-link me-2" aria-hidden="true"></i>Telegram URL</label>
                                        <div class="col-md-4 p-0">
                                        </div>
                                        <div>
                                            <input autocomplete="off" type="text" class="form-control" id="telegram_url" name="telegram_url" value="<?= @$telegram_url ?>" placeholder="Telegram URL">
                                            <span class="error-message" id="telegram_url-error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="pinterest_url" class="form-label"><i class="fa-solid fa-link me-2" aria-hidden="true"></i>Pinterest URL</label>
                                        <div class="col-md-4 p-0">
                                        </div>
                                        <div>
                                            <input autocomplete="off" type="text" class="form-control" id="pinterest_url" name="pinterest_url" value="<?= @$pinterest_url ?>" placeholder="Pinterest URL">
                                            <span class="error-message" id="pinterest_url-error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="google_search_url" class="form-label"><i class="fa-solid fa-link me-2" aria-hidden="true"></i>Google Search URL
                                            <div class="col-md-4 p-0">
                                        </label>
                                    </div>
                                    <div>
                                        <input autocomplete="off" type="text" class="form-control" id="google_search_url" name="google_search_url" value="<?= @$google_search_url ?>" placeholder="Google Search URL">
                                        <span class="error-message" id="google_search_url-error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree"></h2>
            <div id="seoIntegration" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="container">
                        <h3 class="mb-0 mt-3 text-secondary">SEO Information</h3>
                        <hr>
                        <h4>Home page</h4>
                        <div class="col-12 mb-4">
                            <label for="home_page_title" class="form-label">Home Page Title</label>
                            <textarea class="form-control" name="home_page_title" id="home_page_title" rows="3"><?= @$home_page_title ?></textarea>
                        </div>
                        <div class="col-12 mb-4">
                            <label for="home_page_seo_keyword" class="form-label">Home Page SEO Keyword</label>
                            <textarea class="form-control" name="home_page_seo_keyword" id="home_page_seo_keyword" rows="3"><?= @$home_page_seo_keyword ?></textarea>
                        </div>

                        <div class="col-12 mb-4">
                            <label for="home_page_description" class="form-label">Home Page Description</label>
                            <textarea class="form-control" name="home_page_description" id="home_page_description" rows="3"><?= @$home_page_description ?></textarea>
                        </div>

                        <h4>About page</h4>
                        <div class="col-12 mb-4">
                            <label for="about_page_title" class="form-label">About Page Title</label>
                            <textarea class="form-control" name="about_page_title" id="about_page_title" rows="3"><?= @$about_page_title ?></textarea>
                        </div>
                        <div class="col-12 mb-4">
                            <label for="home_page_seo_keyword" class="form-label">About Page SEO Keyword</label>
                            <textarea class="form-control" name="home_page_seo_keyword" id="home_page_seo_keyword" rows="3"><?= @$home_page_seo_keyword ?></textarea>
                        </div>

                        <div class="col-12 mb-4">
                            <label for="home_page_description" class="form-label">About Page Description</label>
                            <textarea class="form-control" name="home_page_description" id="home_page_description" rows="3"><?= @$home_page_description ?></textarea>
                        </div>

                        <h4>Contact page</h4>
                        <div class="col-12 mb-4">
                            <label for="contact_page_title" class="form-label">Contact Page Title</label>
                            <textarea class="form-control" name="contact_page_title" id="contact_page_title" rows="3"><?= @$contact_page_title ?></textarea>
                        </div>
                        <div class="col-12 mb-4">
                            <label for="contact_page_seo_keyword" class="form-label">Contact Page SEO Keyword</label>
                            <textarea class="form-control" name="contact_page_seo_keyword" id="contact_page_seo_keyword" rows="3"><?= @$contact_page_seo_keyword ?></textarea>
                        </div>

                        <div class="col-12 mb-4">
                            <label for="contact_page_description" class="form-label">Contact Page Description</label>
                            <textarea class="form-control" name="contact_page_description" id="contact_page_description" rows="3"><?= @$contact_page_description ?></textarea>
                        </div>

                        <h4>FAQ page</h4>
                        <div class="col-12 mb-4">
                            <label for="faq_page_title" class="form-label">FAQ Page Title</label>
                            <textarea class="form-control" name="faq_page_title" id="faq_page_title" rows="3"><?= @$faq_page_title ?></textarea>
                        </div>
                        <div class="col-12 mb-4">
                            <label for="faq_page_seo_keyword" class="form-label">FAQ Page SEO Keyword</label>
                            <textarea class="form-control" name="faq_page_seo_keyword" id="faq_page_seo_keyword" rows="3"><?= @$faq_page_seo_keyword ?></textarea>
                        </div>

                        <div class="col-12 mb-4">
                            <label for="faq_page_description" class="form-label">FAQ Page Description</label>
                            <textarea class="form-control" name="faq_page_description" id="faq_page_description" rows="3"><?= @$faq_page_description ?></textarea>
                        </div>


                        <h4>Support page</h4>
                        <div class="col-12 mb-4">
                            <label for="support_page_title" class="form-label">Support Page Title</label>
                            <textarea class="form-control" name="support_page_title" id="support_page_title" rows="3"><?= @$support_page_title ?></textarea>
                        </div>
                        <div class="col-12 mb-4">
                            <label for="support_page_seo_keyword" class="form-label">Support Page SEO Keyword</label>
                            <textarea class="form-control" name="support_page_seo_keyword" id="support_page_seo_keyword" rows="3"><?= @$support_page_seo_keyword ?></textarea>
                        </div>

                        <div class="col-12 mb-4">
                            <label for="support_page_description" class="form-label">Support Page Description</label>
                            <textarea class="form-control" name="support_page_description" id="support_page_description" rows="3"><?= @$support_page_description ?></textarea>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <div class="position-fixed bottom-0 end-0 translate-middle-x" style="z-index: 1000;">
            <button type="button" class="btn btn-primary m-4 p-2" style="width: 200px;" onclick="submitFormWithAjax('form',true,true,successCallback,errorCallback)">Save</button>
        </div>
    </form>
</div>
<script>
    function successCallback(response) {
        if (response.status == 201 || response.status == 200) {
            var data = JSON.parse(response.data);
            console.log(response.data);
            setTimeout(() => {
                window.location.href = '<?= base_url(route_to('default_dashboard')) ?>';
            }, 2000);
        }
    }

    function errorCallback(response) {
        console.log(response);
    }
</script>