<div class="w-[70%] h-screen-minus-banyak overflow-auto flex flex-col gap-2">
    @if (count($keranjangs) < 1)    
        <h class="w-full text-center text-xl font-medium">Barang Belanjaan Kamu Masih Kosong Nih</h>
    @endif

    @foreach ($keranjangs as $keranjang)    
        <div class="row flex items-start border border-neutral-400 bg-white rounded shadow-md p-2 gap-2">
            <div class="">
                <input type="checkbox" {{ $keranjang->checked == 1 ? 'checked' : '' }} class="w-5 h-5">
            </div>
            <div class="flex flex-col justify-start items-start gap-1">
                <div class="flex gap-2">
                    <img src="{{ asset("storage/{$keranjang->product->img}") }}" alt="product" class="w-[40%] rounded-sm shadow-md bg-white">
    
                    <div class=" flex flex-col gap-1">
                        <span class="text-sm font-semibold">{{ $keranjang->product->user->name }}</span>
                        <div>
                            <span class="w-14 inline-block">Name</span>
                            <span class="mr-2">:</span>
                            <span>{{ $keranjang->product->name }}</span>
                        </div>
                        <div>
                            <span class="w-14 inline-block">Price</span>
                            <span class="mr-2">:</span>
                            <span class="font-semibold">{{ "Rp" . number_format($keranjang->product->price, 0, ',', '.') }}</span>
                        </div>
                        <div>
                            <span class="w-14 inline-block">Stock</span>
                            <span class="mr-2">:</span>
                            <span>{{ $keranjang->product->stock }}</span>
                        </div>
                        <form action="" class="mt-1" method="POST">
                            @csrf
                            @method('DELETE')
                            
                            <input type="hidden" name="id" value="{{ $keranjang->id }}">
                            <button type="submit" name="delete_keranjang_submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

</div>

<div class="w-[30%] border border-neutral-400 bg-white rounded shadow-md px-2">
    <div class="border-b border-b-neutral-300 py-2">
        <h2 class="text-lg font-semibold">Ringkasan Belanja</h2>
        <div class="mt-1 flex items-center justify-between">
            <h3>Total</h3>
            <h3 class="font-semibold">{{ $totalPrice != 0 ? "Rp" . number_format($totalPrice, 0, ',', '.') : ''  }}</h3>
        </div>
    </div>
    <div class="border-b border-b-neutral-300 py-2">
        <button type="button" class="w-full border border-neutral-300 rounded-md bg-blue-500 py-1.5 text-white font-medium">Bayar</button>
    </div>
</div>

@if (count($keranjangs) > 0)
        <script>
            $(document).ready(function () 
            {
                $('input[type=checkbox]').each(function (index, element) 
                {
                    $(element).click(function (e) 
                    {
                        let id = $("input[name='id']").eq(index).val();

                        if($(this).prop('checked')) 
                        {
                            $.ajax({
                                type: "GET",
                                url: "/keranjang/checked",
                                data: {
                                    'id': id,
                                    'checked': true
                                },
                                success: function (response) {
                                    $('.keranjang-container').html(response);
                                }
                            });
                        } 
                        else 
                        {
                            $.ajax({
                                type: "GET",
                                url: "/keranjang/checked",
                                data: {
                                    'id': id,
                                    'checked': false
                                },
                                success: function (response) {
                                    $('.keranjang-container').html(response);
                                }
                            });
                        }
                    });
                });
            });
        </script>
    @endif