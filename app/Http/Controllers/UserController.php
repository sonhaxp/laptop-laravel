<?php

namespace App\Http\Controllers;

use App\Models\Attributevalue;
use App\Models\Classifygroupoption;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Rate;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserController extends Controller
{
    public function login(){
        return view('user.login');
    }
    public function checkLogin(Request $request){
        $request = $request->all();
        $username = $request["username"];
        $password = $request["password"];
        $user = User::whereRaw("UserName = '{$username}'")->first();
        $idKH = Attributevalue::whereRaw("Value like '%khách hàng%'")->first()->AttributeValueId;
        if($user == null||!Hash::check($password, $user->Password)||$user->RoleId!=$idKH)
            return redirect()->back()->withErrors(
                [
                    'email' => 'Sai tên đăng nhập hoặc mật khẩu'
                ]
            );
        $statusCart = Attributevalue::whereRaw("Value like '%Giỏ hàng%'")->first();
        $order = Order::whereRaw("UserId = '{$user->UserId}' and status = {$statusCart->AttributeValueId}")->first();
        if($order != null){
            $cart = OrderDetail::with('product')->whereRaw("OrderId = '{$order->OrderId}'")->get();
            foreach($cart as $item){
                $item->Price = $item->Product->Price;
                $item->Discount = $item->Product->Discount;
                $item->save();
            }
            session(['cart'=>$cart]);
        }
        session(['user'=>$user]);
        return redirect('trang-chu');

    }
    public function register(){
        
        //$data['password'] = Hash::make($request->password);
        return view('user.register');
    }
    public function registerUser(Request $request){
        $request = $request->all();
        $email = $request["email"];
        $a = User::whereRaw("Email = '{$email}'")->first();
        if($a!=null){
            return redirect()->back()->withErrors(
                [
                    'email' => 'Email đã tồn tại. Vui lòng chọn email khác!!!'
                ]
            );
        }
       
        $idKH = Attributevalue::whereRaw("Value like '%khách hàng%'")->first()->AttributeValueId;
        $user = new User;
        $user->Name = $request["name"];
        $user->Password = Hash::make($request["password"]);
        $user->UserName = $request["email"];
        $user->Email = $request["email"];
        $user->PhoneNumber = $request["phone"];
        $user->Gender = $request["gender"];
        $user->Birthday = $request["birthday"];
        $user->RoleId = $idKH;
        $user->Status = 1;
        $user->CreateAt = Carbon::now();
        $user->CreateBy = 1;
        $user->save();
        return redirect('dang-nhap');
    }
    public function logout(){
        session(['user'=>null]);
        session(['cart'=>null]); 
        return redirect('trang-chu');
    }
    public function info(){
        $statusCart = Attributevalue::whereRaw("Value like '%Giỏ hàng%'")->first();
        $statusInvoice = Attributevalue::whereRaw("Value like '%Hóa đơn%'")->first();
        $user = session("user");
        $chitieu = Order::join('Orderdetail','Orders.OrderId', '=', 'Orderdetail.OrderId')
                    ->selectRaw('sum(Quantity*Price*(100-Discount)/100) as TongTien')->whereRaw("UserId = {$user->UserId} and YEAR(Orders.CreateAt) = YEAR(NOW()) and Status = {$statusInvoice->AttributeValueId}" )->first();
        $chitieu = $chitieu->TongTien==null?0:$chitieu->TongTien;
        
        $orders = Order::join('Orderdetail','Orders.OrderId', '=', 'Orderdetail.OrderId')
        ->selectRaw('sum(Quantity*Price*(100-Discount)/100) as TongTien, CreateAt, DisplayName, Receiver, PhoneNumber, Address,Email, Status, Orders.OrderId')
        ->GroupByRaw('CreateAt, DisplayName, Receiver, PhoneNumber, Address,Email, Status, Orders.OrderId')
        ->whereRaw("UserId = {$user->UserId} and YEAR(Orders.CreateAt) = YEAR(NOW()) and Status != {$statusCart->AttributeValueId}" )
        ->get();
        return view('user.info',["user"=>$user,"chitieu"=>$chitieu,"orders"=>$orders]);
    }
    public function ChangeInfo(Request $request){
        $user = session("user");
        $request = $request->all();
        $flag = $request["flag"];
        $address = $request["address"];
        $password_old = $request["password_old"];
        $password_new = $request["password_new"];
        if(!Hash::check($password_old, $user->Password)&&$flag !="0"){
            return redirect()->back()->withErrors(
                [
                    'password' => 'Mật khẩu không chính xác. Vui lòng nhập lại!!!'
                ]
            );
        }
        $user->Address = $address;
        if($flag!="0")
            $user->Password = Hash::make($password_new);
        $user->save();
        return redirect('thong-tin');
    }
    public static function GetOrderDetail($id){
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
        return view("Shared.Order_Modal",["products"=>$products, "total"=>$total]);
    }

    public function Rate(Request $request){
        $request = $request->all();
        $comment = $request["comment"];
        $productId = $request["productId"];
        $rating = $request["rating"];
        $user = session('user');
        if($user == null){
            return redirect()->back()->withErrors(
                [
                    'role' => 'Bạn phải đăng nhập trước khi đánh giá!!!'
                ]
            );
        }
        $statusInvoice = Attributevalue::whereRaw("Value like '%Hóa đơn%'")->first();
        $flag = Order::join('OrderDetail','Orders.OrderId', '=', 'Orderdetail.OrderId')
                    ->whereRaw("UserId = {$user->UserId} and Status = {$statusInvoice->AtributeValueId}");
        
        if($flag == null){
            return redirect()->back()->withErrors(
                [
                    'role' => 'Bạn chưa mua sản phẩm này nên không thể đánh giá!!!'
                ]
            );
        }
        $rate = Rate::whereRaw("UserId = {$user->UserId} and ProductId = {$productId}")->first();
        if($rate!=null){
            $rate->Comment = $comment;
            $rate->Star = $rating;
            $rate->UpdateAt = Carbon::now();
            $rate->UpdateBy = $user->UserId;
            $rate->save();
            return redirect()->back()->withErrors(
                [
                    'role' => 'Bạn đã cập nhật đánh giá thành công!!!'
                ]
            );
        }
        else{
            $rate = new Rate;
            $rate->Comment = $comment;
            $rate->UserId = $user->UserId;
            $rate->ProductId = $productId;
            $rate->CreateAt = Carbon::now();
            $rate->CreateBy = $user->UserId;
            $rate->Star = $rating;
            $rate->save();
            return redirect()->back()->withErrors(
                [
                    'role' => 'Bạn đã đánh giá thành công!!!'
                ]
            );
        }        
    }
    public function ListCustomer(){
        if(session('admin')==null){
            return redirect('admin');
        }
        $user = User::where("RoleId","=","14")->get();
        return view("user.ListCustomer",[
            "user"=>$user
        ]);
    }
    public function ListSupplier(){
        if(session('admin')==null){
            return redirect('admin');
        }
        $user = User::where("RoleId","=","15")->get();
        return view("user.ListSupplier",[
            "user"=>$user
        ]);
    }
    public function User(){
        if(session('admin')==null){
            return redirect('admin');
        }
        $user = User::where("RoleId","=","14")->get();
        return view("user.User");
    }
    public function CreateUser(Request $request){
        if(session('admin')==null){
            return redirect('admin');
        }
        $request = $request->all();
        $Name = $request["Name"];
        $Email = $request["Email"];
        $Address = $request["Address"];
        $PhoneNumber = $request["PhoneNumber"];
        $Status = 0;
        if(array_key_exists("Active",$request)){
            $Status = 1;
        }   
        $user= new User();
        $user->Name = $Name;
        $user->UserName = $Name;
        $user->Email = $Email;
        $user->PhoneNumber = $PhoneNumber;
        $user->Address = $Address;
        $user->Status = $Status;
        $user->RoleId = 15;
        $user->CreateAt = Carbon::now();
        $user->CreateBy = session('admin')->UserId;
        $user->save();
        try {
            $user->save();
            return redirect()->back()->withErrors(
                [
                    'success' => 'Thêm mới nhà cung cấp thành công'
                ]
            ); 
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(
                [
                    'User' => "Nhà cung cấp này đã có. Không thể thêm!"
                ]
            ); 
        }
    }
}
