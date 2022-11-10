<?php


namespace App\Http\Controllers;

use App\Models\Articlecategory;
use App\Models\Article;
use App\Models\Attribute;
use App\Models\Attributecategory;
use App\Models\Brand;
use App\Models\Brandcategory;
use App\Models\Category;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function CreateCategory()
    {
        if(session('admin')==null){
            return redirect('admin');
        }
        $category = Category::where("Status","=","1")->get();
        return view("category.CreateCategory",[
            "category"=>$category
        ]);
    }
    public function SubmitCategory(Request $request){
        if(session('admin')==null){
            return redirect('admin');
        }
        $request = $request->all();
        $Name = $request["Name"];
        $Url = $request["Url"];
        $categoryId = $request["ParentCategory"];
        if($categoryId == 0) $categoryId = null;
        $Status = 0;
        if(array_key_exists("Active",$request)){
            $Status = 1;
        }   
        $category = new Category();
        $category->Name = $Name;
        $category->Url = $Url;
        $category->ParentCategoryId = $categoryId;
        $category->Status = $Status;
        $category->CreateAt= Carbon::now();
        $category->CreateBy = session('admin')->UserId;
        $category->save();
        return redirect()->back()->withErrors(
            [
                'success' => 'Thêm mới danh mục thành công'
            ]
        ); 
    }


    public function CreateAttributeCategory()
    {
        if(session('admin')==null){
            return redirect('admin');
        }
        $category = Category::where("Status","=","1")->get();
        $attribute = Attribute::where("Status","=","1")->get();
        $categoryattribute = Attributecategory::where("Status","=","1")->orderBy('CategoryId')->get();
        return view("category.CreateAttributeCategory",[
            "category"=>$category,
            "attribute"=>$attribute,
            "categoryattribute"=>$categoryattribute
        ]);
    }
    public function SubmitAttributeCategory(Request $request){
        if(session('admin')==null){
            return redirect('admin');
        }
        $request = $request->all();
        $cat = $request["Category"];
        $attr = $request["Attribute"];
        $Status = 0;
        if(array_key_exists("Active",$request)){
            $Status = 1;
        }   
        $attr_cat= new Attributecategory();
        $attr_cat->CategoryId = $cat;
        $attr_cat->AttributeId = $attr;
        $attr_cat->Status = $Status;
        try {
            $attr_cat->save();
            return redirect()->back()->withErrors(
                [
                    'success' => 'Thêm mới thuộc tính - danh mục thành công'
                ]
            ); 
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(
                [
                    'Attribute' => "Thuộc tính này đã có trong danh mục. Không thể thêm!"
                ]
            ); 
        }
    }


    public function CreateBrandCategory()
    {
        if(session('admin')==null){
            return redirect('admin');
        }
        $category = Category::where("Status","=","1")->get();
        $brand = Brand::where("Status","=","1")->get();
        $categorybrand = Brandcategory::where("Status","=","1")->orderBy('CategoryId')->get();
        return view("category.CreateBrandCategory",[
            "category"=>$category,
            "brand"=>$brand,
            "categorybrand"=>$categorybrand
        ]);
    }
    public function SubmitBrandCategory(Request $request){
        if(session('admin')==null){
            return redirect('admin');
        }
        $request = $request->all();
        $cat = $request["Category"];
        $brand = $request["Brand"];
        $Status = 0;
        if(array_key_exists("Active",$request)){
            $Status = 1;
        }   
        $brand_cat= new Brandcategory();
        $brand_cat->CategoryId = $cat;
        $brand_cat->BrandId = $brand;
        $brand_cat->Status = $Status;
        try {
            $brand_cat->save();
            return redirect()->back()->withErrors(
                [
                    'success' => 'Thêm mới thương hiệu - danh mục thành công'
                ]
            ); 
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(
                [
                    'Brand' => "Thương hiệu này đã có trong danh mục. Không thể thêm!"
                ]
            ); 
        }
    }
}