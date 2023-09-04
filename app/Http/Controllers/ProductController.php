<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Constants\ProductConstants;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = new Product();
        $allProducts = $product->allProducts(true, true);

        return view('product.index', ['allProducts' => $allProducts ,'ucd' => ProductConstants::UCD_Currency]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validateRequest($request->formData);
        if ($validator->passes()) {
            Product::create($request->formData);
        }else{
            return response()->json(['error' => 'Invalid data'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fullPath = Request('fullPath');
        $productId = Request('productId');
        $fullPathAsClass = Request('fullPathAsClass');
        $fullFillePath = ProductConstants::Storage_Base_Folder_Name . '/' . $fullPath . ProductConstants::File_Extension;
        $file = Storage::disk('public')->get($fullFillePath);
        $file = json_decode($file, TRUE);
        return view('product.update', ['product' => $file[$productId] ,'fullPathAsClass' => $fullPathAsClass, 'productId' => $productId, 'fullPath' => $fullPath]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fullPath = Request('fullPath');
        $formData = Request('formData');
        $fullFillePath = ProductConstants::Storage_Base_Folder_Name . '/' . $fullPath . ProductConstants::File_Extension;

        $formData = $request->formData;

        $validator = $this->validateRequest($formData);
        if ($validator->passes()) {
            Product::update($fullFillePath , $id, $formData);
        }else{
            return response()->json(['error' => 'invalid data'], 404);
        }
    }

    public function listAll(){
        $product = new Product();
        $allProducts = $product->allProducts(true, true);

        return view('product.list_all', ['allProducts' => $allProducts,'ucd' => ProductConstants::UCD_Currency]);
    }

    private function validateRequest($data){

        return Validator::make($data, [
            'name' => 'required|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|numeric|regex:/^\d{0,10}(\.\d{1,2})?$/',
        ]);

    }

}
