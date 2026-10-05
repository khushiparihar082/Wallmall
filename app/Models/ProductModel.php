<?php

namespace App\Models;

use ApiResponseStatusCode;
use App\Models\FunctionModel;
use App\Traits\CommonTraits;
use Exception;

class ProductModel extends FunctionModel
{
    use CommonTraits;
    protected $table            = 'product';
    protected $primaryKey       = 'product_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'product_id',
        'product_name',
        'product_code',
        'product_hsn_code',
        'category_type_id',
        'category_id',
        'brand_id',
        'height',
        'width',
        'length',
        'product_description',
        'product_seo_title',
        'product_seo_description',
        'product_keyfeature',
        'product_specialcare',
        'product_alt_text1',
        'product_alt_text2',
        'product_alt_text3',
        'variant_id',
        'product_refund_exchange',
        'spotlight_image',
        'fluencer_video',
        'fluencer_alt_text',
        'spotlight_alt_text',
        'spotlight_product_description',
        'spotlight_product_title',
        'product_image1',
        'product_image2',
        'product_image3',
        'is_spotlight',
        'is_fluencer',
        'is_recommended',
        'is_returnable',
        'is_sponsore',
        'is_exchangeable',
        'view_count',
        'product_return_exchange_days',
        'is_active',
        'created_at'
    ];
    protected $booleanFields = ["is_recommended", "is_exchangeable", "is_sponsore", "is_returnable", "is_active", "is_spotlight", "is_fluencer"];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $messageAlias = 'Product';
    // Validation


    protected $validationRules = [
        'product_id' => 'permit_empty',
        'product_name' => 'required|max_length[255]|is_unique[product.product_name,product_id,{product_id}]',
        'product_code' => 'permit_empty|alpha_numeric_space',
        'product_hsn_code' => 'required|max_length[8]',
        'category_type_id' => 'required|integer|is_not_unique[category_type.category_type_id]',
        'category_id' => 'required|integer|is_not_unique[category.category_id]',
        'brand_id' => 'required|integer|is_not_unique[brand.brand_id]',
        'height' => 'permit_empty',
        'width' => 'permit_empty',
        'length' => 'permit_empty',
        'product_description' => 'permit_empty',
        'product_seo_title' => 'permit_empty|max_length[60]',
        'product_seo_description' => 'permit_empty|max_length[170]',
        'product_keyfeature' => 'permit_empty',
        'product_specialcare' => 'permit_empty',
        'product_refund_exchange' => 'permit_empty',
        'variant_id' => 'permit_empty|integer|is_not_unique[product_variant.variant_id]',
        'spotlight_image' => 'permit_empty',
        'fluencer_video' => 'permit_empty',
        'product_image1' => 'permit_empty',
        'product_image2' => 'permit_empty',
        'product_image3' => 'permit_empty',
        'product_alt_text1' => 'permit_empty',
        'product_alt_text2' => 'permit_empty',
        'product_alt_text3' => 'permit_empty',
        'spotlight_alt_text' => 'permit_empty',
        'fluencer_alt_text' => 'permit_empty',
        'spotlight_product_title' => 'permit_empty',
        'spotlight_product_description' => 'permit_empty',
        'view_count' => 'permit_empty',
        'is_spotlight' => 'permit_empty',
        'is_fluencer' => 'permit_empty',
        'is_recommended' => 'permit_empty',
        'is_returnable' => 'permit_empty',
        'is_sponsore' => 'permit_empty',
        'is_exchangeable' => 'permit_empty',
        'is_active' => 'permit_empty',
        'product_return_exchange_days' => 'required',
    ];
    protected $validationMessages = [
        'product_name' => [
            'required' => 'Product name is required.',
            'max_length' => 'Max 255 characters.',
            'alpha_space' => 'The Product name cannot contain special characters or numbers.',
        ],
        'product_seo_title' => [
            'max_length' => 'Max 120 characters.'
        ],
        'product_specialcare' => [
            'max_length' => 'Max 120 characters.'
        ],
        'product_seo_description' => [
            'max_length' => 'Max 120 characters.'
        ],
        'product_refund_exchange' => [
            'max_length' => 'Max 120 characters.'
        ],
        'product_code' => [
            'required' => 'Product code is required.',
            'alpha_numeric_space' => 'The Product code cannot contain special characters.',
        ],
        'product_hsn_code' => [
            'required' => 'HSN code is required.'
        ],
        'category_type_id' => [
            'required' => 'Category type is required.'
        ],
        'category_id' => [
            'required' => 'Category ID is required.'
        ],
        'brand_id' => [
            'required' => 'Brand ID is required.'
        ],
        'product_return_exchange_days' => [
            'required' => 'Return Exchange days is required.'
        ],

    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['updateBooleanFields'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['updateBooleanFields'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = ['ConvertDateDMY', 'MultiConnection'];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    protected $dateFields = ['created_at', 'updated_at'];

    public function __construct()
    {
        parent::__construct();
        $this->addParentJoin('category_type_id', $this->getCategoryTypeModel(), 'left', ['category_type_name']);
        $this->addParentJoin('category_id', $this->getCategoryModel(), 'left', ['category_name']);
        $this->addParentJoin('brand_id', $this->getBrandModel(), 'left', ['brand_name']);
    }
    // Custom validation rules
    protected function alpha_space(string $str): bool
    {
        return preg_match('/^[a-zA-Z\s]+$/', $str) === 1;
    }

    protected function alpha_numeric_space(string $str): bool
    {
        return preg_match('/^[a-zA-Z0-9\s]+$/', $str) === 1;
    }

    public function MultiConnection($data)
    {
        if (isset($data['data'])) {
            if (isset($_POST['_otherFilters']) && !empty($_POST['_otherFilters'])) {
                $otherFilters = $_POST['_otherFilters'];
                if (isset($data['data'][0])) {
                    $top_search_data = [];
                    if (isset($otherFilters['top_search']) && $otherFilters['top_search'] == true) {
                        $product_ids = array_column($data['data'], 'product_id') ?? [];
                        if (!empty($product_ids)) {
                            $top_search_data = $this->getTopSearchSummaryModel()->whereIn('product_id', $product_ids)->findAll();
                        }
                    }
                    // features
                    foreach ($data['data'] as $key => &$product) {
                        if (isset($otherFilters['features']) && $otherFilters['features'] == true) {
                            $features_filters = $otherFilters['features_filters'] ?? [];
                            $this->features($product, $features_filters);
                        }
                        // variants
                        if (isset($otherFilters['variants']) && $otherFilters['variants'] == true) {
                            $variants_filters = $otherFilters['variants_filters'] ?? [];
                            $this->variants($product, $variants_filters);
                        }
                        if (isset($otherFilters['top_search']) && $otherFilters['top_search'] == true) {
                            foreach ($top_search_data as $top_search_row) {
                                if ($top_search_row['product_id'] == $product['product_id']) {
                                    $product['total_search_count'] = $top_search_row['total_search_count'];
                                    break;
                                }
                            }
                            if (!isset($product['total_search_count'])) {
                                $product['total_search_count'] = 0;
                            }
                        }
                    }
                } else {
                    if (isset($otherFilters['features']) && $otherFilters['features'] == true) {
                        $features_filters = $otherFilters['features_filters'] ?? [];
                        $this->features($data['data'], $features_filters);
                    }
                    // variants
                    if (isset($otherFilters['variants']) && $otherFilters['variants'] == true) {
                        $variants_filters = $otherFilters['variants_filters'] ?? [];
                        $this->variants($data['data'], $variants_filters);
                        // if (isset($otherFilters['sizes']) && $otherFilters['sizes'] == true) {
                        //     if (isset($data['data']['variants']) && !empty(isset($data['data']['variants']))) {
                        //         $sizes_filters = $otherFilters['sizes_filters'] ?? [];
                        //         foreach ($data['data']['variants'] as &$variant) {
                        //             $this->sizes($variant, $sizes_filters);
                        //         }
                        //     }
                        // }
                    }
                }
            }
        }
        return $data;
    }

    public function features(&$row, $filters = [])
    {
        $filters['product_vs_feature.product_id'] = $row['product_id'];
        $data = $this->getProductVsFeatureModel()->RecordList($filters);
        ($data['status'] == ApiResponseStatusCode::OK) ? $row['features'] = $data['data'] : $row['features'] = [];
    }
    public function variants(&$row, $filters = [])
    {
        $filters['product_variant.product_id'] = $row['product_id'];
        $data = $this->getProductVariantModel()->RecordList($filters);
        ($data['status'] == ApiResponseStatusCode::OK) ? $row['variants'] = $data['data'] : $row['variants'] = [];
    }
    public function sizes(&$row, $filters = [])
    {
        $filters['size_vs_variant.variant_id'] = $row['variant_id'];
        $data = $this->getSizeVsVariantModel()->RecordList($filters);
        ($data['status'] == ApiResponseStatusCode::OK) ? $row['sizes'] = $data['data'] : $row['sizes'] = [];
    }

    function product_listing($filter = [])
    {
        // try catch exception throw to outer function
        try {
            $customer_id = $_SESSION['customer_id'] ?? null;
            $this->select('product.product_id,product.product_name,product.category_type_id,product.category_id,product.brand_id');
            $this->select('product_variant.variant_id');
            if (isset($filter['other_fields']) && $filter['other_fields'] == true) {
                $this->select("product.product_code,product.product_hsn_code,product.height,product.width,product.length,product.product_description,product.product_keyfeature,product.product_specialcare,product.product_refund_exchange,product.is_recommended,product.is_sponsore,product.is_returnable,product.is_exchangeable,product.spotlight_product_description,product.spotlight_product_title,product.product_return_exchange_days,product.is_active");

                foreach (range(1, 3) as $i) {
                    $this->select(getImagePathQueryString("product.product_image$i"));
                    $this->select(getImagePathQueryString("product.product_image$i", true));
                    $this->select("product.product_alt_text$i");
                }

                // 👇 Spotlight & Fluencer fields add here
                $this->select(getImagePathQueryString("product.spotlight_image"));
                $this->select(getImagePathQueryString("product.spotlight_image", true));
                $this->select("product.spotlight_alt_text");
                $this->select("product.fluencer_video, product.fluencer_alt_text");
                $this->select("product.is_spotlight, product.is_fluencer");
            }
            if (isset($filter['joins'])) {
                $joins = $filter['joins'];
                if (in_array('top_search', $joins)) {
                    $this->select('IFNULL(top_search_summary.total_search_count, 0) as search_count');
                }

                if (in_array('category_type', $joins)) {
                    $this->select('category_type.category_type_name');
                    if (isset($filter['category_type']['other_fields']) && $filter['category_type']['other_fields'] == true) {
                        $this->select('category_type.category_type_description,category_type.category_type_alt_text');
                        $this->select(getImagePathQueryString('category_type.category_type_image'));
                        $this->select(getImagePathQueryString('category_type.category_type_image', true));
                        $this->select(getImagePathQueryString('category_type.category_type_icon'));
                        $this->select(getImagePathQueryString('category_type.category_type_icon', true));
                    }
                }
                if (in_array('category', $joins)) {
                    $this->select('category.category_name');
                    if (isset($filter['category']['other_fields']) && $filter['category']['other_fields'] == true) {
                        $this->select('category.category_description,category.category_alt_text');
                        $this->select(getImagePathQueryString('category.category_image'));
                        $this->select(getImagePathQueryString('category.category_image', true));
                    }
                }
                if (in_array('brand', $joins)) {
                    $this->select('brand.brand_name');
                    if (isset($filter['brand']['other_fields']) && $filter['brand']['other_fields'] == true) {
                        $this->select('brand.brand_description,brand.brand_alt_text');
                        $this->select(getImagePathQueryString('brand.brand_image'));
                        $this->select(getImagePathQueryString('brand.brand_image', true));
                    }
                }
                if (in_array('variant', $joins)) {
                    $this->select('product_variant.variant_id,product_variant.variant_sku_code,product_variant.variant_name,product_variant.unit_id,product_variant.color_id,product_variant.cod_charges');
                    $this->select('product_variant.size_id as default_size_id');

                    if (isset($filter['variant']['other_fields']) && $filter['variant']['other_fields'] == true) {
                        $this->select('product_variant.variant_weight,product_variant.mrp,product_variant.discount_per,product_variant.gst_per,product_variant.selling_price,product_variant.delivery_charge,product_variant.variant_description');
                        foreach (range(1, 6) as $i) {
                            $this->select(getImagePathQueryString("product_variant.variant_image$i"));
                            $this->select(getImagePathQueryString("product_variant.variant_image$i", true));
                            $this->select("product_variant.variant_alt_text$i");
                        }
                        if (isset($filter['ecommerce']) && $filter['ecommerce'] != true) {
                            $this->select('product_variant.purchase_rate,product_variant.cost_price,product_variant.profit_per,product_variant.profit_amt');
                        }
                        // Define the final_price and final_discount expressions
                        if (in_array('offer', $joins)) {
                            $final_price_expr = "ROUND(product_variant.selling_price * (1 - (COALESCE(offer.offer_discount, 0) / 100)), 0)";
                            $this->select("$final_price_expr as final_price");
                            $this->select("ROUND((1 - ($final_price_expr / product_variant.mrp)) * 100, 0) as final_discount");
                        } else {
                            $final_price_expr = "ROUND(product_variant.selling_price, 0)";
                            $this->select("$final_price_expr as final_price");
                            $this->select("ROUND((1 - ($final_price_expr / product_variant.mrp)) * 100, 0) as final_discount");
                        }
                    }
                    if (in_array('unit', $joins)) {
                        $this->select('unit.unit_name');
                    }
                    if (in_array('stock', $joins)) {
                        $this->select('stock.quantity');
                    }
                    if (in_array('size', $joins)) {
                        $this->select('size.size_id,size.size_name');
                    }
                    if (!empty($customer_id)) {
                        if (in_array('wishlist', $joins)) {
                            $this->select('customer_wishlist.customer_wishlist_id');
                        }
                        if (in_array('cart', $joins)) {
                            $this->select('customer_cart.customer_cart_id,customer_cart.cart_quantity');
                            $this->select('(product_variant.selling_price * customer_cart.cart_quantity) as CartItemTotal');
                        }
                    }
                    if (in_array('color', $joins)) {
                        $this->select('color.color_name,color.color_code,color_alt_text');
                        $this->select(getImagePathQueryString('color.color_image'));
                        $this->select(getImagePathQueryString('color.color_image', true));
                    }
                    //OfferItem
                    if (in_array('offer', $joins)) {
                        $this->select('offer.offer_id,offer.offer_name,offer.offer_title,offer.offer_alt_text,offer.offer_type,offer.offer_from,offer.offer_to');
                        $this->select(getNumericQueryString('offer.offer_discount'));
                        $this->select(getImagePathQueryString('offer.offer_image'));
                        $this->select(getImagePathQueryString('offer.offer_image', true));
                    }
                    if (in_array('customer_review', $joins)) {
                        $this->select('ROUND(IFNULL(review_summary.review_rating_avg, 0), 1) as customer_rating');
                        $this->select('IFNULL(review_summary.review_count_sum, 0) as customer_review_count');
                    }
                }
            }
            if (isset($filter['joins'])) {
                $joins = [
                    'category_type' => 'category_type.category_type_id = product.category_type_id',
                    'category' => 'category.category_id = product.category_id',
                    'brand' => 'brand.brand_id = product.brand_id',
                    'top_search' => 'top_search_summary.product_id = product.product_id',
                    'variant' => 'product_variant.product_id = product.product_id',
                    'customer_review' => 'review_summary.variant_id = product_variant.variant_id',
                    'unit' => 'unit.unit_id = product_variant.unit_id',
                    'stock' => isset($filter['default_variant_only']) && !$filter['default_variant_only']
                        ? 'stock.variant_id = product_variant.variant_id'
                        : 'stock.variant_id = product.variant_id',
                    'wishlist' => !empty($customer_id)
                        ? "customer_wishlist.customer_id = $customer_id AND customer_wishlist.variant_id = product_variant.variant_id"
                        : '',
                    'cart' => !empty($customer_id)
                        ? "customer_cart.customer_id = $customer_id AND customer_cart.variant_id = product_variant.variant_id"
                        : '',
                    'color' => 'color.color_id = product_variant.color_id'
                ];
                foreach ($joins as $key => $joinCondition) {
                    if (in_array($key, $filter['joins'])) {
                        switch ($key) {
                            case 'variant':
                                $key = "product_variant";
                                break;
                            case 'top_search':
                                $key = "top_search_summary";
                                break;
                            case 'customer_review':
                                $key = "review_summary";
                                break;
                            case 'wishlist':
                                $key = "customer_wishlist";
                                break;
                            case 'cart':
                                $key = "customer_cart";
                                break;
                            default:
                                # code...
                                break;
                        }
                        if (!empty($joinCondition)) {
                            $this->join($key, $joinCondition, 'left');
                            if ($key ==  'product_variant' && in_array('size', $filter['joins']) && in_array('variant', $filter['joins'])) {
                                if (isset($filter['default_size_only']) && !$filter['default_size_only']) {
                                    $this->join("size_vs_variant", "size_vs_variant.variant_id = product_variant.variant_id", "left");
                                    $this->join("size", "size.size_id = size_vs_variant.size_id", "left");
                                } else {
                                    $this->join("size", "size.size_id = product_variant.size_id", "left");
                                }
                            }
                        }
                    }
                }
                if (in_array('offer', $filter['joins'])) {
                    $this->join("offer_item", "offer_item.product_id = product.product_id", "left");
                    $this->join("offer", "offer.offer_id = offer_item.offer_id AND offer.offer_from <= CURDATE() AND offer.offer_to >= CURDATE()", "left");
                }
            }
            if (in_array('offer', $filter['joins']) && isset($filter['offer']['offer_only']) && $filter['offer']['offer_only'] == true) {
                $this->where('offer.offer_id IS NOT NULL');
            }
            if (in_array('offer', $filter['joins']) && isset($filter['offer']['offer_type']) && $filter['offer']['offer_type'] == true) {
                $this->where('offer.offer_type', $filter['offer']['offer_type']);
            }
            // 👇 Spotlight & Fluencer filters
            if (isset($filter['spotlight_only']) && $filter['spotlight_only'] == true) {
                $this->where('product.is_spotlight', 1);
            }
            if (isset($filter['fluencer_only']) && $filter['fluencer_only'] == true) {
                $this->where('product.is_fluencer', 1);
            }
            if (isset($filter['joins'])) {
                foreach (['product', 'category_type', 'category', 'brand', 'variant', 'size', 'color'] as $key) {
                    if (in_array($key, $filter['joins']) && isset($filter[$key]) && is_array($filter[$key])) {
                        $is_active_check = true;
                        if ((!isset($filter['ecommerce']) && $filter['ecommerce'] != true) || in_array($key, ['size', 'color'])) {
                            $is_active_check = false;
                        }
                        if (!empty($filter[$key])) {
                            $this->applyProductListingCommonFilter($key, $filter[$key], $is_active_check);
                        }
                    }
                }
                if (isset($filter['feature'])) {
                    if (isset($filter['feature']['feature_names']) && !empty($filter['feature']['feature_names'])) {
                        $pvfModel = $this->getProductVsFeatureModel();

                        // Select the product_id from product_vs_feature table
                        $pvfModel->select('product_vs_feature.product_id');

                        // Join with the feature table to filter by feature names
                        $pvfModel->join('feature', 'product_vs_feature.feature_id = feature.feature_id');

                        // Filter by feature names
                        $pvfModel->whereIn('feature.feature_name', $filter['feature']['feature_names']);

                        // Group by product_id to count the number of distinct feature names for each product
                        $pvfModel->groupBy('product_vs_feature.product_id');

                        // Compile the subquery
                        $rawSql = $pvfModel->builder()->getCompiledSelect(false);

                        // Apply the subquery in the main query's where IN clause
                        $this->where('product.product_id IN (' . $rawSql . ')', null, false);
                    }
                }
                if (in_array('variant', $filter['joins']) && isset($filter['discount'])) {
                    if (isset($filter['discount']['from']) && !empty($filter['discount']['from'])) {
                        // 'from' should be the lower bound, so use '>='
                        $this->where('product_variant.discount_per >=', $filter['discount']['from']);
                    }
                    if (isset($filter['discount']['to']) && !empty($filter['discount']['to'])) {
                        // 'to' should be the upper bound, so use '<='
                        $this->where('product_variant.discount_per <=', $filter['discount']['to']);
                    }
                }
                if (in_array('variant', $filter['joins']) && isset($filter['price'])) {
                    if (isset($filter['price']['from']) && !empty($filter['price']['from'])) {
                        // 'from' should be the lower bound, so use '>='
                        $this->where('product_variant.selling_price >=', $filter['price']['from']);
                    }
                    if (isset($filter['price']['to']) && !empty($filter['price']['to'])) {
                        // 'to' should be the upper bound, so use '<='
                        $this->where('product_variant.selling_price <=', $filter['price']['to']);
                    }
                }

                if (in_array('wishlist', $filter['joins']) && isset($filter['wishlist'])) {
                    if (!empty($filter['wishlist']['wishlist_only'])) {
                        // Ensure customer_wishlist_id is not null when wishlist_only is true
                        $this->where('customer_wishlist.customer_wishlist_id IS NOT NULL');
                    }
                }
                if (in_array('cart', $filter['joins']) && isset($filter['cart'])) {
                    if (isset($filter['cart']['customer_cart_ids']) && is_array($filter['cart']['customer_cart_ids']) && !empty($filter['cart']['customer_cart_ids'])) {
                        // Apply whereIn condition for customer_cart_ids
                        $this->whereIn('customer_cart.customer_cart_id', $filter['cart']['customer_cart_ids']);
                    }

                    if (!empty($filter['cart']['cart_only'])) {
                        // Ensure customer_cart_id is not null when cart_only is true
                        $this->where('customer_cart.customer_cart_id IS NOT NULL');
                    }
                }
            }

            if (isset($filter['availableStock']) && $filter['availableStock']) {
                $this->where('stock.quantity >', 0);
            }
            if (isset($filter['limit'])) {
                if (!empty($filter['limit']['count'])) {
                    $this->limit($filter['limit']['count']);
                }
                if (!empty($filter['limit']['start_from'])) {
                    $this->offset($filter['limit']['start_from']);
                }
            }
            // Search By String
            if (isset($filter['search']) && !empty($filter['search']) && is_string($filter['search'])) {
                $search_array = explode(' ', $filter['search']);
                $firstWordIsSearched = false;
                foreach ($search_array as $word) {
                    if (!$firstWordIsSearched) {
                        $this->like('product.product_name', $word);
                        $firstWordIsSearched = true;
                    }
                    $this->orLike('product.product_name', $word);
                    $this->orLike('product_variant.variant_name', $word);
                    $this->orLike('category_type.category_type_name', $word);
                    $this->orLike('category.category_name', $word);
                    $this->orLike('color.color_name', $word);
                    $this->orLike('size.size_name', $word);
                }
            }
            if (isset($filter['OrderBy']) && !empty($filter['OrderBy'])) {
                switch ($filter['OrderBy']) {
                    case 'top_search':
                        if (in_array('top_search', $joins)) {
                            $this->orderBy("top_search_summary.total_search_count");
                        }
                        break;
                    case 'new_arrival':
                        $this->orderBy('product.created_at', 'desc');
                        break;
                    case 'top_rating':
                        if (in_array('customer_review', $joins)) {
                            $this->orderBy('review_summary.review_count_sum', 'desc')
                                ->orderBy('review_summary.review_rating_avg', 'desc');
                        }
                        break;
                    case 'recommended':
                        $this->orderBy('product.is_recommended', 'desc');
                        break;
                    case 'sponsored':
                        $this->orderBy('product.is_sponsore', 'desc');
                        break;
                    case 'price_lowest':
                        if (in_array('variant', $filter['joins'])) {
                            $this->orderBy('final_price', 'asc'); // Order by ascending price
                        }
                        break;
                    case 'price_highest':
                        if (in_array('variant', $filter['joins'])) {
                            $this->orderBy('final_price', 'desc'); // Order by descending price
                        }
                        break;
                    case 'discount_highest':
                        if (in_array('variant', $filter['joins'])) {
                            $this->orderBy('final_discount', 'desc'); // Order by descending discount
                        }
                        break;
                    default:
                        break;
                }
            }

            $data = $this->distinct()
                ->groupBy('product_variant.variant_id')
                ->findAll() ?? [];

            if (!empty($data)) {
                // Product and Social Media URL
                if (isset($filter['ecommerce']) && $filter['ecommerce']) {
                    $this->addProductDetailPageUrlWithSocialMedia($data);
                }

                // Multi Variant
                // if (isset($filter['multivariant']) && $filter['multivariant'] == true) {
                //     $product_ids = array_unique(array_column($data, 'product_id'));
                //     $vm = $this->getProductVariantModel();
                //     $vm->select('product_variant.variant_id,product_variant.product_id,product_variant.variant_sku_code,product_variant.variant_name,product_variant.unit_id,product_variant.color_id,product_variant.size_id as default_size_id');
                //     $vm->select('product_variant.variant_weight,product_variant.mrp,product_variant.discount_per,product_variant.gst_per,product_variant.selling_price,product_variant.delivery_charge,product_variant.variant_description,product_variant.variant_alt_text1');
                //     $vm->select(getImagePathQueryString('product_variant.variant_image1'));
                //     $vm->select(getImagePathQueryString('product_variant.variant_image1', true));
                //     if (!isset($filter['ecommerce']) || $filter['ecommerce'] != true) {
                //         $vm->select('product_variant.purchase_rate,product_variant.cost_price,product_variant.profit_per,product_variant.profit_amt');
                //     }
                //     $vm->select('product.product_name');
                //     $vm->join('product', 'product.product_id = product_variant.product_id', 'left');
                //     $vm->select('color.color_name,color.color_code');
                //     $vm->join('color', 'color.color_id = product_variant.color_id', 'left');

                //     // Offer
                //     if (isset($filter['joins'])) {
                //         if (in_array('offer', $filter['joins'])) {
                //             $final_price_expr = "ROUND(product_variant.selling_price * (1 - (COALESCE(offer.offer_discount, 0) / 100)), 0)";
                //             $vm->select("$final_price_expr as final_price");
                //             $vm->select("ROUND((1 - ($final_price_expr / product_variant.mrp)) * 100, 0) as final_discount");
                //         } else {
                //             $final_price_expr = "ROUND(product_variant.selling_price, 0)";
                //             $vm->select("$final_price_expr as final_price");
                //             $vm->select("ROUND((1 - ($final_price_expr / product_variant.mrp)) * 100, 0) as final_discount");
                //         }
                //     }

                //     if (isset($filter['joins'])) {
                //         if (in_array('offer', $filter['joins'])) {
                //             $current_date = date('Y-m-d');
                //             $vm->join('offer_item', 'offer_item.product_id = product.product_id', 'left');
                //             $vm->join('offer', "offer.offer_id = offer_item.offer_id AND offer.offer_from <= '$current_date' AND offer.offer_to >= '$current_date'", 'left');
                //         }
                //         if (in_array('customer_review', $filter['joins'])) {
                //             $vm->join('review_summary', 'review_summary.variant_id = product_variant.variant_id', 'left');
                //         }
                //     }

                //     $vm->whereIn('product_variant.product_id', $product_ids);
                //     if (isset($filter['ecommerce']) && $filter['ecommerce']) {
                //         $vm->where('product_variant.is_active', 1);
                //     }

                //     $variant_data = $vm->findAll() ?? [];
                //     if (isset($filter['ecommerce']) && $filter['ecommerce']) {
                //         $this->addProductDetailPageUrlWithSocialMedia($variant_data);
                //     }

                //     // if (isset($filter['multisizes']) && $filter['multisizes']) {
                //     //     $size_vs_variant_model = $this->getSizeVsVariantModel();
                //     //     $sizes_data = $size_vs_variant_model
                //     //         ->select('size.size_id, size_vs_variant.variant_id')
                //     //         ->autoJoin()
                //     //         ->findAll();

                //     //     $sizes_by_variant = [];
                //     //     foreach ($sizes_data as $size) {
                //     //         $sizes_by_variant[$size['variant_id']][] = $size;
                //     //     }

                //     //     foreach ($variant_data as $key => $variant) {
                //     //         $variant_data[$key]['sizes'] = $sizes_by_variant[$variant['variant_id']] ?? [];
                //     //     }
                //     // }
                //     $variant_data_by_product = [];
                //     foreach ($variant_data as $variant_detail) {
                //         $variant_data_by_product[$variant_detail['product_id']][] = $variant_detail;
                //     }

                //     foreach ($data as $key => &$row) {
                //         $row['variants'] = $variant_data_by_product[$row['product_id']] ?? [];
                //     }
                // }

                // Multi Feature
                if (isset($filter['multifeature']) && $filter['multifeature'] == true) {
                    $product_ids = array_unique(array_column($data, 'product_id'));
                    $pvfm = $this->getProductVsFeatureModel();
                    $pvfm->select('product_vs_feature.product_id');
                    $pvfm->autoJoin(true);
                    $pvfm->whereIn('product_vs_feature.product_id', $product_ids);
                    if (isset($filter['ecommerce']) && $filter['ecommerce']) {
                        $pvfm->where('feature.is_active', 1);
                    }
                    $features_data = $pvfm->findAll() ?? [];

                    $features_by_product = [];
                    foreach ($features_data as $feature) {
                        $features_by_product[$feature['product_id']][] = $feature;
                    }

                    foreach ($data as $key => &$row) {
                        $row['features'] = $features_by_product[$row['product_id']] ?? [];
                    }
                }
            }
            return $data;
        } catch (Exception $e) {
            throw $e;
        }
    }
    private function applyProductListingCommonFilter(string $key, array $filter, $is_active_check = false)
    {
        $fieldMap = [
            'product' => ['name' => 'product_name', 'id' => 'product_id'],
            'category_type' => ['name' => 'category_type_name', 'id' => 'category_type_id'],
            'category' => ['name' => 'category_name', 'id' => 'category_id'],
            'brand' => ['name' => 'brand_name', 'id' => 'brand_id'],
            'variant' => ['name' => 'variant_name', 'id' => 'variant_id'],
            'size' => ['name' => 'size_name', 'id' => 'size_id'],
            'color' => ['name' => 'color_name', 'id' => 'color_id'],
            'feature' => ['name' => 'feature_name', 'id' => 'feature_id'],
        ];
        $table_name = $key;
        if ($table_name == 'variant') {
            $table_name = 'product_variant';
        }

        $nameField = $fieldMap[$key]['name'] ?? '';
        $idField = $fieldMap[$key]['id'] ?? '';

        if (isset($filter[$nameField]) && !empty($filter[$nameField])) {
            $this->where("$table_name.$nameField", trim($filter[$nameField]));
        }

        if (isset($filter[$idField]) && !empty($filter[$idField])) {
            $this->where("$table_name.$idField", trim($filter[$idField]));
        }

        if (isset($filter["{$key}_names"]) && is_array($filter["{$key}_names"]) && !empty($filter["{$key}_names"])) {
            $this->whereIn("$table_name.$nameField", $filter["{$key}_names"]);
        }

        if (isset($filter["{$key}_ids"]) && is_array($filter["{$key}_ids"]) && !empty($filter["{$key}_ids"])) {
            $this->whereIn("$table_name.$idField", $filter["{$key}_ids"]);
        }

        if ($is_active_check) {
            $this->where("$table_name.is_active", 1);
        }
    }
    public function addProductDetailPageUrlWithSocialMedia(&$data)
    {
        foreach ($data as $key => &$product) {
            $product_name = $product['product_name'] . " " . $product['variant_name'];
            $varinat_id = $product['variant_id'];
            $message = "";
            $product['product_url'] = $this->getProductDetailPageUrl($varinat_id, false);
            $facebook_share_link = $this->getProductDetailPageUrl($varinat_id, true, 'facebook');
            $twitter_share_link = $this->getProductDetailPageUrl($varinat_id, true, 'twitter');
            $whatsapp_share_link = $this->getProductDetailPageUrl($varinat_id, true, 'whatsapp');
            $other_share_link = $this->getProductDetailPageUrl($varinat_id, true, 'other');
            $product['facebook_url'] = getSocialMediaSharingUrlLink('facebook', $facebook_share_link, $message);
            $product['twitter_url'] = getSocialMediaSharingUrlLink('twitter', $twitter_share_link, $message);
            $product['whatsapp_url'] = getSocialMediaSharingUrlLink('whatsapp', $whatsapp_share_link, $message);
            $product['share_other_url'] = $other_share_link;
        }
    }
    public function getProductDetailPageUrl($variant_id, $product_name = null, $with_domain = false, $refer_source = null)
    {
        $parameter = [];

        // Only pass variant id
        $parameter["pvid"] = $variant_id;

        if (!empty($refer_source)) {
            $parameter["rs"] = $refer_source;
        }

        if (isset($_SESSION['reffer_code']) && !empty($_SESSION['reffer_code'])) {
            $parameter["rc"] = $_SESSION['reffer_code'];
        }

        $parameter_url_string = http_build_query(
            $parameter,
            "",
            "&",
            PHP_QUERY_RFC3986
        );

        $url = "productdetail?" . $parameter_url_string;

        return ($with_domain)
            ? rtrim($_ENV['EcommerceWebsiteDomainUrl'], '/') . '/' . $url
            : $url;
    }
    public function ProductStockList()
    {
        return $this->select([
            'product.product_id',
            'product.product_name',

            'product_variant.variant_id as variant_id',
            'product_variant.variant_name',
            'product_variant.variant_sku_code',

            'stock.stock_id',
            'COALESCE(stock.quantity,0) as quantity',
            'stock.updated_at'
        ])
            ->join('product_variant', 'product_variant.product_id = product.product_id', 'left')
            ->join('stock', 'stock.variant_id = product_variant.variant_id', 'left')
            ->where('product_variant.variant_id IS NOT NULL')
            ->findAll();
    }

    public function getProductsWithOfferFlag($offer_id, $offer_from, $offer_to)
    {
        // Fetch the list of product IDs that are in conflicting offers
        $exclude_product_list = array_column(
            $this->getOfferItemModel()
                ->select('offer_item.product_id')
                ->join('offer', 'offer.offer_id = offer_item.offer_id', 'INNER')
                ->where('offer.offer_id !=', $offer_id)
                ->where('offer.offer_to >=', $offer_to)
                ->where('offer.offer_from <=', $offer_from)
                ->findAll() ?? [],
            'product_id'
        );
        // Build the main query
        $this->autoJoin();
        $this->select('product.product_id, product.product_name');
        $this->select('(CASE WHEN offer_item.product_id IS NOT NULL THEN TRUE ELSE FALSE END) AS item_under_offer_item', false);
        $this->join('offer_item', 'product.product_id = offer_item.product_id AND offer_item.offer_id = ' . $this->db->escape($offer_id), 'left');
        $this->join('offer', 'offer_item.offer_id = offer.offer_id', 'left');

        // Join with variant table to check discount
        $this->join('product_variant', 'product_variant.product_id = product.product_id', 'inner');

        if (!empty($exclude_product_list)) {
            $this->whereNotIn('product.product_id', $exclude_product_list);
        }
        $this->where('product_variant.discount_per', 0);

        // Remove duplicates (since product may have multiple variants)
        $this->groupBy('product.product_id');
        // Correct use of orderBy clause
        $this->orderBy('item_under_offer_item', 'DESC');
        // Execute the query and return results
        return $this->findAll() ?? [];
    }
}
