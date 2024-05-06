@extends('layouts.main2')

@section('main2')
    <form class="w-full flex flex-col justify-center" action="" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('partials.alert')

        <div class="row w-full flex gap-5 flex-col items-center justify-center">
            <img src="{{ asset($img ? "storage/$img" : 'imgs/person.png') }}" alt="user" class="person w-40 h-40 border border-neutral-500 rounded shadow-md cursor-zoom-in">

            <div class="person-container fixed top-0 left-0 bottom-0 right-0 bg-[rgba(0,0,0,.5)] backdrop-blur-sm hidden justify-center items-center cursor-zoom-out">
                <img src="{{ asset($img ? "storage/$img" : 'imgs/person.png') }}" alt="user" class="w-96 h-96 border border-neutral-500 rounded shadow-md">
            </div>
        </div>

        <div class="row">
            <div class="w-1/2 mx-auto flex justify-end items-center gap-5">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-circle cursor-pointer hidden" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                </svg>
                <button type="submit" name="user_submit" class="check hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-check-circle cursor-pointer" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
                    </svg>
                </button>
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-pencil cursor-pointer" viewBox="0 0 16 16">
                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                </svg>
            </div>
        </div>

        <div class="row text-center pb-3">
            <input type="hidden" name="username" id="username" value="{{ $username }}">
            <input type="hidden" name="img_old" id="img_old" value="{{ $img }}" class="bg-white border border-neutral-500 rounded-sm p-1 w-[19rem] shadow-md hidden">
            <input type="file" name="img" id="img" class="bg-white border border-neutral-500 rounded-sm p-1 w-[19rem] shadow-md hidden img-input">
        </div>

        <div class="row text-center">
            <input readonly required type="text" class="rounded-sm bg-transparent overflow-hidden py-1 px-4 outline-none w-1/2 text-center text-2xl name-input" name="name" value="{{ $name }}">
        </div>
    </form>

    <script>
        $(document).ready(function () {
            let bufferSrcPerson = "";
            let bufferName = "";

            $('.person').click(function (e) { 
                e.preventDefault();

                $(this).addClass('hidden');
                
                $('.person-container').removeClass('hidden');
                $('.person-container').addClass('flex');
            });

            $('.person-container').click(function (e) { 
                e.preventDefault();

                $(this).removeClass('flex');
                $(this).addClass('hidden');
                
                $('.person').removeClass('hidden');
                $('.person').addClass('flex');
            });

            $('.bi-pencil').click(function (e) {
                e.preventDefault();

                $(this).addClass('hidden');

                $('.img-input').removeClass('hidden');
                $('.bi-x-circle').removeClass('hidden');
                $('.check').removeClass('hidden');

                $('.name-input').addClass('edit-input-active');
                $('.name-input').prop('readonly', false);

                bufferSrcPerson = $('.person').attr('src');
                bufferName = $('.name-input').val();
            });

            $('.bi-x-circle').click(function(e) {
                e.preventDefault();

                $(this).addClass('hidden');

                $('.img-input').addClass('hidden');
                $('.bi-pencil').removeClass('hidden');
                $('.check').addClass('hidden');

                $('.name-input').removeClass('edit-input-active');
                $('.name-input').prop('readonly', true);
                $('.name-input').val(bufferName);   

                $('.person').attr('src', bufferSrcPerson);
                bufferSrcPerson = "";

                $('input[type=file]').val('');
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
                    $('.person').attr('src', OFREvent.target.result);
                }
            });
        });
    </script>
@endsection