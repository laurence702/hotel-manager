<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Http\Requests\Admin\StoreProductsRequest;
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
            $outOfStock = Product::where('stock_count', '0')->count();
            $lowStock = Product::where('stock_count', '<', '5')->count();
            return view('admin.products.index', compact(['products', 'outOfStock', 'lowStock']));
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
    public function store(StoreProductsRequest $request)
    {
        $product = new Product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock_count = $request->stock_count;
        $querySuccess = $product->save();
        if ($querySuccess)
            return redirect()->route('admin.products.index')->with('success');
        else
            return redirect()->route('admin.products.index')->with('errors');
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
    public function update(UpdateProductRequest $request, $id)
    {
        if (!Gate::allows('products_edit')) {
            return view('errors.401');
        }

        $product = Product::findOrFail($id);

        $product->update($request->all());

        return redirect()->route('admin.products.index')->with('success', 'Update Successful');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('products_delete')) {
            return abort(401);
        }
        $drink = Product::findOrFail($id);
        $drink->delete();

        return redirect()->route('admin.products.index');
    }
}
