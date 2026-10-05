<?php

namespace App\Traits;
// Firebase Messaging Notification
use App\Models\FirebaseMessagingTokenModel;
use App\Models\FirebaseMessagingNotificationModel;
use App\Models\CountryModel;
use App\Models\StateModel;
use App\Models\CityModel;

use App\Models\CustomerModel;
use App\Models\CustomerTokenModel;

use App\Models\FunctionModel;
use App\Models\BrandModel;
use App\Models\CategoryModel;
use App\Models\CategoryTypeModel;
use App\Models\ProductModel;
use App\Models\SizeModel;
use App\Models\UserModel;
use App\Models\UserTokenModel;

use App\Controllers\EmailController;
use App\Controllers\OAuthController;
use App\Controllers\RazorpayController;
use App\Controllers\SmsController;
use App\Models\BlogPostModel;
use App\Models\ColorModel;
use App\Models\ContactUsModel;
use App\Models\UnitModel;
use App\Models\ProductVariantModel;
use App\Models\SizeVsVariantModel;
use App\Models\FeatureTypeModel;
use App\Models\FeatureModel;
use App\Models\FormSubmissionsModel;
use App\Models\OfferItemModel;
use App\Models\OfferModel;
use App\Models\ProductVsFeatureModel;
use App\Models\StockModel;
use App\Models\SubscribersListModel;
use App\Models\WebsiteProfileModel;
use App\Models\CouponModel;
use App\Models\CustomerAddressModel;
use App\Models\CustomerCartModel;
use App\Models\CustomerReviewModel;
use App\Models\CustomerWishlistModel;
use App\Models\OTPVerificationModel;
use App\Models\TopSearchModel;

use App\Models\CustomerCartSummaryModel;
use App\Models\CustomerOrderItemModel;

use App\Models\CustomerWishlistSummaryModel;
use App\Models\FaqModel;
use App\Models\OrderItemModel;
use App\Models\OrderLogModel;
use App\Models\OrderModel;
use App\Models\OrderPaymentModel;
use App\Models\ReviewSummaryModel;
use App\Models\ShareReferenceModel;
use App\Models\SubscriptionModel;
use App\Models\ThirdPartyIntegrationModel;
use App\Models\TopSearchSummaryModel;
use App\Models\TemplateModel;
use App\Models\EWalletModel;
use App\Models\EWallePaymentWithdrawlModel;
trait CommonTraits
{
    /**
     * Return Model Instance
     * @return ProductVsFeatureModel
     */
    public static function getProductVsFeatureModel()
    {
        return new ProductVsFeatureModel();
    }
    /**
     * Return Model Instance
     * @return FeatureModel
     */
    public static function getFeatureModel()
    {
        return new FeatureModel();
    }
    /**
     * Return Model Instance
     * @return FeatureTypeModel
     */
    public static function getFeatureTypeModel()
    {
        return new FeatureTypeModel();
    }
    /**
     * Return Model Instance
     * @return FirebaseMessagingTokenModel
     */
    public static function getFirebaseMessagingTokenModel()
    {
        return new FirebaseMessagingTokenModel();
    }
    /**
     * Return Model Instance
     * @return FirebaseMessagingNotificationModel
     */
    public static function getFirebaseMessagingNotificationModel()
    {
        return new FirebaseMessagingNotificationModel();
    }

    /**
     * Return Model Instance
     * @return CountryModel
     */
    public static function getCountryModel()
    {
        return new CountryModel();
    }
    /**
     * Return Model Instance
     * @return StateModel
     */
    public static function getStateModel()
    {
        return new StateModel();
    }
    /**
     * Return Model Instance
     * @return CityModel
     */
    public static function getCityModel()
    {
        return new CityModel();
    }
    // /**
    //  * Return Model Instance
    //  * @return CustomerAddressModel
    //  */
    // public static function getCustomerAddressModel()
    // {
    //     return new CustomerAddressModel();
    // }

