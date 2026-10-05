<?php

namespace App\Controllers;

use ApiResponseStatusCode;
use App\Controllers\AdminApiController;
use App\Controllers\BaseController;
use App\Traits\CommonTraits;
use UserType;
use \Mpdf\Mpdf;

class AdminPageController extends BaseController
{
    use CommonTraits;
    public function default_dashboard()
    {

        switch ($_SESSION['user_type']) {
            case UserType::Admin->value:
                return $this->admin_dashboard();
                break;
            case UserType::Inventory->value:
                return $this->stock_dashboard();
                break;
            case UserType::Finance->value:
                return $this->finance_dashboard();
                break;
            case UserType::Order:
                return $this->order_dashboard();
                break;
            case UserType::Delivery->value:
                return $this->delivery_dashboard();
                break;
        }
        return $this->admin_dashboard();
    }

    public function admin_dashboard()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Admin Dashboard';
        $theme_data['_page_title'] = 'Admin Dashboard';
        $theme_data['_breadcrumb1'] = 'Dashboard';
        $theme_data['_breadcrumb2'] = 'Admin Dashboard';
        $theme_data['_script_files'][] = $theme_data['_assets_path'] . 'assets/js/pages/dashboard.init.js';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Dashboard/admin_dashboard';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function inventory_dashboard()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Inventory Dashboard';
        $theme_data['_page_title'] = 'Inventory Dashboard';
        $theme_data['_breadcrumb1'] = 'Dashboard';
        $theme_data['_breadcrumb2'] = 'Admin Dashboard';
        $theme_data['_script_files'][] = $theme_data['_assets_path'] . 'assets/js/pages/dashboard.init.js';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Dashboard/inventory_dashboard';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function finance_dashboard()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Finance Dashboard';
        $theme_data['_page_title'] = 'Finance Dashboard';
        $theme_data['_breadcrumb1'] = 'Dashboard';
        $theme_data['_breadcrumb2'] = 'Finance Dashboard';
        $theme_data['_script_files'][] = $theme_data['_assets_path'] . 'assets/js/pages/dashboard.init.js';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Dashboard/finance_dashboard';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function order_dashboard()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Order Dashboard';
        $theme_data['_page_title'] = 'Order Dashboard';
        $theme_data['_breadcrumb1'] = 'Dashboard';
        $theme_data['_breadcrumb2'] = 'Order Dashboard';
        $theme_data['_script_files'][] = $theme_data['_assets_path'] . 'assets/js/pages/dashboard.init.js';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Dashboard/order_dashboard';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function delivery_dashboard()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Delivery Dashboard';
        $theme_data['_page_title'] = 'Delivery Dashboard';
        $theme_data['_breadcrumb1'] = 'Dashboard';
        $theme_data['_breadcrumb2'] = 'Delivery Dashboard';
        $theme_data['_script_files'][] = $theme_data['_assets_path'] . 'assets/js/pages/dashboard.init.js';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Dashboard/delivery_dashboard';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function stock_dashboard()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Stock Dashboard';
        $theme_data['_page_title'] = 'Stock Dashboard';
        $theme_data['_breadcrumb1'] = 'Dashboard';
        $theme_data['_breadcrumb2'] = 'Stock Dashboard';
        $theme_data['_script_files'][] = $theme_data['_assets_path'] . 'assets/js/pages/dashboard.init.js';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Dashboard/stock_dashboard';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function coupon_list()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Coupon';
        $theme_data['_page_title'] = 'Coupon';
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Coupon';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/Coupon/coupon_list';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function refer_coupon_list()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Refer Coupon';
        $theme_data['_page_title'] = 'Refer Coupon';
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Refer Coupon';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/Coupon/refer_coupon_list';
        $website_data = $this->getWebsiteProfileModel()->first() ?? [];
        $theme_data = array_merge($theme_data, $website_data, ['ApiUrl' => base_url(route_to('website_profile_update_api'))]);
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function coupon_create_update($coupon_id  = null)
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = ($coupon_id == null) ? "Coupon Create" : "Coupon Update";
        $theme_data['_page_title'] = ($coupon_id == null) ? "Coupon Create" : "Coupon Update";
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = ($coupon_id == null) ? "Coupon Create" : "Coupon Update";

        if (!empty($coupon_id)) {
            $coupon_data = $this->getCouponModel()->RecordGet($coupon_id);
            $theme_data = array_merge($theme_data, $coupon_data['data'], ['ApiUrl' => base_url(route_to('coupon_update_api'))]);
        } else {
            $theme_data = array_merge($theme_data, ['ApiUrl' => base_url(route_to('coupon_create_api'))]);
        }
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/Coupon/coupon_create_update';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function role_user_list()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Role User';
        $theme_data['_page_title'] = 'Role User';
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Role User';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/role_user_list';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function UserRoleCreateUpdateComponent($user_id = null)
    {
        $data = [];
        if (!empty($user_id)) {
            $user_data = $this->getUserModel()->RecordGet($user_id);
            $data = array_merge($user_data['data'], ['ApiUrl' => base_url(route_to('user_update_api'))]);
        } else {
            $data = array_merge(['ApiUrl' => base_url(route_to('user_create_api'))]);
        }
        return view("AdminPanelNew/components/UserRoleCreateUpdate", $data);
    }
    public function category_type_list()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Category Type';
        $theme_data['_page_title'] = 'Category Type';
        $theme_data['_breadcrumb1'] = 'Inventory';
        $theme_data['_breadcrumb2'] = 'Category Type';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Inventory/category_type_list';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function CategoryTypeCreateUpdate($category_type_id  = null)
    {
        $data = [];
        if (!empty($category_type_id)) {
            $CategoryType_data = $this->getCategoryTypeModel()->RecordGet($category_type_id);
            $data = array_merge($CategoryType_data['data'], ['ApiUrl' => base_url(route_to('categoryType_update_api'))]);
        } else {
            $data = array_merge(['ApiUrl' => base_url(route_to('categoryType_create_api'))]);
        }
        return view("AdminPanelNew/components/CategoryTypeCreateUpdate", $data);
    }
    public function category_list()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Category';
        $theme_data['_page_title'] = 'Category';
        $theme_data['_breadcrumb1'] = 'Inventory';
        $theme_data['_breadcrumb2'] = 'Category';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Inventory/category_list';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function CategoryCreateUpdate($category_id  = null)
    {
        $data = [];
        if (!empty($category_id)) {
            $Category_data = $this->getCategoryModel()->RecordGet($category_id);
            $data = array_merge($Category_data['data'], ['ApiUrl' => base_url(route_to('category_update_api'))]);
        } else {
            $data = array_merge(['ApiUrl' => base_url(route_to('category_create_api'))]);
        }
        return view("AdminPanelNew/components/CategoryCreateUpdate", $data);
    }

