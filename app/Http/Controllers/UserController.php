<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(): Response
    {
        return response()->view('user', [
            'title' => 'Halaman User',
            'img' => auth()->user()->img,
            'name' => auth()->user()->name,
            'username' => auth()->user()->username,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        if($request->has('user_submit'))
        {
            // dd(
            //     $request->input(), 
            //     $request->file('img_old'),
            //     $request->file('img'),
            // );

            // untuk memberikan validasi
            $validate = $request->validate([
                'img' => ['nullable', 'image', 'file', 'max:1024'],
                'name' => ['required'],
            ]);

            // jika ada image nya, maka masukan ke dalam storage, dan ubah isi $validate['img']
            if($request->file('img'))
            {
                // jika ada old image nya, maka hapus old image nya
                if($request->input('img_old')) 
                {
                    Storage::delete($request->input('img_old'));
                }
                
                $validate['img'] = $request->file('img')->store('user-imgs');
            }

            // jika di dalam form halamannya membawa input dengan name username, maka lakukan update
            if($request->input('username'))
            {
                User::where('username', $request->input('username'))
                    ->update($validate);

                return redirect('/user')->with('flash', [
                    'message' => 'User Berhasil Di Update',
                    'status' => 'success'
                ]);
            }

            // jika di dalam form halamannya tidak membawa input dengan name username, maka berikan pesan error dan jangan di update user nya
            return redirect('/user')->with('flash', [
                'message' => 'Gagal Update Karena username Tidak Ada',
                'status' => 'error'
            ]);
        }
        else 
        {
            // ini jika dari wilayah bukan /user masuk ke put user
            return redirect()->back()
                             ->with('flash', [
                                'message' => 'Submit Bukan Dari User',
                                ' status' => 'error'
                             ]);
        }
    }
}
