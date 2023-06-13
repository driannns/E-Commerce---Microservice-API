<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;

use GuzzleHttp\Client;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    function myorder() {
        $orders = [];
        $order = Order::where('user_id', auth()->user()->id)->get();
        foreach($order as $data) {
            $client = new Client();
            $url = "http://127.0.0.1:8888/api/product/";
            $response  = $client->request('GET', $url. $data->product_id);
            $datas = json_decode($response->getBody()->getContents()); 
            $products = $datas[0];   
            // $products = Product::where('id', $data->product_id)->first();
            if($products){

                $orders[] = [
                    "receiptId" => $data->receipt_id,
                    "product_name" => $products->product_name,
                    "category" => $products->category,
                    "foto" => $products->foto,
                    "description" => $products->description,
                    "quantity" => $data->quantity,
                    "price" => $data->price,
                    "paymentMethod" => $data->paymentMethod,
                    "origin" => $data->origin,
                    "destination" => $data->destination,
                    "courier" => $data->courier
                ];
        }
        }

        return view('myorder', compact('orders'));
    }
}
