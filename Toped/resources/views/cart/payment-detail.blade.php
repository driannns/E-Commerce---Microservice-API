<x-app-layout>
    <div class="flex items-center pl-16" style="height: 15vh;">
        <img class="w-2/12" src="/assets/logo.png" alt="">
        <h1 class="text-2xl font-bold">Payment Detail</h1>
    </div>

    <div class="w-full bg-white min-h-screen pb-10">
        @php
        $totalPrice = 0;
        $totalWeight = 0;
        @endphp
        <form action="{{ route('storeOrder') }}" method="post">
            @csrf
            <div class="w-7/12 border mx-auto p-3 m-10">
                <h1 class="font-bold text-xl">Detail Product</h1>
                @foreach($product as $products)
                <div class="w-full mx-autop-4 flex items-center justify-evenly">
                <div class="flex items-center gap-3 w-3/12">
                    <div class="w-36 h-36 rounded-lg"
                        style="background-image: url('{{ asset('storage/posts/' . $products['foto']) }}'); background-size: contain; background-repeat: no-repeat; background-position: center">
                    </div>
                    <div class="">
                        <p>{{ $products['product_name'] }}</p>
                        <p class="font-bold">{{ $products['category'] }}</p>
                    </div>
                </div>
                <div class="w-3/12">
                    @php
                    $price = $products['price'] * $products['quantity'];
                    $totalPrice += $price;
                    @endphp
                    <input readonly type="text" name="price{{ $products['id'] }}" value="@currency($price)" class="border-0 focus:ring-0 bg-transparent">
                </div>
                <div class="w-3/12">
                    <div class="flex justify-center items-center gap-2">
                        <p>Quantity:</p>
                        <input readonly type="text" name="quantity{{ $products['id'] }}" value="{{ $products['quantity'] }}" class="border-0 focus:ring-0 bg-transparent">
</div>
                </div>
                @php
                $weight = $products['weight'] * $products['quantity'];
                $totalWeight += $weight;
                @endphp
                <div class="w-3/12">
                    <div class="flex justify-center items-center gap-2">
                        <p>Total Weight :</p>
                        <p>{{ $weight }} gram</p>
                        <input type="hidden" name="weight" value="{{$totalWeight}}">
                    </div>
                </div>
            </div>
            @endforeach
            <div class="mt-3">
                <h1 class="font-bold text-xl my-2">Shipping</h1>
                <div class="flex gap-3">
                    <div class="">
                        <div class="flex items-center gap-1">
                            <p class="w-3/12">From : </p>
                            <input readonly type="text" name="origin" value="{{ $costsOrigin['city_name']}}" class="border-0 focus:ring-0 bg-transparent">
                        </div>
                        <div class="flex items-center gap-1">    
                            <p class="w-3/12">To : </p>
                            <input readonly type="text" name="destination" value="{{ $costsDestination['city_name']}}" class="border-0 focus:ring-0 bg-transparent">
                        </div>
                    </div>
                    <div class="w-8/12">
                        <div class="flex items-center gap-1">
                            <p class="w-2/12">Courier :</p>
                            <input readonly type="text" name="courier" value="{{ $costs['name']}}" class="w-full border-0 focus:ring-0 bg-transparent">
                        </div>
                        
                        <p>Shipping Price : <span>@currency($costs['costs'][0]['cost'][0]['value'])</span></p>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <h1 class="font-bold text-xl my-2">Payment</h1>
                <div class="flex gap-3">
                    <div class="">
                        <p>Product Price : @currency($totalPrice)</p>
                        <p>Shipping Price : @currency($costs['costs'][0]['cost'][0]['value'])</p>
                        @php
                        $totalPayment = $totalPrice + $costs['costs'][0]['cost'][0]['value']
                        @endphp
                        <p>Total Payment : @currency($totalPayment) </p>
                        <div class="flex items-center gap-1">
                            <p>Payment Method :</p>
                            <input readonly type="text" name="paymentMethod"  value="{{ $paymentMethod }}" class="focus:border-0  focus:border-none border-none focus:ring-0  focus:ring-none bg-transparent">
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3 flex justify-center">
                <button type="submit" class="bg-[#41b547] text-white font-bold w-9/12 py-2 rounded-xl mt-4 mx-auto">Checkout</button>
            </div>
        </form>
        </div>
    </div>
</x-app-layout>
