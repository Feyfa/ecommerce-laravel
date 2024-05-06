<header class="navbar bg-violet-500 flex justify-between items-center h-14 px-10 fixed top-0 left-0 right-0">
    <h1 class="text-2xl text-white">My Ecommerce</h1>
    <form action="/logout" method="POST">
        @csrf
        <button
            type="submit" 
            name="logout_submit"
            class="text-white border-2 border-neutral-300 w-24 py-1.5 rounded bg-red-500 hover:bg-[#ff4d4d]">Logout</button>
    </form>
</header>