<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;

use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $product = [];
        $cart = Cart::where('user_id', auth()->user()->id)->get();
        if(count($cart) > 0){
            foreach($cart as $carts){
                $client = new Client();
                $url = "http://127.0.0.1:8888/api/product/";
                $response  = $client->request('GET', $url. $carts->product_id);
                $datas = json_decode($response->getBody()->getContents()); 
                $products = $datas[0];   
                // $products = Product::where('id', $carts->product_id)->get();
                $product[] = $products;
            }
            // dd($product);
            
            return view('cart.index', compact('cart', 'product'));
        }
        return view('cart.index', compact('cart'));
    }

    public function addCart($id)
    {    
        $client = new Client();
        $url = "http://127.0.0.1:8888/api/product/";
        $response  = $client->request('GET', $url.$id);
        $datas = json_decode($response->getBody()->getContents());    
        // dd($datas[0]->id);                 
        // $product = Product::find($id);

        $existingCart = Cart::where('product_id', $datas[0]->id)
        ->where('user_id', auth()->user()->id)
        ->count();
        if ($existingCart > 0) {
            return redirect()->back();
        } else {

            Cart::create([
                "user_id" => auth()->user()->id,
                "product_id" => $datas[0]->id
            ]);
            
            return redirect()->route('cart.index');
        }
    }

    function removeCart($id) {
        $cart = Cart::where('product_id', $id)->first();
        // dd($cart);
        if($cart->user_id == auth()->user()->id){

            $cart->delete();
        }
        return redirect()->route('cart.index');
    }

    function checkout(Request $request) {
        $product = [];
        $client = new Client();
        $url = "http://127.0.0.1:8080/api/shipping";
        $response  = $client->request('GET', $url);
        $datas = json_decode($response->getBody()->getContents());
        $city = $datas->rajaongkir->results;
        $cart = Cart::where('user_id', auth()->user()->id)->get();
        foreach($cart as $carts){
            $client = new Client();
            $url = "http://127.0.0.1:8888/api/product/";
            $response  = $client->request('GET', $url. $carts->product_id);
            $datas = json_decode($response->getBody()->getContents()); 
            $products = $datas[0];   
            // $products = Product::where('id', $carts->product_id)->first();
            $value = $request->input("myNumber{$products->id}");
            $carts->update([
                'quantity' => $value,
            ]);
            $product[] = [
                "id" => $products->id,
                "product_name" => $products->product_name,
                "category" => $products->category,
                "price" => $products->price,
                "weight" => $products->weight,
                "foto" => $products->foto,
                "description" => $products->description,
                "quantity" => $carts->quantity
            ];

        }
        // dd(Session::get('met    hodPayment'));
        
        return view('cart.checkout', compact('datas', 'product', 'city'));
    }
    
    function detailPayment(Request $request) {
        $product = [];

        $client = new Client();
        $url = 'http://127.0.0.1:8080/api/shipping/cost';
    
        $response = $client->post($url, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'origin' => '151',
                'city' => $request->city,
                'weight' =>  $request->weight,
                'code' => $request->code,
            ],
        ]);

        $responseData = json_decode($response->getBody(), true);
        $costs = $responseData[0]['rajaongkir']['results'][0];
        $costsOrigin = $responseData[0]['rajaongkir']['origin_details'];
        $costsDestination = $responseData[0]['rajaongkir']['destination_details'];
        
        $cart = Cart::where('user_id', auth()->user()->id)->get();
        foreach($cart as $carts){
            $client = new Client();
            $url = "http://127.0.0.1:8888/api/product/";
            $response  = $client->request('GET', $url. $carts->product_id);
            $datas = json_decode($response->getBody()->getContents()); 
            $products = $datas[0];   
            // $products = Product::where('id', $carts->product_id)->first();

            $product[] = [
                "id" => $products->id,
                "product_name" => $products->product_name,
                "category" => $products->category,
                "price" => $products->price,
                "weight" => $products->weight,
                "foto" => $products->foto,
                "description" => $products->description,
                "quantity" => $carts->quantity
            ];

        }

        $paymentMethod = $request->paymentMethod;

        return view('cart.payment-detail', compact('costs', 'product', 'costsOrigin', 'costsDestination', 'paymentMethod'));
    }

    function storeOrder(Request $request) {
        $cart = Cart::where('user_id', auth()->user()->id)->get();
        foreach($cart as $carts){
            $client = new Client();
            $url = "http://127.0.0.1:8888/api/product/";
            $response  = $client->request('GET', $url. $carts->product_id);
            $datas = json_decode($response->getBody()->getContents()); 
            $products = $datas[0];   
            // $products = Product::where('id', $carts->product_id)->first();
                $receiptId = Str::random(20);
                Order::create([
                    "receiptId" => $receiptId,
                    "user_id" => auth()->user()->id,
                    "product_id" => $products->id,
                    "price" => $request->input("price{$products->id}"),
                    "quantity" => $request->input("quantity{$products->id}"),
                    "paymentMethod" => $request->paymentMethod,
                    "origin" => $request->origin,
                    "destination" => $request->destination,
                    "courier" => $request->courier,
                ]);
                $carts->delete();
        }
        return redirect()->route('myorder');
    }
}
