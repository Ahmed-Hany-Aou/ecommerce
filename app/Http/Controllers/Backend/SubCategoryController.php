<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;
use App\Models\SubSubCategory;
use Illuminate\Support\Str;


class subCategoryController extends Controller
{
    public function SubCategoryView(){

    	$categories = Category::orderBy('category_name_en','ASC')->get();
    	$subcategory = SubCategory::latest()->get();
    	return view('backend.category.subcategory_view',compact('subcategory','categories'));

    }


	public function SubCategoryStore(Request $request){

		$request->validate([
			 'category_id' => 'required',
			 'subcategory_name_en' => 'required',
			 'subcategory_name_hin' => 'required',
		 ],[
			 'category_id.required' => 'Please select Any option',
			 'subcategory_name_en.required' => 'Input SubCategory English Name',
		 ]);
 
		  
 
		SubCategory::insert([
		 'category_id' => $request->category_id,
		 'subcategory_name_en' => $request->subcategory_name_en,
		 'subcategory_name_hin' => $request->subcategory_name_hin,
		 'subcategory_slug_en' => strtolower(str_replace(' ', '-',$request->subcategory_name_en)),
		 'subcategory_slug_hin' => str_replace(' ', '-',$request->subcategory_name_hin),
		  
 
		 ]);
 
		 $notification = array(
			 'message' => 'SubCategory Inserted Successfully',
			 'alert-type' => 'success'
		 );
 
		 return redirect()->back()->with($notification);
 
	 } // end method 
 






     public function SubCategoryEdit($id){
    	$categories = Category::orderBy('category_name_en','ASC')->get();
    	$subcategory = SubCategory::findOrFail($id);
    	return view('backend.category.subcategory_edit',compact('subcategory','categories'));

    }


	public function SubCategoryUpdate(Request $request)
	{
		$request->validate([
			'id' => 'required|exists:sub_categories,id',
			'subcategory_name_en' => 'required|string|max:255',
			'subcategory_name_hin' => 'required|string|max:255',
			'category_id' => 'required|exists:categories,id',
		]);
	
		$subcategory = SubCategory::findOrFail($request->id);
		$subcategory->update([
			'subcategory_name_en' => $request->subcategory_name_en,
			'subcategory_name_hin' => $request->subcategory_name_hin,
			'subcategory_slug_en' => Str::slug($request->subcategory_name_en),
			'subcategory_slug_hin' => Str::slug($request->subcategory_name_hin),
			'category_id' => $request->category_id,
		]);
	
		// Check if the request is AJAX
		if ($request->ajax()) {
			return response()->json([
				'message' => 'SubCategory Updated Successfully',
				'alert-type' => 'success',
			]);
		}
	
		// Redirect to the SubCategory List for non-AJAX requests
		return redirect()->route('all.subcategory')->with([
			'message' => 'SubCategory Updated Successfully',
			'alert-type' => 'success',
		]);
	}
	
	



    /*
    public function SubCategoryDelete($id){

    	SubCategory::findOrFail($id)->delete();

    	$notification = array(
			'message' => 'SubCategory Deleted Successfully',
			'alert-type' => 'info'
		);

		return redirect()->back()->with($notification);

    }
        */
		
		public function SubCategoryDelete($id)
{
    $subcategory = SubCategory::findOrFail($id);

    // Check if the subcategory has sub-subcategories
    if ($subcategory->subSubCategories()->exists()) {
        return response()->json([
            'message' => 'This subcategory cannot be deleted because it has sub-subcategories.',
            'alert-type' => 'error',
        ], 400); // HTTP 400 Bad Request
    }

    $subcategory->delete();

    return response()->json([
        'message' => 'SubCategory Deleted Successfully',
        'alert-type' => 'success',
    ], 200);
}





  /////////////// That for SUB->SUBCATEGORY ////////////////

