<?php

namespace App\Http\Controllers\admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
     public function productCreateView(){
        $categories=Category::select('id','name')->get();
        return view('admin.product.productcreate',compact('categories'));
    }

    public function productListView($action='default'){

        $product=Product::select('products.id','products.name','products.price','products.image','products.stock','products.category_id','categories.name as category_name')
                ->leftJoin('categories','products.category_id','categories.id')
                ->when( $action=='lowAmt',function($query){
                    $query->where('products.stock','<=',3);
                })
                ->orderBy('products.created_at','desc')
                ->get();

        return view('admin.product.productlist',compact('product'));
    }

    public function productEditView($id){
        $oldData=Product::where('id',$id)->first();
        $categories=Category::get();
        return view('admin.product.productedit',compact('oldData','categories'));
    }

    public function productCreateData(Request $request){
        $this->checkValidation($request, 'create');
        $data = $this->getData($request);

        if ($request->hasFile('image')) {
            $destinationPath = $this->resolveWritableImageDirectory();
            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move($destinationPath, $fileName);
            $data['image'] = $fileName;
        }

        Product::create($data);
        Alert::success('Success Title', 'Product created successfully!');
        return back();
    }

    // product delete function

    public function productDelete($id){
        $oldImageName = Product::where('id', $id)->value('image');
        $this->deleteImageFile($oldImageName);
        Product::where('id', $id)->delete();
        return back();
    }

    public function productEdit(Request $request){
        $this->checkValidation($request, 'edit');
        $data = $this->getData($request);

        // Get old image name from DB
        $oldImageName = Product::where('id', $request->id)->value('image');

        if ($request->hasFile('image')) {
            $destinationPath = $this->resolveWritableImageDirectory();
            $this->deleteImageFile($oldImageName);
            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move($destinationPath, $fileName);
            $data['image'] = $fileName;
        } else {
            $data['image'] = $oldImageName;
        }

        Product::where('id', $request->id)->update($data);
        Alert::success('Success Title', 'Product updated successfully!');
        return to_route('productListView');
    }

    private function resolveWritableImageDirectory(): string
    {
        $candidates = [
            public_path('images'),
            storage_path('app/public/images'),
            sys_get_temp_dir() . '/amara_images',
        ];

        foreach ($candidates as $path) {
            if (!File::exists($path)) {
                @File::makeDirectory($path, 0777, true, true);
            }
            @chmod($path, 0777);
            if (is_dir($path) && is_writable($path)) {
                return $path;
            }
        }

        return sys_get_temp_dir();
    }

    private function deleteImageFile(?string $fileName): void
    {
        if (!$fileName) {
            return;
        }

        $paths = [
            public_path('images/' . $fileName),
            storage_path('app/public/images/' . $fileName),
            sys_get_temp_dir() . '/amara_images/' . $fileName,
            sys_get_temp_dir() . '/' . $fileName,
        ];

        foreach ($paths as $filePath) {
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        }
    }

    public function getData($request){
       return [
         'name' => $request->name,
         'category_id' => $request->category_id,
         'price' => $request->price,
         'description'=>$request->description,
         'stock' => $request->stock
       ];
    }

    private function checkValidation($request,$action){
        $rules = [
            'name' => 'required|min:1|max:199|unique:products,name,'.$request->id,
            'category_id' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric'
        ];
        $rules['image'] = $action == 'create'? 'required|file|mimes:jpg,jpeg,png,webp,svg' : 'file|mimes:jpg,jpeg,png,webp,svg';

        $message = [
            'name.required' => 'ဖြည့်စွက်ရန် လိုအပ်ပါသည်',
            'description.required' => 'ဖြည့်စွက်ရန် လိုအပ်ပါသည်',
            'image.required' => 'ဖြည့်စွက်ရန် လိုအပ်ပါသည်',
            'price.required' => 'ဖြည့်စွက်ရန် လိုအပ်ပါသည်',
            'stock.required' => 'ဖြည့်စွက်ရန် လိုအပ်ပါသည်',
            'category_id.required'=>'ဖြည့်စွက်ရန် လိုအပ်ပါသည်'

        ];

        $request->validate($rules, $message);
    }
}
