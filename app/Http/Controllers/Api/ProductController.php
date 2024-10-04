<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        {
            //find Gameplay by ID
            $product = Product::latest()->paginate(5);


            //response
            $response = [
                'success'   => 'Detail Product',
                'data'      => $product,
            ];


            return response()->json($response, 200);
        }


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
      //validasi data

      $image = $request->file('image');
      $image->storeAs('public/posts', $image->hashName());

      $validator = Validator::make($request->all(),[
          'chategory_id'=> 'required',
          'product' => 'required|min:2|unique:products',
          'description' => 'required',
          'price' => 'required|integer',
          'stock' => 'required|integer',
          'image' => 'image|mimes:jpeg,jpg,png|max:2048',
      ]);
      //cek jika validasi gagal
      if($validator->fails()) {
          return response()->json([
              'status' => 'faild',
              'message' => 'Invalid filed',
              'errors' => $validator->errors()
          ],422);
      }

      //create product = memasukan data ke database
      $product = Product::create([
          'chategory_id' => $request->chategory_id,
          'product' => $request->product,
          'description' => $request->description,
          'price' => $request->price,
          'stock' => $request->stock,
          'image' => $request->image,
      ]);

      //response
      $response = [
          'status'=> 'success',
          'message' => 'Add product succes',
          'data' => $product
      ];

      return response()->json($response, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        {
            //define validation rules
            $validator = Validator::make($request->all(),[
                'chategory' => 'required',
                'product' => 'required|min:2unique:products',
                'description' => 'required',
                'price' => 'required|integer',
                'stock' => 'required|integer',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg[max:2048',

            ]);

            //check if validation fails
            if ($validator->fails()){
                return response()->json($validator->errors(),422);
            }

            //find level by ID
            $produk = Product::find($id);

           //upload image
           $image = $request->file('image');
           $image->storeAs('public/posts', $image->hashName());

           $produk->update([
                'chategory_id' => $request->chategory_id,
                'product' => $request->product,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'image' => $image->hashName(),
           ]);

            //response
            $response = [
                'status' => 'success',
                'message' => 'Update product Success',
                'data' => $produk,
            ];

            return response()->json($response, 200);

        }

        /**
         * Remove the specified resource from storage.
         */
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        {
            //find gameplay by ID
            $product = product::find($id);


            if (isset($product)) {


                //delete post
                $product->delete();


                $response = [
                    'success'   => 'Delete gproduct Success',
                ];
                return response()->json($response, 200);


            } else {
                //jika data gameplay tidak ditemukan
                $response = [
                    'success'   => 'Data product Not Found',
                ];


                return response()->json($response, 404);
            }
    }

    }
}
