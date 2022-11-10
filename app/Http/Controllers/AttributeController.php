<?php
namespace App\Http\Controllers;

use App\Models\Articlecategory;
use App\Models\Article;
use App\Models\Attribute;
use App\Models\Attributevalue;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttributeController extends Controller
{
    public function CreateAttribute()
    {
        if(session('admin')==null){
            return redirect('admin');
        }
        $attribute = Attribute::where("Status","=","1")->get();
        return view("attribute.CreateAttribute",[
            "attribute"=>$attribute
        ]);
    }
    public function SubmitAttribute(Request $request){
        if(session('admin')==null){
            return redirect('admin');
        }
        $request = $request->all();
        $Name = $request["Name"];
        $Status = 0;
        if(array_key_exists("Active",$request)){
            $Status = 1;
        }   
        $attribute = new Attribute();
        $attribute->Name = $Name;
        $attribute->Status = $Status;
        $attribute->CreateAt= Carbon::now();
        $attribute->CreateBy = session('admin')->UserId;
        $attribute->save();
        return redirect()->back()->withErrors(
            [
                'success' => 'Thêm mới thuộc tính thành công'
            ]
        ); 
    }


    public function CreateAttributeValue()
    {
        if(session('admin')==null){
            return redirect('admin');
        }
        $attribute = Attribute::where("Status","=","1")->get();
        $attributevalue = Attributevalue::where("Status","=","1")->orderBy("attributeid")->orderBy("attributevalueid")->get();
        return view("attribute.CreateAttributeValue",[
            "attribute"=>$attribute,
            "attributevalue"=>$attributevalue
        ]);
    }
    public function SubmitAttributeValue(Request $request){
        if(session('admin')==null){
            return redirect('admin');
        }
        $request = $request->all();
        $Attribute = $request["Attribute"];
        $Value = $request["Value"];
        $Status = 0;
        if(array_key_exists("Active",$request)){
            $Status = 1;
        }   
        $attributevalue = new Attributevalue();
        $attributevalue->AttributeId = $Attribute;
        $attributevalue->Value = $Value;
        $attributevalue->Status = $Status;
        $attributevalue->save();
        return redirect()->back()->withErrors(
            [
                'success' => 'Thêm mới giá trị thành công'
            ]
        ); 
    }
}