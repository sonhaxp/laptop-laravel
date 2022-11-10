<?php


namespace App\Http\Controllers;

use App\Models\Articlecategory;
use App\Models\Article;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public static function index($id = null,$page = 1){
        $whereClause = "";
        $cat = null;
        if($id == null){
            $whereClause = " 1=1 ";
        }
        else{
            $id = "tin-tuc/".$id;
            $cat = Articlecategory::whereRaw("Url = '{$id}'")->first();
            $whereClause = "ArticleCategoryId = {$cat->ArticleCategoriesId}";
        }
        $categoryArticle = Articlecategory::whereRaw("Status = 1")->get();
        $Article = Article::whereRaw("Status = 1 and {$whereClause}");
        $pageCount = ceil($Article->count()/9);
        $Article = $Article->orderby("createdate","desc")->skip(($page - 1) * 9)->take(9)->get();
        return view("Article.index",[
            "articles"=>$Article,
            "categoryArticle"=>$categoryArticle,
            "page"=>$pageCount,
            "cat"=>$cat
        ]);
    }
    public static function Article($id){
        $id = "tin-tuc/".$id;
        $categoryArticle = Articlecategory::whereRaw("Status = 1")->get();
        $Article = Article::whereRaw("Status = 1 and Url = '{$id}'")->first();
        return view("Article.article",[
            "categoryArticle"=>$categoryArticle,
            "article"=>$Article
        ]);
    }
    public function CategoryArticle(){
        if(session('admin')==null){
            return redirect('admin');
        }
        $category = Articlecategory::where("Status","=","1")->get();
        return view("Article.CreateCategory",[
            "category"=>$category
        ]);
    }
    public function CreateCategoryArticle(Request $request){
        if(session('admin')==null){
            return redirect('admin');
        }
        $request = $request->all();
        $ParentCategory = $request["ParentCategory"]==0?null:$request["ParentCategory"];
        $CategoryName = $request["CategoryName"];
        $active = 0;
        if(array_key_exists("Active",$request)){
            $active = 1;
        }
        $URL = $request["URL"];
        $CategorySort = $request["CategorySort"];

        $category = new Articlecategory;
        $category->ArticleCategoriesParentId = $ParentCategory;
        $category->CategoryName = $CategoryName;
        $category->Status = $active;
        $category->Url = $URL;
        $category->CategorySort = $CategorySort;
        $category->save();
        return redirect()->back()->withErrors(
            [
                'success' => 'Danh mục được tạo thành công.'
            ]
        );        
    }
    public static function EditArticleCategories($id){
        if(session('admin')==null){
            return redirect('admin');
        }
        $cat = Articlecategory::find($id);
        $category = Articlecategory::where("Status","=","1")->get();
        return view("Article.EditCategory",[
            "category"=>$category,
            "cat"=>$cat
        ]);
    }
    public function ConfirmCategoryArticle(Request $request){
        if(session('admin')==null){
            return redirect('admin');
        }
        $request = $request->all();
        $ParentCategory = $request["ParentCategory"]==0?null:$request["ParentCategory"];
        $CategoryName = $request["CategoryName"];
        $active = 0;
        if(array_key_exists("Active",$request)){
            $active = 1;
        }
        $URL = $request["Url"];
        $CategorySort = $request["CategorySort"];
        $CategoryId= $request["CategoryId"];

        $category = Articlecategory::find($CategoryId);
        $category->ArticleCategoriesParentId = $ParentCategory;
        $category->CategoryName = $CategoryName;
        $category->Status = $active;
        $category->URL = $URL;
        $category->CategorySort = $CategorySort;
        $category->save();
        return redirect()->back()->withErrors(
            [
                'success' => 'Danh mục được cập nhật thành công.'
            ]
        );        
    }
    public function DeleteArticleCategories(Request $request){
        if(session('admin')==null){
            return redirect('admin');
        }
        $request = $request->all();
        $id = $request["category"];
        try {
            $adm = Articlecategory::find($id)->delete();
            return 1;
        }
        catch (Exception $e) {
            $adm = Articlecategory::find($id);
            $adm->Status = 0;
            $adm->UpdateAt = Carbon::now();
            $adm->UpdateBy = session("admin")->UserId;
        }
    }

    public function CreateArticle(){
        if(session('admin')==null){
            return redirect('admin');
        }
        $category = Articlecategory::where("Status","=","1")->get();
        return view('article.CreateArticle',[
            "category"=>$category
        ]);
    }
    public function SubmitCreateArticle(Request $request){
        if(session('admin')==null){
            return redirect('admin');
        }
        $request = $request->all();
        $CategoryId = $request["ArticleCategoryId"];
        $Subject = $request["Subject"];
        $Description = $request["Description"];
        $Body = $request["Body"];
        $URL = $request["URL"];
        $Active = 0;
        if(array_key_exists("Active",$request)){
            $Active = 1;
        }   
        $article = new Article;
        $article->ArticleCategoryId = $CategoryId;
        $article->Subject = $Subject;
        $article->Description = $Description;
        $article->Body = $Body;
        $article->URL = $URL;
        $article->Status = $Active;
        $article->CreateDate = Carbon::now();
        $article->UserId = session('admin')->UserId;
        if(array_key_exists("Image",$request)){
            $image = $request["Image"];
            if($image->getClientMimeType()!="image/jpeg" && $image->getClientMimeType()!="image/png")
                return redirect()->back()->withErrors(
                    [
                        'image' => 'Định dạng phải là jpeg,jpg,png,gif'
                    ]
                );
            $destination_path = "public/images/article";
            $image_name = $image->getClientOriginalName();
            $image->storeAs($destination_path,$image_name);
            $pathSql = "storage/images/article/"."$image_name";
            $article->Image = $pathSql;
        }
        $article->save();
        return redirect()->back()->withErrors(
            [
                'success' => 'Thêm mới tin tức thành công'
            ]
        );  
    }
    public function ListArticle(){
        if(session('admin')==null){
            return redirect('admin');
        }
        $category = Articlecategory::where("Status","=","1")->get();
        $article = Article::where("Status","=","1")->orderBy("CreateDate","desc")->get();

        return view('article.ListArticle',[
            "category"=>$category,
            "article"=>$article
        ]);
    }
}
