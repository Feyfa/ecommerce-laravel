@extends('layouts.main2')

@section('main2')

    @include('partials.alert')

    <div class="w-full text-xl">
        <h1 class="text-center text-3xl font-medium">Product Saya</h1>

        @if (count($products) < 1)
            <h1 class="text-center mt-10">Produt Anda Kosong</h1>    
        @endif
        
        <div class="w-full p-4 grid grid-cols-3 gap-x-3 gap-y-5">

            @foreach ($products as $product)    
                <div class="row flex flex-col justify-end gap-1 border border-neutral-500 bg-white rounded shadow-md">
                    <img src="{{ asset("storage/$product->img") }}" alt="product" class="w-full h-max rounded-sm shadow-md bg-white">
                    
                    <input type="hidden" name="id" value="{{ $product->id }}">

                    <div class="p-1 flex flex-col gap-1">
                        <div>
                            <span class="w-16 inline-block">Name</span>
                            <span class="mr-2">:</span>
                            <span>{{ $product->name }}</span>
                        </div>
                        <div>
                            <span class="w-16 inline-block">Price</span>
                            <span class="mr-2">:</span>
                            <span class="font-semibold">{{ "Rp" . number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                        <div>
                            <span class="w-16 inline-block">Stock</span>
                            <span class="mr-2">:</span>
                            <span>{{ $product->stock }}</span>
                        </div>
                    </div>
                    <div class="flex gap-4 p-1 pb-2">
                        <a href="/product/edit?id={{ $product->id }}&user_id_seller={{ $user_id_seller }}" class="text-center w-full rounded-sm shadow-md border border-neutral-500 bg-green-500 py-1">Edit</a>
                        <form action="" method="POST" class="w-full">
                            @csrf
                            @method('DELETE')

                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <button type="submit" name="delete_submit" class="w-full rounded-sm shadow-md border border-neutral-500 bg-red-500 py-1">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <a href="/product/add" class="fixed bottom-7 right-5 w-max border border-slate-500 p-2 rounded-md bg-blue-500 hover:bg-[#428bff] cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
            </svg>
        </a>
    </div>
@endsection