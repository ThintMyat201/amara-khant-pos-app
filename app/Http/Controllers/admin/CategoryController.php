<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{

    public function categoryCreateView(){
         $categorylist=Category::select('id','name','created_at')
        ->orderBy('created_at','desc')
        ->paginate(7);
        return view('admin.category.categorycreate',compact('categorylist'));
    }

    // put category data
    public function categoryCreateButton(Request $request){
       $this->checkValidation($request);
        $data=$this->getData($request);
        Category::create($data);
        Alert::success('Success Title', 'Success Message');
        return back();
    }

    public function categoryDeleteButton($id){
         Category::where('id',$id)->delete();
         return back();
    }

    private function getData($request){
       return [
         'name'=>$request->categoryName
       ];
    }

    private function checkValidation($request){
        $rules=[
            'categoryName'=>'required'
            ];
        $message=[
            'categoryName.required'=>'ဖြည့်စွက်ရန် လိုအပ်ပါသည်',
        ];

        $request->validate($rules,$message);
    }
}
