<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ChategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chategory = Chategory::latest()->paginate(5);

        $response = [
            'massage'   =>'List all Level',
            'data'      => $chategory,
        ];
        return response()->json($response, 200);
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
         $validator = Validator::make($request->all(),[
            'chategory' => 'required',
        ]);


        //jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid field',
                'errors' => $validator->errors()
            ],422);
        }


        //jika validasi sukses masukan data level ke database
        $chategory = Chategory::create([
            'chategory' => $request->chategory,
        ]);


        //response
        $response = [
            'success'   => 'Add level success',
            'data'      => $chategory,
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
        //define validation rules
        $validator = Validator::make($request->all(),[
            'chategory' => 'required|unique:chategories|min:2',
        ]);

        //check if validation fails
        if ($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        //find level by ID
        $chategory = Chategory::find($id);

        $chategory->update ([
            'chategory' => $request->chategory,
        ]);


        //response
        $response = [
            'status' => 'success',
            'message' => 'Update chategory Success',
            'data' => $chategory,
        ];

        return response()->json($response, 201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        {
            //find character by ID
            $chategory = Chategory::find($id);




            if (isset($chategory)) {
                //jika data ditemukan delete image from storage
                Storage::delete('public/chategory/'.basename($chategory->image));


                //delete post
                $chategory->delete();


                $response = [
                    'success'   => 'Delete Chategory Success',
                ];
                return response()->json($response, 200);


            } else {
                //jika data tidak ditemukan
                $response = [
                    'success'   => 'Data Chategory Not Found',
                ];


                return response()->json($response, 404);


            }


        }

    }
}
