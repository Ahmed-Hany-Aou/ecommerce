<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function CategoryView()
    {
        // Fetch categories and pass them to the view
        $categories = Category::latest()->get();
    
        // Use the compact function to pass the variable
        return view('backend.category.category_view', compact('categories'));
    }
    


    public function CategoryStore(Request $request){

       $request->validate([
    		'category_name_en' => 'required',
    		'category_name_hin' => 'required',
    		'category_icon' => 'required',
    	],[
    		'category_name_en.required' => 'Input Category English Name',
    		'category_name_hin.required' => 'Input Category Hindi Name',
    	]);

    	 

	Category::insert([
		'category_name_en' => $request->category_name_en,
		'category_name_hin' => $request->category_name_hin,
		'category_slug_en' => strtolower(str_replace(' ', '-',$request->category_name_en)),
		'category_slug_hin' => str_replace(' ', '-',$request->category_name_hin),
		'category_icon' => $request->category_icon,

    	]);

	    $notification = array(
			'message' => 'Category Inserted Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);

    } // end method 


    public function CategoryEdit($id){
    	$category = Category::findOrFail($id);
    	return view('backend.category.category_edit',compact('category'));

    }



    public function CategoryUpdate(Request $request)
    {
        // Validate input
        $request->validate([
            'id' => 'required|exists:categories,id',
            'category_name_en' => 'required|string|max:255',
            'category_name_hin' => 'required|string|max:255',
            'category_icon' => 'required|string|max:255',
        ]);
    
        // Find category and update it
        $category = Category::findOrFail($request->id);
        $category->update([
            'category_name_en' => $request->category_name_en,
            'category_name_hin' => $request->category_name_hin,
            'category_slug_en' => strtolower(str_replace(' ', '-', $request->category_name_en)),
            'category_slug_hin' => str_replace(' ', '-', $request->category_name_hin),
            'category_icon' => $request->category_icon,
        ]);
    
        return response()->json([
            'message' => 'Category Updated Successfully',
            'alert-type' => 'success',
        ]);
    }
    
    
    


/*
public function CategoryDelete($id){

    	Category::findOrFail($id)->delete();

    	$notification = array(
			'message' => 'Category Deleted Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);

    } // end method 
*/
public function CategoryDelete($id)
{
    $category = Category::findOrFail($id);

    // Check if the category has subcategories
    if ($category->subcategories()->exists()) {
        return response()->json([
            'message' => 'This category cannot be deleted because it has subcategories.',
            'alert-type' => 'error'
        ], 400); // HTTP 400 Bad Request
    }

    $category->delete();

    return response()->json([
        'message' => 'Category Deleted Successfully',
        'alert-type' => 'success'
    ], 200);
}

}
 