    // /**
    //  * Return Model Instance
    //  * @return CustomerVerificationModel
    //  */
    // public static function getCustomerVerificationModel()
    // {
    //     return new CustomerVerificationModel();
    // }
    // /**
    //  * Return Model Instance
    //  * @return CustomerWishlistModel
    //  */
    // public static function getCustomerWishlistModel()
    // {
    //     return new CustomerWishlistModel();
    // }
    /**
     * Return Model Instance
     * @return FunctionModel
     */
    public static function getFunctionModel()
    {
        return new FunctionModel();
    }
    /**
     * Return Model Instance
     * @return BrandModel
     */
    public static function getBrandModel()
    {
        return new BrandModel();
    }
    /**
     * Return Model Instance
     * @return CategoryModel
     */
    public static function getCategoryModel()
    {
        return new CategoryModel();
    }
    /**
     * Return Model Instance
     * @return ProductModel
     */
    public static function getProductModel()
    {
        return new ProductModel();
    }
    /**
     * Return Model Instance
     * @return SizeModel
     */
    public static function getSizeModel()
    {
        return new SizeModel();
    }
    /**
     * Return Model Instance
     * @return UserModel
     */
    public static function getUserModel()
    {
        return new UserModel();
    }
    /**
     * Return Model Instance
     * @return CategoryTypeModel
     */
    public static function getCategoryTypeModel()
    {
        return new CategoryTypeModel();
    }
    /**
     * Return Model Instance
     * @return UserTokenModel
     */
    public static function getUserTokenModel()
    {
        return new UserTokenModel();
    }


    /**
     * Return Model Instance
     * @return EmailController
     */
    public static function getEmailController()
    {
        return new EmailController();
    }

    /**
     * Return Model Instance
     * @return UnitModel
     */
    public static function getUnitModel()
    {
        return new UnitModel();
    }

    /**
     * Return Model Instance
     * @return ProductVariantModel
     */
    public static function getProductVariantModel()
    {
        return new ProductVariantModel();
    }

    /**
     * Return Model Instance
     * @return SizeVsVariantModel
     */
    public static function getSizeVsVariantModel()
    {
        return new SizeVsVariantModel();
    }

    /**
     * Return Model Instance
     * @return ColorModel
     */
    public static function getColorModel()
    {
        return new ColorModel();
    }

    /**
     * Return Model Instance
     * @return StockModel
     */
    public static function getStockModel()
    {
        return new StockModel();
    }

    /**
     * Return Model Instance
     * @return WebsiteProfileModel
     */
    public static function getWebsiteProfileModel()
    {
        return new WebsiteProfileModel();
    }

    /**
     * Return Model Instance
     * @return SubscribersListModel
     */
    public static function getSubscribersListModel()
    {
        return new SubscribersListModel();
    }

    /**
     * Return Model Instance
     * @return FormSubmissionsModel
     */
    public static function getFormSubmissionsModel()
    {
        return new FormSubmissionsModel();
    }

    /**
     * Return Model Instance
     * @return BlogPostModel
     */
    public static function getBlogPostModel()
    {
        return new BlogPostModel();
    }


    /**
     * Return Model Instance
     * @return CouponModel
     */
    public static function getCouponModel()
    {
        return new CouponModel();
    }
    /**
     * Return Model Instance
     * @return OfferModel
     */
    public static function getOfferModel()
    {
        return new OfferModel();
    }
    /**
     * Return Model Instance
     * @return OfferItemModel
     */
    public static function getOfferItemModel()
    {
        return new OfferItemModel();
    }
    /**
     * Return Model Instance
     * @return CustomerModel
     */
    public static function getCustomerModel()
    {
        return new CustomerModel();
    }
    /**
     * Return Model Instance
     * @return OTPVerificationModel
     */
    public static function getOTPVerificationModel()
    {
        return new OTPVerificationModel();
    }
    /**
     * Return Model Instance
     * @return CustomerTokenModel
     */
    public static function getCustomerTokenModel()
    {
        return new CustomerTokenModel();
    }
    /**
     * Return Model Instance
     * @return CustomerAddressModel
     */
    public static function getCustomerAddressModel()
    {
        return new CustomerAddressModel();
    }
    /**
     * Return Model Instance
     * @return CustomerCartModel
     */
    public static function getCustomerCartModel()
    {
        return new CustomerCartModel();
    }
    /**
     * Return Model Instance
     * @return CustomerWishlistModel
     */
    public static function getCustomerWishlistModel()
    {
        return new CustomerWishlistModel();
    }
    /**
     * Return Model Instance
     * @return TopSearchModel
     */
    public static function getTopSearchModel()
    {
        return new TopSearchModel();
    }

