<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AttributeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/',[
    HomeController:: class,
    'index'
]);
Route::get('trang-chu',[
    HomeController:: class,
    'index'
]);
Route::get('lien-he',[HomeController:: class,'contact']);
Route::get('gioi-thieu',[HomeController:: class,'intro']);
Route::get('phan-hoi',[HomeController:: class,'feedback']);
Route::post('sendFeedback',[HomeController:: class,'sendFeedBack']);
Route::get('dang-nhap',[UserController:: class,'login']);
Route::post('checkLogin', [UserController::class, 'checkLogin']);
Route::get('dang-ky', [UserController::class, 'register']);
Route::post('registerUser', [UserController::class, 'registerUser']);
Route::get('dang-xuat', [UserController::class, 'logout']);
Route::get('thong-tin', [UserController::class, 'info']);
Route::post('ChangeInfo', [UserController::class, 'ChangeInfo']);
Route::get('GetOrderDetail/{id}', function ($id) {
    return UserController::GetOrderDetail($id);
});
Route::get('GetOrderDetailAdmin/{id}', function ($id) {
    return CartController::GetOrderDetail($id);
});
Route::post('order/DeleteOrder', [CartController::class, 'DeleteOrder']);
Route::get('order/UpdateOrder', [CartController::class, 'UpdateOrder']);
Route::post('order/SubmitUpdateOrder', [CartController::class, 'SubmitUpdateOrder']);

Route::get('gio-hang', [CartController::class,'index']);
Route::get('GetCountCart', [CartController::class,'GetCountCart']);
Route::post('AddCart', [CartController::class,'AddCart']);
Route::get('order/ListOrder', [CartController::class,'ListOrder']);


Route::post('purchase/DeletePurchase', [PurchaseController::class, 'DeletePurchase']);
Route::get('purchase/UpdatePurchase', [PurchaseController::class, 'UpdatePurchase']);
Route::get('purchase/CreatePurchase', [PurchaseController::class, 'CreatePurchase']);
Route::post('purchase/SubmitCreatePurchase', [PurchaseController::class, 'SubmitCreatePurchase']);
Route::post('purchase/SubmitUpdatePurchase', [PurchaseController::class, 'SubmitUpdatePurchase']);
Route::get('purchase/ListPurchase', [PurchaseController::class,'ListPurchase']);
Route::get('GetInfoSupplier', [PurchaseController::class,'GetInfoSupplier']);
Route::get('GetInfoProduct', [PurchaseController::class,'GetInfoProduct']);
Route::get('GetPurchaseDetail/{id}',function ($id) {
    return PurchaseController::GetPurchaseDetail($id);
});

Route::post('Rate', [UserController::class,'Rate']);

Route::get('user/ListCustomer', [UserController::class,'ListCustomer']);
Route::get('user/ListSupplier', [UserController::class,'ListSupplier']);
Route::get('user/User', [UserController::class,'User']);
Route::post('user/CreateUser', [UserController::class,'CreateUser']);




Route::get('DeleteCart/{id}', function ($id) {
    return CartController::DeleteCart($id);
});
Route::get('UpdateCart/{id}/{quantity}', function ($id,$quantity) {
    return CartController::UpdateCart($id,$quantity);
});
Route::get('thanh-toan', [CartController::class,'checkout']);
Route::post('completePayment',[CartController:: class,'completePayment']);

Route::get('tin-tuc', [ArticleController::class, 'index']);
Route::get('tin-tuc/{id}', function($id){
    return ArticleController::index($id);
});
Route::get('tin-tuc/{id}?page={page}', function($id,$page){
    return ArticleController::index($id,$page);
});
Route::get('tin-tuc/{id}/{urlArticle}', function($id,$urlArticle){
    return ArticleController::Article($id."/".$urlArticle);
});

Route::post('tim-kiem-san-pham',[ProductsController:: class,'search']);

Route::get('products',[ProductsController:: class,'index']);
Route::post('filterProduct',[ProductsController:: class,'filterProduct']);

