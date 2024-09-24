<?php
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\HomeAdvertisementController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CustomerController as CustomerControllerForAdmin;
use App\Http\Controllers\Admin\DashboardController as DashboardControllerForAdmin;
use App\Http\Controllers\Admin\DynamicPageController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Admin\LoginController as LoginControllerForAdmin;
use App\Http\Controllers\Admin\PageAboutController;
use App\Http\Controllers\Admin\PageBlogController;
use App\Http\Controllers\Admin\PageContactController;
use App\Http\Controllers\Admin\PagePricingController;
use App\Http\Controllers\Admin\PagePropertyCategoryController;
use App\Http\Controllers\Admin\PagePropertyLocationController;
use App\Http\Controllers\Admin\PagePropertyController;
use App\Http\Controllers\Admin\PageFaqController;
use App\Http\Controllers\Admin\PageHomeController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PageOtherController;
use App\Http\Controllers\Admin\PagePrivacyController;
use App\Http\Controllers\Admin\PageTermController;
use App\Http\Controllers\Admin\CategoryController as CategoryControllerForAdmin;
use App\Http\Controllers\Admin\BlogController as BlogControllerForAdmin;
use App\Http\Controllers\Admin\AmenityController as AmenityControllerForAdmin;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\PropertyCategoryController as PropertyCategoryControllerForAdmin;
use App\Http\Controllers\Admin\PropertyLocationController as PropertyLocationControllerForAdmin;
use App\Http\Controllers\Admin\PropertyController as PropertyControllerForAdmin;
use App\Http\Controllers\Admin\UnderConstructionPropertyController as UnderConstructionPropertyControllerForAdmin;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SocialMediaItemController;
use App\Http\Controllers\Admin\FaqController as FaqControllerForAdmin;
use App\Http\Controllers\Admin\RoleController as RoleControllerForAdmin;
use App\Http\Controllers\Admin\PackageController as PackageControllerForAdmin;
use App\Http\Controllers\Admin\PurchaseHistoryController as PurchaseHistoryControllerForAdmin;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\ClearDatabaseController;
use App\Http\Controllers\Admin\PageDreamPropertyController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ManageAdminController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\SubModuleController;
use App\Http\Controllers\Admin\TradeController;

use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\WithdrawController;
use App\Http\Controllers\Admin\RewardController;
use App\Http\Controllers\Admin\VolunteerController;
use App\Http\Controllers\Admin\VillageController;
use App\Http\Controllers\Admin\EventCategoryController;
use App\Http\Controllers\Admin\AttendeesController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\AppLanguageController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\VisitorController;

use App\Models\Notification;

use Illuminate\Support\Facades\Route;


/* --------------------------------------- */
/* --------------------------------------- */
/* --------------------------------------- */
/* ADMIN SECTION */
/* --------------------------------------- */
/* --------------------------------------- */
/* --------------------------------------- */

/* --------------------------------------- */
/* Login and profile management */
/* --------------------------------------- */

// In web.php or api.php

Route::post('/change-status', [VolunteerController::class, 'changeStatus']);
Route::post('/submit-rejection-reason', [VolunteerController::class, 'submitRejectionReason']);

Route::get('admin/dashboard', [DashboardControllerForAdmin::class,'index'])
    ->name('admin_dashboard');

Route::get('admin', function () {return redirect('admin/login');});

Route::get('admin/login', [LoginControllerForAdmin::class,'login'])
    ->name('admin_login');

Route::post('admin/login/store', [LoginControllerForAdmin::class,'login_check'])
    ->name('admin_login_store');

Route::get('admin/logout', [LoginControllerForAdmin::class,'logout'])
    ->name('admin_logout');

Route::get('admin/forget-password', [LoginControllerForAdmin::class,'forget_password'])
    ->name('admin_forget_password');

Route::post('admin/forget-password/store', [LoginControllerForAdmin::class,'forget_password_check'])
    ->name('admin_forget_password_store');

Route::get('admin/reset-password/{token}/{email}', [LoginControllerForAdmin::class,'reset_password']);

Route::post('admin/reset-password/update', [LoginControllerForAdmin::class,'reset_password_update'])
    ->name('admin_reset_password_update');

Route::get('admin/password-change', [ProfileController::class,'password'])
    ->name('admin_password_change');

Route::post('admin/password-change/update', [ProfileController::class,'password_update'])
    ->name('admin_password_change_update');

Route::get('admin/profile-change', [ProfileController::class,'profile'])
    ->name('admin_profile_change');

Route::post('admin/profile-change/update', [ProfileController::class,'profile_update'])
    ->name('admin_profile_change_update');

Route::get('admin/photo-change', [ProfileController::class,'photo'])
    ->name('admin_photo_change');

Route::post('admin/photo-change/update', [ProfileController::class,'photo_update'])
    ->name('admin_photo_change_update');

Route::get('admin/banner-change', [ProfileController::class,'banner'])
    ->name('admin_banner_change');

Route::post('admin/banner-change/update', [ProfileController::class,'banner_update'])
    ->name('admin_banner_change_update');




/* --------------------------------------- */
/* Payment */
/* --------------------------------------- */
Route::get('admin/payment/view', [SettingController::class,'payment_edit'])
    ->name('admin_payment');