  public function SubSubCategoryView() {
    $categories = Category::orderBy('category_name_en', 'ASC')->get();
    $subsubcategory = SubSubCategory::with(['category', 'subcategory'])->latest()->get();
    return view('backend.category.sub_subcategory_view', compact('subsubcategory', 'categories'));
}



 
    /*
     public function GetSubCategory($category_id){

     	$subcat = SubCategory::where('category_id',$category_id)->orderBy('subcategory_name_en','ASC')->get();
     	return json_encode($subcat);
     }
*/


public function GetSubCategory($category_id)
{
    $subcategories = SubCategory::where('category_id', $category_id)
                                ->orderBy('subcategory_name_en', 'ASC')
                                ->get();

    return response()->json($subcategories);
}


/*
	public function GetSubCategory($subcategory_id)
{
    $subsubcategories = SubSubCategory::where('subcategory_id', $subcategory_id)->orderBy('subsubcategory_name_en')->get();

    // Return the result as JSON
    return response()->json($subsubcategories);
}
*/

public function GetSubSubCategory($subcategory_id)
{
    $subsubcategories = SubSubCategory::where('subcategory_id', $subcategory_id)
                                      ->orderBy('subsubcategory_name_en', 'ASC')
                                      ->get();

    return response()->json($subsubcategories);
}




public function SubSubCategoryStore(Request $request)
{
    $request->validate([
        'category_id' => 'required',
        'subcategory_id' => 'required',
        'subsubcategory_name_en' => 'required',
        'subsubcategory_name_hin' => 'required',
    ]);

    // Insert the new sub-subcategory
    SubSubCategory::create([
        'category_id' => $request->category_id,
        'subcategory_id' => $request->subcategory_id,
        'subsubcategory_name_en' => $request->subsubcategory_name_en,
        'subsubcategory_name_hin' => $request->subsubcategory_name_hin,
        'subsubcategory_slug_en' => Str::slug($request->subsubcategory_name_en),
        'subsubcategory_slug_hin' => Str::slug($request->subsubcategory_name_hin),
    ]);

    // Return success response
    return response()->json([
        'message' => 'Sub-SubCategory Added Successfully!',
        'alert-type' => 'success'
    ]);
}




    public function SubSubCategoryEdit($id){
    	$categories = Category::orderBy('category_name_en','ASC')->get();
    	$subcategories = SubCategory::orderBy('subcategory_name_en','ASC')->get();
    	$subsubcategories = SubSubCategory::findOrFail($id);
    	return view('backend.category.sub_subcategory_edit',compact('categories','subcategories','subsubcategories'));

    }


	public function SubSubCategoryUpdate(Request $request) {
		$subsubcat_id = $request->id;
	
		// Debugging step: Log the input data and check the request
		//dd($request->all());
	
		SubSubCategory::findOrFail($subsubcat_id)->update([
			'category_id' => $request->category_id,
			'subcategory_id' => $request->subcategory_id,
			'subsubcategory_name_en' => $request->subsubcategory_name_en,
			'subsubcategory_name_hin' => $request->subsubcategory_name_hin,
			'subsubcategory_slug_en' => strtolower(str_replace(' ', '-', $request->subsubcategory_name_en)),
			'subsubcategory_slug_hin' => str_replace(' ', '-', $request->subsubcategory_name_hin),
		]);
	
		$notification = array(
			'message' => 'Sub-SubCategory Updated Successfully',
			'alert-type' => 'info'
		);
	
		return redirect()->route('all.subsubcategory')->with($notification);
	}
	
    /*
    public function SubSubCategoryDelete($id){

    	SubSubCategory::findOrFail($id)->delete();
    	 $notification = array(
			'message' => 'Sub-SubCategory Deleted Successfully',
			'alert-type' => 'info'
		);

		return redirect()->back()->with($notification);

    }
*/
public function SubSubCategoryDelete($id)
{
    $subsubcategory = SubSubCategory::findOrFail($id);

    // Delete the Sub-SubCategory
    $subsubcategory->delete();

    // Return a JSON response for SweetAlert
    return response()->json([
        'message' => 'Sub-SubCategory Deleted Successfully',
        'alert-type' => 'success',
    ], 200);
}


}