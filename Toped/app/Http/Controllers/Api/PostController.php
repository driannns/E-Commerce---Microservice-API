<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function index()
    {
        //get all posts
        $client = new Client();
        $url = "http://127.0.0.1:8888/api/product";
        $response  = $client->request('GET', $url);
        $datas = json_decode($response->getBody()->getContents());
        // $posts = Product::latest()->paginate(5);

        //return collection of posts as a resource
        return new PostResource(true, 'List Data Products', $datas);
    }

    function show($id){
        $posts = Product::find($id);

        return new PostResource(true, 'Data product', $posts);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'foto'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'product_name'     => 'required',
            'category'   => 'required',
            'description'   => 'required',
            'price'   => 'required',
            'weight' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $image = $request->file('foto');
        $image->storeAs('public/posts', $image->hashName());

        $post = Product::create([
            'foto'     => $image->hashName(),
            'product_name'     => $request->product_name,
            'category'   => $request->category,
            'description' => $request->description,
            'price'   => $request->price,
            'weight'   => $request->weight,
        ]);

        return new PostResource(true, 'Data Post Berhasil Ditambahkan!', $post);
    }

    function update(Request $request, $id) {
        $product = Product::find($id);

        $validator = Validator::make($request->all(), [
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'product_name' => 'required',
            'category'   => 'required',
            'description'   => 'required',
            'price'   => 'required',
            'weight' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('foto')) {
            $fotocolumn = $product->foto;
            $path = public_path("uploads/images/{$fotocolumn}");
            if (File::exists($path)) {
                unlink($path);
            }
            $image = $request->file('foto');
            $image->storeAs('public/posts', $image->hashName());
            $product->update([
                "foto" => $image->hashName()
            ]);
        }

        $post = $product->update([
            'product_name'     => $request->product_name,
            'category'   => $request->category,
            'description' => $request->description,
            'price'   => $request->price,
            'weight'   => $request->weight,
        ]);

        return new PostResource(true, 'Product Berhasil Diperbarui!', $post);

    }

    function destroy($id) {
        $post = Product::find($id);

        $post->delete();

        return new PostResource(true, 'Data Product Berhasil Dihapus!', null);
    }
}
