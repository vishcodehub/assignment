<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ProductController extends Controller
{
    
    public function index(Request $request)
    {
        if($request->parent_id){
        return Product::select('id','name','parent_id')->get();

        }
        else{
            return Product::select('id','name','parent_id')->get();
        }
    }
   
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'parent_id'=>'required',
        ]);

        try{
            Product::create($request->post());

            return response()->json([
                'message'=>'Created Successfully!!'
            ]);
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            return response()->json([
                'message'=>'Something goes wrong while creating!!'
            ],500);
        }
    }

    public function show(Product $product)
    {
        return response()->json(['product'=>$product]);
    }
   
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'=>'required',
            'parent_id'=>'required',
        ]);
        try{
            $product->fill($request->post())->update();
            return response()->json([
                'message'=>'Details Updated Successfully!!'
            ]);
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            return response()->json([
                'message'=>'Something goes wrong while updating Details!!'
            ],500);
        }
    }
   
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return response()->json([
                'message'=>'Deleted Successfully!!'
            ]);            
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'message'=>'Something goes wrong while deleting!!'
            ]);
        }
    }

    public function manageCategory(Request $request)
    {
        $product = Product::where('parent_id', '=', 0)->get();
        // $allProduct = Product::pluck('name','id')->all();
        return response()->json(['product'=>$product,'allProduct'=>$allProduct]);

        // return view('categoryTreeview',compact('categories','allCategories'));
    }
}