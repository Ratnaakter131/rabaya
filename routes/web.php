<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\cartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerRegisterController;
use App\Http\Controllers\CustomerLoginController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\GithubController;
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleManager;
use App\Http\Controllers\subcategoryController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\StripePaymentController;
use Illuminate\support\Facades\Auth;



// welcome
// Route::get('/', function () {
//     return view('welcome');
// });

//frontend
Auth::routes();
Route::get('/', [FrontendController::class, 'welcome'])->name('index');

Route::get('/product/details/{slug}', [FrontendController::class, 'product_details'])->name('product.details');


//backend
Route::get('/home', [HomeController::class, 'index'])->name('home');

// users
Route::get('/users', [HomeController::class, 'users'])->name('users');
Route::get('/delete/user/{user_id}', [HomeController::class, 'delete'])->name('delete.user');
Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
Route::post('/profile/photo/update', [HomeController::class, 'profile_update'])->name('profile.photo.update');
// category
Route::get('/category', [CategoryController::class, 'index'])->name('category');

Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');

Route::get('/category/edit/{category_id}', [CategoryController::class, 'edit'])->name('category.edit');

Route::post('/category/update', [CategoryController::class, 'update'])->name('category.update');

Route::get('/category/del/{cat_id}', [CategoryController::class, 'del'])->name('del');

Route::post('/category/mark/delete', [CategoryController::class, 'mark_delete'])->name('category.marked');

Route::get('/category/restore/{cat_id}', [CategoryController::class, 'restore'])->name('category.restore');

Route::get('/category/per/delete/{cat_id}', [CategoryController::class, 'pdelete'])->name('category.per.delete');

Route::get('/subcategory', [SubcategoryController::class, 'index'])->name('subcategory');

Route::post('/subcategory/store', [SubcategoryController::class, 'store'])->name('subcategory.store');

// product
Route::get('/add/product', [ProductController::class, 'add_product'])->name('add.product');

Route::post('/product/store', [ProductController::class, 'product_store'])->name('product.store');

Route::post('/getsubcategory', [ProductController::class, 'getsubcategory']);

Route::get('/product/list', [ProductController::class, 'product_list'])->name('product.list');

Route::get('/product/inventory/{product_id}', [InventoryController::class, 'inventory'])->name('inventory');

Route::get('/product/variation', [InventoryController::class, 'variation'])->name('variation');

Route::post('/add/color', [InventoryController::class, 'addcolor'])->name('add.color');

Route::post('/add/size', [InventoryController::class, 'addsize'])->name('add.size');

Route::post('/addinventory', [InventoryController::class, 'addinventory'])->name('add.inventory');

Route::post('/getSize', [FrontendController::class, 'getSize']);
//customer
Route::get('/customer/register/login', [CustomerRegisterController::class, 'register_login'])->name('customer.register.login');

Route::post('/customer/register/store', [CustomerRegisterController::class, 'register_store'])->name('customer.register.store');

Route::post('/customer/login', [CustomerLoginController::class, 'customer_login'])->name('customer.login');

Route::get('/customer/logout', [CustomerController::class, 'customer_logout'])->name('customer.logout');

Route::get('/customer/email/verify/{token}', [AccountController::class, 'customeremail_verify']);

Route::post('/cart/store', [cartController::class, 'cart_store'])->name('cart.store');

Route::get('/cart/remove/{cart_id}', [cartController::class, 'cart_remove'])->name('cart.remove');

Route::get('/cart', [cartController::class, 'cart'])->name('cart');

Route::post('/cart/update', [cartController::class, 'cart_update'])->name('cart.update');

Route::get('/coupon', [CouponController::class, 'coupon'])->name('add.coupon');

Route::post('/coupon/store', [CouponController::class, 'coupon_store'])->name('coupon.store');

Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');

Route::post('/getCity', [CheckoutController::class, 'getCity']);

Route::post('/order/store', [CheckoutController::class, 'order_store'])->name('order.store');

Route::get('/order/success', [CheckoutController::class, 'order_success'])->name('order.success');

Route::get('account', [AccountController::class, 'account'])->name('account');

Route::get('invoice/download/{order_id}', [AccountController::class, 'invoice_download'])->name('invoice.download');

// SSLCOMMERZ Start
Route::get('/ssl/payment', [SslCommerzPaymentController::class, 'ssl_pay']);

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END

//STRIPE
Route::get('stripe', [StripePaymentController::class, 'stripe']);
Route::post('stripe', [StripePaymentController::class, 'stripepost'])->name('stripe.post');

Route::post('review', [FrontendController::class, 'review'])->name('review.store');
// password reset
Route::get('/pass/reset/req', [AccountController::class, 'pass_reset_req'])->name('customer.pass.reset.req');
Route::post('/pass/reset/store', [AccountController::class, 'pass_reset_store'])->name('customer.pass.reset.store');
Route::get('/pass/reset/form/{token}', [AccountController::class, 'pass_reset_form'])->name('customer.pass.reset.form');
Route::post('/pass/reset/update', [AccountController::class, 'pass_reset_update'])->name('pass.reset.update');

Route::get('/role/manager', [RoleManager::class, 'role_manager'])->name('role.manager');

Route::post('/permission/store', [RoleManager::class, 'permission_store'])->name('permission.store');

Route::post('/create/role', [RoleManager::class, 'create_role'])->name('create.role ');

Route::get('/edit/permission/{role_id}', [RoleManager::class, 'edit_permission'])->name('edit.permission');
Route::post('/role/permissions/update', [RoleManager::class, 'role_permissions_update'])->name('role.permissions.update');
Route::post('/assign/role', [RoleManager::class, 'assign_role'])->name('assign.role');

// github
Route::get('/github/redirect', [GithubController::class, 'github_redirect'])->name('github.redirect');
Route::get('/github/callback', [GithubController::class, 'github_callback'])->name('github.callback');

// google
Route::get('/google/redirect', [GoogleController::class, 'google_redirect'])->name('google.redirect');
Route::get('/google/callback', [GoogleController::class, 'google_callback'])->name('google.callback');
// facebook
Route::get('/facebook/redirect', [FacebookController::class, 'facebook_redirect'])->name('facebook.redirect');
Route::get('/facebook/callback', [FacebookController::class, 'facebook_callback'])->name('facebook.callback');
//filering
Route::get('/shop', [FrontendController::class, 'shop'])->name('shop');
