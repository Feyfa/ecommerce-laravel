@if (session()->has('flash'))
    <div class="alert-{{ session('flash')['status'] }} bg-blue-500 fixed top-0 left-0 right-0 text-white flex justify-between items-center text-2xl py-3 px-8 shadow-2xl tracking-wide border-b border-b-neutral-500">
        <p>{{ session('flash')['message'] }}</p>
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-lg cursor-pointer" viewBox="0 0 16 16">
            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
        </svg>
    </div>

    <script>
        $(document).ready(function () {
            setTimeout(() => {
                $('.bi-x-lg').parent().addClass('hidden'); 
            }, 3000);
            
            $('.bi-x-lg').click(function (e) { 
                e.preventDefault();
                $(this).parent().addClass('hidden'); 
            });
        });
    </script>
@endif