Route::post('admin/payment/update', [SettingController::class,'payment_update'])
    ->name('admin_payment_update');



/* --------------------------------------- */
/* Currency */
/* --------------------------------------- */
Route::get('admin/currency/view', [CurrencyController::class,'index'])
    ->name('admin_currency_view');

Route::get('admin/currency/create', [CurrencyController::class,'create'])
    ->name('admin_currency_create');

Route::post('admin/currency/store', [CurrencyController::class,'store'])
    ->name('admin_currency_store');

Route::get('admin/currency/delete/{id}', [CurrencyController::class,'destroy'])
    ->name('admin_currency_delete');

Route::get('admin/currency/edit/{id}', [CurrencyController::class,'edit'])
    ->name('admin_currency_edit');

Route::post('admin/currency/update/{id}', [CurrencyController::class,'update'])
    ->name('admin_currency_update');




/* --------------------------------------- */
/* Currency */
/* --------------------------------------- */
Route::get('admin/banner/view', [BannerController::class,'index'])
->name('admin_banner_view');

Route::get('admin/banner/create', [BannerController::class,'create'])
->name('admin_banner_create');

Route::post('admin/banner/store', [BannerController::class,'store'])
->name('admin_banner_store');

Route::get('admin/banner/delete/{id}', [BannerController::class,'destroy'])
->name('admin_banner_delete');

Route::get('admin/banner/edit/{id}', [BannerController::class,'edit'])
->name('admin_banner_edit');

Route::post('admin/banner/update/{id}', [BannerController::class,'update'])
->name('admin_banner_update');


/* --------------------------------------- */
/* Currency */
/* --------------------------------------- */
Route::get('admin/manage-admin/view', [ManageAdminController::class,'index'])
->name('admin_manage_admin_view');

Route::get('admin/manage-admin/create', [ManageAdminController::class,'create'])
->name('admin_manage_admin_create');

Route::post('admin/manage-admin/store', [ManageAdminController::class,'store'])
->name('admin_manage_admin_store');

Route::get('admin/manage-admin/delete/{id}', [ManageAdminController::class,'destroy'])
->name('admin_manage_admin_delete');

Route::get('admin/manage-admin/edit/{id}', [ManageAdminController::class,'edit'])
->name('admin_manage_admin_edit');

Route::post('admin/manage-admin/update/{id}', [ManageAdminController::class,'update'])
->name('admin_manage_admin_update');


/* --------------------------------------- */
/* Module Management */
/* --------------------------------------- */
Route::get('admin/manage-module/view', [ModuleController::class,'index'])
->name('admin_manage_module_view');

Route::get('admin/manage-module/create', [ModuleController::class,'create'])
->name('admin_manage_module_create');

Route::post('admin/manage-module/store', [ModuleController::class,'store'])
->name('admin_manage_module_store');

Route::get('admin/manage-module/delete/{id}', [ModuleController::class,'destroy'])
->name('admin_manage_module_delete');

Route::get('admin/manage-module/edit/{id}', [ModuleController::class,'edit'])
->name('admin_manage_module_edit');

Route::post('admin/manage-module/update/{id}', [ModuleController::class,'update'])
->name('admin_manage_module_update');


/* --------------------------------------- */
/* Sub Module Management */
/* --------------------------------------- */
Route::get('admin/sub-module/view', [SubModuleController::class,'index'])
->name('admin_sub_manage_module_view');

Route::get('admin/sub-module/create', [SubModuleController::class,'create'])
->name('admin_sub_manage_module_create');

Route::post('admin/sub-module/store', [SubModuleController::class,'store'])
->name('admin_sub_manage_module_store');

Route::get('admin/sub-module/delete/{id}', [SubModuleController::class,'destroy'])
->name('admin_sub_manage_module_delete');

Route::get('admin/sub-module/edit/{id}', [SubModuleController::class,'edit'])
->name('admin_sub_manage_module_edit');

Route::post('admin/sub-module/update/{id}', [SubModuleController::class,'update'])
->name('admin_sub_manage_module_update');


/* --------------------------------------- */
/* Blog Category */
/* --------------------------------------- */
Route::get('admin/category/view', [CategoryControllerForAdmin::class,'index'])
    ->name('admin_category_view');

Route::get('admin/category/create', [CategoryControllerForAdmin::class,'create'])
    ->name('admin_category_create');

Route::post('admin/category/store', [CategoryControllerForAdmin::class,'store'])
    ->name('admin_category_store');

Route::get('admin/category/delete/{id}', [CategoryControllerForAdmin::class,'destroy'])
    ->name('admin_category_delete');

Route::get('admin/category/edit/{id}', [CategoryControllerForAdmin::class,'edit'])
    ->name('admin_category_edit');

Route::post('admin/category/update/{id}', [CategoryControllerForAdmin::class,'update'])
    ->name('admin_category_update');


/* --------------------------------------- */
/* Blog */
/* --------------------------------------- */
Route::get('admin/blog/view', [BlogControllerForAdmin::class,'index'])
    ->name('admin_blog_view');

Route::get('admin/blog/create', [BlogControllerForAdmin::class,'create'])
    ->name('admin_blog_create');

