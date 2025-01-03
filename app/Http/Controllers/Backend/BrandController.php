<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Image;
use Illuminate\Support\Facades\Log;
use Exception;

class BrandController extends Controller
{
    public function BrandView(){

    	$brands = Brand::latest()->get();
    	return view('backend.brand.brand_view',compact('brands'));

    }


    public function BrandStore(Request $request){

    	$request->validate([
    		'brand_name_en' => 'required',
    		'brand_name_hin' => 'required',
    		'brand_image' => 'required',
    	],[
    		'brand_name_en.required' => 'Input Brand English Name',
    		'brand_name_hin.required' => 'Input Brand Hindi Name',
    	]);

    	$image = $request->file('brand_image');
    	$name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
    	Image::make($image)->resize(300,300)->save('upload/brand/'.$name_gen);
    	$save_url = 'upload/brand/'.$name_gen;

	Brand::insert([
		'brand_name_en' => $request->brand_name_en,
		'brand_name_hin' => $request->brand_name_hin,
		'brand_slug_en' => strtolower(str_replace(' ', '-',$request->brand_name_en)),
		'brand_slug_hin' => str_replace(' ', '-',$request->brand_name_hin),
		'brand_image' => $save_url,

    	]);

	    $notification = array(
			'message' => 'Brand Inserted Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);

    } // end method 



    public function BrandEdit($id){
    	$brand = Brand::findOrFail($id);
    	return view('backend.brand.brand_edit',compact('brand'));

    }

	public function BrandUpdate(Request $request)
{
    $brand_id = $request->id;
    $old_img = $request->old_image;

    // Check if the old image exists before deleting it
    if ($old_img && file_exists(public_path($old_img))) {
        try {
            // Attempt to delete the old image
            unlink(public_path($old_img)); // Delete the old image
            Log::info("Old image deleted for brand ID: {$brand_id}");
        } catch (Exception $e) {
            // Log an error if unlinking fails
            Log::error("Error deleting old image for brand ID: {$brand_id}. Error: " . $e->getMessage());
        }
    } else {
        // Log a warning if the old image is not found
        Log::warning("Old image not found or not provided for brand ID: {$brand_id}");
    }

    // Check if a new image is uploaded
    if ($request->file('brand_image')) {
        // Handle the new image upload
        $image = $request->file('brand_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(300, 300)->save(public_path('upload/brand/'.$name_gen));
        $save_url = 'upload/brand/'.$name_gen;

        // Update the brand data with the new image
        Brand::findOrFail($brand_id)->update([
            'brand_name_en' => $request->brand_name_en,
            'brand_name_hin' => $request->brand_name_hin,
            'brand_slug_en' => strtolower(str_replace(' ', '-', $request->brand_name_en)),
            'brand_slug_hin' => str_replace(' ', '-',$request->brand_name_hin),
            'brand_image' => $save_url,
        ]);

        // Log success message
        Log::info("Brand ID: {$brand_id} updated with new image.");
        
        $notification = array(
            'message' => 'Brand Updated Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('all.brand')->with($notification);
    } else {
        // Handle the case where no new image is uploaded
        Brand::findOrFail($brand_id)->update([
            'brand_name_en' => $request->brand_name_en,
            'brand_name_hin' => $request->brand_name_hin,
            'brand_slug_en' => strtolower(str_replace(' ', '-', $request->brand_name_en)),
            'brand_slug_hin' => str_replace(' ', '-',$request->brand_name_hin),
        ]);

        // Log success message for update without image
        Log::info("Brand ID: {$brand_id} updated without new image.");
        
        $notification = array(
            'message' => 'Brand Updated Successfully (No Image)',
            'alert-type' => 'info'
        );

        return redirect()->route('all.brand')->with($notification);
    }
}

	



    public function BrandDelete($id){

    	$brand = Brand::findOrFail($id);
    	$img = $brand->brand_image;
    	unlink($img);

    	Brand::findOrFail($id)->delete();

    	 $notification = array(
			'message' => 'Brand Deleted Successfully',
			'alert-type' => 'info'
		);

		return redirect()->back()->with($notification);

    } // end method 



}
 