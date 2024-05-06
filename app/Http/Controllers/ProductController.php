<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function editView(Request $request): Response|RedirectResponse
    {
        if($request->user_id_seller ==  auth()->user()->id)
        {
            return response()->view('edit', [
                'title' => 'Halaman Edit',
                'product' => Product::where('id', $request->input('id'))->first(),
                'user_id_seller' => $request->user_id_seller,
            ]);
        }
        else
        {
            return redirect()->back()
                             ->with('flash', [
                                'message' => 'Product Tidak Terdaftar',
                                'status' => 'error'
                             ]);
        }
    }

    public function update(Request $request): RedirectResponse
    {
        if(
            $request->has('edit_submit') && 
            $request->input('user_id_seller') == auth()->user()->id
        )
        {
            // dd($request->input('name'), $request->file('img'));
            
            $validate = $request->validate([
                'img' => ['image', 'file', 'max:1024', 'nullable'],
                'name' => ['required', 'min:3'],
                'price' => ['required', 'integer', 'min:1'],
                'stock' => ['required', 'integer', 'min:1']
            ]);

            if($request->file('img'))
            {
                if($request->input('old_img'))
                {
                    Storage::delete($request->input('old_img'));
                }

                $validate['img'] = $request->file('img')->store('product-imgs');
            }

            Product::where('id', $request->input('id'))
                   ->where('user_id_seller', $request->input('user_id_seller'))
                   ->update($validate);

            return redirect('/product')->with('flash', [
                'message' => 'Product Berhasil Di Update',
                'status' => 'success'
            ]);
        }
        else
        {
            return redirect()->back()
                             ->with('flash', [
                                'message' => 'Submit Bukan Dari Edit',
                                'status' => 'error' 
                             ]);
        }
    }

    public function productView(): Response
    {
        $product = Product::where('user_id_seller', auth()->user()->id)->get();

        return response()->view('product', [
            'title' => 'Halaman Product',
            'products' => $product,
            'user_id_seller' => auth()->user()->id,
        ]);
    }

    public function addView(): Response
    {
        return response()->view('add', [
            'title' => 'Halaman Tambah',
            'id' => auth()->user()->id,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        // dd(
        //     $request->input(),
        //     $request->file('img')
        // );

        if($request->has('tambah_submit'))
        {
            $validate = $request->validate([
                'user_id_seller' => ['required', 'integer'],
                'img' => ['image', 'file', 'max:1024', 'required'],
                'name' => ['required', 'min:3'],
                'price' => ['required', 'integer', 'min:1'],
                'stock' => ['required', 'integer', 'min:1']
            ]);

            $validate['img'] = $request->file('img')->store('product-imgs');

            Product::create($validate);

            return redirect('/product')->with('flash', [
                'message' => 'Product Berhasil Ditambah',
                'status' => 'success'
            ]);
        }
        else
        {
            return redirect()->back()
                             ->with('flash', [
                                'message' => 'Submit Bukan Dari Tambah',
                                'status' => 'error'
                             ]);
        }
    }

    public function delete(Request $request)
    {
        if($request->has('delete_submit'))
        {
            Keranjang::where('product_id', $request->input('id'))
                     ->delete();

            $product = Product::where('id', $request->input('id'))->first();

            Storage::delete($product->img);

            $product->delete();

            return redirect('/product')->with('flash', [
                'message' => 'Product Berhasil Dihapus',
                'status' => 'success',
            ]);
        }
        else
        {
            return redirect()->back()
                             ->with('flash', [
                                'message' => 'Submit Bukan Dari Delete',
                                'status' => 'error'
                             ]);
        }
    }
}
