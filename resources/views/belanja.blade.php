@extends('layouts.main2')

@section('main2')

    @include('partials.alert')

    <div class="w-full">
        <h1 class="text-center text-3xl font-medium">Barang Belanja</h1>
    
        <div class="w-full p-4 grid grid-cols-3 gap-x-3 gap-y-5">

            @foreach ($products as $product)
                <div class="row flex flex-col justify-end gap-1 border border-neutral-500 bg-white rounded shadow-md">
                    <img src="{{ asset("/storage/$product->img") }}" alt="product" class="w-full h-max rounded-sm shadow-md bg-white">

                    <div class="text-sm px-1">
                        <span class="font-semibold">{{ $product->user->name }}</span>
                    </div>

                    <div class="p-1 flex flex-col gap-1">
                        <div>
                            <span class="w-14 inline-block">Name</span>
                            <span class="mr-2">:</span>
                            <span>{{ $product->name }}</span>
                        </div>
                        <div>
                            <span class="w-14 inline-block">Price</span>
                            <span class="mr-2">:</span>
                            <spa class="font-semibold">{{ "Rp" . number_format($product->price, 0, ',', '.') }}</spa>
                        </div>
                        <div>
                            <span class="w-14 inline-block">Stock</span>
                            <span class="mr-2">:</span>
                            <span>{{ $product->stock }}</span>
                        </div>
                    </div>
                    <div class="flex gap-4 p-1 pb-2">
                        <form action="/keranjang" method="POST" class="w-full">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="user_id_buyer" value="{{ $user_id_buyer }}">
                            <button type="submit" name="keranjang_submit" class="rounded-sm shadow-md border border-neutral-500 bg-yellow-500 w-max py-1 px-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                                    <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9z"/>
                                    <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection