<x-app-layout>
    <div class="flex items-center pl-16" style="height: 15vh;">
        <img class="w-2/12" src="/assets/logo.png" alt="">
        <h1 class="text-2xl font-bold">My Order</h1>
    </div>

    @if(count($orders) == 0)
    <div class="grid place-items-center" style="height: 80vh;">
        <img src="/assets/nocart.jpg" alt="No Cart">
    </div>
    @else
        <div class="w-full min-h-screen">
            @foreach ($orders as $products)
            <div class="w-10/12 mx-auto border py-4 px-8 flex items-center justify-between">
                <div class="flex items-center gap-3 w-3/12">
                    <div class="w-36 h-36 rounded-lg"
                        style="background-image: url('{{ asset('storage/posts/' . $products['foto']) }}'); background-size: contain; background-repeat: no-repeat; background-position: center">
                    </div>
                    <div class="">
                        <p>{{ $products['product_name'] }}</p>
                        <p class="font-bold">{{ $products['category'] }}</p>
                        <p class="font-bold text-sm">x{{ $products['quantity'] }}</p>
                    </div>
                </div>
                <div class="w-3/12 flex flex-col items-center">
                    <p class="font-bold text-xl">{{$products['price']}}</p>
                    <a href="{{ route('dashboard') }}">
                        <button type="submit" class="bg-[#41b547] w-full text-white font-bold py-2 px-8 rounded-xl mt-4 mx-auto">Buy again</button>
                    </a>
                </div>
            </div>
            @endforeach
    @endif
</x-app-layout>
