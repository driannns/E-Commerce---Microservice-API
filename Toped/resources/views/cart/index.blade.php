<x-app-layout>
    <div class="flex items-center pl-16" style="height: 15vh;">
        <img class="w-2/12" src="/assets/logo.png" alt="">
        <h1 class="text-2xl font-bold">Keranjang Belanja</h1>
    </div>

    @if(count($cart) == 0)
    <div class="grid place-items-center" style="height: 80vh;">
        <img src="/assets/nocart.jpg" alt="No Cart">
    </div>
    @else
    <form action="{{ route('checkout') }}" method="post">
        @csrf
        @method('patch')
        <div class="w-full min-h-screen">
            @foreach ($product as $products)

            <div class="w-10/12 mx-auto border p-4 flex items-center justify-evenly">
                <div class="flex items-center gap-3 w-3/12">
                    <div class="w-36 h-36 rounded-lg"
                        style="background-image: url(''); background-size: contain; background-repeat: no-repeat; background-position: center">
                    </div>
                    <div class="">
                        <p>{{ $products->product_name }}</p>
                        <p>{{ $products->category }}</p>
                    </div>
                </div>
                <div class="w-3/12">
                    @currency($products->price)
                </div>
                <div class="w-3/12">
                    <div class="flex justify-center items-center">
                        <button class="border-2 p-2 w-10 h-10" type="button"
                            onclick="decrementNumber('{{ $products->id }}')">-</button>
                        <input class="font-bold w-20 text-center" type="text" id="myNumber{{$products->id}}"
                            name="myNumber{{$products->id}}" value="1" min="1" readonly>
                        <button class="border-2 p-2 w-10 h-10" type="button"
                            onclick="incrementNumber('{{ $products->id }}')">+</button>
                    </div>
                </div>
                <div class="w-1/12">
                    <a href="{{ route('cart.removeCart', $products->id) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-10 h-10">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                    </a>
                </div>
            </div>
    
            @endforeach

            <div class="w-10/12 mx-auto flex justify-end">
                <button type="submit" class="bg-[#41b547] text-white font-bold px-7 py-2 rounded-xl mt-4">Check
                    Out</button>
            </div>
        </div>
    </form>

    @endif
    <script>
        function incrementNumber(itemId) {
            var currentNumber = parseInt(document.getElementById('myNumber' + itemId).value);
            document.getElementById('myNumber' + itemId).value = currentNumber + 1;

            console.log('myNumber' + itemId);
            console.log(currentNumber);
        }

        function decrementNumber(itemId) {
            var currentNumber = parseInt(document.getElementById('myNumber' + itemId).value);
            if (currentNumber > 1) {
                document.getElementById('myNumber' + itemId).value = currentNumber - 1;
                console.log(currentNumber);
            }
        }

    </script>
</x-app-layout>
