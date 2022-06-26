<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\sections;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:المنتجات', ['only' => ['index']]);
        $this->middleware('permission:اضافة منتج', ['only' => ['create','store']]);
        $this->middleware('permission:تعديل منتج', ['only' => ['edit','update']]);
        $this->middleware('permission:حذف منتج', ['only' => ['destroy']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = products::all();
        $sections = sections::all();
        return view('products.products',compact('products','sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // dd($request->all());
        $request->validate([
            'products_name' => 'required|max:255',
            'section' => 'required|max:255',
        ]);
        // dd($request->all());

        $products = products::create([
            'products_name' =>$request->products_name,
            'description'=>$request->description,
            'section_id' => $request->section,
        ]);

        return redirect()->back()->with('product','تمت اضافة المنتج بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit($product)
    {
        //
        $product = products::find($product);
        $sections = sections::all();
        return view('products.edit',compact('product','sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $product)
    {
        //
        // dd($request->all());

        $request->validate([
            'products_name' => "required|max:255",
            'section' => "required|integer",
        ]);
        $product = products::find($product);
        $product->products_name = $request->products_name;
        $product->description = $request->description;
        $product->section_id = $request->section;
        $product->save();

        return redirect('/products')->with('product','تم التعديل بنجاح');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy($product)
    {
        //
        // dd($product);
        $product = products::find($product)->delete();

        return redirect()->back()->with('product','تمت حذف المنتج بنجاح');
    }
}