Route::get('product/CreateProduct',[ProductsController:: class,'CreateProduct']);
Route::post('product/SubmitCreateProduct',[ProductsController:: class,'SubmitCreateProduct']);
Route::get('product/attribute/{id}',function ($id) {
    return ProductsController::RenderAttribute($id);
});
Route::get('product/brandcategory/{id}',function ($id) {
    return ProductsController::RenderBrand($id);
});
Route::get('product/ListProduct',[ProductsController:: class,'ListProduct']);
Route::post('product/DeleteProduct',[ProductsController:: class,'DeleteProduct']);
Route::get('product/UpdateProduct',[ProductsController:: class,'UpdateProduct']);
Route::post('product/SubmitUpdateProduct',[ProductsController:: class,'SubmitUpdateProduct']);

Route::get('admin',[AdminController:: class,'index']);
Route::get('admin/login',[AdminController:: class,'login']);
Route::post('admin/checkLogin',[AdminController:: class,'checkLogin']);
Route::get('admin/changePass',[AdminController:: class,'changePass']);
Route::post('admin/ChangePassword',[AdminController:: class,'ChangePassword']);
Route::get('admin/LogOut',[AdminController:: class,'logout']);
Route::get('admin/ListAdmin',[AdminController:: class,'AdminAccount']);
Route::post('admin/CreateAdmin',[AdminController:: class,'CreateAdmin']);
Route::get('Admin/EditAdmin/{id}',function ($id) {
    return AdminController::EditAdmin($id);
});
Route::post('Admin/SubmitUpdateAdmin',[AdminController::class,"SubmitUpdateAdmin"]);
Route::post('admin/DeleteAdmin',[AdminController::class,"DeleteAdmin"]);
Route::get('admin/ConfigSite',[AdminController::class,"ConfigSite"]);
Route::post('admin/UpdateConfigSite',[AdminController::class,"UpdateConfigSite"]);
Route::get('admin/ListFeedback',[AdminController::class,"ListFeedback"]);
Route::get('admin/CreateBanner',[AdminController::class,"CreateBanner"]);
Route::post('admin/SubmitCreateBanner',[AdminController::class,"SubmitCreateBanner"]);


Route::get('article/CategoryArticle',[ArticleController::class,"CategoryArticle"]);
Route::post('article/CreateCategoryArticle',[ArticleController::class,"CreateCategoryArticle"]);
Route::post('article/DeleteArticleCategories',[ArticleController::class,"DeleteArticleCategories"]);
Route::get('article/EditArticleCategories/{id}',function ($id) {
    return ArticleController::EditArticleCategories($id);
});

Route::post('article/ConfirmCategoryArticle',[ArticleController::class,"ConfirmCategoryArticle"]);
Route::get('article/Article',[ArticleController::class,"CreateArticle"]);
Route::post('article/CreateArticle',[ArticleController::class,"SubmitCreateArticle"]);
Route::get('article/ListArticle',[ArticleController::class,"ListArticle"]);
Route::post('article/DeleteArticle',[ArticleController::class,"DeleteArticle"]);

Route::get('brand/CreateBrand',[BrandController::class,"CreateBrand"]);
Route::post('brand/SubmitBrand',[BrandController::class,"SubmitBrand"]);

Route::get('category/CreateCategory',[CategoryController::class,"CreateCategory"]);
Route::post('category/SubmitCategory',[CategoryController::class,"SubmitCategory"]);
Route::get('category/CreateBrandCategory',[CategoryController::class,"CreateBrandCategory"]);
Route::post('category/SubmitBrandCategory',[CategoryController::class,"SubmitBrandCategory"]);
Route::get('category/CreateAttributeCategory',[CategoryController::class,"CreateAttributeCategory"]);
Route::post('category/SubmitAttributeCategory',[CategoryController::class,"SubmitAttributeCategory"]);

Route::get('attribute/CreateAttribute',[AttributeController::class,"CreateAttribute"]);
Route::post('attribute/SubmitAttribute',[AttributeController::class,"SubmitAttribute"]);

Route::get('attribute/CreateAttributeValue',[AttributeController::class,"CreateAttributeValue"]);
Route::post('attribute/SubmitAttributeValue',[AttributeController::class,"SubmitAttributeValue"]);

Route::get('{urlCategory}/{urlProduct}', function ($urlCategory,$urlProduct) {
    return ProductsController::product($urlCategory,$urlProduct);
});

Route::get('{urlCategory}', function ($urlCategory) {
    return ProductsController::products($urlCategory);
});



