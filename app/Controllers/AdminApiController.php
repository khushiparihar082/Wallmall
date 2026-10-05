<?php

namespace App\Controllers;

use ApiResponseStatusCode;
use App\Controllers\BaseController;
use App\Models\FunctionModel;
use CodeIgniter\HTTP\Response;
use Exception;
use MediaModuleType;

class AdminApiController extends BaseController
{

    public function handleOptionsRequest()
    {
        return $this->response->setStatusCode(Response::HTTP_OK);
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

            if (!empty($result['data']) && is_array($result['data'])) {

                foreach ($result['data'] as &$row) {

                    if (!empty($row['status_action_id'])) {

                        $user = $this->getUserModel()
                            ->select('fullname')
                            ->where('user_id', $row['status_action_id'])
                            ->first();

                        // ✅ merge fullname into result
                        $row['status_action_name'] = $user['fullname'] ?? null;
                    } else {
                        $row['status_action_name'] = null;
                    }
                }
            }

            return formatApiAutoResponse($this->request, $this->response, $result);
        } catch (Exception $e) {
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::BAD_REQUEST,
                $e->getMessage(),
                []
            );
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
    public function apiCall($url, $method = 'POST', $parameter = [], $header = [])
    {
        log_message('error', $url . ' Start: ' . date('Y-m-d H:i:s'));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->formatHeaders($header));