Route::post('admin/blog/store', [BlogControllerForAdmin::class,'store'])
    ->name('admin_blog_store');

Route::get('admin/blog/delete/{id}', [BlogControllerForAdmin::class,'destroy'])
    ->name('admin_blog_delete');

Route::get('admin/blog/edit/{id}', [BlogControllerForAdmin::class,'edit'])
    ->name('admin_blog_edit');

Route::post('admin/blog/update/{id}', [BlogControllerForAdmin::class,'update'])
    ->name('admin_blog_update');


/* --------------------------------------- */
/* Blog Comment */
/* --------------------------------------- */
Route::get('admin/comment/approved', [CommentController::class,'approved'])
    ->name('admin_comment_approved');

Route::get('admin/comment/make-pending/{id}', [CommentController::class,'make_pending'])
    ->name('admin_comment_make_pending');

Route::get('admin/comment/pending', [CommentController::class,'pending'])
    ->name('admin_comment_pending');

Route::get('admin/comment/make-approved/{id}', [CommentController::class,'make_approved'])
    ->name('admin_comment_make_approved');

Route::get('admin/comment/delete/{id}', [CommentController::class,'destroy'])
    ->name('admin_comment_delete');


/* --------------------------------------- */
/* Dynamic Pages */
/* --------------------------------------- */
Route::get('admin/dynamic-page/view', [DynamicPageController::class,'index'])
    ->name('admin_dynamic_page_view');

Route::get('admin/dynamic-page/create', [DynamicPageController::class,'create'])
    ->name('admin_dynamic_page_create');

Route::post('admin/dynamic-page/store', [DynamicPageController::class,'store'])
    ->name('admin_dynamic_page_store');

Route::get('admin/dynamic-page/delete/{id}', [DynamicPageController::class,'destroy'])
    ->name('admin_dynamic_page_delete');

Route::get('admin/dynamic-page/edit/{id}', [DynamicPageController::class,'edit'])
    ->name('admin_dynamic_page_edit');

Route::post('admin/dynamic-page/update/{id}', [DynamicPageController::class,'update'])
    ->name('admin_dynamic_page_update');



/* --------------------------------------- */
/* Testimonial */
/* --------------------------------------- */
Route::get('admin/testimonial/view', [TestimonialController::class,'index'])
    ->name('admin_testimonial_view');

Route::get('admin/testimonial/create', [TestimonialController::class,'create'])
    ->name('admin_testimonial_create');

Route::post('admin/testimonial/store', [TestimonialController::class,'store'])
    ->name('admin_testimonial_store');

Route::get('admin/testimonial/delete/{id}', [TestimonialController::class,'destroy'])
    ->name('admin_testimonial_delete');

Route::get('admin/testimonial/edit/{id}', [TestimonialController::class,'edit'])
    ->name('admin_testimonial_edit');

Route::post('admin/testimonial/update/{id}', [TestimonialController::class,'update'])
    ->name('admin_testimonial_update');


/* --------------------------------------- */
/* Amenity */
/* --------------------------------------- */
Route::get('admin/amenity/view', [AmenityControllerForAdmin::class,'index'])
    ->name('admin_amenity_view');

Route::get('admin/amenity/create', [AmenityControllerForAdmin::class,'create'])
    ->name('admin_amenity_create');

Route::post('admin/amenity/store', [AmenityControllerForAdmin::class,'store'])
    ->name('admin_amenity_store');

Route::get('admin/amenity/delete/{id}', [AmenityControllerForAdmin::class,'destroy'])
    ->name('admin_amenity_delete');

Route::get('admin/amenity/edit/{id}', [AmenityControllerForAdmin::class,'edit'])
    ->name('admin_amenity_edit');

Route::post('admin/amenity/update/{id}', [AmenityControllerForAdmin::class,'update'])
    ->name('admin_amenity_update');


/* --------------------------------------- */
/* Property Category */
/* --------------------------------------- */
Route::get('admin/property-category/view', [PropertyCategoryControllerForAdmin::class,'index'])
    ->name('admin_property_category_view');

Route::get('admin/property-category/create', [PropertyCategoryControllerForAdmin::class,'create'])
    ->name('admin_property_category_create');

Route::post('admin/property-category/store', [PropertyCategoryControllerForAdmin::class,'store'])
    ->name('admin_property_category_store');

Route::get('admin/property-category/delete/{id}', [PropertyCategoryControllerForAdmin::class,'destroy'])
    ->name('admin_property_category_delete');

Route::get('admin/property-category/edit/{id}', [PropertyCategoryControllerForAdmin::class,'edit'])
    ->name('admin_property_category_edit');

Route::post('admin/property-category/update/{id}', [PropertyCategoryControllerForAdmin::class,'update'])
    ->name('admin_property_category_update');


/* --------------------------------------- */
/* Property Location */
/* --------------------------------------- */
Route::get('admin/property-location/view', [PropertyLocationControllerForAdmin::class,'index'])
    ->name('admin_property_location_view');

Route::get('admin/property-location/create', [PropertyLocationControllerForAdmin::class,'create'])
    ->name('admin_property_location_create');

Route::post('admin/property-location/store', [PropertyLocationControllerForAdmin::class,'store'])
    ->name('admin_property_location_store');

