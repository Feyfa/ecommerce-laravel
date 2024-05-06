@extends('layouts.main')

@section('main')

    @include('partials.alert')

    <div 
        style="background-image: url({{ asset('imgs/bg-utama.jpg') }})"
        class="w-full min-h-screen flex justify-center items-center bg-cover bg-no-repeat">
        <form 
            action="" 
            method="POST" 
            class="text-xl font-normal border border-neutral-500 rounded w-[35%] p-3 shadow-2xl bg-[rgba(255,255,255,.7)]">
            @csrf
            
            <h1 class="text-center text-3xl">Login Ecommerce</h1>

            <div class="row flex flex-col gap-1 mt-5">
                <label for="username" class="@error('username') text-red-500 @enderror">Username</label>
                <div class="relative">
                    <input 
                        required    
                        type="text" 
                        autocomplete="off" 
                        name="username" 
                        id="username"
                        class="w-full border border-neutral-500 h-12 pl-2.5 pr-11 outline-none rounded shadow @error('username') border-red-500 @enderror">
                    <span class="absolute right-2.5 top-3 end-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                        </svg>
                    </span>
                </div>
                @error('username')
                    <p class="-mt-1 text-base text-red-500">{{ $message }}</p>
                @enderror
            </div>


            <div class="row flex flex-col gap-1 mt-3">
                <label for="password" class="@error('password') text-red-500 @enderror">Password</label>
                <div class="relative">
                    <input 
                        required    
                        type="password" 
                        autocomplete="off" 
                        name="password" 
                        id="password"
                        class="w-full border border-neutral-500 h-12 pl-2.5 pr-11 outline-none rounded shadow @error('password') border-red-500 @enderror">
                    <span class="absolute right-2.5 top-3 end-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-eye cursor-pointer" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-eye-slash hidden cursor-pointer" viewBox="0 0 16 16">
                            <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z"/>
                            <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829"/>
                            <path d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z"/>
                          </svg>
                    </span>
                </div>
                @error('password')
                    <p class="-mt-1 text-base text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end mt-3">
                <a href="/register" class="underline text-blue-700">register</a>
            </div>

            <button type="submit" name="login_submit" class="w-full h-12 border border-neutral-300 rounded shadow bg-blue-500 hover:bg-[#428bff] mt-4">Login</button>

            <script>
                $(document).ready(function () {
                    $('.bi-eye').click(function (e) { 
                        e.preventDefault();

                        $(this).addClass('hidden');
                        $('.bi-eye-slash').removeClass('hidden');

                        $('input#password').attr('type', 'text');
                    });

                    $('.bi-eye-slash').click(function (e) { 
                        e.preventDefault();

                        $(this).addClass('hidden');
                        $('.bi-eye').removeClass('hidden');

                        $('input#password').attr('type', 'password');
                    });
                });
            </script>
        </form>
    </div>
@endsection