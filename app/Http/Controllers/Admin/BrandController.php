<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Profile;
use Illuminate\Http\Request;
use Exception;

class BrandController extends Controller
{



    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
   public function index(){
      $brands =  Brand::latest()->get();
      $profiles = Profile::select('name','image')->get();

       return view('admin.brand.manage',compact('brands','profiles'));
   }




    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        $profiles = Profile::select('name','image')->get();
        return view('admin.brand.create',compact('profiles'));
    }




    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request){
        $request->validate([
          'brand_name'=>'required'
       ]);
        $brand =null;
        try {
            $brandName = $request ->brand_name;
            Brand::create([
                'brand_name' =>$brandName,
                'brand_slug' => slugify($brandName),
                'top_brand' =>$request->top_brand,
                'status' => '1'
            ]);
            $brand = true;
        }catch (Exception $exception){
            $brand = false;
        }
        if ($brand == true){
            setMessage('success','Brand Save Success !');
        }else{
            setMessage('danger','Something Wrong !');
        }
        return redirect()->back();
    }




    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){
       $id = base64_decode($id);
       $brand = Brand::find($id);
        $profiles = Profile::select('name','image')->get();
        return view('admin.brand.edit',compact('brand','profiles'));
    }




    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id){
        $brand = Brand::find($id);

        $request->validate([
            'brand_name'=>'required'
        ]);

        $success =null;
        try {
            $brandName = $request ->brand_name;
            $brand->update([
                'brand_name' =>$brandName,
                'brand_slug' => slugify($brandName),
                'top_brand' =>$request->top_brand

            ]);
            $success = true;
        }catch (Exception $exception){
            $success = false;
        }
        if ($success == true){
            setMessage('success','Brand updated Successfully !');
        }else{
            setMessage('danger','Something Wrong !');
        }
        return redirect()->back();
    }



    /**
     * @param $id
     * @param $status
     */
    public function updateStatus($id,$status){
        $brand = Brand::find($id);
        $brand->status = $status;
        $brand->save();
    }




    /**
     * @param $id
     * @param $status
     */
    public function updatetopBrand($id,$top_brand){
        $brand = Brand::find($id);
        $brand->top_brand = $top_brand;
        $brand->save();
    }




    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id){
       $id = base64_decode($id);
       $brand = Brand::find($id);
       $brand->delete();
        setMessage('success','Brand has been Successfully Deleted !');
        return redirect()->back();
    }
}
