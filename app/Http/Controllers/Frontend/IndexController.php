<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Slider;
use App\Models\Product;
use App\Models\MultiImg;
use Illuminate\Support\Facades\Hash;

class IndexController extends Controller
{
	public function index(){
		// Fetch featured, hot deals, special offers, and special deals
		$products = Product::where('status', 1)->orderBy('id', 'DESC')->limit(6)->get();
		$sliders = Slider::where('status', 1)->orderBy('id', 'DESC')->limit(3)->get();
		$categories = Category::orderBy('category_name_en', 'ASC')->get();
	
		$featured = Product::where('featured', 1)->orderBy('id', 'DESC')->limit(6)->get();
		$hot_deals = Product::where('hot_deals', 1)->where('discount_price', '!=', NULL)->orderBy('id', 'DESC')->limit(3)->get();
		$special_offer = Product::where('special_offer', 1)->orderBy('id', 'DESC')->limit(6)->get();
		$special_deals = Product::where('special_deals', 1)->orderBy('id', 'DESC')->limit(3)->get();
	
		// Fetch category 0, with null checks
		$skip_category_0 = Category::skip(0)->first();
		$skip_product_0 = $skip_category_0 ? Product::where('status', 1)->where('category_id', $skip_category_0->id)->orderBy('id', 'DESC')->get() : collect();
	
		// Fetch category 1, with null checks
		$skip_category_1 = Category::skip(1)->first();
		$skip_product_1 = $skip_category_1 ? Product::where('status', 1)->where('category_id', $skip_category_1->id)->orderBy('id', 'DESC')->get() : collect();
	
		// Fetch brand 1, with null checks
		$skip_brand_1 = Brand::skip(1)->first();
		$skip_brand_product_1 = $skip_brand_1 ? Product::where('status', 1)->where('brand_id', $skip_brand_1->id)->orderBy('id', 'DESC')->get() : collect();
	
		// Pass data to view
		return view('frontend.index', compact('categories', 'sliders', 'products', 'featured', 'hot_deals', 'special_offer', 'special_deals', 'skip_category_0', 'skip_product_0', 'skip_category_1', 'skip_product_1', 'skip_brand_1', 'skip_brand_product_1'));
	}
	

    public function UserLogout(){
    	Auth::logout();
    	return Redirect()->route('login');
    }


    public function UserProfile(){
    	$id = Auth::user()->id;
    	$user = User::find($id);
    	return view('frontend.profile.user_profile',compact('user'));
    }



    public function UserProfileStore(Request $request){
        $data = User::find(Auth::user()->id);
		$data->name = $request->name;
		$data->email = $request->email;
		$data->phone = $request->phone;


		if ($request->file('profile_photo_path')) {
			$file = $request->file('profile_photo_path');
			@unlink(public_path('upload/user_images/'.$data->profile_photo_path));
			$filename = date('YmdHi').$file->getClientOriginalName();
			$file->move(public_path('upload/user_images'),$filename);
			$data['profile_photo_path'] = $filename;
		}
		$data->save();

		$notification = array(
			'message' => 'User Profile Updated Successfully',
			'alert-type' => 'success'
		);

		return redirect()->route('dashboard')->with($notification);

    } // end method 


    public function UserChangePassword(){
    	$id = Auth::user()->id;
    	$user = User::find($id);
    	return view('frontend.profile.change_password',compact('user'));
    }


    public function UserPasswordUpdate(Request $request){

		$validateData = $request->validate([
			'oldpassword' => 'required',
			'password' => 'required|confirmed',
		]);

		$hashedPassword = Auth::user()->password;
		if (Hash::check($request->oldpassword,$hashedPassword)) {
			$user = User::find(Auth::id());
			$user->password = Hash::make($request->password);
			$user->save();
			Auth::logout();
			return redirect()->route('user.logout');
		}else{
			return redirect()->back();
		}


	}// end method



	public function ProductDetails($id,$slug){
		$product = Product::findOrFail($id);

		$color_en = $product->product_color_en;
		$product_color_en = explode(',', $color_en);

		$color_hin = $product->product_color_hin;
		$product_color_hin = explode(',', $color_hin);

		$size_en = $product->product_size_en;
		$product_size_en = explode(',', $size_en);

		$size_hin = $product->product_size_hin;
		$product_size_hin = explode(',', $size_hin);

		$multiImag = MultiImg::where('product_id',$id)->get();

		$cat_id = $product->category_id;
		$relatedProduct = Product::where('category_id',$cat_id)->where('id','!=',$id)->orderBy('id','DESC')->get();
	 	return view('frontend.product.product_details',compact('product','multiImag','product_color_en','product_color_hin','product_size_en','product_size_hin','relatedProduct'));

	}



	public function TagWiseProduct($tag)//////////////////////not same method as course
{
    // Split the tag into words (separated by commas)
    $tagWords = explode(',', $tag);

    // Prepare the query to check if any of the words in the tag exist in either English or Hindi tags
    $products = Product::where('status', 1)
        ->where(function ($query) use ($tagWords) {
            foreach ($tagWords as $word) {
                $query->orWhere('product_tags_en', 'like', "%{$word}%")
                      ->orWhere('product_tags_hin', 'like', "%{$word}%");
            }
        })
        ->orderBy('id', 'DESC')
        ->paginate(3);

    // Get categories to display in the sidebar
    $categories = Category::orderBy('category_name_en', 'ASC')->get();

    return view('frontend.tags.tags_view', compact('products', 'categories'));
}




  // Subcategory wise data
	public function SubCatWiseProduct($subcat_id,$slug){
		$products = Product::where('status',1)->where('subcategory_id',$subcat_id)->orderBy('id','DESC')->paginate(6);
		$categories = Category::orderBy('category_name_en','ASC')->get();
		return view('frontend.product.subcategory_view',compact('products','categories'));

	}

  // Sub-Subcategory wise data
	public function SubSubCatWiseProduct($subsubcat_id,$slug){
		$products = Product::where('status',1)->where('subsubcategory_id',$subsubcat_id)->orderBy('id','DESC')->paginate(6);
		$categories = Category::orderBy('category_name_en','ASC')->get();
		return view('frontend.product.sub_subcategory_view',compact('products','categories'));

	}



    /// Product View With Ajax
	public function ProductViewAjax($id){
		$product = Product::with('category','brand')->findOrFail($id);

		$color = $product->product_color_en;
		$product_color = explode(',', $color);

		$size = $product->product_size_en;
		$product_size = explode(',', $size);

		return response()->json(array(
			'product' => $product,
			'color' => $product_color,
			'size' => $product_size,

		));

	} // end method 






}
 