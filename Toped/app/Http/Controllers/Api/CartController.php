<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(Request $request)
    {
        //get all posts
        $session = Session::get('user_id');
        // $user = auth()->user();
        return new PostResource(true, "List Cart", $session);
        // dd($user);
        // $product = [];
        // $auth = auth()->user()->name;
        // $posts = Cart::where('user_id', auth()->user()->id)->get();
        // foreach($posts as $data){
        //     $products = Product::where('id', $data->product_id)->get();
        //     $product[] = $products;
        // }
        // if (count($product) == 0) {
        //     return response()->json([
        //         'status' => 404,
        //         'error' => [
        //             'code' => 'data_not_found',
        //             'message' => 'Data tidak ditemukan.'
        //             ]
        //         ], 404);
        //     }

    }
}
