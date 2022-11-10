<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Articlecategory;
use App\Models\Attributevalue;
use App\Models\Configsite;
use App\Models\Feedback;
use App\Models\Product;
use App\Models\Order;
use App\Models\Orderdetail;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(){

        return view('home.index');
    }
    public static function renderHeader(){
        $category = Category::whereRaw('Status = 1 and ParentCategoryId is null')->get();
        $categoryArticle = Articlecategory::whereRaw('Status = 1 and ArticleCategoriesParentId is null')->orderBy('CategorySort')->get();
        $user = session('user');
        $cart = session('cart');
        $quantity_cart = $cart ? count($cart) : 0;
        $configSite = Configsite::first();
        $view = view('shared.header', ["category" => $category, 
                                             "categoryArticle" => $categoryArticle, 
                                             "user" => $user, 
                                             "configSite"=> $configSite,
                                             "cart"=> $quantity_cart
                                            ])->render();
        return $view;
    }
    public static function renderFooter(){
        $configSite = Configsite::find(1);
        $view = view('shared.footer', [ "configSite"=> $configSite])->render();
        return $view;
    }
    public static function renderSlider(){
        $slider = Slider::whereRaw('Status = 1')->orderBy('Sort')->get();
        return view('home.slider',["slider"=>$slider]);
    }
    public static function renderLaptopBestSeller(){
        $statusInvoice = Attributevalue::whereRaw("Value like '%Hóa đơn%'")->first();
        $laptopCategory = Category::whereRaw("name like '%laptop%' or name like '%may tinh xach tay%'")->first();
        $cat = Category::whereRaw("Status = 1 and ((CategoryId = {$laptopCategory->CategoryId} or ParentCategoryId = {$laptopCategory->CategoryId}))")->get();
        $catId = [];
        foreach($cat as $item){
            array_push($catId,$item->CategoryId);
        }
        $product = Product::leftJoin(DB::raw("Product b"),"Product.ProductId","=","b.ProductParentId")->whereRaw("b.ProductId is null")
        ->leftJoin(DB::raw("(select * from OrderDetail where OrderId in (select OrderId from Orders where Status = {$statusInvoice->AttributeValueId})) a"),"a.ProductId","=", "Product.ProductId")
        ->selectRaw('ifnull(sum(a.Quantity),0) as SoLuong, Product.ProductId, Product.ShortName, Product.Name, Product.Url,Product.BrandId, Product.Price, Product.Discount, Product.Image')
        ->GroupByRaw('Product.ProductId, Product.ShortName, Product.Name, Product.Url,Product.BrandId, Product.Price, Product.Discount, Product.Image')
        ->whereIn("Product.CategoryId",$catId)
        ->whereRaw("Product.Status = 1")
        ->orderBy('SoLuong','desc')->orderby('ProductId')
        ->take(4)->get();
        $title = 'Laptop bán chạy nhất';
        $link = $laptopCategory->Url;
        return view('home.home',["product"=>$product,"title"=>$title,"link"=>$link]);
    }
    public static function renderPhoneBestSeller(){
        $slider = Slider::whereRaw('Status = 1')->orderBy('Sort')->find(4)->get();
        return view('home.home',["slider"=>$slider]);
    }
    public static function renderLaptopBestDiscount(){
        $laptopCategory = Category::whereRaw("name like '%laptop%' or name like '%may tinh xach tay%'")->first();
        $title = 'Laptop giảm giá cao nhất';
        $link = $laptopCategory->Url;
        $product = Product::leftJoin(DB::raw("Product b"),"Product.ProductId","=","b.ProductParentId")
        ->whereRaw("b.ProductId is null")
        ->selectRaw('Product.ProductId, Product.ShortName, Product.Name, Product.Url,Product.BrandId, Product.Price, Product.Discount, Product.Image')
        ->orderby('Discount','desc')->take(4)->get();
        return view('home.home',["product"=>$product,"title"=>$title,"link"=>$link]);
    }
    public function contact(){
        $configSite = Configsite::find(1);
        return view('home.contact', [ "configSite"=> $configSite]);
    }
    public function feedback(){
        return view('home.feedback');
    }
    public function sendFeedBack(Request $request){
        $request = $request->all();
        $user = session('user');
        if($user==null){
            return redirect('phan-hoi')->withErrors(
                [
                    'login' => 'Bạn phải đăng nhập để gửi phản hồi!!!'
                ]
            );
        }
        $comment = $request["message"];
        $feedback = new Feedback;
        $feedback->UserId = $user->UserId;
        $feedback->Comment = $comment;
        $feedback->CreateAt = Carbon::now();
        $feedback->CreateBy = $user->UserId;
        $feedback->Status = 1;
        $feedback->save();
        return redirect()->back()->withErrors(
            [
                'success' => 'Bạn đã gửi phản hồi thành công. Chúng tôi sẽ liên hệ với bạn qua email!!!'
            ]
        );
    }
    public function intro(){
        $configSite = Configsite::find(1);
        return view('home.intro', [ "configSite"=> $configSite]);
    }
}