Route::get('admin/property-location/delete/{id}', [PropertyLocationControllerForAdmin::class,'destroy'])
    ->name('admin_property_location_delete');

Route::get('admin/property-location/edit/{id}', [PropertyLocationControllerForAdmin::class,'edit'])
    ->name('admin_property_location_edit');

Route::post('admin/property-location/update/{id}', [PropertyLocationControllerForAdmin::class,'update'])
    ->name('admin_property_location_update');



/* --------------------------------------- */
/* Property */
/* --------------------------------------- */
Route::get('admin/property/view', [PropertyControllerForAdmin::class,'index'])
    ->name('admin_property_view');

Route::get('admin/property/create', [PropertyControllerForAdmin::class,'create'])
    ->name('admin_property_create');

Route::post('admin/property/store', [PropertyControllerForAdmin::class,'store'])
    ->name('admin_property_store');

Route::get('admin/property/delete/{id}', [PropertyControllerForAdmin::class,'destroy'])
    ->name('admin_property_delete');

Route::get('admin/property/edit/{id}', [PropertyControllerForAdmin::class,'edit'])
    ->name('admin_property_edit');

Route::post('admin/property/update/{id}', [PropertyControllerForAdmin::class,'update'])
    ->name('admin_property_update');

Route::get('admin/property/delete-social-item/{id}', [PropertyControllerForAdmin::class,'delete_social_item'])
    ->name('admin_property_delete_social_item');

Route::get('admin/property/delete-photo/{id}', [PropertyControllerForAdmin::class,'delete_photo'])
    ->name('admin_property_delete_photo');

Route::get('admin/property/delete-video/{id}', [PropertyControllerForAdmin::class,'delete_video'])
    ->name('admin_property_delete_video');


Route::get('admin/property/delete-additional-feature/{id}', [PropertyControllerForAdmin::class,'delete_additional_feature'])
    ->name('admin_property_delete_additional_feature');


    Route::get('admin/property-status/{id}', [PropertyControllerForAdmin::class,'change_status']);
    Route::get('admin/property-approve-status/{id}', [PropertyControllerForAdmin::class,'property_approve_status']);
    Route::get('admin/property-photo-approve-status/{id}', [PropertyControllerForAdmin::class,'property_photo_approve_status']);
    Route::get('admin/property-video-approve-status/{id}', [PropertyControllerForAdmin::class,'property_video_approve_status']);

/* --------------------------------------- */
/*Under Construction Property */
/* --------------------------------------- */
Route::get('admin/under-construction-property/view', [UnderConstructionPropertyControllerForAdmin::class,'index'])
    ->name('admin_underconstruction_property_view');

Route::get('admin/under-construction-property/create', [UnderConstructionPropertyControllerForAdmin::class,'create'])
    ->name('admin_underconstruction_property_create');

Route::post('admin/under-construction-property/store', [UnderConstructionPropertyControllerForAdmin::class,'store'])
    ->name('admin_underconstruction_property_store');

Route::get('admin/under-construction-property/delete/{id}', [UnderConstructionPropertyControllerForAdmin::class,'destroy'])
    ->name('admin_underconstruction_property_delete');

Route::get('admin/under-construction-property/edit/{id}', [UnderConstructionPropertyControllerForAdmin::class,'edit'])
    ->name('admin_underconstruction_property_edit');

Route::post('admin/under-construction-property/update/{id}', [UnderConstructionPropertyControllerForAdmin::class,'update'])
    ->name('admin_underconstruction_property_update');

Route::get('admin/under-construction-property/delete-social-item/{id}', [UnderConstructionPropertyControllerForAdmin::class,'delete_social_item'])
    ->name('admin_underconstruction_property_delete_social_item');

Route::get('admin/under-construction-property/delete-photo/{id}', [UnderConstructionPropertyControllerForAdmin::class,'delete_photo'])
    ->name('admin_underconstruction_property_delete_photo');

Route::get('admin/under-construction-property/delete-video/{id}', [UnderConstructionPropertyControllerForAdmin::class,'delete_video'])
    ->name('admin_underconstruction_property_delete_video');

Route::get('admin/under-construction-property/delete-additional-feature/{id}', [UnderConstructionPropertyControllerForAdmin::class,'delete_additional_feature'])
    ->name('admin_underconstruction_property_delete_additional_feature');

Route::get('admin/under-construction-property-status/{id}', [UnderConstructionPropertyControllerForAdmin::class,'change_status']);


/* --------------------------------------- */
/* Review Settings */
/* --------------------------------------- */
Route::get('admin/admin-review/view', [ReviewController::class,'view_admin_review'])
    ->name('admin_view_admin_review');

Route::post('admin/admin-review/store', [ReviewController::class,'store_admin_review'])
    ->name('admin_store_admin_review');

Route::post('admin/admin-review/update/{id}', [ReviewController::class,'update_admin_review'])
    ->name('admin_update_admin_review');

Route::get('admin/admin-review/delete/{id}', [ReviewController::class,'delete_admin_review'])
    ->name('admin_delete_admin_review');

Route::get('admin/customer-review/view', [ReviewController::class,'view_customer_review'])
    ->name('admin_view_customer_review');