    /**
     * Return Model Instance
     * @return CustomerReviewModel
     */
    public static function getCustomerReviewModel()
    {
        return new CustomerReviewModel();
    }

    /**
     * Return Model Instance
     * @return ContactUsModel
     */
    public static function getContactUsModel()
    {
        return new ContactUsModel();
    }
    /**
     * Return Model Instance
     * @return CustomerCartSummaryModel
     */
    public static function getCustomerCartSummaryModel()
    {
        return new CustomerCartSummaryModel();
    }
    /**
     * Return Model Instance
     * @return CustomerOrderItemModel
     */
    public static function getCustomerOrderItemModel()
    {
        return new CustomerOrderItemModel();
    }

    /**
     * Return Model Instance
     * @return CustomerWishlistSummaryModel
     */
    public static function getCustomerWishlistSummaryModel()
    {
        return new CustomerWishlistSummaryModel();
    }
    /**
     * Return Model Instance
     * @return OrderItemModel
     */
    public static function getOrderItemModel()
    {
        return new OrderItemModel();
    }
    /**
     * Return Model Instance
     * @return OrderLogModel
     */
    public static function getOrderLogModel()
    {
        return new OrderLogModel();
    }
    /**
     * Return Model Instance
     * @return OrderModel
     */
    public static function getOrderModel()
    {
        return new OrderModel();
    }
    /**
     * Return Model Instance
     * @return OrderPaymentModel
     */
    public static function getOrderPaymentModel()
    {
        return new OrderPaymentModel();
    }
    /**
     * Return Model Instance
     * @return ReviewSummaryModel
     */
    public static function getReviewSummaryModel()
    {
        return new ReviewSummaryModel();
    }
    /**
     * Return Model Instance
     * @return ShareReferenceModel
     */
    public static function getShareReferenceModel()
    {
        return new ShareReferenceModel();
    }
    /**
     * Return Model Instance
     * @return SubscriptionModel
     */
    public static function getSubscriptionModel()
    {
        return new SubscriptionModel();
    }
    /**
     * Return Model Instance
     * @return TopSearchSummaryModel
     */
    public static function getTopSearchSummaryModel()
    {
        return new TopSearchSummaryModel();
    }
    /**
     * Return Model Instance
     * @return FaqModel
     */
    public static function getFaqModel()
    {
        return new FaqModel();
    }

    /**
     * Return Model Instance
     * @return ThirdPartyIntegrationModel
     */
    public static function getThirdPartyIntegrationModel()
    {
        return new ThirdPartyIntegrationModel();
    }

    /**
     * Return Model Instance
     * @return SmsController
     */
    public static function getSmsController()
    {
        return new SmsController();
    }
    /**
     * Return Model Instance
     * @return RazorpayController
     */
    public static function getRazorpayController()
    {
        return new RazorpayController();
    }
    /**
     * Return Model Instance
     * @return OAuthController
     */
    public static function getOAuthController()
    {
        return new OAuthController();
    }
    /**
     * Return Model Instance
     * @return TemplateModel
     */
    public static function getTemplateModel()
    {
        return new TemplateModel();
    }

     /**
     * Return Model Instance
     * @return EWalletModel
     */
    public static function getEWalletModel()
    {
        return new EWalletModel();
    }

    /**
     * Return Model Instance
     * @return EWallePaymentWithdrawlModel
     */
    public static function getEWallePaymentWithdrawlModel()
    {
        return new EWallePaymentWithdrawlModel();
    }
}
