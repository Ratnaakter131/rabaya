<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Inventory;
use App\Models\OrderProduct;
use App\Models\product;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Cookie;
use Arr;
use Illuminate\Support\Facades\Cookie as FacadesCookie;
use Stripe\Product as StripeProduct;
use Symfony\Component\HttpFoundation\Cookie as HttpFoundationCookie;

class FrontendController extends Controller {
    function welcome() {
        $all_products = product::simplePaginate(6);
        $new_arrivals = product::latest()->take(4)->get();
        $top_categories = Category::take(6)->get();

        $recent_product_id = Cookie::get('recent_view_product');
        if($recent_product_id == ''){
            $after_unique = array_unique(json_decode("[]", true));
        }
        else{
            $after_unique = array_unique(json_decode($recent_product_id, true));
        }
        $all_recent_viewed_products = Product::find($after_unique);


        return view('frontend.index', [
            'all_products' => $all_products,
            'new_arrivals' => $new_arrivals,
            'top_categories' => $top_categories,
            'all_recent_viewed_products' => $all_recent_viewed_products,
        ]);
    }
    function product_details($slug) {
        $product_details = product::where('slug', $slug)->get();
        $product_id = $product_details->first()->id;
        $category_id = $product_details->first()->category_id;

        $related_products = Product::where('category_id', $category_id)->where('id', '!=', $product_id)->get();
        $product_review = OrderProduct::where('product_id', $product_id)->whereNotNull('review')->get();
        $total_review = OrderProduct::where('product_id', $product_id)->whereNotNull('review')->count();
        $total_star = OrderProduct::where('product_id', $product_id)->whereNotNull('star')->sum('star');

        $available_colors = Inventory::where('product_id', $product_id)
            ->selectRaw('color_id, count(*) as total')
            ->groupBy('color_id')
            ->get();

            $all = Cookie::get('recent_view_product');
            if(!$all){
               $all = "[]";
            }
            $all_info = json_decode($all, true);
            $cookie_info = Arr::prepend($all_info, $product_id);
            $item_data = json_encode($cookie_info);
            Cookie::queue('recent_view_product', $item_data, 100000);


        return view('frontend.product_details', [
            'product_details' => $product_details,
            'available_colors' => $available_colors,
            'related_products' => $related_products,
            'product_review' => $product_review,
            'total_review' => $total_review,
            'total_star' => $total_star,
        ]);
    }
    function getSize(Request $request) {
        $str = '<option>Choose A Option</option>';
        $sizes = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->get();
        foreach ($sizes as $size) {
            $str .= '<option value="' . $size->size_id . '">' . $size->rel_to_size->size_name . '</option>';
        }
        echo $str;
    }
    function review(Request $request) {

        OrderProduct::where('user_id', $request->user_id)->where('product_id', $request->product_id)->update([
            'review' => $request->review,
            'star' => $request->star,
            'updated_at' => Carbon::now(),
        ]);
        return back();
    }
    function shop(Request $request){
        $data = $request->all();
        $all_products = Product::where(function ($q) use ($data){
            if(!empty($data['q']) && $data['q'] != '' && $data['q'] != 'undefined'){
                $q->where(function ($q) use ($data){
                    $q->where('product_name', 'like', '%'.$data['q'].'%');
                    $q->orwhere('short_desp', 'like', '%'.$data['q'].'%');
                    $q->orwhere('long_desp', 'like', '%'.$data['q'].'%');
                });
            }
            if(!empty($data['category_id']) && $data['category_id'] != '' && $data['category_id'] != 'undefined'){
                    $q->where('category_id', $data['category_id']);
            }
            if(!empty($data['min']) && $data['min'] != '' && $data['min'] != 'undefined' || !empty($data['min']) && $data['min'] != '' && $data['min'] != 'undefined'){
                    $q->whereBetween('after_discount', [($data['min'] == ''?0: $data['min']), ($data['max'] == '' ? 999999999999 : $data['max'])]);
            }
            // if(!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined' || !empty($data['size_id']) && $data['size_id'] != '' && $data['size_id'] != 'undefined'){
            //     $q->whereHas('inventories', function ($q) use ($data){
            //         if(!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined'){
            //             $q->whereHas('rel_to_color', function ($q) use ($data){
            //                 $q->where('colors.id', $data['color_id']);
            //             });
            //         }
            //         if(!empty($data['size_id']) && $data['size_id'] != '' && $data['size_id'] != 'undefined'){
            //             $q->whereHas('rel_to_size', function ($q) use ($data){
            //                 $q->where('sizes.id', $data['size_id']);
            //             });
            //         }
            //     });
            // }
            if (!empty($data['color_id']) && $data['color_id'] != '' &&  $data['color_id'] != 'undefined' || !empty($data['size_id']) && $data['size_id'] != '' &&  $data['size_id'] != 'undefined') {
                $q->whereHas('inventories', function ($q) use ($data) {
                    if (!empty($data['color_id']) && $data['color_id'] != '' &&  $data['color_id'] != 'undefined') {
                        $q->whereHas('rel_to_color', function ($q) use ($data) {
                            $q->where('colors.id', $data['color_id']);
                        });
                    }
                    if (!empty($data['size_id']) && $data['size_id'] != '' &&  $data['size_id'] != 'undefined') {
                        $q->whereHas('rel_to_size', function ($q) use ($data) {
                            $q->where('sizes.id', $data['size_id']);
                        });
                    }
                });
            }
        })->get();

        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();
        return view('frontend.shop',[
            'all_products'=> $all_products,
            'categories'=> $categories,
            'colors'=> $colors,
            'sizes'=> $sizes,
        ]);
    }

}