Route::get('admin/customer-review/delete/{id}', [ReviewController::class,'delete_customer_review'])
    ->name('admin_delete_customer_review');

Route::get('admin/review-approve-status/{id}', [ReviewController::class,'review_approve_status']);


/* --------------------------------------- */
/* General Settings */
/* --------------------------------------- */
Route::get('admin/setting/general', [SettingController::class,'edit'])
    ->name('admin_setting_general');

Route::post('admin/setting/general/update', [SettingController::class,'update'])
    ->name('admin_setting_general_update');


/* --------------------------------------- */
/* Advertisements */
/* --------------------------------------- */
Route::get('admin/advertisement/home', [HomeAdvertisementController::class,'edit'])
    ->name('admin_home_advertisement');

Route::post('admin/advertisement/home/update', [HomeAdvertisementController::class,'update'])
    ->name('admin_home_advertisement_update');


/* --------------------------------------- */
/* Language Settings */
/* --------------------------------------- */
Route::get('admin/language/menu/view', [LanguageController::class,'language_menu_text'])
    ->name('admin_language_menu_text');

Route::post('admin/language/menu/update', [LanguageController::class,'language_menu_text_update'])
    ->name('admin_language_menu_text_update');

Route::get('admin/language/menu/create', [LanguageController::class,'admin_language_menu_text_create'])
->name('admin_language_menu_text_create');

Route::post('admin/language/menu/store', [LanguageController::class,'admin_language_menu_text_store'])
->name('admin_language_menu_text_store');



Route::get('admin/language/website/view', [LanguageController::class,'language_website_text'])
    ->name('admin_language_website_text');

Route::post('admin/language/website/update', [LanguageController::class,'language_website_text_update'])
    ->name('admin_language_website_text_update');

Route::get('admin/language/website/create', [LanguageController::class,'admin_language_website_text_create'])
->name('admin_language_website_text_create');

Route::post('admin/language/website/store', [LanguageController::class,'admin_language_website_text_store'])
->name('admin_language_website_text_store');


Route::get('admin/language/notification/view', [LanguageController::class,'language_notification_text'])
    ->name('admin_language_notification_text');

Route::post('admin/language/notification/update', [LanguageController::class,'language_notification_text_update'])
    ->name('admin_language_notification_text_update');

Route::get('admin/language/notification/create', [LanguageController::class,'admin_language_notification_text_create'])
    ->name('admin_language_notification_text_create');

Route::post('admin/language/notification/store', [LanguageController::class,'admin_language_notification_text_store'])
    ->name('admin_language_notification_text_store');


Route::get('admin/language/admin-panel/view', [LanguageController::class,'language_admin_panel_text'])
    ->name('admin_language_admin_panel_text');

Route::get('admin/language/admin-panel/create', [LanguageController::class,'language_admin_panel_text_create'])
->name('language_admin_panel_text_create');

Route::post('admin/language/admin-panel/update', [LanguageController::class,'language_admin_panel_text_update'])
    ->name('admin_language_admin_panel_text_update');

Route::post('admin/language/admin-panel/store', [LanguageController::class,'language_admin_panel_text_store'])
    ->name('language_admin_panel_text_store');

/* --------------------------------------- */
/* Page Settings */
/* --------------------------------------- */
Route::get('admin/page-home/edit', [PageHomeController::class,'edit'])
    ->name('admin_page_home_edit');
Route::post('admin/page-home/update', [PageHomeController::class,'update'])
    ->name('admin_page_home_update');

Route::get('admin/page-about/edit', [PageAboutController::class,'edit'])
    ->name('admin_page_about_edit');
Route::post('admin/page-about/update', [PageAboutController::class,'update'])
    ->name('admin_page_about_update');

Route::get('admin/page-blog/edit', [PageBlogController::class,'edit'])
    ->name('admin_page_blog_edit');
Route::post('admin/page-blog/update', [PageBlogController::class,'update'])
    ->name('admin_page_blog_update');

Route::get('admin/page-faq/edit', [PageFaqController::class,'edit'])
    ->name('admin_page_faq_edit');
Route::post('admin/page-faq/update', [PageFaqController::class,'update'])
    ->name('admin_page_faq_update');

Route::get('admin/page-contact/edit', [PageContactController::class,'edit'])
    ->name('admin_page_contact_edit');
Route::post('admin/page-contact/update', [PageContactController::class,'update'])
    ->name('admin_page_contact_update');

Route::get('admin/page-pricing/edit', [PagePricingController::class,'edit'])
    ->name('admin_page_pricing_edit');
Route::post('admin/page-pricing/update', [PagePricingController::class,'update'])
    ->name('admin_page_pricing_update');

Route::get('admin/page-property-category/edit', [PagePropertyCategoryController::class,'edit'])
    ->name('admin_page_property_category_edit');
Route::post('admin/page-property-category/update', [PagePropertyCategoryController::class,'update'])
    ->name('admin_page_property_category_update');

Route::get('admin/page-property-location/edit', [PagePropertyLocationController::class,'edit'])
    ->name('admin_page_property_location_edit');
Route::post('admin/page-property-location/update', [PagePropertyLocationController::class,'update'])
    ->name('admin_page_property_location_update');

