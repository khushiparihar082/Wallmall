<?php

namespace App\Controllers;

use DateTime;
use ApiResponseStatusCode;
use App\Controllers\BaseController;
use App\Models\FunctionModel;
use Exception;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\Response;

class EcommerceApiController extends BaseController
{
    use ResponseTrait;
    public function handleOptionsRequest()
    {
        return $this->response->setStatusCode(Response::HTTP_OK);
    }
    protected function getCustomerId($returnCustomerID = true): string|null
    {
        if ($returnCustomerID) {
            return (isset($_SESSION['customer_id']) && !empty($_SESSION['customer_id'])) ? $_SESSION['customer_id'] : null;
        } else {
            return (isset($_SESSION['customer_id']) && !empty($_SESSION['customer_id'])) ? true : false;
        }
    }
    protected function ModelGet(FunctionModel $modelInstance)
    {
        try {
            $requestedData = (array) getRequestData($this->request, 'ARRAY') ?? [];
            $validation = \Config\Services::validation();
            // Define validation rules
            $validation->setRules([
                $modelInstance->getPrimaryKey() => 'required',
            ]);
            // Run validation
            if ($validation->run($requestedData) === false) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Validation Failed', [], $validation->getErrors());
            }
            $result = $modelInstance->RecordGet($requestedData[$modelInstance->getPrimaryKey()]);
            return formatApiAutoResponse($this->request, $this->response, $result);
        } catch (Exception $e) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, $e->getMessage(), []);
        }
    }
    protected function ModelList(FunctionModel $modelInstance)
    {
        try {
            $filter = getRequestData($this->request, 'ARRAY') ?? [];
            $result = $modelInstance->RecordList($filter);
            return formatApiAutoResponse($this->request, $this->response, $result);
        } catch (Exception $e) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, $e->getMessage(), []);
        }
    }
    protected function ModelCreate(FunctionModel $modelInstance, &$returnResultInArray = [])
    {
        try {
            $requestData = getRequestData($this->request, 'ARRAY') ?? [];
            $result = $modelInstance->RecordCreate($requestData);
            $returnResultInArray = $result;
            return formatApiAutoResponse($this->request, $this->response, $result);
        } catch (Exception $e) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, $e->getMessage(), []);
        }
    }
    protected function ModelUpdate(FunctionModel $modelInstance, &$returnResultInArray = [])
    {
        try {
            $requestData = getRequestData($this->request, 'ARRAY') ?? [];
            $result = $modelInstance->RecordUpdate($requestData, $requestData[$modelInstance->getPrimaryKey()]);
            $returnResultInArray = $result;
            return formatApiAutoResponse($this->request, $this->response, $result);
        } catch (Exception $e) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, $e->getMessage(), []);
        }
    }
    protected function ModelDelete(FunctionModel $modelInstance)
    {
        try {
            $requestData = getRequestData($this->request, 'ARRAY') ?? [];
            $validation = \Config\Services::validation();
            // Define validation rules
            $validation->setRules([
                $modelInstance->getPrimaryKey() => 'required',
            ]);
            // Run validation
            if ($validation->run($requestData) === false) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Validation Failed', [], $validation->getErrors());
            }
            $result = $modelInstance->RecordDelete($requestData[$modelInstance->getPrimaryKey()]);
            return formatApiAutoResponse($this->request, $this->response, $result);
        } catch (Exception $e) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, $e->getMessage(), []);
        }
    }
    // Country ---------------------------------------------------------------------------------------------------------
    /**
     * {"country_id":"required"}
     */
    public function CountryGet()
    {
        return $this->ModelGet($this->getCountryModel());
    }
    /**
     *  {
     *  "country_id": "",
     *	"country_name": "",
     *	"alias": "",
     *	"short_name": "",
     *	"phonecode": "",
     *	"currency": "",
     *	"currency_name": "",
     *	"currency_symbol": "",
     *	"region": "",
     *  "select":"",
     *  "autojoin":"" // "y","f"
     *  }
     */
    public function CountryList()
    {
        return $this->ModelList($this->getCountryModel());
    }

    /**
     * {"state_id":"required"}
     */

    // State ----------------------------------------------------------------------------------------------------------


    /** 
     * Get a list of all states
     * 
     * @return mixed
     */
    public function StateList()
    {
        return $this->ModelList($this->getStateModel());
    }



    // City -------------------------------------------------------------------------------------------------------



    /** 
     * Get a list of all cities
     * 
     * @return mixed
     */
    public function CityList()
    {
        return $this->ModelList($this->getCityModel());
    }

    /*
    * @param $for category_type_page,category_page,brand_page,feature_type_page,feature_page,product_detail,blog_detail_page,offer_detail_page,home_page,about_page,contact_page,support_page,career_page,faq_page,tc_page,pp_page,return_page,refund_page,disclaimer_page
    */
    protected function getSeo(string $for, string|null $record_id = null)
    {
        try {

            $seo_data = [
                'title' => null,
                'description' => null,
                'keywords' => null,
            ];
            switch ($for) {
                case 'category_type_page':
                    $record_data = $this->getCategoryTypeModel()->where('category_type_name', $record_id)->first();
                    $seo_data = [
                        'title' => $record_data['category_type_seo_title'] ?? $record_data['category_type_name'],
                        'description' => $record_data['category_type_seo_description'] ?? $record_data['category_type_name'],
                        'keywords' => $record_data['category_type_seo_keyword'] ?? $record_data['category_type_name'],
                    ];
                    break;
                case 'category_page':
                    $record_data = $this->getCategoryModel()->where('category_name', $record_id)->first();
                    $seo_data = [
                        'title' => $record_data['category_seo_title'] ?? $record_data['category_name'],
                        'description' => $record_data['category_seo_description'] ?? $record_data['category_name'],
                        'keywords' => $record_data['category_seo_keyword'] ?? $record_data['category_name'],
                    ];
                    break;
                case 'offer_page':
                    $record_data = $this->getOfferModel()->where('offer_name', $record_id)->first();
                    $seo_data = [
                        'title' => $record_data['offer_seo_title'] ?? $record_data['offer_name'],
                        'description' => $record_data['offer_seo_description'] ?? $record_data['offer_name'],
                        'keywords' => $record_data['offer_seo_keyword'] ?? $record_data['category_name'],
                    ];
                    break;
                case 'brand_page':
                    $record_data = $this->getBrandModel()->where('brand_name', $record_id)->first();
                    $seo_data = [
                        'title' => $record_data['brand_seo_title'] ?? $record_data['brand_name'],
                        'description' => $record_data['brand_seo_description'] ?? $record_data['brand_name'],
                        'keywords' => $record_data['brand_seo_keyword'] ?? $record_data['brand_name'],
                    ];
                    break;
                case 'feature_type_page':
                    $record_data = $this->getFeatureTypeModel()->where('feature_type_name', $record_id)->first();
                    $seo_data = [
                        'title' => $record_data['feature_type_seo_title'] ?? $record_data['feature_type_name'],
                        'description' => $record_data['feature_type_seo_description'] ?? $record_data['feature_type_name'],
                        'keywords' => $record_data['feature_type_seo_keyword'] ?? $record_data['feature_type_name'],
                    ];
                    break;
                case 'feature_page':
                    $record_data = $this->getFeatureModel()->where('feature_name', $record_id)->first();
                    $seo_data = [
                        'title' => $record_data['feature_seo_title'] ?? $record_data['feature_name'],
                        'description' => $record_data['feature_seo_description'] ?? $record_data['feature_name'],
                        'keywords' => $record_data['feature_seo_keyword'] ?? $record_data['feature_name'],
                    ];
                    break;
                case 'product_detail':
                    $record_data = $this->getProductVariantModel()->find($record_id);
                    $seo_data = [
                        'title' => $record_data['product_seo_title'] ?? $record_data['product_variant_seo_title'],
                        'description' => $record_data['product_seo_description'] ?? $record_data['variant_seo_description'],
                        'keywords' => $record_data['product_keyfeature'] ?? $record_data['variant_seo_keyword'],
                    ];
                    break;
                case 'product_listing':
                    $record_data = $this->getProductModel()->first();
                    $seo_data = [
                        'title' => $record_data['product_seo_title'] ?? $record_data['firm_name'],
                        'description' => $record_data['product_seo_description'] ?? $record_data['firm_name'],
                        'keywords' => $record_data['product_keyfeature'] ?? $record_data['firm_name'],
                    ];
                    break;
                case 'product_detail_page':
                    $record_data = $this->getProductVariantModel()->first();;
                    $seo_data = [
                        'title' => $record_data['product_variant_seo_title'] ?? $record_data['variant_name'],
                        'description' => $record_data['variant_seo_description'] ?? $record_data['variant_name'],
                        'keywords' => $record_data['variant_seo_keyword'] ?? $record_data['variant_name'],
                    ];
                    break;

                case 'blog_detail_page':
                    $record_data = $this->getBlogPostModel()->find($record_id);
                    $seo_data = [
                        'title' => $record_data['blog_seo_title'] ?? $record_data['blog_title'] ?? 'blog Title',
                        'description' => $record_data['blog_seo_description'] ?? $record_data['blog_title']  ?? 'blog Title',
                        'keywords' => $record_data['blog_keyfeature'] ?? $record_data['blog_title'] ?? 'blog Title',
                    ];
                    break;
                case 'home_page':
                    $record_data = $this->getWebsiteProfileModel()->first();
                    $seo_data = [
                        'title' => $record_data['home_page_seo_title'] ?? $record_data['firm_name'],
                        'description' => $record_data['home_page_seo_description'] ?? $record_data['firm_name'],
                        'keywords' => $record_data['home_page_seo_keyword'] ?? $record_data['firm_name'],
                    ];
                    break;
                case 'about_page':
                    $record_data = $this->getWebsiteProfileModel()->first();
                    $seo_data = [
                        'title' => $record_data['about_page_seo_title'] ?? $record_data['firm_name'],
                        'description' => $record_data['about_page_seo_description'] ?? $record_data['firm_name'],
                        'keywords' => $record_data['about_page_seo_keyword'] ?? $record_data['firm_name'],
                    ];
                    break;
                case 'contact_page':
                    $record_data = $this->getWebsiteProfileModel()->first();
                    $seo_data = [
                        'title' => $record_data['contact_page_seo_title'] ?? $record_data['firm_name'],
                        'description' => $record_data['contact_page_seo_description'] ?? $record_data['firm_name'],
                        'keywords' => $record_data['contact_page_seo_keyword'] ?? $record_data['firm_name'],
                    ];
                    break;
                case 'return_page':
                    $record_data = $this->getWebsiteProfileModel()->first();
                    $seo_data = [
                        'title' => $record_data['return_page_seo_title'] ?? $record_data['firm_name'],
                        'description' => $record_data['return_page_seo_description'] ?? $record_data['firm_name'],
                        'keywords' => $record_data['return_page_seo_keyword'] ?? $record_data['firm_name'],
                    ];
                    break;
                case 'pp_page':
                    $record_data = $this->getWebsiteProfileModel()->first();
                    $seo_data = [
                        'title' => $record_data['pp_page_seo_title'] ?? $record_data['firm_name'],
                        'description' => $record_data['pp_page_seo_description'] ?? $record_data['firm_name'],
                        'keywords' => $record_data['pp_page_seo_keyword'] ?? $record_data['firm_name'],
                    ];
                    break;
                case 'shipping_policy_page':
                    $record_data = $this->getWebsiteProfileModel()->first();
                    $seo_data = [
                        'title' => $record_data['shipping_policy_page_seo_title'] ?? $record_data['firm_name'],
                        'description' => $record_data['shipping_policy_page_seo_description'] ?? $record_data['firm_name'],
                        'keywords' => $record_data['shipping_policy_page_seo_keyword'] ?? $record_data['firm_name'],
                    ];
                    break;
                case 'refund_page':
                    $record_data = $this->getWebsiteProfileModel()->first();
                    $seo_data = [
                        'title' => $record_data['refund_page_seo_title'] ?? $record_data['firm_name'],
                        'description' => $record_data['refund_page_seo_description'] ?? $record_data['firm_name'],
                        'keywords' => $record_data['refund_page_seo_keyword'] ?? $record_data['firm_name'],
                    ];
                    break;
                case 'disclaimer_page':
                    $record_data = $this->getWebsiteProfileModel()->first();
                    $seo_data = [
                        'title' => $record_data['disclaimer_page_seo_title'] ?? $record_data['firm_name'],
                        'description' => $record_data['disclaimer_page_seo_description'] ?? $record_data['firm_name'],
                        'keywords' => $record_data['disclaimer_page_seo_keyword'] ?? $record_data['firm_name'],
                    ];
                    break;
                case 'support_page':
                    $record_data = $this->getWebsiteProfileModel()->first();
                    $seo_data = [
                        'title' => $record_data['support_page_seo_title'] ?? $record_data['firm_name'],
                        'description' => $record_data['support_page_seo_description'] ?? $record_data['firm_name'],
                        'keywords' => $record_data['support_page_seo_keyword'] ?? $record_data['firm_name'],
                    ];
                    break;

                case 'tc_page':
                    $record_data = $this->getWebsiteProfileModel()->first();
                    $seo_data = [
                        'title' => $record_data['tc_page_seo_title'] ?? $record_data['firm_name'],
                        'description' => $record_data['tc_page_seo_description'] ?? $record_data['firm_name'],
                        'keywords' => $record_data['tc_page_seo_keyword'] ?? $record_data['firm_name'],
                    ];
                    break;
                case 'career_page':
                    $record_data = $this->getWebsiteProfileModel()->first();
                    $seo_data = [
                        'title' => $record_data['career_page_seo_title'] ?? $record_data['firm_name'],
                        'description' => $record_data['career_page_seo_description'] ?? $record_data['firm_name'],
                        'keywords' => $record_data['career_page_seo_keyword'] ?? $record_data['firm_name'],
                    ];
                    break;
                case 'faq_page':
                    $seo_data = [
                        'title' => 'FAQ - TheHillMen',
                        'description' => 'Discover our FAQ  page for more information.',
                        'keywords' => 'FAQ Question'
                    ];
                    break;
                case 'offer_detail_page': // by Offer Seo
                    $seo_data = [
                        'title' => 'Exclusive Offers - TheHillMen',
                        'description' => 'Discover our exclusive offers on sarees and more at TheHillMen. Shop now to get the best deals!',
                        'keywords' => 'offers, sarees, TheHillMen'
                    ];
                    break;
                case 'coupan_list': // by Offer Seo
                    $seo_data = [
                        'title' => 'Exclusive Coupan - TheHillMen',
                        'description' => 'coupan',
                        'keywords' => 'coupan TheHillMen'
                    ];
                    break;

                case 'OrderList': // by Offer Seo
                    $seo_data = [
                        'title' => 'Orders - TheHillMen',
                        'description' => 'order',
                        'keywords' => 'order TheHillMen'
                    ];
                    break;
                case 'offer_list_page':
                    $seo_data = [
                        'title' => 'Offers List - TheHillMen',
                        'description' => 'Browse through our comprehensive list of offers and promotions at TheHillMen. Find great deals on sarees and more!',
                        'keywords' => 'offers list, sarees, TheHillMen'
                    ];
                    break;
                case 'wishlist':
                    $seo_data = [
                        'title' => 'Your Wishlist - TheHillMen',
                        'description' => 'View and manage your wishlist of sarees and other products at TheHillMen.',
                        'keywords' => 'wishlist, sarees, TheHillMen'
                    ];
                    break;
                case 'cart':
                    $seo_data = [
                        'title' => 'Shopping Cart - TheHillMen',
                        'description' => 'Review and manage the items in your shopping cart at TheHillMen. Complete your purchase of beautiful sarees today.',
                        'keywords' => 'cart, sarees, TheHillMen'
                    ];
                    break;
                case 'checkout':
                    $seo_data = [
                        'title' => 'Checkout - TheHillMen',
                        'description' => 'Complete your purchase and checkout securely at TheHillMen. Enjoy shopping our exclusive sarees and more.',
                        'keywords' => 'checkout, sarees, TheHillMen'
                    ];
                    break;
                case 'userprofile':
                    $seo_data = [
                        'title' => 'User Profile - TheHillMen',
                        'description' => 'Manage your user profile and view your account details at TheHillMen.',
                        'keywords' => 'user profile, TheHillMen'
                    ];
                    break;
                case 'blogpage':
                    $seo_data = [
                        'title' => 'Blogs page - TheHillMen',
                        'description' => 'Manage your Blogs page at TheHillMen.',
                        'keywords' => 'Blogs page, TheHillMen'
                    ];
                    break;
                case 'customeraddress':
                    $seo_data = [
                        'title' => 'Customer Addresses - TheHillMen',
                        'description' => 'Manage your Addresses information for easy checkout and shipping at TheHillMen.',
                        'keywords' => 'customer Addresses, TheHillMen'
                    ];
                    break;
                default:
                    $seo_data = [
                        'title' => 'TheHillMen',
                        'description' => 'TheHillMen - Quality Sarees and More.',
                        'keywords' => 'sarees, TheHillMen'
                    ];
                    break;
            }
            return $seo_data;
        } catch (Exception $e) {
            throw $e;
        }
    }
    protected function header_footer()
    {
        try {
            $header_footer_data = [];
            $wpm = $this->getWebsiteProfileModel();
            // ...(aapka existing select code)...
            $header_footer_data['website_profile'] = $wpm->first();
            $header_footer_data['product_category_type'] = $this->category_type_list_array_data();
            $header_footer_data['Coupons'] = $this->coupan_list_array();

            if ($this->getCustomerId(false)) {
                // store once
                $customer_id = $this->getCustomerId();

                // Cart Count
                $header_footer_data['customer_cart_count'] = $this->getCustomerCartModel()
                    ->where('customer_id', $this->getCustomerId())
                    ->countAllResults();

                // Wishlist Count
                $header_footer_data['customer_wishlist_count'] = $this->getCustomerWishlistModel()
                    ->where('customer_id', $this->getCustomerId())
                    ->countAllResults();



                if (!empty($customer_wishlist_summary) && isset($customer_wishlist_summary['total_product_count'])) {
                    // use summary value if available
                    $header_footer_data['customer_wishlist_count'] = (int) $customer_wishlist_summary['total_product_count'];
                } else {
                    // fallback: directly count wishlist rows for the customer
                    $wishlist_items = $this->getCustomerWishlistModel()
                        ->where('customer_id', $customer_id)
                        ->findAll(); // safe for small lists
                    $header_footer_data['customer_wishlist_count'] = (!empty($wishlist_items)) ? count($wishlist_items) : 0;
                }

                // static/dynamic notification count
                $header_footer_data['customer_notification_count'] = 15;
            }

            return $header_footer_data;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function home_page($customer_id = null)
    {
        try {
            $page_data = [];

            $parameters = getRequestData($this->request, 'ARRAY') ?? [];
            $customer_id = $parameters['customer_id'] ?? null;
            $page_data['header_footer_data'] = $this->header_footer() ?? [];
            $page_data['seo_data'] = $this->getSeo('home_page') ?? [];
            $page_data['offer_list'] = $this->offers_array_data();
            $page_data['new_arrival'] = $this->new_arrival_product_array_data();
            $page_data['top_search'] = $this->top_search_product_array_data();
            // all offer list
            $all_offer = $this->all_offer_array_data($customer_id);
            $page_data['all_offer_list'] = $all_offer['offerList'];
            // coupon list
            $page_data['coupon_list'] = $this->coupan_list_array();
            $categor_type = $this->getCategoryTypeModel()->select('category_type_id,category_type_name')->findAll();
            $page_data['categor_type'] = $categor_type;

            $category_type_products = [];
            if (!empty($categor_type)) {
                $count = 0; // counter
                foreach ($categor_type as $row) {
                    if ($count >= 5) { // limit to 5 categories
                        break;
                    }
                    $category_type_name = $row['category_type_name'];
                    $category_data = $this->category_type_product_array_data($category_type_name, 'ARRAY');
                    if (!empty($category_data[$category_type_name])) {
                        $category_type_products[$category_type_name] = $category_data[$category_type_name];
                        $count++; // increase counter only if products found
                    }
                }
            }
            $page_data['category_type_products'] = $category_type_products;
            $page_data['category_type_names'] = array_keys($category_type_products);

            // Initialize an array for exclusive colors
            $color_names = ['Black', 'Pink', 'White', 'Green', 'Yellow', 'Orange', 'Red', 'Teal', 'Violet', 'Blue'];
            $exclusive_colors = [];
            foreach ($color_names as $color_name) {
                // Fetch color data for each color name
                $color_data = $this->color_product_array_data($color_name, 'ARRAY');
                // Check if color data is not empty and add to exclusive_colors array
                if (!empty($color_data[$color_name])) {
                    $exclusive_colors[$color_name] = $color_data[$color_name];
                }
            }

            $page_data['exclusive_colors'] = $exclusive_colors;
            $page_data['exclusive_colors_name'] = array_keys($exclusive_colors); // Only keep names with products

            //spotlight products
            $limit      = $parameters['limit'] ?? 20;
            $offset     = $parameters['offset'] ?? 0;

            // Spotlight products filter
            $filter = [
                "limit" => [
                    "count"      => $limit,
                    "start_from" => $offset,
                ],
            ];

            $page_data['spotlight_products'] = $this->spotlight_array_data($filter);

            //fluencer products
            $limit      = $parameters['limit'] ?? 20;
            $offset     = $parameters['offset'] ?? 0;

            // fluencer products filter
            $filter = [
                "limit" => [
                    "count"      => $limit,
                    "start_from" => $offset,
                ],
            ];

            $page_data['fluencer_products'] = $this->fluencer_array_data($filter);

            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, "Data Fetch Successfully", $page_data);
        } catch (Exception $e) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }


    protected function getAllPublishedBlog($blogId = null)
    {
        try {
            $bpm = $this->getBlogPostModel();
            $bpm->select("blog_id,published_at,created_at,blog_title,blog_short_content,blog_long_content,blog_featured_image,blog_alt_text,blog_status,blog_views_count,blog_likes_count,blog_author_name");
            $bpm->select(getImagePathQueryString('blog_featured_image'));
            $bpm->select(getImagePathQueryString('blog_featured_image', true));
            if (!empty($blogId)) {
                return $bpm->where('blog_status', 'published')->find($blogId) ?? [];
            } else {
                return $bpm->where('blog_status', 'published')->findAll() ?? [];
            }
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function blog_post()
    {
        try {
            $parameters = getRequestData($this->request, 'ARRAY') ?? [];
            $page_data = [];
            $page_data['seo_data'] = $this->getSeo('blogpage') ?? [];
            $page_data['header_footer_data'] = $this->header_footer() ?? [];
            $page_data['blogs'] = $this->getAllPublishedBlog();
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, "Data Fetch Successfully", $page_data);
        } catch (Exception $e) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function blog_detail()
    {
        try {
            $parameters = getRequestData($this->request, 'ARRAY') ?? [];
            $page_data = [];
            $page_data['header_footer_data'] = $this->header_footer() ?? [];
            if (!empty($parameters['blog_id'])) {
                $page_data['seo_data'] = $this->getSeo('blog_detail_page', $parameters['blog_id']) ?? [];
            }
            $page_data['blog_detail'] = $this->getAllPublishedBlog($parameters['blog_id']);
            $page_data['blogs'] = $this->getAllPublishedBlog();
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, "Data Fetch Successfully", $page_data);
        } catch (Exception $e) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    // http://localhost:82//productlisting?f=category_types%3ABanarasi%20Saree%2CKanjeevaram%20Saree%2CEmbellished%20
    /**
     * Fetches the product listing page data with applied filters.
     * 
     * @return \CodeIgniter\HTTP\Response
     * 
     * Expected JSON input:
     * {
     *     "only_data": "boolean",      // Optional. If true, only product data will be returned without SEO or header/footer data.
     *     "seo_for": "string",         // Optional. Specifies the SEO context for the page.
     *     "record_id": "integer",      // Optional. Used for fetching SEO data.
     *     "category_types": "array",   // Optional. Array of category type names to filter by.
     *     "categories": "array",       // Optional. Array of category names to filter by.
     *     "features": "array",         // Optional. Array of feature names to filter by.
     *     "brands": "array",           // Optional. Array of brand names to filter by.
     *     "sizes": "array",            // Optional. Array of size names to filter by.
     *     "colors": "array"            // Optional. Array of color names to filter by.
     * }
     * 
     * Filter configuration:
     * {
     *     "ecommerce": true,                          // Include ecommerce-related fields
     *     "other_fields": true,                       // Include other unspecified fields
     *     "joins": [                                  // Specify the tables to join
     *         "category_type", 
     *         "category", 
     *         "brand", 
     *         "variant", 
     *         "wishlist", 
     *         "color", 
     *         "size"
     *     ],
     *     "category_type": {
     *         "category_type_names": [...]           // Filter by category type names
     *     },
     *     "category": {
     *         "category_names": [...]                // Filter by category names
     *     },
     *     "feature": {
     *         "feature_names": [...]                 // Filter by feature names
     *     },
     *     "brand": {
     *         "brand_names": [...]                   // Filter by brand names
     *     },
     *     "variant": {
     *         "other_fields": true                   // Include other fields related to variants
     *     },
     *     "size": {
     *         "size_names": [...]                    // Filter by size names
     *     },
     *     "color": {
     *         "color_names": [...]                   // Filter by color names
     *     },
     *     "price": {
     *         "from": "",                            // Price range start
     *         "to": ""                               // Price range end
     *     },
     *     "discount": {
     *         "from": "",                            // Discount range start
     *         "to": ""                               // Discount range end
     *     },
     *     "multivariant": true                       // Include multiple variants
     * }
     */
    protected function product_listing_array_data($data)
    {
        try {

            $filter = [
                "ecommerce" => true,
                "other_fields" => true,
                "joins" => ["category_type", "category", "brand", "variant", "wishlist", "color", "size", "stock", "offer", "customer_review"],
                "category_type" => [
                    "category_type_names" => (isset($data['category_types']) && !empty($data['category_types'])) ? $data['category_types'] : [],
                ],
                "category" => [
                    "category_names" => (isset($data['categories']) && !empty($data['categories'])) ? $data['categories'] : [],
                ],
                "feature" => [
                    "feature_names" => (isset($data['features']) && !empty($data['features'])) ? $data['features'] : [],
                ],
                "brand" => [
                    "brand_names" => (isset($data['brands']) && !empty($data['brands'])) ? $data['brands'] : [],
                ],
                "variant" => [
                    "other_fields" => true,
                ],
                "size" => [
                    "size_names" => (isset($data['sizes']) && !empty($data['sizes'])) ? $data['sizes'] : [],
                ],
                "color" => [
                    "color_names" => (isset($data['colors']) && !empty($data['colors'])) ? $data['colors'] : [],
                ],
                "price" => [
                    "from" => $data['p_to'] ?? null,
                    "to" => $data['p_from'] ?? null,
                ],
                "discount" => [
                    "from" => $data['d_to'] ?? null,
                    "to" => $data['d_from'] ?? null,
                ],
                "search" => $data['search'] ?? null,
                "OrderBy" => $data['sort'] ?? null,
                'limit' => [
                    'count' => 24,
                    'start_from' => isset($data['ls']) ? (int) $data['ls'] : 0 // Convert to integer
                ],
                "default_variant_only" => false,
                "multivariant" => false,
            ];
            return $this->getProductModel()->product_listing($filter) ?? [];
        } catch (Exception $e) {
            throw $e;
        }
    }
    protected function top_search_product_array_data()
    {
        try {
            $filter = [
                "ecommerce" => true,
                "other_fields" => true,
                "joins" => ["variant", "wishlist", "color", "size", "stock", "offer", "top_search", "customer_review"],
                "variant" => [
                    "other_fields" => true,
                ],
                'limit' => [
                    'count' => 8,
                    'start_from' => 0
                ],
                "OrderBy" => "top_search",
            ];
            return $this->getProductModel()->product_listing($filter) ?? [];
        } catch (Exception $e) {
            throw $e;
        }
    }
    protected function new_arrival_product_array_data()
    {
        try {
            $filter = [
                "ecommerce" => true,
                "other_fields" => true,
                "joins" => ["variant", "wishlist", "color", "size", "stock", "offer", "customer_review"],
                "variant" => [
                    "other_fields" => true,
                ],
                'limit' => [
                    'count' => 10,
                    'start_from' => 0
                ],
                "OrderBy" => "new_arrival",
            ];
            return $this->getProductModel()->product_listing($filter) ?? [];
        } catch (Exception $e) {
            throw $e;
        }
    }
    public function color_product_array_data($color_name = null, $returnType = 'JSON')
    {
        if (empty($color_name)) {
            $data = getRequestData($this->request, 'ARRAY');
            $color_name = $data['color_name'] ?? 'Black';
        }
        try {
            $filter = [
                "ecommerce" => true,
                "other_fields" => true,
                "joins" => ["variant", "wishlist", "color", "size", "stock", "offer", "customer_review"],
                "variant" => [
                    "other_fields" => true,
                ],
                "color" => [
                    "color_names" => [$color_name],
                ],
                'limit' => [
                    'count' => 10,
                    'start_from' => 0
                ],
            ];
            $color_data[$color_name] = $this->getProductModel()->product_listing($filter) ?? [];
            if ($returnType != 'JSON') {
                return $color_data;
            } else {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, 'Color Wise Product Fetch Successfully', $color_data);
            }
        } catch (Exception $e) {
            if ($returnType != 'JSON') {
                throw $e;
            } else {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, $e->getMessage());
            }
        }
    }

    public function category_type_product_array_data($category_type_name = null, $returnType = 'JSON')
    {
        if (empty($category_type_name)) {
            $data = getRequestData($this->request, 'ARRAY');
            $category_type_name = $data['category_type_name'] ?? 'Black';
        }
        try {
            $filter = [
                "ecommerce" => true,
                "other_fields" => true,
                "joins" => ["variant", "wishlist", "category_type", "size", "stock", "offer", "customer_review"],
                "variant" => [
                    "other_fields" => true,
                ],
                "category_type" => [
                    "category_type_names" => [$category_type_name],
                ],
                'limit' => [
                    'count' => 10,
                    'start_from' => 0
                ],
            ];
            $category_type_data[$category_type_name] = $this->getProductModel()->product_listing($filter) ?? [];
            if ($returnType != 'JSON') {
                return $category_type_data;
            } else {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, 'Color Wise Product Fetch Successfully', $category_type_data);
            }
        } catch (Exception $e) {
            if ($returnType != 'JSON') {
                throw $e;
            } else {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, $e->getMessage());
            }
        }
    }
    protected function getPriceRange()
    {
        try {
            $min_max_price = $this->getProductVariantModel()
                ->select('MIN(product_variant.selling_price) AS min_price, MAX(product_variant.selling_price) AS max_price')
                ->join('product', 'product.product_id = product_variant.product_id')
                ->where('product_variant.is_active', 1)
                ->findAll() ?? [];
            return $min_max_price;
        } catch (Exception $e) {
            throw $e;
        }
    }
    protected function category_type_list_array_data()
    {
        try {
            $category_type_list = $this->getCategoryTypeModel()
                ->select('category_type.category_type_id,category_type.category_type_name,category_type.category_type_alt_text')
                ->select(getImagePathQueryString('category_type_image'))
                ->select(getImagePathQueryString('category_type_image', true))
                ->select(getImagePathQueryString('category_type_icon'))
                ->select(getImagePathQueryString('category_type_icon', true))
                ->select('COUNT(product.product_id) AS product_count_category_type_wise')
                ->select('MAX(product_variant.selling_price) AS lowest_selling_price')
                ->join('product', 'product.category_type_id = category_type.category_type_id AND product.is_active = 1')
                ->join('product_variant', 'product_variant.product_id = product.product_id AND product_variant.is_active = 1')
                ->where('category_type.is_active', 1)
                ->groupBy('category_type.category_type_name')
                ->orderBy('category_type.category_type_name')
                ->findAll() ?? [];

            return $category_type_list;
        } catch (Exception $e) {
            throw $e;
        }
    }


    protected function category_list_array_data()
    {
        try {
            $category_list = $this->getCategoryModel()
                ->select('category.category_id,category.category_name,category.category_alt_text')
                ->select(getImagePathQueryString('category_image'))
                ->select(getImagePathQueryString('category_image', true))
                ->select('COUNT(product.product_id) AS product_count_category_wise')
                ->join('product', 'product.category_id = category.category_id')
                ->where('category.is_active', 1)
                ->groupBy('category.category_name')
                ->orderBy('category.category_name')
                ->findAll() ?? [];
            return $category_list;
        } catch (Exception $e) {
            throw $e;
        }
    }
    protected function brand_list_array_data()
    {
        try {
            $brand_list = $this->getBrandModel()
                ->select('brand.brand_id,brand.brand_name,brand.brand_alt_text')
                ->select(getImagePathQueryString('brand_image'))
                ->select(getImagePathQueryString('brand_image', true))
                ->select('COUNT(product.product_id) AS product_count_brand_wise')
                ->join('product', 'product.brand_id = brand.brand_id')
                ->where('brand.is_active', 1)
                ->groupBy('brand.brand_name')
                ->orderBy('brand.brand_name')
                ->findAll() ?? [];
            return $brand_list;
        } catch (Exception $e) {
            throw $e;
        }
    }
    protected function color_list_array_data()
    {
        try {
            $color_list = $this->getProductVariantModel()
                ->select('color.color_id,color.color_name,color.color_alt_text,color_code')
                ->select(getImagePathQueryString('color_image'))
                ->select(getImagePathQueryString('color_image', true))
                ->select('COUNT(product_variant.variant_id) AS product_count_color_wise')
                ->join('color', 'product_variant.color_id = color.color_id')
                ->groupBy('color.color_name')
                ->orderBy('color.color_name')
                ->findAll() ?? [];
            return $color_list;
        } catch (Exception $e) {
            throw $e;
        }
    }
    protected function size_list_array_data()
    {
        try {
            $this->getSizeModel()->select('size_id,size_name')->findAll() ?? [];
        } catch (Exception $e) {
            throw $e;
        }
    }
    protected function customer_review_list_array_data()
    {
        try {
            return $this->getCustomerReviewModel()
                ->select('customer_review_id, customer_rating, customer_review, product_id')
                ->findAll() ?? [];
        } catch (Exception $e) {
            throw $e;
        }
    }
    protected function feature_type_list_array_data()
    {
        try {
            $feature_type_list = $this->getFeatureTypeModel()->select('feature_type_id,feature_type_name')->where('is_active', 1)->findAll() ?? [];
            // Adding features to feature types
            if (!empty($feature_type_list)) {
                foreach ($feature_type_list as &$feature_type) {
                    $feature_type['features'] = $this->getFeatureModel()->select('feature_id,feature_name')->where('feature_type_id', $feature_type['feature_type_id'])->where('is_active', 1)->findAll() ?? [];
                }
            }
            return $feature_type_list;
        } catch (Exception $e) {
            throw $e;
        }
    }
    public function product_listing_page()
    {
        try {
            $parameters = getRequestData($this->request, 'ARRAY') ?? [];
            $data = [];
            $data['products'] = $this->product_listing_array_data($parameters);
            if (isset($parameters['only_data']) && $parameters['only_data'] == true) {
                // nothing
            } else {
                if (isset($parameters['seo_for'])) {
                    switch ($parameters['seo_for']) {
                        case 'category_types':
                            $parameters['seo_for'] = 'category_type_page';
                            break;
                        case 'brands':
                            $parameters['seo_for'] = 'brand_page';
                            break;
                        case 'features':
                            $parameters['seo_for'] = 'feature_page';
                            break;
                        case 'categories':
                            $parameters['seo_for'] = 'category_page';
                            break;
                        case 'offers':
                            $parameters['seo_for'] = 'offer_list_page';
                            break;
                        default:
                            // Default case if needed
                            break;
                    }
                    $data['seo_data'] = $this->getSeo($parameters['seo_for'], $parameters['record_id']) ?? [];
                }
                // Header Footer
                $headerFooterData = $this->header_footer();
                $data['header_footer_data'] = is_array($headerFooterData) ? $headerFooterData : [];
                // Filters

                $data['filters']['category'] = $this->category_list_array_data();
                $data['filters']['brand'] = $this->brand_list_array_data();
                $data['filters']['feature_type'] = $this->feature_type_list_array_data();
                $data['filters']['color'] = $this->color_list_array_data();
                $data['filters']['size'] = $this->size_list_array_data();
                $data['filters']['customer_review'] = $this->customer_review_list_array_data();

                $data['price_range'] = $this->getPriceRange();
            }
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                'Record Found',
                $data
            );
        } catch (Exception $e) {
            // Log and return error response
            log_message('error', $e->getMessage());
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }
    }

    protected function coupan_list_array()
    {
        try {
            $currentDate = date('Y-m-d H:i:s');
            return $this->getCouponModel()
                ->where('coupon_to >=', $currentDate)
                ->where('coupon_from <=', $currentDate)
                ->where('is_active', 1)->findAll();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function coupan_list()
    {
        try {
            $parameters = getRequestData($this->request, 'ARRAY');
            $page_data['coupon_list'] = $this->coupan_list_array();
            if (isset($parameters['only_data']) && $parameters['only_data'] == true) {
            } else {
                $page_data['seo_data'] = $this->getSeo('coupan_list') ?? [];
            }
            $page_data['header_footer_data'] = $this->header_footer() ?? [];

            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                'Record Found',
                $page_data
            );
        } catch (Exception $e) {
            // Log and return error response
            log_message('error', $e->getMessage());
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }
    }
    /**
     * Fetches product details for a specific variant.
     * 
     * @return \CodeIgniter\HTTP\Response
     * 
     * Expected JSON input:
     * {
     *     "variant_id": "integer"  // ID of the product variant to fetch details for
     * }
     */

    public function product_detail_page()
    {
        try {

            $page_data['header_footer_data'] = $this->header_footer() ?? [];
            $page_data['seo_data'] = $this->getSeo('product_detail_page') ?? [];
            $parameters = getRequestData($this->request, 'ARRAY') ?? [];
            $variant_id = $parameters['variant_id'] ?? null;
            $reffer_code = $parameters['rc'] ?? null;
            $source = $parameters['rs'] ?? 'direct';
            $product_detail_list = $this->product_detail_array_data(['variant_ids' => [$variant_id]]);
            $this->add_product_to_top_search($product_detail_list[0]['product_id']);
            if (!empty($product_detail_list) && isset($product_detail_list[0])) {
                $page_data['product_detail'] = $product_detail_list[0];
                $similar_category_type_product_list_filter = [
                    'category_types' => [$page_data['product_detail']['category_type_name']],
                    'limit' => [
                        'count' => 15,
                        'start_from' => 0
                    ],
                ];
                $page_data['similar_category_type_product_list'] = $this->product_listing_array_data($similar_category_type_product_list_filter);
                $similar_color_product_list_filter = [
                    'colors' => [$page_data['product_detail']['color_name']],
                    'limit' => [
                        'count' => 15,
                        'start_from' => 0
                    ],
                ];
                $product_id = $product_detail_list[0]['product_id'];

                // Get current view count
                $product = $this->getProductModel()->find($product_id);
                $current_count = (int) $product['view_count'];

                // Increment count
                $new_count = $current_count + 1;

                // Update in database
                $this->getProductModel()
                    ->update($product_id, ['view_count' => $new_count]);

                // Optional: use for display
                $page_data['view_count'] = $new_count;
                $page_data['similar_color_product_list'] = $this->product_listing_array_data($similar_color_product_list_filter);
                $page_data['review_list'] = $this->review_list($variant_id);
                $page_data['coupan'] = $this->coupan_list_array();

                // share refernce work 
                $shareByCustomer = null;
                if (!empty($reffer_code)) {
                    $customerModel = $this->getCustomerModel();
                    $shareByCustomer = $customerModel->where('reffer_code', $reffer_code)->first();
                }

                if (!empty($shareByCustomer)) {

                    $share_by_customer_id = $shareByCustomer['customer_id'];

                    // If user is same, skip share logic (do NOT return the whole function)
                    if (!(isset($_SESSION['customer_id']) && $share_by_customer_id == $_SESSION['customer_id'])) {

                        $product_id = $product_detail_list[0]['product_id'];
                        $shareModel = $this->getShareReferenceModel();

                        $existing = $shareModel
                            ->where('share_by_customer_id', $share_by_customer_id)
                            ->where('product_id', $product_id)
                            ->where('source', $source)
                            ->first();

                        if ($existing) {
                            $shareModel->update($existing['share_reference_id'], [
                                'customer_search_count' => (int)$existing['customer_search_count'] + 1,
                                'updated_at' => date('Y-m-d H:i:s'),
                            ]);
                        } else {
                            $shareModel->insert([
                                'share_by_customer_id' => $share_by_customer_id,
                                'product_id'           => $product_id,
                                'customer_search_count' => 1,
                                'source'               => $source,
                                'created_at'           => date('Y-m-d H:i:s'),
                            ]);
                        }
                    }
                }

                // after this, always return product detail
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::OK,
                    "Data Fetch Successfully",
                    $page_data
                );
            } else {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::NO_CONTENT, "No Data Found");
            }
        } catch (Exception $e) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
    protected function add_product_to_top_search($product_id)
    {
        try {
            $data = ['product_id' => $product_id];
            $tsm = $this->getTopSearchModel();
            $tsm->where('product_id', $data['product_id']);
            if ($this->getCustomerId(false)) {
                $data['customer_id'] = $this->getCustomerId();
                $tsm->where('customer_id', $data['customer_id']);
            } else {
                $tsm->where('customer_id IS NULL');
            }
            $record = $tsm->first();
            if (empty($record)) {
                $data['customer_search_count'] = 1;
                $tsm->RecordCreate($data);
            } else {
                $data['customer_search_count'] = 1 + $record['customer_search_count'];
                $tsm->RecordUpdate($data, $record['top_search_id']);
            }
            $tssm = $this->getTopSearchSummaryModel();
            $tssm->where('0=0')->delete();
            $TopSearchSummaryData = $tsm->select('product_id,SUM(customer_search_count) as total_search_count')->groupBy('product_id')->findAll() ?? [];
            if (!empty($TopSearchSummaryData)) {
                $tssm->insertBatch($TopSearchSummaryData);
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
    protected function review_list($variant_id)
    {
        try {
            $crm = $this->getCustomerReviewModel();
            $crm->select("customer_review.*, customer.fullname");
            $crm->select(getImagePathQueryString('customer_review_image1'));
            $crm->select(getImagePathQueryString('customer_review_image2'));
            $crm->select(getImagePathQueryString('customer_review_image3'));
            $crm->select(getImagePathQueryString('customer_review_image4'));
            $crm->join("customer", "customer.customer_id = customer_review.customer_id", "left");
            $crm->where("customer_review.customer_review_status", 1);
            $crm->where("customer_review.variant_id", $variant_id);

            if ($this->getCustomerId(false)) {
                $crm->where("customer_review.customer_id !=", $this->getCustomerId());
            }

            $review_list = $crm->findAll() ?? [];

            if ($this->getCustomerId(false)) {
                // Query for current customer reviews
                $crm->select("customer_review.*, customer.fullname");
                $crm->select(getImagePathQueryString('customer_review_image1'));
                $crm->select(getImagePathQueryString('customer_review_image2'));
                $crm->select(getImagePathQueryString('customer_review_image3'));
                $crm->select(getImagePathQueryString('customer_review_image4'));
                $crm->join("customer", "customer.customer_id = customer_review.customer_id", "left");
                $crm->where("customer_review.customer_id", $this->getCustomerId());
                $crm->where("customer_review.variant_id", $variant_id);
                $review_list = array_merge($review_list, $crm->findAll() ?? []);
            }

            $review_list = sort_by_datetime('created_at', $review_list);
            return $review_list ?? [];
        } catch (Exception $e) {
            throw $e;
        }
    }

    protected function product_detail_array_data($data): array
    {
        try {
            $filter = [
                "ecommerce" => true,
                "other_fields" => true,
                "joins" => ["category_type", "category", "brand", "variant", "wishlist", "cart", "color", "size", "stock", "offer", "customer_review", "top_search"],
                "variant" => [
                    "other_fields" => true,
                    "variant_ids" => (isset($data['variant_ids']) && !empty(isset($data['variant_ids']))) ? $data['variant_ids'] : [],
                ],
                "default_variant_only" => false,
                "default_size_only" => true,
                "multivariant" => true,
                "multifeature" => true,
                "multisizes" => true,
            ];
            return $this->getProductModel()->product_listing($filter) ?? [];
        } catch (Exception $e) {
            throw $e;
        }
    }
    /**
     * Fetches the wishlist page data.
     * 
     * @return \CodeIgniter\HTTP\Response
     * 
     * Expected JSON input:
     * {
     *     "only_data": "boolean"  // Optional. If true, only product data will be returned without SEO or header/footer data.
     * }
     * 
     * Filter configuration:
     * {
     *     "ecommerce": true,                      // Include ecommerce-related fields
     *     "other_fields": true,                   // Include other unspecified fields
     *     "joins": [                              // Specify the tables to join
     *         "category_type", 
     *         "category", 
     *         "brand", 
     *         "variant", 
     *         "wishlist", 
     *         "color", 
     *         "size"
     *     ],
     *     "variant": {
     *         "other_fields": true                // Include other fields related to variants
     *     },
     *     "multivariant": true,                   // Include multiple variants
     *     "wishlist": {
     *         "wishlist_only": true               // Fetch only wishlist items
     *     }
     * }
     */
    protected function wishlist_page_array()
    {
        try {
            $filter = [
                "ecommerce" => true,
                "other_fields" => true,
                "joins" => ["variant", "wishlist", "color", "size", "stock", "offer", "customer_review"],
                "variant" => [
                    "other_fields" => true,
                ],
                "multivariant" => true,
                "wishlist" => [
                    "wishlist_only" => true
                ],

            ];
            return $this->getProductModel()->product_listing($filter) ?? [];
        } catch (Exception $e) {
            throw $e;
        }
    }
    public function wishlist_page()
    {
        try {
            $parameters = getRequestData($this->request, 'ARRAY');

            if (isset($parameters['only_data']) && $parameters['only_data'] == true) {
                // nothing
            } else {
                $page_data['seo_data'] = $this->getSeo('wishlist') ?? [];
                $page_data['header_footer_data'] = $this->header_footer() ?? [];
            }
            // Fetch Products
            $page_data['Wishlistproducts'] = $this->wishlist_page_array();

            // Return the formatted response
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                'Record Found',
                $page_data
            );
        } catch (Exception $e) {
            // Log and return error response
            log_message('error', $e->getMessage());
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }
    }
    protected function offers_array_data()
    {
        try {
            $filter = [
                "ecommerce" => true,
                "other_fields" => true,
                "joins" => ["variant", "wishlist", "color", "size", "stock", "offer", "customer_review"],
                "variant" => [
                    "other_fields" => true,
                ],
                "offer" => [
                    "offer_only" => true,
                    "offer_type" => "deal_of_the_day",
                ],
            ];
            return $this->getProductModel()->product_listing($filter) ?? [];
        } catch (Exception $e) {
            throw $e;
        }
    }
    public function offers_page()
    {
        try {
            $parameters = getRequestData($this->request, 'ARRAY');
            $page_data['offer_list'] = $this->offers_array_data();
            if (isset($parameters['only_data']) && $parameters['only_data'] == true) {
            } else {
                $page_data['seo_data'] = $this->getSeo('offer_list_page') ?? [];
            }
            $page_data['header_footer_data'] = $this->header_footer() ?? [];
            $page_data['filters']['offer'] =
                $this->getOfferModel()
                ->select('*')
                ->where('is_active', 1)
                ->findAll() ?? [];


            // Return the formatted response
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                'Record Found',
                $page_data
            );
        } catch (Exception $e) {
            // Log and return error response
            log_message('error', $e->getMessage());
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }
    }

    protected function spotlight_array_data($extraFilter = [])
    {
        try {
            $filter = [
                "ecommerce"     => true,
                "other_fields"  => true,
                "joins"         => ["variant", "wishlist", "color", "size", "stock", "offer", "customer_review"],
                "variant"       => [
                    "other_fields" => true,
                ],
                "spotlight_only" => true,
            ];

            $filter = array_merge($filter, $extraFilter);

            $result = $this->getProductModel()->product_listing($filter) ?? [];

            // 👉 UNIQUE PRODUCT_ID FILTER
            $uniqueProducts = [];
            $seenProductIds = [];
            foreach ($result as $row) {

                //  skip inactive products
                if (!isset($row['is_active']) || $row['is_active'] != "1") {
                    continue;
                }

                //  unique product_id
                if (!in_array($row['product_id'], $seenProductIds)) {
                    $seenProductIds[] = $row['product_id'];
                    $uniqueProducts[] = $row;
                }
            }

            return $uniqueProducts;
        } catch (Exception $e) {
            throw $e;
        }
    }

    protected function fluencer_array_data($extraFilter = [])
    {
        try {
            $filter = [
                "ecommerce"     => true,
                "other_fields"  => true,
                "joins"         => ["variant", "wishlist", "color", "size", "stock", "offer", "customer_review"],
                "variant"       => [
                    "other_fields" => true,
                ],
                "fluencer_only" => true, // अब product filter की जगह यही key use करो
            ];

            // Merge extra filters like limit, pagination
            $filter = array_merge($filter, $extraFilter);

            $result =  $this->getProductModel()->product_listing($filter) ?? [];

            $uniqueProducts = [];
            $seenProductIds = [];

            foreach ($result as $row) {

                //  skip inactive products
                if (!isset($row['is_active']) || $row['is_active'] != "1") {
                    continue;
                }

                //  unique product_id
                if (!in_array($row['product_id'], $seenProductIds)) {
                    $seenProductIds[] = $row['product_id'];
                    $uniqueProducts[] = $row;
                }
            }

            return $uniqueProducts;
        } catch (Exception $e) {
            throw $e;
        }
    }
    public function e_wallet_current_balance($customer_id)
    {
        $currentDate = (new \DateTime())->format('Y-m-d');
        $totalWalletAmount = 0;

        /* ===============================
     * 1️⃣ All wallet credits
     * =============================== */
        $wallets = $this->getEWalletModel()
            ->where('customer_id', $customer_id)
            ->where('is_wallet_active', 1)
            ->get()
            ->getResultArray();

        if (empty($wallets)) {
            return 0;
        }

        /* ===============================
     * 2️⃣ Used wallet map (exact)
     * =============================== */
        $usedWalletMap = [];

        $withdrawals = $this->getEWallePaymentWithdrawlModel()
            ->select('deduction_details')
            ->where('customer_id', $customer_id)
            ->whereIn('status', ['paid', 'purchased'])
            ->get()
            ->getResultArray();

        foreach ($withdrawals as $row) {
            if (empty($row['deduction_details'])) continue;

            $details = json_decode($row['deduction_details'], true);
            if (!is_array($details)) continue;

            foreach ($details as $wid => $amt) {
                $usedWalletMap[$wid] = ($usedWalletMap[$wid] ?? 0) + (float)$amt;
            }
        }

        /* ===============================
     * 3️⃣ Calculate usable wallet
     * =============================== */
        foreach ($wallets as $wallet) {

            $walletId = $wallet['e_wallet_id'];
            $walletAmount = (float)$wallet['e_wallet_amount'];
            $usedAmount = $usedWalletMap[$walletId] ?? 0;

            $remaining = $walletAmount - $usedAmount;
            if ($remaining <= 0) {
                continue;
            }

            /* ===============================
         * 4️⃣ Order expiry check (DATE ONLY)
         * =============================== */
            if (empty($wallet['order_id'])) continue;

            $order = $this->getOrderModel()
                ->select('order_delivered_date, order_return_exchange_days')
                ->where('order_id', $wallet['order_id'])
                ->get()
                ->getRowArray();

            if (empty($order) || empty($order['order_delivered_date'])) {
                continue;
            }

            $expiryDate = new \DateTime($order['order_delivered_date']);
            $expiryDate->modify('+' . (int)$order['order_return_exchange_days'] . ' days');

            $expiryDateOnly = $expiryDate->format('Y-m-d');

            //  skip only if expiry is future
            if ($expiryDateOnly > $currentDate) {
                continue;
            }

            /* ===============================
         * 5️⃣ Valid remaining wallet
         * =============================== */
            $totalWalletAmount += round($remaining, 2);
        }

        return round($totalWalletAmount, 2);
    }


    public function checkout_page()
    {
        try {
            $data = getRequestData($this->request, 'ARRAY');
            $website_data = $this->header_footer() ?? [];
            $validation1 = \Config\Services::validation();

            // Add customer ID to request data
            $data['customer_id'] = $this->getCustomerId();

            if (!empty($data['customer_id'])) {
                $customer_data = $this->getCustomerModel()->find($data['customer_id']);
            }

            $data['current_ewallet_amount'] = floor(
                $this->e_wallet_current_balance($data['customer_id'])
            );


            // Validation rules
            $validation1->setRules([
                "customer_id" => "required",
                "customer_cart_ids" => "required"
            ]);

            // If validation fails, return response
            if (!$validation1->run($data)) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, "Form Validation Failed", [], $validation1->getErrors());
            }

            // Get cart list, return error if empty
            $data['multivariant'] = false;
            if (isset($data['generate_order']) && $data['generate_order'] == 'true') {
                $data['ecommerce'] = false;
            }
            $data['cart_list'] = $this->cart_list_array_data($data);
            if (empty($data['cart_list'])) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::NOT_FOUND, "No Item For Checkout");
            }

            // Fetch additional data if not only fetching cart data
            if (empty($data['only_data'])) {
                $data['seo_data'] = $this->getSeo('checkout') ?? [];
                $data['header_footer_data'] = $this->header_footer() ?? [];
            }

            // Fetch coupon list, address list, and process the checkout summary
            $data['coupon_list'] = $this->coupan_list_array($data);
            $data['address_list'] = $this->getCustomerAddressModel()->RecordList(['customer_id' => $data['customer_id']])['data'] ?? [];
            $this->checkout_summary_processed($data);

            // Fetch header and footer data
            // Order Generate 
            if (isset($data['generate_order']) && $data['generate_order'] == 'true') {
                $validation2 = \Config\Services::validation();
                $validation2->setRules([
                    "order_address_id" => [
                        "rules" => "required",
                        "errors" => [
                            "required" => "Address Required"
                        ]
                    ],
                    "fullname" => [
                        "rules" => "required",
                        "errors" => [
                            "required" => "Receiver Name Required"
                        ]
                    ],
                    "mobile" => [
                        "rules" => "required",
                        "errors" => [
                            "required" => "Receiver Number Required"
                        ]
                    ],
                    "terms_and_conditions_accept" => [
                        "rules" => "required",
                        "errors" => [
                            "required" => "Please Accept Term and Condition"
                        ]
                    ],
                    "payment_mode" => [
                        "rules" => "required|in_list[COD,online]",
                        "errors" => [
                            "required" => "Please select payment mode",
                            "in_list" => "Invalid payment mode selected"
                        ]
                    ]
                ]);

                // If validation fails, return response
                if (!$validation2->run($data)) {
                    $errors = $validation2->getErrors();
                    return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, "Fill All Required Fields Before Proceed To Pay", [], $errors);
                } else {
                    $response =  $this->order_create($data);
                    $response = array_merge($response, $website_data, $customer_data);
                    return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, "Order Created Successfully", $response);
                }
            }
            // Return successful response
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, 'Checkout Data Fetched Successfully', $data);
        } catch (Exception $e) {
            // Log error and return internal server error response
            log_message('error', $e->getMessage());
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
    protected function order_create(&$data)
    {
        $om = $this->getOrderModel();
        $oim = $this->getOrderItemModel();
        $coupon_discount = $data['coupon_discount'];
        $total_cart_amount = 0;
        $order_items = [];
        $order_address = [];

        // Find order address
        foreach ($data['address_list'] as $address) {
            if ($address['customer_address_id'] == $data['order_address_id']) {
                $order_address = $address;
                $customer_pincode = $address['customer_pincode'];
                break;
            }
        }
        // $res = $this->checkPincodeServiceability($customer_pincode);

        // Calculate total cart amount
        foreach ($data['cart_list'] as &$item) {
            $total_cart_amount += $item['final_price'];
        }

        if ($total_cart_amount <= 0) {
            $total_cart_amount = 1;
        }

        // Check if customer is partner
        $data['is_order_patner_request'] = 0;
        $is_patner = 0;
        if (!empty($data['customer_id'])) {
            $customer_data = $this->getCustomerModel()->find($data['customer_id']);
            if (!empty($customer_data)) {
                $is_patner = $customer_data['is_patner'];
            }
            if ($is_patner == 1) {
                $data['is_order_patner_request'] = $is_patner;
            }
        }

        // Prepare items
        foreach ($data['cart_list'] as &$item) {
            $item_proportion = $item['final_price'] / $total_cart_amount;
            $item_coupon_discount = $coupon_discount * $item_proportion;
            $gst_per = $item['gst_per'];
            $order_return_exchange_days = $item['product_return_exchange_days'];
            $item_total_amount = $item['total_item_amount'] - $item_coupon_discount + $item['total_shipping_charges'];
            $item_taxable_amount = $item_total_amount / (1 + 5 / 100);

            $order_items[] = [
                'customer_id' => $data['customer_id'],
                'product_id' => $item['product_id'],
                'variant_id' => $item['variant_id'],
                'size_id' => $item['size_id'],
                'color_id' => $item['color_id'],
                'purches_rate' => $item['purchase_rate'],
                'purchase_total' => $item['purchase_rate'] * $item['cart_quantity'],
                'mrp' => (int) $item['mrp'],
                'mrp_total' => (int) $item['mrp'] * $item['cart_quantity'],
                'order_qty' => $item['cart_quantity'],
                'final_discount' => $item['final_discount'],
                'final_rate' => $item['final_price'],
                'coupan_dis_amount' => $item_coupon_discount,
                'shipping_charges_amount' => $item['total_shipping_charges'],
                'item_total_amount' => $item_total_amount,
                'gst_per' => $gst_per,
                'taxable_amount' => $item_taxable_amount,
                'gst_amount' => $item_total_amount - $item_taxable_amount,

            ];
        }

        // Prepare order data
        $last_order = $om->selectMax('order_id')->first() ?? 0;
        $order_number = (!empty($last_order)) ? $last_order['order_id'] + 1 : 1;

        // Handle COD logic
        $cod_total = isset($data['cod_total']) ? (float)$data['cod_total'] : 0.00;
        $order_total = (float)$data['total_amount'];

        // Default values
        $remaining_total = 0.00;
        $cod_charges_total = 0.00;
        $wallet_amount = 0;
        $razorpay_amount = $order_total; // For online by default
        if (isset($data['wallet_amount']) && floatval($data['wallet_amount']) > 0) {
            $wallet_amount = floatval($order_total) - floatval($data['wallet_amount']);
        } else {
            $data['wallet_amount'] = 0;
        }
        if ($data['payment_mode'] === 'COD') {
            $remaining_total = max($order_total - $cod_total, 0);
            $cod_charges_total = $cod_total;
            $razorpay_amount = $cod_total; // only pay cod_total
        }
        if ($data['payment_mode'] === 'COD' && $data['is_wallet'] === '1') {
            $remaining_total = max($wallet_amount - $cod_total, 0);
            $cod_charges_total = $cod_total;
            $razorpay_amount = $cod_total; // only pay cod_total
        }
        if ($data['payment_mode'] === 'online' && $data['is_wallet'] === '1') {
            $razorpay_amount = $order_total - $data['wallet_amount'];
        }
        $order_data = [
            'order_number' => generateDocumentNum(6, $order_number, 'ORD', null, '-'),
            'order_date' => date('Y-m-d H:i:s'),
            'customer_id' => $data['customer_id'],
            'purchase_total' => array_sum(array_column($order_items, 'purchase_total')),
            'mrp_total' => array_sum(array_column($order_items, 'mrp_total')),
            'order_coupon_code' => $data['coupon_status']['coupon_code'] ?? null,
            'coupon_calc_type' => $data['coupon_status']['calculation_type'] ?? '',
            'coupon_value' => $data['coupon_status']['coupon_value'] ?? 0,
            'coupon_dis_total' => $data['coupon_discount'] ?? '0.00',
            'shipping_charges_total' => $data['shipping_total'] ?? '0.00',
            'order_total' => $order_total,
            'remaining_total' => $remaining_total, // new field
            'cod_charges_total' => $cod_charges_total, // new field
            'gst_total' => array_sum(array_column($order_items, 'gst_amount')),
            'taxable_total' => array_sum(array_column($order_items, 'taxable_amount')),
            'order_status' => 'order_payment_pending',
            'payment_mode' => $data['payment_mode'],
            'order_payment_id' => null,
            'razorpay_order_id' => null,
            'billing_address' => $order_address['customer_addresses'],
            'billing_country_id' => $order_address['customer_country_id'],
            'billing_state_id' => $order_address['customer_state_id'],
            'billing_city_id' => $order_address['customer_city_id'],
            'billing_pincode' => $order_address['customer_pincode'],
            'receiver_name' => $data['fullname'],
            'receiver_mobile' => $data['mobile'] ?? null,
            'order_return_exchange_days' => $order_return_exchange_days ?? 0,
            'is_order_patner_request' => $data['is_order_patner_request'],
            'wallet_used_amount' => $data['wallet_amount']
        ];

        // Insert into DB
        $order_create_response = $om->RecordCreate($order_data);
        if ($order_create_response['status'] != ApiResponseStatusCode::CREATED) {
            return formatApiAutoResponse($this->request, $this->response, $order_create_response);
        }

        foreach ($order_items as &$order_item) {
            $order_item['order_id'] = $order_data['order_id'];
            $order_item_create_response = $oim->RecordCreate($order_item);
            if ($order_item_create_response['status'] != ApiResponseStatusCode::CREATED) {
                return formatApiAutoResponse($this->request, $this->response, $order_item_create_response);
            }
        }

        // Empty cart
        foreach ($data['cart_list'] as $cart_item) {
            $this->getCustomerCartModel()->delete($cart_item['customer_cart_id']);
        }

        // Razorpay integration
        $razorpay = new RazorpayController();
        $razorpay->createCustomer($data['customer_id']);
        $notes = [
            'order_id' => $order_data['order_id'],
            'order_number' => $order_data['order_number'],
            'customer_id' => $_SESSION['customer_id'],
            'fullname' => $_SESSION['fullname'],
            'email' => $_SESSION['email'],
            'mobile' => $_SESSION['mobile']
        ];

        // 🧾 For COD: create order for COD amount only
        if ($data['payment_mode'] === 'COD') {
            return $razorpay->createCODOrder($razorpay_amount, $order_data['order_id'], $notes, $order_data);
        } else {
            $orderResult = $razorpay->createOrder($razorpay_amount, $order_data['order_id'], $notes);
            if ($orderResult === null) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    $razorpay->response['status'] ?? ApiResponseStatusCode::BAD_REQUEST,
                    $razorpay->response['message'] ?? 'Order creation failed',
                    [],
                    $razorpay->response['errors'] ?? []
                );
            }
            return $orderResult;
        }
    }

    public function paymentVerify()
    {
        $data = getRequestData($this->request, 'ARRAY');
        $website_data = $this->header_footer() ?? [];
        $firm_logo = $website_data['website_profile']['firm_logo_url'] ?? '';
        $razorpay = new RazorpayController();

        // Verify payment with Razorpay
        $response = $razorpay->paymentVerify($data['razorpay_payment_id'], $data['razorpay_order_id'], $data['razorpay_signature']);

        // Set initial values based on the verification status
        $paymentStatus = $response ? "Success" : "Failed";
        $paymentRemark = $response ? "Payment Verified" : $razorpay->response['message'] ?? "Payment Verification Failed";
        $orderStatus = $response ? "order_payment_verified_razorpay" : "order_payment_fail";
        $logRemark = $response ? "Payment Verified By Razorpay" : "Payment Verification Failed";

        // Prepare payment data for saving to the database
        $paymentData = [
            "razorpay_payment_id" => $data['razorpay_payment_id'],
            "razorpay_signature"  => $data['razorpay_signature'],
            "order_id"            => (int) $data['order_id'],
            "payment_status"      => $paymentStatus,
            "payment_remark"      => $paymentRemark,
            "payment_amt"         => $data['payment_amt'],
            "payment_mode"        => $data['payment_mode'],
            "order_total"         => ($data['payment_mode'] === 'COD')
                ? $data['order_total']
                : $data['payment_amt'],
            "customer_id"        => $data['customer_id'],
        ];


        // Insert payment data and handle response
        if (!$this->savePaymentRecord($paymentData)) {
            return formatApiAutoResponse($this->request, $this->response, $paymentData);
        }

        // Prepare and update order status
        $orderData = ['order_id' => (int)$data['order_id'], 'order_status' => $orderStatus];
        if (!$this->updateOrderStatus($orderData)) {
            return formatApiAutoResponse($this->request, $this->response, $orderData);
        }

        // Log the order update
        $logData = ["order_id" => (int)$data['order_id'], "order_status" => $orderStatus, "log_remark" => $logRemark];
        if (!$this->logOrderStatus($logData)) {
            return formatApiAutoResponse($this->request, $this->response, $logData);
        }

        // Send Notification To All Admin Users

        if ($response) {
            $FC = new FirebaseController();
            $users = $this->getUserModel()->select('user_id')->where('user_type', 'admin')->findAll();
            foreach ($users as $key => $user) {
                $FC->sendNotificationToUser(
                    $user['user_id'],
                    "🛍️ New Order Alert! 🚀",
                    "Order #{$data['order_id']} just landed! 💰 Payment: ₹" . ($data['payment_amt']) . ". Review and Approve Now!",
                    base_url(route_to('admin_pending_approval')),
                    $firm_logo
                );
            }
            $FC->sendNotificationToCustomer(
                $_SESSION['customer_id'],
                "🎉 Success! Your Order is Placed! 🛍️",
                "Order #{$data['order_id']} has been confirmed. Thanks for shopping with us! 🛒 Track your order anytime.",
                $_ENV['EcommerceWebsiteDomainUrl'] . "/orderDetails/{$data['order_id']}",
                $_ENV['app.baseURL'] . $firm_logo
            );
            // ================= STOCK MINUS AFTER ORDER PLACED =================
            $orderItems = $this->getOrderItemModel()
                ->select('variant_id, order_qty')
                ->where('order_id', $data['order_id'])
                ->findAll();

            foreach ($orderItems as $item) {

                $variantId = (int) $item['variant_id'];
                $orderQty  = (int) $item['order_qty'];

                if ($variantId > 0 && $orderQty > 0) {
                    $stockRecord = $this->getStockModel()->where('variant_id', $variantId)->first();
                    if ($stockRecord) {
                        $updateStockData = [
                            'quantity' => $stockRecord['quantity'] - $orderQty,
                            'updated_at' => date('Y-m-d H:i:s'),
                        ];

                        $stockUpdated = $this->getStockModel()->RecordUpdate($updateStockData, $stockRecord['stock_id']);
                    } else {
                        $stockUpdated = false;
                    }

                    if (!$stockUpdated) {
                        // 🔔 ADMIN ALERT
                        foreach ($users as $user) {
                            $FC->sendNotificationToUser(
                                $user['user_id'],
                                "🚨 Stock Update Failed!",
                                "Stock update failed for Variant ID: {$variantId} after Order #{$data['order_id']}. Possible low stock.",
                                base_url(route_to('stock_update')),
                                $firm_logo
                            );
                        }
                    }
                }
            }


            // e-wallet create ONLY when payment is success & mode = online
            if ($response && $data['payment_mode'] === 'online') {
                $customer = $this->getCustomerModel()->find($data['customer_id']);
                $orderTotal = $data['payment_amt'];

                // WEBSITE SETTINGS
                $walletActivationAmount = $website_data['website_profile']['wallet_activation_amount'];
                $level1Percent = $website_data['website_profile']['level1_commission_percentage'];
                $level2Percent = $website_data['website_profile']['level2_comission_percentage'];

                // -------------------------------------------------------------------
                // 1️⃣ SELF CUSTOMER COMMISSION (20%) WHEN NOT PARTNER
                // -------------------------------------------------------------------
                if ($customer && $customer['is_patner'] != '1' && $orderTotal >= $walletActivationAmount) {

                    $selfCommission = ($orderTotal * 20) / 100;

                    $selfWallet = [
                        'customer_type'        => 'self',
                        'customer_id'          => $customer['customer_id'],
                        'order_id'             => $data['order_id'],
                        'e_wallet_percentage'  => 20,
                        'order_amount'         => $orderTotal,
                        'e_wallet_amount'      => $selfCommission,
                        'is_wallet_active'    => 1
                    ];

                    $this->EwalletRecordCreate($selfWallet);
                }

                // -------------------------------------------------------------------
                //  LEVEL 1 PARTNER COMMISSION (only if referral_partner_id exists)
                // -------------------------------------------------------------------
                if (!empty($customer['refferal_patner_id'])) {

                    $partner = $this->getCustomerModel()->find($customer['refferal_patner_id']);

                    if (!empty($partner)) {

                        $partnerCommission = ($orderTotal * $level1Percent) / 100;

                        $partnerWallet = [
                            'customer_type'        => 'patner',
                            'customer_id'          => $partner['customer_id'],
                            'order_id'             => $data['order_id'],
                            'e_wallet_percentage'  => $level1Percent,
                            'order_amount'         => $orderTotal,
                            'e_wallet_amount'      => $partnerCommission,
                            'is_wallet_active'    => 1
                        ];

                        $this->EwalletRecordCreate($partnerWallet);
                        // 🔔 SUPER STOCKIST (Level 1 Partner) Notification
                        $FC->sendNotificationToCustomer(
                            $partner['customer_id'],
                            "💰 Wallet Credit Successful!",
                            "₹{$partnerCommission} credited to your wallet as Super Stockist commission for Order #{$data['order_id']}.",
                            $_ENV['EcommerceWebsiteDomainUrl'] . "/walletHistory",
                            $_ENV['app.baseURL'] . $firm_logo
                        );

                        // 🔔 Admin Notification
                        foreach ($users as $user) {
                            $FC->sendNotificationToUser(
                                $user['user_id'],
                                "Wallet Credit (Super Stockist)",
                                "Super Stockist #{$partner['customer_id']} received commission for Order #{$data['order_id']}.",
                                base_url(route_to('earning_referrer_customer_list')),
                                $firm_logo
                            );
                        }


                        // -------------------------------------------------------------------
                        // 3️⃣ LEVEL 2 PARENT PARTNER COMMISSION
                        // -------------------------------------------------------------------
                        if (!empty($partner['refferal_patner_id'])) {

                            $parent = $this->getCustomerModel()->find($partner['refferal_patner_id']);

                            if (!empty($parent)) {

                                $parentCommission = ($orderTotal * $level2Percent) / 100;

                                $parentWallet = [
                                    'customer_type'        => 'parent_patner',
                                    'customer_id'          => $parent['customer_id'],
                                    'order_id'             => $data['order_id'],
                                    'e_wallet_percentage'  => $level2Percent,
                                    'order_amount'         => $orderTotal,
                                    'e_wallet_amount'      => $parentCommission,
                                    'is_wallet_active'    => 1
                                ];

                                $this->EwalletRecordCreate($parentWallet);

                                // 🔔 SUPER STOCKIST (Level 1 Partner) Notification
                                $FC->sendNotificationToCustomer(
                                    $parent['customer_id'],
                                    "💰 Wallet Credit Successful!",
                                    "₹{$parentCommission} credited to your wallet as Area Stockist commission for Order #{$data['order_id']}.",
                                    $_ENV['EcommerceWebsiteDomainUrl'] . "/walletHistory",
                                    $_ENV['app.baseURL'] . $firm_logo
                                );

                                // 🔔 Admin Notification
                                foreach ($users as $user) {
                                    $FC->sendNotificationToUser(
                                        $user['user_id'],
                                        "Wallet Credit (Area Stockist)",
                                        "Area Stockist #{$parent['customer_id']} received commission for Order #{$data['order_id']}.",
                                        base_url(route_to('earning_referrer_customer_list')),
                                        $firm_logo
                                    );
                                }
                            }
                        }
                    }
                }
                // -------------------------------------------------------------------
                //    If NO referral_partner_id then check reffer_by_id 
                //    → and give parent_partner commission if applicable
                // -------------------------------------------------------------------
                else if (($customer['refferal_patner_id'] == null) && !empty($customer['reffer_by_id'])) {

                    $referBy = $this->getCustomerModel()->find($customer['reffer_by_id']);

                    if (!empty($referBy) && !empty($referBy['refferal_patner_id'])) {

                        // parent partner found
                        $parent = $this->getCustomerModel()->find($referBy['refferal_patner_id']);

                        if (!empty($parent)) {

                            $parentCommission = ($orderTotal * $level2Percent) / 100;

                            $parentWallet = [
                                'customer_type'        => 'parent_patner',
                                'customer_id'          => $parent['customer_id'],
                                'order_id'             => $data['order_id'],
                                'e_wallet_percentage'  => $level2Percent,
                                'order_amount'         => $orderTotal,
                                'e_wallet_amount'      => $parentCommission,
                                'is_wallet_active'    => 1
                            ];

                            $this->EwalletRecordCreate($parentWallet);
                            // 🔔 SUPER STOCKIST (Level 1 Partner) Notification
                            $FC->sendNotificationToCustomer(
                                $parent['customer_id'],
                                "💰 Wallet Credit Successful!",
                                "₹{$parentCommission} credited to your wallet as Area Stockist commission for Order #{$data['order_id']}.",
                                $_ENV['EcommerceWebsiteDomainUrl'] . "/walletHistory",
                                $_ENV['app.baseURL'] . $firm_logo
                            );

                            // 🔔 Admin Notification
                            foreach ($users as $user) {
                                $FC->sendNotificationToUser(
                                    $user['user_id'],
                                    "Wallet Credit (Area Stockist)",
                                    "Area Stockist #{$parent['customer_id']} received commission for Order #{$data['order_id']}.",
                                    base_url(route_to('earning_referrer_customer_list')),
                                    $firm_logo
                                );
                            }
                        }
                    }
                }
            }

            // wallet se payment kiya h to wallet ki table se us data ko remove krna h
            if ($response && $data['is_wallet'] == '1') {

                $walletAmountToDeduct = (float) $data['wallet_amount'];

                /* ===============================
                  * 1️⃣ Fetch wallet credits FIFO
                  * =============================== */
                $walletEntries = $this->getEwalletModel()
                    ->where('customer_id', $data['customer_id'])
                    ->where('is_wallet_active', 1)
                    ->orderBy('created_at', 'ASC')
                    ->get()
                    ->getResultArray();

                /* ===============================
                  * 2️⃣ Already used map
                  * =============================== */
                $usedWalletMap = [];

                $usedRows = $this->getEWallePaymentWithdrawlModel()
                    ->select('deduction_details')
                    ->where('customer_id', $data['customer_id'])
                    ->whereIn('status', ['paid', 'purchased'])
                    ->get()
                    ->getResultArray();

                foreach ($usedRows as $row) {
                    if (empty($row['deduction_details'])) continue;

                    $details = json_decode($row['deduction_details'], true);
                    if (!is_array($details)) continue;

                    foreach ($details as $wid => $amt) {
                        $usedWalletMap[$wid] = ($usedWalletMap[$wid] ?? 0) + (float)$amt;
                    }
                }

                /* ===============================
                  * 3️⃣ FILTER ELIGIBLE (expiry passed)
                  * =============================== */
                $currentDateOnly = date('Y-m-d');
                $eligibleWalletEntries = [];

                foreach ($walletEntries as $entry) {

                    if (empty($entry['order_id'])) continue;

                    $order = $this->getOrderModel()
                        ->select('order_delivered_date, order_return_exchange_days')
                        ->where('order_id', $entry['order_id'])
                        ->get()
                        ->getRowArray();

                    if (empty($order) || empty($order['order_delivered_date'])) continue;

                    $expiryDate = new \DateTime($order['order_delivered_date']);
                    $expiryDate->modify('+' . (int)$order['order_return_exchange_days'] . ' days');

                    if ($expiryDate->format('Y-m-d') > $currentDateOnly) continue;

                    $eligibleWalletEntries[] = $entry;
                }

                /* ===============================
                  * 4️⃣ FIFO deduction (CORRECT)
                  * =============================== */
                $remaining = (float)$data['wallet_amount'];
                $deductionDetails = [];
                $totalDeducted = 0;

                foreach ($eligibleWalletEntries as $entry) {

                    if ($remaining <= 0) break;

                    $wid   = $entry['e_wallet_id'];
                    $total = (float)$entry['e_wallet_amount'];
                    $used  = $usedWalletMap[$wid] ?? 0;

                    $available = $total - $used;
                    if ($available <= 0) continue;

                    $deduct = min($available, $remaining);

                    $deductionDetails[$wid] = $deduct;
                    $totalDeducted += $deduct;
                    $remaining -= $deduct;
                }

                /* ===============================
                * 5️⃣ Record wallet withdrawal
                * =============================== */
                if (!empty($deductionDetails) && $totalDeducted > 0) {

                    $withdrawData = [
                        "customer_id"       => $data['customer_id'],
                        "order_id"          => $data['order_id'], // ✅ best practice
                        "e_wallet_ids"      => json_encode(array_keys($deductionDetails)),
                        "requested_amount"  => $totalDeducted,
                        "approved_amount"   => $totalDeducted,
                        "deduction_details" => json_encode($deductionDetails),
                        "status"            => "purchased",
                        "payment_method"    => "wallet",
                        "transaction_id"    => $data['razorpay_payment_id'] ?? null,
                        "remark"            => "Wallet Used For Order #" . $data['order_id'],
                        "created_at"        => date('Y-m-d H:i:s')
                    ];

                    $withdrawResponse = $this->getEWallePaymentWithdrawlModel()->RecordCreate($withdrawData);

                    if ($withdrawResponse) {

                        /* 🔔 CUSTOMER NOTIFICATION */
                        $FC->sendNotificationToCustomer(
                            $data['customer_id'],
                            "💳 Wallet Used Successfully",
                            "₹{$totalDeducted} deducted from your wallet for Order #{$data['order_id']}.",
                            $_ENV['EcommerceWebsiteDomainUrl'] . "/orderhistory",
                            $_ENV['app.baseURL'] . $firm_logo
                        );

                        /* 🔔 ADMIN NOTIFICATION */
                        foreach ($users as $user) {
                            $FC->sendNotificationToUser(
                                $user['user_id'],
                                "Wallet Payment Used",
                                "Customer #{$data['customer_id']} used ₹{$totalDeducted} from wallet for Order #{$data['order_id']}.",
                                base_url(route_to('admin_pending_approval')),
                                $firm_logo
                            );
                        }
                    }
                }
            }
        }

        // Return the appropriate response based on the payment verification result
        // if ($response) {
        //     $this->getCouponModel()->generateReferCoupon($_SESSION['customer_id'], 'after_order_placed');
        // }
        $statusCode = $response ? ApiResponseStatusCode::OK : ApiResponseStatusCode::BAD_REQUEST;
        $message = $response ? "Payment Verified Successfully" : "Payment Verification Failed";
        return formatApiResponse($this->request, $this->response, $statusCode, $message);
    }
    public function deductStock(int $variantId, int $qty): bool
    {
        return $this->getStockModel()->where('variant_id', $variantId)
            ->where('quantity >=', $qty) // prevent negative stock
            ->set('quantity', "quantity - {$qty}", false)
            ->set('updated_at', date('Y-m-d H:i:s'))
            ->update();
    }

    private function EwalletRecordCreate($eWalletData)
    {
        $EWalletRecord = $this->getEwalletModel()->RecordCreate($eWalletData);
        return $EWalletRecord['status'] === ApiResponseStatusCode::CREATED;
    }
    // Helper function to save payment record
    private function savePaymentRecord($paymentData)
    {
        $paymentRecord = $this->getOrderPaymentModel()->RecordCreate($paymentData);
        return $paymentRecord['status'] === ApiResponseStatusCode::CREATED;
    }

    // Helper function to update order status
    private function updateOrderStatus($orderData)
    {
        $orderUpdate = $this->getOrderModel()->RecordUpdate($orderData, (int)$orderData['order_id']);
        return $orderUpdate['status'] === ApiResponseStatusCode::OK;
    }

    public function updateOrderRemainingAmount($orderData = null)
    {
        try {
            $data = getRequestData($this->request, 'ARRAY') ?? [];
            $orderId = $data['order_id'] ?? ($orderData['order_id'] ?? null);
            $remainingAmount = $data['remaining_total'] ?? ($orderData['remaining_total'] ?? null);
            $deliverDate = $data['order_delivered_date'] ?? ($orderData['order_delivered_date'] ?? null);

            // Prepare data for update
            $updateData = [
                'remaining_total' => $remainingAmount,
                'order_delivered_date' => $deliverDate,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            // Perform update using existing RecordUpdate method
            $orderUpdate = $this->getOrderModel()->RecordUpdate($updateData, (int)$orderId);

            // Check if update was successful
            if (!empty($orderUpdate) && $orderUpdate['status'] === ApiResponseStatusCode::OK) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::OK,
                    "Order remaining amount updated successfully",
                    $orderUpdate
                );
            } else {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::NOT_FOUND,
                    "Failed to update remaining amount or order not found",
                    $orderUpdate
                );
            }
        } catch (\Throwable $e) { // using Throwable to catch all errors & exceptions
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::INTERNAL_SERVER_ERROR,
                "Error while updating remaining amount: " . $e->getMessage()
            );
        }
    }

    // Helper function to log order status update
    private function logOrderStatus($logData)
    {
        $logRecord = $this->getOrderLogModel()->RecordCreate($logData);
        return $logRecord['status'] === ApiResponseStatusCode::CREATED;
    }


    public function paymentFail()
    {
        $data = getRequestData($this->request, 'ARRAY');
        $data['order_status'] = 'order_payment_fail';
        $data['order_remark'] = 'Payment Popup Closed By Customer';
        $response = $this->getOrderModel()->RecordUpdate($data, $data['order_id']);
        if ($response['status'] == ApiResponseStatusCode::OK) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, "Payment Failed");
        } else {
            return formatApiAutoResponse($this->request, $this->response, $response);
        }
    }


    protected function checkout_summary_processed(array &$checkout_data)
    {
        foreach ($checkout_data['cart_list'] as &$product) {
            $product['total_item_amount'] = $product['final_price'] * $product['cart_quantity'];
        }

        $checkout_data['sub_total'] = array_sum(array_column($checkout_data['cart_list'], 'total_item_amount'));
        $checkout_data['coupon_discount'] = $this->getApplyCouponAmount($checkout_data);
        $checkout_data['shipping_total'] = $this->getShippingCharges($checkout_data);
    }


    protected function getApplyCouponAmount(array &$checkout_data): float
    {
        // Initialize coupon discount to 0
        $coupon_discount = 0.00;

        // Return early if no coupon code
        if (empty($checkout_data['coupon_code'])) {
            $checkout_data['coupon_status'] = $this->generateCouponResponse(false, 'Coupon Not Applied Yet', $coupon_discount, '', 'ERR_COUPON_CODE_BLANK');
            return $coupon_discount;
        }

        // Fetch coupon data
        $coupon_data = $this->getCouponModel()->where('coupon_code', $checkout_data['coupon_code'])->first();

        // Validate coupon
        if (!$coupon_data || $coupon_data['is_active'] != 1 || !$this->isCouponValid($coupon_data, $checkout_data)) {
            $checkout_data['coupon_status'] = $this->generateCouponResponse(false, 'Invalid coupon.', $coupon_discount, $checkout_data['coupon_code'], 'ERR_COUPON_INVALID');
            return $coupon_discount;
        }

        // Calculate coupon discount based on percentage or fixed value
        $coupon_discount = $coupon_data['calculation_type'] === 'percentage'
            ? ($coupon_data['coupon_value'] / 100) * $checkout_data['sub_total']
            : $coupon_data['coupon_value'];

        $checkout_data['coupon_status'] = $this->generateCouponResponse(true, 'Coupon applied successfully.', $coupon_discount, $checkout_data['coupon_code'], 'SUCCESS', ["coupon_value" => $coupon_data['coupon_value'], "calculation_type" => $coupon_data['calculation_type']]);
        return $coupon_discount;
    }

    // Validate coupon dates and order value range
    protected function isCouponValid($coupon_data, &$checkout_data): bool
    {
        $current_date = date('Y-m-d H:i:s');

        // Check if coupon is within valid date range
        if ((!empty($coupon_data['coupon_from']) && $current_date < $coupon_data['coupon_from']) ||
            (!empty($coupon_data['coupon_to']) && $current_date > $coupon_data['coupon_to'])
        ) {
            return false;
        }

        // Check if the order value is within coupon's min/max limits
        if ((!empty($coupon_data['min_order_value']) && $checkout_data['sub_total'] < $coupon_data['min_order_value']) ||
            (!empty($coupon_data['max_order_value']) && $checkout_data['sub_total'] > $coupon_data['max_order_value'])
        ) {
            return false;
        }
        if ($coupon_data['repeat_no'] == 0 && $coupon_data['max_use_coupon_count'] == 0) {
            return true;
        } else {
            $order_data = $this->getOrderModel()
                ->select('IFNULL(COUNT(order_coupon_code), 0) as coupon_used_count')
                ->where('order_coupon_code', $coupon_data['coupon_code'])
                ->where('customer_id', $_SESSION['customer_id'])
                ->groupBy('order_coupon_code, customer_id')
                ->first();
            // Check if coupon usage exceeds the allowed repeat number
            if (isset($order_data) && !empty($coupon_data['repeat_no']) && $order_data['coupon_used_count'] >= $coupon_data['repeat_no']) {
                return false; // Coupon has been used more than allowed
            }
            return true;
        }
    }


    /**
     * Helper function to generate a standardized coupon response.
     */
    protected function generateCouponResponse(
        bool $is_applied,
        string $message,
        float $discount = 0.00,
        string $coupon_code = '',
        string $error_code = '',
        array $extra_data = []
    ): array {
        try {
            return array_merge([
                'status' => $is_applied ? 'success' : 'error',
                'coupon_code' => $coupon_code,
                'coupon_discount_amt' => $discount,
                'is_coupon_applied' => $is_applied,
                'coupon_message' => $message,
                'error_code' => $is_applied ? null : $error_code
            ], $extra_data);
        } catch (Exception $e) {
            throw $e;
        }
    }

    protected function getShippingCharges(array &$checkout_data): float
    {
        // Shipping amount will come from frontend
        $shipping = isset($checkout_data['shipping_total'])
            ? floatval($checkout_data['shipping_total'])
            : 0;

        // Product-wise shipping remove
        foreach ($checkout_data['cart_list'] as &$product) {
            $product['total_shipping_charges'] = 0;
        }

        // Final total amount
        $checkout_data['total_amount'] =
            ($checkout_data['sub_total'] - $checkout_data['coupon_discount'])
            + $shipping;

        return $shipping;
    }


    protected function checkThirdPartyShipping(): bool
    {
        return false;
    }
    public function about_page()
    {
        try {
            $page_data['header_footer_data'] = $this->header_footer() ?? [];
            $parameters = getRequestData($this->request, 'ARRAY') ?? [];
            $page_data = [];
            $page_data['seo_data'] = $this->getSeo('about_page') ?? [];
            $page_data['header_footer_data'] = $this->header_footer() ?? [];

            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, "Data Fetch Successfully", $page_data);
        } catch (Exception $e) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
    public function contact_page()
    {
        try {
            $page_data['header_footer_data'] = $this->header_footer() ?? [];
            $parameters = getRequestData($this->request, 'ARRAY') ?? [];
            $page_data = [];
            $page_data['seo_data'] = $this->getSeo('contact_page') ?? [];
            $page_data['header_footer_data'] = $this->header_footer() ?? [];
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, "Data Fetch Successfully", $page_data);
        } catch (Exception $e) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
    public function career_page()
    {
        try {
            $parameters = getRequestData($this->request, 'ARRAY') ?? [];
            $page_data = [];
            $page_data['seo_data'] = $this->getSeo('career_page') ?? [];
            $page_data['header_footer_data'] = $this->header_footer() ?? [];
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, "Data Fetch Successfully", $page_data);
        } catch (Exception $e) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
    public function faq_page()
    {
        try {
            $parameters = getRequestData($this->request, 'ARRAY') ?? [];
            $page_data = [];
            $page_data['seo_data'] = $this->getSeo('faq_page') ?? [];
            $page_data['faqList'] = $this->getFaqModel()->where('faq_status', 'published')->findAll() ?? [];
            $page_data['header_footer_data'] = $this->header_footer() ?? [];
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, "Data Fetch Successfully", $page_data);
        } catch (Exception $e) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
    public function support_page()
    {
        try {
            $parameters = getRequestData($this->request, 'ARRAY') ?? [];
            $page_data = [];
            $page_data['seo_data'] = $this->getSeo('support_page') ?? [];
            $page_data['header_footer_data'] = $this->header_footer() ?? [];
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, "Data Fetch Successfully", $page_data);
        } catch (Exception $e) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
    public function term_and_condition_page()
    {
        try {
            $parameters = getRequestData($this->request, 'ARRAY') ?? [];
            $page_data = [];
            $page_data['seo_data'] = $this->getSeo('tc_page') ?? [];
            $page_data['header_footer_data'] = $this->header_footer() ?? [];
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, "Data Fetch Successfully", $page_data);
        } catch (Exception $e) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
    public function privacy_and_policy_page()
    {
        try {
            $parameters = getRequestData($this->request, 'ARRAY') ?? [];
            $page_data = [];
            $page_data['seo_data'] = $this->getSeo('pp_page') ?? [];
            $page_data['header_footer_data'] = $this->header_footer() ?? [];
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, "Data Fetch Successfully", $page_data);
        } catch (Exception $e) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
    public function shipping_policy_page()
    {
        try {
            $parameters = getRequestData($this->request, 'ARRAY') ?? [];
            $page_data = [];
            $page_data['seo_data'] = $this->getSeo('shipping_policy_page') ?? [];
            $page_data['header_footer_data'] = $this->header_footer() ?? [];
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, "Data Fetch Successfully", $page_data);
        } catch (Exception $e) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
    public function return_policy_page()
    {
        try {
            $parameters = getRequestData($this->request, 'ARRAY') ?? [];
            $page_data = [];
            $page_data['seo_data'] = $this->getSeo('return_page') ?? [];
            $page_data['header_footer_data'] = $this->header_footer() ?? [];
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, "Data Fetch Successfully", $page_data);
        } catch (Exception $e) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
    public function refund_policy_page()
    {
        try {
            $parameters = getRequestData($this->request, 'ARRAY') ?? [];
            $page_data = [];
            $page_data['seo_data'] = $this->getSeo('refund_page') ?? [];
            $page_data['header_footer_data'] = $this->header_footer() ?? [];
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, "Data Fetch Successfully", $page_data);
        } catch (Exception $e) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
    public function disclaimer_page()
    {
        try {
            $parameters = getRequestData($this->request, 'ARRAY') ?? [];
            $page_data = [];
            $page_data['seo_data'] = $this->getSeo('disclaimer_page') ?? [];
            $page_data['header_footer_data'] = $this->header_footer() ?? [];
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, "Data Fetch Successfully", $page_data);
        } catch (Exception $e) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }


    // Customer Registration
    /**
     * {"fullname":"required","email":"required","mobile":"required"}
     */
    public function customer_registration()
    {
        try {
            $data = getRequestData($this->request, 'ARRAY');
            $validation = \Config\Services::validation();
            // $page_data['header_footer_data'] = $this->header_footer() ?? [];

            $validation->setRules([
                "fullname" => [
                    "rules" => "required|max_length[255]|regex_match[/^[A-Za-z\s]+$/]",
                    "errors" => [
                        "regex_match" => "Fullname cannot contain numbers or special characters."
                    ]
                ],
                'email' => 'permit_empty|valid_email',
                'mobile' => 'required|numeric|min_length[10]|max_length[15]',
            ]);

            // Run validation
            if (!$validation->run($data)) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, "Form Validation Failed", [], $validation->getErrors());
            }

            // customer email check already registered or not
            $existing_customer_data = $this->getCustomerModel()->where('email', $data['email'] ?? "")->first();
            if (!empty($existing_customer_data)) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, "Email Address Already Registered", [], ['email' => 'Email Address Already Registered']);
            }
            // customer mobile check already registered or not
            $existing_customer_data = $this->getCustomerModel()->where('mobile', $data['mobile'])->first();
            if (!empty($existing_customer_data)) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, "Mobile Number Already Registered", [], ['mobile' => 'Mobile Number Already Registered']);
            }
            $otp_verification_data = [
                'email' => $data['email'] ?? "",
                'mobile' => $data['mobile'],
                'otp' => $this->generateOTP(),
            ];
            $response = $this->getOTPVerificationModel()->RecordCreate($otp_verification_data);
            // Otp Verification Record Create Successfully or Not
            if ($response['status'] != ApiResponseStatusCode::CREATED) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, "Opps Error Occured ... E0001", []);
            }
            // Send OTP to Customer Mobile Number
            $otp_send = true;
            if (!$this->getSmsController()->registration_otp_send($data['mobile'], $data['fullname'], $otp_verification_data['otp'])) {
                $otp_send = false;
            }
            if (!empty($data['email'])) {
                if (!$this->getEmailController()->registration_otp_send($data['email'], $data['fullname'], $otp_verification_data['otp'])) {
                    $otp_send = false;
                }
            }
            if (!$otp_send) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, "Unable To Send Otp Please Try Again After Sometime.");
            }
            $returnData['otp_verification_id'] = $response['data']['otp_verification_id'];
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, "OTP Send Successfully", $returnData);
        } catch (Exception $e) {
            return  formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, $e->getMessage());
        }
    }
    public function customer_registration_verification()
    {
        try {

            $data = getRequestData($this->request, 'ARRAY');

            $validation = \Config\Services::validation();

            $validation->setRules([
                "fullname" => "required|max_length[255]",
                'email' => 'permit_empty|valid_email',
                'mobile' => [
                    'rules' => 'required|numeric|min_length[10]|max_length[15]|regex_match[/^[^\s][0-9]+$/]',
                    'errors' => [
                        'regex_match' => 'Mobile number cannot start with a space.',
                    ]
                ],
                'otp' => 'required',
                'password' => [
                    'rules' => 'required|regex_match[/^[^\s].*$/]',
                    'errors' => [
                        'regex_match' => 'Password cannot start with a space.',
                    ]
                ],
                "confirm_password" => "required|matches[password]",
                "otp_verification_id" => "required",
            ]);

            if (!$validation->run($data)) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, "Form Validation Failed", [], $validation->getErrors());
            }

            $otp_verification_data = $this->getOTPVerificationModel()->find($data['otp_verification_id']);
            if (empty($otp_verification_data)) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, "Generate Otp First.");
            }

            if ($otp_verification_data['email'] != $data['email'] || $otp_verification_data['mobile'] != $data['mobile'] || $otp_verification_data['otp'] != $data['otp']) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, "Registration Information changed. Please Try Again.");
            }

            $this->getOTPVerificationModel()->delete($data['otp_verification_id']);

            $current_date = new DateTime('now');
            $otp_create_time = new DateTime($otp_verification_data['created_at']);
            $otp_expire_time = (clone $otp_create_time)->modify('+15 minutes');

            if ($current_date > $otp_expire_time) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, "OTP has expired", [], [
                    "otp_generate_time" => $otp_create_time->format('Y-m-d H:i:s'),
                    "current_date" => $current_date->format('Y-m-d H:i:s'),
                    "otp_expire_time" => $otp_expire_time->format('Y-m-d H:i:s')
                ]);
            }

            // Check if email or mobile already registered
            if ($this->getCustomerModel()->where('email', $data['email'] ?? "")->first()) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, "Email Address Already Registered", [], ['email' => 'Email Address Already Registered']);
            }

            if ($this->getCustomerModel()->where('mobile', $data['mobile'])->first()) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, "Mobile Number Already Registered", [], ['mobile' => 'Mobile Number Already Registered']);
            }

            // Generate referral code for the new customer
            $reffer_code = $this->generateReferralCode($data['fullname']);

            $reffer_by_id = null;
            $refferal_patner_id = null;

            // Check if a valid referral code is provided
            if (!empty($data['reffer_code'])) {
                // Find the referring customer by referral code
                $referring_customer = $this->getCustomerModel()->where('reffer_code', $data['reffer_code'])->first();

                if ($referring_customer) {
                    // Set the referring customer's ID
                    $reffer_by_id = $referring_customer['customer_id'];
                }
                // Check if the referring customer is a partner
                if (!empty($reffer_by_id) && $referring_customer['is_patner'] == 1) {
                    $refferal_patner_id = $reffer_by_id;
                }
            }

            // Save the customer data along with the referral code and reffer_by_id
            $customer_data = [
                'fullname' => $data['fullname'],
                'email' => $data['email'] ?? null,
                'mobile' => $data['mobile'],
                'password' => $data['password'],
                'is_active' => 1,
                'is_patner' => 0,
                'reffer_code' => $reffer_code,
                'reffer_by_id' => $reffer_by_id, // Save the referring customer's ID here
                'refferal_patner_id' => $refferal_patner_id,
            ];

            $customer_data = $this->getCustomerModel()->RecordCreate($customer_data);

            if ($customer_data['status'] != ApiResponseStatusCode::CREATED) {
                return formatApiAutoResponse($this->request, $this->response, $customer_data);
            }

            // Send SMS and email notifications
            $this->getSmsController()->send_registration_successfully($data['mobile'], $data['fullname']);
            $this->getEmailController()->send_registration_successfully($data['email'], $data['fullname']);
            // if (!empty($reffer_by_id)) {
            //     $this->getCouponModel()->generateReferCoupon($customer_data['data']['customer_id'], 'after_registration');
            // }
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, "Registration Successful", ['reffer_code' => $reffer_code]);
        } catch (Exception $e) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, $e->getMessage());
        }
    }

    protected function generateOTP()
    {

        try {
            return random_int(100000, 999999);
        } catch (Exception $e) {
            throw $e;
        }
    }

    protected function generateLoginToken(array &$customer_data)
    {
        try {
            $token = $this->getCustomerTokenModel()->generateJWTToken($customer_data);
            $userAgent = $this->request->getUserAgent();
            $croppedUserAgent = (string) strlen($userAgent) > 100 ? substr($userAgent, 0, 100) : $userAgent;
            $CustomerTokenData = [
                'customer_id' => $customer_data[$this->getCustomerModel()->getPrimaryKey()],
                'token' => $token,
                'expiry' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'ip_address' => $this->request->getIPAddress(),
                'device_name' => $croppedUserAgent,
            ];
            $this->getCustomerTokenModel()->RecordCreate($CustomerTokenData);
            $customer_data['token'] = $token;
            unset($customer_data['password']);
        } catch (Exception $e) {
            throw $e;
        }
    }
    private function generateReferralCode($fullname, $prefix = 'TheHillMen', $length = 3)
    {
        try {
            // fullname compulsory: clean it slightly
            $cleanFullname = trim(preg_replace('/\s+/', '', $fullname));

            // Generate fixed-length random number
            $uniqueNumber = str_pad(
                mt_rand(1, pow(10, $length) - 1),
                $length,
                '0',
                STR_PAD_LEFT
            );

            // Return FULLNAME + PREFIX + NUMBER as required
            return $cleanFullname . $prefix . $uniqueNumber;
        } catch (Exception $e) {
            throw $e;
        }
    }


    // Customer Login
    /**
     * {"username":"required","password":"required"}
     */
    public function customer_login()
    {
        try {
            $requestedData = getRequestData($this->request, 'ARRAY') ?? [];
            $validation = \Config\Services::validation();
            // Define validation rules
            $validation->setRules([
                'username' => [
                    'label'  => 'username',
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Email / Mobile is Required',
                    ],
                ],
                'password' => [
                    'label'  => 'Password',
                    'rules'  => 'required',
                    'errors' => [
                        'required'   => 'The {field} field is required.',
                    ],
                ],
            ]);

            // Run validation
            if ($validation->run($requestedData) === false) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Validation Failed', [], $validation->getErrors());
            }

            $result = $this->getCustomerModel()->checkLogin($requestedData['username'], $requestedData['password']);
            if ($result['status'] != ApiResponseStatusCode::OK) {
                return formatApiAutoResponse($this->request, $this->response, $result);
            }
            $customerdata = $result['data'];
            if ($customerdata['is_active'] != 1) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Account is Disabled Please Contact Your Administrator', [], ['error' => 'Account is Disabled Please Contact Your Administrator']);
            }
            $FC = new FirebaseController();
            $customerdata = array_merge($customerdata, $FC->getFrontendIntregationData());
            $this->generateLoginToken($customerdata);
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, 'Login Successfull', $customerdata);
        } catch (Exception $e) {
            throw $e;
        }
    }
    // Customer Forget Password
    /**
     * {"username":"required"}
     */
    public function customer_login_otp()
    {
        try {
            // Retrieve requested data from request
            $requestedData = getRequestData($this->request, 'ARRAY') ?? [];

            // Load validation service
            $validation = \Config\Services::validation();

            // Define validation rules for 'username'
            $validation->setRules([
                'username' => [
                    'label'  => 'Username',
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Email / Mobile is Required',
                    ],
                ],
            ]);

            // Validate requested data against defined rules
            if ($validation->run($requestedData) === false) {
                // Return validation failed response
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::VALIDATION_FAILED,
                    'Validation Failed',
                    [],
                    $validation->getErrors()
                );
            }

            // Attempt to find user by email or mobile
            $customer_data = $this->getCustomerModel()
                ->orWhere('email', $requestedData['username'])
                ->orWhere('mobile', $requestedData['username'])
                ->first();

            // If no user found, return not found response
            if (empty($customer_data)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::NOT_FOUND,
                    'Username Not Found'
                );
            }

            // Generate OTP and prepare update data
            $otp_verification_data = [
                'email' => $customer_data['email'] ?? "",
                'mobile' => $customer_data['mobile'],
                'otp' => $this->generateOTP(),
            ];
            $response = $this->getOTPVerificationModel()->RecordCreate($otp_verification_data);
            // Otp Verification Record Create Successfully or Not
            if ($response['status'] != ApiResponseStatusCode::CREATED) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, "Opps Error Occured ... E0002", []);
            }
            // Initialize OTP send status as false
            $otp_send = false;

            // Attempt to send OTP via email, if email is provided
            if (!empty($customer_data['email'])) {
                if ($this->getEmailController()->login_otp_send($customer_data['email'], $customer_data['fullname'], $otp_verification_data['otp'])) {
                    $otp_send = true;
                }
            }

            // Attempt to send OTP via SMS
            if ($this->getSmsController()->login_otp_send($customer_data['mobile'], $customer_data['fullname'], $otp_verification_data['otp'])) {
                $otp_send = true;
            }

            // Check if OTP sending was successful
            if (!$otp_send) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, "Unable to send OTP. Please try again later.");
            }

            $returnData = [
                "otp_verification_id" => $response['data']['otp_verification_id']
            ];
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, 'OTP Send Successfully', $returnData);
        } catch (Exception $e) {
            // Catch any exceptions and return a bad request response with error message
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::BAD_REQUEST,
                $e->getMessage()
            );
        }
    }

    // Customer Login
    /**
     * {"username":"required","otp":"required"}
     */
    public function customer_login_otp_verification()
    {
        try {
            $requestedData = getRequestData($this->request, 'ARRAY') ?? [];
            $validation = \Config\Services::validation();
            // Define validation rules
            $validation->setRules([
                'username' => [
                    'label'  => 'Username',
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Email / Mobile is required',
                    ],
                ],
                'otp' => [
                    'label'  => 'OTP',
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'OTP is required',
                    ],
                ],
                'otp_verification_id' => [
                    'label'  => 'otp_verification_id',
                    'rules'  => 'required',
                ],
            ]);

            // Run validation
            if ($validation->run($requestedData) === false) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Validation Failed', [], $validation->getErrors());
            }

            // Attempt to find user by email or mobile
            $customer_data = $this->getCustomerModel()
                ->orWhere('email', $requestedData['username'])
                ->orWhere('mobile', $requestedData['username'])
                ->first();

            // If no user found, return not found response
            if (empty($customer_data)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::NOT_FOUND,
                    'Username Not Found'
                );
            }

            $result = $this->getOTPVerificationModel()->RecordGet($requestedData['otp_verification_id']);
            if ($result['status'] != ApiResponseStatusCode::OK) {
                return formatApiAutoResponse($this->request, $this->response, $result);
            }
            if ($result['data']['otp'] != $requestedData['otp']) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::VALIDATION_FAILED,
                    'OTP Not Match'
                );
            }
            if ($customer_data['is_active'] != 1) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Account is Disabled. Please Contact Your Administrator', [], ['error' => 'Account is Disabled. Please Contact Your Administrator']);
            }
            $FC = new FirebaseController();
            $customer_data = array_merge($customer_data, $FC->getFrontendIntregationData());
            $this->generateLoginToken($customer_data);
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, 'Login Successful', $customer_data);
        } catch (Exception $e) {
            return  formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, $e->getMessage());
        }
    }

    // Customer Forget Password
    /**
     * {"username":"required"}
     */
    public function customer_forget_password()
    {
        try {
            // Retrieve requested data from the request
            $requestedData = getRequestData($this->request, 'ARRAY') ?? [];

            // Load validation service
            $validation = \Config\Services::validation();

            // Define validation rules for 'username'
            $validation->setRules([
                'username' => [
                    'label'  => 'Username',
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Email / Mobile is required',
                    ],
                ],
            ]);

            // Validate requested data against defined rules
            if (!$validation->run($requestedData)) {
                // Return validation failed response
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::VALIDATION_FAILED,
                    'Validation Failed',
                    [],
                    $validation->getErrors()
                );
            }

            // Attempt to find user by email or mobile
            $customer_data = $this->getCustomerModel()
                ->where('email', $requestedData['username'])
                ->orWhere('mobile', $requestedData['username'])
                ->first();

            // If no user found, return not found response
            if (empty($customer_data)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::NOT_FOUND,
                    'Username Not Found'
                );
            }

            // Generate OTP and prepare verification data
            $otp_verification_data = [
                'email' => $customer_data['email'] ?? "",
                'mobile' => $customer_data['mobile'],
                'otp' => $this->generateOTP(),
            ];

            // Create OTP verification record
            $response = $this->getOTPVerificationModel()->RecordCreate($otp_verification_data);

            // Check if OTP verification record creation was successful
            if ($response['status'] != ApiResponseStatusCode::CREATED) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::BAD_REQUEST,
                    "Oops! An error occurred. E0002",
                    []
                );
            }

            // Send OTP to customer mobile number
            $otp_send = true;
            if (!$this->getSmsController()->forget_password_otp_send($customer_data['mobile'], $customer_data['fullname'], $otp_verification_data['otp'])) {
                $otp_send = false;
            }

            // Optionally send OTP to email if email exists
            if (!empty($customer_data['email'])) {
                if (!$this->getEmailController()->forget_password_otp_send($customer_data['email'], $customer_data['fullname'], $otp_verification_data['otp'])) {
                    $otp_send = false;
                }
            }

            // If OTP couldn't be sent, return error response
            if (!$otp_send) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::BAD_REQUEST,
                    "Unable to send OTP. Please try again later."
                );
            }

            // Prepare data to return (OTP verification ID)
            $returnData = [
                "otp_verification_id" => $response['data']['otp_verification_id'],
            ];

            // Return success response
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                'OTP sent successfully',
                $returnData
            );
        } catch (Exception $e) {
            // Catch any exceptions and return a bad request response with error message
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::BAD_REQUEST,
                $e->getMessage()
            );
        }
    }


    // Customer Forget Password Verification
    /**
     * {"username":"required","password":"required","confirm_password":"required","otp":"required","otp_verification_id":"required"}
     */
    public function customer_forget_password_verification()
    {
        try {
            // Fetch data from the request
            $data = getRequestData($this->request, 'ARRAY');

            // Initialize validation service
            $validation = \Config\Services::validation();

            // Define validation rules
            $validation->setRules([
                'username' => [
                    'label'  => 'Username',
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Email / Mobile is required',
                    ],
                ],
                'password' => [
                    'label'  => 'Password',
                    'rules'  => 'required',
                ],
                'confirm_password' => [
                    'label'  => 'Confirm Password',
                    'rules'  => 'required|matches[password]',
                    'errors' => [
                        'matches' => 'Passwords do not match',
                    ],
                ],
                'otp' => [
                    'label'  => 'OTP',
                    'rules'  => 'required',
                ],
                'otp_verification_id' => [
                    'label'  => 'OTP Verification ID',
                    'rules'  => 'required',
                ],
            ]);

            // Run validation
            if (!$validation->run($data)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::VALIDATION_FAILED,
                    "Form Validation Failed",
                    [],
                    $validation->getErrors()
                );
            }

            // Attempt to find user by email or mobile
            $customer_data = $this->getCustomerModel()
                ->where('email', $data['username'])
                ->orWhere('mobile', $data['username'])
                ->first();

            if (empty($customer_data)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::NOT_FOUND,
                    'Username Not Found'
                );
            }

            // Fetch OTP verification data
            $otp_verification_data = $this->getOTPVerificationModel()->find($data['otp_verification_id']);
            if (empty($otp_verification_data)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::BAD_REQUEST,
                    "Generate OTP first."
                );
            }

            // Check if OTP data matches
            if (
                ($otp_verification_data['email'] != $customer_data['email'] &&
                    $otp_verification_data['mobile'] != $customer_data['mobile']) ||
                $otp_verification_data['otp'] != $data['otp']
            ) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::BAD_REQUEST,
                    "Information mismatch. Please try again."
                );
            }

            // Validate OTP expiry
            $current_date = (new DateTime())->format('Y-m-d H:i:s');
            $otp_expire_time = date('Y-m-d H:i:s', strtotime("+15 minutes", strtotime($otp_verification_data['created_at'])));

            if ($current_date > $otp_expire_time) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::BAD_REQUEST,
                    "OTP has expired"
                );
            }

            // Update customer password
            $update_data = [
                'customer_id' => $customer_data['customer_id'],
                'password' => $data['password'],
            ];

            $customer_update_result = $this->getCustomerModel()->update($update_data['customer_id'], $update_data);

            if (!$customer_update_result) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::BAD_REQUEST,
                    "Unable to update password"
                );
            }

            // Send success notifications (SMS and email)
            $this->getSmsController()->send_password_change_successfully(
                $customer_data['mobile'] ?? '',
                $customer_data['fullname'] ?? '',
            );
            $this->getEmailController()->send_password_change_successfully($customer_data['email'], $customer_data['fullname']);

            // Delete the OTP entry
            $this->getOTPVerificationModel()->delete($data['otp_verification_id']);

            // Respond with success
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                "Password changed successfully"
            );
        } catch (\Throwable $th) {
            // Catch any exceptions and return a bad request response with error message
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::BAD_REQUEST,
                $th->getMessage()
            );
        }
    }



    // Customer Address List
    /**
     * {
     *  "customer_address_id": "integer",
     *  "customer_country_id": "integer",
     *  "customer_state_id": "integer",
     *  "customer_city_id": "integer",
     *  "customer_addresses": "string",
     *  "customer_pincode": "string",
     *  "address_type": "string",
     * }
     */
    public function customer_address_list()
    {
        try {
            $data = getRequestData($this->request, 'ARRAY') ?? [];
            $data['customer_id'] = $this->getCustomerId();
            $validation = \Config\Services::validation();
            $validation->setRules([
                'customer_id' => 'required',
            ]);
            if (!$validation->run($data)) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, "Customer ID is required.");
            }
            $userAddress = $this->getCustomerAddressModel()->RecordList($data);
            $page_data = [
                'header_footer_data' => $this->header_footer() ?? [],
                'seo_data' => $this->getSeo('customteraddress') ?? [],
                'AddressList' => $userAddress['data'] ?? [],
            ];
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, "Data Fetch Successfully", $page_data);
        } catch (Exception $e) {
            // Return error response in case of exception
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
    // Customer Address Create
    /**
     * {
     *  "customer_country_id": "integer",
     *  "customer_state_id": "integer",
     *  "customer_city_id": "integer",
     *  "customer_addresses": "string",
     *  "customer_pincode": "string",
     *  "address_type": "string"
     * }
     */

    public function customer_address_create()
    {
        try {
            $data = getRequestData($this->request, 'ARRAY');
            $data['customer_id'] = $this->getCustomerId();
            $validation = \Config\Services::validation();
            $validation->setRules([
                'customer_id'         => 'required|integer',
                'customer_country_id' => 'required|integer',
                'customer_state_id'   => 'required|integer',
                'customer_city_id'    => 'required|integer',
                'customer_addresses'  => 'required|max_length[255]',
                'customer_pincode'    => 'required',
                'address_type'        => 'required|in_list[office,home,other]',
            ]);

            if (!$validation->run($data)) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, "Form Validation Failed", [], $validation->getErrors());
            }
            $customerAddressModel = $this->getCustomerAddressModel();
            $response = [];
            if (isset($data['customer_address_id']) && !empty($data['customer_address_id'])) {
                $response = $customerAddressModel->RecordUpdate($data, $data['customer_address_id']);
            } else {
                $response = $customerAddressModel->RecordCreate($data);
            }
            return formatApiAutoResponse($this->request, $this->response, $response);
        } catch (Exception $e) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, $e->getMessage());
        }
    }

    // Customer Address Delete
    /**
     * {
     *  "customer_address_id": "integer"
     * }
     */
    public function customer_address_delete()
    {
        try {
            $data = getRequestData($this->request, 'ARRAY');
            $data['customer_id'] = $this->getCustomerId();
            $validation = \Config\Services::validation();
            $validation->setRules([
                'customer_address_id' => 'required|integer',
                'customer_id' => 'required|integer'
            ]);

            if (!$validation->run($data)) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, "Validation Failed", [], $validation->getErrors());
            }

            $customerAddressModel = $this->getCustomerAddressModel();
            $response = $customerAddressModel->RecordDelete($data['customer_address_id']);

            if ($response) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, "Address Deleted Successfully");
            } else {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::NOT_FOUND, "Address Not Found");
            }
        } catch (Exception $e) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function customer_wishlist_create_update()
    {
        try {
            $customer_id = $this->getCustomerId();
            $data = getRequestData($this->request, 'ARRAY');
            $data['customer_id'] = $customer_id;

            // 🧩 Validation
            $validation = \Config\Services::validation();
            $validation->setRules([
                'product_id' => "required|integer",
                'variant_id' => "required|integer",
            ]);

            if (!$validation->run($data)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::VALIDATION_FAILED,
                    "Form Validation Failed",
                    [],
                    $validation->getErrors()
                );
            }

            $wishlistModel = $this->getCustomerWishlistModel();
            $summaryModel  = $this->getCustomerWishlistSummaryModel();

            // 🔍 Check if variant is already in wishlist for this customer
            $existingWishlist = $wishlistModel
                ->where('customer_id', $customer_id)
                ->where('variant_id', $data['variant_id'])
                ->first();

            if ($existingWishlist) {
                // 🗑 Remove from wishlist
                $wishlistModel->delete($existingWishlist['customer_wishlist_id']);

                // 🧮 Update wishlist summary
                $total = $wishlistModel->where('customer_id', $customer_id)->countAllResults();
                $summary = $summaryModel->where('customer_id', $customer_id)->first();

                if ($summary) {
                    $summaryModel->update($summary['customer_wishlist_summary_id'], [
                        'total_product_count' => $total,
                    ]);
                } else {
                    $summaryModel->insert([
                        'customer_id' => $customer_id,
                        'total_product_count' => $total,
                    ]);
                }

                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::OK,
                    "Variant removed from wishlist successfully",
                    ['Wishlistproducts' => $this->wishlist_page_array()]
                );
            }

            // ✅ Add new variant to wishlist
            $wishlist_created = $wishlistModel->insert($data);
            if ($wishlist_created) {
                // 🧮 Update wishlist summary
                $total = $wishlistModel->where('customer_id', $customer_id)->countAllResults();
                $summary = $summaryModel->where('customer_id', $customer_id)->first();

                if ($summary) {
                    $summaryModel->update($summary['customer_wishlist_summary_id'], [
                        'total_product_count' => $total,
                    ]);
                } else {
                    $summaryModel->insert([
                        'customer_id' => $customer_id,
                        'total_product_count' => $total,
                    ]);
                }

                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::CREATED,
                    "Variant added to wishlist successfully",
                    ['Wishlistproducts' => $this->wishlist_page_array()]
                );
            }

            // ⚠️ Fallback if insert failed
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::BAD_REQUEST,
                "Unable to add variant to wishlist"
            );
        } catch (Exception $e) {
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::BAD_REQUEST,
                $e->getMessage()
            );
        }
    }


    // Cart Add Item
    /**
     * {"product_id":"required","variant_id":"required","size_id":"required"}
     */
    public function customer_add_item_to_cart()
    {
        try {
            $customer_id = $this->getCustomerId();
            $data = getRequestData($this->request, 'ARRAY');
            $website_data = $this->header_footer() ?? [];
            $firm_logo = $website_data['website_profile']['firm_logo_url'] ?? '';
            $data['customer_id'] = $customer_id;

            // 🧾 Validation
            $validation = \Config\Services::validation();
            $validation->setRules([
                'product_id' => "required",
                'variant_id' => "required",
            ]);

            if (!$validation->run($data)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::VALIDATION_FAILED,
                    "Form Validation Failed",
                    [],
                    $validation->getErrors()
                );
            }

            $cartModel = $this->getCustomerCartModel();

            // Check if product already exists in cart
            $cart_data = $cartModel
                ->where("customer_id", $customer_id)
                ->where("product_id", $data["product_id"])
                ->where("variant_id", $data["variant_id"])
                ->first();

            if ($cart_data) {

                // ✅ Product already exists — increase quantity
                $new_quantity = $cart_data['cart_quantity'] + 1;

                $update_data = ['cart_quantity' => $new_quantity];
                $cart_update = $cartModel->RecordUpdate($update_data, $cart_data['customer_cart_id']);

                if ($cart_update['status'] != ApiResponseStatusCode::OK) {
                    return formatApiAutoResponse($this->request, $this->response, $cart_update);
                }

                // 🔹 STOCK CHECK (AFTER UPDATE)
                $stockData = $this->getStockModel()
                    ->where('variant_id', $data['variant_id'])
                    ->first();

                $available_stock = (int) ($stockData['quantity'] ?? 0);

                // 🚨 If cart qty > available stock
                if ($available_stock < $new_quantity) {

                    $FC = new FirebaseController();

                    $users = $this->getUserModel()
                        ->select('user_id')
                        ->where('user_type', 'admin')
                        ->findAll();

                    foreach ($users as $user) {
                        $FC->sendNotificationToUser(
                            $user['user_id'],
                            "⚠️ Stock Alert!",
                            "Variant ID {$data['variant_id']} stock is low. Available: {$available_stock}, Cart Qty: {$new_quantity}",
                            base_url(route_to('stock_update')),
                            $firm_logo
                        );
                    }
                }
            } else {
                // 🆕 Product not in cart — create new
                $data['cart_quantity'] = 1;
                $cart_created = $cartModel->RecordCreate($data);

                if ($cart_created['status'] != ApiResponseStatusCode::CREATED) {
                    return formatApiAutoResponse($this->request, $this->response, $cart_created);
                }
            }

            // 🧮 Always update cart summary after add
            $this->updateCustomerCartSummary($customer_id);

            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                "Product added/updated in cart successfully",
                [
                    'cart_list' => $this->cart_list_array_data()
                ]
            );
        } catch (Exception $e) {
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::BAD_REQUEST,
                $e->getMessage()
            );
        }
    }

    // Cart Less Item
    /**
     * {"product_id":"required","variant_id":"required","size_id":"required"}
     */
    public function customer_less_item_to_cart()
    {
        try {
            $customer_id = $this->getCustomerId();
            $data = getRequestData($this->request, 'ARRAY');
            $data['customer_id'] = $customer_id;

            // ✅ Validation
            $validation = \Config\Services::validation();
            $validation->setRules([
                'product_id' => "required",
                'variant_id' => "required",
            ]);

            if (!$validation->run($data)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::VALIDATION_FAILED,
                    "Form Validation Failed",
                    [],
                    $validation->getErrors()
                );
            }

            $cartModel = $this->getCustomerCartModel();

            // Check item in cart
            $cart_data = $cartModel
                ->where("customer_id", $customer_id)
                ->where("product_id", $data["product_id"])
                ->where("variant_id", $data["variant_id"])
                ->first();

            if (!$cart_data) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::NOT_FOUND,
                    "Product Not Found in Cart"
                );
            }

            // 🧮 Before changing, update summary once
            $this->updateCustomerCartSummary($customer_id);

            // Decrease quantity or delete if 0
            $newQuantity = $cart_data['cart_quantity'] - 1;

            if ($newQuantity <= 0) {
                // Delete item
                $cart_delete = $cartModel->RecordDelete($cart_data['customer_cart_id']);
                if ($cart_delete['status'] != ApiResponseStatusCode::OK) {
                    return formatApiAutoResponse($this->request, $this->response, $cart_delete);
                }
            } else {
                // Update new quantity
                $update_data = ['cart_quantity' => $newQuantity];
                $cart_update = $cartModel->RecordUpdate($update_data, $cart_data['customer_cart_id']);
                if ($cart_update['status'] != ApiResponseStatusCode::OK) {
                    return formatApiAutoResponse($this->request, $this->response, $cart_update);
                }
            }

            // 🧮 Update summary after change
            $this->updateCustomerCartSummary($customer_id);

            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                $newQuantity <= 0 ? "Product removed from cart successfully" : "Product quantity decreased successfully",
                ['cart_list' => $this->cart_list_array_data()]
            );
        } catch (Exception $e) {
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::BAD_REQUEST,
                $e->getMessage()
            );
        }
    }

    // Cart Remove Item
    /**
     * {"customer_cart_id":"required"}
     */
    public function customer_remove_item_to_cart()
    {

        try {
            $data = getRequestData($this->request, 'ARRAY');
            $customer_id = $this->getCustomerId();
            $data['customer_id'] = $customer_id;  // Add customer_id to the data array
            $validation = \Config\Services::validation();
            $validation->setRules([
                'customer_cart_id' => "required",
                'customer_id' => "required",
            ]);
            if (!$validation->run($data)) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, "Form Validation Failed", [], $validation->getErrors());
            }
            $customerCartModel = $this->getCustomerCartModel();
            $response = $customerCartModel->RecordDelete($data['customer_cart_id']);
            if ($response['status'] == ApiResponseStatusCode::OK) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, "Product Removed From Cart Successfully",  ['cart_list' => $this->cart_list_array_data()]);
            } else {
                return formatApiAutoResponse($this->request, $this->response, $response);
            }
        } catch (Exception $e) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, $e->getMessage());
        }
    }

    // Cart List
    /**
     * {
     *  "customer_cart_id": "integer",
     *  "product_id": "integer",
     *  "variant_id": "integer",
     *  "size_id": "integer",
     * }
     */

    private function updateCustomerCartSummary($customer_id)
    {
        $cartModel = $this->getCustomerCartModel();
        $summaryModel = $this->getCustomerCartSummaryModel();

        // Total unique products
        $totalProductCount = $cartModel
            ->where('customer_id', $customer_id)
            ->countAllResults();

        // Total quantity sum
        $totalQuantitySumRow = $cartModel
            ->selectSum('cart_quantity')
            ->where('customer_id', $customer_id)
            ->get()
            ->getRow();
        $totalProductQuantitySum = $totalQuantitySumRow->cart_quantity ?? 0;

        // Prepare data
        $summaryData = [
            'total_product_count' => $totalProductCount,
            'total_product_quantity_sum' => $totalProductQuantitySum,
        ];

        // Update or insert
        $existingSummary = $summaryModel->where('customer_id', $customer_id)->first();
        if ($existingSummary) {
            $summaryModel->update($existingSummary['customer_cart_summary_id'], $summaryData);
        } else {
            $summaryData['customer_id'] = $customer_id;
            $summaryModel->insert($summaryData);
        }
    }

    protected function cart_list_array_data($data = [])
    {
        try {
            $filter = [
                "ecommerce" => $data['ecommerce'] ?? true,
                "other_fields" => true,
                "joins" => ["variant", "cart", "color", "size", "stock", "offer", "customer_review"],
                "variant" => [
                    "other_fields" => true,
                ],
                "cart" => [
                    "customer_cart_ids" => $data["customer_cart_ids"] ?? [],
                    "cart_only" => true,
                ],
                "default_variant_only" => false,
                "default_size_only" => true,
                "multivariant" => $data['multivariant'] ?? true,
            ];
            return $this->getProductModel()->product_listing($filter) ?? [];
        } catch (Exception $e) {
            throw $e;
        }
    }
    public function customer_cart_list()
    {
        try {
            $parameters = getRequestData($this->request, 'ARRAY');

            $website_data = $this->header_footer() ?? [];
            $firm_logo = $website_data['website_profile']['firm_logo_url'] ?? '';

            // Get customer cart
            $customer_cart_data = $this->getCustomerCartModel()
                ->where('customer_id', $this->getCustomerId())
                ->findAll();

            $customer_cart_ids = array_column($customer_cart_data, 'customer_cart_id');

            $page_data['cart_list'] = $this->cart_list_array_data([
                'customer_cart_ids' => $customer_cart_ids ?? []
            ]);

            // 🔹 Stock check & admin notification
            if (!empty($page_data['cart_list'])) {

                $FC = new FirebaseController();
                $users = $this->getUserModel()
                    ->select('user_id')
                    ->where('user_type', 'admin')
                    ->findAll();

                foreach ($page_data['cart_list'] as $cart_item) {

                    $stockData = $this->getStockModel()
                        ->where('variant_id', $cart_item['variant_id'])
                        ->first();

                    $available_stock = (int)($stockData['quantity'] ?? 0);
                    $cart_qty = (int)($cart_item['cart_quantity'] ?? 0);

                    if ($available_stock < $cart_qty) {

                        foreach ($users as $user) {
                            $FC->sendNotificationToUser(
                                $user['user_id'],
                                "⚠️ Order Stock Alert!",
                                "Stock is low for SKU: {$cart_item['variant_sku_code']}. Available: {$available_stock}",
                                base_url(route_to('stock_update')),
                                $firm_logo
                            );
                        }
                    }
                }
            }

            // SEO data only when needed
            if (!isset($parameters['only_data']) || $parameters['only_data'] != true) {
                $page_data['seo_data'] = $this->getSeo('cart') ?? [];
            }

            $page_data['header_footer_data'] = $website_data;

            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                'Record Found',
                $page_data
            );
        } catch (\Throwable $e) {

            log_message('error', $e->getMessage());

            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }
    }

    /**
     * Creates or updates a customer review.
     * 
     * @return \CodeIgniter\HTTP\Response
     * 
     * Expected JSON input:
     * {
     *     "product_id": "integer",
     *     "variant_id": "integer",
     *     // Add any other fields required for the review
     * }
     */

    public function customer_review_create_update()
    {
        try {
            // Get request data
            $data = getRequestData($this->request, 'ARRAY');
            $customer_id = $this->getCustomerId();
            $data['customer_id'] = $customer_id;

            // Initialize validation
            $validation = \Config\Services::validation();

            // Validation rules
            $rules = [
                'product_id'  => 'required|integer|is_not_unique[product.product_id]',
                'variant_id'  => 'required|integer|is_not_unique[product_variant.variant_id]',
                'customer_rating' => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5]',
            ];

            $messages = [
                'customer_rating' => [
                    'required' => 'Please add a rating.',
                ]
            ];

            $validation->setRules($rules, $messages);

            if (!$validation->run($data)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::VALIDATION_FAILED,
                    "Form Validation Failed",
                    [],
                    $validation->getErrors()
                );
            }

            // Image upload handling
            $imageFields = [
                'customer_review_image1',
                'customer_review_image2',
                'customer_review_image3',
                'customer_review_image4'
            ];

            $imagePaths = $thumbnailPaths = $imageUrls = $thumbnailUrls = [];

            foreach ($imageFields as $imageField) {
                if (isset($data[$imageField]) && is_array($data[$imageField])) {
                    $file = $data[$imageField];
                    $allowedFileTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/webp', 'image/svg+xml'];

                    if (in_array($file['type'], $allowedFileTypes)) {
                        $folderPath = "uploads/review_image/";
                        $thumbnailPath = $folderPath . 'thumbnail/';

                        if (!is_dir($folderPath)) mkdir($folderPath, 0755, true);
                        if (!is_dir($thumbnailPath)) mkdir($thumbnailPath, 0755, true);

                        $filename = uniqid('img_') . '_' . time() . '.webp';
                        $filePath = $folderPath . $filename;
                        $thumbnailFilePath = $thumbnailPath . $filename;

                        if (file_put_contents($filePath, file_get_contents($file['tmp_name'])) === false) {
                            throw new Exception("Failed to save uploaded file.");
                        }

                        $imagePaths[$imageField] = $filePath;
                        $thumbnailPaths[$imageField] = $thumbnailFilePath;
                        $imageUrls[$imageField] = base_url($filePath);
                        $thumbnailUrls[$imageField] = base_url($thumbnailFilePath);
                    } else {
                        $data[$imageField] = null;
                    }
                } else {
                    $data[$imageField] = null;
                    $imagePaths[$imageField] = null;
                    $thumbnailPaths[$imageField] = null;
                    $imageUrls[$imageField] = null;
                    $thumbnailUrls[$imageField] = null;
                }
            }

            foreach ($imageFields as $imageField) {
                $data[$imageField] = $imagePaths[$imageField] ?? null;
                $data[$imageField . '_thumbnail'] = $thumbnailPaths[$imageField] ?? null;
                $data[$imageField . '_url'] = $imageUrls[$imageField] ?? null;
                $data[$imageField . '_thumbnail_url'] = $thumbnailUrls[$imageField] ?? null;
            }

            // ✅ Create review record
            $crm = $this->getCustomerReviewModel();
            $result = $crm->RecordCreate($data);

            // ✅ Handle Review Summary (update/create)
            $variant_id = $data['variant_id'];
            $customer_rating = (int)$data['customer_rating'];
            $reviewSummaryModel = $this->getReviewSummaryModel();

            // Check if a summary exists for this variant
            $existingSummary = $reviewSummaryModel->where('variant_id', $variant_id)->first();

            if ($existingSummary) {
                // Update existing summary
                $newCount = $existingSummary['review_count_sum'] + 1;
                $newAvg = round(
                    (($existingSummary['review_rating_avg'] * $existingSummary['review_count_sum']) + $customer_rating) / $newCount,
                    2
                );

                $updateData = [
                    'review_count_sum' => $newCount,
                    'review_rating_avg' => $newAvg
                ];

                $reviewSummaryModel->update($existingSummary['review_summary_id'], $updateData);
            } else {
                // Create new summary
                $createData = [
                    'variant_id' => $variant_id,
                    'review_count_sum' => 1,
                    'review_rating_avg' => $customer_rating
                ];

                $reviewSummaryModel->insert($createData);
            }

            // ✅ Return success response
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::CREATED,
                "Review Created and Summary Updated Successfully",
                $result
            );
        } catch (Exception $e) {
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::BAD_REQUEST,
                $e->getMessage()
            );
        }
    }

    /**
     * Updates the customer's date of birth.
     * 
     * @return \CodeIgniter\HTTP\Response
     * 
     * Expected JSON input:
     * {
     *     "dob": "string",  // Date of birth in the required format
     * }
     */
    public function customer_dob_update()
    {
        try {
            $data = getRequestData($this->request, 'ARRAY');
            $data['customer_id'] = $this->getCustomerId();
            $validation = \Config\Services::validation();
            $validation->setRules([
                'customer_id'    => 'required',
                'dob'           => 'required',
                'customer_upi_id' => 'required'
            ]);
            $headerFooterData = $this->header_footer();
            $data['header_footer_data'] = is_array($headerFooterData) ? $headerFooterData : [];
            if ($validation->run($data)) {
                $response = $this->getCustomerModel()->RecordUpdate($data, $data['customer_id']);
                if ($response['status'] == ApiResponseStatusCode::OK) {
                    return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, "Profile Updated Successfully");
                } else {
                    return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, $response['message']);
                }
            } else {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Profile Not Updated', [], $validation->getErrors());
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
    public function customer_profile()
    {
        try {
            // Retrieve customer_id from session
            $customerId = $this->getCustomerId();
            $validation = \Config\Services::validation();
            $validation->setRules([
                'customer_id' => 'required',
            ]);
            if (!$validation->run(['customer_id' => $customerId])) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, "Customer ID is required.");
            }
            $userProfile = $this->getCustomerModel()->find($customerId);
            $page_data = [
                'header_footer_data' => $this->header_footer() ?? [],
                'seo_data' => $this->getSeo('userprofile') ?? [],
                'UserProfile' => $userProfile ?? [],
            ];
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, "Data Fetch Successfully", $page_data);
        } catch (Exception $e) {
            // Return error response in case of exception
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
    protected function FilesValidate($fileObject, string $moduleName): array
    {
        try {
            $keys = array_keys($fileObject);
            $multifile = is_array($fileObject[$keys[0]]);
            // $mmm = $this->getMediaManagementModel();
            // $ModuleProperty = $mmm->getMediaModuleProperty($moduleName);
            $files = ($multifile == true) ? [] : [0 => $fileObject];
            // checking single file or multi files
            if (is_array($fileObject[$keys[0]])) {
                // If multiple files, run the loop
                foreach ($fileObject[$keys[0]] as $index => $value) {
                    $files[$index] = [];

                    // Dynamically assign keys based on the original array keys
                    foreach ($keys as $key) {
                        $files[$index][$key] = $fileObject[$key][$index];
                    }
                }
            }
            // Validating each file and returning errors if any.
            $errors = [];
            // ($ModuleProperty['maxUploadLimit'] > 0 && count($files) > $ModuleProperty['maxUploadLimit']) ? $errors['maxUploadCount'] = "Max File Upload Count " . $ModuleProperty['maxUploadLimit'] : '';
            // foreach ($files as $key => $file) {
            //     ($this->FileTypeValidate($file, $ModuleProperty['fileTypeAllowed'])) ? '' : $errors['fileType'][] = "(" . $file['name'] . ") Invalid File Type. Allowed Only [" . implode(', ', $ModuleProperty["fileTypeAllowed"]) . "]";
            //     ($this->FileSizeValidate($file, $ModuleProperty['maxFileSizeKb'])) ? '' : $errors['fileSize'][] = "(" . $file['name'] . ") Invalid File Size(" . ($file['size'] / 1024) . "KB). Allowed Maximum Size Only :" . $ModuleProperty['maxFileSizeKb'] . "KB";
            // }
            if (!empty($errors)) {
                return ['status' => false, 'errors' => $errors];
            }
            return ['status' => true, 'files' => $files];
        } catch (Exception $e) {
            throw $e;
        }
    }
    protected function FileTypeValidate($fileObject, $allowedFileTypeArray): bool
    {
        try {
            $fileType = $fileObject['type'];
            // Check if the file type is in the allowed file types array
            return in_array($fileType, $allowedFileTypeArray);
        } catch (Exception $e) {
            throw $e;
        }
    }
    protected function FileSizeValidate($fileObject, $maximumFileSizeInKB): bool
    {
        try {
            $fileSize = $fileObject['size'];
            // Check if the file size is within the allowed limit
            return $fileSize <= $maximumFileSizeInKB * 1024;
        } catch (Exception $e) {
            throw $e;
        }
    }
    public function ImageUpload()
    {
        try {
            $requestedData = getRequestData($this->request, 'ARRAY');
            // Load validation service
            $validation = \Config\Services::validation();

            // Define validation rules for 'username', 'password', 'confirm_password', 'otp'
            $validation->setRules([
                'file' => "required",
                'for' => "in_list[review_image]",
            ]);
            if ($validation->run($requestedData) === false) {
                // Return validation failed response
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Validation Failed', [], $validation->getErrors());
            }
            if (!$this->FileSizeValidate($requestedData['file'], 500)) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'File Size Max 500kb Allowed', []);
            }
            $FileTypeArray = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/webp', 'image/svg+xml'];
            if (!$this->FileTypeValidate($requestedData['file'], $FileTypeArray)) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Invalid File Type Only Image Allowed', []);
            }
            $folderPath = "";
            switch ($requestedData['for']) {

                case 'review_image':
                    $folderPath .= "uploads/review_image/";
                    break;
            }
            $errorMessage = "";
            $uploadResult = uploadImageWithThumbnail($requestedData['file'], $folderPath, $errorMessage);
            if ($uploadResult == false) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, $errorMessage, []);
            }
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, "Image Upload Successfully", $uploadResult);
        } catch (Exception $e) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, $e->getMessage());
        }
    }
    public function deleteImage()
    {
        try {
            $requestedData = getRequestData($this->request, 'ARRAY');

            // Load validation service
            $validation = \Config\Services::validation();

            // Define validation rules for 'image_file_path'
            $validation->setRules([
                "image_file_path" => "required"
            ]);

            if ($validation->run($requestedData) === false) {
                // Return validation failed response
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Validation Failed', [], $validation->getErrors());
            }

            $imagePath = realpath(ROOTPATH . "/public/" . $requestedData['image_file_path']);
            $thumbnailPath = realpath(ROOTPATH . "/public/" . getThumbnailImagePath($requestedData['image_file_path']));

            // Log the paths for debugging
            // log_message('debug', 'Image path: ' . $imagePath);
            // log_message('debug', 'Thumbnail path: ' . $thumbnailPath);

            if ($imagePath && file_exists($imagePath)) {
                if (unlink($imagePath)) {
                    if ($thumbnailPath && file_exists($thumbnailPath)) {
                        unlink($thumbnailPath);
                    }
                    return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, "Image Deleted successfully");
                } else {
                    // Log an error if the file could not be deleted
                    // log_message('error', 'Failed to delete image: ' . $imagePath);
                    return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, "Failed to delete image");
                }
            } else {
                // Log an error if the file path is invalid or the file does not exist
                // log_message('error', 'Image file not found or invalid path: ' . $imagePath);
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::NOT_FOUND, "Image file not found");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
    /**
     * {"search":"string"}
     */
    public function string_search_product_array_data()
    {
        $data = getRequestData($this->request, 'ARRAY');
        // Load validation service
        $validation = \Config\Services::validation();

        // Define validation rules for 'image_file_path'
        $validation->setRules([
            "search" => "required"
        ]);

        if ($validation->run($data) === false) {
            // Return validation failed response
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Validation Failed', [], $validation->getErrors());
        }

        try {

            $filter = [
                "ecommerce" => true,
                "other_fields" => true,
                "joins" => ["category_type", "category", "variant", "color", "size"],
                'limit' => [
                    'count' => 10,
                    'start_from' => isset($data['ls']) ? (int) $data['ls'] : 0 // Convert to integer
                ],
                "search" => $data['search'],
                "default_variant_only" => false,
            ];
            $search_list = $this->getProductModel()->product_listing($filter) ?? [];
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, "Product Searched Successfully", $search_list);
        } catch (Exception $e) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, $e->getMessage());
        }
    }

    public function customer_contact_us()
    {
        try {
            $data = getRequestData($this->request, 'ARRAY');
            // Initialize validation
            $validation = \Config\Services::validation();

            $rules = [
                "fullname" => [
                    "rules" => "required|max_length[255]|regex_match[/^[A-Za-z\s]+$/]",
                    "errors" => [
                        "regex_match" => "Fullname cannot contain numbers or special characters."
                    ]
                ],
                'email' => 'permit_empty|valid_email',
                'mobile' => 'required|numeric|min_length[10]|max_length[15]',
            ];

            $validation->setRules($rules);

            // Validate data
            if (!$validation->run($data)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::VALIDATION_FAILED,
                    "Form Validation Failed",
                    [],
                    $validation->getErrors()
                );
            }
            $ccm = $this->getContactUsModel();
            $result = $ccm->RecordCreate($data);
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::CREATED, "Contact Us Successfully", $result);
        } catch (Exception $e) {
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::BAD_REQUEST,
                $e->getMessage()
            );
        }
    }


    public function customer_order_list()
    {
        try {
            // Retrieve request data in array format
            $data = getRequestData($this->request, 'ARRAY');

            // Add customer ID to request data
            $data['customer_id'] = $this->getCustomerId();

            // Initialize validation
            $validation = \Config\Services::validation();
            $validation->setRules([
                "customer_id" => "required|integer"  // Validate that customer_id is required and must be an integer
            ]);

            // Validate input data
            if (!$validation->run($data)) {
                // Return validation error response
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::VALIDATION_FAILED,
                    "Form Validation Failed",
                    [],
                    $validation->getErrors()
                );
            }

            // Fetch orders for the customer based on customer_id
            $OrderModel = $this->getOrderModel();
            $filter = [
                '_autojoin' => 'Y',
                '_select' => '*',
                'order-customer_id' => $data['customer_id'],
            ];
            $OrderList = $OrderModel->GetAllOrdersWithItems($filter);
            // Prepare response data
            $response_data = [
                'header_footer_data' => $this->header_footer() ?? [],
                'seo_data' => $this->getSeo('OrderList') ?? [],
                'OrderList' => $OrderList,
            ];

            // Return the successful response with order data
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                "Data fetched successfully",
                $response_data
            );
        } catch (\Throwable $e) {
            // Handle any exceptions and return an error response
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }
    }

    public function customer_order_view()
    {
        try {
            // Retrieve request data in array format
            $data = getRequestData($this->request, 'ARRAY');

            // Initialize validation
            $validation = \Config\Services::validation();
            $validation->setRules([
                "order_id" => "required|integer"
            ]);

            // Validate input data
            if (!$validation->run($data)) {
                // Return validation error response
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::VALIDATION_FAILED,
                    "Form Validation Failed",
                    [],
                    $validation->getErrors()
                );
            }

            // Fetch order details based on order_id
            $OrderModel = $this->getOrderModel();
            $order_deatil = $this->getOrderModel()->where('order_id', $data['order_id'])->first();
            $order_shipping_track =
                $this->CustomerOrderTrackingShipping(
                    $order_deatil['order_number'],
                    $order_deatil['delhivery_waybill']
                ) ?: [];

            $filter = [
                '_autojoin' => 'Y',
                '_select' => '*',
                'order_id' => $data['order_id']
            ];

            $order = $OrderModel->GetAllOrdersWithItems($filter, true, [
                'order_payment_fail',
                'order_accepted',
                'order_ready_to_ship',
                'order_shipped',
                'order_exchange_shipped',
                'order_delivered',
                'order_not_delivered',
                'order_exchanged',
                'refund_request',
                'return_request',
                'exchange_request',
                'request_return_rejected',
                'request_exchange_rejected',
                'request_refund_approved',
                'request_return_approved',
                'request_exchange_approved',
                'refund_to_customer',
                'order_payment_verified_razorpay'
            ]);

            // Check if order data exists
            if (empty($order)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::NOT_FOUND,
                    "Order not found"
                );
            }
            // Define status flows
            $statusFlows = [
                'standard' => [
                    'order_payment_verified_razorpay' => ['label' => 'Order Pending'],
                    'order_accepted' => ['label' => 'Order Placed'],
                    'order_ready_to_ship' => ['label' => 'In Progress'],
                    'order_shipped' => ['label' => 'Shipped'],
                    'order_delivered' => ['label' => 'Delivered'],
                ],
                'refund' => [
                    'order_accepted' => ['label' => 'Order Placed'],
                    'refund_request' => ['label' => 'Cancelled Requested'],
                    'request_refund_approved' => ['label' => 'Cancelled Approved'],
                ],
                'return' => [
                    'order_accepted' => ['label' => 'Order Placed'],
                    'order_ready_to_ship' => ['label' => 'In Progress'],
                    'order_shipped' => ['label' => 'Shipped'],
                    'order_delivered' => ['label' => 'Delivered'],
                    'return_request' => ['label' => 'Request for Return'],
                    'request_return_approved' => ['label' => 'Return Approved'],
                    'refund_to_customer' => ['label' => 'Refunded'],
                ],
                'exchanged' => [
                    'order_accepted' => ['label' => 'Order Placed'],
                    'order_ready_to_ship' => ['label' => 'In Progress'],
                    'order_shipped' => ['label' => 'Shipped'],
                    'order_delivered' => ['label' => 'Delivered'],
                    'exchange_request' => ['label' => 'Request Exchange'],
                    'request_exchange_approved' => ['label' => 'Exchange Approved'],
                    'order_exchange_shipped' => ['label' => 'Exchanged Shipped'],
                    'order_exchanged' => ['label' => 'Order Exchanged'],
                ],
            ];

            // Determine the current order status
            $currentStatus = $order[0]['order_status']; // Assuming 'order_status' is a field in the order data

            // Choose which flow to display based on the current order status
            if (in_array($currentStatus, ['return_request', 'request_return_approved', 'refund_to_customer'])) {
                $statuses = $statusFlows['return'];
            } elseif (in_array($currentStatus, ['refund_request', 'request_refund_approved'])) {
                $statuses = $statusFlows['refund'];
            } elseif (in_array($currentStatus, ['exchange_request', 'request_exchange_approved', 'order_exchange_shipped', 'order_exchanged'])) {
                $statuses = $statusFlows['exchanged'];
            } else {
                $statuses = $statusFlows['standard'];
            }

            // Map logs to statuses for date assignment
            foreach ($order[0]['logs'] as $log) {
                $logDate = new DateTime($log['created_at']);
                if (isset($statuses[$log['order_status']])) {
                    $statuses[$log['order_status']]['date'] = $logDate->format('D, j M Y'); // e.g., 'Tue, June 24'
                }
            }

            // Convert the associative statuses to an indexed array
            $indexedStatuses = [];
            foreach ($statuses as $statusKey => $statusData) {
                $indexedStatuses[] = [
                    'status' => $statusKey,
                    'label' => $statusData['label'],
                    'date' => $statusData['date'] ?? 'Pending'
                ];
            }

            // Prepare response data
            $response_data = [
                'header_footer_data' => $this->header_footer() ?? [],
                'seo_data' => $this->getSeo('OrderDetail') ?? [],
                'orderDetails' => $order,
                'shipping_tracking_data' => $order_shipping_track,
                'statuses' => $indexedStatuses, // Indexed array of statuses
            ];

            // Return the successful response with order data
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                "Order details fetched successfully",
                $response_data
            );
        } catch (\Throwable $e) {
            // Handle any exceptions and return an error response
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }
    }

    public function customer_order_cancel()
    {
        try {
            // Retrieve request data in array format
            $data = getRequestData($this->request, 'ARRAY');
            $website_data = $this->header_footer() ?? [];
            $firm_logo = $website_data['website_profile']['firm_logo_url'] ?? '';
            $FC = new FirebaseController();
            $users = $this->getUserModel()->select('user_id')->where('user_type', 'admin')->findAll();
            // Initialize validation for required order_id
            $validation = \Config\Services::validation();
            $validation->setRules([
                "order_id" => "required|integer"
            ]);

            // Validate the input data
            if (!$validation->run($data)) {
                // Return validation error response
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::VALIDATION_FAILED,
                    "Form Validation Failed",
                    [],
                    $validation->getErrors()
                );
            }

            // Fetch the order details based on order_id
            $OrderModel = $this->getOrderModel();
            $order = $OrderModel->find($data['order_id']);

            // Check if the order exists
            if (empty($order)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::NOT_FOUND,
                    "Order not found"
                );
            }

            // Check if the current status allows cancellation
            if (in_array($order['order_status'], ['order_delivered', 'order_shipped'])) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::FORBIDDEN,
                    "Order cannot be canceled at this stage"
                );
            }

            // Prepare order log data
            $logData = [
                'order_id' => $data['order_id'],
                'order_status' => 'refund_request',
                'order_status_alias' => 'refund_request',
                'message' => 'Order cancellation requested by user'
            ];

            // Update the order status to 'refund_request'
            $updateData = [
                'order_status' => 'refund_request'
            ];

            // Update order status and log the change
            $OrderModel->RecordUpdate($updateData, $data['order_id']);
            $order_log_response = $this->getOrderLogModel()->RecordCreate($logData);

            // Handle order log creation failure
            if ($order_log_response['status'] != ApiResponseStatusCode::CREATED) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::INTERNAL_SERVER_ERROR,
                    "Unable to create order log"
                );
            }

            // 🔔 CUSTOMER NOTIFICATION
            $FC->sendNotificationToCustomer(
                $order['customer_id'],
                "❌ Order Cancellation Requested",
                "Your request to cancel Order #{$order['order_id']} has been received. Refund will be processed after verification.",
                $_ENV['EcommerceWebsiteDomainUrl'] . "/orderhistory",
                $_ENV['app.baseURL'] . $firm_logo
            );

            // 🔔 ADMIN NOTIFICATION
            foreach ($users as $user) {
                $FC->sendNotificationToUser(
                    $user['user_id'],
                    "🚨 Refund Request Received",
                    "Customer #{$order['customer_id']} has requested a refund for Order #{$order['order_id']}.",
                    base_url(route_to('cancel_order')),
                    $firm_logo
                );
            }

            // Return a success response
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                "Order canceled successfully and refund requested"
            );
        } catch (\Throwable $e) {
            // Handle any exceptions and return an error response
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }
    }

    public function customer_order_return()
    {
        try {
            // Fetch request data
            $data = getRequestData($this->request, 'ARRAY');
            $website_data = $this->header_footer() ?? [];
            $firm_logo = $website_data['website_profile']['firm_logo_url'] ?? '';
            // Validate incoming data
            $validation = \Config\Services::validation();
            $validation->setRules([
                "order_id" => "required|integer",
                "order_remark" => "required|string|max_length[255]",
                "return_exchange_image1" => "required",
            ]);

            if (!$validation->run($data)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::VALIDATION_FAILED,
                    "Form validation failed",
                    [],
                    $validation->getErrors()
                );
            }
            if ($data['return_exchange_image1']['name'] == '') {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::VALIDATION_FAILED,
                    "Please upload at least one image for return/exchange"

                );
            }
            if ($data['is_return_shipping_charge_agree'] !== 'on') {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::VALIDATION_FAILED,
                    "Please select checkbox for return shipping charge"

                );
            }


            // Validate return data
            if (!isset($data['return_data']) || empty($data['return_data']) || array_sum(array_column($data['return_data'], 'return_qty')) < 1) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::BAD_REQUEST,
                    "Please add item quantity for return"
                );
            }

            $OrderModel = $this->getOrderModel();
            $order = $OrderModel->find($data['order_id']);

            // Check if the order exists
            if (empty($order)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::NOT_FOUND,
                    "Order not found"
                );
            }
            // Image upload handling
            $imageFields = [
                'return_exchange_image1',
                'return_exchange_image2',
                'return_exchange_image3',
                'return_exchange_image4'
            ];

            $imagePaths = $thumbnailPaths = $imageUrls = $thumbnailUrls = [];

            foreach ($imageFields as $imageField) {
                if (isset($data[$imageField]) && is_array($data[$imageField])) {
                    $file = $data[$imageField];
                    $allowedFileTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/webp', 'image/svg+xml'];

                    if (in_array($file['type'], $allowedFileTypes)) {
                        $folderPath = "uploads/return_exchange_image/";
                        $thumbnailPath = $folderPath . 'thumbnail/';

                        if (!is_dir($folderPath)) mkdir($folderPath, 0755, true);
                        if (!is_dir($thumbnailPath)) mkdir($thumbnailPath, 0755, true);

                        $filename = uniqid('img_') . '_' . time() . '.webp';
                        $filePath = $folderPath . $filename;
                        $thumbnailFilePath = $thumbnailPath . $filename;

                        if (file_put_contents($filePath, file_get_contents($file['tmp_name'])) === false) {
                            throw new Exception("Failed to save uploaded file.");
                        }

                        $imagePaths[$imageField] = $filePath;
                        $thumbnailPaths[$imageField] = $thumbnailFilePath;
                        $imageUrls[$imageField] = base_url($filePath);
                        $thumbnailUrls[$imageField] = base_url($thumbnailFilePath);
                    } else {
                        $data[$imageField] = null;
                    }
                } else {
                    $data[$imageField] = null;
                    $imagePaths[$imageField] = null;
                    $thumbnailPaths[$imageField] = null;
                    $imageUrls[$imageField] = null;
                    $thumbnailUrls[$imageField] = null;
                }
            }

            foreach ($imageFields as $imageField) {
                $data[$imageField] = $imagePaths[$imageField] ?? null;
                $data[$imageField . '_thumbnail'] = $thumbnailPaths[$imageField] ?? null;
                $data[$imageField . '_url'] = $imageUrls[$imageField] ?? null;
                $data[$imageField . '_thumbnail_url'] = $thumbnailUrls[$imageField] ?? null;
            }
            $OrderItemModel = $this->getOrderItemModel();
            $order_item_ids = array_column($data['return_data'], 'order_item_id');

            // Fetch and update order items
            foreach ($data['return_data'] as $key => &$order_item) {
                $order_item_data = $OrderItemModel->find($order_item['order_item_id']);

                if (empty($order_item_data)) {
                    return formatApiResponse(
                        $this->request,
                        $this->response,
                        ApiResponseStatusCode::NOT_FOUND,
                        "Order item not found for ID: " . $order_item['order_item_id']
                    );
                }
                // Refund calculation
                $each_rate = $order_item_data['item_total_amount'] / $order_item_data['order_qty'];
                $order_item['refund_amount'] = $order_item['return_qty'] * $each_rate;

                // ✅ FIX: attach uploaded image paths to this order item record
                foreach (['return_exchange_image1', 'return_exchange_image2', 'return_exchange_image3', 'return_exchange_image4'] as $imgField) {
                    $order_item[$imgField] = $imagePaths[$imgField] ?? null;
                }
            }

            // ✅ Now updateBatch will include image fields also
            $OrderItemModel->updateBatch($data['return_data'], 'order_item_id');

            // Calculate total refund amount
            $order_total_refund_amount = array_sum(array_column($data['return_data'], 'refund_amount'));

            // Update order with return details
            $updateData = [
                'total_refund_amount' => $order_total_refund_amount,
                'order_remark' => $data['order_remark'],
                'order_status' => 'return_request',
                'is_return_shipping_charge_agree' => 1
            ];

            $result = $OrderModel->update($data['order_id'], $updateData);

            if (!$result) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::INTERNAL_SERVER_ERROR,
                    "Failed to update order"
                );
            }

            // Log the return request
            $logData = [
                'order_id' => $data['order_id'],
                'order_status' => 'return_request',
                'log_remark' => 'Return request initiated by customer. Reason: ' . $data['order_remark'],
            ];
            $this->getOrderLogModel()->insert($logData);


            // 🔔 INIT FIREBASE
            $FC = new FirebaseController();

            // 🔔 ADMIN USERS
            $users = $this->getUserModel()
                ->select('user_id')
                ->where('user_type', 'admin')
                ->findAll();

            /* -------------------------
                 CUSTOMER NOTIFICATION
               --------------------------*/
            $FC->sendNotificationToCustomer(
                $order['customer_id'],
                "🔄 Return Request Submitted",
                "Your return request for Order #{$data['order_id']} has been submitted. Our team will review it shortly.",
                $_ENV['EcommerceWebsiteDomainUrl'] . "/orderhistory",
                $_ENV['app.baseURL'] . $firm_logo
            );

            /* -------------------------
                 ADMIN NOTIFICATION
             --------------------------*/
            foreach ($users as $user) {
                $FC->sendNotificationToUser(
                    $user['user_id'],
                    "📦 Return Request Received",
                    "Customer #{$order['customer_id']} requested return for Order #{$data['order_id']}.",
                    base_url(route_to('return_request_pending')),
                    $firm_logo
                );
            }

            // Return success response
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                "Order return request processed successfully"
            );
        } catch (\Exception $e) {
            // Handle internal server error
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }
    }

    public function customer_order_exchange()
    {
        try {
            $data = getRequestData($this->request, 'ARRAY');
            $website_data = $this->header_footer() ?? [];
            $firm_logo = $website_data['website_profile']['firm_logo_url'] ?? '';
            $order_item_id = $data['exchange_data'][0]['order_item_id'];
            // Validation
            $validation = \Config\Services::validation();
            $validation->setRules([
                "order_id" => "required|integer",
                "order_remark" => "required|string|max_length[255]",
                "return_exchange_image1" => "required"
            ]);

            if (!$validation->run($data)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::VALIDATION_FAILED,
                    "Form validation failed",
                    [],
                    $validation->getErrors()
                );
            }
            if ($data['return_exchange_image1']['name'] == '') {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::VALIDATION_FAILED,
                    "Please upload at least one image for return/exchange"

                );
            }
            // Exchange data check
            if (
                !isset($data['exchange_data']) ||
                empty($data['exchange_data']) ||
                array_sum(array_column($data['exchange_data'], 'exchange_qty')) < 1
            ) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::BAD_REQUEST,
                    "Please add item quantity for exchange"
                );
            }
            // check product is available in stock
            $orderItemData = $this->getOrderItemModel()
                ->where('order_item_id', $order_item_id)
                ->first();

            if (empty($orderItemData)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::NOT_FOUND,
                    "Order item not found."
                );
            }

            if (!empty($orderItemData['variant_id'])) {

                $stockData = $this->getStockModel()
                    ->where('variant_id', $orderItemData['variant_id'])
                    ->first();

                // Stock record hi nahi mila
                if (empty($stockData) || !isset($stockData['quantity'])) {
                    return formatApiResponse(
                        $this->request,
                        $this->response,
                        ApiResponseStatusCode::BAD_REQUEST,
                        "Product is currently out of stock. You may return it or wait for availability."
                    );
                }

                $stockQty    = (int) $stockData['quantity'];
                $exchangeQty = (int) ($data['exchange_data'][0]['exchange_qty'] ?? 0);

                // Exchange qty invalid
                if ($exchangeQty <= 0) {
                    return formatApiResponse(
                        $this->request,
                        $this->response,
                        ApiResponseStatusCode::BAD_REQUEST,
                        "Invalid exchange quantity."
                    );
                }

                // Stock kam hai
                if ($stockQty < $exchangeQty) {
                    return formatApiResponse(
                        $this->request,
                        $this->response,
                        ApiResponseStatusCode::BAD_REQUEST,
                        "Product is out of stock. You may return it or wait for availability."
                    );
                }
            }

            $OrderModel = $this->getOrderModel();
            $order = $OrderModel->find($data['order_id']);

            if (empty($order)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::NOT_FOUND,
                    "Order not found"
                );
            }

            // ✅ Same working image upload logic from RETURN API
            $imageFields = [
                'return_exchange_image1',
                'return_exchange_image2',
                'return_exchange_image3',
                'return_exchange_image4'
            ];

            $imagePaths = [];

            foreach ($imageFields as $imageField) {
                if (isset($data[$imageField]) && is_array($data[$imageField])) {
                    $file = $data[$imageField];
                    $allowedFileTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/bmp'];

                    if (in_array($file['type'], $allowedFileTypes)) {
                        $folderPath = "uploads/return_exchange_image/";
                        if (!is_dir($folderPath)) mkdir($folderPath, 0755, true);

                        $filename = uniqid('img_') . '_' . time() . '.webp';
                        $filePath = $folderPath . $filename;

                        if (file_put_contents($filePath, file_get_contents($file['tmp_name'])) === false) {
                            throw new \Exception("Failed to save uploaded file.");
                        }

                        $imagePaths[$imageField] = $filePath;
                    } else {
                        $imagePaths[$imageField] = null;
                    }
                } else {
                    $imagePaths[$imageField] = null;
                }
            }

            // ✅ Attach image paths to each exchange item
            $OrderItemModel = $this->getOrderItemModel();

            foreach ($data['exchange_data'] as &$order_item) {
                foreach ($imageFields as $imgField) {
                    $order_item[$imgField] = $imagePaths[$imgField] ?? null;
                }
            }

            // ✅ Save in order_item table
            $OrderItemModel->updateBatch($data['exchange_data'], 'order_item_id');

            // ✅ Update order
            $updateData = [
                'order_remark' => $data['order_remark'],
                'order_status' => 'exchange_request'
            ];
            $OrderModel->update($data['order_id'], $updateData);

            // ✅ Log
            $logData = [
                'order_id' => $data['order_id'],
                'order_status' => 'exchange_request',
                'log_remark' => 'Exchange request initiated by customer. Reason: ' . $data['order_remark'],
            ];
            $this->getOrderLogModel()->insert($logData);

            // 🔔 INIT FIREBASE
            $FC = new FirebaseController();

            // 🔔 ADMIN USERS
            $users = $this->getUserModel()
                ->select('user_id')
                ->where('user_type', 'admin')
                ->findAll();

            /* -------------------------
                 CUSTOMER NOTIFICATION
               --------------------------*/
            $FC->sendNotificationToCustomer(
                $order['customer_id'],
                "🔄 Exchange Request Submitted",
                "Your return request for Order #{$data['order_id']} has been submitted. Our team will review it shortly.",
                $_ENV['EcommerceWebsiteDomainUrl'] . "/orderhistory",
                $_ENV['app.baseURL'] . $firm_logo
            );

            /* -------------------------
                 ADMIN NOTIFICATION
             --------------------------*/
            foreach ($users as $user) {
                $FC->sendNotificationToUser(
                    $user['user_id'],
                    "📦 Exchange Request Received",
                    "Customer #{$order['customer_id']} requested exchange for Order #{$data['order_id']}.",
                    base_url(route_to('exchange_request_pending')),
                    $firm_logo
                );
            }

            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                "Order Exchange request processed successfully"
            );
        } catch (\Exception $e) {
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }
    }

    public function customer_order_invoice()
    {
        try {
            // Determine the request method
            if ($this->request->getMethod() === 'get') {
                // Retrieve order_id from query parameters for GET request
                $order_id = $this->request->getVar('order_id');
            } else {
                // For POST request, retrieve data as you were doing
                $data = getRequestData($this->request, 'ARRAY');
                $validation = \Config\Services::validation();
                $validation->setRules([
                    "order_id" => "required|integer"
                ]);

                if (!$validation->run($data)) {
                    return formatApiResponse(
                        $this->request,
                        $this->response,
                        ApiResponseStatusCode::VALIDATION_FAILED,
                        "Form Validation Failed",
                        [],
                        $validation->getErrors()
                    );
                }

                $order_id = $data['order_id'];
            }

            // The rest of your existing logic remains the same...
            // Define the path to the public/invoice folder
            $invoiceFolder = FCPATH . 'invoice/';
            $invoicePath = $invoiceFolder . 'invoice_' . $order_id . '.pdf';

            if (!file_exists($invoicePath)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::NOT_FOUND,
                    "Invoice not found for this order."
                );
            }

            $invoiceUrl = base_url('invoice/invoice_' . $order_id . '.pdf');

            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                "Invoice download successfully.",
                ['invoice_url' => $invoiceUrl]
            );
        } catch (\Throwable $e) {
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }
    }

    public function Notification_list()
    {
        try {
            // Retrieve customer_id from session
            $customerId = $this->getCustomerId();

            // Validation for customer_id
            $validation = \Config\Services::validation();
            $validation->setRules([
                'customer_id' => 'required',
            ]);

            // Validate customer_id
            if (!$validation->run(['customer_id' => $customerId])) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, "Customer ID is required.");
            }

            // Fetch notifications for the customer
            $notificationsList = $this->getFirebaseMessagingNotificationModel()
                ->where('access_type', 'customer')
                ->where('access_id', $customerId)
                ->findAll() ?? [];

            // Check if notifications match the customer_id and access_id
            if (empty($notificationsList)) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::NOT_FOUND, "No notifications found for the specified customer ID.");
            }

            // Get total count of notifications
            $totalCount = count($notificationsList);

            // Prepare response data
            $page_data = [
                'header_footer_data' => $this->header_footer() ?? [],
                'notificationsList' => $notificationsList,
                'totalCount' => $totalCount, // Include total count in response
            ];

            // Return success response
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, "Data fetched successfully", $page_data);
        } catch (Exception $e) {
            // Return error response in case of exception
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function DeleteNotification()
    {
        try {
            $data = getRequestData($this->request, 'ARRAY');
            $customerId = $this->getCustomerId(); // Use camelCase for consistency
            $data['customer_id'] = $customerId; // Add customer_id to the data array

            // Validate input data
            $validation = \Config\Services::validation();
            $validation->setRules([
                'customer_id' => 'required',
                'firebase_messaging_notification_id' => 'required' // Ensure this field is validated as well
            ]);

            if (!$validation->run($data)) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Form Validation Failed', [], $validation->getErrors());
            }

            // Fetch the notification
            $notificationId = $data['firebase_messaging_notification_id']; // Ensure notification ID is taken from the request data
            $notificationModel = $this->getFirebaseMessagingNotificationModel();
            $notification = $notificationModel
                ->where('firebase_messaging_notification_id', $notificationId)
                ->where('access_type', 'customer')
                ->where('access_id', $customerId)
                ->first();

            // Check if notification exists
            if (!$notification) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::NOT_FOUND, 'Notification not found');
            }

            // Delete the notification record using the model
            $deleteResponse = $notificationModel->delete($notificationId);

            if ($deleteResponse) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, 'Notification removed successfully');
            } else {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, 'Failed to delete notification');
            }
        } catch (Exception $e) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, $e->getMessage());
        }
    }
    public function apiCall(
        string $url,
        string $method = "POST",
        array|null $data = null,
        array $header = [],
        $successCallbackFunction = null,
        $errorCallbackFunction = null
    ): array {

        log_message('error', $url . ' Start: ' . date('Y-m-d H:i:s'));

        $ch = curl_init();

        $method = strtoupper($method);

        // ✅ Handle GET query params
        if ($method === 'GET' && !empty($data)) {
            $queryString = http_build_query($data);
            $url .= (str_contains($url, '?') ? '&' : '?') . $queryString;
        }

        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => $method,
            CURLOPT_HTTPHEADER     => $this->formatHeaders($header),
            CURLOPT_TIMEOUT        => 30,
        ]);

        // ✅ Handle POST / PUT / PATCH body
        if (in_array($method, ['POST', 'PUT', 'PATCH']) && !empty($data)) {
            if (
                isset($header['Content-Type']) &&
                $header['Content-Type'] === 'application/json'
            ) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }
        }

        $response = curl_exec($ch);

        // ❌ CURL ERROR
        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);

            log_message('error', $url . ' CURL Error: ' . $error);

            if (is_callable($errorCallbackFunction)) {
                call_user_func($errorCallbackFunction, $error);
            }

            return [
                'status'  => 500,
                'message' => 'cURL Error',
                'data'    => null,
                'errors'  => $error,
            ];
        }

        curl_close($ch);

        $decodedResponse = json_decode($response, true);

        // ✅ Only check JSON validity
        if (!is_array($decodedResponse)) {
            return [
                'status'  => 500,
                'message' => 'Invalid JSON response',
                'data'    => null,
                'errors'  => $response,
            ];
        }

        // ✅ Empty array check (optional)
        if (empty($decodedResponse)) {
            return [
                'status'  => 404,
                'message' => 'Empty API response',
                'data'    => null,
                'errors'  => null,
            ];
        }


        // ✅ Optional decode
        if (isset($data['_encode']) && $data['_encode']) {
            $this->decode_response($decodedResponse);
        }

        // ✅ Normalize status
        if (isset($decodedResponse['status']) && is_int($decodedResponse['status'])) {
            $decodedResponse['status'] =
                ApiResponseStatusCode::tryFrom($decodedResponse['status'])
                ?? ApiResponseStatusCode::INTERNAL_SERVER_ERROR;
        }


        log_message('error', $url . ' Success End: ' . date('Y-m-d H:i:s'));

        // ✅ Success Callback
        if (is_callable($successCallbackFunction)) {
            call_user_func($successCallbackFunction, $decodedResponse);
        }

        return $decodedResponse;
    }
    private function formatHeaders(array $headers): array
    {
        $formatted_headers = [];
        foreach ($headers as $key => $value) {
            $formatted_headers[] = "$key: $value";
        }
        return $formatted_headers;
    }

    public function decode_response(&$response)
    {
        $data = &$response['data'];
        try {
            if (!empty($data)) {
                $data = base64_decode($data);
                $data = gzdecode($data);
                $data = json_decode($data, true);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function subscriberCreate()
    {
        try {
            $data = getRequestData($this->request, 'ARRAY');

            $validation = \Config\Services::validation();
            $validation->setRules([
                'email'        => 'required|valid_email|max_length[255]',
                'is_subscribe' => 'required|in_list[0,1]',
            ]);

            if (!$validation->run($data)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::VALIDATION_FAILED,
                    "Form Validation Failed",
                    [],
                    $validation->getErrors()
                );
            }

            $subscriberModel = $this->getSubscribersListModel();

            // 🔍 Check if email already exists
            $existing = $subscriberModel->where('email', $data['email'])->first();

            if ($existing) {
                // Email already exists → BAD_REQUEST
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::BAD_REQUEST,
                    "Already Subscribed",
                    []
                );
            }

            // ✅ Create new subscription
            $response = $subscriberModel->RecordCreate($data);

            if ($response) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::OK,
                    "Subscribe Success",
                    $response
                );
            }

            // Agar insert fail ho jaye
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::BAD_REQUEST,
                "Failed to Subscribe",
                []
            );
        } catch (\Exception $e) {
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::BAD_REQUEST,
                $e->getMessage()
            );
        }
    }
    protected function all_offer_array_data($customer_id = null)
    {
        $data = getRequestData($this->request, 'ARRAY');
        $customer_id = $data['customer_id'] ?? $this->getCustomerId();

        $offerRecords = $this->getOfferModel()
            ->select("
            offer.offer_id,
            offer.offer_name,
            offer.offer_title,
            offer.offer_image,
            offer.offer_alt_text,
            offer.offer_type,
            offer.offer_seo_title,
            offer.offer_seo_keyword,
            offer.offer_seo_description,
            offer.offer_from,
            offer.offer_to,
            offer.offer_discount,
            offer.is_active,
            offer.created_at,
            offer.updated_at
        ")
            ->where('offer.is_active', 1)
            ->where('offer.offer_to >=', date('Y-m-d'))
            ->orderBy('offer.created_at', 'DESC')
            ->findAll() ?? [];

        $offerItemModel = $this->getOfferItemModel();
        $productModel   = $this->getProductModel();

        $finalOfferList = [];

        foreach ($offerRecords as $offer) {
            $offer_id = $offer['offer_id'];

            // Step 2: Get all product IDs linked with this offer
            $offerItems = $offerItemModel
                ->select('product_id')
                ->where('offer_id', $offer_id)
                ->findAll();

            $productIds = array_column($offerItems, 'product_id');
            $variantWiseProducts = [];

            if (!empty($productIds)) {
                // Step 3: Prepare product listing filter
                $filter = [
                    'ecommerce' => true,
                    'joins' => [
                        'variant',
                        'category',
                        'brand',
                        'color',
                        'size',
                        'offer',
                        'customer_review',
                        'wishlist',
                        'stock'
                    ],
                    'wishlist' => [
                        'customer_id' => $customer_id,
                    ],
                    'offer' => [
                        'offer_only' => true,
                    ],
                    'product' => [
                        'other_fields' => true,
                    ],
                    'variant' => [
                        'other_fields' => true,
                    ],
                    'category' => [
                        'other_fields' => true,
                    ],
                    'brand' => [
                        'other_fields' => true,
                    ],
                    'multivariant' => true,
                ];

                // Step 4: Fetch all products for this offer
                $productModel = $this->getProductModel(); // fresh instance
                $productModel->whereIn('product.product_id', $productIds);
                $products = $productModel->product_listing($filter);
            }

            $offer['offer_items_products'] = $products ?? [];
            $finalOfferList[] = $offer;
        }

        return [
            'offerList'  => $finalOfferList,
            'totalCount' => count($finalOfferList),
        ];
    }

    // frontend web ke liye offer list ki api with variant wise products
    public function frontend_offer_list($customer_id = null)
    {
        try {
            $data = getRequestData($this->request, 'ARRAY');
            $customer_id = $data['customer_id'] ?? $this->getCustomerId();
            $offerList = $this->all_offer_array_data();

            // Check if notifications match the customer_id and access_id
            if (empty($offerList)) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::NOT_FOUND, "No notifications found for the specified customer ID.");
            }

            // Prepare response data
            $page_data = [
                'header_footer_data' => $this->header_footer() ?? [],
                'offerList' => $offerList['offerList'],
                'seo_data' => $this->getSeo('offers_page') ?? [],
            ];

            // Return success response
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, "Data fetched successfully", $page_data);
        } catch (Exception $e) {
            // Return error response in case of exception
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function Order_apply_coupon_list($order_amount = 0)
    {
        try {

            // Get request data safely
            $data = getRequestData($this->request, 'ARRAY');
            $order_amount = isset($data['order_amount']) ? (float) $data['order_amount'] : (float) $order_amount;

            // Current timestamp
            $currentDate = date('Y-m-d H:i:s');

            // Fetch valid coupons
            $coupons = $this->getCouponModel()
                ->where('is_active', 1)
                ->where('coupon_from <=', $currentDate)
                ->where('coupon_to >=', $currentDate)
                ->where('min_order_value <=', $order_amount)
                ->where('max_order_value >=', $order_amount)
                ->findAll();

            // Prepare data
            $page_data = [
                'order_amount' => $order_amount,
                'coupons'      => $coupons
            ];

            // Send formatted response
            if (!empty($coupons)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::OK,
                    "Available coupons fetched successfully",
                    $page_data
                );
            } else {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::NOT_FOUND,
                    "No coupons available for this order amount",
                    $page_data
                );
            }
        } catch (\Exception $e) {
            // Return error response in case of exception
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }
    }


    public function reffered_customer_list()
    {
        try {
            $data = getRequestData($this->request, 'ARRAY');
            $customerModel = $this->getCustomerModel();

            // Get POST values
            $customer_id = $data['customer_id'] ?? $this->getCustomerId();
            $level       = $data['level'] ?? '';

            if (!$customer_id) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::BAD_REQUEST,
                    'customer_id is required',
                    []
                );
            }

            if (!$level) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::BAD_REQUEST,
                    'level is required',
                    []
                );
            }

            // Check if customer exists
            $exists = $customerModel->find($customer_id);
            if (!$exists) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::BAD_REQUEST,
                    'Customer not found',
                    []
                );
            }

            // ===========================
            // ⭐ LEVEL - 1 LOGIC
            // ===========================
            if ($level == 1) {

                // All customers whose reffer_by_id = customer_id
                $data = $customerModel
                    ->where('reffer_by_id', $customer_id)
                    ->findAll();
            }

            // ===========================
            // ⭐ LEVEL - 2 LOGIC
            // ===========================
            else if ($level == 2) {

                // First get LEVEL-1 customers
                $level1 = $customerModel
                    ->select('customer_id')
                    ->where('reffer_by_id', $customer_id)
                    ->findAll();

                if (!empty($level1)) {

                    // Extract their IDs
                    $level1_ids = array_column($level1, 'customer_id');

                    // Now fetch those referred by level-1 customers
                    $data = $customerModel
                        ->whereIn('reffer_by_id', $level1_ids)
                        ->findAll();
                } else {
                    $data = [];
                }
            }

            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                'Referred customer list fetched successfully',
                $data
            );
        } catch (Exception $e) {

            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::BAD_REQUEST,
                $e->getMessage(),
                null,
                []
            );
        }
    }


    public function ewallet_active()
    {
        try {

            $data = getRequestData($this->request, 'ARRAY');
            $FC = new FirebaseController();
            $website_data = $this->header_footer() ?? [];
            $firm_logo = $website_data['website_profile']['firm_logo_url'] ?? '';

            $users = $this->getUserModel()->select('user_id')->where('user_type', 'admin')->findAll();
            // Validate
            if (empty($data['customer_id'])) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::BAD_REQUEST,
                    "customer_id is required",
                    []
                );
            }

            $customer_id = $data['customer_id'];

            $cm = $this->getCustomerModel();
            $customer = $cm->find($customer_id);

            if (empty($customer)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::NOT_FOUND,
                    "Customer not found",
                    []
                );
            }

            // Update only e-wallet related fields
            $updateData = [
                'is_patner'  => 1,
            ];

            $updated = $cm->update($customer_id, $updateData);

            if (!$updated) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::BAD_REQUEST,
                    "Failed to activate e-wallet",
                    []
                );
            }

            // SUCCESS RESPONSE (no data)
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                "E-Wallet activated successfully",
                []
            );
            // 🔔 CUSTOMER NOTIFICATION
            $FC->sendNotificationToCustomer(
                $customer_id,
                "🎉 Wallet Activated!",
                "Congratulations! Your e-wallet has been successfully activated. You can now earn and use wallet benefits.",
                $_ENV['EcommerceWebsiteDomainUrl'] . "/walletHistory",
                $_ENV['app.baseURL'] . $firm_logo
            );
            foreach ($users as $user) {
                $FC->sendNotificationToUser(
                    $user['user_id'],
                    "✅ Wallet Activated",
                    "Customer #{$customer_id} has successfully activated their e-wallet.",
                    base_url(route_to('admin_customers')),
                    $firm_logo
                );
            }
        } catch (Exception $e) {

            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::INTERNAL_SERVER_ERROR,
                $e->getMessage(),
                []
            );
        }
    }

    public function getCustomerWalletSummary()
    {
        try {

            $data = getRequestData($this->request, 'ARRAY');
            // Validate
            if (empty($data['customer_id'])) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::BAD_REQUEST,
                    "customer_id is required",
                    []
                );
            }

            $customer_id = $data['customer_id'];

            // 1) Fetch all wallet credit rows (FIFO order)
            $wallet_data = $this->getEWalletModel()
                ->select('e_wallet_id, e_wallet_amount, created_at')
                ->where('customer_id', $customer_id)
                ->where('is_wallet_active', 1)
                ->orderBy('e_wallet_id', 'ASC')
                ->findAll(); // returns array of rows

            // total earned (sum of all credit rows)
            $total_earned = array_sum(array_map(function ($r) {
                return floatval($r['e_wallet_amount'] ?? 0);
            }, $wallet_data));

            // 2) Withdrawals that actually reduce balance: paid OR purchased
            $withdrawals = $this->getEWallePaymentWithdrawlModel()
                ->select('withdraw_id, approved_amount, status, created_at')
                ->where('customer_id', $customer_id)
                ->whereIn('status', ['paid', 'purchased'])
                ->orderBy('created_at', 'ASC')
                ->findAll();

            // 3) purchased only (sum of approved_amount where status = 'purchased')
            $purchasedRow = $this->getEWallePaymentWithdrawlModel()
                ->selectSum('approved_amount', 'purchased_use_amount')
                ->where('customer_id', $customer_id)
                ->where('status', 'purchased')
                ->first();

            $purchased_withdraw = floatval($purchasedRow['purchased_use_amount'] ?? 0);

            // 4) pending requests (sum of requested_amount where status in pending, processing, approved)
            $pendingRow = $this->getEWallePaymentWithdrawlModel()
                ->selectSum('requested_amount', 'pending_amount')
                ->where('customer_id', $customer_id)
                ->whereIn('status', ['pending', 'processing', 'approved'])
                ->first();

            $pending_withdraw = floatval($pendingRow['pending_amount'] ?? 0);

            // 5) FIFO deduction logic using withdrawals (paid + purchased)
            // Work on a copy of wallet rows so we can modify amounts
            $remainingCredits = array_map(function ($r) {
                return [
                    'e_wallet_id' => $r['e_wallet_id'],
                    'e_wallet_amount' => floatval($r['e_wallet_amount'] ?? 0),
                    'created_at' => $r['created_at'] ?? null
                ];
            }, $wallet_data);

            $total_withdrawn = 0.0;

            foreach ($withdrawals as $wd) {
                $amountToDeduct = floatval($wd['approved_amount'] ?? 0.0);

                if ($amountToDeduct <= 0) continue;

                foreach ($remainingCredits as $key => $cr) {
                    if ($amountToDeduct <= 0) break;

                    $creditAmount = floatval($cr['e_wallet_amount']);

                    if ($creditAmount <= 0) {
                        // nothing to use from this row
                        continue;
                    }

                    if ($creditAmount <= $amountToDeduct + 0.000001) {
                        // consume full credit row
                        $amountToDeduct -= $creditAmount;
                        $total_withdrawn += $creditAmount;
                        // mark row as zero
                        $remainingCredits[$key]['e_wallet_amount'] = 0.0;
                    } else {
                        // consume part of this credit row
                        $remainingCredits[$key]['e_wallet_amount'] = round($creditAmount - $amountToDeduct, 8);
                        $total_withdrawn += $amountToDeduct;
                        $amountToDeduct = 0.0;
                    }
                }
            }

            // remove zero rows from fifo_remaining_rows and keep only leftover positive amounts
            $fifo_remaining_rows = array_values(array_filter($remainingCredits, function ($r) {
                return isset($r['e_wallet_amount']) && floatval($r['e_wallet_amount']) > 0;
            }));

            // 6) Remaining balance is sum of leftover amounts
            $current_balance = array_sum(array_column($fifo_remaining_rows, 'e_wallet_amount'));

            $wallet_withdrawal_data = [
                'customer_id'         => $customer_id,
                'total_earned'        => round($total_earned, 2),
                'total_withdrawn'     => round($total_withdrawn, 2),
                'pending_withdrawal'  => round($pending_withdraw, 2),
                'current_balance'     => round($current_balance, 2),
                'purchased_use_amount' => round($purchased_withdraw, 2),
                'fifo_remaining_rows' => $fifo_remaining_rows
            ];

            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                'Wallet Withdrawal list fetched successfully',
                $wallet_withdrawal_data
            );
        } catch (Exception $e) {

            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::INTERNAL_SERVER_ERROR,
                $e->getMessage(),
                []
            );
        }
    }

    public function customer_request_withdrawal_amount()
    {
        try {
            $data = getRequestData($this->request, 'ARRAY');
            $FC = new FirebaseController();
            $header_footer_data = $this->header_footer() ?? [];
            $firm_logo = $header_footer_data['website_profile']['firm_logo_url'] ?? '';
            $withdrawal_limit_amount = $header_footer_data['website_profile']['wallet_withdrawal_amount'];
            // 🔍 VALIDATION
            $validation = \Config\Services::validation();
            $validation->setRules([
                'customer_id'       => 'required|is_natural_no_zero',
                'requested_amount'  => 'required|decimal',
                'status'            => 'required|in_list[pending,approved,rejected,processing,paid]',
                'remark'            => 'permit_empty'
            ]);

            if (!$validation->run($data)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::VALIDATION_FAILED,
                    "Form Validation Failed",
                    [],
                    $validation->getErrors()
                );
            }
            if ($data['requested_amount'] > $withdrawal_limit_amount) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::VALIDATION_FAILED,
                    "Withdrawal amount exceeds the limit",
                    [],
                    $validation->getErrors()
                );
            }
            $wallet_data = $this->getEWalletModel()
                ->select('e_wallet_id, e_wallet_amount ,created_at')
                ->where('customer_id', $data['customer_id'])
                ->where('is_wallet_active', 1)
                ->orderBy('created_at', 'ASC')
                ->get()
                ->getResultArray();

            $withdrawals = $this->getEWallePaymentWithdrawlModel()
                ->select('withdraw_id, approved_amount, status')
                ->where('customer_id', $data['customer_id'])
                ->whereIn('status', ['purchased', 'paid'])
                ->orderBy('created_at', 'ASC')
                ->get()
                ->getResultArray();

            $remainingCredits = $wallet_data;
            $total_withdrawn = 0;

            foreach ($withdrawals as $wd) {
                $amountToDeduct = $wd['approved_amount'];

                foreach ($remainingCredits as $key => $cr) {
                    if ($amountToDeduct <= 0) break;

                    $creditAmount = $cr['e_wallet_amount'];

                    if ($creditAmount <= $amountToDeduct) {
                        // consume full credit
                        $amountToDeduct -= $creditAmount;
                        $total_withdrawn += $creditAmount;
                        unset($remainingCredits[$key]);
                    } else {
                        // consume part of credit
                        $remainingCredits[$key]['e_wallet_amount'] -= $amountToDeduct;
                        $total_withdrawn += $amountToDeduct;
                        $amountToDeduct = 0;
                    }
                }
            }

            // Remaining balance
            $current_balance = array_sum(array_column($remainingCredits, 'e_wallet_amount'));
            if ($data['requested_amount'] > $current_balance) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::VALIDATION_FAILED,
                    "Your current balance is less than your request amount",
                    [],
                    $validation->getErrors()
                );
            }
            $withdrawModel = $this->getEWallePaymentWithdrawlModel();

            // --------------------------------------------
            //   CHECK IF withdraw_id EXISTS (UPDATE CASE)
            // --------------------------------------------

            if (!empty($data['withdraw_id'])) {

                $existing = $withdrawModel->find($data['withdraw_id']);

                if (!$existing) {
                    return formatApiResponse(
                        $this->request,
                        $this->response,
                        ApiResponseStatusCode::BAD_REQUEST,
                        "Invalid withdraw_id. Record not found!",
                        []
                    );
                }

                // 🔄 UPDATE RECORD
                $withdrawModel->update($data['withdraw_id'], $data);
                // 🔔 CUSTOMER NOTIFICATION (ON UPDATE)
                $FC->sendNotificationToCustomer(
                    $data['customer_id'],
                    "📢 Withdrawal Status Updated",
                    "Your withdrawal request of ₹{$data['requested_amount']} is now '{$data['status']}'.",
                    $_ENV['EcommerceWebsiteDomainUrl'] . "/walletHistory",
                    $_ENV['app.baseURL'] . $firm_logo
                );
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::OK,
                    "Withdrawal Request Updated Successfully",
                    $withdrawModel->find($data['withdraw_id'])
                );
            }

            // --------------------------------------------
            // CHECK AGE OF REMAINING WALLET BALANCE (FIFO BASED)
            // --------------------------------------------

            $remainingCredits = array_values($remainingCredits);

            if (empty($remainingCredits)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::BAD_REQUEST,
                    "No usable wallet balance available for withdrawal",
                    []
                );
            }

            // latest usable credit (FIFO ke baad jo bacha)
            $latestRemainingCredit = end($remainingCredits);

            $walletCreatedAt = new \DateTime($latestRemainingCredit['created_at']);
            $currentDate     = new \DateTime();
            $daysDifference  = $walletCreatedAt->diff($currentDate)->days;

            if ($daysDifference < 7) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::BAD_REQUEST,
                    "Withdrawal allowed only after 7 days of wallet credit",
                    [
                        'wallet_credit_date' => $latestRemainingCredit['created_at'],
                        'days_completed'     => $daysDifference,
                        'days_remaining'     => 7 - $daysDifference
                    ]
                );
            }
            // --------------------------------------------
            //   NO withdraw_id → CREATE NEW RECORD
            // --------------------------------------------

            $newId = $withdrawModel->insert($data);

            if ($newId) {

                // 🔔 ADMIN NOTIFICATION (ON CREATE)
                $users = $this->getUserModel()
                    ->select('user_id')
                    ->where('user_type', 'admin')
                    ->findAll();

                foreach ($users as $user) {
                    $FC->sendNotificationToUser(
                        $user['user_id'],
                        "💸 New Withdrawal Request",
                        "Customer #{$data['customer_id']} requested ₹{$data['requested_amount']} withdrawal.",
                        base_url(route_to('pending_withdrawal_request_list')),
                        $firm_logo
                    );
                }

                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::OK,
                    "Withdrawal Request Created Successfully",
                    $withdrawModel->find($newId)
                );
            }

            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::BAD_REQUEST,
                "Failed to create withdrawal request",
                []
            );
        } catch (\Exception $e) {

            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::BAD_REQUEST,
                $e->getMessage()
            );
        }
    }

    // delhivery apis work start here
    public function checkPincodeServiceability()
    {
        $data = getRequestData($this->request, 'ARRAY');

        if (empty($data['pincode'])) {
            return $this->response->setJSON([
                'status'  => 400,
                'message' => 'Pincode is required'
            ]);
        }

        $token = $_ENV['DelhiveryAPIToken'] ?? '';

        // ✅ apiCall returns ARRAY
        $response = $this->apiCall(
            "https://track.delhivery.com/c/api/pin-codes/json/",
            'GET',
            [
                'filter_codes' => $data['pincode']   // 👈 GET params here
            ],
            [
                'Authorization' => 'Bearer ' . $token,
                'Accept'        => 'application/json'
            ]
        );

        // ❌ API error
        if (empty($response) || !isset($response['delivery_codes'][0]['postal_code'])) {
            return $this->response->setJSON([
                'status'  => 404,
                'message' => 'Invalid response from Delhivery'
            ]);
        }

        $postal = $response['delivery_codes'][0]['postal_code'];

        // ❌ Not serviceable
        if ($postal['pickup'] !== 'Y') {
            return $this->response->setJSON([
                'status'  => 404,
                'message' => 'Not serviceable'
            ]);
        }

        $pincode = [
            'cod'      => isset($postal['cod']) && $postal['cod'] === 'Y',
            'pre_paid' => isset($postal['pre_paid']) && $postal['pre_paid'] === 'Y',
            'city'     => $postal['city'] ?? ($postal['center']['city'] ?? null),
            'state'    => $postal['state_code']
                ?? ($postal['center']['state'] ?? null)
                ?? null
        ];

        return GetformatApiResponse(
            $this->request,
            $this->response,
            ApiResponseStatusCode::OK,
            'Pincode serviceability checked successfully',
            $pincode
        );
    }
    public function calculateShippingCost()
    {
        try {
            $data = getRequestData($this->request, 'ARRAY');

            //  Proper validation
            $required = ['md', 'ss', 'o_pin', 'd_pin', 'cgm', 'pt'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    return GetformatApiResponse(
                        $this->request,
                        $this->response,
                        ApiResponseStatusCode::BAD_REQUEST,
                        "Missing required field: {$field}"
                    );
                }
            }

            $token = $_ENV['DelhiveryAPIToken'] ?? '';
            if (empty($token)) {
                return GetformatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::UNAUTHORIZED,
                    'Delhivery API token missing'
                );
            }

            // ✅ Call Delhivery Charges API
            $response = $this->apiCall(
                'https://track.delhivery.com/api/kinko/v1/invoice/charges/.json',
                'GET',
                $data,
                [
                    'Authorization' => 'Token ' . $token,
                    'Accept'        => 'application/json'
                ]
            );

            // ❌ API failure
            if (empty($response)) {
                return GetformatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::SERVICE_UNAVAILABLE,
                    'Empty response from Delhivery'
                );
            }

            // ❌ Delhivery error response
            if (isset($response['error'])) {
                return GetformatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::BAD_REQUEST,
                    'Delhivery error',
                    null,
                    $response
                );
            }

            // ✅ Success
            return GetformatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                'Shipping cost calculated successfully',
                $response
            );
        } catch (\Throwable $e) {
            log_message('error', 'Shipping Cost Error: ' . $e->getMessage());

            return GetformatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::INTERNAL_SERVER_ERROR,
                'Something went wrong while calculating shipping cost'
            );
        }
    }

    public function CustomerOrderTrackingShipping($ref_ids, $waybill)
    {
        if (empty($ref_ids) || empty($waybill)) {
            return [];
        }

        $token = $_ENV['DelhiveryAPIToken'] ?? '';

        $response = $this->apiCall(
            "https://track.delhivery.com/api/v1/packages/json/",
            'GET',
            [
                'waybill' => $waybill,
                'ref_ids' => $ref_ids,
            ],
            [
                'Authorization' => 'Bearer ' . $token,
                'Accept'        => 'application/json'
            ]
        );

        return $response ?? [];
    }
}
