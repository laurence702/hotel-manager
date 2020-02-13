<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Product;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('products_view')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (!Gate::allows('products_delete')) {
                return abort(401);
            }
            $products = Product::onlyTrashed()->get();
        } else {
            $products = Product::all();
        return view('admin.products.index', compact('products'));
        }
    }   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('customer_create')) {
            return abort(401);
        }        
        //$product = \App\Product::get()->pluck('price','description' ,'name','id')->prepend(trans('quickadmin.qa_please_select'), '');
        $products = Product::all();
 
        return view('admin.products.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product= new Product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        //return $product; die;
        $querySuccess = $product->save();
        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('products_view')) {
            return abort(401);
        }
        $product = Product::findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('products_edit')) {
            return abort(401);
        }

        $product = Product::findOrFail($id);

        return view('admin.products.edit', compact('product'));
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
        $product = Product::findOrFail($id);
        
        $product->update($request->all());

        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Gate::allows('products_delete'))
        $drink = Product::findOrFail($id);
        $drink->delete();

        return redirect()->route('admin.products.index');
    }


    public function checkoutPage(Request $request) {
        $products = Product::all();
        return view('admin.products.test',compact('products'));
    }
}