Route::get('admin/page-property/edit', [PagePropertyController::class,'edit'])
    ->name('admin_page_property_edit');
Route::post('admin/page-property/update', [PagePropertyController::class,'update'])
    ->name('admin_page_property_update');

Route::get('admin/page-term/edit', [PageTermController::class,'edit'])
    ->name('admin_page_term_edit');
Route::post('admin/page-term/update', [PageTermController::class,'update'])
    ->name('admin_page_term_update');

Route::get('admin/page-privacy/edit', [PagePrivacyController::class,'edit'])
    ->name('admin_page_privacy_edit');
Route::post('admin/page-privacy/update', [PagePrivacyController::class,'update'])
    ->name('admin_page_privacy_update');

Route::get('admin/page-other/edit', [PageOtherController::class,'edit'])
    ->name('admin_page_other_edit');
Route::post('admin/page-other/update', [PageOtherController::class,'update'])
    ->name('admin_page_other_update');

    Route::get('admin/dream-property-location/edit', [PageDreamPropertyController::class,'edit'])
    ->name('admin_dream_property_location_edit');
Route::post('admin/dream-property-location/update', [PageDreamPropertyController::class,'update'])
    ->name('admin_dream_property_location_update');



/* --------------------------------------- */
/* FAQ - Admin */
/* --------------------------------------- */
Route::get('admin/faq/view', [FaqControllerForAdmin::class,'index'])
    ->name('admin_faq_view');

Route::get('admin/faq/create', [FaqControllerForAdmin::class,'create'])
    ->name('admin_faq_create');

Route::post('admin/faq/store', [FaqControllerForAdmin::class,'store'])
    ->name('admin_faq_store');

Route::get('admin/faq/delete/{id}', [FaqControllerForAdmin::class,'destroy'])
    ->name('admin_faq_delete');

Route::get('admin/faq/edit/{id}', [FaqControllerForAdmin::class,'edit'])
    ->name('admin_faq_edit');

Route::post('admin/faq/update/{id}', [FaqControllerForAdmin::class,'update'])
    ->name('admin_faq_update');



/* --------------------------------------- */
/* Role - Admin */
/* --------------------------------------- */
Route::get('admin/role/view', [RoleControllerForAdmin::class,'index'])
->name('admin_role_view');

Route::get('admin/role/create', [RoleControllerForAdmin::class,'create'])
->name('admin_role_create');

Route::post('admin/role/store', [RoleControllerForAdmin::class,'store'])
->name('admin_role_store');

Route::get('admin/role/delete/{id}', [RoleControllerForAdmin::class,'destroy'])
->name('admin_role_delete');

Route::get('admin/role/edit/{id}', [RoleControllerForAdmin::class,'edit'])
->name('admin_role_edit');

Route::post('admin/role/update/{id}', [RoleControllerForAdmin::class,'update'])
->name('admin_role_update');

Route::get('admin/role-status/{id}', [RoleControllerForAdmin::class,'change_status']);




/* --------------------------------------- */
/*  Admin Task */
/* --------------------------------------- */
Route::get('admin/task/view', [TaskController::class,'index'])
->name('admin_task_view');

Route::get('admin/task/create', [TaskController::class,'create'])
->name('admin_task_create');

Route::post('admin/task/store', [TaskController::class,'store'])
->name('admin_task_store');

Route::get('admin/task/delete/{id}', [TaskController::class,'destroy'])
->name('admin_task_delete');

Route::get('admin/task/edit/{id}', [TaskController::class,'edit'])
->name('admin_task_edit');

Route::post('admin/task/update/{id}', [TaskController::class,'update'])
->name('admin_task_update');



/* --------------------------------------- */
/* Package - Admin */
/* --------------------------------------- */
Route::get('admin/package/view', [PackageControllerForAdmin::class,'index'])
    ->name('admin_package_view');

Route::get('admin/package/create', [PackageControllerForAdmin::class,'create'])
    ->name('admin_package_create');

Route::post('admin/package/store', [PackageControllerForAdmin::class,'store'])
    ->name('admin_package_store');

Route::get('admin/package/delete/{id}', [PackageControllerForAdmin::class,'destroy'])
    ->name('admin_package_delete');

Route::get('admin/package/edit/{id}', [PackageControllerForAdmin::class,'edit'])
    ->name('admin_package_edit');

Route::post('admin/package/update/{id}', [PackageControllerForAdmin::class,'update'])
    ->name('admin_package_update');



/* --------------------------------------- */
/* Email Template - Admin */
/* --------------------------------------- */
Route::get('admin/email-template/view', [EmailTemplateController::class,'index'])
    ->name('admin_email_template_view');

Route::get('admin/email-template/edit/{id}', [EmailTemplateController::class,'edit'])
    ->name('admin_email_template_edit');

Route::post('admin/email-template/update/{id}', [EmailTemplateController::class,'update'])
    ->name('admin_email_template_update');


/* --------------------------------------- */
/* Social Media - Admin */
/* --------------------------------------- */
Route::get('admin/social-media/view', [SocialMediaItemController::class,'index'])
    ->name('admin_social_media_view');

Route::get('admin/social-media/create', [SocialMediaItemController::class,'create'])
    ->name('admin_social_media_create');