        if (!empty($parameter)) {
            if ($method === 'GET') {
                curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($parameter));
            } else {
                if (
                    isset($header['Content-Type']) &&
                    str_contains($header['Content-Type'], 'application/json')
                ) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($parameter));
                } else {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameter));
                }
            }
        }


        $response = curl_exec($ch);

        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);

            log_message('error', 'Curl Error: ' . $error);

            return [
                'error' => true,
                'message' => $error
            ];
        }

        curl_close($ch);

        log_message('error', $url . ' End: ' . date('Y-m-d H:i:s'));

        // 🔥 Detect XML response
        if (str_starts_with(trim($response), '<?xml')) {
            $xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
            return json_decode(json_encode($xml), true);
        }

        // Otherwise JSON
        return json_decode($response, true);
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
     * {
     *     "country_name": "required|max_length[100]",
     *     "alias": "max_length[3]",
     *     "short_name": "max_length[2]",
     *     "phonecode": "max_length[255]",
     *     "currency": "max_length[255]",
     *     "currency_name": "max_length[255]",
     *     "currency_symbol": "max_length[255]",
     *     "region": "max_length[255]"
     * } 
     */
    public function CountryCreate()
    {
        return $this->ModelCreate($this->getCountryModel());
    }
    /**
     * {
     *     "country_id": "required",
     *     "country_name": "required|max_length[100]",
     *     "alias": "max_length[3]",
     *     "short_name": "max_length[2]",
     *     "phonecode": "max_length[255]",
     *     "currency": "max_length[255]",
     *     "currency_name": "max_length[255]",
     *     "currency_symbol": "max_length[255]",
     *     "region": "max_length[255]"
     * } 
     */
    public function CountryUpdate()
    {
        return $this->ModelUpdate($this->getCountryModel());
    }
    /**
     * {"country_id":"required"}
     */
    public function CountryDelete()
    {
        return $this->ModelDelete($this->getCountryModel());
    }
    /**
     * {"state_id":"required"}
     */

    // State ----------------------------------------------------------------------------------------------------------

    /** 
     * Get a single state by ID
     * 
     * @return mixed
     */
    public function StateGet()
    {
        return $this->ModelGet($this->getStateModel());
    }

    /** 
     * Get a list of all states
     * 
     * @return mixed
     */
    public function StateList()
    {
        return $this->ModelList($this->getStateModel());
    }

    /** 
     * Create a new state
     * 
     * @return mixed
     */
    public function StateCreate()
    {
        return $this->ModelCreate($this->getStateModel());
    }

    /** 
     * Update an existing state
     * 
     * @return mixed
     */
    public function StateUpdate()
    {
        return $this->ModelUpdate($this->getStateModel());
    }

    /** 
     * Delete an existing state
     * 
     * @return mixed
     */
    public function StateDelete()
    {
        return $this->ModelDelete($this->getStateModel());
    }

    // City -------------------------------------------------------------------------------------------------------

    /** 
     * Get a single city by ID
     * 
     * @return mixed
     */
    public function CityGet()
    {
        return $this->ModelGet($this->getCityModel());
    }

    /** 
     * Get a list of all cities
     * 
     * @return mixed
     */
    public function CityList()
    {
        return $this->ModelList($this->getCityModel());
    }

    /** 
     * Create a new city
     * 
     * @return mixed
     */
    public function CityCreate()
    {
        return $this->ModelCreate($this->getCityModel());
    }

    /** 
     * Update an existing city
     * 
     * @return mixed
     */
    public function CityUpdate()
    {
        return $this->ModelUpdate($this->getCityModel());
    }

    /** 
     * Delete an existing city
     * 
     * @return mixed
     */
    public function CityDelete()
    {
        return $this->ModelDelete($this->getCityModel());
    }

    // Brand -------------------------------------------------------------------------------------------------------

    /** 
     * Get a single brand by ID
     * 
     * @return mixed
     */
    public function BrandGet()
    {
        return $this->ModelGet($this->getBrandModel());
    }

    /** 
     * Get a list of all brands
     * 
     * @return mixed
     */
    public function BrandList()
    {
        return $this->ModelList($this->getBrandModel());
    }



    /** 
     * Create a new brand
     * 
     * @return mixed
     */
    public function BrandCreate()
    {
        return $this->ModelCreate($this->getBrandModel());
    }

    /** 
     * Update an existing brand
     * 
     * @return mixed
     */
    public function BrandUpdate()
    {
        return $this->ModelUpdate($this->getBrandModel());
    }

    /** 
     * Delete an existing brand
     * 
     * @return mixed
     */
    public function BrandDelete()
    {
        return $this->ModelDelete($this->getBrandModel());
    }

    // CategoryType -------------------------------------------------------------------------------------------------------

    /** 
     * Get a single category type by ID
     * 
     * @return mixed
     */
    public function CategoryTypeGet()
    {
        return $this->ModelGet($this->getCategoryTypeModel());
    }

    /** 
     * Get a list of all category types
     * 
     * @return mixed
     */
    public function CategoryTypeList()
    {
        return $this->ModelList($this->getCategoryTypeModel());
    }

    /** 
     * Create a new category type
     * 
     * @return mixed
     */
    public function CategoryTypeCreate()
    {
        return $this->ModelCreate($this->getCategoryTypeModel());
    }

    /** 
     * Update an existing category type
     * 
     * @return mixed
     */
    public function CategoryTypeUpdate()
    {
        return $this->ModelUpdate($this->getCategoryTypeModel());
    }

    /** 
     * Delete an existing category type
     * 
     * @return mixed
     */
    public function CategoryTypeDelete()
    {
        return $this->ModelDelete($this->getCategoryTypeModel());
    }

    // Category -------------------------------------------------------------------------------------------------------

    /** 
     * Get a single category by ID
     * 
     * @return mixed
     */
    public function CategoryGet()
    {
        return $this->ModelGet($this->getCategoryModel());
    }

    /** 
     * Get a list of all categories
     * 
     * @return mixed
     */
    public function CategoryList()
    {
        return $this->ModelList($this->getCategoryModel());
    }

    /** 
     * Create a new category
     * 
     * @return mixed
     */
    public function CategoryCreate()
    {
        return $this->ModelCreate($this->getCategoryModel());
    }

    /** 
     * Update an existing category
     * 
     * @return mixed
     */
    public function CategoryUpdate()
    {
        return $this->ModelUpdate($this->getCategoryModel());
    }

    /** 
     * Delete an existing category
     * 
     * @return mixed
     */
    public function CategoryDelete()
    {
        return $this->ModelDelete($this->getCategoryModel());
    }

    // FeatureType -------------------------------------------------------------------------------------------------------

    /** 
     * Get a single category type by ID
     * 
     * @return mixed
     */
    public function FeatureTypeGet()
    {
        return $this->ModelGet($this->getFeatureTypeModel());
    }

    /** 
     * Get a list of all category types
     * 
     * @return mixed
     */
    public function FeatureTypeList()
    {
        return $this->ModelList($this->getFeatureTypeModel());
    }

    /** 
     * Create a new category type
     * 
     * @return mixed
     */
    public function FeatureTypeCreate()
    {
        return $this->ModelCreate($this->getFeatureTypeModel());
    }

    /** 
     * Update an existing category type
     * 
     * @return mixed
     */
    public function FeatureTypeUpdate()
    {
        return $this->ModelUpdate($this->getFeatureTypeModel());
    }

    /** 
     * Delete an existing category type
     * 
     * @return mixed
     */
    public function FeatureTypeDelete()
    {
        return $this->ModelDelete($this->getFeatureTypeModel());
    }

    // Feature -------------------------------------------------------------------------------------------------------

    /** 
     * Get a single category by ID
     * 
     * @return mixed
     */
    public function FeatureGet()
    {
        return $this->ModelGet($this->getFeatureModel());
    }

    /** 
     * Get a list of all categories
     * 
     * @return mixed
     */
    public function FeatureList()
    {
        return $this->ModelList($this->getFeatureModel());
    }

    /** 
     * Create a new category
     * 
     * @return mixed
     */
    public function FeatureCreate()
    {
        return $this->ModelCreate($this->getFeatureModel());
    }

    /** 
     * Update an existing category
     * 
     * @return mixed
     */
    public function FeatureUpdate()
    {
        return $this->ModelUpdate($this->getFeatureModel());
    }

    /** 
     * Delete an existing category
     * 
     * @return mixed
     */
    public function FeatureDelete()
    {
        return $this->ModelDelete($this->getFeatureModel());
    }



    // Product -------------------------------------------------------------------------------------------------------

    /** 
     * Get a single product by ID
     * 
     * @return mixed
     */
    public function productGet()
    {
        return $this->ModelGet($this->getProductModel());
    }

    /** 
     * Get a list of all products
     * 
     * @return mixed
     */
    public function productList()
    {
        return $this->ModelList($this->getProductModel());
    }

    /** 
     * Create a new product
     * 
     * @return mixed
     */
    public function productCreate()
    {
        $response = [];
        $result = $this->ModelCreate($this->getProductModel(), $response);
        if ($response['status'] == ApiResponseStatusCode::CREATED) {
            if (isset($_POST['features']) && is_array($_POST['features'])) {
                foreach ($_POST['features'] as $key => $feature) {
                    $features_row = [
                        'feature_id' => $feature,
                        'product_id' => $response['data']['product_id']
                    ];
                    $this->getProductVsFeatureModel()->insert($features_row);
                }
            }
        }
        return $result;
    }

    /** 
     * Update an existing product
     * 
     * @return mixed
     */
    public function productUpdate()
    {
        $response = [];
        $result = $this->ModelUpdate($this->getProductModel(), $response);
        if ($response['status'] == ApiResponseStatusCode::OK) {
            $this->getProductVsFeatureModel()->where('product_id', $response['data']['product_id'])->delete();
            if (isset($_POST['features']) && is_array($_POST['features'])) {
                foreach ($_POST['features'] as $key => $feature) {
                    $features_row = [
                        'feature_id' => $feature,
                        'product_id' => $response['data']['product_id']
                    ];
                    $this->getProductVsFeatureModel()->insert($features_row);
                }
            }
        }

        return $result;
    }

    /** 
     * Delete an existing product
     * 
     * @return mixed
     */
    public function productDelete()
    {
        return $this->ModelDelete($this->getProductModel());
    }

    // Variant -------------------------------------------------------------------------------------------------------

    /** 
     * Get a single product variant by ID
     * 
     * @return mixed
     */
    public function variantGet()
    {
        return $this->ModelGet($this->getProductVariantModel());
    }

    /** 
     * Get a list of all product variants
     * 
     * @return mixed
     */
    public function variantList()
    {
        return $this->ModelList($this->getProductVariantModel());
    }
    public function variantCreate()
    {
        $response = [];

        $result = $this->ModelCreate($this->getProductVariantModel(), $response);
        // if ($response['status'] == ApiResponseStatusCode::CREATED) {
        //     $this->getSizeVsVariantModel()->where('variant_id', $response['data']['variant_id'])->delete();
        //     if (isset($_POST['sizes']) && is_array($_POST['sizes'])) {
        //         foreach ($_POST['sizes'] as $key => $size) {
        //             $size_row = [
        //                 'size_id' => $size,
        //                 'variant_id' => $response['data']['variant_id']
        //             ];
        //             $this->getSizeVsVariantModel()->insert($size_row);
        //         }
        //     }
        // }
        if ($response['status'] == ApiResponseStatusCode::CREATED) {

            $data = [
                'variant_id' => $response['data']['variant_id'],
                'quantity'   => $response['data']['minimum_stock'],
            ];

            $stockCreate = $this->getStockModel()->insert($data);
        }

        return $result;
    }
    public function variantUpdate()
    {
        $response = [];
        $result = $this->ModelUpdate($this->getProductVariantModel(), $response);
        // if ($response['status'] == ApiResponseStatusCode::OK) {
        //     $this->getSizeVsVariantModel()->where('variant_id', $response['data']['variant_id'])->delete();
        //     if (isset($_POST['sizes']) && is_array($_POST['sizes'])) {
        //         foreach ($_POST['sizes'] as $key => $size) {
        //             $size_row = [
        //                 'size_id' => $size,
        //                 'variant_id' => $response['data']['variant_id']
        //             ];
        //             $this->getSizeVsVariantModel()->insert($size_row);
        //         }
        //     }
        // }
        return $result;
    }
    public function variantDelete()
    {
        return $this->ModelDelete($this->getProductVariantModel());
    }
    public function calculate_variant()
    {
        $data = getRequestData($this->request, 'ARRAY');
        $result = $this->getProductVariantModel()->calculate_variant(['data' => $data]);
        return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, 'Calculated Successfull', $result['data']);
    }


    public function sizeGet()
    {
        return $this->ModelGet($this->getSizeModel());
    }

    public function sizeList()
    {
        return $this->ModelList($this->getSizeModel());
    }

    public function sizeCreate()
    {
        return $this->ModelCreate($this->getSizeModel());
    }
    public function sizeUpdate()
    {
        return $this->ModelUpdate($this->getSizeModel());
    }
    public function sizeDelete()
    {
        return $this->ModelDelete($this->getSizeModel());
    }

    public function unitGet()
    {
        return $this->ModelGet($this->getUnitModel());
    }

    public function unitList()
    {
        return $this->ModelList($this->getUnitModel());
    }

    public function unitCreate()
    {
        return $this->ModelCreate($this->getUnitModel());
    }
    public function unitUpdate()
    {
        return $this->ModelUpdate($this->getUnitModel());
    }
    public function unitDelete()
    {
        return $this->ModelDelete($this->getUnitModel());
    }


    // color ------------------------------------------------------------------------------

    public function colorGet()
    {
        return $this->ModelGet($this->getColorModel());
    }

    public function colorList()
    {
        return $this->ModelList($this->getColorModel());
    }

    public function colorCreate()
    {
        return $this->ModelCreate($this->getColorModel());
    }
    public function colorUpdate()
    {
        return $this->ModelUpdate($this->getColorModel());
    }
    public function colorDelete()
    {
        return $this->ModelDelete($this->getColorModel());
    }

    // stock ------------------------------------------------------------------------------

    public function stockGet()
    {
        return $this->ModelGet($this->getStockModel());
    }

    public function stockList()
    {
        return $this->ModelList($this->getStockModel());
    }
    public function ProductWiseStockList()
    {
        $data = $this->getProductModel()->ProductStockList() ?? [];
        return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, 'Calculated Successfull', $data);
    }

    public function stockCreate()
    {
        return $this->ModelCreate($this->getStockModel());
    }
    public function stockUpdate()
    {
        return $this->ModelUpdate($this->getStockModel());
    }
    public function stockDeleteCreate()
    {
        $data = getRequestData($this->request, 'ARRAY');
        $this->getStockModel()->where('variant_id', $data['variant_id'])->delete();
        $result = $this->getStockModel()->RecordCreate($data);
        if ($result['status'] == ApiResponseStatusCode::CREATED) {
            return formatApiAutoResponse($this->request, $this->response, $result);
        } else {
            return formatApiAutoResponse($this->request, $this->response, $result);
        }
    }
    public function stockDelete()
    {
        return $this->ModelDelete($this->getStockModel());
    }

    // Offers ------------------------------------------------------------------------------

    public function offerGet()
    {
        return $this->ModelGet($this->getOfferModel());
    }

    public function offerList()
    {
        return $this->ModelList($this->getOfferModel());
    }

    public function offerCreate()
    {

        return $this->ModelCreate($this->getOfferModel(), $response);
    }
    public function offerUpdate()
    {
        return $this->ModelUpdate($this->getOfferModel(), $response);
    }
    public function offerDelete()
    {
        return $this->ModelDelete($this->getOfferModel());
    }

    // Offers Item ------------------------------------------------------------------------------

    public function offerItemGet()
    {
        return $this->ModelGet($this->getOfferItemModel());
    }

    public function offerItemList()
    {
        return $this->ModelList($this->getOfferItemModel());
    }

    public function offerItemCreate()
    {
        return $this->ModelCreate($this->getOfferItemModel());
    }
    public function offerItemUpdate()
    {
        return $this->ModelUpdate($this->getOfferItemModel());
    }
    public function offerItemDelete()
    {

        return $this->ModelDelete($this->getOfferItemModel());
    }

    public function offer_item_list_for_create_update()
    {
        $parameters = getRequestData($this->request, 'ARRAY') ?? [];
        $offerItemModel = $this->getOfferItemModel();
        $existingOfferItems = $offerItemModel->findAll();
        $existingVariantIds = array_map(function ($item) {
            return $item['product_id'];
        }, $existingOfferItems);
        $data = $this->getProductModel()->product_listing($parameters) ?? [];
        $filteredData = array_filter($data, function ($product) use ($existingVariantIds) {
            return !in_array($product['product_id'], $existingVariantIds);
        });

        return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, 'Record Found', array_values($filteredData));
    }


    // Coupon ------------------------------------------------------------------------------

    public function CouponGet()
    {
        return $this->ModelGet($this->getCouponModel());
    }

    public function CouponList()
    {
        return $this->ModelList($this->getCouponModel());
    }

    public function CouponCreate()
    {
        return $this->ModelCreate($this->getCouponModel());
    }
    public function CouponUpdate()
    {
        return $this->ModelUpdate($this->getCouponModel());
    }
    public function CouponDelete()
    {
        return $this->ModelDelete($this->getCouponModel());
    }


    // blog ------------------------------------------------------------------------------

    public function blogPostGet()
    {
        return $this->ModelGet($this->getBlogPostModel());
    }

    public function blogPostList()
    {
        return $this->ModelList($this->getBlogPostModel());
    }

    public function blogPostCreate()
    {
        return $this->ModelCreate($this->getBlogPostModel());
    }
    public function blogPostUpdate()
    {
        return $this->ModelUpdate($this->getBlogPostModel());
    }
    public function blogPostDelete()
    {
        return $this->ModelDelete($this->getBlogPostModel());
    }

    // subscriber ------------------------------------------------------------------------------

    public function subscriberGet()
    {
        return $this->ModelGet($this->getSubscribersListModel());
    }

    public function subscriberList()
    {
        return $this->ModelList($this->getSubscribersListModel());
    }
    // Review ------------------------------------------------------------------------------

    public function reviewGet()
    {
        return $this->ModelGet($this->getCustomerReviewModel());
    }

    public function reviewList()
    {
        return $this->ModelList($this->getCustomerReviewModel());
    }
    public function reviewUpdate()
    {
        return $this->ModelUpdate($this->getCustomerReviewModel());
    }

    // Wishlist ------------------------------------------------------------------------------

    public function wishlistGet()
    {
        return $this->ModelGet($this->getCustomerWishlistModel());
    }

    public function wishlistList()
    {
        return $this->ModelList($this->getCustomerWishlistModel());
    }
    public function wishlistUpdate()
    {
        return $this->ModelUpdate($this->getCustomerWishlistModel());
    }
    public function wishlistDelete()
    {
        return $this->ModelDelete($this->getCustomerWishlistModel());
    }


    // Cart ------------------------------------------------------------------------------

    public function cartGet()
    {
        return $this->ModelGet($this->getCustomerCartModel());
    }

    public function cartList()
    {
        return $this->ModelList($this->getCustomerCartModel());
    }
    public function cartUpdate()
    {
        return $this->ModelUpdate($this->getCustomerCartModel());
    }
    public function cartDelete()
    {
        return $this->ModelDelete($this->getCustomerCartModel());
    }

    // FAQ ------------------------------------------------------------------------------

    public function faqGet()
    {
        return $this->ModelGet($this->getFaqModel());
    }

    public function faqList()
    {
        return $this->ModelList($this->getFaqModel());
    }
    public function faqUpdate()
    {
        return $this->ModelUpdate($this->getFaqModel());
    }
    public function faqDelete()
    {
        return $this->ModelDelete($this->getFaqModel());
    }
    public function faqCreate()
    {
        return $this->ModelCreate($this->getFaqModel());
    }


    // Enquire Api Form Submission

    // blog ------------------------------------------------------------------------------

    public function FormSubmissionsList()
    {
        return $this->ModelList($this->getFormSubmissionsModel());
    }
    public function FormSubmissionsUpdate()
    {
        return $this->ModelUpdate($this->getFormSubmissionsModel());
    }


    public function ContactList()
    {
        return $this->ModelList($this->getContactUsModel());
    }
    public function ContactUpdate()
    {
        return $this->ModelUpdate($this->getContactUsModel());
    }

    // Website Profile ------------------------------------------------------------------------------

    public function WebsiteProfileCreate()
    {
        return $this->ModelCreate($this->getWebsiteProfileModel());
    }

    public function WebsiteProfileUpdate()
    {
        return $this->ModelUpdate($this->getWebsiteProfileModel());
    }


    // Customer  ------------------------------------------------------------------------------

    public function customerGet()
    {
        return $this->ModelGet($this->getCustomerModel());
    }

    public function customerList()
    {
        return $this->ModelList($this->getCustomerModel());
    }

    public function customerCreate()
    {
        return $this->ModelCreate($this->getCustomerModel());
    }

    public function customerUpdate()
    {
        return $this->ModelUpdate($this->getCustomerModel());
    }

    public function customerDelete()
    {
        return $this->ModelDelete($this->getCustomerModel());
    }

    // Order  ------------------------------------------------------------------------------

    public function orderGet()
    {
        return $this->ModelGet($this->getOrderModel());
    }

    public function orderList()
    {
        return $this->ModelList($this->getOrderModel());
    }

    public function orderCreate()
    {
        return $this->ModelCreate($this->getOrderModel());
    }

    public function orderUpdate()
    {
        return $this->ModelUpdate($this->getOrderModel());
    }

    public function orderDelete()
    {
        return $this->ModelDelete($this->getOrderModel());
    }

    public function downloadInvoice()
    {
        $parameter = $this->request->getGet() ?? [];
        if (!isset($parameter['order_id'])) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, "Order ID Required");
        }
        // Fetch order details based on order_id
        $OrderModel = $this->getOrderModel();
        $filter = [
            '_autojoin' => 'Y',
            '_select' => '*',
            'order_id' => $parameter['order_id']
        ];
        // $order_id = $data['order_id'];
        $order = $OrderModel->GetAllOrdersWithItems($filter, true, [
            'order_delivered',
            'order_exchanged',
        ]);

        // Prepare response data
        $response_data = [
            'orderDetails' => $order,
        ];
        log_message('debug', 'Order Data: ' . print_r($order, true));

        // Load the HTML view for the invoice and pass the data
        $html = view('AdminPanelNew/pages/finance/invoice', $response_data);

        // Create an instance of mPDF
        $mpdf = new \Mpdf\Mpdf();

        // Write the HTML to the PDF
        $mpdf->WriteHTML($html);

        // Define the path to the public/invoice folder
        $invoiceFolder = FCPATH . 'invoice/';

        // Check if the invoice folder exists, if not, create it
        if (!is_dir($invoiceFolder)) {
            mkdir($invoiceFolder, 0755, true); // Create the folder with necessary permissions
        }

        // Define the path where the PDF should be saved
        $savePath = $invoiceFolder . 'invoice_' . $parameter['order_id'] . '.pdf';

        // Save the PDF to the specified path
        $mpdf->Output($savePath, \Mpdf\Output\Destination::FILE); // Save file locally

        // After saving, redirect to open the saved file in a new window
        return redirect()->to(base_url('invoice/invoice_' . $parameter['order_id'] . '.pdf')); // Open PDF in new window
    }


    public function orderStatusChange()
    {
        $message = "";
        $data = getRequestData($this->request, "ARRAY");
        if (!isset($data['log_remark']) || empty($data['log_remark'])) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, "Remark is required");
        }
        // Update Order Status
        $order_data = $this->getOrderModel()->autoJoin(false)->select('order.*')->where('order.order_id', $data['order_id'])->first();
        $email = $this->getEmailController();
        $sms = $this->getSmsController();
        $order_link = "https://hillmen.brillsense.com/orderDetails/" . $order_data['order_id'];

        $validation = \Config\Services::validation();

        switch ($data['order_status']) {
            case 'order_payment_pending':
                // Handle payment pending
                $order_response = $this->getOrderModel()->RecordUpdate($data, $data['order_id']);
                if ($order_response['status'] != ApiResponseStatusCode::OK) {
                    $order_response['message'] = "Unable To Change Order Status";
                    return formatApiAutoResponse($this->request, $this->response, $order_response);
                }

                $order_log_response = $this->getOrderLogModel()->RecordCreate($data);
                if ($order_log_response['status'] != ApiResponseStatusCode::CREATED) {
                    $order_log_response['message'] = "Unable To Create Order Log";
                    return formatApiAutoResponse($this->request, $this->response, $order_log_response);
                }

                $message = "Payment is pending.";
                break;

            case 'order_payment_processing':
                // Handle payment processing
                $order_response = $this->getOrderModel()->RecordUpdate($data, $data['order_id']);
                if ($order_response['status'] != ApiResponseStatusCode::OK) {
                    $order_response['message'] = "Unable To Change Order Status";
                    return formatApiAutoResponse($this->request, $this->response, $order_response);
                }

                $order_log_response = $this->getOrderLogModel()->RecordCreate($data);
                if ($order_log_response['status'] != ApiResponseStatusCode::CREATED) {
                    $order_log_response['message'] = "Unable To Create Order Log";
                    return formatApiAutoResponse($this->request, $this->response, $order_log_response);
                }

                $message = "Payment is processing.";
                break;

            case 'order_payment_success':
                // Validate before updating status and logs
                $validation->setRules([
                    'log_remark' => [
                        'label'  => 'log_remark',
                        'rules'  => 'required',
                        'errors' => ['required' => 'log_remark is required'],
                    ],
                ]);

                if ($validation->run($data) === false) {
                    return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Validation Failed', [], $validation->getErrors());
                }

                // Update order and create logs only if validation passes
                $order_response = $this->getOrderModel()->RecordUpdate($data, $data['order_id']);
                if ($order_response['status'] != ApiResponseStatusCode::OK) {
                    $order_response['message'] = "Unable To Change Order Status";
                    return formatApiAutoResponse($this->request, $this->response, $order_response);
                }

                $order_log_response = $this->getOrderLogModel()->RecordCreate($data);
                if ($order_log_response['status'] != ApiResponseStatusCode::CREATED) {
                    $order_log_response['message'] = "Unable To Create Order Log";
                    return formatApiAutoResponse($this->request, $this->response, $order_log_response);
                }

                $message = "Order Status Change Successfully";
                break;

            case 'order_payment_fail':
                // Handle payment failure
                $order_response = $this->getOrderModel()->RecordUpdate($data, $data['order_id']);
                if ($order_response['status'] != ApiResponseStatusCode::OK) {
                    $order_response['message'] = "Unable To Change Order Status";
                    return formatApiAutoResponse($this->request, $this->response, $order_response);
                }

                $order_log_response = $this->getOrderLogModel()->RecordCreate($data);
                if ($order_log_response['status'] != ApiResponseStatusCode::CREATED) {
                    $order_log_response['message'] = "Unable To Create Order Log";
                    return formatApiAutoResponse($this->request, $this->response, $order_log_response);
                }

                $email_send = $email->payment_failure($order_data['mobile'], $order_data['fullname'], $order_data['order_number'], 'order_link');
                $sms_send = $sms->payment_failure($order_data['mobile'], $order_data['fullname'], $order_data['order_number'], 'order_link');

                $message = "Payment Failed";
                break;

            case 'order_payment_verified_manual':
            case 'order_payment_verified_razorpay':
                // Validate before updating status and logs
                $validation->setRules([
                    'log_remark' => [
                        'label'  => 'log_remark',
                        'rules'  => 'required',
                        'errors' => ['required' => 'log_remark is required'],
                    ],
                ]);

                if ($validation->run($data) === false) {
                    return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Validation Failed', [], $validation->getErrors());
                }

                // Update order and create logs only if validation passes
                $order_response = $this->getOrderModel()->RecordUpdate($data, $data['order_id']);
                if ($order_response['status'] != ApiResponseStatusCode::OK) {
                    $order_response['message'] = "Unable To Change Order Status";
                    return formatApiAutoResponse($this->request, $this->response, $order_response);
                }

                $order_log_response = $this->getOrderLogModel()->RecordCreate($data);
                if ($order_log_response['status'] != ApiResponseStatusCode::CREATED) {
                    $order_log_response['message'] = "Unable To Create Order Log";
                    return formatApiAutoResponse($this->request, $this->response, $order_log_response);
                }

                $message = ($data['order_status'] === 'order_payment_verified_manual')
                    ? "Payment verified manually."
                    : "Payment verified through Razorpay.";
                break;

            case 'order_accepted':
                // Validate the request before proceeding
                $validation = \Config\Services::validation();
                $validation->setRules([
                    'log_remark' => [
                        'label'  => 'log_remark',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'log_remark is required',
                        ],
                    ],
                ]);

                // Validate requested data against defined rules
                if ($validation->run($data) === false) {
                    // Return validation failed response
                    return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Validation Failed', [], $validation->getErrors());
                }

                // Handle the case when the order is accepted
                $order_response = $this->getOrderModel()->RecordUpdate($data, $data['order_id']);
                if ($order_response['status'] != ApiResponseStatusCode::OK) {
                    $order_response['message'] = "Unable To Change Order Status";
                    return formatApiAutoResponse($this->request, $this->response, $order_response);
                }

                $order_log_response = $this->getOrderLogModel()->RecordCreate($data);
                if ($order_log_response['status'] != ApiResponseStatusCode::CREATED) {
                    $order_log_response['message'] = "Unable To Create Order Log";
                    return formatApiAutoResponse($this->request, $this->response, $order_log_response);
                }

                // Send email and SMS notifications
                $email_send = $email->order_confirmation_successfully(
                    $order_data['email'],
                    $order_data['fullname'],
                    $order_data['order_number'],
                    $order_data['order_date'],
                    $order_data['order_total'],
                    $order_link
                );

                $sms_send = $sms->order_confirmation_successfully(
                    $order_data['mobile'] ?? '',
                    $order_data['fullname'] ?? '',
                    $order_data['order_number'] ?? '',
                    $order_data['order_date'] ?? '',
                    $order_data['order_total'] ?? '',
                    $order_link
                );

                $message = "Order accepted.";
                break;

            case 'order_ready_to_ship':
                // Validate the request before proceeding
                $validation = \Config\Services::validation();
                $validation->setRules([
                    'log_remark' => [
                        'label'  => 'log_remark',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'log_remark is required',
                        ],
                    ],
                ]);

                // Validate requested data against defined rules
                if ($validation->run($data) === false) {
                    // Return validation failed response
                    return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Validation Failed', [], $validation->getErrors());
                }

                // Handle the case when the order is ready to ship
                $order_response = $this->getOrderModel()->RecordUpdate($data, $data['order_id']);
                if ($order_response['status'] != ApiResponseStatusCode::OK) {
                    $order_response['message'] = "Unable To Change Order Status";
                    return formatApiAutoResponse($this->request, $this->response, $order_response);
                }

                $order_log_response = $this->getOrderLogModel()->RecordCreate($data);
                if ($order_log_response['status'] != ApiResponseStatusCode::CREATED) {
                    $order_log_response['message'] = "Unable To Create Order Log";
                    return formatApiAutoResponse($this->request, $this->response, $order_log_response);
                }

                $message = "Order is ready to ship.";
                break;
            case 'order_shipped':
                // Validate the request before proceeding
                $validation = \Config\Services::validation();
                $validation->setRules([
                    'docket_number' => [
                        'label'  => 'docket_number',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'docket_number is required',
                        ],
                    ],
                    'order_shipping_company_name' => [
                        'label'  => 'order_shipping_company_name',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'order_shipping_company_name is required',
                        ],
                    ],
                    'order_delivery_expected_date' => [
                        'label'  => 'order_delivery_expected_date',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'order_delivery_expected_date is required',
                        ],
                    ],
                    'log_remark' => [
                        'label'  => 'log_remark',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'log_remark is required',
                        ],
                    ],
                ]);

                // Validate requested data against defined rules
                if ($validation->run($data) === false) {
                    return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Validation Failed', [], $validation->getErrors());
                }

                // Update the order
                $order_response = $this->getOrderModel()->RecordUpdate($data, $data['order_id']);
                if ($order_response['status'] != ApiResponseStatusCode::OK) {
                    $order_response['message'] = "Unable To Change Order Status";
                    return formatApiAutoResponse($this->request, $this->response, $order_response);
                }

                // Create order log
                $order_log_response = $this->getOrderLogModel()->RecordCreate($data);
                if ($order_log_response['status'] != ApiResponseStatusCode::CREATED) {
                    $order_log_response['message'] = "Unable To Create Order Log";
                    return formatApiAutoResponse($this->request, $this->response, $order_log_response);
                }

                $email_send = $email->order_shipped_successfully(
                    $order_data['email'],
                    $order_data['fullname'],
                    $order_data['order_number'],
                    $order_data['tracking_link'] ?? '',
                    $order_data['docket_number'],
                    $order_data['carrier_name'] ?? '',
                    $order_data['order_delivery_expected_date']
                );
                $sms_send = $sms->order_shipped_successfully(
                    $order_data['mobile'] ?? '',
                    $order_data['fullname'] ?? '',
                    $order_data['order_number'] ?? '',
                    $order_data['tracking_link'] ?? '',
                    $order_data['docket_number'] ?? '',
                    $order_data['carrier_name'] ?? '',
                    $order_data['order_delivery_expected_date'] ?? '',
                );

                $message = "Order has been shipped.";
                break;


            case 'order_exchange_shipped':
                // Validate the request before proceeding
                $validation = \Config\Services::validation();
                $validation->setRules([
                    'docket_number' => [
                        'label'  => 'docket_number',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'docket_number is required',
                        ],
                    ],
                    'order_shipping_company_name' => [
                        'label'  => 'order_shipping_company_name',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'order_shipping_company_name is required',
                        ],
                    ],
                    'order_delivery_expected_date' => [
                        'label'  => 'order_delivery_expected_date',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'order_delivery_expected_date is required',
                        ],
                    ],
                    'log_remark' => [
                        'label'  => 'log_remark',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'log_remark is required',
                        ],
                    ],
                ]);

                // Validate requested data against defined rules
                if ($validation->run($data) === false) {
                    return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Validation Failed', [], $validation->getErrors());
                }

                // Update the order and create logs
                $order_response = $this->getOrderModel()->RecordUpdate($data, $data['order_id']);
                if ($order_response['status'] != ApiResponseStatusCode::OK) {
                    $order_response['message'] = "Unable To Change Order Status";
                    return formatApiAutoResponse($this->request, $this->response, $order_response);
                }

                $order_log_response = $this->getOrderLogModel()->RecordCreate($data);
                if ($order_log_response['status'] != ApiResponseStatusCode::CREATED) {
                    $order_log_response['message'] = "Unable To Create Order Log";
                    return formatApiAutoResponse($this->request, $this->response, $order_log_response);
                }
                $email_send = $email->order_shipped_successfully(
                    $order_data['mobile'] ?? '',
                    $order_data['fullname'] ?? '',
                    $order_data['order_number'] ?? '',
                    $order_data['tracking_link'] ?? '',
                    $order_data['docket_number'],
                    $order_data['carrier_name'] ?? '',
                    $order_data['order_delivery_expected_date'] ?? '',
                );
                $sms_send = $sms->order_shipped_successfully(
                    $order_data['mobile'] ?? '',
                    $order_data['fullname'] ?? '',
                    $order_data['order_number'] ?? '',
                    $order_data['tracking_link'] ?? '',
                    $order_data['docket_number'],
                    $order_data['carrier_name'] ?? '',
                    $order_data['order_delivery_expected_date'] ?? '',
                );


                $message = "Exchange order has been shipped.";
                break;

            case 'order_delivered':
                // ✅ Validate the request before proceeding
                $validation = \Config\Services::validation();
                $validation->setRules([
                    'order_delivered_date' => [
                        'label'  => 'order_delivered_date',
                        'rules'  => 'required',
                        'errors' => ['required' => 'order_delivered_date is required'],
                    ],
                    'log_remark' => [
                        'label'  => 'log_remark',
                        'rules'  => 'required',
                        'errors' => ['required' => 'log_remark is required'],
                    ],
                    'remaining_total' => [
                        'label'  => 'remaining_total',
                        'rules'  => 'required|decimal',
                        'errors' => ['required' => 'remaining_total is required'],
                    ],
                ]);

                if ($validation->run($data) === false) {
                    return formatApiResponse(
                        $this->request,
                        $this->response,
                        ApiResponseStatusCode::VALIDATION_FAILED,
                        'Validation Failed',
                        [],
                        $validation->getErrors()
                    );
                }

                // ✅ Get current order details
                $order = $this->getOrderModel()
                    ->select('remaining_total,order_number, customer_id,payment_mode,order_total')
                    ->find($data['order_id']);

                if (!$order) {
                    return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::NOT_FOUND, 'Order not found');
                }

                // ✅ Calculate new remaining total
                $existingRemaining = (float)$order['remaining_total'];
                $inputRemaining = (float)$data['remaining_total'];
                $newRemaining = max(0, $existingRemaining - $inputRemaining); // prevent negative

                // ✅ Update order data
                $updateData = [
                    'order_id' => $data['order_id'],
                    'order_status' => 'order_delivered',
                    'order_delivered_date' => $data['order_delivered_date'],
                    'log_remark' => $data['log_remark'],
                    'remaining_total' => $newRemaining,
                    'status_action_date' => $data['status_action_date'],
                    'status_action_id' => $data['status_action_id'],
                ];

                $order_response = $this->getOrderModel()->RecordUpdate($updateData, $data['order_id']);
                if ($order_response['status'] != ApiResponseStatusCode::OK) {
                    $order_response['message'] = "Unable To Change Order Status";
                    return formatApiAutoResponse($this->request, $this->response, $order_response);
                }

                // create order payment data
                if ($order['payment_mode'] === 'COD') {
                    $paymentData = [
                        'order_id'            => (int)$data['order_id'],
                        'payment_mode'        => $order['payment_mode'],
                        'payment_status'      => 'Success',
                        'payment_amt'         => $data['remaining_total'], // amount collected during delivery
                        'order_total'         => $order['order_total'],
                        'payment_remark'      => $data['log_remark'],
                        'razorpay_payment_id' => null,
                        'razorpay_signature'  => null,
                        'created_at'          => date('Y-m-d H:i:s')
                    ];

                    $payment_response = $this->getOrderPaymentModel()->RecordCreate($paymentData);

                    if ($payment_response['status'] != ApiResponseStatusCode::CREATED) {
                        return formatApiAutoResponse($this->request, $this->response, [
                            'status' => ApiResponseStatusCode::BAD_REQUEST,
                            'message' => 'Failed to create COD payment record',
                        ]);
                    }
                }
                // ✅ Create log entry
                $order_log_response = $this->getOrderLogModel()->RecordCreate($updateData);
                if ($order_log_response['status'] != ApiResponseStatusCode::CREATED) {
                    $order_log_response['message'] = "Unable To Create Order Log";
                    return formatApiAutoResponse($this->request, $this->response, $order_log_response);
                }

                // Send email and SMS notifications
                $email_send = $email->delivery_confirmation_successfully(
                    $order_data['email'],
                    $order_data['fullname'],
                    $order_data['order_number']
                );
                $sms_send = $sms->delivery_confirmation_successfully(
                    $order_data['mobile'] ?? '',
                    $order_data['fullname'] ?? '',
                    $order_data['order_number'] ?? '',
                );
                // SMS notifications
                // $this->getCouponModel()->generateReferCoupon($order_data['customer_id'], 'after_delivered');
                $message = "Order delivered.";
                break;


            case 'order_not_delivered':
                // Validate the request before proceeding
                $validation = \Config\Services::validation();
                $validation->setRules([
                    'log_remark' => [
                        'label'  => 'log_remark',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'log_remark is required',
                        ],
                    ],
                ]);

                // Validate requested data against defined rules
                if ($validation->run($data) === false) {
                    return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Validation Failed', [], $validation->getErrors());
                }

                // Update the order and create logs
                $order_response = $this->getOrderModel()->RecordUpdate($data, $data['order_id']);
                if ($order_response['status'] != ApiResponseStatusCode::OK) {
                    $order_response['message'] = "Unable To Change Order Status";
                    return formatApiAutoResponse($this->request, $this->response, $order_response);
                }

                $order_log_response = $this->getOrderLogModel()->RecordCreate($data);
                if ($order_log_response['status'] != ApiResponseStatusCode::CREATED) {
                    $order_log_response['message'] = "Unable To Create Order Log";
                    return formatApiAutoResponse($this->request, $this->response, $order_log_response);
                }

                $message = "Order not delivered.";
                break;


            case 'order_exchanged':
                // Validate the request before proceeding
                $validation = \Config\Services::validation();
                $validation->setRules([
                    'log_remark' => [
                        'label'  => 'log_remark',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'log_remark is required',
                        ],
                    ],
                ]);

                // Validate requested data against defined rules
                if ($validation->run($data) === false) {
                    return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Validation Failed', [], $validation->getErrors());
                }

                // Update the order and create logs
                $order_response = $this->getOrderModel()->RecordUpdate($data, $data['order_id']);
                if ($order_response['status'] != ApiResponseStatusCode::OK) {
                    $order_response['message'] = "Unable To Change Order Status";
                    return formatApiAutoResponse($this->request, $this->response, $order_response);
                }

                $order_log_response = $this->getOrderLogModel()->RecordCreate($data);
                if ($order_log_response['status'] != ApiResponseStatusCode::CREATED) {
                    $order_log_response['message'] = "Unable To Create Order Log";
                    return formatApiAutoResponse($this->request, $this->response, $order_log_response);
                }
                // Send email and SMS notifications
                $email_send = $email->delivery_confirmation_successfully(
                    $order_data['mobile'],
                    $order_data['fullname'],
                    $order_data['order_number']
                );
                $sms_send = $sms->delivery_confirmation_successfully(
                    $order_data['mobile'] ?? '',
                    $order_data['fullname'] ?? '',
                    $order_data['order_number'] ?? '',
                );
                $message = "Order has been exchanged.";
                break;

            case 'refund_request':
                // Validate the request before proceeding
                $validation = \Config\Services::validation();
                $validation->setRules([
                    'log_remark' => [
                        'label'  => 'log_remark',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'log_remark is required',
                        ],
                    ],
                ]);

                // Validate requested data against defined rules
                if ($validation->run($data) === false) {
                    return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Validation Failed', [], $validation->getErrors());
                }

                // Update the order and create logs
                $order_response = $this->getOrderModel()->RecordUpdate($data, $data['order_id']);
                if ($order_response['status'] != ApiResponseStatusCode::OK) {
                    $order_response['message'] = "Unable To Change Order Status";
                    return formatApiAutoResponse($this->request, $this->response, $order_response);
                }

                $order_log_response = $this->getOrderLogModel()->RecordCreate($data);
                if ($order_log_response['status'] != ApiResponseStatusCode::CREATED) {
                    $order_log_response['message'] = "Unable To Create Order Log";
                    return formatApiAutoResponse($this->request, $this->response, $order_log_response);
                }

                $message = "Refund request received.";
                break;

            case 'return_request':
                // Validate the request before proceeding
                $validation = \Config\Services::validation();
                $validation->setRules([
                    'log_remark' => [
                        'label'  => 'log_remark',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'log_remark is required',
                        ],
                    ],
                ]);

                // Validate requested data against defined rules
                if ($validation->run($data) === false) {
                    return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Validation Failed', [], $validation->getErrors());
                }
                // Prepare data for order item update
                $data['exchange_qty'] = null; // Set exchange_qty to null
                $data['refund_amount'] = null; // Set refund_amount to null
                // Update the order and create logs
                $order_response = $this->getOrderModel()->RecordUpdate($data, $data['order_id']);
                if ($order_response['status'] != ApiResponseStatusCode::OK) {
                    $order_response['message'] = "Unable To Change Order Status";
                    return formatApiAutoResponse($this->request, $this->response, $order_response);
                }

                $order_log_response = $this->getOrderLogModel()->RecordCreate($data);
                if ($order_log_response['status'] != ApiResponseStatusCode::CREATED) {
                    $order_log_response['message'] = "Unable To Create Order Log";
                    return formatApiAutoResponse($this->request, $this->response, $order_log_response);
                }

                $message = "Return request received.";
                break;

            case 'exchange_request':
                // Validate the request before proceeding
                $validation = \Config\Services::validation();
                $validation->setRules([
                    'log_remark' => [
                        'label'  => 'log_remark',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'log_remark is required',
                        ],
                    ],
                ]);

                // Validate requested data against defined rules
                if ($validation->run($data) === false) {
                    return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Validation Failed', [], $validation->getErrors());
                }

                // Update the order and create logs
                $order_response = $this->getOrderModel()->RecordUpdate($data, $data['order_id']);
                if ($order_response['status'] != ApiResponseStatusCode::OK) {
                    $order_response['message'] = "Unable To Change Order Status";
                    return formatApiAutoResponse($this->request, $this->response, $order_response);
                }

                $order_log_response = $this->getOrderLogModel()->RecordCreate($data);
                if ($order_log_response['status'] != ApiResponseStatusCode::CREATED) {
                    $order_log_response['message'] = "Unable To Create Order Log";
                    return formatApiAutoResponse($this->request, $this->response, $order_log_response);
                }

                $message = "Exchange request received.";
                break;


            case 'request_return_rejected':
                // Validate the request before proceeding
                $validation = \Config\Services::validation();
                $validation->setRules([
                    'log_remark' => [
                        'label'  => 'log_remark',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'log_remark is required',
                        ],
                    ],
                ]);

                // Validate requested data against defined rules
                if ($validation->run($data) === false) {
                    return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Validation Failed', [], $validation->getErrors());
                }

                // Update the order and create logs
                $order_response = $this->getOrderModel()->RecordUpdate($data, $data['order_id']);
                $order_item_data = $this->getOrderItemModel()->select('order_item_id')->where('order_id', $data['order_id'])->findAll(); // Make sure to fetch based on order_id
                $order_item_ids = array_column($order_item_data, 'order_item_id');

                // Set return_qty and refund_amount to zero
                if (!empty($order_item_ids)) {
                    $this->getOrderItemModel()->update($order_item_ids, [
                        'return_qty' => 0,
                        'refund_amount' => 0
                    ]);
                }

                if ($order_response['status'] != ApiResponseStatusCode::OK) {
                    $order_response['message'] = "Unable To Change Order Status";
                    return formatApiAutoResponse($this->request, $this->response, $order_response);
                }


                $order_log_response = $this->getOrderLogModel()->RecordCreate($data);
                if ($order_log_response['status'] != ApiResponseStatusCode::CREATED) {
                    $order_log_response['message'] = "Unable To Create Order Log";
                    return formatApiAutoResponse($this->request, $this->response, $order_log_response);
                }

                $message = "Return request rejected.";
                break;

            case 'request_exchange_rejected':
                // Validate the request before proceeding
                $validation = \Config\Services::validation();
                $validation->setRules([
                    'log_remark' => [
                        'label'  => 'log_remark',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'log_remark is required',
                        ],
                    ],
                ]);

                // Validate requested data against defined rules
                if ($validation->run($data) === false) {
                    return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Validation Failed', [], $validation->getErrors());
                }

                $order_response = $this->getOrderModel()->RecordUpdate($data, $data['order_id']);
                $order_item_data = $this->getOrderItemModel()->select('order_item_id')->where('order_id', $data['order_id'])->findAll(); // Make sure to fetch based on order_id
                $order_item_ids = array_column($order_item_data, 'order_item_id');

                // Set return_qty and refund_amount to zero
                if (!empty($order_item_ids)) {
                    $this->getOrderItemModel()->update($order_item_ids, [
                        'exchange_qty' => 0
                    ]);
                }

                if ($order_response['status'] != ApiResponseStatusCode::OK) {
                    $order_response['message'] = "Unable To Change Order Status";
                    return formatApiAutoResponse($this->request, $this->response, $order_response);
                }


                $order_log_response = $this->getOrderLogModel()->RecordCreate($data);
                if ($order_log_response['status'] != ApiResponseStatusCode::CREATED) {
                    $order_log_response['message'] = "Unable To Create Order Log";
                    return formatApiAutoResponse($this->request, $this->response, $order_log_response);
                }

                $message = "Exchange request rejected.";
                break;

            case 'request_refund_approved':
                // Validate the request before proceeding
                $validation = \Config\Services::validation();
                $validation->setRules([
                    'log_remark' => [
                        'label'  => 'log_remark',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'log_remark is required',
                        ],
                    ],
                ]);

                // Validate requested data against defined rules
                if ($validation->run($data) === false) {
                    return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Validation Failed', [], $validation->getErrors());
                }

                // Update the order and create logs
                $order_response = $this->getOrderModel()->RecordUpdate($data, $data['order_id']);
                if ($order_response['status'] != ApiResponseStatusCode::OK) {
                    $order_response['message'] = "Unable To Change Order Status";
                    return formatApiAutoResponse($this->request, $this->response, $order_response);
                }

                $order_log_response = $this->getOrderLogModel()->RecordCreate($data);
                if ($order_log_response['status'] != ApiResponseStatusCode::CREATED) {
                    $order_log_response['message'] = "Unable To Create Order Log";
                    return formatApiAutoResponse($this->request, $this->response, $order_log_response);
                }

                // Send notification
                $email_send = $email->order_refund_processed_successfully(
                    $order_data['mobile'],
                    $order_data['fullname'],
                    $order_data['order_number'],
                    'order_link'
                );
                $sms_send = $sms->order_refund_processed_successfully(
                    $order_data['mobile'] ?? '',
                    $order_data['fullname'] ?? '',
                    $order_data['order_number'] ?? '',
                    'order_link'
                );
                $this->DeActivateWalletByOrderId($data['order_id']);
                $message = "Refund request approved.";
                break;

            case 'request_return_approved':
                // Validate the request before proceeding
                $validation = \Config\Services::validation();
                $validation->setRules([
                    'return_shipping_charge' => [
                        'label'  => 'return_shipping_charge',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'return_shipping_charge is required',
                        ],
                    ],
                    'delhivery_waybill' => [
                        'label'  => 'delhivery_waybill',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'Return waybill is required',
                        ],
                    ],
                    'log_remark' => [
                        'label'  => 'log_remark',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'log_remark is required',
                        ],
                    ],
                ]);

                // Validate requested data against defined rules
                if ($validation->run($data) === false) {
                    return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Validation Failed', [], $validation->getErrors());
                }

                // Update the order and create logs
                $order_response = $this->getOrderModel()->RecordUpdate($data, $data['order_id']);
                if ($order_response['status'] != ApiResponseStatusCode::OK) {
                    $order_response['message'] = "Unable To Change Order Status";
                    return formatApiAutoResponse($this->request, $this->response, $order_response);
                }

                $order_log_response = $this->getOrderLogModel()->RecordCreate($data);
                if ($order_log_response['status'] != ApiResponseStatusCode::CREATED) {
                    $order_log_response['message'] = "Unable To Create Order Log";
                    return formatApiAutoResponse($this->request, $this->response, $order_log_response);
                }
                $this->DeActivateWalletByOrderId($data['order_id']);
                $message = "Return request approved.";
                break;

            case 'request_exchange_approved':
                // Validate the request before proceeding
                $validation = \Config\Services::validation();
                $validation->setRules([
                    'delhivery_waybill' => [
                        'label'  => 'delhivery_waybill',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'Exchange waybill is required',
                        ],
                    ],
                    'log_remark' => [
                        'label'  => 'log_remark',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'log_remark is required',
                        ],
                    ],
                ]);

                // Validate requested data against defined rules
                if ($validation->run($data) === false) {
                    return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Validation Failed', [], $validation->getErrors());
                }

                // Update the order and create logs
                $order_response = $this->getOrderModel()->RecordUpdate($data, $data['order_id']);
                if ($order_response['status'] != ApiResponseStatusCode::OK) {
                    $order_response['message'] = "Unable To Change Order Status";
                    return formatApiAutoResponse($this->request, $this->response, $order_response);
                }

                $order_log_response = $this->getOrderLogModel()->RecordCreate($data);
                if ($order_log_response['status'] != ApiResponseStatusCode::CREATED) {
                    $order_log_response['message'] = "Unable To Create Order Log";
                    return formatApiAutoResponse($this->request, $this->response, $order_log_response);
                }

                $message = "Exchange request approved.";
                break;

            case 'refund_to_customer':
                // Handle the case when a refund is issued to the customer
                $order_response = $this->getOrderModel()->RecordUpdate($data, $data['order_id']);
                $order_log_response = $this->getOrderLogModel()->RecordCreate($data);
                $validation = \Config\Services::validation();

                // Define validation rules for 'log_remark'
                $validation->setRules([
                    'log_remark' => [
                        'label'  => 'log_remark',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'log_remark is required',
                        ],
                    ],
                ]);

                // Validate requested data against defined rules
                if ($validation->run($data) === false) {
                    // Return validation failed response
                    return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Validation Failed', [], $validation->getErrors());
                }

                $email_send = $email->order_refund_processed_successfully(
                    $order_data['mobile'],
                    $order_data['fullname'],
                    $order_data['order_number'],
                    'order_link' // You can replace 'order_link' with the actual order link
                );
                $sms_send = $sms->order_refund_processed_successfully(
                    $order_data['mobile'] ?? '',
                    $order_data['fullname'] ?? '',
                    $order_data['order_number'] ?? '',
                    'order_link' // You can replace 'order_link' with the actual order link
                );

                $message = "Refund has been issued to the customer.";
                break;

                // Handle the case when a refund is issued to the customer
                $order_response = $this->getOrderModel()->RecordUpdate($data, $data['order_id']);
                $order_log_response = $this->getOrderLogModel()->RecordCreate($data);
                $validation = \Config\Services::validation();

                // Define validation rules for 'username'
                $validation->setRules([
                    'log_remark' => [
                        'label'  => 'log_remark',
                        'rules'  => 'required',
                        'errors' => [
                            'required' => 'log_remark is required',
                        ],
                    ],
                ]);

                // Validate requested data against defined rules
                if ($validation->run($data) === false) {
                    // Return validation failed response
                    return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Validation Failed', [], $validation->getErrors());
                }

                $message = "Refund issued to customer.";
                break;

            default:
                // // Handle the case when the status is unknown
                // $order_response = $this->getOrderModel()->RecordUpdate($data, $data['order_id']);
                // $order_log_response = $this->getOrderLogModel()->RecordCreate($data);
                $message = "Unknown order status.";
                break;
        }

        // Return success response
        return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, $message);
    }

    private function DeActivateWalletByOrderId($orderId)
    {
        $walletModel = $this->getEWalletModel();

        $walletRow = $walletModel
            ->where('order_id', $orderId)
            ->first();

        if ($walletRow) {
            $walletModel->update($walletRow['e_wallet_id'], [
                'is_wallet_active' => 0
            ]);
        }
    }

    public function third_party_integration_update_api()
    {
        return $this->ModelUpdate($this->getThirdPartyIntegrationModel());
    }
    public function email_sms_template_update_api()
    {
        return $this->ModelUpdate($this->getTemplateModel());
    }
    // User Login  ------------------------------------------------------------------------------------
    /** 
     * {
     * "username":"required",
     * "password":"required"
     * }
     */
    public function UserLogin()
    {
        $requestedData = getRequestData($this->request, 'ARRAY') ?? [];
        $validation = \Config\Services::validation();
        // Define validation rules
        $validation->setRules([
            'username' => [
                'label'  => 'Username',
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
        } else {
            // Cookies Set at remember me
            if (isset($requestedData['rememberme'])) {
                if ($requestedData['rememberme'] == 'on') {
                    // CREATE COOKIES INSTANCE AND SET VALUE $requestedData['username'] to cookies username key
                    set_cookie('username', $requestedData['username']);
                }
            } else {
                delete_cookie('username');
            }
            $result = $this->getUserModel()->checkLogin($requestedData['username'], $requestedData['password']);
            if ($result['status'] != ApiResponseStatusCode::OK) {
                return formatApiAutoResponse($this->request, $this->response, $result);
            }
            $userdata = $result['data'];
            if ($userdata['is_active'] != 1) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, 'Account is Disabled Please Contact Your Administrator', [], ['error' => 'Account is Disabled Please Contact Your Administrator']);
            }
            $token = $this->getUserTokenModel()->generateJWTToken($userdata);
            $userAgent = $this->request->getUserAgent();
            $croppedUserAgent = (string) strlen($userAgent->getAgentString()) > 100 ? substr($userAgent->getAgentString(), 0, 100) : $userAgent->getAgentString();
            $UserTokenData = [
                'user_id' => $userdata[$this->getUserModel()->getPrimaryKey()],
                'token' => $token,
                'expiry' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'ip_address' => $this->request->getIPAddress(),
                'device_name' => $croppedUserAgent,
            ];
            $result = $this->getUserTokenModel()->RecordCreate($UserTokenData);
            if ($result['status'] != ApiResponseStatusCode::CREATED) {
                return formatApiAutoResponse($this->request, $this->response, $result);
            }
            $userdata['token'] = $token;
            $userdata['logged_in'] = true;
            $FC = new FirebaseController();
            $userdata = array_merge($userdata, $FC->getFrontendIntregationData());
            $session = \Config\Services::session();
            $session->set($userdata);
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, 'Login Successfull', $userdata);
        }
    }
    // User  -------------------------------------------------------------------------------------------------------
    /** */
    public function UserForgetPasswordOtpSend()
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
            $result = $this->getUserModel()
                ->orWhere('email', $requestedData['username'])
                ->orWhere('mobile', $requestedData['username'])
                ->first();

            // If no user found, return not found response
            if (empty($result)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::NOT_FOUND,
                    'Username Not Found'
                );
            }

            // Generate OTP and prepare update data
            $update_data = ['otp' => random_int(1000, 9999)];

            // Update user record with generated OTP
            $result1 = $this->getUserModel()->RecordUpdate($update_data, $result['user_id']);

            // If update operation fails, return corresponding response
            if ($result1['status'] != ApiResponseStatusCode::OK) {
                return formatApiAutoResponse(
                    $this->request,
                    $this->response,
                    $result1
                );
            }
            $email_send_result = $this->getEmailController()->UserForgetPasswordSendOtp(
                $result['email'] ?? '',
                $result['fullname'] ?? '',
                $update_data['otp'] ?? '',
            );

            // Check if the email sending was successful and handle errors if needed
            if (!$email_send_result) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::BAD_REQUEST,
                    'Failed to send OTP'
                );
            }

            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                'OTP Send Successfull',
                []
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


    public function UserForgetPasswordUpdate()
    {
        try {
            // Retrieve requested data from request
            $requestedData = getRequestData($this->request, 'ARRAY') ?? [];

            // Load validation service
            $validation = \Config\Services::validation();

            // Define validation rules for 'username', 'password', 'confirm_password', 'otp'
            $validation->setRules([
                'username' => [
                    'label'  => 'Username',
                    'rules'  => 'required',
                    'errors' => [
                        'required' => 'Email / Mobile is Required',
                    ],
                ],
                'password' => [
                    'label'  => 'Password',
                    'rules'  => 'required',
                ],
                'confirm_password' => [
                    'label'  => 'Confirm Password',
                    'rules'  => 'required|matches[password]',
                ],
                'otp' => [
                    'label'  => 'OTP',
                    'rules'  => 'required',
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
            $result = $this->getUserModel()
                ->orWhere('email', $requestedData['username'])
                ->orWhere('mobile', $requestedData['username'])
                ->first();

            // If no user found, return bad request response
            if (empty($result)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::BAD_REQUEST,
                    'Username Not Found'
                );
            }

            // Check if provided OTP matches stored OTP
            if ($result['otp'] != $requestedData['otp']) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::BAD_REQUEST,
                    'OTP Not Match'
                );
            }

            // Update user record with new password and clear OTP
            $update_data = ['otp' => '', 'password' => $requestedData['password']];
            $this->getUserModel()->RecordUpdate($update_data, $result['user_id']);

            // Return success response after successful password change
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                'Password Successfully Changed',
                []
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

    public function UserGet()
    {
        return $this->ModelGet($this->getUserModel());
    }
    /** */
    public function UserList()
    {
        return $this->ModelList($this->getUserModel());
    }
    /** 
     * {"user_id": "permit_empty|integer",	"fullname": "required|max_length[255]",	"email": "required|valid_email|max_length[255]|is_unique[user.email,user_id,{user_id}]",	"mobile": "required|max_length[15]|is_unique[user.mobile,user_id,{user_id}]",	"password": "required|max_length[255]",	"otp": "permit_empty|max_length[6]",	"user_type": "required|in_list[admin,inventory,finance,order,delivery]",	"is_active": "boolean"} 
     */
    public function UserCreate()
    {
        return $this->ModelCreate($this->getUserModel());
    }
    /** */
    public function UserUpdate()
    {
        return $this->ModelUpdate($this->getUserModel());
    }
    /** */
    public function UserDelete()
    {
        return $this->ModelDelete($this->getUserModel());
    }

    protected function FilesValidate($fileObject, string $moduleName): array
    {
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
    }
    protected function FileTypeValidate($fileObject, $allowedFileTypeArray): bool
    {
        $fileType = $fileObject['type'];
        // Check if the file type is in the allowed file types array
        return in_array($fileType, $allowedFileTypeArray);
    }
    protected function FileSizeValidate($fileObject, $maximumFileSizeInKB): bool
    {
        $fileSize = $fileObject['size'];
        // Check if the file size is within the allowed limit
        return $fileSize <= $maximumFileSizeInKB * 1024;
    }

    public function ImageUpload()
    {
        $requestedData = getRequestData($this->request, 'ARRAY');

        $validation = \Config\Services::validation();
        $validation->setRules([
            'file' => "required",
            'for'  => "in_list[category_type,category,brand,product,variant,color,feature,blogpost,firmLogo,offer,coupan,slider_image,product_video,slider_video,blog_video,fluencer_video]",
        ]);

        if ($validation->run($requestedData) === false) {
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::VALIDATION_FAILED,
                'Validation Failed',
                [],
                $validation->getErrors()
            );
        }

        // File size validation
        $maxSize = in_array($requestedData['for'], ['product_video', 'slider_video', 'blog_video']) ? 10240 : 500; // KB
        if (!$this->FileSizeValidate($requestedData['file'], $maxSize)) {
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::VALIDATION_FAILED,
                "File Size Exceeded (Max {$maxSize} KB Allowed)",
                []
            );
        }

        // Allowed types
        $FileTypeArray = [
            // Images
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/bmp',
            'image/webp',
            'image/svg+xml',
            // Videos
            'video/mp4',
            'video/webm',
            'video/ogg',
            'video/mpeg',
            'video/quicktime'
        ];
        if (!$this->FileTypeValidate($requestedData['file'], $FileTypeArray)) {
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::VALIDATION_FAILED,
                'Invalid File Type. Only Images and Videos Allowed',
                []
            );
        }

        // Determine folder and conversion flag
        $folderPath   = "";
        $convertToWebp = true;
        switch ($requestedData['for']) {
            case 'category_type':
                $folderPath .= "uploads/category_type/";
                break;
            case 'category':
                $folderPath .= "uploads/category/";
                break;
            case 'brand':
                $folderPath .= "uploads/brand/";
                break;
            case 'product':
                $folderPath .= "uploads/product/";
                break;
            case 'variant':
                $folderPath .= "uploads/variant/";
                break;
            case 'color':
                $folderPath .= "uploads/color/";
                break;
            case 'feature':
                $folderPath .= "uploads/feature/";
                break;
            case 'blogpost':
                $folderPath .= "uploads/blogpost/";
                break;
            case 'firmLogo':
                $folderPath .= "uploads/firmLogo/";
                break;
            case 'offer':
                $folderPath .= "uploads/offer/";
                break;
            case 'coupan':
                $folderPath .= "uploads/coupan/";
                break;
            case 'slider_image':
                $folderPath .= "uploads/slider_image/";
                $convertToWebp = false;
                break;

            // Videos
            case 'product_video':
                $folderPath .= "uploads/product_video/";
                $convertToWebp = false;
                break;
            case 'slider_video':
                $folderPath .= "uploads/slider_video/";
                $convertToWebp = false;
                break;
            case 'blog_video':
                $folderPath .= "uploads/blog_video/";
                $convertToWebp = false;
                break;
        }

        // robust mime detection
        $file = $requestedData['file'];
        $mime = $file['type'] ?? null;
        if (empty($mime) && !empty($file['tmp_name']) && file_exists($file['tmp_name'])) {
            if (function_exists('finfo_open')) {
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($finfo, $file['tmp_name']);
                finfo_close($finfo);
            } else {
                $mime = mime_content_type($file['tmp_name']);
            }
        }

        // --- If it's a VIDEO: just move it to target folder (don't call image helper) ---
        if (!empty($mime) && strpos($mime, 'video/') === 0) {
            $uploadDir = FCPATH . $folderPath;
            if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, 'Unable to create upload directory', []);
            }

            // file extension
            $origName = $file['name'] ?? '';
            $ext = pathinfo($origName, PATHINFO_EXTENSION);
            if (empty($ext)) {
                $map = [
                    'video/mp4' => 'mp4',
                    'video/webm' => 'webm',
                    'video/ogg' => 'ogv',
                    'video/mpeg' => 'mpeg',
                    'video/quicktime' => 'mov'
                ];
                $ext = $map[$mime] ?? 'mp4';
            }

            $filename = uniqid('vid_') . '.' . $ext;
            $destPath = $uploadDir . $filename;

            $moved = false;
            if (!empty($file['tmp_name']) && is_uploaded_file($file['tmp_name'])) {
                $moved = move_uploaded_file($file['tmp_name'], $destPath);
            } elseif (!empty($file['tmp_name']) && file_exists($file['tmp_name'])) {
                // sometimes tmp_name is a path (when testing), so try rename
                $moved = rename($file['tmp_name'], $destPath);
            } elseif (!empty($file['base64'])) {
                // optional: if frontend sends base64 payload
                $decoded = base64_decode($file['base64']);
                $moved = (file_put_contents($destPath, $decoded) !== false);
            }

            if (!$moved) {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, 'Failed to save uploaded video', []);
            }

            @chmod($destPath, 0644);
            $relPath = rtrim($folderPath, '/') . '/' . $filename;

            $result = [
                'file_name' => $filename,
                'image_path_url'  => base_url($relPath),
                'image_path'  => $relPath,
                'mime'      => $mime,
                'size'      => filesize($destPath),
            ];

            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, "File Upload Successfully", $result);
        }

        // --- Else: treat as IMAGE and use your image helper ---
        $errorMessage = "";
        $uploadResult = uploadImageWithThumbnail(
            $file,
            $folderPath,
            $errorMessage,
            0.5,
            $convertToWebp
        );

        if ($uploadResult == false) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, $errorMessage, []);
        }

        return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, "File Upload Successfully", $uploadResult);
    }

    public function deleteImage()
    {
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
    }

    public function ImportProductByExcel()
    {
        try {
            helper(['form', 'excel']);
            $data = getRequestData($this->request, 'ARRAY');
            $file = $data['_files']['csv'];
            if ($file->isValid() && !$file->hasMoved()) {
                $filePath = $file->getTempName();
                $excelData = getExcelDataInArrayHeaderKeyWise($filePath, 11);
                if (empty($excelData)) {
                    return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, 'Record Not Found For Import');
                }
                // Trim Data
                $this->ExcelDataTrim($excelData);
                // Process Data to Default Values
                $this->ExcelDataProcess($excelData);
                // Validate Excel File
                $errors = [];
                if (!$this->ExcelValidate($excelData, $errors)) {
                    return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::VALIDATION_FAILED, "Excel File Validation Failed", [], $errors);
                } else {
                    // Excel Validate Successfully
                    $counts = ['category_type' => 0, 'category' => 0, 'brand' => 0, 'product' => 0, 'variant' => 0];
                    // Category Process
                    $category_type_name_unique = array_unique(array_column($excelData, 'category_type_name'));
                    $this->InsertMultipleCategoryTypeIfNotExist($category_type_name_unique, $excelData, $counts);

                    $category_name_unique = array_unique(array_column($excelData, 'category_name'));
                    $this->InsertMultipleCategoryIfNotExist($category_name_unique, $excelData, $counts);
                    $brand_name_unique = array_unique(array_column($excelData, 'brand_name'));
                    $this->InsertMultipleBrandIfNotExist($brand_name_unique, $excelData, $counts);
                    $this->InsertMultipleProductIfNotExist($excelData, $counts);
                    $this->InsertMultipleVariantIfNotExist($excelData, $counts);
                    $success_response = [];
                    if ($counts['category_type'] != 0) {
                        $success_response['category_type'] = $counts['category_type'] . " Category Type Created Successfully";
                    }
                    if ($counts['category'] != 0) {
                        $success_response['category'] = $counts['category'] . " Category Created Successfully";
                    }
                    if ($counts['brand'] != 0) {
                        $success_response['brand'] = $counts['brand'] . " Brand Created Successfully";
                    }
                    if ($counts['product'] != 0) {
                        $success_response['product'] = $counts['product'] . " Product Created Successfully";
                    }
                    if ($counts['variant'] != 0) {
                        $success_response['variant'] = $counts['variant'] . " Variant Created Successfully";
                    }
                }
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, 'Bulk Import Successfully', $success_response);
            } else {
                return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, 'Invalid file or file has already been moved'[]);
            }
        } catch (Exception $e) {
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::BAD_REQUEST, $e->getMessage(), []);
        }
    }
    protected function InsertMultipleCategoryTypeIfNotExist($category_type_name_unique, &$rows, &$counts)
    {
        try {
            foreach ($category_type_name_unique as $key => $category_type_name) {
                $record = $this->getCategoryTypeModel()->where('category_type_name', $category_type_name)->findAll();
                if (!empty($record)) {
                    $this->addKeyOnSearchInRows($rows, 'category_type_name', $category_type_name, 'category_type_id', $record[0]['category_type_id']);
                } else {
                    $category_type_data = [
                        'category_type_name' => $category_type_name,
                        'category_type_image' => '/Image_not_available.png',
                        'is_active' => 1,
                    ];
                    $categroy_type_id = $this->getCategoryTypeModel()->insert($category_type_data);
                    $this->addKeyOnSearchInRows($rows, 'category_type_name', $category_type_name, 'category_type_id', $categroy_type_id);
                    $counts['category_type'] += 1;
                }
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
    protected function InsertMultipleCategoryIfNotExist($category_name_unique, &$rows, &$counts)
    {
        try {
            foreach ($category_name_unique as $key => $category_name) {
                $category_type_id = current(array_column(array_filter($rows, fn($row) => $row['category_name'] == $category_name), 'category_type_id'));

                $record = $this->getCategoryModel()->where('category_name', $category_name)->findAll();
                if (!empty($record)) {
                    $this->addKeyOnSearchInRows($rows, 'category_name', $category_name, 'category_id', $record[0]['category_id']);
                } else {
                    $category_data = [
                        'category_name' => $category_name,
                        'category_type_id' => $category_type_id,
                        'category_image' => '/Image_not_available.png',
                        'is_active' => 1,
                    ];
                    $categroy_id = $this->getCategoryModel()->insert($category_data);
                    $this->addKeyOnSearchInRows($rows, 'category_name', $category_name, 'category_id', $categroy_id);
                    $counts['category'] += 1;
                }
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
    protected function InsertMultipleBrandIfNotExist($brand_name_unique, &$rows, &$counts)
    {
        try {
            foreach ($brand_name_unique as $key => $brand_name) {


                $record = $this->getBrandModel()->where('brand_name', $brand_name)->findAll();
                if (!empty($record)) {
                    $this->addKeyOnSearchInRows($rows, 'brand_name', $brand_name, 'brand_id', $record[0]['brand_id']);
                } else {
                    $brand_data = [
                        'brand_name' => $brand_name,
                        'brand_image' => '/Image_not_available.png',
                        'is_active' => 1,
                    ];
                    $brand_id = $this->getBrandModel()->insert($brand_data);
                    $this->addKeyOnSearchInRows($rows, 'brand_name', $brand_name, 'brand_id', $brand_id);
                    $counts['brand'] += 1;
                }
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
    protected function InsertMultipleProductIfNotExist(&$rows, &$counts)
    {
        try {
            foreach ($rows as $key => &$row) {
                if (!empty($row['features'])) {
                    $features_name = explode(',', $row['features']);
                    foreach ($features_name as &$value) {
                        $value = trim($value);
                    }
                    $features_list = $this->getFeatureModel()->whereIn('feature_name', $features_name)->findAll();
                    $features = [];
                    if (!empty($features_list)) {
                        $features = array_column($features_list, 'feature_id');
                    }
                    $row['features'] = $features;
                }
                $product_name = $row['product_name'];
                $record = $this->getProductModel()->where('product_name', $product_name)->findAll();

                if (!empty($record)) {
                    $row['product_id'] = $record[0]['product_id'];
                    $update_data = [
                        'product_name' => $product_name,
                        'category_type_id ' => $row['category_type_id'],
                        'category_id ' => $row['category_id'],
                        'brand_id ' => $row['brand_id'],
                        'product_hsn_code' => $row['product_hsn_code'],
                        'height' => $row['height'],
                        'width' => $row['width'],
                        'product_description' => $row['product_description'],
                        'product_seo_title' => $row['product_seo_title'],
                        'product_seo_description' => $row['product_seo_description'],
                        'product_keyfeature' => $row['product_keyfeature'],
                        'product_specialcare' => $row['product_specialcare'],
                        'product_refund_exchange' => $row['product_refund_exchange'],
                        'is_recommended' => $row['is_recommended'],
                        'is_returnable' => $row['is_returnable'],
                        'is_sponsore' => $row['is_sponsore'],
                        'is_exchangeable' => $row['is_exchangeable'],
                        'product_image1' => '/Image_not_available.png',
                        'is_active' => 1,
                    ];
                    $this->getProductModel()->RecordUpdate($update_data, $record[0]['product_id']);
                } else {
                    $product_data = [
                        'product_name' => $product_name,
                        'category_type_id' => $row['category_type_id'],
                        'category_id' => $row['category_id'],
                        'brand_id' => $row['brand_id'],
                        'product_hsn_code' => $row['product_hsn_code'],
                        'height' => $row['height'],
                        'width' => $row['width'],
                        'product_description' => $row['product_description'],
                        'product_seo_title' => $row['product_seo_title'],
                        'product_seo_description' => $row['product_seo_description'],
                        'product_keyfeature' => $row['product_keyfeature'],
                        'product_specialcare' => $row['product_specialcare'],
                        'product_refund_exchange' => $row['product_refund_exchange'],
                        'is_recommended' => $row['is_recommended'],
                        'is_returnable' => $row['is_returnable'],
                        'is_sponsore' => $row['is_sponsore'],
                        'is_exchangeable' => $row['is_exchangeable'],
                        'product_image1' => '/Image_not_available.png',
                        'is_active' => 1,
                    ];

                    $result = $this->getProductModel()->RecordCreate($product_data);
                    $row['product_id'] = $result['data']['product_id'];
                    $counts['product'] += 1;
                    $this->addKeyOnSearchInRows($rows, 'product_name', $product_name, 'product_id', $row['product_id']);
                }
                // Insert Features
                if ($row['features'] && !empty($row['features']) && is_array($row['features'])) {
                    $this->getProductVsFeatureModel()->where('product_id', $row['product_id'])->delete();
                    if (isset($row['features']) && is_array($row['features'])) {
                        foreach ($row['features'] as $key => $feature) {
                            $features_row = [
                                'feature_id' => $feature,
                                'product_id' => $row['product_id']
                            ];
                            $this->getProductVsFeatureModel()->RecordCreate($features_row);
                        }
                    }
                }
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    protected function InsertMultipleVariantIfNotExist(&$rows, &$counts)
    {
        try {
            foreach ($rows as $key => &$row) {
                // Process sizes
                if (!empty($row['sizes'])) {
                    $sizes_name = explode(',', $row['sizes']);
                    foreach ($sizes_name as &$value) {
                        $value = trim($value);
                    }
                    $sizes_list = $this->getSizeModel()->whereIn('size_name', $sizes_name)->findAll();
                    $sizes = [];
                    if (!empty($sizes_list)) {
                        $sizes = array_column($sizes_list, 'size_id');
                    }
                    $row['sizes'] = $sizes;
                }

                // Fetch variant, unit, and color records
                $variant_sku_code = $row['variant_sku_code'];
                $record = $this->getProductVariantModel()->where('variant_sku_code', $variant_sku_code)->findAll();

                $unit_name = $row['unit_name'];
                $unitrecord = $this->getUnitModel()->where('unit_name', $unit_name)->findAll();

                $color_name = $row['color_name'];
                $colorrecord = $this->getColorModel()->where('color_name', $color_name)->findAll();

                // Set unit_id and color_id
                $row['unit_id'] = $unitrecord[0]['unit_id'];
                $row['color_id'] = $colorrecord[0]['color_id'];

                // Construct variant data array
                $variant_data = [
                    'variant_sku_code' => $variant_sku_code,
                    'variant_name' => $row['variant_name'],
                    'unit_id' => $row['unit_id'],
                    'product_id' => $row['product_id'],
                    'color_id' => $row['color_id'],
                    'minimum_stock' => $row['minimum_stock'],
                    'variant_weight' => $row['variant_weight'],
                    'purchase_rate' => $row['purchase_rate'],
                    'mrp' => $row['mrp'],
                    'discount_per' => $row['discount_per'],
                    'gst_per' => $row['gst_per'],
                    'variant_image1' => '/Image_not_available.png',
                    'is_active' => 1,
                ];

                // Insert or update variant 
                if (!empty($record)) {
                    // Update existing variant
                    $row['variant_id'] = $record[0]['variant_id'];
                    $this->getProductVariantModel()->update($row['variant_id'], $variant_data);
                } else {
                    // Insert new variant
                    $result = $this->getProductVariantModel()->RecordCreate($variant_data);
                    $row['variant_id'] = $result['data']['variant_id'];
                    $counts['variant'] += 1;
                }
                // // Insert multiple sizes
                // if (isset($row['sizes']) && !empty($row['sizes'])) {
                //     $this->getSizeVsVariantModel()->where('variant_id', $row['variant_id'])->delete();
                //     if (is_array($row['sizes'])) {
                //         foreach ($row['sizes'] as $size) {
                //             $size_row = [
                //                 'size_id' => $size,
                //                 'variant_id' => $row['variant_id'],
                //             ];
                //             $this->getSizeVsVariantModel()->RecordCreate($size_row);
                //         }
                //     }
                // }
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
    protected function addKeyOnSearchInRows(&$rows, $searchFieldName, $searchFieldValue, $addFieldName, $addFieldValue)
    {
        foreach ($rows as $key1 => &$row) {
            if ($row[$searchFieldName] == $searchFieldValue) {
                $row[$addFieldName] = $addFieldValue;
            }
        }
    }
    protected function ExcelDataTrim(&$rows)
    {
        foreach ($rows as $key => &$row) {
            foreach ($row as $key1 => &$value) {
                $value = trim($value);
            }
        }
    }
    protected function ExcelDataProcess(&$rows)
    {
        $intFields = ["is_recommended", "is_returnable", 'is_sponsore', 'is_exchangeable', 'minimum_stock', 'variant_weight', 'purchase_rate', 'mrp', 'discount_per', 'gst_per'];
        $defaultDataBluePrint = [
            "product_name" => "",
            "product_hsn_code" => "",
            "category_type_name" => "",
            "category_name" => "",
            "brand_name" => "",
            "features" => "",
            "height" => "",
            "width" => "",
            "product_description" => "",
            "product_seo_title" => "",
            "product_seo_description" => "",
            "product_keyfeature" => "",
            "product_specialcare" => "",
            "product_refund_exchange" => "",
            "is_recommended" => 0,
            "is_returnable" => 0,
            "is_sponsore" => 0,
            "is_exchangeable" => 0,
            "variant_name" => "",
            "variant_sku_code" => "",
            "unit_name" => "",
            "color_name" => "",
            "minimum_stock" => 0,
            "variant_weight" => 0.00,
            "purchase_rate" => 0.00,
            "mrp" => 0.00,
            "discount_per" => 0.00,
            "gst_per" => 0.00,
            "sizes" => "",
        ];
        foreach ($rows as $key => &$row) {
            foreach ($row as $key1 => &$value) {
                if (empty($value)) {
                    if (array_key_exists($key1, $defaultDataBluePrint)) {
                        $value = $defaultDataBluePrint[$key1];
                    }
                }
            }
        }
        foreach ($rows as $key => &$row) {
            foreach ($row as $key1 => &$value) {
                if (in_array($key1, $intFields)) {
                    $value = floatval($value);
                }
            }
        }
    }
    protected function ExcelValidate($rows, &$errors)
    {
        $validationRules = [
            'product_name' => 'required|max_length[255]',
            'product_hsn_code' => 'required|max_length[8]',
            'category_type_name' => 'required|max_length[255]',
            'category_name' => 'required|max_length[255]',
            'brand_name' => 'required|max_length[255]',
            'variant_name' => 'required|max_length[255]',
            'variant_sku_code' => 'required|max_length[255]',
            'unit_name' => 'required|max_length[255]',
            'color_name' => 'required|max_length[255]',
            'purchase_rate' => 'required|max_length[10]|decimal',
            'mrp' => 'required|max_length[10]|decimal',
            'discount_per' => 'required|max_length[5]|decimal',
            'gst_per' => 'required|max_length[5]|decimal',
            'features' => 'permit_empty',
            'height' => 'permit_empty|max_length[255]',
            'width' => 'permit_empty|max_length[255]',
            'product_description' => 'permit_empty',
            'product_seo_title' => 'permit_empty|max_length[120]',
            'product_seo_description' => 'permit_empty|max_length[120]',
            'product_keyfeature' => 'permit_empty',
            'product_specialcare' => 'permit_empty',
            'product_refund_exchange' => 'permit_empty',
            'is_recommended' => 'permit_empty|in_list[0,1]',
            'is_returnable' => 'permit_empty|in_list[0,1]',
            'is_sponsore' => 'permit_empty|in_list[0,1]',
            'is_exchangeable' => 'permit_empty|in_list[0,1]',
            'minimum_stock' => 'permit_empty|max_length[11]',
            'variant_weight' => 'permit_empty|max_length[10]',
            'sizes' => 'permit_empty'
        ];

        $validation = \Config\Services::validation();
        $isValid = true;

        foreach ($rows as $index => $row) {
            if (!$validation->setRules($validationRules)->run($row)) {
                $errors[$index] = $validation->getErrors();
                $isValid = false;
            }
        }
        $color_name_unique = array_unique(array_column($rows, 'color_name'));
        foreach ($color_name_unique as $index => $color_name) {
            $result = $this->getColorModel()->where('color_name', $color_name)->findAll();
            if (empty($result)) {
                $errors[0]['color_name'] = $color_name . ' Color Name Not Found in Record';
                $isValid = false;
                break;
            }
        }
        $unit_name_unique = array_unique(array_column($rows, 'unit_name'));
        foreach ($unit_name_unique as $index => $unit_name) {
            $result = $this->getUnitModel()->where('unit_name', $unit_name)->findAll();
            if (empty($result)) {
                $errors[0]['unit_name'] = $unit_name . ' Unit Name Not Found in Record';
                $isValid = false;
                break;
            }
        }
        return $isValid;
    }


    public function admin_dashboard_api()
    {
        try {
            $apc = new AdminPageController();
            $data = [];
            $data['counts'] = $apc->order_dashboard_counts();

            // Fetch list data
            $list_data = $this->getOrderModel()
                ->select('order.order_date, order.order_number, order.order_total, order.payment_mode, customer.fullname')
                ->join('customer', 'customer.customer_id = order.customer_id')
                ->orderBy('order.order_date', 'DESC')
                ->limit(10)
                ->findAll();

            $data['list_data'] = $list_data;
            // Send list data as it is

            //overview data
            $overview_data = $this->getOrderModel()
                ->select('SUM(IFNULL(order_total, 0)) AS total_order_amount, SUM(IFNULL(total_refund_amount, 0)) AS total_refund_amount')
                ->whereIn('order_status', ['refund_to_customer', 'order_delivered', 'order_exchanged'])
                ->first(); // use first() since we expect a single row result with SUM

            // Store the aggregated data in the respective fields
            $data['total_order_amount'] = $overview_data['total_order_amount'];
            $data['total_refund_amount'] = $overview_data['total_refund_amount'];

            // Calculate revenue
            $data['revenue'] = $data['total_order_amount'] - $data['total_refund_amount'];


            //product wishlist 
            $product_wishlist = $this->getCustomerWishlistSummaryModel()
                ->select('SUM(customer_wishlist_summary.total_product_count) AS total_product_count_sum')
                ->findAll();
            $data['product_wishlist'] = $product_wishlist;
            $data['total_product_count_sum'] = array_column($product_wishlist, 'total_product_count_sum');

            //New visitors
            $new_visitor = $this->getCustomerCartSummaryModel()
                ->select('SUM(customer_cart_summary.total_product_count) AS total_visitor_count_sum')
                ->findAll();
            $data['new_visitor'] = $new_visitor;
            $data['total_visitor_count_sum'] = array_column($new_visitor, 'total_visitor_count_sum');

            // Query for monthly sales data (unchanged)
            $monthly_sales = $this->getOrderModel()->MonthlyOrderSummary('order_delivered');

            // Prepare data for chart (unchanged)
            $data['monthly_sales'] = $monthly_sales;
            $data['months'] = array_column($monthly_sales, 'month_name');
            $data['sales'] = array_column($monthly_sales, 'total_sales');
            $data['years'] = array_column($monthly_sales, 'year');


            //user count
            $user_count = $this->getCustomerModel()
                ->select('COUNT(*) AS user_count')
                ->where('YEAR(created_at) = YEAR(CURRENT_DATE)', null, false)
                ->where('MONTH(created_at) = MONTH(CURRENT_DATE)', null, false)
                ->findAll();
            $data['user_count'] = $user_count;
            $data['user_data_count'] = array_column($user_count, 'user_count');


            // source count visit analytics
            $source_count_rows = $this->getShareReferenceModel()
                ->select('COALESCE(source, "direct") as source, SUM(customer_search_count) as total_customer_search_count')
                ->groupBy('source')
                ->findAll();

            // Convert rows to one associative array
            $source_counts = [];

            foreach ($source_count_rows as $row) {
                $key = strtolower($row['source']) . '_total_customer_search_count';
                $source_counts[$key] = (int)$row['total_customer_search_count'];
            }

            $data['source_count'] = $source_counts;



            //Review Customer
            $customer_review = $this->getCustomerReviewModel()
                ->select('customer_review.customer_review, customer_review.customer_rating, customer.fullname, product.product_name')
                ->join('customer', 'customer.customer_id = customer_review.customer_id')
                ->join('product', 'product.product_id = customer_review.product_id')
                ->where('customer_review.created_at >=', date('Y-m-01 00:00:00'))  // First day of the current month
                ->where('customer_review.created_at <=', date('Y-m-t 23:59:59'))    // Last day of the current month
                ->where('customer_review.customer_review IS NOT NULL')
                ->where('customer_review.customer_review !=', '')
                ->findAll();

            // Assign the fetched data to the output array
            $data['customer_review'] = $customer_review;
            //Inbox message
            $inbox_data = $this->getContactUsModel()
                ->select('contact_us.fullname,contact_us.message,contact_us.order_inquiry')
                ->limit(6)
                ->findAll();
            $data['inbox_data'] = $inbox_data;
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, 'Dashboard Updated', $data);
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

    public function order_dashboard_api()
    {
        try {
            $apc = new AdminPageController();
            $data = [];
            $data['counts'] = $apc->order_dashboard_counts();
            $today_order = $this->getOrderModel()
                ->select('COUNT(*) as total_orders_today')
                ->where('DATE(order_date)', date('Y-m-d'))
                ->first();

            $data['today_order_count'] = $today_order;
            $list_data = $this->getOrderModel()
                ->select('order.order_date, order.order_number, order.order_total, order.payment_mode, customer.fullname')
                ->join('customer', 'customer.customer_id = order.customer_id')
                ->orderBy('order.order_date', 'DESC')
                ->limit(10)
                ->findAll();
            $data['list_data'] = $list_data;

            $refund_data = $this->getOrderModel()
                ->select('order.order_date, order.order_number, order.order_total, order.payment_mode,order.order_status, customer.fullname')
                ->join('customer', 'customer.customer_id = order.customer_id')
                ->where('order.order_status', 'refund_to_customer')
                ->orderBy('order.order_date', 'DESC')
                ->limit(10)
                ->findAll();

            $data['refund_data'] = $refund_data;

            $weekly_sales = $this->getOrderModel()->PreviousWeekOrderSummary('order_delivered');
            $data['weekly_sales'] = $weekly_sales;

            $yearly_sales = $this->getOrderModel()->YearlyOrderSummary('order_delivered');
            $data['yearly_sales'] = $yearly_sales;
            $data['sales'] = array_column($yearly_sales, 'total_sales');
            $data['years'] = array_column($yearly_sales, 'year');



            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, 'Dashboard Updated', $data);
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

    public function finance_dashboard_api()
    {
        try {
            $apc = new AdminPageController();
            $data = [];
            $data['counts'] = $apc->order_dashboard_counts();
            $overview_data = $this->getOrderModel()
                ->select('SUM(IFNULL(order_total, 0)) AS total_order_amount, SUM(IFNULL(total_refund_amount, 0)) AS total_refund_amount')
                ->whereIn('order_status', ['refund_to_customer', 'order_delivered', 'order_exchanged'])
                ->first(); // use first() since we expect a single row result with SUM

            // Store the aggregated data in the respective fields
            $data['total_order_amount'] = $overview_data['total_order_amount'];
            $data['total_refund_amount'] = $overview_data['total_refund_amount'];

            // Calculate revenue
            $data['revenue'] = $data['total_order_amount'] - $data['total_refund_amount'];

            $monthly_sales = $this->getOrderModel()->MonthlyOrderSummary('order_delivered');

            // Prepare data for chart (unchanged)
            $data['monthly_sales'] = $monthly_sales;
            $data['months'] = array_column($monthly_sales, 'month_name');
            $data['sales'] = array_column($monthly_sales, 'total_sales');
            $data['years'] = array_column($monthly_sales, 'year');
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, 'Dashboard Updated', $data);
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

    public function stock_dashboard_api()
    {
        try {

            $data = [];
            $stock_data = $this->getOrderModel()
                ->select('IFNULL(SUM(total_refund_amount), 0) AS refund_amount')
                ->whereIn('order_status', ['refund_to_customer'])
                ->first();

            $data['refund_amount'] = $stock_data['refund_amount'] ?? 0;


            $category_wise_stock = $this->getStockModel()
                ->select('category.category_name,SUM(IFNULL(stock.quantity, 0)) as quantity')
                ->join('product_variant', 'stock.variant_id = product_variant.variant_id', "left")
                ->join('product', 'product_variant.product_id = product.product_id', "left")
                ->join('category', 'product.category_id = category.category_id', "left")
                ->groupBy('category.category_name')
                ->findAll();  // use first() since we expect a single row result with SUM
            $data['total_stock_data'] = array_sum(array_column($category_wise_stock, 'quantity')) ?? 0;
            $data['category_wise_stock'] = $category_wise_stock;
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, 'Dashboard Updated', $data);
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
    public function delivered_dashboard_api()
    {
        try {
            $apc = new AdminPageController();
            $data = [];
            $data['counts'] = $apc->order_dashboard_counts();
            return formatApiResponse($this->request, $this->response, ApiResponseStatusCode::OK, 'Dashboard Updated', $data);
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
    public function top_paying_customer_api()
    {
        try {
            // Load required models
            $orderModel = $this->getOrderModel();
            $customerModel = $this->getCustomerModel();

            // Query: sum of all delivered orders grouped by customer_id
            $builder = $orderModel->select('customer_id, SUM(order_total) as total_spent')
                ->where('order_status', 'order_delivered')
                ->groupBy('customer_id')
                ->orderBy('total_spent', 'DESC')
                ->limit(10); // top 10 customers, adjust if needed

            $topCustomers = $builder->findAll();

            $data = [];
            if (!empty($topCustomers)) {
                $customerIds = array_column($topCustomers, 'customer_id');

                // Fetch customer details
                $customers = $customerModel
                    ->whereIn('customer_id', $customerIds)
                    ->findAll();

                // Index customers by ID for quick lookup
                $customerMap = [];
                foreach ($customers as $cust) {
                    $customerMap[$cust['customer_id']] = $cust;
                }

                // Merge spending data with customer info
                foreach ($topCustomers as $row) {
                    $cust = $customerMap[$row['customer_id']] ?? null;
                    if ($cust) {
                        $data[] = [
                            'customer_id' => $cust['customer_id'],
                            'fullname' => $cust['fullname'],
                            'email' => $cust['email'],
                            'mobile' => $cust['mobile'],
                            'upi' => $cust['customer_upi_id'],
                            'total_spent' => (float) $row['total_spent'],
                        ];
                    }
                }
            }

            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                'Top paying customers fetched successfully',
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
    public function returnable_customer_api()
    {
        try {
            // Load required models
            $orderModel = $this->getOrderModel();
            $customerModel = $this->getCustomerModel();

            // Query: sum of all delivered orders grouped by customer_id
            $builder = $orderModel->select('customer_id, SUM(order_total) as total_spent')
                ->where('order_status', 'refund_to_customer')
                ->groupBy('customer_id')
                ->orderBy('total_spent', 'DESC')
                ->limit(10); // top 10 customers, adjust if needed

            $topCustomers = $builder->findAll();

            $data = [];
            if (!empty($topCustomers)) {
                $customerIds = array_column($topCustomers, 'customer_id');

                // Fetch customer details
                $customers = $customerModel
                    ->whereIn('customer_id', $customerIds)
                    ->findAll();

                // Index customers by ID for quick lookup
                $customerMap = [];
                foreach ($customers as $cust) {
                    $customerMap[$cust['customer_id']] = $cust;
                }

                // Merge spending data with customer info
                foreach ($topCustomers as $row) {
                    $cust = $customerMap[$row['customer_id']] ?? null;
                    if ($cust) {
                        $data[] = [
                            'customer_id' => $cust['customer_id'],
                            'fullname' => $cust['fullname'],
                            'email' => $cust['email'],
                            'mobile' => $cust['mobile'],
                            'upi' => $cust['customer_upi_id'],
                            'total_spent' => (float) $row['total_spent'],
                        ];
                    }
                }
            }

            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                'Top paying customers fetched successfully',
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


    public function getReferrerCustomers_api()
    {
        try {
            $customerModel = $this->getCustomerModel();

            // Get all customers whose reffer_by_id is NULL
            $data = $customerModel
                ->where('reffer_by_id', null)
                ->findAll();

            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                'Referrer customer list fetched successfully',
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
    public function getReferredCustomers_api()
    {
        try {
            $customerModel = $this->getCustomerModel();

            // Get POST values
            $customer_id = $this->request->getPost('customer_id');
            $level       = $this->request->getPost('level');

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
    public function share_reference_customer_list()
    {
        try {

            $shareReferenceModel = $this->getShareReferenceModel();

            // Base query
            $builder = $shareReferenceModel
                ->select("share_reference.*, customer.fullname, product.product_name")
                ->join("customer", "customer.customer_id = share_reference.share_by_customer_id", "left")
                ->join("product", "product.product_id = share_reference.product_id", "left");


            $rows = $builder->findAll();

            if (empty($rows)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::OK,
                    "No shared products found",
                    []
                );
            }

            // Group by product_id + customer
            $final = [];

            foreach ($rows as $row) {

                $key = $row['share_by_customer_id'] . "_" . $row['product_id'];

                if (!isset($final[$key])) {
                    $final[$key] = [
                        "customer_id"   => $row['share_by_customer_id'],
                        "fullname" => $row['fullname'],
                        "product_id"    => $row['product_id'],
                        "product_name"  => $row['product_name'],
                        "sources"       => []
                    ];
                }

                // Add each source inside array
                $final[$key]["sources"][] = [
                    "source_name" => $row["source"],
                    "customer_search_count" => (int)$row["customer_search_count"]
                ];
            }

            // Reset array keys
            $final = array_values($final);

            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                'Share reference list fetched successfully',
                $final
            );
        } catch (Exception $e) {

            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::BAD_REQUEST,
                $e->getMessage(),
                null
            );
        }
    }

    private function getLevel1ReferredQuery()
    {
        $db = \Config\Database::connect();

        $sql = "
        SELECT 
            c.customer_id,
            c.fullname,
            c.mobile,
            c.email,
            IFNULL(ew.total_earning, 0) AS total_earning,
            IFNULL(wd.total_withdrawal, 0) AS total_withdrawal,
            (IFNULL(ew.total_earning, 0) - IFNULL(wd.total_withdrawal, 0)) AS remaining
        FROM customer c
        LEFT JOIN (
            SELECT customer_id, SUM(e_wallet_amount) AS total_earning
            FROM e_wallet
            WHERE is_wallet_active = 1
            GROUP BY customer_id
        ) ew ON ew.customer_id = c.customer_id
       LEFT JOIN (
    SELECT customer_id, SUM(CAST(approved_amount AS DECIMAL(12,2))) AS total_withdrawal
    FROM e_wallet_payment_withdrawals
    WHERE status IN ('paid','purchased')   -- include purchased too
    GROUP BY customer_id
) wd ON wd.customer_id = c.customer_id
        WHERE 
            c.is_patner = 1
            AND (c.refferal_patner_id IS NULL OR c.refferal_patner_id = '')
    ";

        $query = $db->query($sql);

        if (!$query) {
            throw new \Exception("Failed to execute referred customer SQL query.");
        }

        return $query->getResultArray();
    }

    public function getLevel1ReferredEarnCustomer_api()
    {
        try {
            // Step 1 → Get filtered wallet + withdrawal data
            $data = $this->getLevel1ReferredQuery();

            // Step 2 → If empty data
            if (empty($data)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::OK,
                    "No referred customer found",
                    []
                );
            }

            // Step 3 → Return success
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                "Referred customer list fetched successfully",
                $data
            );
        } catch (\Throwable $e) {

            // Step 4 → Error handling
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::BAD_REQUEST,
                "Something went wrong: " . $e->getMessage(),
                null
            );
        }
    }
    private function getLevel2ReferredQuery($customerIds)
    {
        $db = \Config\Database::connect();

        if (!is_array($customerIds)) {
            $customerIds = [$customerIds];
        }

        if (empty($customerIds)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($customerIds), '?'));

        $sql = "
        SELECT 
            c.customer_id,
            c.fullname,
            c.mobile,
            c.email,
            IFNULL(ew.total_earning, 0) AS total_earning,
            IFNULL(wd.total_withdrawal, 0) AS total_withdrawal,
            (IFNULL(ew.total_earning, 0) - IFNULL(wd.total_withdrawal, 0)) AS remaining
        FROM customer c
        LEFT JOIN (
            SELECT customer_id, SUM(e_wallet_amount) AS total_earning
            FROM e_wallet
            WHERE is_wallet_active = 1
            GROUP BY customer_id
        ) ew ON ew.customer_id = c.customer_id
        LEFT JOIN (
    SELECT customer_id, SUM(approved_amount) AS total_withdrawal
    FROM e_wallet_payment_withdrawals
    WHERE status IN ('paid','purchased')
    GROUP BY customer_id
) wd ON wd.customer_id = c.customer_id

         
        WHERE c.customer_id IN ($placeholders)
    ";

        $query = $db->query($sql, $customerIds);

        if (!$query) {
            throw new \Exception("Failed to execute wallet summary SQL query.");
        }

        return $query->getResultArray();
    }


    public function getLevel2ReferredEarnCustomer_api()
    {
        try {
            $data = getRequestData($this->request, 'ARRAY');
            $customerModel = $this->getCustomerModel();

            $customer_id = $data['customer_id'] ?? null;
            $level       = $data['level'] ?? null;

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

            // Check customer exists
            if (!$customerModel->find($customer_id)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::BAD_REQUEST,
                    'Customer not found',
                    []
                );
            }

            $ids = [];

            // ⭐ LEVEL 1
            if ($level == 1) {
                $rows = $customerModel
                    ->select('customer_id')
                    ->where('refferal_patner_id', $customer_id)
                    ->findAll();

                if (!empty($rows)) {
                    $ids = array_column($rows, 'customer_id');
                }
            }

            // ⭐ LEVEL 2
            else if ($level == 2) {

                // Step 1 → get LEVEL-1 ids
                $level1 = $customerModel
                    ->select('customer_id')
                    ->where('refferal_patner_id', $customer_id)
                    ->findAll();

                if (!empty($level1)) {

                    $level1_ids = array_column($level1, 'customer_id');

                    // Step 2 → get Level-2 ids
                    $level2 = $customerModel
                        ->select('customer_id')
                        ->whereIn('refferal_patner_id', $level1_ids)
                        ->findAll();

                    if (!empty($level2)) {
                        $ids = array_column($level2, 'customer_id');
                    }
                }
            }

            // If no referred users
            if (empty($ids)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::OK,
                    'No referred customers found',
                    []

                );
            }

            // Fetch wallet summary
            $result = $this->getLevel2ReferredQuery($ids);
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                'Referred customer list fetched successfully',
                $result
            );
        } catch (\Throwable $e) {

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

    public function getWithdrawalRequestList_api()
    {
        try {
            $access_data = getRequestData($this->request, 'ARRAY');
            $status = $access_data['status'] ?? null;

            $WithdrawalModel = $this->getEWallePaymentWithdrawlModel();

            $builder = $WithdrawalModel
                ->select("
            e_wallet_payment_withdrawals.*,
            customer.fullname,
            customer.email,
            customer.mobile,

            (
                -- Total wallet earned
                (SELECT IFNULL(SUM(w.e_wallet_amount), 0)
                 FROM e_wallet w
                 WHERE w.customer_id = e_wallet_payment_withdrawals.customer_id
                 AND w.is_wallet_active = 1
                )
                -
                -- Total deducted (paid + purchased)
                (SELECT IFNULL(SUM(wd.approved_amount), 0)
                 FROM e_wallet_payment_withdrawals wd
                 WHERE wd.customer_id = e_wallet_payment_withdrawals.customer_id
                 AND wd.status IN ('paid', 'purchased')
                )
            ) AS current_balance
        ")
                ->join('customer', 'customer.customer_id = e_wallet_payment_withdrawals.customer_id', 'left');

            // Filter by status if provided
            if (!empty($status)) {
                $statusArray = array_map('trim', explode(',', $status));
                $builder->whereIn('e_wallet_payment_withdrawals.status', $statusArray);
            }

            $data = $builder->findAll();

            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                'Withdrawal request list fetched successfully',
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

    public function getUpdateWithdrawalRequest_api()
    {
        try {
            $data = getRequestData($this->request, 'ARRAY');
            $validation = \Config\Services::validation();
            $validation->setRules([
                'withdrawal_id'     => 'required',
                'customer_id'       => 'required|is_natural_no_zero',
                'requested_amount'  => 'required|decimal',
                'status'            => 'required|in_list[pending,approved,rejected,processing,paid]',
                'remark'            => 'permit_empty',
                'payment_method'    => 'permit_empty',
                'transaction_id'    => 'permit_empty',
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

            $withdrawModel = $this->getEWallePaymentWithdrawlModel();

            // --------------------------------------------
            //   CHECK IF withdrawal_id EXISTS (UPDATE CASE)
            // --------------------------------------------

            if (!empty($data['withdrawal_id'])) {

                $existing = $withdrawModel->find($data['withdrawal_id']);

                if (!$existing) {
                    return formatApiResponse(
                        $this->request,
                        $this->response,
                        ApiResponseStatusCode::BAD_REQUEST,
                        "Invalid withdrawal_id. Record not found!",
                        []
                    );
                }

                // 🔄 UPDATE RECORD
                $withdrawModel->update($data['withdrawal_id'], $data);

                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::OK,
                    "Withdrawal Request Updated Successfully",
                    $withdrawModel->find($data['withdrawal_id'])
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

    // customer delhivery creation API
    public function createShipping()
    {
        try {
            $data = getRequestData($this->request, 'ARRAY');

            // Required validation (as per doc)
            $required = ['name', 'order', 'phone', 'add', 'pin', 'pickup_location', 'city', 'state'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    return formatApiResponse(
                        $this->request,
                        $this->response,
                        ApiResponseStatusCode::BAD_REQUEST,
                        "Missing required field: {$field}"
                    );
                }
            }

            $token = $_ENV['DelhiveryAPIToken'] ?? '';
            if (!$token) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::UNAUTHORIZED,
                    'Delhivery API token missing'
                );
            }

            $postData = [
                'format' => 'json',
                'data' => json_encode([
                    "pickup_location" => [
                        "name" => trim($data['pickup_location'])
                    ],
                    "shipments" => [
                        [
                            "order"        => $data['order'],
                            "name"         => $data['name'],
                            "phone"        => (string) $data['phone'],
                            "add"          => $data['add'],
                            "city"         => $data['city'],
                            "pin"          => (string) $data['pin'],
                            "state"        => $data['state'],
                            "country"      => $data['country'] ?? 'India',
                            "payment_mode" => ($data['cod_amount'] ?? 0) > 0 ? "COD" : "Prepaid",
                            "total_amount" => $data['total_amount'] ?? 0,
                            "weight"       => $data['weight'] ?? 500
                        ]
                    ]
                ])
            ];

            $response = $this->apiCall(
                'https://track.delhivery.com/api/cmu/create.json',
                'POST',
                $postData,
                [
                    'Authorization' => 'Token ' . $token,
                    'Content-Type'  => 'application/x-www-form-urlencoded',
                    'Accept'        => 'application/json'
                ]
            );


            // 1️⃣ Empty / no response
            if (empty($response)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::SERVICE_UNAVAILABLE,
                    'Empty response from Delhivery'
                );
            }

            // 2️⃣ Delhivery returned failure
            if (
                (isset($response['success']) && $response['success'] === false)
                || (isset($response['error']) && $response['error'] === true)
            ) {

                // Extract best possible error message
                $errorMessage = $response['rmk'] ?? 'Delhivery shipment creation failed';

                // Package level error (MOST IMPORTANT)
                if (!empty($response['packages'][0]['remarks'])) {
                    $errorMessage = $response['packages'][0]['remarks'];
                }

                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::BAD_REQUEST,
                    $errorMessage,
                    null,
                    $response
                );
            }

            // 3️⃣ Success case
            if (isset($response['success']) && $response['success'] === true) {
                $orderModel = $this->getOrderModel();
                $waybill = $response['packages'][0]['waybill'] ?? null;
                $refnum = $response['packages'][0]['refnum'] ?? null;
                if (!empty($waybill) && !empty($refnum)) {

                    $orderData = [
                        'delhivery_waybill' => $waybill
                    ];
                    $order_data = $this->getOrderModel()->where('order_number', $refnum)->first();
                    $this->getOrderModel()->RecordUpdate($orderData, $order_data['order_id']);
                }
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::OK,
                    'Shipment created successfully',
                    $response
                );
            }
        } catch (\Throwable $e) {
            log_message('error', 'Delhivery Shipment Error: ' . $e->getMessage());

            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::INTERNAL_SERVER_ERROR,
                'Something went wrong while creating shipment'
            );
        }
    }

    public function cancelShipping()
    {
        try {
            $data = getRequestData($this->request, 'ARRAY');

            // Required validation
            if (empty($data['waybill'])) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::BAD_REQUEST,
                    "Missing required field waybill"
                );
            }

            $token = $_ENV['DelhiveryAPIToken'] ?? '';
            if (!$token) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::UNAUTHORIZED,
                    'Delhivery API token missing'
                );
            }

            // ✅ CORRECT PAYLOAD
            $postData = [
                'waybill'      => (string) $data['waybill'],
                'cancellation' => 'true'
            ];

            $response = $this->apiCall(
                'https://track.delhivery.com/api/p/edit',
                'POST',
                $postData,
                [
                    'Authorization' => 'Token ' . $token,
                    'Content-Type'  => 'application/json'
                ]
            );

            // Empty response
            if (empty($response)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::SERVICE_UNAVAILABLE,
                    'Empty response from Delhivery'
                );
            }

            // Failure
            if (
                (isset($response['success']) && $response['success'] === false)
                || (isset($response['error']) && $response['error'] === true)
            ) {
                $errorMessage = $response['rmk'] ?? 'Shipment cancellation failed';

                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::BAD_REQUEST,
                    $errorMessage,
                    null,
                    $response
                );
            }

            // Success
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                'Shipment cancelled successfully',
                $response
            );
        } catch (\Throwable $e) {
            log_message('error', 'Delhivery Cancel Error: ' . $e->getMessage());

            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::INTERNAL_SERVER_ERROR,
                'Something went wrong while cancelling shipment'
            );
        }
    }

    public function pickupShipping()
    {
        try {
            $data = getRequestData($this->request, 'ARRAY');

            $required = ['pickup_location', 'pickup_date', 'pickup_time', 'expected_package_count'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    return formatApiResponse(
                        $this->request,
                        $this->response,
                        ApiResponseStatusCode::BAD_REQUEST,
                        "Missing required field: {$field}"
                    );
                }
            }

            $token = $_ENV['DelhiveryAPIToken'] ?? '';
            if (!$token) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::UNAUTHORIZED,
                    'Delhivery API token missing'
                );
            }


            $response = $this->apiCall(
                'https://track.delhivery.com/fm/request/new/',
                'POST',
                $data,
                [
                    'Authorization' => 'Token ' . $token,
                    'Content-Type'  => 'application/json'
                ]
            );

            // Empty response
            $response = $this->apiCall(
                'https://track.delhivery.com/fm/request/new/',
                'POST',
                $data,
                [
                    'Authorization' => 'Token ' . $token,
                    'Content-Type'  => 'application/json'
                ]
            );

            // HTTP error handling
            if (!isset($response['http_code']) || $response['http_code'] >= 400) {
                if (!empty($response['prepaid'])) {
                    $errorMsg = $response['prepaid'];
                } else {
                    $errorMsg = 'Pickup request failed';
                }

                if (isset($response['body']['prepaid'])) {
                    $errorMsg = $response['body']['prepaid'];
                } elseif (isset($response['body']['rmk'])) {
                    $errorMsg = $response['body']['rmk'];
                }

                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::BAD_REQUEST,
                    $errorMsg,
                    null,
                    $response['body'] ?? $response
                );
            }

            // ✅ SUCCESS
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                'Shipment pickup requested successfully',
                $response['body']
            );
        } catch (\Throwable $e) {
            log_message('error', 'Delhivery Cancel Error: ' . $e->getMessage());

            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::INTERNAL_SERVER_ERROR,
                'Something went wrong while picking up shipment'
            );
        }
    }


    public function trackingShipping()
    {

        $data = getRequestData($this->request, 'ARRAY');
        $required = ['ref_ids', 'waybill'];
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

        // ✅ apiCall returns ARRAY
        $response = $this->apiCall(
            "https://track.delhivery.com/api/v1/packages/json/",
            'GET',
            [
                'waybill' => $data['waybill'],
                'ref_ids' => $data['ref_ids'],
            ],
            [
                'Authorization' => 'Bearer ' . $token,
                'Accept'        => 'application/json'
            ]
        );


        if (empty($response)) {
            return GetformatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::SERVICE_UNAVAILABLE,
                'Empty response from Delhivery'
            );
        }

        // Failure
        if (
            (isset($response['success']) && $response['success'] === false)
            || (isset($response['error']) && $response['error'] === true)
        ) {

            return GetformatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::BAD_REQUEST,
                $response
            );
        }

        // Success
        return GetformatApiResponse(
            $this->request,
            $this->response,
            ApiResponseStatusCode::OK,
            'Shipment tracked successfully',
            $response
        );
    }

    public function returnShipping()
    {
        try {
            $data = getRequestData($this->request, 'ARRAY');

            /* ================= REQUIRED FIELDS ================= */
            $required = [
                'order',
                'name',
                'phone',
                'add',
                'city',
                'pin',
                'state',
                'country',
                'waybill',
                'return_add',
                'return_city',
                'return_pin',
                'return_state',
                'pickup_location',
                'order_date',
                'quantity',
                'image',
                'qc_question_id'
            ];

            foreach ($required as $field) {
                if (empty($data[$field])) {
                    return formatApiResponse(
                        $this->request,
                        $this->response,
                        ApiResponseStatusCode::BAD_REQUEST,
                        "Missing required field: {$field}"
                    );
                }
            }

            /* ================= IMAGE ARRAY (MANDATORY) ================= */
            $images = array_map('trim', explode(',', $data['image']));
            if (empty($images)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::BAD_REQUEST,
                    "QC images are mandatory"
                );
            }

            $token = $_ENV['DelhiveryAPIToken'];

            /* ================= PAYLOAD ================= */
            $payloadData = [
                'pickup_location' => [
                    'name' => trim($data['pickup_location'])
                ],
                'shipments' => [
                    [
                        // BASIC SHIPMENT DETAILS
                        'client' => 'HILLMEN LIFESTYLE PRIVATE LIMITED',
                        'name' => $data['name'],
                        'phone' => $data['phone'],  // Use actual phone from data
                        'add' => $data['add'],  // Use actual address from data
                        'city' => $data['city'],
                        'pin' => (string)$data['pin'],
                        'state' => $data['state'],
                        'country' => $data['country'],

                        // ORDER DETAILS
                        'order' => $data['order'],
                        'waybill' => (string)$data['waybill'],
                        'payment_mode' => ((float)($data['cod_amount'] ?? 0) > 0) ? 'COD' : 'Prepaid',
                        'order_date' => date('d-m-Y', strtotime($data['order_date'])),
                        'quantity' => (int)$data['quantity'],
                        'weight' => (($data['weight'] ?? 200) . ' gm'),
                        'total_amount' => (float)($data['total_amount'] ?? 0),

                        // PRODUCT DETAILS (MANDATORY from example)
                        'products_desc' => $data['products_desc'] ?? 'Return Product',
                        'shipping_mode' => $data['shipping_mode'] ?? 'Express',
                        'seller_name' => $data['seller_name'] ?? 'Seller',
                        'seller_gst_tin' => $data['seller_gst_tin'] ?? '',

                        // RETURN DETAILS
                        'return_name' => $data['return_name'] ?? $data['name'],
                        'return_add' => '1st floor, 18, Shanku Marg, above SBI Bank SME Branch, Freeganj, Madhav Nagar, Ujjain, Madhya Pradesh 456010',
                        'return_city' => $data['return_city'],
                        'return_pin' => (string)$data['return_pin'],
                        'return_state' => $data['return_state'],
                        'return_country' => $data['country'],
                        'return_phone' => '7974822832',  // Use same phone or add return_phone field

                        // QC CONFIG - IMPORTANT FOR RVP QC 3.0
                        'qc_type' => 'param',  // Fixed value as per documentation

                        'custom_qc' => [
                            [
                                'item' => $data['item'] ?? 'product',
                                'description' => $data['description'] ?? 'Returned product QC',
                                'images' => $images,
                                'quantity' => (int)$data['quantity'],
                                'return_reason' => $data['return_reason'] ?? 'Customer Return',
                                'brand' => $data['brand'] ?? '',  // Add if available
                                'product_category' => $data['product_category'] ?? '',  // Add if available

                                'questions' => [
                                    [
                                        'questions_id' => $data['qc_question_id'],
                                        'options' => ['Yes', 'No'],  // Provide actual options
                                        'value' => ['Yes'],  // Correct answer
                                        'required' => true,
                                        'type' => 'multi',  // or 'varchar' based on your requirement
                                        'ques_images' => []  // Optional: add if you have question-specific images
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ];

            /* ================= API CALL ================= */
            // Note: The API expects form-urlencoded with 'data' as JSON string
            $payload = [
                'format' => 'json',
                'data' => json_encode($payloadData)
            ];

            $response = $this->apiCall(
                'https://track.delhivery.com/api/cmu/create.json',  // Use production URL
                'POST',
                $payload,
                [
                    'Authorization' => 'Token ' . $token,
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ]
            );

            if (empty($response)) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::SERVICE_UNAVAILABLE,
                    'Empty response from Delhivery'
                );
            }

            // Check for error in response
            if (isset($response['success']) && $response['success'] === false) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::BAD_REQUEST,
                    $response['rmk'] ?? $response['message'] ?? 'Return shipment failed',
                    null,
                    $response
                );
            }

            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                'Return shipment created successfully',
                $response
            );
        } catch (\Throwable $e) {
            log_message('error', 'Delhivery API Error: ' . $e->getMessage() . ' - ' . $e->getTraceAsString());

            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::INTERNAL_SERVER_ERROR,
                'Something went wrong: ' . $e->getMessage()
            );
        }
    }

    //end

    public function sendOfferCouponNotification()
    {
        try {
            $data = getRequestData($this->request, 'ARRAY');
            $required = ['type', 'action', 'title', 'discount', 'image'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    return formatApiResponse(
                        $this->request,
                        $this->response,
                        ApiResponseStatusCode::BAD_REQUEST,
                        "Not Send Notification Customer and Admin"
                    );
                }
            }
            $FC = new FirebaseController();

            /*
         * Expected $data structure:
         * [
         *   'type' => 'coupon' | 'offer',
         *   'action' => 'created' | 'updated',
         *   'title' => 'DIWALI50',
         *   'discount' => '50%',
         *   'redirect_url' => 'url',
         *   'image' => 'logo path'
         * ]
         */

            $typeLabel   = ucfirst($data['type']);   // Coupon / Offer
            $actionLabel = ucfirst($data['action']); // Created / Updated

            /* ================= ADMIN NOTIFICATION ================= */

            $admins = $this->getUserModel()
                ->select('user_id')
                ->where('user_type', 'admin')
                ->findAll();

            foreach ($admins as $admin) {
                $FC->sendNotificationToUser(
                    $admin['user_id'],
                    "🎯 {$typeLabel} {$actionLabel}!",
                    "{$typeLabel} '{$data['title']}' has been {$actionLabel}. Discount: {$data['discount']}.",
                    $data['redirect_url'],
                    $data['image']
                );
            }

            /* ================= CUSTOMER NOTIFICATION ================= */

            $customers = $this->getCustomerModel()
                ->select('customer_id')
                ->findAll();

            foreach ($customers as $customer) {
                $FC->sendNotificationToCustomer(
                    $customer['customer_id'],
                    "🔥 New {$typeLabel} Available!",
                    "Use {$data['title']} & get {$data['discount']} off. Hurry! ⏰",
                    $data['redirect_url'],
                    $data['image']
                );
            }

            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::OK,
                'Notification sent successfully',
                $data
            );
        } catch (\Throwable $e) {
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

    // refund with razorpay
    public function customer_order_payment_refund_razorpay()
    {
        try {
            $wpm = $this->getWebsiteProfileModel();
            $website_data = $wpm->first();
            $firm_logo = $website_data['firm_logo_url'] ?? '';
            $data = getRequestData($this->request, 'ARRAY');
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
            $orderPayment = $this->getOrderPaymentModel()->where('order_id', $data['order_id'])->first();

            // ❗ Amounts DB se lo (NOT frontend)
            $orderAmount          = (float) $data['paid_amount'];
            $returnShippingCharge = (float) $data['return_shipping_charge'];

            $refundAmount = $orderAmount - $returnShippingCharge;

            if ($refundAmount <= 0) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::BAD_REQUEST,
                    "Refund amount invalid"
                );
            }

            $razorpayService = new RazorpayController();
            $refundData = $razorpayService->createReturnRefund(
                $orderPayment['razorpay_payment_id'],
                $refundAmount,
                $returnShippingCharge
            );

            if ($refundData === null) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::BAD_REQUEST,
                    "Refund failed"
                );
            }

            // ✅ order table Single DB update
            $updateData = [
                'refund_transaction_id' => $refundData['refund_id'],
            ];

            $response = $OrderModel->update($data['order_id'], $updateData);

            if ($response === false) {
                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::INTERNAL_SERVER_ERROR,
                    "Refund initiation failed"
                );
            } else {

                $FC = new FirebaseController();

                //  Admin notification
                $admins = $this->getUserModel()
                    ->select('user_id')
                    ->where('user_type', 'admin')
                    ->findAll();

                foreach ($admins as $admin) {
                    $FC->sendNotificationToUser(
                        $admin['user_id'],
                        "💸 Refund Initiated",
                        "Refund initiated for Order #{$data['order_id']}. Amount: ₹{$refundAmount}. Please review.",
                        base_url(route_to('refund_to_customer')),
                        $firm_logo
                    );
                }

                // 🔔 Customer notification
                if ($data['purpose'] == 'return')
                    $FC->sendNotificationToCustomer(
                        $data['customer_id'],
                        "💸 Refund Initiated Successfully",
                        "Your refund for Order #{$data['order_id']} has been initiated. ₹{$returnShippingCharge} deducted as return shipping charges. Amount will be credited soon.",
                        '',
                        $_ENV['app.baseURL'] . $firm_logo
                    );
                else {
                    $FC->sendNotificationToCustomer(
                        $data['customer_id'],
                        "💸 Refund Initiated Successfully",
                        "Your refund for Order #{$data['order_id']}. Amount will be credited soon.",
                        '',
                        $_ENV['app.baseURL'] . $firm_logo
                    );
                }

                return formatApiResponse(
                    $this->request,
                    $this->response,
                    ApiResponseStatusCode::OK,
                    "Refund initiated successfully"
                );
            }
        } catch (\Exception $e) {
            return formatApiResponse(
                $this->request,
                $this->response,
                ApiResponseStatusCode::INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }
    }
}
