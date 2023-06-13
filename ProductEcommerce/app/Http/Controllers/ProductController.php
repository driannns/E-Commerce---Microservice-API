<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Product::latest()->paginate(5);

        return response()->json([
            $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
        // $image->storeAs('public/posts', $image->hashName());

        $post = Product::create([
            'foto'     => $imageName,
            'product_name'     => $request->product_name,
            'category'   => $request->category,
            'description' => $request->description,
            'price'   => $request->price,
            'weight'   => $request->weight,
        ]);

        return response()->json([
            true, 'Data product berhasil ditambahkan', $post
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $posts = Product::find($id);
        
        return response()->json([
            $posts
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
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

        return response()->json([
            true, 'Product Berhasil Diperbarui!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Product::find($id);

        $post->delete();

         return response()->json([
            true, 'Product Berhasil Dihapus!',
        ]);
    }
}
