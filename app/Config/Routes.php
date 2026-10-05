<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;
use MenuActionType as MAT;
// Load custom helpers
helper("commonfunction_helper");
helper('array');
/**
 * Automatically adds routes for all modules found in the specified directory.
 *
 * @param string $directory The directory to scan for modules.
 * @param RouteCollection $routes The route collection instance.
 * @return void
 */
/**
 * @var RouteCollection $routes
 */

if (!function_exists('autoAddRoutes')) {
    function autoAddRoutes(string $directory, RouteCollection $routes): void
    {
        $modules = scandir($directory);

        foreach ($modules as $module) {
            if ($module === '.' || $module === '..') {
                continue;
            }

            $fullPath = $directory . '/' . $module;

            if (is_dir($fullPath)) {
                $routesPath = $fullPath . '/Config/Routes.php';
                if (file_exists($routesPath)) {
                    // Load the module's routes
                    require $routesPath;
                }

                autoAddRoutes($fullPath, $routes);
            }
        }
    }
}

// Retrieve PHP_SELF
$php_self = $_SERVER['PHP_SELF'];

// Define allowed file extensions
$extensions = ['js', 'css', 'img', 'map', 'jpg', 'jpeg', 'png', 'gif', 'webp', 'woff', 'woff2', 'ttf', 'otf', 'mp4', 'webm', 'ogg', 'mp3', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt'];

// Extract file extension using pathinfo
$file_extension = pathinfo($php_self, PATHINFO_EXTENSION);
function encodeArray($array)
{
    $serializedArray = serialize($array);
    return urlencode($serializedArray);
}
if (!in_array($file_extension, $extensions)) {
    $routes->options('(:any)', 'EcommerceApiController::handleOptionsRequest');
    // Main Routes Start ---------------------------------------------------------------------------------------------------------------------
    $routes->get('/', 'AuthController::login', ['as' => 'admin_login_page']);
    $routes->get('/testing', 'AdminPageController::testing', ['as' => 'testing']);
    $routes->get('/sms_testing', 'AdminPageController::sms_testing', ['as' => 'sms_testing']);
    $routes->get('/logout', 'AuthController::logout', ['as' => 'admin_logout_page']);
    $routes->get('/forgetPassword', 'AuthController::forgetPassword', ['as' => 'forget_Password']);
    $routes->group('Auth', ['filter' => 'AdminAuthFilter'], function ($routes) {
        $routes->post('addUserTokenFirebase', 'FirebaseController::addUserTokenFirebase', ['as' => 'addUserTokenFirebase']);
        $routes->group('Dashboard', function ($routes) {
            $routes->get('/', 'AdminPageController::default_dashboard', ['as' => 'default_dashboard']);
            $routes->get('Admin', 'AdminPageController::admin_dashboard', ['as' => 'admin_dashboard']);
            $routes->get('Inventory', 'AdminPageController::inventory_dashboard', ['as' => 'inventory_dashboard']);
            $routes->get('Order', 'AdminPageController::order_dashboard', ['as' => 'order_dashboard']);
            $routes->get('Financial', 'AdminPageController::finance_dashboard', ['as' => 'financial_dashboard']);
            $routes->get('Delivery', 'AdminPageController::delivery_dashboard', ['as' => 'delivery_dashboard']);
            $routes->get('Stock', 'AdminPageController::stock_dashboard', ['as' => 'stock_dashboard']);
        });
        $routes->group('Admin', function ($routes) {
            $routes->get('RoleUserList', 'AdminPageController::role_user_list', ['as' => 'role_user_list']);
            $routes->get('UserRoleCreateUpdateComponent', 'AdminPageController::UserRoleCreateUpdateComponent', ['as' => 'UserRoleCreateUpdateComponent']);
            $routes->get('UserRoleCreateUpdateComponent/(:num)', 'AdminPageController::UserRoleCreateUpdateComponent/$1');
            $routes->get('BrandCreateUpdate', 'AdminPageController::BrandCreateUpdate', ['as' => 'BrandCreateUpdate']);
            $routes->get('BrandCreateUpdate/(:num)', 'AdminPageController::BrandCreateUpdate/$1');
            $routes->get('CategoryTypeCreateUpdate', 'AdminPageController::CategoryTypeCreateUpdate', ['as' => 'CategoryTypeCreateUpdate']);
            $routes->get('CategoryTypeCreateUpdate/(:num)', 'AdminPageController::CategoryTypeCreateUpdate/$1');
            $routes->get('CategoryCreateUpdate', 'AdminPageController::CategoryCreateUpdate', ['as' => 'CategoryCreateUpdate']);
            $routes->get('CategoryCreateUpdate/(:num)', 'AdminPageController::CategoryCreateUpdate/$1');

            $routes->get('FeatureTypeCreateUpdate', 'AdminPageController::FeatureTypeCreateUpdate', ['as' => 'FeatureTypeCreateUpdate']);
            $routes->get('FeatureTypeCreateUpdate/(:num)', 'AdminPageController::FeatureTypeCreateUpdate/$1');
            $routes->get('FeatureCreateUpdate', 'AdminPageController::FeatureCreateUpdate', ['as' => 'FeatureCreateUpdate']);
            $routes->get('FeatureCreateUpdate/(:num)', 'AdminPageController::FeatureCreateUpdate/$1');

            $routes->get('SizeCreateUpdate', 'AdminPageController::SizeCreateUpdate', ['as' => 'SizeCreateUpdate']);
            $routes->get('SizeCreateUpdate/(:num)', 'AdminPageController::SizeCreateUpdate/$1');
            $routes->get('ColorCreateUpdate', 'AdminPageController::ColorCreateUpdate', ['as' => 'ColorCreateUpdate']);
            $routes->get('ColorCreateUpdate/(:num)', 'AdminPageController::ColorCreateUpdate/$1');
            $routes->get('blog_post_create_update', 'AdminPageController::blog_post_create_update', ['as' => 'create_blog_post']);
            $routes->get('blog_post_create_update/(:any)', 'AdminPageController::blog_post_create_update/$1');

            $routes->get('BlogPostView', 'AdminPageController::blog_post', ['as' => 'BlogPostView']);
            $routes->get('CustomerList', 'AdminPageController::customer_list', ['as' => 'customer_list']);
            $routes->get('OfferList', 'AdminPageController::offer_list', ['as' => 'offer_list']);
            $routes->get('OfferCreateUpdate', 'AdminPageController::offer_create_update', ['as' => 'create_offer']);
            $routes->get('OfferCreateUpdate/(:any)', 'AdminPageController::offer_create_update/$1');
            $routes->get('OfferItemsAddRemove/(:any)', 'AdminPageController::offer_items/$1', ['as' => 'offer_items']);
            $routes->post('OfferItemsCreateUpdate', 'AdminPageController::offer_items_create_update', ['as' => 'offer_items_create_update']);
            $routes->group('Company', function ($routes) {
                $routes->get('CompanyTemplate', 'AdminPageController::company_template', ['as' => 'company_template']);
                $routes->get('EcommerceSetup', 'AdminPageController::ecommerce_setup', ['as' => 'ecommerce_setup']);
                $routes->get('SliderStyle', 'AdminPageController::slider_style', ['as' => 'slider_style']);
            });
            $routes->group('Coupon', function ($routes) {
                $routes->get('CouponList', 'AdminPageController::coupon_list', ['as' => 'coupon_list']);
                $routes->get('ReferCouponList', 'AdminPageController::refer_coupon_list', ['as' => 'refer_coupon_list']);
                $routes->get('CouponCreateUpdate', 'AdminPageController::coupon_create_update', ['as' => 'coupon_create_update']);
                $routes->get('CouponCreateUpdate/(:any)', 'AdminPageController::coupon_create_update/$1');
            });
            $routes->group('Pages', function ($routes) {
                $routes->get('HeaderFooter', 'AdminPageController::header_footer', ['as' => 'header_footer']);
                $routes->get('Home', 'AdminPageController::home', ['as' => 'home']);
                $routes->get('Contact', 'AdminPageController::contact', ['as' => 'contact']);
                $routes->get('Subscriber', 'AdminPageController::subscriber', ['as' => 'subscriber']);
                $routes->get('TopPayCustomer', 'AdminPageController::top_paying_customer_list', ['as' => 'top_paying_customer_list']);
                $routes->get('ReturnableCustomer', 'AdminPageController::returnable_customer_list', ['as' => 'returnable_customer_list']);
                $routes->get('ReferrerCustomers', 'AdminPageController::referrer_customer_list', ['as' => 'referrer_customer_list']);
                $routes->get('ReferredCustomers/(:any)/(:any)', 'AdminPageController::referred_customer_list/$1/$2', ['as' => 'referred_customer_list']);
                $routes->get('EarnReferredCustomers/(:any)/(:any)', 'AdminPageController::earning_referred_customer/$1/$2', ['as' => 'earning_referred_customer']);
                $routes->get('EarnReferrerCustomers', 'AdminPageController::earning_referrer_customer_list', ['as' => 'earning_referrer_customer_list']);
                $routes->get('PendingWithdrawalRequest', 'AdminPageController::pending_withdrawal_request_list', ['as' => 'pending_withdrawal_request_list']);
                $routes->get('ApprovedWithdrawalRequest', 'AdminPageController::approved_withdrawal_request_list', ['as' => 'approved_withdrawal_request_list']);
                $routes->get('PaidWithdrawalRequest', 'AdminPageController::paid_withdrawal_request_list', ['as' => 'paid_withdrawal_request_list']);
                $routes->get('RejectWithdrawalRequest', 'AdminPageController::reject_withdrawal_request_list', ['as' => 'reject_withdrawal_request_list']);
                $routes->get('PurchasedWalletCustomers', 'AdminPageController::purchased_withdrawal_customer_list', ['as' => 'purchased_withdrawal_customer_list']);
                $routes->get('ShareRefernceList', 'AdminPageController::share_reference_detail', ['as' => 'share_reference_detail']);
                $routes->get('About', 'AdminPageController::about', ['as' => 'about']);
                $routes->get('Support', 'AdminPageController::support_us', ['as' => 'support_us']);
                $routes->get('FAQ', 'AdminPageController::FAQ', ['as' => 'FAQ']);
                $routes->get('Career', 'AdminPageController::career', ['as' => 'career']);
                $routes->get('TermCondition', 'AdminPageController::term_condition', ['as' => 'term_condition']);
                $routes->get('PrivacyPolicy', 'AdminPageController::privacy_policy', ['as' => 'privacy_policy']);
                $routes->get('ShippingPolicy', 'AdminPageController::shipping_policy', ['as' => 'shipping_policy']);
                $routes->get('ReturnPolicy', 'AdminPageController::return_policy', ['as' => 'return_policy']);
                $routes->get('RefundPolicy', 'AdminPageController::refund_policy', ['as' => 'refund_policy']);
                $routes->get('Disclaimer', 'AdminPageController::disclaimer', ['as' => 'disclaimer']);
            });

            $routes->group('Enquire', function ($routes) {
                $routes->get('Contact', 'AdminPageController::contact_us_list', ['as' => 'contact_us_list']);
                $routes->get('Support', 'AdminPageController::support_list', ['as' => 'support_list']);
                $routes->get('Career', 'AdminPageController::career_list', ['as' => 'career_list']);
                $routes->get('Sales', 'AdminPageController::sales_list', ['as' => 'sales_list']);
                $routes->get('SubscriberList', 'AdminPageController::subsctiber_list', ['as' => 'subscriber_list']);
                $routes->get('UnSubscriberList', 'AdminPageController::unsubscriber_list', ['as' => 'unsubscriber_list']);
                $routes->get('ReviewList', 'AdminPageController::review_list', ['as' => 'review_list']);
                $routes->get('WishlistList', 'AdminPageController::wishlist_list', ['as' => 'wishlist_list']);
                $routes->get('CartList', 'AdminPageController::cart_list', ['as' => 'cart_list']);
                $routes->get('FAQList', 'AdminPageController::faq_list', ['as' => 'faq_list']);
                $routes->get('faq_create_update', 'AdminPageController::faq_create_update', ['as' => 'faq_create_update']);
                $routes->get('faq_create_update/(:any)', 'AdminPageController::faq_create_update/$1');
            });
            $routes->group('Integration', function ($routes) {
                $routes->get('ThirdPartyIntegration', 'AdminPageController::third_party_integration', ['as' => 'third_party_integration']);
                $routes->get('EmailSmsTemplate', 'AdminPageController::email_sms_template', ['as' => 'email_sms_template']);
                $routes->post('View', 'AdminPageController::email_sms_template_form', ['as' => 'email_sms_template_form']);
            });
        });
        $routes->group('Inventory', function ($routes) {
            $routes->get('Category', 'AdminPageController::category_list', ['as' => 'category_list']);
            $routes->get('CategoryType', 'AdminPageController::category_type_list', ['as' => 'category_type_list']);
            $routes->get('Feature', 'AdminPageController::feature_list', ['as' => 'feature_list']);
            $routes->get('FeatureType', 'AdminPageController::feature_type_list', ['as' => 'feature_type_list']);
            $routes->get('AddBrand', 'AdminPageController::brand_list', ['as' => 'brand_list']);
            $routes->get('AddPattern', 'AdminPageController::pattern_list', ['as' => 'pattern_list']);
            $routes->get('Color', 'AdminPageController::color_list', ['as' => 'color_list']);
            $routes->get('Size', 'AdminPageController::size_list', ['as' => 'size_list']);
            $routes->get('ProductManage', 'AdminPageController::product_manage', ['as' => 'product_manage']);
            $routes->get('ProductCreateUpdate', 'AdminPageController::product_create_update', ['as' => 'create_product']);
            $routes->get('ProductCreateUpdate/(:any)', 'AdminPageController::product_create_update/$1');
            $routes->get('VariantProducts/(:any)', 'AdminPageController::variant_list/$1', ['as' => 'variant_list']);
            $routes->get('VariantCreateUpdate/(:any)', 'AdminPageController::variant_create_update/$1', ['as' => 'variant_create_update']);
            $routes->get('VariantCreateUpdate/(:any)/(:any)', 'AdminPageController::variant_create_update/$1/$2', ['as' => 'update_variant']);
            $routes->post('VariantView', 'AdminPageController::variant_view_detail', ['as' => 'VariantView']);
            $routes->post('ProductView', 'AdminPageController::product_view_detail', ['as' => 'ProductView']);
            $routes->get('FacebookPixel', 'AdminPageController::facebook_pixel', ['as' => 'facebook_pixel']);
            $routes->get('GoogleTag', 'AdminPageController::google_tag_manager', ['as' => 'google_tag_manager']);
            $routes->get('MicrosoftUniversalEventTracking', 'AdminPageController::microsoft_universal_event_tracking', ['as' => 'microsoft_universal_event_tracking']);
            $routes->group('Stock', function ($routes) {
                $routes->get('stock_update', 'AdminPageController::stock_update', ['as' => 'stock_update']);
                $routes->get('StockUpdate', 'AdminPageController::add_update_stock', ['as' => 'update_stock']);
            });
        });
        $routes->group('Finance', function ($routes) {
            $routes->get('Dashboard', 'AdminPageController::Dashboard', ['as' => 'Dashboard']);
            $routes->get('PaymentPending', 'AdminPageController::order_list/finance_pending_order', ['as' => 'payment_pending']);
            $routes->get('RefundToCustomer', 'AdminPageController::order_list/refund_to_customer', ['as' => 'refund_to_customer']);
            $routes->get('ReturnApproved', 'AdminPageController::order_list/request_return_approved', ['as' => 'request_return_approved']);
            $routes->get('RazorpayPaymentApproved', 'AdminPageController::order_list/razorpay_payment_approved', ['as' => 'razorpay_payment_approved']);
        });
        $routes->group('Order', function ($routes) {
            $routes->get('AllOrder', 'AdminPageController::order_list/all_order', ['as' => 'all_order']);
            $routes->get('PendingApproval', 'AdminPageController::order_list/admin_pending_approval', ['as' => 'admin_pending_approval']);
            $routes->get('CancelOrders', 'AdminPageController::order_list/cancel_order', ['as' => 'cancel_order']);
            $routes->get('ReturnRequestPending', 'AdminPageController::order_list/return_request_pending', ['as' => 'return_request_pending']);
            $routes->get('ReturnRequestReject', 'AdminPageController::order_list/return_request_reject', ['as' => 'return_request_reject']);
            $routes->get('ExchangeRequestPending', 'AdminPageController::order_list/exchange_request_pending', ['as' => 'exchange_request_pending']);
        });
        $routes->group('Delivery', function ($routes) {
            $routes->get('PendingOrders', 'AdminPageController::order_list/delivery_pending_orders', ['as' => 'delivery_pending_orders']);
            $routes->get('ReadyToShipOrders', 'AdminPageController::order_list/delivery_ready_to_ship', ['as' => 'delivery_ready_to_ship']);
            $routes->get('ShippedOrders', 'AdminPageController::order_list/delivery_shipped', ['as' => 'delivery_shipped']);
            $routes->get('DeliveredOrders', 'AdminPageController::order_list/delivered', ['as' => 'delivered']);
            $routes->get('NotDeliveredOrder', 'AdminPageController::order_list/order_not_delivered', ['as' => 'order_not_delivered']);
            $routes->get('invoice', 'AdminApiController::downloadInvoice', ['as' => 'invoice_download']);
        });
        $routes->post('ShipmentTrack', 'AdminPageController::shipment_tracking', ['as' => 'ShipmentTrack']);
        $routes->post('OrderView', 'AdminPageController::order_detail', ['as' => 'OrderView']);
        $routes->post('orderStatusChange', 'AdminApiController::orderStatusChange', ['as' => 'orderStatusChange']);
        $routes->group('Report', function ($routes) {
            $routes->get('ItemWithVariants', 'AdminPageController::item_with_variants', ['as' => 'item_with_variants']);
        });
        $routes->post('ReviewView', 'AdminPageController::review_detail', ['as' => 'ReviewView']);
        $routes->post('ReferView', 'AdminPageController::refer_detail', ['as' => 'ReferView']);
        $routes->post('deleteNotification', 'AdminPageController::deleteNotification', ['as' => 'deleteNotification']);
    });
    // Admin Panel Api Start -----------------------------------------------------------------------------------------------------------
    $routes->group('adminApi', function ($routes) {
        $routes->group('user', function ($routes) {
            $routes->post('login', 'AdminApiController::UserLogin', ['as' => 'userLoginApi']);
            $routes->post('UserForgetPasswordOtpSend', 'AdminApiController::UserForgetPasswordOtpSend', ['as' => 'UserForgetPasswordOtpSend']);
            $routes->post('UserForgetPasswordUpdate', 'AdminApiController::UserForgetPasswordUpdate', ['as' => 'UserForgetPasswordUpdate']);
        });


        // Admin Panel Api Without Midware Start
        $routes->group('Country', function ($routes) {
            $routes->post('Get', 'AdminApiController::CountryGet');
            $routes->post('List', 'AdminApiController::CountryList');
            $routes->post('Create', 'AdminApiController::CountryCreate');
            $routes->post('Update', 'AdminApiController::CountryUpdate');
            $routes->post('Delete', 'AdminApiController::CountryDelete');
        });
        $routes->group('State', function ($routes) {
            $routes->post('Get', 'AdminApiController::StateGet');
            $routes->post('List', 'AdminApiController::StateList');
            $routes->post('Create', 'AdminApiController::StateCreate');
            $routes->post('Update', 'AdminApiController::StateUpdate');
            $routes->post('Delete', 'AdminApiController::StateDelete');
        });
        $routes->group('City', function ($routes) {
            $routes->post('Get', 'AdminApiController::CityGet');
            $routes->post('List', 'AdminApiController::CityList');
            $routes->post('Create', 'AdminApiController::CityCreate');
            $routes->post('Update', 'AdminApiController::CityUpdate');
            $routes->post('Delete', 'AdminApiController::CityDelete');
        });
        $routes->group('Auth', ['filter' => 'AdminApiAuthFilter'], function ($routes) {
            // User Routes
            $routes->group('User', function ($routes) {
                $routes->post('Get', 'AdminApiController::UserGet');
                $routes->post('List', 'AdminApiController::UserList', ['as' => 'user_list_api']);
                $routes->post('Create', 'AdminApiController::UserCreate', ['as' => 'user_create_api']);
                $routes->post('Update', 'AdminApiController::UserUpdate', ['as' => 'user_update_api']);
                $routes->post('Delete', 'AdminApiController::UserDelete', ['as' => 'user_delete_api']);
            });
            $routes->group('FileUpload', function ($routes) {
                $routes->post('ImageUpload', 'AdminApiController::ImageUpload', ['as' => 'file_upload_image_api']);
                $routes->post('ImageDelete', 'AdminApiController::deleteImage', ['as' => 'file_delete_image_api']);
            });
            $routes->group('Brand', function ($routes) {
                $routes->post('Get', 'AdminApiController::BrandGet', ['as' => 'brand_get_api']);
                $routes->post('List', 'AdminApiController::BrandList', ['as' => 'brand_list_api']);
                $routes->post('Create', 'AdminApiController::BrandCreate', ['as' => 'brand_create_api']);
                $routes->post('Update', 'AdminApiController::BrandUpdate', ['as' => 'brand_update_api']);
                $routes->post('Delete', 'AdminApiController::BrandDelete', ['as' => 'brand_delete_api']);
            });
            $routes->group('CategoryType', function ($routes) {
                $routes->post('Get', 'AdminApiController::CategoryTypeGet', ['as' => 'categoryType_get_api']);
                $routes->post('List', 'AdminApiController::CategoryTypeList', ['as' => 'categoryType_list_api']);
                $routes->post('Create', 'AdminApiController::CategoryTypeCreate', ['as' => 'categoryType_create_api']);
                $routes->post('Update', 'AdminApiController::CategoryTypeUpdate', ['as' => 'categoryType_update_api']);
                $routes->post('Delete', 'AdminApiController::CategoryTypeDelete', ['as' => 'categoryType_delete_api']);
            });

            $routes->group('Category', function ($routes) {
                $routes->post('Get', 'AdminApiController::CategoryGet', ['as' => 'category_get_api']);
                $routes->post('List', 'AdminApiController::CategoryList', ['as' => 'category_list_api']);
                $routes->post('Create', 'AdminApiController::CategoryCreate', ['as' => 'category_create_api']);
                $routes->post('Update', 'AdminApiController::CategoryUpdate', ['as' => 'category_update_api']);
                $routes->post('Delete', 'AdminApiController::CategoryDelete', ['as' => 'category_delete_api']);
            });
            $routes->group('FeatureType', function ($routes) {
                $routes->post('Get', 'AdminApiController::FeatureTypeGet', ['as' => 'featureType_get_api']);
                $routes->post('List', 'AdminApiController::FeatureTypeList', ['as' => 'featureType_list_api']);
                $routes->post('Create', 'AdminApiController::FeatureTypeCreate', ['as' => 'featureType_create_api']);
                $routes->post('Update', 'AdminApiController::FeatureTypeUpdate', ['as' => 'featureType_update_api']);
                $routes->post('Delete', 'AdminApiController::FeatureTypeDelete', ['as' => 'featureType_delete_api']);
            });

            $routes->group('Feature', function ($routes) {
                $routes->post('Get', 'AdminApiController::FeatureGet', ['as' => 'feature_get_api']);
                $routes->post('List', 'AdminApiController::FeatureList', ['as' => 'feature_list_api']);
                $routes->post('Create', 'AdminApiController::FeatureCreate', ['as' => 'feature_create_api']);
                $routes->post('Update', 'AdminApiController::FeatureUpdate', ['as' => 'feature_update_api']);
                $routes->post('Delete', 'AdminApiController::FeatureDelete', ['as' => 'feature_delete_api']);
            });

            $routes->group('Product', function ($routes) {
                $routes->post('Get', 'AdminApiController::productGet', ['as' => 'product_get_api']);
                $routes->post('List', 'AdminApiController::productList', ['as' => 'product_list_api']);
                $routes->post('Create', 'AdminApiController::productCreate', ['as' => 'product_create_api']);
                $routes->post('Update', 'AdminApiController::productUpdate', ['as' => 'product_update_api']);
                $routes->post('Delete', 'AdminApiController::productDelete', ['as' => 'product_delete_api']);
                $routes->post('ExportProductInExcelForImport', 'AdminApiController::ExportProductInExcelForImport', ['as' => 'ExportProductInExcelForImport']);
                $routes->post('ImportProductByExcel', 'AdminApiController::ImportProductByExcel', ['as' => 'ImportProductByExcel']);
            });
            $routes->group('ProductVariant', function ($routes) {
                $routes->post('Get', 'AdminApiController::variantGet', ['as' => 'variant_get_api']);
                $routes->post('List', 'AdminApiController::variantList', ['as' => 'variant_list_api']);
                $routes->post('Create', 'AdminApiController::variantCreate', ['as' => 'variant_create_api']);
                $routes->post('Update', 'AdminApiController::variantUpdate', ['as' => 'variant_update_api']);
                $routes->post('Delete', 'AdminApiController::variantDelete', ['as' => 'variant_delete_api']);
                $routes->post('calculate_variant', 'AdminApiController::calculate_variant', ['as' => 'calculate_variant']);
            });

            $routes->group('Size', function ($routes) {
                $routes->post('Get', 'AdminApiController::sizeGet', ['as' => 'size_get_api']);
                $routes->post('List', 'AdminApiController::sizeList', ['as' => 'size_list_api']);
                $routes->post('Create', 'AdminApiController::sizeCreate', ['as' => 'size_create_api']);
                $routes->post('Update', 'AdminApiController::sizeUpdate', ['as' => 'size_update_api']);
                $routes->post('Delete', 'AdminApiController::sizeDelete', ['as' => 'size_delete_api']);
            });

            $routes->group('Unit', function ($routes) {
                $routes->post('Get', 'AdminApiController::unitGet', ['as' => 'unit_get_api']);
                $routes->post('List', 'AdminApiController::unitList', ['as' => 'unit_list_api']);
                $routes->post('Create', 'AdminApiController::unitCreate', ['as' => 'unit_create_api']);
                $routes->post('Update', 'AdminApiController::unitUpdate', ['as' => 'unit_update_api']);
                $routes->post('Delete', 'AdminApiController::unitDelete', ['as' => 'unit_delete_api']);
            });
            $routes->group('Color', function ($routes) {
                $routes->post('Get', 'AdminApiController::colorGet', ['as' => 'color_get_api']);
                $routes->post('List', 'AdminApiController::colorList', ['as' => 'color_list_api']);
                $routes->post('Create', 'AdminApiController::colorCreate', ['as' => 'color_create_api']);
                $routes->post('Update', 'AdminApiController::colorUpdate', ['as' => 'color_update_api']);
                $routes->post('Delete', 'AdminApiController::colorDelete', ['as' => 'color_delete_api']);
            });

            $routes->group('Stock', function ($routes) {
                $routes->post('Get', 'AdminApiController::stockGet', ['as' => 'stock_get_api']);
                $routes->post('List', 'AdminApiController::stockList', ['as' => 'stock_list_api']);
                $routes->post('Create', 'AdminApiController::stockCreate', ['as' => 'stock_create_api']);
                $routes->post('Update', 'AdminApiController::stockUpdate', ['as' => 'stock_update_api']);
                $routes->post('stockDeleteCreate', 'AdminApiController::stockDeleteCreate', ['as' => 'stockDeleteCreate']);
                $routes->post('Delete', 'AdminApiController::stockDelete', ['as' => 'stock_delete_api']);
                $routes->post('ProductWiseStockList', 'AdminApiController::ProductWiseStockList', ['as' => 'ProductWiseStockList']);
            });
            $routes->group('Offers', function ($routes) {
                $routes->post('Get', 'AdminApiController::offerGet', ['as' => 'offer_get_api']);
                $routes->post('List', 'AdminApiController::offerList', ['as' => 'offer_list_api']);
                $routes->post('Create', 'AdminApiController::offerCreate', ['as' => 'offer_create_api']);
                $routes->post('Update', 'AdminApiController::offerUpdate', ['as' => 'offer_update_api']);
                $routes->post('Delete', 'AdminApiController::offerDelete', ['as' => 'offer_delete_api']);
                $routes->post('offer_item_list_for_create_update', 'AdminApiController::offer_item_list_for_create_update', ['as' => 'offer_item_list_for_create_update']);
            });
            $routes->group('OffersItem', function ($routes) {
                $routes->post('Get', 'AdminApiController::offerItemGet', ['as' => 'offerItem_get_api']);
                $routes->post('List', 'AdminApiController::offerItemList', ['as' => 'offerItem_list_api']);
                $routes->post('Create', 'AdminApiController::offerItemCreate', ['as' => 'offerItem_create_api']);
                $routes->post('Update', 'AdminApiController::offerItemUpdate', ['as' => 'offerItem_update_api']);
                $routes->post('Delete', 'AdminApiController::offerItemDelete', ['as' => 'offer_delete_api']);
            });
            $routes->group('WebsiteProfile', function ($routes) {
                $routes->post('Create', 'AdminApiController::WebsiteProfileCreate', ['as' => 'website_profile_create_api']);
                $routes->post('Update', 'AdminApiController::WebsiteProfileUpdate', ['as' => 'website_profile_update_api']);
            });
            $routes->group('BlogPost', function ($routes) {
                $routes->post('Get', 'AdminApiController::blogPostGet', ['as' => 'blog_post_get_api']);
                $routes->post('List', 'AdminApiController::blogPostList', ['as' => 'blog_post_list_api']);
                $routes->post('Create', 'AdminApiController::blogPostCreate', ['as' => 'blog_post_create_api']);
                $routes->post('Update', 'AdminApiController::blogPostUpdate', ['as' => 'blog_post_update_api']);
                $routes->post('Delete', 'AdminApiController::blogPostDelete', ['as' => 'blog_post_delete_api']);
            });
            $routes->group('Coupon', function ($routes) {
                $routes->post('Get', 'AdminApiController::CouponGet', ['as' => 'coupon_get_api']);
                $routes->post('List', 'AdminApiController::CouponList', ['as' => 'coupon_list_api']);
                $routes->post('Create', 'AdminApiController::CouponCreate', ['as' => 'coupon_create_api']);
                $routes->post('Update', 'AdminApiController::CouponUpdate', ['as' => 'coupon_update_api']);
                $routes->post('Delete', 'AdminApiController::CouponDelete', ['as' => 'coupon_delete_api']);
            });
            $routes->group('EnquireList', function ($routes) {
                $routes->post('List', 'AdminApiController::FormSubmissionsList', ['as' => 'enquire_list_api']);
                $routes->post('Update', 'AdminApiController::FormSubmissionsUpdate', ['as' => 'enquire_update_api']);
            });
            $routes->group('ContactList', function ($routes) {
                $routes->post('List', 'AdminApiController::ContactList', ['as' => 'contact_list_api']);
                $routes->post('Update', 'AdminApiController::ContactUpdate', ['as' => 'contact_update_api']);
            });

            $routes->group('ReviewList', function ($routes) {
                $routes->post('Get', 'AdminApiController::reviewGet', ['as' => 'review_get_api']);
                $routes->post('List', 'AdminApiController::reviewList', ['as' => 'review_list_api']);
                $routes->post('Update', 'AdminApiController::reviewUpdate', ['as' => 'review_update_api']);
            });
            $routes->group('WishlistList', function ($routes) {
                $routes->post('Get', 'AdminApiController::wishlistGet', ['as' => 'wishlist_get_api']);
                $routes->post('List', 'AdminApiController::wishlistList', ['as' => 'wishlist_list_api']);
                $routes->post('Update', 'AdminApiController::wishlistUpdate', ['as' => 'wishlist_update_api']);
                $routes->post('Delete', 'AdminApiController::wishlistDelete', ['as' => 'wishlist_delete_api']);
            });
            $routes->group('CartList', function ($routes) {
                $routes->post('Get', 'AdminApiController::cartGet', ['as' => 'cart_get_api']);
                $routes->post('List', 'AdminApiController::cartList', ['as' => 'cart_list_api']);
                $routes->post('Update', 'AdminApiController::cartUpdate', ['as' => 'cart_update_api']);
                $routes->post('Delete', 'AdminApiController::cartDelete', ['as' => 'cart_delete_api']);
            });
            $routes->group('FaqList', function ($routes) {
                $routes->post('Get', 'AdminApiController::faqGet', ['as' => 'faq_get_api']);
                $routes->post('List', 'AdminApiController::faqList', ['as' => 'faq_list_api']);
                $routes->post('Create', 'AdminApiController::faqCreate', ['as' => 'faq_create_api']);
                $routes->post('Update', 'AdminApiController::faqUpdate', ['as' => 'faq_update_api']);
                $routes->post('Delete', 'AdminApiController::faqDelete', ['as' => 'faq_delete_api']);
            });
            $routes->group('UnSubscriberList', function ($routes) {
                $routes->post('Get', 'AdminApiController::unsubscriberGet', ['as' => 'unsubscriber_get_api']);
                $routes->post('List', 'AdminApiController::unsubscriberList', ['as' => 'unsubscriber_list_api']);
            });
            $routes->group('Subscription', function ($routes) {
                $routes->post('Get', 'AdminApiController::subscriptionGet', ['as' => 'subscription_get_api']);
                $routes->post('List', 'AdminApiController::subscriptionList', ['as' => 'subscription_list_api']);
                $routes->post('Create', 'AdminApiController::subscriptionCreate', ['as' => 'subscription_create_api']);
                $routes->post('Update', 'AdminApiController::subscriptionUpdate', ['as' => 'subscription_update_api']);
                $routes->post('Delete', 'AdminApiController::subscriptionDelete', ['as' => 'subscription_update_api']);
            });
            $routes->group('CustomerList', function ($routes) {
                $routes->post('Get', 'AdminApiController::customerGet', ['as' => 'customer_get_api']);
                $routes->post('List', 'AdminApiController::customerList', ['as' => 'customer_list_api']);
                $routes->post('Create', 'AdminApiController::customerCreate', ['as' => 'customer_create_api']);
                $routes->post('Update', 'AdminApiController::customerUpdate', ['as' => 'customer_update_api']);
                $routes->post('Delete', 'AdminApiController::customerDelete', ['as' => 'customer_delete_api']);
            });
            $routes->group('OrderList', function ($routes) {
                $routes->post('Get', 'AdminApiController::orderGet', ['as' => 'order_get_api']);
                $routes->post('List', 'AdminApiController::orderList', ['as' => 'order_list_api']);
                $routes->post('Create', 'AdminApiController::orderCreate', ['as' => 'order_create_api']);
                $routes->post('Update', 'AdminApiController::orderUpdate', ['as' => 'order_update_api']);
                $routes->post('Delete', 'AdminApiController::orderDelete', ['as' => 'order_delete_api']);
            });
            $routes->post('FinanceorderList', 'AdminApiController::FinanceorderList', ['as' => 'FinanceorderList']);
            $routes->post('PaymentConfirmOrdersList', 'AdminApiController::PaymentConfirmOrdersList', ['as' => 'PaymentConfirmOrdersList']);
            $routes->post('SubscriberList', 'AdminApiController::subscriberList', ['as' => 'subscriber_list_api']);
            $routes->post('TopPayCustomerList', 'AdminApiController::top_paying_customer_api', ['as' => 'top_paying_customer_api']);
            $routes->post('ReturnableCustomerList', 'AdminApiController::returnable_customer_api', ['as' => 'returnable_customer_api']);
            $routes->post('ReferrerCustomerList', 'AdminApiController::getReferrerCustomers_api', ['as' => 'getReferrerCustomers_api']);
            $routes->post('ReferredCustomerList', 'AdminApiController::getReferredCustomers_api', ['as' => 'getReferredCustomers_api']);
            $routes->post('EarnReferredList', 'AdminApiController::getLevel1ReferredEarnCustomer_api', ['as' => 'getLevel1ReferredEarnCustomer_api']);
            $routes->post('EarnReferredChildList', 'AdminApiController::getLevel2ReferredEarnCustomer_api', ['as' => 'getLevel2ReferredEarnCustomer_api']);
            $routes->post('ShareRefrenceCustomerList', 'AdminApiController::share_reference_customer_list', ['as' => 'share_reference_customer_list']);
            $routes->post('WithdrawalRequestList', 'AdminApiController::getWithdrawalRequestList_api', ['as' => 'getWithdrawalRequestList_api']);
            $routes->post('WithdrawalRequestUpdate', 'AdminApiController::getUpdateWithdrawalRequest_api', ['as' => 'getUpdateWithdrawalRequest_api']);
            //delhivered api
            $routes->post('createShipping', 'AdminApiController::createShipping', ['as' => 'createShipping']);
            $routes->post('cancelShipping', 'AdminApiController::cancelShipping', ['as' => 'cancelShipping']);
            $routes->post('pickupShipping', 'AdminApiController::pickupShipping', ['as' => 'pickupShipping']);
            $routes->post('trackingShipping', 'AdminApiController::trackingShipping', ['as' => 'trackingShipping']);
            $routes->post('returnShipping', 'AdminApiController::returnShipping', ['as' => 'returnShipping']);
            $routes->post('CustomerOrderPaymentRefund', 'AdminApiController::customer_order_payment_refund_razorpay', ['as' => 'customer_order_payment_refund_razorpay']);
            // coupon and offer notification api
            $routes->post('sendOfferCouponNotification', 'AdminApiController::sendOfferCouponNotification', ['as' => 'sendOfferCouponNotification']);
            // Integration Settings Api
            $routes->post('third_party_integration_update_api', 'AdminApiController::third_party_integration_update_api', ['as' => 'third_party_integration_update_api']);
            $routes->post('email_sms_template_update_api', 'AdminApiController::email_sms_template_update_api', ['as' => 'email_sms_template_update_api']);
        });
    });

    // Ecommerce Api Start -------------------------------------------------------------------------------------------
    $routes->group('EcommerceApi', function ($routes) {
        $routes->group('FileUpload', function ($routes) {
            $routes->post('ImageUpload', 'EcommerceApiController::ImageUpload');
            $routes->post('ImageDelete', 'EcommerceApiController::deleteImage');
        });
        $routes->group('NoAuth', ['filter' => 'EcommerceApiNoAuthFilter'], function ($routes) {
            $routes->group('Customer', function ($routes) {
                $routes->post('Register', 'EcommerceApiController::customer_registration', ['as' => 'customer_registration']);
                $routes->post('RegisterVerification', 'EcommerceApiController::customer_registration_verification', ['as' => 'customer_registration_verification']);
                $routes->post('ForgetPassword', 'EcommerceApiController::customer_forget_password', ['as' => 'customer_forget_password']);
                $routes->post('ForgetPasswordVerification', 'EcommerceApiController::customer_forget_password_verification', ['as' => 'customer_forget_password_verification']);
                $routes->post('Login', 'EcommerceApiController::customer_login', ['as' => 'customer_login']);
                $routes->post('LoginOtp', 'EcommerceApiController::customer_login_otp', ['as' => 'customer_login_otp']);
                $routes->post('LoginOtpVerification', 'EcommerceApiController::customer_login_otp_verification', ['as' => 'customer_login_otp_verification']);
            });
            $routes->group('Pages', function ($routes) {
                $routes->post('Home', 'EcommerceApiController::home_page', ['as' => 'home_page']);
                $routes->post('ProductList', 'EcommerceApiController::product_listing_page', ['as' => 'product_listing_page']);
                $routes->match(['get', 'post'], 'ProductDetails', 'EcommerceApiController::product_detail_page');
                $routes->post('BlogPost', 'EcommerceApiController::blog_post', ['as' => 'blog_post']);
                $routes->post('BlogDetail', 'EcommerceApiController::blog_detail', ['as' => 'blog_detail']);
                $routes->post('OffersList', 'EcommerceApiController::offers_page', ['as' => 'offers_page']);
                $routes->post('OverAllOfferList', 'EcommerceApiController::frontend_offer_list', ['as' => 'offer_list']);
                $routes->post('CoupanList', 'EcommerceApiController::coupan_list', ['as' => 'coupan_list']);
                $routes->post('about_page', 'EcommerceApiController::about_page', ['as' => 'about_page']);
                $routes->post('contact_page', 'EcommerceApiController::contact_page', ['as' => 'contact_page']);
                $routes->post('career_page', 'EcommerceApiController::career_page', ['as' => 'career_page']);
                $routes->post('faq_page', 'EcommerceApiController::faq_page', ['as' => 'faq_page']);
                $routes->post('support_page', 'EcommerceApiController::support_page', ['as' => 'support_page']);
                $routes->post('term_and_condition_page', 'EcommerceApiController::term_and_condition_page', ['as' => 'term_and_condition_page']);
                $routes->post('privacy_and_policy_page', 'EcommerceApiController::privacy_and_policy_page', ['as' => 'privacy_and_policy_page']);
                $routes->post('return_policy_page', 'EcommerceApiController::return_policy_page', ['as' => 'return_policy_page']);
                $routes->post('refund_policy_page', 'EcommerceApiController::refund_policy_page', ['as' => 'refund_policy_page']);
                $routes->post('disclaimer_page', 'EcommerceApiController::disclaimer_page', ['as' => 'disclaimer_page']);
                $routes->post('customer_contact_us', 'EcommerceApiController::customer_contact_us', ['as' => 'customer_contact_us']);
                $routes->post('shipping_policy_page', 'EcommerceApiController::shipping_policy_page', ['as' => 'shipping_policy_page']);
            });
            $routes->group('Country', function ($routes) {
                $routes->post('CountryList', 'EcommerceApiController::CountryList', ['as' => 'CountryList']);
            });
            $routes->group('State', function ($routes) {
                $routes->post('StateList', 'EcommerceApiController::StateList', ['as' => 'StateList']);
            });
            $routes->group('City', function ($routes) {
                $routes->post('CityList', 'EcommerceApiController::CityList', ['as' => 'CityList']);
            });
            $routes->group('Product', function ($routes) {
                $routes->post('string_search_product_array_data', 'EcommerceApiController::string_search_product_array_data', ['as' => 'string_search_product_array_data']);
                $routes->post('color_product_array_data', 'EcommerceApiController::color_product_array_data', ['as' => 'color_product_array_data']);
                $routes->post('category_type_product_array_data', 'EcommerceApiController::category_type_product_array_data', ['as' => 'category_type_product_array_data']);
            });
        });
        $routes->group('Auth', ['filter' => 'EcommerceApiAuthFilter'], function ($routes) {
            $routes->post('addCustomerTokenFirebase', 'FirebaseController::addCustomerTokenFirebase', ['as' => 'addCustomerTokenFirebase']);
            $routes->group('Customer', function ($routes) {
                $routes->post('AddressCreate', 'EcommerceApiController::customer_address_create', ['as' => 'customer_address_create']);
                $routes->post('AddressList', 'EcommerceApiController::customer_address_list', ['as' => 'customer_address_list']);
                $routes->post('WishListCreateUpdate', 'EcommerceApiController::customer_wishlist_create_update', ['as' => 'customer_wishlist_create_update']);
                $routes->post('AddItemToCart', 'EcommerceApiController::customer_add_item_to_cart', ['as' => 'customer_add_item_to_cart']);
                $routes->post('LessItemToCart', 'EcommerceApiController::customer_less_item_to_cart', ['as' => 'customer_less_item_to_cart']);
                $routes->post('RemoveItemToCart', 'EcommerceApiController::customer_remove_item_to_cart', ['as' => 'customer_remove_item_to_cart']);
                $routes->post('CartList', 'EcommerceApiController::customer_cart_list', ['as' => 'customer_cart_list']);
                $routes->post('Checkout', 'EcommerceApiController::checkout_page', ['as' => 'checkout_page']);
                $routes->post('paymentVerify', 'EcommerceApiController::paymentVerify', ['as' => 'paymentVerify']);
                $routes->post('paymentFail', 'EcommerceApiController::paymentFail', ['as' => 'paymentFail']);
                $routes->post('ReviewCreateUpdate', 'EcommerceApiController::customer_review_create_update', ['as' => 'customer_review_create_update']);
                $routes->post('ReviewList', 'EcommerceApiController::customer_review_list', ['as' => 'customer_review_list']);
                $routes->post('ProfileUpdate', 'EcommerceApiController::customer_dob_update', ['as' => 'customer_dob_update']);
                $routes->post('WishListPage', 'EcommerceApiController::wishlist_page', ['as' => 'wishlist_page']);
                $routes->post('UserProfilePage', 'EcommerceApiController::customer_profile', ['as' => 'customer_profile']);
                $routes->post('AddressDelete', 'EcommerceApiController::customer_address_delete', ['as' => 'customer_address_delete']);
                $routes->post('NotificationList', 'EcommerceApiController::Notification_list', ['as' => 'Notification_list']);
                $routes->post('DeleteNotification', 'EcommerceApiController::DeleteNotification', ['as' => 'DeleteNotification']);
                $routes->group('Order', function ($routes) {

                    $routes->post('CustomerOrderList', 'EcommerceApiController::customer_order_list', ['as' => 'customer_order_list']);
                    $routes->post('CustomerOrderView', 'EcommerceApiController::customer_order_view', ['as' => 'customer_order_view']);
                    $routes->post('OrderCancel', 'EcommerceApiController::customer_order_cancel', ['as' => 'customer_order_cancel']);
                    $routes->post('OrderReturn', 'EcommerceApiController::customer_order_return', ['as' => 'customer_order_return']);
                    $routes->post('OrderExchange', 'EcommerceApiController::customer_order_exchange', ['as' => 'customer_order_exchange']);
                    $routes->post('OrderInvoice', 'EcommerceApiController::customer_order_invoice', ['as' => 'customer_order_invoice']);
                });
                $routes->group('Subscriber', function ($routes) {
                    $routes->post('SubscribeCreate', 'EcommerceApiController::subscriberCreate', ['as' => 'subscriber_create_api']);
                });
                $routes->group('ValidCoupon', function ($routes) {
                    $routes->post('ValidCouponList', 'EcommerceApiController::Order_apply_coupon_list', ['as' => 'Order_apply_coupon_list']);
                });
                $routes->group('Referred', function ($routes) {
                    $routes->post('ReferredList', 'EcommerceApiController::reffered_customer_list', ['as' => 'reffered_customer_list']);
                });
                $routes->group('Ewallet', function ($routes) {
                    $routes->post('EwalletActive', 'EcommerceApiController::ewallet_active', ['as' => 'ewallet_active']);
                    $routes->post('CustomerWalletSummary', 'EcommerceApiController::getCustomerWalletSummary', ['as' => 'getCustomerWalletSummary']);
                    $routes->post('CustomerWithdrawalReq', 'EcommerceApiController::customer_request_withdrawal_amount', ['as' => 'customer_request_withdrawal_amount']);
                });
                $routes->group('Delhivery', function ($routes) {
                    $routes->match(['get', 'post'], 'CheckPincodeServiceability', 'EcommerceApiController::checkPincodeServiceability', ['as' => 'checkPincodeServiceability']);
                    $routes->match(['get', 'post'], 'CalculateShippingCost', 'EcommerceApiController::calculateShippingCost', ['as' => 'calculateShippingCost']);
                });


                $routes->group('Comment', function ($routes) {});
            });
        });
        $routes->group('dashboard_api', function ($routes) {
            $routes->post("admin_dashboard_api", "AdminApiController::admin_dashboard_api", ['as' => 'admin_dashboard_api']);
            $routes->post("order_dashboard_api", "AdminApiController::order_dashboard_api", ['as' => 'order_dashboard_api']);
            $routes->post("finance_dashboard_api", "AdminApiController::finance_dashboard_api", ['as' => 'finance_dashboard_api']);
            $routes->post("stock_dashboard_api", "AdminApiController::stock_dashboard_api", ['as' => 'stock_dashboard_api']);
            $routes->post("delivered_dashboard_api", "AdminApiController::delivered_dashboard_api", ['as' => 'delivered_dashboard_api']);
        });
        $routes->post('updateOrderRemainingAmount', 'EcommerceApiController::updateOrderRemainingAmount', ['as' => 'updateOrderRemainingAmount']);
    });
}
