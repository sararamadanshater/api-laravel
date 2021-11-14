<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;

class CategoryController extends Controller
{
    use GeneralTrait;

    public function index(){
        $categories=Category::select('id','name_'. app()->getlocale())->get();
        // return response()->json( $categories);
        return $this->returnData("categories",$categories,"success categories");
    }
    public function getCategoryById(Request $request){
        $category=Category::select('id','name_'. app()->getlocale())->find($request->id);
      
        if(!$category){
            return $this->returnError('000','this category not found');
        }
           
        return $this->returnData('category',$category,"get succes category");
        // return response()->json( $categories);
    }

    public function changeDisplay(Request $request){
        Category::where("id",$request->id)->update(["display"=>$request->display]);
        return $this->returnSuccesMassge("001","change display successfuly");
    }


}