Route::post('admin/social-media/store', [SocialMediaItemController::class,'store'])
    ->name('admin_social_media_store');

Route::get('admin/social-media/delete/{id}', [SocialMediaItemController::class,'destroy'])
    ->name('admin_social_media_delete');

Route::get('admin/social-media/edit/{id}', [SocialMediaItemController::class,'edit'])
    ->name('admin_social_media_edit');

Route::post('admin/social-media/update/{id}', [SocialMediaItemController::class,'update'])
    ->name('admin_social_media_update');




/* --------------------------------------- */
/* Purchase History - Admin */
/* --------------------------------------- */
Route::get('admin/purchase-history/view', [PurchaseHistoryControllerForAdmin::class,'index'])
    ->name('admin_purchase_history_view');

Route::get('admin/purchase-history/detail/{id}', [PurchaseHistoryControllerForAdmin::class,'detail'])
    ->name('admin_purchase_history_detail');

Route::get('admin/purchase-history/invoice/{id}', [PurchaseHistoryControllerForAdmin::class,'invoice'])
    ->name('admin_purchase_history_invoice');



/* --------------------------------------- */
/* Customer - Admin */
/* --------------------------------------- */
Route::get('admin/customer/view', [CustomerControllerForAdmin::class,'index'])
    ->name('admin_customer_view');

Route::get('admin/customer/filter', [CustomerControllerForAdmin::class,'customer_filter'])
->name('customer_filter');

Route::get('admin/customer/detail/{id}', [CustomerControllerForAdmin::class,'detail'])
    ->name('admin_customer_detail');

Route::get('admin/customer/delete/{id}', [CustomerControllerForAdmin::class,'destroy'])
    ->name('admin_customer_delete');

Route::get('admin/customer-status/{id}', [CustomerControllerForAdmin::class,'change_status']);

Route::get('admin/clear-database', [ClearDatabaseController::class,'index'])
    ->name('admin_clear_database');


/* --------------------------------------- */
/* Social Media - Admin */
/* --------------------------------------- */
Route::get('admin/product/view', [ProductController::class,'index'])
    ->name('admin_product_view');

Route::get('admin/product/create', [ProductController::class,'create'])
    ->name('admin_product_create');

Route::post('admin/product/store', [ProductController::class,'store'])
    ->name('admin_product_store');

Route::get('admin/product/delete/{id}', [ProductController::class,'destroy'])
    ->name('admin_product_delete');

Route::get('admin/product/edit/{id}', [ProductController::class,'edit'])
    ->name('admin_product_edit');

Route::post('admin/product/update/{id}', [ProductController::class,'update'])
    ->name('admin_product_update');


/* --------------------------------------- */
/* Product Admin */
/* --------------------------------------- */
Route::get('admin/withdraw/view', [WithdrawController::class,'index'])
->name('admin_withdraw_view');

Route::get('admin/withdraw/create', [WithdrawController::class,'create'])
->name('admin_withdraw_create');

Route::post('admin/withdraw/store', [WithdrawController::class,'store'])
->name('admin_withdraw_store');

Route::get('admin/withdraw/delete/{id}', [WithdrawController::class,'destroy'])
->name('admin_withdraw_delete');

Route::get('admin/withdraw/edit/{id}', [WithdrawController::class,'edit'])
->name('admin_withdraw_edit');

Route::post('admin/withdraw/update/{id}', [WithdrawController::class,'update'])
->name('admin_withdraw_update');

/* --------------------------------------- */
/* Reward Admin */
/* --------------------------------------- */
Route::get('admin/reward/view', [RewardController::class,'index'])
->name('admin_reward_view');

Route::get('admin/reward/create', [RewardController::class,'create'])
->name('admin_reward_create');

Route::post('admin/reward/store', [RewardController::class,'store'])
->name('admin_reward_store');


/* --------------------------------------- */
/* Reward Admin */
/* --------------------------------------- */
Route::get('admin/trade/view', [TradeController::class,'index'])
->name('admin_trade_view');

Route::get('admin/trade/create', [TradeController::class,'create'])
->name('admin_trade_create');

Route::post('admin/trade/store', [TradeController::class,'store'])
->name('admin_trade_store');

/* --------------------------------------- */
/* Volunteer Admin */
/* --------------------------------------- */
Route::get('admin/volunteer/view', [VolunteerController::class,'index'])
->name('admin_volunteer_view');

Route::get('admin/volunteer/create', [VolunteerController::class,'create'])
->name('admin_volunteer_create');

Route::post('admin/volunteer/store', [VolunteerController::class,'store'])
->name('admin_volunteer_store');

Route::get('admin/volunteer/delete/{id}', [VolunteerController::class,'destroy'])
->name('admin_volunteer_delete');

Route::get('admin/volunteer/edit/{id}', [VolunteerController::class,'edit'])
->name('admin_volunteer_edit');

Route::post('admin/volunteer/update/{id}', [VolunteerController::class,'update'])
->name('admin_volunteer_update');


/* --------------------------------------- */
/* Village Admin */
/* --------------------------------------- */
Route::get('admin/village/view', [VillageController::class,'index'])
->name('admin_village_view');

