<?php


namespace App\Http\Controllers;

use App\Models\Articlecategory;
use App\Models\Article;
use App\Models\Brand;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function CreateBrand()
    {
        if(session('admin')==null){
            return redirect('admin');
        }
        $brand = Brand::where("Status","=","1")->get();
        return view("brand.CreateBrand",[
            "brand"=>$brand
        ]);
    }
    public function SubmitBrand(Request $request){
        if(session('admin')==null){
            return redirect('admin');
        }
        $request = $request->all();
        $Name = $request["Name"];
        $BrandId = $request["ParentBrand"];
        if($BrandId == 0) $BrandId = null;
        $Status = 0;
        if(array_key_exists("Active",$request)){
            $Status = 1;
        }   
        $brand = new Brand();
        $brand->Name = $Name;
        $brand->BrandParentId = $BrandId;
        $brand->Status = $Status;
        $brand->CreateAt= Carbon::now();
        $brand->CreateBy = session('admin')->UserId;
        $brand->save();
        return redirect()->back()->withErrors(
            [
                'success' => 'Thêm mới thương hiệu thành công'
            ]
        ); 
    }
}