<x-app-layout>

    <div class="py-12 px-12">

        <!-- Search Bar -->
        <div class="w-full flex items-center justify-center">
            <div class="w-9/12 border-2 border-[#41b547] flex items-center justify-between rounded-lg">
                <input type="text" name="search" class="w-full border-none focus:ring-0 focus:border-0  bg-transparent"
                    placeholder="Search Product">
                <button class="bg-[#41b547] h-full px-2 py-1 rounded-r-lg -mr-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="white" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </button>
            </div>
        </div>
        <!-- Advertise -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <img src="/assets/adv.jpg" alt="">
                </div>
            </div>
        </div>
        @if(count($result) == 0)
        <div class="grid place-items-center" style="height: 80vh;">
            <img src="/assets/nocart.jpg" alt="No Cart">
        </div>
        @else
        <!-- Product -->
        <div class="">
            <h1 class="text-2xl font-bold">Products for you</h1>
            <div class="my-5 grid grid-cols-4 gap-5">
                @foreach($result as $data)
                <div class="card bg-white shadow-xl">
                    <figure><img class="p-3" src="{{ asset('storage/posts/' . $data->foto) }}" alt="Shoes" /></figure>
                    <div class="card-body bg-white ">
                        <div class="flex justify-between items-center">
                            <h2 class="card-title">{{ $data->product_name }}</h2>
                            <p class="text-right">@currency($data->price)</p>
                        </div>
                        <p>If a dog chews shoes whose shoes does he choose?</p>
                        <div class="card-actions justify-end">
                            <button class="btn btn-primary">Add to Cart</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
        @endif
    </div>
</x-app-layout>
