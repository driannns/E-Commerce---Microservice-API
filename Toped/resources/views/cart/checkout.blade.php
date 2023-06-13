<x-app-layout>
    <div class="flex items-center pl-16" style="height: 15vh;">
        <img class="w-2/12" src="/assets/logo.png" alt="">
        <h1 class="text-2xl font-bold">Checkout</h1>
    </div>

    <form class="w-full" action="{{ route('detailPayment') }}" method="post">
        @csrf
        <div class="w-full mt-5">
            <div class="w-10/12 flex items-center gap-4 mx-auto border p-3">
                <div class="">
                    <h1 class="font-bold text-2xl text-[#41b547]">Alamat Pengiriman</h1>
                    <p>{{ Auth::user()->name }}</p>
                </div>
                <div class="w-full">
                    <x-input-label for="address" :value="__('Address')" />
                    <x-text-input id="address" class="block w-full mt-1" type="text" name="address"
                        placeholder="Address..." :value="old('address')" required autofocus autocomplete="address" />
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>
                <div class="w-full mt-1">
                    <x-input-label for="city" :value="__('City')" />
                    <select id="city" name="city" required
                        class="w-full mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                        <option selected>Choose City</option>
                        @foreach ($city as $data)
                        <option value="{{ $data->city_id }}">{{ $data->city_name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('city')" class="mt-2" />
                </div>
            </div>

            <div class="w-full mt-10">
                <div class="w-10/12 mx-auto">

                    <h1>Products ordered</h1>
                    @php
                    $totalPrice = 0;
                    $totalWeight = 0;
                    @endphp
                    @foreach($product as $products)
                    <div class="w-full mx-auto border p-4 flex items-center justify-evenly">
                        <div class="flex items-center gap-3 w-3/12">
                            <div class="w-36 h-36 rounded-lg"
                                style="background-image: url('{{ asset('storage/posts/' . $products['foto']) }}'); background-size: contain; background-repeat: no-repeat; background-position: center">
                            </div>
                            <div class="">
                                <p>{{ $products['product_name'] }}</p>
                                <p>{{ $products['category'] }}</p>
                            </div>
                        </div>
                        <div class="w-3/12">
                            @php
                                $price = $products['price'] * $products['quantity'];
                                $totalPrice += $price;
                            @endphp
                            @currency($price)
                        </div>
                        <div class="w-3/12">
                            <div class="flex justify-center items-center gap-2">
                                <p>Quantity:</p>
                                <p>{{ $products['quantity'] }}</p>
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
                </div>
            </div>

            <div class="w-full mt-10">
                <div class="w-10/12 mx-auto border p-3">
                    <h1>Shipping</h1>
                    <div class="w-full mt-1">
                        <x-input-label for="code" :value="__('Choose a courier')" />
                        <select id="code" name="code" required
                            class="w-full mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                            <option value="">Choose a courier</option>
                            <option value="jne">JNE</option>
                            <option value="pos">POS Indonesia</option>
                            <option value="tiki">TIKI</option>
                        </select>
                        <x-input-error :messages="$errors->get('code')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="w-full mt-10">

                <div class="w-10/12 mx-auto border p-3">
                    <h1>Payment</h1>
                    <div class="w-full mt-1">
                        <p class="font-bold mb-3">@currency($totalPrice)</p>
                        <p class="font-bold mb-3">Choose Payment Method</p>
                        <ul class="items-center w-full text-base bg-white border border-gray-200 rounded-lg sm:flex">
                            <li class="w-2/12">
                                <div class="flex flex-col items-center pl-3 pb-5">
                                    <label for="horizontal-list-radio-license"
                                        class="w-full py-3 text-center font-black text-gray-900 dark:text-gray-300">GOPAY
                                    </label>
                                    <input id="horizontal-list-radio-license" type="radio" value="GOPAY"
                                        name="paymentMethod" checked
                                        class="w-4 h-4 text-[#42d48e] bg-gray-100 border-gray-300 focus:ring-[#42d48e] focus:ring-2">
                                </div>
                            </li>
                            <li class="w-2/12">
                                <div class="flex flex-col items-center pl-3 pb-5">
                                    <label for="horizontal-list-radio-id"
                                        class="w-full py-3 text-center font-black text-gray-900 dark:text-gray-300">OVO
                                    </label>
                                    <input id="horizontal-list-radio-id" type="radio" value="OVO" name="paymentMethod"
                                        class="w-4 h-4 text-[#42d48e] bg-gray-100 border-gray-300 focus:ring-[#42d48e] focus:ring-2">
                                </div>
                            </li>
                            <li class="w-2/12">
                                <div class="flex flex-col items-center pl-3 pb-5">
                                    <label for="horizontal-list-radio-millitary"
                                        class="w-full py-3 text-center font-black text-gray-900 dark:text-gray-300">DANA
                                    </label>
                                    <input id="horizontal-list-radio-millitary" type="radio" value="DANA"
                                        name="paymentMethod"
                                        class="w-4 h-4 text-[#42d48e] bg-gray-100 border-gray-300 focus:ring-[#42d48e] focus:ring-2">
                                </div>
                            </li>
                            <li class="w-2/12">
                                <div class="flex flex-col items-center pl-3 pb-5">
                                    <label for="horizontal-list-radio-passport"
                                        class="w-full py-3 font-black text-gray-900 dark:text-gray-300 text-center">COD
                                    </label>
                                    <input id="horizontal-list-radio-passport" type="radio" value="COD"
                                        name="paymentMethod"
                                        class="w-4 h-4 text-[#42d48e] bg-gray-100 border-gray-300 focus:ring-[#42d48e] focus:ring-2">
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="w-full mt-10 flex justify-center pb-10">
                <button type="submit" class="bg-[#41b547] text-white font-bold w-9/12 py-2 rounded-xl mt-4 mx-auto">Make
                    Order</button>
            </div>
    </form>
    </div>
</x-app-layout>