    public function brand_list()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Brand';
        $theme_data['_page_title'] = 'Brand';
        $theme_data['_breadcrumb1'] = 'Inventory';
        $theme_data['_breadcrumb2'] = 'Brand';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Inventory/brand_list';
        return view('AdminPanelNew/partials/main', $theme_data);
    }


    public function review_list()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Review';
        $theme_data['_page_title'] = 'Review';
        $theme_data['_breadcrumb1'] = 'Enquiry';
        $theme_data['_breadcrumb2'] = 'Review';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/Enquiry/review_list';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function wishlist_list()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Wishlist';
        $theme_data['_page_title'] = 'Wishlist';
        $theme_data['_breadcrumb1'] = 'Enquiry';
        $theme_data['_breadcrumb2'] = 'Wishlist';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/Enquiry/wishlist_list';
        return view('AdminPanelNew/partials/main', $theme_data);
    }

    public function cart_list()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Cart';
        $theme_data['_page_title'] = 'Cart';
        $theme_data['_breadcrumb1'] = 'Enquiry';
        $theme_data['_breadcrumb2'] = 'Cart';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/Enquiry/cart_list';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function item_with_variants()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Item With Variants';
        $theme_data['_page_title'] = 'Item With Variants';
        $theme_data['_breadcrumb1'] = 'Report';
        $theme_data['_breadcrumb2'] = 'Item With Variants';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/Report/item_with_variants';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function faq_list()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = "FAQ Create";
        $theme_data['_page_title'] = "FAQ Create";
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'FAQ Profile';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/Enquiry/faq_list';

        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function faq_create_update($faq_id = null)
    {
        // Fetch common data for the admin panel
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = ($faq_id == null) ? "faq Create" : "faq Update";
        $theme_data['_page_title'] = ($faq_id == null) ? "faq Create" : "faq Update";
        $theme_data['_breadcrumb1'] = 'Pages';
        $theme_data['_breadcrumb2'] = ($faq_id == null) ? "faq Create" : "faq Update";
        if ($faq_id !== null) {
            $faq_data = $this->getFaqModel()->RecordGet($faq_id);
            $theme_data = array_merge($theme_data, $faq_data['data'], ['ApiUrl' => base_url(route_to('faq_update_api'))]);
        } else {
            $theme_data = array_merge($theme_data, ['ApiUrl' => base_url(route_to('faq_create_api'))]);
        }
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/Enquiry/faq_create_update';
        return view('AdminPanelNew/partials/main', $theme_data);
    }



    public function contact_us_list()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'ContactUs';
        $theme_data['_page_title'] = 'ContactUs';
        $theme_data['_breadcrumb1'] = 'Enquiry';
        $theme_data['_breadcrumb2'] = 'ContactUs';
        $theme_data['form_type'] = 'contact_us';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/Enquiry/contact_us_list';
        return view('AdminPanelNew/partials/main', $theme_data);
    }


    public function BrandCreateUpdate($brand_id  = null)
    {
        $data = [];
        if (!empty($brand_id)) {
            $CategoryType_data = $this->getBrandModel()->RecordGet($brand_id);
            $data = array_merge($CategoryType_data['data'], ['ApiUrl' => base_url(route_to('brand_update_api'))]);
        } else {
            $data = array_merge(['ApiUrl' => base_url(route_to('brand_create_api'))]);
        }
        return view("AdminPanelNew/components/BrandCreateUpdate", $data);
    }

    public function SizeCreateUpdate($size_id  = null)
    {
        $data = [];
        if (!empty($size_id)) {
            $Size_data = $this->getSizeModel()->RecordGet($size_id);
            $data = array_merge($Size_data['data'], ['ApiUrl' => base_url(route_to('size_update_api'))]);
        } else {
            $data = array_merge(['ApiUrl' => base_url(route_to('size_create_api'))]);
        }
        return view("AdminPanelNew/components/SizeCreateUpdate", $data);
    }

    public function ColorCreateUpdate($color_id  = null)
    {
        $data = [];
        if (!empty($color_id)) {
            $Color_data = $this->getColorModel()->RecordGet($color_id);
            $data = array_merge($Color_data['data'], ['ApiUrl' => base_url(route_to('color_update_api'))]);
        } else {
            $data = array_merge(['ApiUrl' => base_url(route_to('color_create_api'))]);
        }
        return view("AdminPanelNew/components/ColorCreateUpdate", $data);
    }


    public function customer_list()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Customer';
        $theme_data['_page_title'] = 'Customer List';
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Customer List';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/customer_list';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function top_paying_customer_list()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Customer';
        $theme_data['_page_title'] = 'Top Pay Customer';
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Top Pay Customer';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/top_paying_customer';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function referrer_customer_list()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Customer';
        $theme_data['_page_title'] = 'Referrer Customer';
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Referrer Customer';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/referrer_customer';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function referred_customer_list($customer_id, $level)
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['refferred_data'] = $this->getCustomerModel()->find($customer_id);
        $theme_data = array_merge($theme_data, ['customer_id' => $customer_id]);
        $theme_data = array_merge($theme_data, ['level' => $level]);
        $customer = $this->getCustomerModel()->find($customer_id);
        $customerName = $customer['fullname'] ?? 'Customer';
        $theme_data['_meta_title'] = 'Customer';
        $theme_data['_page_title'] = $customerName . ' - Referred Customers';
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = $customerName . ' - Referred Customers';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/referred_customer';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function earning_referrer_customer_list()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Customer';
        $theme_data['_page_title'] = 'Earn Referrer Customer';
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Earn Referrer Customer';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/earning_referrer_customer';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function earning_referred_customer($customer_id, $level)
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['refferred_data'] = $this->getCustomerModel()->find($customer_id);
        $theme_data = array_merge($theme_data, ['customer_id' => $customer_id]);
        $theme_data = array_merge($theme_data, ['level' => $level]);
        $customer = $this->getCustomerModel()->find($customer_id);
        $customerName = $customer['fullname'] ?? 'Customer';
        $theme_data['_meta_title'] = 'Customer';
        $theme_data['_page_title'] = $customerName . ' - Earn Referred Customers';
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = $customerName . ' - Earn Referred Customers';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/earning_referred_customer';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function pending_withdrawal_request_list()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Customer';
        $theme_data['_page_title'] = 'Pending Withdrawal Request';
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Pending Withdrawal Request';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/pending_withdrawal_request';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function approved_withdrawal_request_list()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Customer';
        $theme_data['_page_title'] = 'Approved/Process Withdrawal Request';
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Approved/Process Withdrawal Request';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/approved_process_withdrawal_request';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function paid_withdrawal_request_list()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Customer';
        $theme_data['_page_title'] = 'Paid Withdrawal Request';
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Paid Withdrawal Request';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/paid_withdrawal_request';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function reject_withdrawal_request_list()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Customer';
        $theme_data['_page_title'] = 'Reject Withdrawal Request';
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Reject Withdrawal Request';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/reject_withdrawal_request';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function purchased_withdrawal_customer_list()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Customer';
        $theme_data['_page_title'] = 'Wallet Purchased Customer';
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Wallet Purchased Customer';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/purchased_withdrawal_customer';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function returnable_customer_list()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Customer';
        $theme_data['_page_title'] = 'Returnable Customer';
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Returnable Customer';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/returnable_customer';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function share_reference_detail()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Customer';
        $theme_data['_page_title'] = 'Share Reference Customer';
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Share Reference Customer';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/share_reference_detail';
        return view('AdminPanelNew/partials/main', $theme_data);
    }

    public function blog_post_create_update($blog_id = null)
    {
        // Fetch common data for the admin panel
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = ($blog_id == null) ? "Blog post Create" : "Blog post Update";
        $theme_data['_page_title'] = ($blog_id == null) ? "Blog post Create" : "Blog post Update";
        $theme_data['_breadcrumb1'] = 'Pages';
        $theme_data['_breadcrumb2'] = ($blog_id == null) ? "Blog post Create" : "Blog post Update";
        if ($blog_id !== null) {
            $blog_data = $this->getBlogPostModel()->RecordGet($blog_id);
            $theme_data = array_merge($theme_data, $blog_data['data'], ['ApiUrl' => base_url(route_to('blog_post_update_api'))]);
        } else {
            $theme_data = array_merge($theme_data, ['ApiUrl' => base_url(route_to('blog_post_create_api'))]);
        }
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/blog_post_create_update';
        return view('AdminPanelNew/partials/main', $theme_data);
    }


    public function slider_style()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] =  "Slider Style";
        $theme_data['_page_title'] =  "Slider Style";
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Slider Style';
        $data = [];
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/Company/slider_style';
        $data = array_merge($data, $theme_data); // Merging theme data into $data for the view

        return view('AdminPanelNew/partials/main', $data);
    }

    public function company_template()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Company Template';
        $theme_data['_page_title'] = 'Company Template';
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Company Template';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/Company/company_template';
        return view('AdminPanelNew/partials/main', $theme_data);
    }


    public function header_footer()
    {
        $theme_data = $this->admin_panel_common_data();
        $website_data = $this->getWebsiteProfileModel()->first();
        if (!empty($website_data)) {
            $theme_data = array_merge($theme_data, $website_data, ['ApiUrl' => base_url(route_to('website_profile_update_api'))]);
        } else {
            $theme_data = array_merge($theme_data, ['ApiUrl' => base_url(route_to('website_profile_create_api'))]);
        }
        $theme_data['_meta_title'] = "Header Footer Page";
        $theme_data['_page_title'] = "Header Footer Page";
        $theme_data['_breadcrumb1'] = 'Pages';
        $theme_data['_breadcrumb2'] = 'Header Footer';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/pages/Header';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function home()
    {
        $theme_data = $this->admin_panel_common_data();
        $website_data = $this->getWebsiteProfileModel()->first();
        if (!empty($website_data)) {
            $theme_data = array_merge($theme_data, $website_data, ['ApiUrl' => base_url(route_to('website_profile_update_api'))]);
        } else {
            $theme_data = array_merge($theme_data, ['ApiUrl' => base_url(route_to('website_profile_create_api'))]);
        }
        $theme_data['_meta_title'] = (isset($theme_data['website_profile_id'])) ? "Website Profile Create" : "Company Update";
        $theme_data['_page_title'] = (isset($theme_data['website_profile_id'])) ? "Company Create" : "Company Update";
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Website Profile';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/pages/Home';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function contact()
    {
        $theme_data = $this->admin_panel_common_data();
        $website_data = $this->getWebsiteProfileModel()->first();
        if (!empty($website_data)) {
            $theme_data = array_merge($theme_data, $website_data, ['ApiUrl' => base_url(route_to('website_profile_update_api'))]);
        } else {
            $theme_data = array_merge($theme_data, ['ApiUrl' => base_url(route_to('website_profile_create_api'))]);
        }
        $theme_data['_meta_title'] = (isset($theme_data['website_profile_id'])) ? "Website Profile Create" : "Company Update";
        $theme_data['_page_title'] = (isset($theme_data['website_profile_id'])) ? "Company Create" : "Company Update";
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Website Profile';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/pages/Contact';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function subscriber()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = "Subscriber List";
        $theme_data['_page_title'] = "Subscriber List";
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Website Profile';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/subscribers_list';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function about()
    {
        $theme_data = $this->admin_panel_common_data();
        $website_data = $this->getWebsiteProfileModel()->first();
        if (!empty($website_data)) {
            $theme_data = array_merge($theme_data, $website_data, ['ApiUrl' => base_url(route_to('website_profile_update_api'))]);
        } else {
            $theme_data = array_merge($theme_data, ['ApiUrl' => base_url(route_to('website_profile_create_api'))]);
        }
        $theme_data['_meta_title'] = (isset($theme_data['website_profile_id'])) ? "Website Profile Create" : "Company Update";
        $theme_data['_page_title'] = (isset($theme_data['website_profile_id'])) ? "Company Create" : "Company Update";
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Website Profile';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/pages/About';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function support_us()
    {
        $theme_data = $this->admin_panel_common_data();
        $website_data = $this->getWebsiteProfileModel()->first();
        if (!empty($website_data)) {
            $theme_data = array_merge($theme_data, $website_data, ['ApiUrl' => base_url(route_to('website_profile_update_api'))]);
        } else {
            $theme_data = array_merge($theme_data, ['ApiUrl' => base_url(route_to('website_profile_create_api'))]);
        }
        $theme_data['_meta_title'] = (isset($theme_data['website_profile_id'])) ? "Website Profile Create" : "Company Update";
        $theme_data['_page_title'] = (isset($theme_data['website_profile_id'])) ? "Company Create" : "Company Update";
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Website Profile';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/pages/Support_us';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function FAQ()
    {
        $theme_data = $this->admin_panel_common_data();
        $website_data = $this->getWebsiteProfileModel()->first();
        if (!empty($website_data)) {
            $theme_data = array_merge($theme_data, $website_data, ['ApiUrl' => base_url(route_to('website_profile_update_api'))]);
        } else {
            $theme_data = array_merge($theme_data, ['ApiUrl' => base_url(route_to('website_profile_create_api'))]);
        }
        $theme_data['_meta_title'] = (isset($theme_data['website_profile_id'])) ? "Website Profile Create" : "Company Update";
        $theme_data['_page_title'] = (isset($theme_data['website_profile_id'])) ? "Company Create" : "Company Update";
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Website Profile';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/pages/FAQ';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function career()
    {
        $theme_data = $this->admin_panel_common_data();
        $website_data = $this->getWebsiteProfileModel()->first();
        if (!empty($website_data)) {
            $theme_data = array_merge($theme_data, $website_data, ['ApiUrl' => base_url(route_to('website_profile_update_api'))]);
        } else {
            $theme_data = array_merge($theme_data, ['ApiUrl' => base_url(route_to('website_profile_create_api'))]);
        }
        $theme_data['_meta_title'] = (isset($theme_data['website_profile_id'])) ? "Website Profile Create" : "Company Update";
        $theme_data['_page_title'] = (isset($theme_data['website_profile_id'])) ? "Company Create" : "Company Update";
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Website Profile';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/pages/Career';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function term_condition()
    {
        $theme_data = $this->admin_panel_common_data();
        $website_data = $this->getWebsiteProfileModel()->first();
        if (!empty($website_data)) {
            $theme_data = array_merge($theme_data, $website_data, ['ApiUrl' => base_url(route_to('website_profile_update_api'))]);
        } else {
            $theme_data = array_merge($theme_data, ['ApiUrl' => base_url(route_to('website_profile_create_api'))]);
        }
        $theme_data['_meta_title'] = (isset($theme_data['website_profile_id'])) ? "Website Profile Create" : "Company Update";
        $theme_data['_page_title'] = (isset($theme_data['website_profile_id'])) ? "Company Create" : "Company Update";
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Website Profile';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/pages/Term_Condition';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function privacy_policy()
    {
        $theme_data = $this->admin_panel_common_data();
        $website_data = $this->getWebsiteProfileModel()->first();
        if (!empty($website_data)) {
            $theme_data = array_merge($theme_data, $website_data, ['ApiUrl' => base_url(route_to('website_profile_update_api'))]);
        } else {
            $theme_data = array_merge($theme_data, ['ApiUrl' => base_url(route_to('website_profile_create_api'))]);
        }
        $theme_data['_meta_title'] = (isset($theme_data['website_profile_id'])) ? "Website Profile Create" : "Company Update";
        $theme_data['_page_title'] = (isset($theme_data['website_profile_id'])) ? "Company Create" : "Company Update";
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Website Profile';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/pages/Privacy_policy';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function shipping_policy()
    {
        $theme_data = $this->admin_panel_common_data();
        $website_data = $this->getWebsiteProfileModel()->first();
        if (!empty($website_data)) {
            $theme_data = array_merge($theme_data, $website_data, ['ApiUrl' => base_url(route_to('website_profile_update_api'))]);
        } else {
            $theme_data = array_merge($theme_data, ['ApiUrl' => base_url(route_to('website_profile_create_api'))]);
        }
        $theme_data['_meta_title'] = (isset($theme_data['website_profile_id'])) ? "Website Profile Create" : "Company Update";
        $theme_data['_page_title'] = (isset($theme_data['website_profile_id'])) ? "Company Create" : "Company Update";
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Website Profile';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/pages/shipping_policy';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function return_policy()
    {
        $theme_data = $this->admin_panel_common_data();
        $website_data = $this->getWebsiteProfileModel()->first();
        if (!empty($website_data)) {
            $theme_data = array_merge($theme_data, $website_data, ['ApiUrl' => base_url(route_to('website_profile_update_api'))]);
        } else {
            $theme_data = array_merge($theme_data, ['ApiUrl' => base_url(route_to('website_profile_create_api'))]);
        }
        $theme_data['_meta_title'] = (isset($theme_data['website_profile_id'])) ? "Website Profile Create" : "Company Update";
        $theme_data['_page_title'] = (isset($theme_data['website_profile_id'])) ? "Company Create" : "Company Update";
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Website Profile';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/pages/Return_policy';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function refund_policy()
    {
        $theme_data = $this->admin_panel_common_data();
        $website_data = $this->getWebsiteProfileModel()->first();
        if (!empty($website_data)) {
            $theme_data = array_merge($theme_data, $website_data, ['ApiUrl' => base_url(route_to('website_profile_update_api'))]);
        } else {
            $theme_data = array_merge($theme_data, ['ApiUrl' => base_url(route_to('website_profile_create_api'))]);
        }
        $theme_data['_meta_title'] = (isset($theme_data['website_profile_id'])) ? "Website Profile Create" : "Company Update";
        $theme_data['_page_title'] = (isset($theme_data['website_profile_id'])) ? "Company Create" : "Company Update";
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Website Profile';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/pages/Refund_policy';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function disclaimer()
    {
        $theme_data = $this->admin_panel_common_data();
        $website_data = $this->getWebsiteProfileModel()->first();
        if (!empty($website_data)) {
            $theme_data = array_merge($theme_data, $website_data, ['ApiUrl' => base_url(route_to('website_profile_update_api'))]);
        } else {
            $theme_data = array_merge($theme_data, ['ApiUrl' => base_url(route_to('website_profile_create_api'))]);
        }
        $theme_data['_meta_title'] = (isset($theme_data['website_profile_id'])) ? "Website Profile Create" : "Company Update";
        $theme_data['_page_title'] = (isset($theme_data['website_profile_id'])) ? "Company Create" : "Company Update";
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Website Profile';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/pages/Disclaimer';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function size_list()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Size';
        $theme_data['_page_title'] = 'Size';
        $theme_data['_breadcrumb1'] = 'Inventory';
        $theme_data['_breadcrumb2'] = 'Size';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Inventory/size_list';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function facebook_pixel()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Facebook Pixel';
        $theme_data['_page_title'] = 'Facebook Pixel';
        $theme_data['_breadcrumb1'] = 'Inventory';
        $theme_data['_breadcrumb2'] = 'Facebook Pixel';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/Integration/facebook_pixel';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function google_tag_manager()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Google Tag Manager';
        $theme_data['_page_title'] = 'Google Tag Manager';
        $theme_data['_breadcrumb1'] = 'Inventory';
        $theme_data['_breadcrumb2'] = 'Google Tag Manager';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/Integration/google_tag_manager';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function microsoft_universal_event_tracking()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Microsoft Universal Event Tracking';
        $theme_data['_page_title'] = 'Microsoft Universal Event Tracking';
        $theme_data['_breadcrumb1'] = 'Inventory';
        $theme_data['_breadcrumb2'] = 'Microsoft Universal Event Tracking';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/Integration/microsoft_universal_event_tracking';
        return view('AdminPanelNew/partials/main', $theme_data);
    }

    public function feature_type_list()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Feature Type';
        $theme_data['_page_title'] = 'Feature Type';
        $theme_data['_breadcrumb1'] = 'Inventory';
        $theme_data['_breadcrumb2'] = 'Feature Type';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Inventory/feature_type_list';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function FeatureTypeCreateUpdate($feature_type_id  = null)
    {
        $data = [];
        if (!empty($feature_type_id)) {
            $FeatureType_data = $this->getFeatureTypeModel()->RecordGet($feature_type_id);
            $data = array_merge($FeatureType_data['data'], ['ApiUrl' => base_url(route_to('featureType_update_api'))]);
        } else {
            $data = array_merge(['ApiUrl' => base_url(route_to('featureType_create_api'))]);
        }
        return view("AdminPanelNew/components/FeatureTypeCreateUpdate", $data);
    }
    public function feature_list()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Feature';
        $theme_data['_page_title'] = 'Feature';
        $theme_data['_breadcrumb1'] = 'Inventory';
        $theme_data['_breadcrumb2'] = 'Feature';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Inventory/feature_list';
        return view('AdminPanelNew/partials/main', $theme_data);
    }


    public function color_list()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Color';
        $theme_data['_page_title'] = 'Color';
        $theme_data['_breadcrumb1'] = 'Inventory';
        $theme_data['_breadcrumb2'] = 'Color';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Inventory/color_list';
        return view('AdminPanelNew/partials/main', $theme_data);
    }

    public function blog_post()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Blog Post';
        $theme_data['_page_title'] = 'Blog Post';
        $theme_data['_breadcrumb1'] = 'Inventory';
        $theme_data['_breadcrumb2'] = 'Blog Post';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/blog_post';
        return view('AdminPanelNew/partials/main', $theme_data);
    }


    public function FeatureCreateUpdate($feature_id  = null)
    {
        $data = [];
        if (!empty($feature_id)) {
            $Feature_data = $this->getFeatureModel()->RecordGet($feature_id);
            $data = array_merge($Feature_data['data'], ['ApiUrl' => base_url(route_to('feature_update_api'))]);
        } else {
            $data = array_merge(['ApiUrl' => base_url(route_to('feature_create_api'))]);
        }
        return view("AdminPanelNew/components/FeatureCreateUpdate", $data);
    }

    public function product_manage()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Product';
        $theme_data['_page_title'] = 'Product';
        $theme_data['_breadcrumb1'] = 'Inventory';
        $theme_data['_breadcrumb2'] = 'Product';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Inventory/product_manage';
        return view('AdminPanelNew/partials/main', $theme_data);
    }

    public function product_create_update($product_id  = null)
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = ($product_id == null) ? "Product Create" : "Product Update";
        $theme_data['_page_title'] = ($product_id == null) ? "Product Create" : "Product Update";
        $theme_data['_breadcrumb1'] = 'Inventory';
        $theme_data['_breadcrumb2'] = ($product_id == null) ? "Product Create" : "Product Update";
        $theme_data = array_merge($theme_data, ['features' => []]);
        if (!empty($product_id)) {
            $Product_data = $this->getProductModel()->RecordGet($product_id);
            $theme_data = array_merge($theme_data, $Product_data['data'], ['ApiUrl' => base_url(route_to('product_update_api'))]);
            $features_data = $this->getProductVsFeatureModel()->RecordList(['product_id' => $product_id]);
            if (!empty($features_data['data'])) {
                $features = ['features' => array_column($features_data['data'], 'feature_id')];
                $theme_data = array_merge($theme_data, $features ?? []);
            }
        } else {
            $theme_data = array_merge($theme_data, ['ApiUrl' => base_url(route_to('product_create_api'))]);
        }
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Inventory/product_create_update';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function offer_list()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Offer';
        $theme_data['_page_title'] = 'Offer';
        $theme_data['_breadcrumb1'] = 'Offer';
        $theme_data['_breadcrumb2'] = 'Offer';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/offer_list';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function offer_create_update($offer_id  = null)
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = ($offer_id == null) ? "Offer Create" : "Offer Update";
        $theme_data['_page_title'] = ($offer_id == null) ? "Offer Create" : "Offer Update";
        $theme_data['_breadcrumb1'] = 'Pages';
        $theme_data['_breadcrumb2'] = ($offer_id == null) ? "Offer Create" : "Offer Update";
        if ($offer_id !== null) {
            $Offer_data = $this->getOfferModel()->RecordGet($offer_id);
            $theme_data = array_merge($theme_data, $Offer_data['data'], ['ApiUrl' => base_url(route_to('offer_update_api'))]);
            $offer_items = $this->getOfferItemModel()->where('offer_id', $offer_id)->findAll();
            $theme_data['offer_items'] = array_column($offer_items, 'variant_id') ?? [];
        } else {
            $theme_data = array_merge($theme_data, ['ApiUrl' => base_url(route_to('offer_create_api'))]);
        }
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/offer_create_update';
        return view('AdminPanelNew/partials/main', $theme_data);
    }



    public function variant_create_update($product_id, $variant_id = null)
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data = array_merge($theme_data, ['product_id' => $product_id]);
        $theme_data = array_merge($theme_data, ['sizes' => []]);
        if (!empty($variant_id)) {
            $variant_data = $this->getProductVariantModel()->RecordGet($variant_id);
            // $sizes_data = $this->getSizeVsVariantModel()->RecordList(['variant_id' => $variant_id]);
            // if (!empty($sizes_data['data'])) {
            //     $sizes = ['sizes' => array_column($sizes_data['data'], 'size_id')];
            //     $theme_data = array_merge($theme_data, $sizes ?? []);
            // }
            $theme_data = array_merge($theme_data, $variant_data['data']);
        } else {
            $theme_data = array_merge($theme_data);
        }
        $theme_data['_meta_title'] = ($variant_id == null) ? "Variant" : "Variant Update";
        $theme_data['_page_title'] = ($variant_id == null) ? "Variant" : "Variant Update";
        $theme_data['_breadcrumb1'] = 'Inventory';
        $theme_data['_breadcrumb2'] = ($variant_id == null) ? "Variant" : "Variant Update";
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Inventory/variant_create_update';
        return view('AdminPanelNew/partials/main', $theme_data);
    }

    public function variant_view_detail()
    {
        $variant_filter = [
            '_autojoin' => 'Y',
            '_select' => '*',
            'product_variant.variant_id' => $_POST['variant_id'],
            '_selectOther' => "(SELECT GROUP_CONCAT(s.size_name ORDER BY s.size_name SEPARATOR ', ')
            FROM size_vs_variant sv
            JOIN size s ON s.size_id = sv.size_id
            WHERE sv.variant_id = product_variant.variant_id) AS sizes"
        ];

        $variant_data = $this->getProductVariantModel()->RecordList($variant_filter);
        return view('AdminPanelNew/pages/component/variant_view_detail', $variant_data['data'][0]);
    }
    public function order_detail()
    {
        $data = getRequestData($this->request, 'ARRAY');
        $filter = [
            '_autojoin' => 'Y',
            '_select' => '*',
            'order_id' => $data['order_id']
        ];
        $order_data = $this->getOrderModel()->GetAllOrdersWithItems($filter);
        $data['order_data'] = $order_data[0] ?? [];

        $website_data = $this->getWebsiteProfileModel()->first();
        $pickup = $website_data['pickup_location'] ?? '';

        $data['order_data']['pickup_location'] = $pickup;

        log_message('debug', 'Order Data: ' . print_r($data['order_data'], true));

        return view('AdminPanelNew/pages/component/order_detail', $data);;
    }
    public function shipment_tracking()
    {
        $data = getRequestData($this->request, 'ARRAY');
        return view('AdminPanelNew/pages/component/shipment_tracking', $data);;
    }
    public function review_detail()
    {
        $data = getRequestData($this->request, 'ARRAY');
        $crm = $this->getCustomerReviewModel();
        $crm->select('customer_review.*');
        if (isset($data['variant_id'])) {
            $crm->where('customer_review.variant_id', $data['variant_id']);
        }
        if (isset($data['customer_id'])) {
            $crm->where('customer_review.customer_id', $data['customer_id']);
        }
        $crm->where('customer_review.customer_review_status', 1);
        $crm->autoJoin();
        $review_data = $crm->findAll();

        $data['review_data'] = (!empty($review_data)) ? $review_data : [];
        return view('AdminPanelNew/components/review_detail', $data);
    }
    public function refer_detail()
    {
        $data = getRequestData($this->request, 'ARRAY');
        $cm = $this->getCustomerModel();

        $cm->select('customer.*');
        if (!empty($data['reffer_by_id'])) {
            $cm->where('customer.refer_by_id IS NOT NULL');
            $cm->where('customer.refer_by_id !=', '');

            $refer_data = $cm->findAll();
        }

        $data['refer_data'] = (!empty($refer_data)) ? $refer_data : [];

        return view('AdminPanelNew/components/refer_detail', $data);
    }


    public function product_view_detail()
    {
        $_POST['_otherFilters'] = [
            'features' => true,
            'features_filters' => [
                '_autojoin' => 'F',
                '_select' => '*',
            ],
            'variants' => true,
            'variants_filters' => [
                '_autojoin' => 'Y',
                '_select' => '*',
            ],
            'sizes' => true,
            'sizes_filters' => [
                '_autojoin' => 'Y',
                '_select' => '*',
            ],
        ];
        $product_filter = [
            '_autojoin' => 'Y',
            '_select' => '*',
            'product.product_id' => $_POST['product_id'],
        ];
        $product_data = $this->getProductModel()->RecordList($product_filter);
        return view('AdminPanelNew/pages/component/product_view_detail', $product_data['data'][0]);
    }
    public function variant_list($product_id, $variant_id = null)
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['product_data'] = $this->getProductModel()->find($product_id);
        $theme_data = array_merge($theme_data, ['product_id' => $product_id]);

        $theme_data['_meta_title'] = ($variant_id == null) ? "Products Variant" : "Variant Products";
        $theme_data['_page_title'] = 'Products Variant';
        $theme_data['_breadcrumb1'] = 'Inventory';
        $theme_data['_breadcrumb2'] = 'Products Variant';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Inventory/variant_products';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function offer_items($offer_id)
    {
        $theme_data = $this->admin_panel_common_data();
        // Current Date into  numric index
        $theme_data['current_date'] = date('Y-m-d');
        // Convert into Numeric Index

        $offer = $this->getOfferModel()->find($offer_id);
        $theme_data = array_merge($theme_data, $offer);
        // Get Exclude Item List
        $product_list = $this->getProductModel()->getProductsWithOfferFlag($offer_id, $offer['offer_to'], $offer['offer_from']);
        $theme_data['product_list'] = $product_list ?? [];
        if (!empty($product_list)) {
        }
        $theme_data['_meta_title'] = "Offer Items";
        $theme_data['_page_title'] = 'Offer Items';
        $theme_data['_breadcrumb1'] = 'Offer List';
        $theme_data['_breadcrumb2'] = 'Offer Items';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/offer_items';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function offer_items_create_update()
    {
        $data = getRequestData($this->request, 'ARRAY');
        $offer_items = array_filter($data['items'], function ($item) {
            return isset($item['product_id']) && !empty($item['product_id']);
        });
        $this->getOfferItemModel()->where('offer_id', $data['offer_id'])->delete();
        $this->getOfferItemModel()->insertBatch($offer_items);
        return redirect()->route('offer_list');
    }

    public function order_list($page_status)
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data = array_merge($theme_data, $this->request->getGet() ?? []);
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/finance/All_Orders';
        $title = '';
        switch ($page_status) {
            // Finance
            case 'request_return_approved':
                $title = "Request Return Approved";
                $theme_data['order_status_array'] = [
                    'request_return_approved',
                ];
                break;
            case 'finance_pending_order':
                $title = "Pending Orders";
                $theme_data['order_status_array'] = [
                    'order_payment_processing',
                    'order_payment_success',
                    'request_refund_approved',
                    'order_not_delivered'
                ];
                break;
            case 'refund_to_customer':
                $title = "Refund to Customer";
                $theme_data['order_status_array'] = [
                    'refund_to_customer',
                ];
                break;
            case 'finance_payment_failed':
                $title = "Payment Failed";
                $theme_data['order_status_array'] = ['order_payment_fail'];
                break;
            case 'razorpay_payment_approved':
                $title = "Razorpay Payment Approved";
                $theme_data['order_status_array'] = ['order_payment_verified_razorpay'];
                break;
            // Order Management By Admin
            case 'all_order':
                $title = "All Orders";
                $orderModel = $this->getOrderModel();
                $deliveredCount = $orderModel
                    ->where('order_status', 'order_delivered')
                    ->countAllResults();
                $TotalOrder = $orderModel
                    ->countAllResults();

                $theme_data['order_status_array'] = [];
                $theme_data['Total_order_count'] = $TotalOrder;
                $theme_data['delivered_order_count'] = $deliveredCount;
                break;
            case 'admin_pending_approval':
                $title = "Pending Approval";
                $theme_data['order_status_array'] = [
                    'order_payment_verified_manual',
                    'order_payment_verified_razorpay',
                ];
                break;
            case 'cancel_order':
                $title = "Cancel Orders";
                $theme_data['order_status_array'] = [
                    'refund_request',
                ];
                break;
            case 'return_request_pending':
                $title = "Return Request Pending";
                $theme_data['order_status_array'] = [
                    'return_request',
                ];
                break;
            case 'return_request_reject':
                $title = "Return/Exchange Request Rejeted";
                $theme_data['order_status_array'] = [
                    'request_return_rejected',
                    'request_exchange_rejected',
                ];
                break;
            case 'exchange_request_pending':
                $title = "Exchange Request Pending";
                $theme_data['order_status_array'] = [
                    'exchange_request',
                ];
                break;
            // Delivery 
            case 'delivery_pending_orders':
                $title = "Order Accepted";
                $theme_data['order_status_array'] = ['order_accepted', 'request_exchange_approved'];
                break;
            case 'delivery_ready_to_ship':
                $title = "Ready To Ship";
                $theme_data['order_status_array'] = ['order_ready_to_ship'];
                break;
            case 'delivery_shipped':
                $title = "Order Shipped";
                $theme_data['order_status_array'] = ['order_shipped', 'order_exchange_shipped'];
                break;
            case 'delivered':
                $title = "Order Delivered";
                $theme_data['order_status_array'] = ['order_delivered', 'order_exchanged'];
                break;
            case 'order_not_delivered':
                $title = "Order Not Delivered";
                $theme_data['order_status_array'] = ['order_not_delivered'];
                break;
        }

        $theme_data['page_status'] = $page_status;
        $theme_data['_meta_title'] = $title;
        $theme_data['_page_title'] = $title;
        $theme_data['_breadcrumb1'] = $title;
        $theme_data['_breadcrumb2'] = $title;
        return view('AdminPanelNew/partials/main', $theme_data);
    }

    public function Dashboard()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Orders Dashboard';
        $theme_data['_page_title'] = 'Orders Dashboard';
        $theme_data['_breadcrumb1'] = 'Orders';
        $theme_data['_breadcrumb2'] = 'Orders Dashboard';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/finance/Dashboard';
        return view('AdminPanelNew/partials/main', $theme_data);
    }



    // Stock Managmet
    public function stock_update()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Stock';
        $theme_data['_page_title'] = 'Stock';
        $theme_data['_breadcrumb1'] = 'Stock Manage';
        $theme_data['_breadcrumb2'] = 'Stock';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Stock/stock_update';
        return view('AdminPanelNew/partials/main', $theme_data);
    }

    public function offer_item()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Offer Item';
        $theme_data['_page_title'] = 'Offer Item';
        $theme_data['_breadcrumb1'] = 'Stock';
        $theme_data['_breadcrumb2'] = 'Stock';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Stock/offer_item';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function add_stock()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Stock';
        $theme_data['_page_title'] = 'Stock';
        $theme_data['_breadcrumb1'] = 'Stock Manage';
        $theme_data['_breadcrumb2'] = 'Stock';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Stock/add_stock';
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function third_party_integration()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Third Party Integration';
        $theme_data['_page_title'] = 'Third Party Integration';
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Third Party Integration';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/third_party_integration';
        // Email
        $theme_data['email_integration']['fields'] = $this->getThirdPartyIntegrationModel()->getEmailIntegrationFileds();
        $theme_data['email_integration']['data'] = $this->getThirdPartyIntegrationModel()->getIntegrationDataByType('email');
        // Sms
        $theme_data['sms_integration']['fields'] = $this->getThirdPartyIntegrationModel()->getSmsIntegrationFileds();
        $theme_data['sms_integration']['data'] = $this->getThirdPartyIntegrationModel()->getIntegrationDataByType('sms');
        // Rozorpay
        $theme_data['rozorpay_integration']['fields'] = $this->getThirdPartyIntegrationModel()->getRozorpayIntegrationFileds();
        $theme_data['rozorpay_integration']['data'] = $this->getThirdPartyIntegrationModel()->getIntegrationDataByType('rozorpay');
        // Google OAuth
        // $theme_data['googleoauth_integration']['fields'] = $this->getThirdPartyIntegrationModel()->getGoogleoauthIntegrationFileds();
        // $theme_data['googleoauth_integration']['data'] = $this->getThirdPartyIntegrationModel()->getIntegrationDataByType('googleoauth');
        // Google Firebase
        $theme_data['firebase_integration']['fields'] = $this->getThirdPartyIntegrationModel()->getFirebaseIntegrationFileds();
        $theme_data['firebase_integration']['data'] = $this->getThirdPartyIntegrationModel()->getIntegrationDataByType('firebase');
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function email_sms_template()
    {
        $theme_data = $this->admin_panel_common_data();
        $theme_data['_meta_title'] = 'Email SMS Template';
        $theme_data['_page_title'] = 'Email SMS Template';
        $theme_data['_breadcrumb1'] = 'Admin';
        $theme_data['_breadcrumb2'] = 'Email SMS Template';
        $theme_data['_view_files'][] = 'AdminPanelNew/pages/Admin/email_sms_template';
        $template_data = $this->getTemplateModel()->findAll();
        $theme_data['templates'] = $template_data;
        return view('AdminPanelNew/partials/main', $theme_data);
    }
    public function email_sms_template_form()
    {
        $data = getRequestData($this->request, 'ARRAY');
        $template_data = $this->getTemplateModel()->find($data['template_id']);
        if (!empty($template_data)) {
            return view("AdminPanelNew/components/email_sms_template_form", $template_data);
        }
        return "<h1>Template Record Not Found</h1>";
    }
    public function testing() {}
    public function sms_testing()
    {
        $ec = new SmsController;

        if ($ec->is_active && $ec->response['status'] == ApiResponseStatusCode::OK) {
            $ec->testing('7879531944', 'Khushi', '123456');

            if ($ec->response['status'] == ApiResponseStatusCode::OK) {
                print_r($ec->response);
            } else {
                print_r($ec->response);
            }
        } else {
            print_r($ec->response);
        }
    }
    public function deleteNotification()
    {
        $notificationId = $this->request->getPost('notification_id');

        if ($notificationId) {
            $this->getFirebaseMessagingNotificationModel()
                ->where('firebase_messaging_notification_id', $notificationId)
                ->where('access_id', $_SESSION['user_id'])
                ->delete();

            return $this->response->setJSON(['success' => true, 'message' => 'Notification deleted successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Notification ID is missing']);
        }
    }

    protected function admin_panel_common_data(): array
    {
        $theme_data = [];
        $theme_data['_assets_path'] = 'AdminPanelNew/';
        $theme_data['_theme_path'] = 'AdminPanelNew/';
        $theme_data['_partials_path'] = $theme_data['_theme_path'] . 'partials/';

        $theme_data['_meta_title'] = '';
        $theme_data['_page_title'] = '';
        $theme_data['_breadcrumb1'] = '';
        $theme_data['_breadcrumb2'] = '';
        // Css
        $theme_data['_head_css_code'] = "";
        $theme_data['_head_css_files'][] = $theme_data['_assets_path'] . 'assets/css/style.css';
        // Pre Script
        $theme_data['_head_js_code'] = "const base_url = '" . base_url() . "'";
        $theme_data['_head_js_files'][] = $theme_data['_assets_path'] . 'assets/js/pre-script.js';
        // Post Script
        $theme_data['_script_files'][] = $theme_data['_assets_path'] . 'assets/js/script.js';
        $theme_data['_script_files'][] = $theme_data['_assets_path'] . 'assets/js/comman.js';
        $theme_data['_script_js_code'] = "";
        $theme_data['_view_files'] = [];

        // Notification 
        $theme_data['_notifications'] = $this->getFirebaseMessagingNotificationModel()->where('access_type', 'user')->where('access_id', $_SESSION['user_id'])->findAll() ?? [];
        $theme_data['_notification_count'] = $this->getFirebaseMessagingNotificationModel()
            ->where('access_type', 'user')
            ->where('access_id', $_SESSION['user_id'])
            ->countAllResults();


        // Sidebar
        $theme_data['_user_name'] = $_SESSION['fullname'];
        $theme_data['_user_id'] = '1';
        $theme_data['_user_image_url'] = 'assets/images/users/avatar-2.jpg';
        $theme_data['_role_name'] = ucfirst($_SESSION['user_type']);
        $theme_data['_role_id'] = '1';
        $order_process_counts = $this->order_dashboard_counts();
        $counts = [];
        $counts = array_merge($counts, $order_process_counts);
        $theme_data['_menus'] = $this->getSiteBarMenus($counts);
        return $theme_data;
    }
    public function order_dashboard_counts()
    {
        $order_status_counts = $this->getOrderModel()->select('order_status, COUNT(order_status) as status_count')->groupBy('order_status')->findAll();
        $counts = [];
        $array_status_refund_to_customer = [
            'refund_to_customer',
        ];
        $counts['refund_to_customer'] = (!empty($order_status_counts)) ? calculateArrayFieldByCondition($order_status_counts, 'order_status', $array_status_refund_to_customer, 'status_count', 'sum') : 0;

        $array_status_request_return_approved = [
            'request_return_approved',
        ];
        $counts['request_return_approved'] = (!empty($order_status_counts)) ? calculateArrayFieldByCondition($order_status_counts, 'order_status', $array_status_request_return_approved, 'status_count', 'sum') : 0;

        $array_status_pending_verification = [
            'order_payment_processing',
            'order_payment_success',
        ];
        $counts['pending_verification'] = (!empty($order_status_counts)) ? calculateArrayFieldByCondition($order_status_counts, 'order_status', $array_status_pending_verification, 'status_count', 'sum') : 0;
        
        $array_status_refund_pending = [
            'order_not_delivered',
            'request_refund_approved',
        ];
        $counts['refund_pending'] = (!empty($order_status_counts)) ? calculateArrayFieldByCondition($order_status_counts, 'order_status', $array_status_refund_pending, 'status_count', 'sum') : 0;

        $array_status_pending_approval = [
            "order_payment_verified_manual",
            "order_payment_verified_razorpay",
            
        ];
        $counts['pending_approval'] = (!empty($order_status_counts)) ? calculateArrayFieldByCondition($order_status_counts, 'order_status', $array_status_pending_approval, 'status_count', 'sum') : 0;


        $return_status_pending_approval = [
            "return_request",
        ];
        $counts['return_request'] = (!empty($order_status_counts)) ? calculateArrayFieldByCondition($order_status_counts, 'order_status', $return_status_pending_approval, 'status_count', 'sum') : 0;

        
        $refund_status_pending_approval = [
            "refund_request",
        ];
        $counts['refund_request'] = (!empty($order_status_counts)) ? calculateArrayFieldByCondition($order_status_counts, 'order_status', $refund_status_pending_approval, 'status_count', 'sum') : 0;


         $return_status_pending_approval = [
            "return_request",
        ];
        $counts['return_request'] = (!empty($order_status_counts)) ? calculateArrayFieldByCondition($order_status_counts, 'order_status', $return_status_pending_approval, 'status_count', 'sum') : 0;

        $return_status_rejected = [
            "request_return_rejected",
            'request_exchange_rejected',
        ];
        $counts['request_return_rejected'] = (!empty($order_status_counts)) ? calculateArrayFieldByCondition($order_status_counts, 'order_status', $return_status_rejected, 'status_count', 'sum') : 0;

        $exchange_status_pending_approval = [
            "exchange_request",
        ];
        $counts['exchange_request'] = (!empty($order_status_counts)) ? calculateArrayFieldByCondition($order_status_counts, 'order_status', $exchange_status_pending_approval, 'status_count', 'sum') : 0;

        $array_status_pending_refund = [
            'request_refund_approved',
        ];
        $counts['pending_refund'] = (!empty($order_status_counts)) ? calculateArrayFieldByCondition($order_status_counts, 'order_status', $array_status_pending_refund, 'status_count', 'sum') : 0;

        $array_prazorpay_payment_approveds = [
            'order_payment_verified_razorpay',
        ];
        $counts['order_payment_verified_razorpay'] = (!empty($order_status_counts)) ? calculateArrayFieldByCondition($order_status_counts, 'order_status', $array_prazorpay_payment_approveds, 'status_count', 'sum') : 0;
        $array_pending_orders = [
            'order_accepted',
            'request_exchange_approved',
        ];
        $counts['pending_orders'] = (!empty($order_status_counts)) ? calculateArrayFieldByCondition($order_status_counts, 'order_status', $array_pending_orders, 'status_count', 'sum') : 0;
        $array_ready_to_shipped = [
            'order_ready_to_ship',
        ];
        $counts['ready_to_shipped'] = (!empty($order_status_counts)) ? calculateArrayFieldByCondition($order_status_counts, 'order_status', $array_ready_to_shipped, 'status_count', 'sum') : 0;
        $array_delivery_shipped = [
            'order_shipped',
            'order_exchange_shipped',

        ];
        $counts['delivery_shipped'] = (!empty($order_status_counts)) ? calculateArrayFieldByCondition($order_status_counts, 'order_status', $array_delivery_shipped, 'status_count', 'sum') : 0;
        $array_delivered = [
            'order_delivered',
            'order_exchanged',
        ];
        $counts['order_delivered'] = (!empty($order_status_counts)) ? calculateArrayFieldByCondition($order_status_counts, 'order_status', $array_delivered, 'status_count', 'sum') : 0;
        $array_order_not_delivered = [
            'order_not_delivered'
        ];
        $counts['order_not_delivered'] = (!empty($order_status_counts)) ? calculateArrayFieldByCondition($order_status_counts, 'order_status', $array_order_not_delivered, 'status_count', 'sum') : 0;
        return $counts;
    }

    protected function getSiteBarMenus($counts = [])
    {
        $menuArray = [
            [
                "module_title" => "Files.Dashboard",
                "module_name" => "module1",
                "module_icon" => "mdi mdi-airplay",
                "visibility" => ($_SESSION['user_type'] == 'admin') ? true : false,
                "menus" => [
                    [
                        "title" => "Admin Dashboard",
                        "url" => base_url(route_to('admin_dashboard')),
                        "badge_count" => 0,
                        "visibility" => ($_SESSION['user_type'] == 'admin') ? true : false,
                    ],
                    [
                        "title" => "Order Dashboard",
                        "url" => base_url(route_to('order_dashboard')),
                        "badge_count" => 0,
                        "visibility" => ($_SESSION['user_type'] == 'admin' || $_SESSION['user_type'] == 'order') ? true : false,
                    ],
                    [
                        "title" => "Finance Dashboard",
                        "url" => base_url(route_to('financial_dashboard')),
                        "badge_count" => 0,
                        "visibility" => ($_SESSION['user_type'] == 'admin' || $_SESSION['user_type'] == 'finance') ? true : false,
                    ],
                    [
                        "title" => "Stock Dashboard",
                        "url" => base_url(route_to('stock_dashboard')),
                        "badge_count" => 0,
                        "visibility" => ($_SESSION['user_type'] == 'admin' || $_SESSION['user_type'] == 'stock') ? true : false,
                    ],
                    [
                        "title" => "Delivery Dashboard",
                        "url" => base_url(route_to('delivery_dashboard')),
                        "badge_count" => 0,
                        "visibility" => ($_SESSION['user_type'] == 'admin' || $_SESSION['user_type'] == 'delivery') ? true : false,
                    ],
                ]
            ],

            [
                "module_title" => "Files.Admin",
                "module_name" => "Administrator",
                "module_icon" => "mdi mdi-account-supervisor-outline",
                "visibility" => ($_SESSION['user_type'] == 'admin') ? true : false,
                "menus" => [
                    [
                        "title" => "Users Role",
                        "url" => base_url(route_to('role_user_list')),
                        "badge_count" => 0,
                        "visibility" => true,
                    ],
                    // [
                    //     "title" => "Blog Posts",
                    //     "url" => base_url(route_to('BlogPostView')),
                    //     "badge_count" => 0,
                    //     "visibility" => true,
                    // ],
                    [
                        "title" => "Contact Us",
                        "url" => base_url(route_to('contact_us_list')),
                        "badge_count" => 0,
                        "visibility" => true,
                    ],
                    [
                        "title" => "Contact",
                        "url" => base_url(route_to('contact')),
                        "badge_count" => 0,
                        "visibility" => true,
                    ],

                    [
                        "title" => "Coupons",
                        "url" => base_url(route_to('coupon_list')),
                        "badge_count" => 0,
                        "visibility" => true,
                    ],
                    // [
                    //     "title" => "Refer Coupons",
                    //     "url" => base_url(route_to('refer_coupon_list')),
                    //     "badge_count" => 0,
                    //     "visibility" => true,
                    // ],
                    [
                        "title" => "Offers",
                        "url" => base_url(route_to('offer_list')),
                        "badge_count" => 0,
                        "visibility" => true,
                    ],
                    [
                        "title" => "Pages",
                        "url" => "javascript: void(0);",
                        "badge_count" => 0,
                        "visibility" => ($_SESSION['user_type'] == 'admin') ? true : false,
                        "sub_menus" => [
                            [
                                "title" => "Header & Footer",
                                "url" => base_url(route_to('header_footer')),
                                "badge_count" => 0,
                                "visibility" => true,
                            ],
                            [
                                "title" => "Home",
                                "url" => base_url(route_to('home')),
                                "badge_count" => 0,
                                "visibility" => true,
                            ],

                            [
                                "title" => "About",
                                "url" => base_url(route_to('about')),
                                "badge_count" => 0,
                                "visibility" => true,
                            ],
                            [
                                "title" => "Support",
                                "url" => base_url(route_to('support_us')),
                                "badge_count" => 0,
                                "visibility" => true,
                            ],
                            // [
                            //     "title" => "FAQ",
                            //     "url" => base_url(route_to('FAQ')),
                            //     "badge_count" => 0,
                            //     "visibility" => true,
                            // ],
                            // [
                            //     "title" => "Career",
                            //     "url" => base_url(route_to('career')),
                            //     "badge_count" => 0,
                            //     "visibility" => true,
                            // ],
                            [
                                "title" => "Terms & Condition",
                                "url" => base_url(route_to('term_condition')),
                                "badge_count" => 0,
                                "visibility" => true,
                            ],
                            [
                                "title" => "Privacy & Policy",
                                "url" => base_url(route_to('privacy_policy')),
                                "badge_count" => 0,
                                "visibility" => true,
                            ],
                            [
                                "title" => "Shipping Policy",
                                "url" => base_url(route_to('shipping_policy')),
                                "badge_count" => 0,
                                "visibility" => true,
                            ],
                            [
                                "title" => "Return Policy",
                                "url" => base_url(route_to('return_policy')),
                                "badge_count" => 0,
                                "visibility" => true,
                            ],
                            [
                                "title" => "Refund Policy",
                                "url" => base_url(route_to('refund_policy')),
                                "badge_count" => 0,
                                "visibility" => true,
                            ],
                            // [
                            //     "title" => "Disclaimer",
                            //     "url" => base_url(route_to('disclaimer')),
                            //     "badge_count" => 0,
                            //     "visibility" => true,
                            // ],
                        ]
                    ],
                    [
                        "title" => "Slider",
                        "url" => "javascript: void(0);",
                        "badge_count" => 0,
                        "visibility" => false,
                        "sub_menus" => [
                            [
                                "title" => "Slider Style",
                                "url" => base_url(route_to('slider_style')),
                                "badge_count" => 0,
                                "visibility" => true,
                            ],
                        ]
                    ],
                    [
                        "title" => "Third Party Integration",
                        "url" => base_url(route_to('third_party_integration')),
                        "badge_count" => 0,
                        "visibility" => true,
                    ],
                    [
                        "title" => "Email & SMS Template",
                        "url" => base_url(route_to('email_sms_template')),
                        "badge_count" => 0,
                        "visibility" => true,
                    ],
                    // [
                    //     "title" => "Marketing Pixels",
                    //     "url" => "javascript: void(0);",
                    //     "badge_count" => 0,
                    //     "visibility" => ($_SESSION['user_type'] == 'admin') ? true : false,
                    //     "sub_menus" => [
                    //         [
                    //             "title" => "FacebookPixel",
                    //             "url" => base_url(route_to('facebook_pixel')),
                    //             "badge_count" => 0,
                    //             "visibility" => true,
                    //         ],
                    //         [
                    //             "title" => "GoogleTag",
                    //             "url" => base_url(route_to('google_tag_manager')),
                    //             "badge_count" => 0,
                    //             "visibility" => true,
                    //         ],
                    //         [
                    //             "title" => "MicrosoftUniversal",
                    //             "url" => base_url(route_to('microsoft_universal_event_tracking')),
                    //             "badge_count" => 0,
                    //             "visibility" => true,
                    //         ],
                    //     ]
                    // ]

                ]
            ],
            [
                "module_title" => "Inventory",
                "module_name" => "Administrator",
                "module_icon" => "mdi mdi-note-text-outline",
                // "visibility" => true,
                "visibility" => (in_array($_SESSION['user_type'], ['admin', 'inventory'])) ? true : false,

                "menus" => [
                    [
                        "title" => "Brand",
                        "url" => base_url(route_to('brand_list')),
                        "badge_count" => 0,
                        "visibility" => true,
                    ],
                    [
                        "title" => "Category Type",
                        "url" => base_url(route_to('category_type_list')),
                        "badge_count" => 0,
                        "visibility" => true,
                    ],
                    [
                        "title" => "Category",
                        "url" => base_url(route_to('category_list')),
                        "badge_count" => 0,
                        "visibility" => true,
                    ],
                    // [
                    //     "title" => "Feature Type",
                    //     "url" => base_url(route_to('feature_type_list')),
                    //     "badge_count" => 0,
                    //     "visibility" => true,
                    // ],
                    // [
                    //     "title" => "Feature",
                    //     "url" => base_url(route_to('feature_list')),
                    //     "badge_count" => 0,
                    //     "visibility" => true,
                    // ],
                    [
                        "title" => "Color",
                        "url" => base_url(route_to('color_list')),
                        "badge_count" => 0,
                        "visibility" => true,
                    ],
                    [
                        "title" => "Size",
                        "url" => base_url(route_to('size_list')),
                        "badge_count" => 0,
                        "visibility" => true,
                    ],
                    [
                        "title" => "Product Management",
                        "url" => base_url(route_to('product_manage')),
                        "badge_count" => 0,
                        "visibility" => true,
                    ],
                ]
            ],
            [
                "module_title" => "Finance Management",
                "module_name" => "Administrator",
                "module_icon" => "mdi mdi-note-text-outline",
                "visibility" => (in_array($_SESSION['user_type'], ['admin', 'finance'])) ? true : false,
                "menus" => [
                    [
                        "title" => "Finance Dashboard",
                        "url" => base_url(route_to('financial_dashboard')),
                        "badge_count" => 0,
                        "visibility" => ($_SESSION['user_type'] == 'admin' || $_SESSION['user_type'] == 'finance') ? true : false,
                    ],
                    [
                        "title" => "Return Approved",
                        "url" => base_url(route_to('request_return_approved')),
                        "badge_count" => $counts['request_return_approved'] ?? 0,
                        "visibility" => true,
                    ],
                    [
                        "title" => "Pending Refund Processed",
                        "url" => base_url(route_to('payment_pending')),
                        "badge_count" => $counts['refund_pending'] ?? 0,
                        "visibility" => true,
                    ],
                    [
                        "title" => "Refund to Customer",
                        "url" => base_url(route_to('refund_to_customer')),
                        "badge_count" => $counts['refund_to_customer'] ?? 0,
                        "visibility" => true,
                    ],
                    [
                        "title" => "Razorpay Verified Payment",
                        "url" => base_url(route_to('razorpay_payment_approved')),
                        "badge_count" => $counts['order_payment_verified_razorpay'] ?? 0,
                        "visibility" => true,
                    ],

                ]
            ],
            [
                "module_title" => "Orders Management",
                "module_name" => "Administrator",
                "module_icon" => "mdi mdi-note-text-outline",
                "visibility" => (in_array($_SESSION['user_type'], ['admin', 'order'])) ? true : false,

                "menus" => [
                    [
                        "title" => "Order Dashboard",
                        "url" => base_url(route_to('order_dashboard')),
                        "badge_count" => 0,
                        "visibility" => ($_SESSION['user_type'] == 'admin' || $_SESSION['user_type'] == 'order') ? true : false,
                    ],
                    [
                        "title" => "All Orders",
                        "url" => base_url(route_to('all_order')),
                        "badge_count" => 0,
                        "visibility" => true,
                    ],
                    [
                        "title" => "Pending Approval",
                        "url" => base_url(route_to('admin_pending_approval')),
                        "badge_count" => $counts['pending_approval'] ?? 0,
                        "visibility" => true,
                    ],
                    [
                        "title" => "Cancel Orders",
                        "url" => base_url(route_to('cancel_order')),
                        "badge_count" => $counts['refund_request'] ?? 0,
                        "visibility" => true,
                    ],
                    [
                        "title" => "Return Request Pending",
                        "url" => base_url(route_to('return_request_pending')),
                        "badge_count" => $counts['return_request'] ?? 0,
                        "visibility" => true,
                    ],
                    [
                        "title" => "Return/Exchange Request Rejected",
                        "url" => base_url(route_to('return_request_reject')),
                        "badge_count" => $counts['request_return_rejected'] ?? 0,
                        "visibility" => true,
                    ],
                    [
                        "title" => "Exchange Request Pending",
                        "url" => base_url(route_to('exchange_request_pending')),
                        "badge_count" => $counts['exchange_request'] ?? 0,
                        "visibility" => true,
                    ],
                ]
            ],
            [
                "module_title" => "Delivery Management",
                "module_name" => "Administrator",
                "module_icon" => "mdi mdi-note-text-outline",
                "visibility" => (in_array($_SESSION['user_type'], ['admin', 'delivery'])) ? true : false,

                "menus" => [
                    [
                        "title" => "Delivery Dashboard",
                        "url" => base_url(route_to('delivery_dashboard')),
                        "badge_count" => 0,
                        "visibility" => ($_SESSION['user_type'] == 'admin' || $_SESSION['user_type'] == 'delivery') ? true : false,
                    ],
                    [
                        "title" => "Delivery Pending Orders",
                        "url" => base_url(route_to('delivery_pending_orders')),
                        "badge_count" => $counts['pending_orders'] ?? 0,
                        "visibility" => true,
                    ],
                    [
                        "title" => "Delivery Ready To Ship",
                        "url" => base_url(route_to('delivery_ready_to_ship')),
                        "badge_count" => $counts['ready_to_shipped'] ?? 0,
                        "visibility" => true,
                    ],
                    [
                        "title" => "Delivery Shipped",
                        "url" => base_url(route_to('delivery_shipped')),
                        "badge_count" => $counts['delivery_shipped'] ?? 0,
                        "visibility" => true,
                    ],
                    [
                        "title" => "Delivered",
                        "url" => base_url(route_to('delivered')),
                        "badge_count" => $counts['order_delivered'] ?? 0,
                        "visibility" => true,
                    ],
                    [
                        "title" => "Not Delivered",
                        "url" => base_url(route_to('order_not_delivered')),
                        "badge_count" => $counts['order_not_delivered'] ?? 0,
                        "visibility" => true,
                    ],
                ]
            ],
            [
                "module_title" => "Stock Management",
                "module_name" => "Administrator",
                "module_icon" => "mdi mdi-note-text-outline",
                "visibility" => (in_array($_SESSION['user_type'], ['admin', 'inventory'])) ? true : false,

                "menus" => [
                    [
                        "title" => "Stock Dashboard",
                        "url" => base_url(route_to('stock_dashboard')),
                        "badge_count" => 0,
                        "visibility" => ($_SESSION['user_type'] == 'admin' || $_SESSION['user_type'] == 'stock') ? true : false,
                    ],
                    [
                        "title" => "Current Stock Update",
                        "url" => base_url(route_to('stock_update')),
                        "badge_count" => 0,
                        "visibility" => true,
                    ],

                ]
            ],
            // [
            //     "module_title" => "CRM Management",
            //     "module_name" => "module1",
            //     "module_icon" => "mdi mdi-airplay",
            //     "visibility" => ($_SESSION['user_type'] == 'admin') ? true : false,
            //     "menus" => [


            //         [
            //             "title" => "FAQ",
            //             "url" => base_url(route_to('faq_list')),
            //             "badge_count" => 0,
            //             "visibility" => ($_SESSION['user_type'] == 'admin') ? true : false,
            //         ],
            //         [
            //             "title" => "Refer & Earn",
            //             "url" => base_url(route_to('subscriber_list')),
            //             "badge_count" => 0,
            //             "visibility" => ($_SESSION['user_type'] == 'admin') ? true : false,
            //         ],
            //     ],
            // ],

            [
                "module_title" => "Customer Management",
                "module_name" => "module1",
                "module_icon" => "mdi mdi-airplay",
                "visibility" => ($_SESSION['user_type'] == 'admin') ? true : false,
                "menus" => [
                    [
                        "title" => "Customers",
                        "url" => base_url(route_to('customer_list')),
                        "badge_count" => 0,
                        "visibility" => ($_SESSION['user_type'] == 'admin') ? true : false,
                    ],
                    [
                        "title" => "Customer Wishlist",
                        "url" => base_url(route_to('wishlist_list')),
                        "badge_count" => 0,
                        "visibility" => ($_SESSION['user_type'] == 'admin') ? true : false,
                    ],
                    [
                        "title" => "Customer Review",
                        "url" => base_url(route_to('review_list')),
                        "badge_count" => 0,
                        "visibility" => ($_SESSION['user_type'] == 'admin') ? true : false,
                    ],
                    [
                        "title" => "Customer Cart",
                        "url" => base_url(route_to('cart_list')),
                        "badge_count" => 0,
                        "visibility" => ($_SESSION['user_type'] == 'admin') ? true : false,
                    ],
                    [
                        "title" => "Top Pay Customer's",
                        "url" => base_url(route_to('top_paying_customer_list')),
                        "badge_count" => 0,
                        "visibility" => ($_SESSION['user_type'] == 'admin') ? true : false,
                    ],
                    [
                        "title" => "Returnable Customer's",
                        "url" => base_url(route_to('returnable_customer_list')),
                        "badge_count" => 0,
                        "visibility" => ($_SESSION['user_type'] == 'admin') ? true : false,
                    ],

                    [
                        "title" => "Subscriber",
                        "url" => base_url(route_to('subscriber')),
                        "badge_count" => 0,
                        "visibility" => ($_SESSION['user_type'] == 'admin') ? true : false,
                    ],


                ],
            ],
            [
                "module_title" => "Reffer Management",
                "module_name" => "module1",
                "module_icon" => "mdi mdi-airplay",
                "visibility" => ($_SESSION['user_type'] == 'admin') ? true : false,
                "menus" => [
                    [
                        "title" => "Referrer Customer's",
                        "url" => base_url(route_to('referrer_customer_list')),
                        "badge_count" => 0,
                        "visibility" => ($_SESSION['user_type'] == 'admin') ? true : false,
                    ],
                    [
                        "title" => "Earn Referrer Customer's",
                        "url" => base_url(route_to('earning_referrer_customer_list')),
                        "badge_count" => 0,
                        "visibility" => ($_SESSION['user_type'] == 'admin') ? true : false,
                    ],

                ],
            ],

            [
                "module_title" => "Withdrawal Management",
                "module_name" => "module1",
                "module_icon" => "mdi mdi-airplay",
                "visibility" => ($_SESSION['user_type'] == 'admin') ? true : false,
                "menus" => [

                    [
                        "title" => "Pending Withdrawal Request",
                        "url" => base_url(route_to('pending_withdrawal_request_list')),
                        "badge_count" => 0,
                        "visibility" => ($_SESSION['user_type'] == 'admin') ? true : false,
                    ],
                    [
                        "title" => "Approved/Process Withdrawal Request",
                        "url" => base_url(route_to('approved_withdrawal_request_list')),
                        "badge_count" => 0,
                        "visibility" => ($_SESSION['user_type'] == 'admin') ? true : false,
                    ],
                    [
                        "title" => "Paid Withdrawal Request",
                        "url" => base_url(route_to('paid_withdrawal_request_list')),
                        "badge_count" => 0,
                        "visibility" => ($_SESSION['user_type'] == 'admin') ? true : false,
                    ],
                    [
                        "title" => "Reject Withdrawal Request",
                        "url" => base_url(route_to('reject_withdrawal_request_list')),
                        "badge_count" => 0,
                        "visibility" => ($_SESSION['user_type'] == 'admin') ? true : false,
                    ],
                    [
                        "title" => "Wallet Purchased Customer's",
                        "url" => base_url(route_to('purchased_withdrawal_customer_list')),
                        "badge_count" => 0,
                        "visibility" => ($_SESSION['user_type'] == 'admin') ? true : false,
                    ],
                ],
            ],
            [
                "module_title" => "Report",
                "module_name" => "Administrator",
                "module_icon" => "mdi mdi-note-text-outline",
                "visibility" => (in_array($_SESSION['user_type'], ['admin', 'delivery'])) ? true : false,

                "menus" => [
                    [
                        "title" => "Item With Variants",
                        "url" => base_url(route_to('item_with_variants')),
                        "badge_count" => $counts['pending_orders'] ?? 0,
                        "visibility" => true,
                    ],


                ]
            ],

        ];
        return $menuArray;
    }
}
