<?php

namespace App\Http\Controllers;

use App\Models\Attributevalue;
use App\Models\Classifygroupoption;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Product;
use App\Models\Productdetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function ListPurchase(Request $request){
        if(session('admin')==null){
            return redirect('admin');
        }
        $request = $request->all();
        $pageCurrent = 1;
        $whereClause = " 1 = 1 ";
        if(array_key_exists("pageCurrent",$request))
            $pageCurrent = $request["pageCurrent"];
        $typePurchase = 0;
        if(array_key_exists("typePurchase",$request)&&$request["typePurchase"]!=""){
            $typePurchase = $request["typePurchase"];
            $whereClause .= "and Status = {$typePurchase} ";
        }
        $keyword = "";
        if(array_key_exists("Name",$request)&&$request["Name"]!=""){
            $keyword = $request["Name"];
            $whereClause .= "and Deliver like '%{$keyword}%' ";
        }
        $purchase = Purchase::leftJoin('Purchasedetail','Purchase.PurchaseId', '=', 'Purchasedetail.PurchaseId')
        ->selectRaw('sum(Purchasedetail.Quantity*Price) as TongTien, CreateAt, DisplayName, Deliver, PhoneNumber, Address,Email, Status,EmployeeId, Purchase.PurchaseId')
        ->whereRaw("{$whereClause}")->orderBy('CreateAt','desc')
        ->GroupByRaw('CreateAt, DisplayName, Deliver, PhoneNumber, Address,Email, Status, EmployeeId, Purchase.PurchaseId');
        $count = count($purchase->get());
        $page = ceil($count/5);

        $purchase = $purchase->skip(($pageCurrent - 1) * 5)->take(5)->get();
        $TypePurchase = Attributevalue::where('AttributeId','=',15)->get();
        return view('purchase.ListPurchase',[
            "count"=>$count,
            "page"=>$page,
            "purchase"=>$purchase,
            "pageCurrent"=>$pageCurrent,
            "typePurchase"=>$TypePurchase
        ]);

    }
    public static function GetPurchaseDetail($id){
        if(session('admin')==null){
            return redirect('admin');
        }
        $products = PurchaseDetail::whereRaw("PurchaseId = {$id}")->get();
        $total = 0;
        foreach ($products as $item)
        {
            $total = $total + ($item->Quantity * $item->Price * (100 - $item->Discount) / 100);
            if($item->Product->Group1!=null){
                $group1 = $item->Product->Group1;
                $group2 = $item->Product->Group2;
                if($group2==null) $group2 = "null";
                $item->Product->Attribute = Classifygroupoption::join("Classifygroup","Classifygroupoption.Classifygroupid","=","Classifygroup.Classifygroupid")
                ->join("attribute","Classifygroup.attributeid","=","attribute.attributeid")
                ->join("attributevalue","attributevalue.attributevalueid","=","classifygroupoption.valueid")
                ->selectRaw("attribute.name, attributevalue.value")
                ->whereRaw("ClassifygroupoptionId = {$group1} or ClassifygroupoptionId = {$group2}")->get();
            }
        }
        return view("Purchase.Purchase_Modal",["products"=>$products, "total"=>$total]);
    }
    public function DeletePurchase(Request $request){
        if(session('admin')==null){
            return redirect('admin');
        }
        $request = $request->all();
        $PurchaseId = $request["purchase"];
        $purchase = Purchase::find($PurchaseId);
        $purchase->Status = 19;
        $purchase->UpdateAt = Carbon::now();
        $purchase->UpdateBy = session('admin')->UserId;
        $purchase->EmployeeId = session('admin')->UserId;
        $purchase->save();
        return 1;
    }
    public function UpdatePurchase(Request $request){
        if(session('admin')==null){
            return redirect('admin');
        }
        $request = $request->all();
        $PurchaseId = $request["purchaseId"];
        $purchase = Purchase::find($PurchaseId);
        $purchasedetail = PurchaseDetail::whereRaw("PurchaseId = {$PurchaseId}")->get();
        return view('purchase.updatePurchase',[
            "purchase"=>$purchase,
            "purchasedetail"=>$purchasedetail
        ]);
    }
    public function SubmitUpdatePurchase(Request $request){
        if(session('admin')==null){
            return redirect('admin');
        }
        $request = $request->all();
        $purchaseId = $request["PurchaseId"];
        $purchase = Purchase::find($purchaseId);
        $purchase->Status = 18;
        $purchase->UpdateAt = Carbon::now();
        $purchase->UpdateBy = session('admin')->UserId;;
        $purchase->EmployeeId = session('admin')->UserId;
        $purchase->save();
        $purchasedetail = PurchaseDetail::whereRaw("PurchaseId = {$purchaseId}")->get();
        foreach ($purchasedetail as $item) {
            $product = Product::find($item->ProductId);
            $product->Quantity-=$item->Quantity;
            $product->save();
            $stt = Productdetail::where('ProductId','=',$item->ProductId)->max('STT');
            $IMEI = $request[$item->ProductId];
            for ($i=0; $i <  count($IMEI); $i++) { 
                $pd = Productdetail::where("SerialNumber","=",$IMEI[$i])->first();
                if($pd!=null){
                    $pd->PurchaseDetailId = $item->PurchaseDetailId;
                    $pd->PeriodOfGuarantee = Carbon::now()->addMonths($item->Product->PeriodOfGuarantee);
                }
                else{
                    $pd = new Productdetail;
                    $pd->ProductId = $item->ProductId;
                    $pd->PurchaseDetailId = $item->PurchaseDetailId;
                    $pd->SerialNumber = $IMEI[$i];
                    $pd->PeriodOfGuarantee = Carbon::now()->addMonths($item->Product->PeriodOfGuarantee);
                    $pd->STT = $stt+1;
                    $stt+=1;
                }
                $pd->save();
            }
        }
        return redirect("purchase/listPurchase");
    }
    public function CreatePurchase(){
        if(session('admin')==null){
            return redirect('admin');
        }
        $TypePurchase = Attributevalue::where('AttributeId','=',15)->Where('AttributeValueId','!=',35)->get();
        $product = Product::whereRaw('Status = 1')->get();
        $supplier = User::whereRaw('RoleId = 15')->get();
        return view('purchase.createPurchase',[
            "typePurchase"=>$TypePurchase,
            "product"=>$product,
            "supplier"=>$supplier
        ]);
    }

    public function GetInfoSupplier(Request $request){
        if(session('admin')==null){
            return redirect('admin');
        }
        $request = $request->all();
        $id = $request["id"];
        $supplier = User::find($id);
        return json_encode($supplier);
    }
    public function GetInfoProduct(Request $request){
        if(session('admin')==null){
            return redirect('admin');
        }
        $request = $request->all();
        $id = $request["id"];
        $product = Product::find($id);
        return json_encode($product);
    }

    public function SubmitCreatePurchase(Request $request){
        if(session('admin')==null){
            return redirect('admin');
        }
        $request=$request->all();
        $PurchaseId = $request["PurchaseId"];
        $SupplierId = $request["SupplierId"];
        $Deliver = $request["Deliver"];
        $Address = $request["Address"];
        $PhoneNumber = $request["PhoneNumber"];
        $Email = $request["Email"];
        $Product = $request["Product"];
        try{
            $purchase = new Purchase();
            $purchase->Status = $PurchaseId;
            $purchase->SupplierId = $SupplierId;
            $purchase->Deliver = $Deliver;
            $purchase->Address = $Address;
            $purchase->PhoneNumber = $PhoneNumber;
            $purchase->EmployeeId = session('admin')->UserId;
            $purchase->Email = $Email;
            $purchase->CreateAt = Carbon::now();
            $purchase->CreateBy = session('admin')->UserId;
            $purchase->save();
            foreach ($Product as $item) {
                $product = Product::find($item["ProductId"]);
                $product->Quantity+=$item["Quantity"];
                $product->Price=$item["Price"] * 1.2;
                $product->PeriodOfGuarantee=$item["PeriodOfGuarantee"];
                $product->save();
                $purchasedetail = new PurchaseDetail();
                $purchasedetail->PurchaseId =  $purchase->PurchaseId;
                $purchasedetail->ProductId  =  $item["ProductId"];
                $purchasedetail->Quantity =  $item["Quantity"];
                $purchasedetail->Price =  $item["Price"];
                $purchasedetail->save();
                $stt = Productdetail::where('ProductId','=',$item["ProductId"])->max('STT');
                foreach ($item["IMEI"] as $imei) {
                    $stt+=1;
                    $productdetail = new Productdetail();
                    $productdetail->ProductId = $purchasedetail->ProductId;
                    $productdetail->ProductDetailId = $purchasedetail->ProductDetailId;
                    $productdetail->STT = $stt;
                    $productdetail->SerialNumber = $imei;
                    $productdetail->save();
                }
            }
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
}
