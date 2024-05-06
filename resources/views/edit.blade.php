@extends('layouts.main2')

@section('main2')
    <form class="w-full px-4 flex flex-col justify-center gap-5" action="" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('partials.alert')

        <div class="row relative">
            <a href="/product" class="absolute top-0 end-0 left-2 w-max">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm11.5 5.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
                </svg>
            </a>
            <h1 class="text-center text-4xl tracking-wide">Edit Product</h1>
        </div>

        <div class="row w-full flex gap-5 flex-col items-center justify-center">
            <img src="{{ asset("storage/$product->img") }}" alt="product" class="product w-[400px] h-[225px] border border-neutral-500 rounded shadow-md cursor-zoom-in">

            <div class="product-container fixed top-0 left-0 bottom-0 right-0 bg-[rgba(0,0,0,.5)] backdrop-blur-sm hidden justify-center items-center cursor-zoom-out">
                <img src="{{ asset("storage/$product->img") }}" alt="user" class="product w-[560px] h-[315px] border border-neutral-500 rounded shadow-md">
            </div>
        </div>

        <div class="row flex justify-center items-center">
            <input required type="hidden" name="id" value="{{ $product->id }}">
            <input required type="hidden" name="user_id_seller" value="{{ $user_id_seller }}">

            <input required type="hidden" name="old_img" value="{{ $product->img }}">
            <input type="file" name="img" id="img" class="bg-white border border-neutral-500 rounded-sm p-1 w-[19rem] shadow-md img-input">
        </div>

        <div class="grid grid-cols-3 gap-5 text-xl">
            <div class="flex flex-col items-start gap-1">
                <label for="name" class="@error('name') text-red-500 @enderror">Name</label>
                <input required type="text" name="name" id="name" value="{{ $product->name }}" class="border border-neutral-500 rounded-sm py-2 px-2.5 w-full outline-none shadow-md @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="-mt-1 text-base text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex flex-col items-start gap-1">
                <label for="price" class="@error('price') text-red-500 @enderror">Price</label>
                <input required type="number" min="1" name="price" id="price" value="{{ $product->price }}" class="border border-neutral-500 rounded-sm py-2 px-2.5 w-full outline-none shadow-md @error('price') border-red-500 @enderror">
                @error('price')
                    <p class="-mt-1 text-base text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex flex-col items-start gap-1">
                <label for="stock" class="@error('stock') text-red-500 @enderror">Stock</label>
                <input required type="number" min="1" name="stock" id="stock" value="{{ $product->stock }}" class="border border-neutral-500 rounded-sm py-2 px-2.5 w-full outline-none shadow-md @error('stock') border-red-500 @enderror">
                @error('stock')
                    <p class="-mt-1 text-base text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-3 gap-5">
            <button type="submit" name="edit_submit" class="py-2.5 border border-neutral-500 rounded-sm shadow-lg bg-blue-500 mt-2 hover:bg-[#428bff]">Edit</button>
        </div>
    </form>

    <script>
        $(document).ready(function () {
            $('.product').click(function (e) { 
                e.preventDefault();

                $(this).addClass('hidden');
                
                $('.product-container').removeClass('hidden');
                $('.product-container').addClass('flex');
            });

            $('.product-container').click(function (e) { 
                e.preventDefault();

                $(this).removeClass('flex');
                $(this).addClass('hidden');
                
                $('.product').removeClass('hidden');
                $('.product').addClass('flex');
            });

            $('.product-container').click(function (e) { 
                e.preventDefault();

                $(this).removeClass('flex');
                $(this).addClass('hidden');
                
                $('.person').removeClass('hidden');
                $('.person').addClass('flex');
            });

            $('input[type=file]').change(function (e) { 
                e.preventDefault();

                // jika file bukan image
                if(!this.files[0].type.startsWith('image/')) {
                    this.value = '';
                    return alert('The foto field must be an image');
                } 

                if(this.files[0].size > 1000000) {
                    this.value = '';
                    return alert('The foto field must not be greater than 1024 kilobytes');
                }

                const oFReader = new FileReader();

                oFReader.readAsDataURL(this.files[0]);

                oFReader.onload = function (OFREvent) {
                    $('.product').each(function (index, element) {
                        $(element).attr('src', OFREvent.target.result);
                    });
                }
            });
        });
    </script>
@endsection