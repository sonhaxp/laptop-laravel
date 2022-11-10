<?php

namespace App\Http\Controllers;

use App\Models\Attributevalue;
use App\Models\Classifygroupoption;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Productdetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index(){
        $cart = session('cart');
        $user = session('user');
        if($user==null){
            return redirect('dang-nhap');
        }
        $total = 0;
        if($cart == null){
            $cart = collect([]);
        }
        foreach ($cart as $item)
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
        return view('cart.index',["products"=>$cart,"total"=>$total]);
    }
    public static function UpdateCart($id,$quantity){
        $cart = session('cart');
        $temp = $cart->find($id);
        if($quantity==0){
            $cart = $cart->where("ProductId","!=","{$temp->ProductId}");
            OrderDetail::whereRaw("OrderDetailId = {$id}")->delete();
        }
        else{
            $temp->Quantity = $quantity;
            $temp->save();
        }
        session(['cart'=>$cart]);
        $total = 0;
        foreach ($cart as $item)
        {
            $item->Price = $cart->Product->Price;
            $item->Discount = $cart->Product->Discount;
            $item->save();
            $total = $total + ($item->Quantity * $item->Price * (100 - $item->Discount) / 100);
        }
        return view('shared.cart',["products"=>$cart,"total"=>$total]);
    }
    public static function GetCountCart(){
        return(session('cart')->count());
    }
    public static function AddCart(Request $request){
        $request = $request->all();
        $id = $request["idProduct"];
        $product = Product::find($id);
        $user = session('user');
        $statusCart = Attributevalue::whereRaw("Value like '%Giỏ hàng%'")->first();
        if($user==null){
            return redirect('dang-nhap');
        }
        
        $cart = session('cart');
        $orderId = 0;
        if($cart==null){
            $order = Order::whereRaw("UserId = {$user->UserId} and Status = {$statusCart->AttributeValueId}")->first();
            if($order==null){
                $order = new Order;
                $order->UserId = $user->UserId;
                $order->Status = $statusCart->AttributeValueId;
                $order->CreateAt = Carbon::now();
                $order->CreateBy = $user->UserId;
                $order->save();
                $orderId = $order->OrderId;
            }
            else{
                $orderId = $order->OrderId;
            }
            $cart = collect([]);
        }
        else{
            $orderId = $cart->first()->OrderId;
        }
        $temp = $cart->where("ProductId",$id)->first();
        if($temp!=null){
            $temp->Quantity += 1;
            $temp->save();
        }
        else{
            $item = new OrderDetail;
            $item->ProductId = $id;
            $item->OrderId = $orderId;
            $item->Quantity = 1;
            $item->Discount = $product->Discount;
            $item->Price = $product->Price;
            $item->save();
            $cart->push($item);
        }
        session(['cart'=>$cart]);
        return redirect('gio-hang');
    }
    public static function DeleteCart($id){
        $cart = session('cart');
        $temp = $cart->find($id);
        $cart = $cart->where("ProductId","!=","{$temp->ProductId}");
        OrderDetail::whereRaw("OrderDetailId = {$id}")->delete();
        session(['cart'=>$cart]);
        $total = 0;
        foreach ($cart as $item)
        {
            $total = $total + ($item->Quantity * $item->Price * (100 - $item->Discount) / 100);
        }
        return view('shared.cart',["products"=>$cart,"total"=>$total]);
    }
    public function checkout(){
        $cart = session('cart');
        $user = session('user');
        if($user==null){
            return redirect('dang-nhap');
        }
        $total = 0;
        if($cart == null){
            $cart = collect([]);
        }
        foreach ($cart as $item)
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
        return view("cart.Checkout",["products"=>$cart,"total"=>$total,"user"=>$user]);
    }
    public function completePayment(Request $request){
        $request = $request->all();
        $cart = session("cart");
        $statusWaiting = Attributevalue::whereRaw("Value like '%Chờ xác nhận%'")->first();
        $orderId = $cart->first()->OrderId;
        $order = Order::where("OrderId","=","{$orderId}")->first();
        $order->Status = $statusWaiting->AttributeValueId;
        $order->CreateAt = Carbon::now();
        $order->Address = $request["Address"];
        $order->PhoneNumber = $request["PhoneNumber"];
        $order->Receiver = $request["Name"];
        $order->Email = $request["Email"];
        $order->save();
        session(['cart'=>null]);
        return redirect("thong-tin");
    }
    public function ListOrder(Request $request){
        if(session('admin')==null){
            return redirect('admin');
        }
        $request = $request->all();
        $pageCurrent = 1;
        $whereClause = " 1 = 1 ";
        if(array_key_exists("pageCurrent",$request))
            $pageCurrent = $request["pageCurrent"];
        $typeOrder = 0;
        if(array_key_exists("typeOrder",$request)&&$request["typeOrder"]!=""){
            $typeOrder = $request["typeOrder"];
            $whereClause .= "and Status = {$typeOrder} ";
        }
        $keyword = "";
        if(array_key_exists("Name",$request)&&$request["Name"]!=""){
            $keyword = $request["Name"];
            $whereClause .= "and Receiver like '%{$keyword}%' ";
        }
        $order = Order::leftJoin('Orderdetail','Orders.OrderId', '=', 'Orderdetail.OrderId')
        ->selectRaw('sum(Orderdetail.Quantity*Price*(100-Discount)/100) as TongTien, CreateAt, DisplayName, Receiver, PhoneNumber, Address,Email, Status, Orders.OrderId')
        ->whereRaw("{$whereClause}")->where('Status','!=',16)->orderBy('CreateAt','desc')
        ->GroupByRaw('CreateAt, DisplayName, Receiver, PhoneNumber, Address,Email, Status, Orders.OrderId');
        $count = count($order->get());
        $page = ceil($count/5);

        $order = $order->skip(($pageCurrent - 1) * 5)->take(5)->get();
        $TypeOrder = Attributevalue::where('AttributeId','=',7)->where('AttributeValueId','!=',16)->get();
        return view('cart.ListOrder',[
            "count"=>$count,
            "page"=>$page,
            "order"=>$order,
            "pageCurrent"=>$pageCurrent,
            "typeOrder"=>$TypeOrder
        ]);

    }
    public static function GetOrderDetail($id){
        if(session('admin')==null){
            return redirect('admin');
        }
        $products = OrderDetail::whereRaw("OrderId = {$id}")->get();
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
        return view("Cart.Order_Modal",["products"=>$products, "total"=>$total]);
    }
    public function DeleteOrder(Request $request){
        if(session('admin')==null){
            return redirect('admin');
        }
        $request = $request->all();
        $OrderId = $request["order"];
        $order = Order::find($OrderId);
        $order->Status = 19;
        $order->UpdateAt = Carbon::now();
        $order->UpdateBy = session('admin')->UserId;
        $order->EmployeeId = session('admin')->UserId;
        $order->save();
        return 1;
    }
    public function UpdateOrder(Request $request){
        if(session('admin')==null){
            return redirect('admin');
        }
        $request = $request->all();
        $OrderId = $request["orderId"];
        $order = Order::find($OrderId);
        $orderdetail = OrderDetail::whereRaw("OrderId = {$OrderId}")->get();
        return view('cart.updateOrder',[
            "order"=>$order,
            "orderdetail"=>$orderdetail
        ]);
    }
    public function SubmitUpdateOrder(Request $request){
        if(session('admin')==null){
            return redirect('admin');
        }
        $request = $request->all();
        $orderId = $request["OrderId"];
        $order = Order::find($orderId);
        $order->Status = 18;
        $order->UpdateAt = Carbon::now();
        $order->UpdateBy = session('admin')->UserId;;
        $order->EmployeeId = session('admin')->UserId;
        $order->save();
        $orderdetail = OrderDetail::whereRaw("OrderId = {$orderId}")->get();
        foreach ($orderdetail as $item) {
            $product = Product::find($item->ProductId);
            $product->Quantity-=$item->Quantity;
            $product->save();
            $stt = Productdetail::where('ProductId','=',$item->ProductId)->max('STT');
            $IMEI = $request[$item->ProductId];
            for ($i=0; $i <  count($IMEI); $i++) { 
                $pd = Productdetail::where("SerialNumber","=",$IMEI[$i])->first();
                if($pd!=null){
                    $pd->OrderDetailId = $item->OrderDetailId;
                    $pd->PeriodOfGuarantee = Carbon::now()->addMonths($item->Product->PeriodOfGuarantee);
                }
                else{
                    $pd = new Productdetail;
                    $pd->ProductId = $item->ProductId;
                    $pd->OrderDetailId = $item->OrderDetailId;
                    $pd->SerialNumber = $IMEI[$i];
                    $pd->PeriodOfGuarantee = Carbon::now()->addMonths($item->Product->PeriodOfGuarantee);
                    $pd->STT = $stt+1;
                    $stt+=1;
                }
                $pd->save();
            }
        }
        return redirect("order/listOrder");
    }
}
