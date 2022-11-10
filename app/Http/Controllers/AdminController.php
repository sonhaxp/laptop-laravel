<?php


namespace App\Http\Controllers;

use App\Models\Configsite;
use App\Models\Attributevalue;
use App\Models\User;
use App\Models\Product;
use App\Models\Article;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\FeedBack;
use App\Models\Slider;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Symfony\Polyfill\Intl\Idn\Resources\unidata\Regex;

class AdminController extends Controller
{
    public function index()
    {
        if(session("admin")==null){
            return redirect('admin/login');
        }
        $configSite = ConfigSite::first();
        $admin = session("admin");
        $idCus = Attributevalue::whereRaw("Value like '%Khách hàng%'")->first();
        $countProduct = Product::whereRaw("ProductParentId is null and Status = 1")->count();
        $countArticle = Article::whereRaw("Status = 1")->count();
        $countFeedBack = FeedBack::whereRaw("Status = 1")->count();
        $countCustomer = User::whereRaw("Status = 1 and RoleId = {$idCus->AttributeValueId}")->count();
        $countBrand = Brand::whereRaw("Status = 1")->count();
        return view("admin.index",[
            "configSite"=>$configSite,
            "admin"=>$admin,
            "countProduct"=>$countProduct,
            "countArticle"=>$countArticle,
            "countFeedBack"=>$countFeedBack,
            "countCustomer"=>$countCustomer,
            "countBrand"=>$countBrand,
        ]);
    }
    public function login()
    {
        return view("Shared.Admin.login");
    }
    public function checklogin(Request $request)
    {
        $request = $request->all();
        $adminname = $request["UserName"];
        $password = $request["Password"];
        $admin = User::whereRaw("UserName = '{$adminname}'")->first();
        if($admin == null||!Hash::check($password, $admin->Password)||($admin->Attributevalue->Value!="Quản trị viên"&&$admin->Attributevalue->Value!="Nhân viên"))
            return redirect()->back()->withErrors(
                [
                    'email' => 'Sai tài khoản hoặc mật khẩu'
                ]
            );
        $admin->LastLogin = Carbon::now();
        $admin->save();
        session(['admin'=>$admin]);
        return redirect('admin');
    }
    public function changePass(){
        if(session('admin')!=null){
            return view('admin.ChangePass');
        }
        return redirect('admin');
    }
    public function ChangePassWord(Request $request){
        if(session('admin')==null){
            return redirect('admin');
        }
        $request = $request->all();
        $admin = session('admin');
        $oldPassword = $request["OldPassword"];
        $password = $request["Password"];
        if($admin == null||!Hash::check($oldPassword, $admin->Password))
            return redirect()->back()->withErrors(
                [
                    'password' => 'Mật khẩu hiện tại không đúng'
                ]
            );
        $admin->Password = Hash::make($password);
        $admin->save();
        session(['admin'=>null]);
        return redirect('admin');
    }
    public function logout(){
        session(['admin'=>null]);
        return redirect('admin');
    }
    public function AdminAccount(){
        $roleAdmin = Attributevalue::whereRaw("Value like '%Quản trị viên%'")->first();
        $roleManager = Attributevalue::whereRaw("Value like '%Nhân viên%'")->first();
        if(session('admin')==null||session('admin')->RoleId!=$roleAdmin->AttributeValueId){
            return redirect('admin');
        }
        $Role = Attributevalue::whereRaw("AttributeId = 6")->get();
        $Admin = User::whereIn("RoleId",[$roleAdmin->AttributeValueId,$roleManager->AttributeValueId])->get();
        return view('admin.CreateAdmin',[
            "role"=>$Role,
            "admins"=>$Admin
        ]);

    }
    public function CreateAdmin(Request $request){
        $roleAdmin = Attributevalue::whereRaw("Value like '%Quản trị viên%'")->first();
        if(session('admin')==null||session('admin')->RoleId!=$roleAdmin->AttributeValueId){
            return redirect('admin');
        }
        $request = $request->all();
        $username = $request["Username"];
        $name = $request["Name"];
        $password = $request["Password"];
        $active = $request["Active"]!=null?1:0;
        $role = $request["Role"];
        if(User::whereRaw("UserName = '{$username}'")->first()!=null){
            return redirect()->back()->withErrors(
                [
                    'username' => 'Tên đăng nhập đã được dùng.'
                ]
            );
        };
        $admin = new User;
        $admin->UserName = $username;
        $admin->Name = $name;
        $admin->Password = Hash::make($password);
        $admin->Status = $active;
        $admin->RoleId = $role;
        $admin->CreateAt = Carbon::now();
        $admin->CreateBy = session('admin')->UserId;
        $admin->save();
        return redirect()->back()->withErrors(
            [
                'success' => 'Tài khoản được tạo thành công.'
            ]
        );        
    }
    public static function EditAdmin($id){
        $roleAdmin = Attributevalue::whereRaw("Value like '%Quản trị viên%'")->first();
        if(session('admin')==null||session('admin')->RoleId!=$roleAdmin->AttributeValueId){
            return redirect('admin');
        }
        $admin = User::find($id);
        if($admin==null){
            return redirect('admin');
        }
        $roleAdmin = Attributevalue::whereRaw("Value like '%Quản trị viên%'")->first();
        $roleManager = Attributevalue::whereRaw("Value like '%Nhân viên%'")->first();
        if(session('admin')==null||session('admin')->RoleId!=$roleAdmin->AttributeValueId){
            return redirect('admin');
        }
        $Role = Attributevalue::whereRaw("AttributeId = 6")->get();
        $Admin = User::whereIn("RoleId",[$roleAdmin->AttributeValueId,$roleManager->AttributeValueId])->get();
        return view('admin.EditAdmin',[
            "adminEdit"=>$admin,
            "role"=>$Role,
            "admins"=>$Admin
        ]);
    }
    public function DeleteAdmin(Request $request){
        $roleAdmin = Attributevalue::whereRaw("Value like '%Quản trị viên%'")->first();
        if(session('admin')==null||session('admin')->RoleId!=$roleAdmin->AttributeValueId){
            return redirect('admin');
        }
        $request = $request->all();
        $id = $request["username"];
        try {
            $adm = User::find($id)->delete();
          }
        catch (Exception $e) {
            $adm = User::find($id);
            $adm->Status = 0;
            $adm->UpdateAt = Carbon::now();
            $adm->UpdateBy = session("admin")->UserId;
        }
        return 1;
    }
    public function SubmitUpdateAdmin(Request $request){
        $roleAdmin = Attributevalue::whereRaw("Value like '%Quản trị viên%'")->first();
        if(session('admin')==null||session('admin')->RoleId!=$roleAdmin->AttributeValueId){
            return redirect('admin');
        }
        $request = $request->all();
        $id = $request["AdminId"];
        $username = $request["Username"];
        $password = $request["Password"];
        $active = $request["Active"]!=null?1:0;
        $role = $request["Role"];
        $passwordAdmin = $request["PasswordAdmin"];
        if(!Hash::check($passwordAdmin, session('admin')->Password))
        return redirect()->back()->withErrors(
            [
                'passwordAdmin' => 'Mật khẩu quản trị không đúng'
            ]
        );
        $admin = User::find($id);
        $admin->UserName = $username;
        $admin->Name = $username;
        if($admin->Password != $password){
            $admin->Password = Hash::make($password);
        }
        $admin->Status = $active;
        $admin->RoleId = $role;
        $admin->UpdateAt = Carbon::now();
        $admin->UpdateBy = session('admin')->UserId;
        $admin->save();
        return redirect()->back()->withErrors(
            [
                'success' => 'Tài khoản được tạo thành công.'
            ]
        );      
    }
    public function ConfigSite(){
        $roleAdmin = Attributevalue::whereRaw("Value like '%Quản trị viên%'")->first();
        if(session('admin')==null||session('admin')->RoleId!=$roleAdmin->AttributeValueId){
            return redirect('admin');
        }
        $configSite = Configsite::first();
        return view("admin.configSite",["configSite"=>$configSite]);

    }
    public function UpdateConfigSite(Request $request){
        $roleAdmin = Attributevalue::whereRaw("Value like '%Quản trị viên%'")->first();
        if(session('admin')==null||session('admin')->RoleId!=$roleAdmin->AttributeValueId){
            return redirect('admin');
        }
        $configSite = Configsite::first();
        $request = $request->all();
        $configSite->Name = $request["Name"];
        $configSite->Title = $request["Title"];
        $configSite->Description = $request["Description"];
        $configSite->Place = $request["Place"];
        $configSite->Hotline = $request["Hotline"];
        $configSite->Email = $request["Email"];
        if(array_key_exists("Image",$request)){
            $destination_path = "public/images/logo";
            $image = $request["Image"];
            $image_name = $image->getClientOriginalName();
            $image->storeAs($destination_path,$image_name);
            $pathSql = "storage/images/logo/"."$image_name";
            $configSite->Image = $pathSql;
        }
        $configSite->save();
        
        return redirect()->back()->withErrors(
            [
                'success' => 'Cập nhật thành công.'
            ]
        );    
    }
    public function ListFeedback(){
        if(session('admin')==null){
            return redirect('admin');
        }
        $feedback = FeedBack::orderBy('CreateAt','desc')->get();
        return view('admin.ListFeedBack',[
            "feedback"=>$feedback
        ]);
    }
    public function CreateBanner(){
        if(session('admin')==null){
            return redirect('admin');
        }
        $slider = Slider::get();
        return view('admin.CreateBanner',[
            "slider"=>$slider
        ]);
    }
    public function SubmitCreateBanner(Request $request){
        if(session('admin')==null){
            return redirect('admin');
        }
        $request = $request->all();

        $BannerName = $request["BannerName"];
        $Slogan = $request["Slogan"];
        $BtnText = $request["BtnText"];
        $URL = $request["URL"];
        $Sort = $request["Sort"];
        $Status = 0;
        if(array_key_exists("Status",$request)){
            $Status = 1;
        }   
        $slider = new Slider();
        $slider->BannerName = $BannerName;
        $slider->Slogan = $Slogan;
        $slider->BtnText = $BtnText;
        $slider->Sort = ($Sort==null?999:$Sort);
        $slider->Url = $URL;
        $slider->Status = $Status;
        if(array_key_exists("Image",$request)){
            $image = $request["Image"];
            if($image->getClientMimeType()!="image/jpeg" && $image->getClientMimeType()!="image/png")
                return redirect()->back()->withErrors(
                    [
                        'image' => 'Định dạng phải là jpeg,jpg,png,gif'
                    ]
                );
            $destination_path = "public/images/banner";
            $image_name = $image->getClientOriginalName();
            $image->storeAs($destination_path,$image_name);
            $pathSql = "storage/images/banner/"."$image_name";
            $slider->Image = $pathSql;
        }
        $slider->save();
        return redirect()->back()->withErrors(
            [
                'success' => 'Thêm mới quảng cáo thành công'
            ]
        );  
    }
}