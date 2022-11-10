<?php

namespace App\Http\Controllers;

use App\Models\Attributecategory;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Rate;
use App\Models\Attributedetail;
use App\Models\Attributevalue;
use App\Models\Brand;
use App\Models\Brandcategory;
use App\Models\Classifygroup;
use Attribute;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    public static function product($urlCategory,$urlProduct){
        $category = Category::whereRaw("Status = 1 and Url = '{$urlCategory}'")->first();
        $product = Product::whereRaw("Status = 1 and Url = '{$urlCategory}/{$urlProduct}'")->first();
        if($category==null){
            return redirect('trang-chu');
        }
        if($category==null){
            return redirect('trang-chu');
        }
        //$rate = Rate::whereRaw("ProductId = '{$product->ProductId}'")->selectRaw('count(*) as Quantity,IFNULL(sum(Star)/count(*),0) as rate')->first();
        $rate = Rate::whereRaw("ProductId = '{$product->ProductId}'")->orderBy("CreateAt","desc")->get();
        $rate_Count = $rate->count();
        $rate_Rate = 0;
        foreach($rate as $item){
            $rate_Rate += $item->Star;
        }
        if($rate_Count!=0){
            $rate_Rate/=$rate_Count;
        }
        $attribute = Attributedetail::where("ProductId","=","{$product->ProductId}")->get();
        $parentProduct = Product::where("ProductId","=","{$product->ProductParentId}")->first();
        $classifygroup = null;
        if($parentProduct != null){
            $classifygroup = Classifygroup::where("classifygroup.ProductId","=","{$parentProduct->ProductId}")->get();
            $groupoptions = $classifygroup[0]->classifygroupoptions;
            for ($j=0; $j < $groupoptions->count(); $j++) { 
                $temp = $classifygroup[0]->classifygroupoptions[$j];
                $temp->product = Product::whereRaw("Product.ProductParentId = {$parentProduct->ProductId} and Group1 = {$temp->ClassifyGroupOptionId}")->first();
            }
            if($classifygroup->count()>1){
                $groupoptions = $classifygroup[1]->classifygroupoptions;
                for ($j=0; $j < $groupoptions->count(); $j++) { 
                    $temp = $classifygroup[1]->classifygroupoptions[$j];
                    $temp->product = Product::whereRaw("Product.ProductParentId = {$parentProduct->ProductId} and Group1 = {$product->Group1} and Group2 = {$temp->ClassifyGroupOptionId}")->first();
                }
            }
        }
        return view('product.index',["product"=>$product,
                                     "category"=>$category,
                                     "rate"=>$rate,
                                     "rate_Count"=>$rate_Count,
                                     "rate_Rate"=>$rate_Rate,
                                     "attribute"=>$attribute,
                                     "classifygroup"=>$classifygroup
                                    ]);
    }
    public static function products($urlCategory){
        $category = Category::whereRaw("Status = 1 and Url = '{$urlCategory}'")->first();
        $cat = Category::whereRaw("Status = 1 and ((CategoryId = {$category->CategoryId} or ParentCategoryId = {$category->CategoryId}))")->get();
        $catId = [];
        foreach($cat as $item){
            array_push($catId,$item->CategoryId);
        }
        $statusInvoice = Attributevalue::whereRaw("Value like '%Hóa đơn%'")->first();
        if($category==null){
            redirect('trang-chu');
        }
        $brand = Brandcategory::whereIn("CategoryId",$catId)->whereRaw("Status = 1")->get();
        $count = Product::leftJoin(DB::raw("Product b"),"Product.ProductId","=","b.ProductParentId")->whereRaw("b.ProductId is null")
        ->whereIn("Product.CategoryId",$catId)->whereRaw("Product.Status = 1")->count();
        $page = ceil($count/12);
        $product = Product::leftJoin(DB::raw("Product b"),"Product.ProductId","=","b.ProductParentId")->whereRaw("b.ProductId is null");
        $product = $product->leftJoin(DB::raw("(select * from OrderDetail where OrderId in (select OrderId from Orders where Status = {$statusInvoice->AttributeValueId})) a"),"a.ProductId","=", "Product.ProductId")
                            ->selectRaw('ifnull(sum(a.Quantity),0) as SoLuong, Product.ProductId, Product.ShortName, Product.Name, Product.Url,Product.BrandId, Product.Price, Product.Discount, Product.Image')
                            ->GroupByRaw('Product.ProductId, Product.ShortName, Product.Name, Product.Url,Product.BrandId, Product.Price, Product.Discount, Product.Image')
                            ->whereIn("Product.CategoryId",$catId)
                            ->whereRaw("Product.Status = 1")
                            ->orderBy('SoLuong','desc')->orderby('ProductId')
                            ->take(12)->get();
        return view('product.product',["category"=>$category,
                                        "brand"=>$brand,
                                        "page"=>$page,
                                        "products"=>$product
                                        ]);
    }
    public function filterProduct(Request $request){
        $request = $request->all();
        $brand = $request["brand"];
        $price = $request["price"];
        $priceWhere = "";
        $page = $request["page"];
        $orderby = $request["orderby"];
        $categoryId = $request["category"];
        $cat = Category::whereRaw("Status = 1 and ((CategoryId = {$categoryId} or ParentCategoryId = {$categoryId}))")->get();
        $catId = [];
        foreach($cat as $item){
            array_push($catId,$item->CategoryId);
        }
        if($brand==null){
            $brandDB = Brandcategory::whereIn("CategoryId",$catId)->whereRaw("Status = 1")->get();
            $brand = [];
            foreach($brandDB as $item){
                array_push($brand,$item->BrandId);
            }
        }
        else{
            $brand = explode(',',$brand);
        }
        if($price != null){
            $price = explode(',',$price);
            $flag = true;
            if(in_array(1,$price)){
                if($flag){
                    $priceWhere .=" Product.Price*(1-Product.Discount/100)<10000000";
                    $flag = false;
                }
                else{
                    $priceWhere .= " or Product.Price*(1-Product.Discount/100)<10000000";
                }
            }
            if(in_array(2,$price)){
                if($flag){
                    $priceWhere .= " (Product.Price*(1-Product.Discount/100)>=10000000 and Product.Price*(1-Product.Discount/100)<15000000)";
                    $flag = false;
                }
                else{
                    $priceWhere .= " or (Product.Price*(1-Product.Discount/100)>=10000000 and Product.Price*(1-Product.Discount/100)<15000000)";
                }
            }
            if(in_array(3,$price)){
                if($flag){
                    $priceWhere .= " (Product.Price*(1-Product.Discount/100)>=15000000 and Product.Price*(1-Product.Discount/100)<20000000)";
                    $flag = false;
                }
                else{
                    $priceWhere .= " or (Product.Price*(1-Product.Discount/100)>=15000000 and Product.Price*(1-Product.Discount/100)<20000000)";
                }
            }
            if(in_array(4,$price)){
                if($flag){
                    $priceWhere .= " ((Product.Price*(1-Product.Discount/100)>=20000000 and (Product.Price*(1-Product.Discount/100)<25000000)";
                    $flag = false;
                }
                else{
                    $priceWhere .= " or (Product.Price*(1-Product.Discount/100)>=20000000 and Product.Price*(1-Product.Discount/100)<25000000)";
                }
            }
            if(in_array(5,$price)){
                if($flag){
                    $priceWhere .= " Product.Price>=25000000";
                    $flag = false;
                }
                else{
                    $priceWhere .= " or Product.Price>=25000000";
                }
            }
            
        }
        else{
            $priceWhere = " 1 = 1 ";
        }
        $product = Product::leftJoin(DB::raw("Product b"),"Product.ProductId","=","b.ProductParentId")->whereRaw("b.ProductId is null");
        $product = $product->whereIn('Product.BrandId',$brand)
            ->whereIn("Product.CategoryId",$catId)
            ->whereRaw("Product.Status = 1 and ({$priceWhere})");
        $page_count = ceil($product->count()/12);
        if($orderby==0){
            $statusInvoice = Attributevalue::whereRaw("Value like '%Hóa đơn%'")->first();
            $product = $product->leftJoin(DB::raw("(select * from OrderDetail where OrderId in (select OrderId from Orders where Status = {$statusInvoice->AttributeValueId})) a"),"a.ProductId","=", "Product.ProductId")
                            ->selectRaw('ifnull(sum(a.Quantity),0) as SoLuong, Product.ProductId, Product.ShortName, Product.Name, Product.Url,Product.BrandId, Product.Price, Product.Discount, Product.Image')
                            ->GroupByRaw('Product.ProductId, Product.ShortName, Product.Name, Product.Url,Product.BrandId, Product.Price, Product.Discount, Product.Image')
                            ->orderBy('SoLuong','desc')->orderby('Product.ProductId')
                            ->skip(($page - 1) * 12)->take(12)->get();
        }
        else if($orderby==1){
            $product = $product->selectRaw('Product.ProductId, Product.ShortName, Product.Name, Product.Url,Product.BrandId, Product.Price, Product.Discount, Product.Image')
            ->orderBy(DB::raw('Product.Price * (1 - Product.Discount/100)'))->orderby('Product.ProductId')
            ->skip(($page - 1) * 12)->take(12)->get();
        }
        else if($orderby==2){
            $product = $product->selectRaw('Product.ProductId, Product.ShortName, Product.Name, Product.Url,Product.BrandId, Product.Price, Product.Discount, Product.Image')
            ->orderBy(DB::raw('Product.Price * (1 - Product.Discount/100)'),'desc')->orderby('Product.ProductId')
            ->skip(($page - 1) * 12)->take(12)->get();
        }
        else {
            $statusInvoice = Attributevalue::whereRaw("Value like '%Hóa đơn%'")->first();
            $product = $product->leftJoin("Rate", "Rate.ProductId", "Product.ProductId")
                            ->selectRaw('ifnull(avg(Star),0) as Star, Product.ProductId, Product.ShortName, Product.Name, Product.Url,Product.BrandId, Product.Price, Product.Discount, Product.Image')
                            ->GroupByRaw('Product.ProductId, Product.ShortName, Product.Name, Product.Url,Product.BrandId, Product.Price, Product.Discount, Product.Image')
                            ->orderBy('Star','desc')->orderby('Product.ProductId')
                            ->skip(($page - 1) * 12)->take(12)->get();
        }
        return view("shared.Product_Main",["products"=>$product,"page"=>$page_count]);
    }
    public function search(Request $request){
        $request = $request->all();
        $keyword = $request["keyword"];
        $brand = $request["brand"];
        $pageCurrent = $request["page"];
        $whereClause = " Product.Status = 1 and Product.Name like '%{$keyword}%'";
        if($brand != "Tất cả"){
            $category = Category::whereRaw("Name = '{$brand}'")->first();
            $whereClause = $whereClause." and Product.CategoryId = {$category->CategoryId}";
        }
        $product = Product::leftJoin(DB::raw("Product b"),"Product.ProductId","=","b.ProductParentId")
        ->selectRaw("Product.ProductId, Product.ShortName, Product.Name, Product.Url,Product.BrandId, Product.Price, Product.Discount, Product.Image")
        ->whereRaw("b.ProductId is null")
        ->whereRaw($whereClause);
        $page = ceil($product->count()/9);
        $product = $product->skip(($pageCurrent - 1) * 9)->take(9)->get();
        return view("product.searchPage",[
            "products"=>$product,
            "page"=>$page,
            "keyword"=>$keyword,
            "cat"=>$brand,
            "pageCurrent"=>$pageCurrent
        ]);
    }

    public function CreateProduct(){
        if(session('admin')==null){
            return redirect('admin');
        }
        $category = Category::where("Status","=","1")->get();
        return view("product.createProduct",[
            "category"=>$category
        ]);
    }
    public static function RenderAttribute($id){
        if(session('admin')==null){
            return redirect('admin');
        }
        $catId = $id;
        if($id!=""){
            $attribute = Attributecategory::whereRaw("Status = 1 and CategoryId = {$catId}")->get();
            foreach ($attribute as $item ) {
                $item->Value = Attributevalue::whereRaw("Status = 1 and AttributeId = {$item->AttributeId}")->get();
            }
            return view("product.AttributeProduct",[
                "attribute"=>$attribute,
            ]);
        }
        
    }
    public static function RenderBrand($id){
        if(session('admin')==null){
            return redirect('admin');
        }
        $catId = $id;
        if($id!=""){
            $brand = Brandcategory::whereRaw("Status = 1 and CategoryId = {$catId}")->get();
            return view("product.BrandCategory",[
                "brand"=>$brand,
            ]);
        }
        
    }
    public function SubmitCreateProduct(Request $request){
        if(session('admin')==null){
            return redirect('admin');
        }
        $request = $request->all();
        $CategoryId = $request["Category"];
        $BrandId = $request["Brand"];
        $Name = $request["Name"];
        $Discount = $request["Discount"];
        $PeriodOfGuarantee = $request["PeriodOfGuarantee"];
        $ShortName = $request["ShortName"];
        $Price = $request["Price"];
        $Description = $request["Description"];
        $Url = $request["Url"];
        $Active = 0;
        if(array_key_exists("Active",$request)){
            $Active = 1;
        }   
        $product = new Product();
        $product->CategoryId = $CategoryId;
        $product->Name = $Name;
        $product->ShortName = $ShortName;
        $product->Discount = $Discount;
        $product->Price = $Price;
        $product->Description = $Description;
        $product->PeriodOfGuarantee = $PeriodOfGuarantee;
        $product->ShortName = $ShortName;
        $product->BrandId = $BrandId;
        $product->Url = $Url;
        $product->Status = $Active;
        $product->CreateAt = Carbon::now();
        $product->CreateBy = session('admin')->UserId;
        if(array_key_exists("Image",$request)){
            $image = $request["Image"];
            if($image->getClientMimeType()!="image/jpeg" && $image->getClientMimeType()!="image/png"&& $image->getClientMimeType()!="image/jpg" && $image->getClientMimeType()!="image/gif")
                return redirect()->back()->withErrors(
                    [
                        'image' => 'Định dạng phải là jpeg,jpg,png,gif'
                    ]
                );
            $destination_path = "public/images/product";
            $image_name = $image->getClientOriginalName();
            $image->storeAs($destination_path,$image_name);
            $pathSql = "storage/images/product/"."$image_name";
            $product->Image = $pathSql;
        }
        $product->save();
        $attribute = Attributecategory::whereRaw("Status = 1 and CategoryId = {$product->CategoryId}")->get();
            foreach ($attribute as $item ) {
                $item->Value = Attributevalue::whereRaw("Status = 1 and AttributeId = {$item->AttributeId}")->get();
                if(array_key_exists($item->AttributeId,$request)&&$request[$item->AttributeId]!=""){
                    $attributedetail = new Attributedetail();
                    $attributedetail->ProductId = $product->ProductId;
                    $attributedetail->AttributeId = $item->AttributeId;
                    $attributedetail->ValueId = $request[$item->AttributeId];
                    $attributedetail->Status = 1;
                    $attributedetail->CreateAt = Carbon::now();
                    $attributedetail->CreateBy = session('admin')->UserId;
                    $attributedetail->save();
                }
            }
        return redirect()->back()->withErrors(
            [
                'success' => 'Thêm mới sản phẩm thành công'
            ]
        );  
    }
    public static function ListProduct(Request $request){
        if(session('admin')==null){
            return redirect('admin');
        }
        $request = $request->all();
        $pageCurrent = 1;
        $whereClause = "1 = 1 ";
        if(array_key_exists("pageCurrent",$request))
            $pageCurrent = $request["pageCurrent"];
        $catId = 0;
        if(array_key_exists("pageCurrent",$request)&&$request["catId"]!=""){
            $catId = $request["catId"];
            $whereClause .= "and CategoryId = {$catId} ";
        }
        $Name = "";
        if(array_key_exists("Name",$request)&&$request["Name"]!=""){
            $Name = $request["Name"];
            $whereClause .= "and Name like '%{$Name}%' ";
        }
        $product = Product::whereRaw("Status = 1 and ProductParentId is null and {$whereClause}");
        $category = Category::whereRaw('Status = 1')->get();
        $count = $product->count();
        $page = ceil($count/3);
        $product = $product->skip(($pageCurrent - 1) * 3)->take(3)->get();
        return view('product.ListProduct',[
            "product"=>$product,
            "count"=>$count,
            "category"=>$category,
            "page"=>$page,
            "pageCurrent"=>$pageCurrent
        ]);
    }
    public function DeleteProduct(Request $request){
        if(session('admin')==null){
            return redirect('admin');
        }
        $request = $request->all();
        $id = $request["product"];
        try {
            $Attributedetail = Attributedetail::whereRaw("ProductId = {$id}")->delete();
            $adm = Product::find($id)->delete();
            return 1;
        }
        catch (Exception $e) {
            $adm = Product::find($id);
            $adm->Status = 0;
            $adm->UpdateAt = Carbon::now();
            $adm->UpdateBy = session("admin")->UserId;
        }
    }
    public function UpdateProduct(Request $request){
        if(session('admin')==null){
            return redirect('admin');
        }
        $request = $request->all();
        $productId = $request["productId"];
        $product = Product::find($productId);
        $brand = Brandcategory::whereRaw("Status = 1 and CategoryId = {$product->CategoryId}")->get();
        $attribute = Attributecategory::whereRaw("Status = 1 and CategoryId = {$product->CategoryId}")->get();
        $attributedetail = Attributedetail::whereRaw("Status = 1 and ProductId = {$product->ProductId}");
        foreach ($attribute as $item ) {
            $item->Value = Attributevalue::whereRaw("Status = 1 and AttributeId = {$item->AttributeId}")->get();
            foreach ($item->Value as $temp) {
                $a = Attributedetail::whereRaw("Status = 1 and ProductId = {$product->ProductId}")->where("AttributeId","=",$temp->AttributeId)->first();
                if($a == null){
                    $temp->flag = false;
                }
                else if($a->ValueId == $temp->AttributeValueId){
                    $temp->flag = true;
                }
                else{
                    $temp->flag = false;
                }
            }
        }
        $category = Category::where("Status","=","1")->get();
        return view("product.updateProduct",[
            "category"=>$category,
            "product"=>$product,
            "brand"=>$brand,
            "attributedetail"=>$attributedetail,
            "attribute"=>$attribute,
        ]);
    }
    public static function SubmitUpdateProduct(Request $request){
        if(session('admin')==null){
            return redirect('admin');
        }
        $request = $request->all();
        $CategoryId = $request["Category"];
        $ProductId = $request["ProductId"];
        $BrandId = $request["Brand"];
        $Name = $request["Name"];
        $Discount = $request["Discount"];
        $ShortName = $request["ShortName"];
        $PeriodOfGuarantee = $request["PeriodOfGuarantee"];
        $Price = $request["Price"];
        $Description = $request["Description"];
        $Url = $request["Url"];
        $Active = 0;
        if(array_key_exists("Active",$request)){
            $Active = 1;
        }   
        $product = Product::find($ProductId);
        $product->CategoryId = $CategoryId;
        $product->Name = $Name;
        $product->ShortName = $ShortName;
        $product->Discount = $Discount;
        $product->Price = $Price;
        $product->Description = $Description;
        $product->PeriodOfGuarantee = $PeriodOfGuarantee;
        $product->ShortName = $ShortName;
        $product->BrandId = $BrandId;
        $product->Url = $Url;
        $product->Status = $Active;
        $product->UpdateAt = Carbon::now();
        $product->UpdateBy = session('admin')->UserId;
        if(array_key_exists("Image",$request)){
            $image = $request["Image"];
            if($image->getClientMimeType()!="image/jpeg" && $image->getClientMimeType()!="image/png"&& $image->getClientMimeType()!="image/jpg" && $image->getClientMimeType()!="image/gif")
                return redirect()->back()->withErrors(
                    [
                        'image' => 'Định dạng phải là jpeg,jpg,png,gif'
                    ]
                );
            $destination_path = "public/images/product";
            $image_name = $image->getClientOriginalName();
            $image->storeAs($destination_path,$image_name);
            $pathSql = "storage/images/product/"."$image_name";
            $product->Image = $pathSql;
        }
        $product->save();
        $attribute = Attributecategory::whereRaw("Status = 1 and CategoryId = {$product->CategoryId}")->get();
        foreach ($attribute as $item ) {
            $attributedetail = Attributedetail::whereRaw("ProductId = {$ProductId} and AttributeId = {$item->AttributeId}")->first();
            if($attributedetail==null){
                $attributedetail = new Attributedetail();
                $attributedetail->CreateAt = Carbon::now();
                $attributedetail->CreateBy = session('admin')->UserId;
            }
            else{
                $attributedetail->UpdateAt = Carbon::now();
                $attributedetail->UpdateBy = session('admin')->UserId;
            }
            if(array_key_exists($item->AttributeId,$request)&&$request[$item->AttributeId]!=""){
                $attributedetail->ProductId = $product->ProductId;
                $attributedetail->AttributeId = $item->AttributeId;
                $attributedetail->ValueId = $request[$item->AttributeId];
                $attributedetail->Status = 1;
                $attributedetail->save();
            }
            else{
                $attributedetail->delete();
            }
        }
        return redirect()->back()->withErrors(
            [
                'success' => 'Sửa sản phẩm thành công'
            ]
        );  
    }

}