Route::get('admin/village/create', [VillageController::class,'create'])
->name('admin_village_create');

Route::post('admin/village/store', [VillageController::class,'store'])
->name('admin_village_store');

Route::get('admin/village/delete/{id}', [VillageController::class,'destroy'])
->name('admin_village_delete');

Route::get('admin/village/edit/{id}', [VillageController::class,'edit'])
->name('admin_village_edit');

Route::post('admin/village/update/{id}', [VillageController::class,'update'])
->name('admin_village_update');

Route::get('admin/village-status/{id}', [VillageController::class,'change_status']);




/* --------------------------------------- */
/* Event Category Admin */
/* --------------------------------------- */
Route::get('admin/event_category/view', [EventCategoryController::class,'index'])
->name('admin_event_category_view');

Route::get('admin/event_category/create', [EventCategoryController::class,'create'])
->name('admin_event_category_create');

Route::post('admin/event_category/store', [EventCategoryController::class,'store'])
->name('admin_event_category_store');

Route::get('admin/event_category/delete/{id}', [EventCategoryController::class,'destroy'])
->name('admin_event_category_delete');

Route::get('admin/event_category/edit/{id}', [EventCategoryController::class,'edit'])
->name('admin_event_category_edit');

Route::post('admin/event_category/update/{id}', [EventCategoryController::class,'update'])
->name('admin_event_category_update');

Route::get('admin/event-category-status/{id}', [EventCategoryController::class,'change_status']);



/* --------------------------------------- */
/* Attendees Admin */
/* --------------------------------------- */
Route::get('admin/attendees/view', [AttendeesController::class,'index'])
->name('admin_attendees_view');

Route::get('admin/attendees/create', [AttendeesController::class,'create'])
->name('admin_attendees_create');

Route::post('admin/attendees/store', [AttendeesController::class,'store'])
->name('admin_attendees_store');

Route::get('admin/attendees/delete/{id}', [AttendeesController::class,'destroy'])
->name('admin_attendees_delete');

Route::get('admin/attendees/edit/{id}', [AttendeesController::class,'edit'])
->name('admin_attendees_edit');

Route::post('admin/attendees/update/{id}', [AttendeesController::class,'update'])
->name('admin_attendees_update');

Route::get('admin/attendees-status/{id}', [AttendeesController::class,'change_status']);



/* --------------------------------------- */
/* Event Admin */
/* --------------------------------------- */
Route::get('admin/event/view', [EventController::class,'index'])
->name('admin_event_view');

Route::get('admin/event/create', [EventController::class,'create'])
->name('admin_event_create');

Route::post('admin/event/store', [EventController::class,'store'])
->name('admin_event_store');

Route::get('admin/event/delete/{id}', [EventController::class,'destroy'])
->name('admin_event_delete');

Route::get('admin/event/edit/{id}', [EventController::class,'edit'])
->name('admin_event_edit');

Route::post('admin/event/update/{id}', [EventController::class,'update'])
->name('admin_event_update');

Route::get('admin/event-status/{id}', [EventController::class,'change_status']);

Route::post('admin/assign-volunteer', [EventController::class, 'assign_volunteer']);
Route::post('admin/assign-attendee', [EventController::class, 'assign_attendee']);

Route::post('/admin/attendees', [EventController::class, 'storeAttendee'])->name('admin_attendees_store');


/* --------------------------------------- */
/* App Language Admin */
/* --------------------------------------- */
Route::get('admin/app-language/view', [AppLanguageController::class,'index'])
->name('admin_app_language_view');

Route::get('admin/app-language/create', [AppLanguageController::class,'create'])
->name('admin_app_language_create');

Route::post('admin/app-language/store', [AppLanguageController::class,'store'])
->name('admin_app_language_store');

Route::get('admin/app-language/delete/{id}', [AppLanguageController::class,'destroy'])
->name('admin_app_language_delete');

Route::get('admin/app-language/edit/{id}', [AppLanguageController::class,'edit'])
->name('admin_app_language_edit');

Route::post('admin/app-language/update', [AppLanguageController::class,'update'])
    ->name('admin_app_language_update');

Route::post('admin/app-language-single/{id}', [AppLanguageController::class,'update_single'])
->name('admin_app_language_update_single');



/* --------------------------------------- */
/* App Notification Admin */
/* --------------------------------------- */
Route::get('admin/notification/view', [NotificationController::class,'index'])
->name('admin_notification_view');

Route::get('admin/notification/create', [NotificationController::class,'create'])
->name('admin_notification_create');

Route::post('admin/notification/store', [NotificationController::class,'store'])
->name('admin_notification_store');

Route::get('admin/notification/delete/{id}', [NotificationController::class,'destroy'])
->name('admin_notification_delete');

Route::get('admin/notification-status/{id}', [NotificationController::class,'change_status']);



/* --------------------------------------- */
/* App Visitors Admin */
/* --------------------------------------- */
Route::get('admin/visitor/view', [VisitorController::class,'index'])
->name('admin_visitor_view');

Route::get('admin/visitor/delete/{id}', [VisitorController::class,'destroy'])
->name('admin_visitor_delete');

Route::get('admin/visitor-status/{id}', [VisitorController::class,'change_status']);
