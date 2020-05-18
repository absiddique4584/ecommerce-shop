<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\Category;
use Exception;
use App\Models\Product;
use Image;

class ProductController extends Controller
{



    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $products = Product::select('id', 'name', 'model', 'buying_price', 'selling_price', 'special_price', 'special_start', 'special_end', 'quantity', 'thumbnail', 'status')->orderBy('id', 'desc')->get();

        return view('admin.product.manage', compact('products'));
    }










    /**
     * @param $id
     * @param $price
     */
    public function updateBuyingPrice($id ,$price){
        $product = Product::select('id','buying_price')->find($id);
        $product->buying_price = $price;
        $product->save();
    }





    /**
     * @param Request $request
     */
    public function updateSellingPrice(Request $request){
        $product = Product::select('id','selling_price')->find($request->id);
        $product->selling_price = $request->price;
        $product->save();
    }





    /**
     * @param Request $request
     */
    public function updateSpecialPrice(Request $request){
        $product = Product::select('id','special_price')->find($request->id);
        $product->special_price = $request->price;
        $product->save();
    }







    /**
     * @param $id
     */
    public function findCategories($id){
        $categories = SubCategory::select('id', 'name')->where('category_id',$id)->get();

        echo '<option value="">Select SubCategory</option>';
        foreach ($categories as $row){
            echo '<option value="'.$row->id.'">'.$row->name.'</option>';
        }
    }






    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $categories= Category::get();
        $brands= Brand::get();
        return view('admin.product.create',compact('categories','brands'));
    }






    /**
     * @param ProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductRequest $request)
    {

        $product = null;
        try {
            //thumbnail section
            $thumbnail = $request->file('thumbnail');
            $fileEx = $thumbnail->getClientOriginalExtension();
            $thumbnailName = date('Ymdhis.') . $fileEx;
            Image::make($thumbnail)
                ->resize(400,400)
                ->save(public_path('uploads/product/').$thumbnailName);

            //gallery section
            $gallery =[];
            if ($request->hasFile('gallery')){
                $gallery = $this->imageGallery($request);
            }

            $product = Product::create([
                'cat_id' =>$request->cat_id,
                'subcat_id' =>$request->subcat_id,
                'brand_id' =>$request->brand_id,
                'name' =>$request->name,
                'slug' =>slugify($request->name),
                'model' =>$request->model,
                'buying_price' =>$request->buying_price,
                'selling_price' =>$request->selling_price,
                'special_price' =>$request->special_price,
                'special_start' =>$request->special_start,
                'special_end' =>$request->special_end,
                'quantity' =>$request->quantity,
                'video_url' =>$request->video_url,
                'warranty' =>$request->warranty,
                'warranty_duration' =>$request->warranty_duration,
                'warranty_condition' =>$request->warranty_condition,
                'thumbnail' =>$thumbnailName,
                'gallery' =>json_encode($gallery),
                'description' =>$request->description,
                'long_description' =>$request->long_description,
                'status' =>$request->status,

            ]);

        } catch (Exception $exception) {

            $product = false;
        }

        if ($product) {
            setMessage('success', 'Yay! A Product has been successfully created.');
        } else {
            setMessage('danger', 'Oops! Unable to create a new Product.');
        }
        return redirect()->back();
    }






    /**
     * @param $request
     * @return array
     */
    public function imageGallery($request){
        $gallery=[];
        $images = $request->file('gallery');
        $i=0;
        foreach ($images as $image){

            $fileEx1 = $image->getClientOriginalExtension();
            $galleryName = date('Ymdhis').$i.'.' . $fileEx1;
            Image::make($image)
                ->resize(400,400)
                ->save(public_path('uploads/product/').$galleryName);
            array_push($gallery,$galleryName);
            $i++;
        }

        return $gallery;
    }







    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $id = base64_decode($id);
        $products = Product::find($id);
        $categories= Category::select('id','name')->get();
        $brands = Brand::select('id','brand_name')->get();
        $subcategories = SubCategory::select('id','name')->get();
        return view('admin.product.edit', compact('products','categories','brands','subcategories'));
    }







    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductRequest $request, $id)
    {
        $products = Product::find($id);

        $product = null;
        try {
            //thumbnail section
            $thumbnail = $request->file('thumbnail');
            $fileEx = $thumbnail->getClientOriginalExtension();
            $thumbnailName = date('Ymdhis.') . $fileEx;
            Image::make($thumbnail)
                ->resize(400,400)
                ->save(public_path('uploads/product/').$thumbnailName);

            //gallery section
            $gallery =[];
            if ($request->hasFile('gallery')){
                $gallery = $this->imageGallery1($request);
            }

            $product = $products->update([
                'cat_id' =>$request->cat_id,
                'subcat_id' =>$request->subcat_id,
                'brand_id' =>$request->brand_id,
                'name' =>$request->name,
                'slug' =>slugify($request->name),
                'model' =>$request->model,
                'buying_price' =>$request->buying_price,
                'selling_price' =>$request->selling_price,
                'special_price' =>$request->special_price,
                'special_start' =>$request->special_start,
                'special_end' =>$request->special_end,
                'quantity' =>$request->quantity,
                'video_url' =>$request->video_url,
                'warranty' =>$request->warranty,
                'warranty_duration' =>$request->warranty_duration,
                'warranty_condition' =>$request->warranty_condition,
                'thumbnail' =>$thumbnailName,
                'gallery' =>json_encode($gallery),
                'description' =>$request->description,
                'long_description' =>$request->long_description,
                'status' =>$request->status,

            ]);

        } catch (Exception $exception) {

            $product = false;
        }

        if ($product) {
            setMessage('success', 'Yay! A Product has been successfully created.');
        } else {
            setMessage('danger', 'Oops! Unable to create a new Product.');
        }
        return redirect()->back();
    }






    /**
     * @param $request
     * @return array
     */
    public function imageGallery1($request){
        $gallery=[];
        $images = $request->file('gallery');
        $i=0;
        foreach ($images as $image){

            $fileEx1 = $image->getClientOriginalExtension();
            $galleryName = date('Ymdhis').$i.'.' . $fileEx1;
            Image::make($image)
                ->resize(400,400)
                ->save(public_path('uploads/product/').$galleryName);
            array_push($gallery,$galleryName);
            $i++;
        }

        return $gallery;
    }







    /**
     * @param $id
     * @param $status
     */
    public function updateStatus($id, $status)
    {
        $products = Product::find($id);
        $products->status = $status;
        $products->save();
    }






    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        try {
            $id = base64_decode($id);
            $products = Product::find($id);
            unlink(public_path('uploads/product/') . $products->thumbnail);

            $images = json_decode($products->gallery);
            if (!empty($image)){
                foreach ($images as $image){
                    unlink(public_path('uploads/product/') . $image);
                }
            }


            $products->delete();
            setMessage('success', 'Product has been successfully deleted!');
        }catch (Exception $exception){
            setMessage('warning', "Oops! Something Wrong,Can't Delete!");
        }

        return redirect()->back();
    }
}
