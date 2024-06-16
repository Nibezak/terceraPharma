@extends('layouts.frontend')
@section('content')
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .crediCard.seeBack {
            transform: rotateY(-180deg);
        }
    </style>
    <main class="flex min-h-screen flex-col items-center justify-between p-6 lg:p-24">
        <form class="bg-white w-full max-w-3xl mx-auto px-4 lg:px-6 py-8 shadow-md rounded-md flex flex-col lg:flex-row"
            method="POST" action="/momo-checkout">
            @csrf

            <div class="w-full lg:w-1/2 lg:pr-8 lg:border-r-2 lg:border-slate-300">
                <input
                    class="bg-gray-100 w-full py-1 px-2 rounded-md my-4 border border-4 border-gray-200 text-gray-700 shadow-md"
                    value="{{ $orderNumber }}" name="refNo" />

                <div class="mb-4">
                    <label class="text-neutral-800 font-bold text-sm mb-2 block">Phone Number:</label>
                    <input id="cardNumber" type="text" onclick="hideBackCard()" name="phoneNumber"
                        class="flex h-10 w-full rounded-md border-2 bg-background px-4 py-1.5 text-lg ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:border-purple-600 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 undefined"
                        maxlength="12" placeholder="07 XXX XXXXX" required />
                </div>

                <div class="mb-4">
                    <label class="text-neutral-800 font-bold text-sm mb-2 block">Amount:</label>
                    <input id="cardName" type="text" onclick="hideBackCard()"
                        class="flex h-10 disable w-full rounded-md border-2 bg-gray-300 px-4 py-1.5 text-lg ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:border-purple-600 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 undefined"
                        disabled value="{{ $amount }} rwf" />
                </div>

                <button class="bg-blue-500 text-white rounded-md shadow-lg py-2 px-2" type="submit">Confirm Payment
                </button>

            </div>
            <div class="w-full lg:w-1/2 lg:pl-8">
                <div class="w-full max-w-sm h-56" style="perspective: 1000px">
                    <div id="creditCard" class="relative crediCard cursor-pointer transition-transform duration-500"
                        style="transform-style: preserve-3d" onclick="toggleBackCard()">
                        <div class="w-full h-56 m-auto rounded-xl text-white shadow-2xl absolute"
                            style="backface-visibility: hidden">
                            <img src="https://i.ibb.co/LPLv5MD/Payment-Card-01.jpg"
                                class="relative object-cover w-full h-full rounded-xl" />
                            <div class="w-full px-8 absolute top-8">
                                <div class="text-right right-0 flex justify-end">
                                    <img src="{{ asset('frontend/img/mtnlogo.png') }}" width="30" />
                                </div>
                                <div class="pt-1">
                                    <p class="font-light">Phone Number</p>
                                    <p id="imageCardNumber" class="font-medium tracking-more-wider h-6">

                                    </p>
                                </div>
                                <div class="pt-6 flex justify-between">
                                    <div>
                                        <p class="font-light">Amount</p>
                                        <p id="imageCardName" class="font-medium tracking-widest h-6">
                                            {{ $amount }} rwf
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="w-full h-56 m-auto rounded-xl text-white shadow-2xl absolute"
                            style="backface-visibility: hidden; transform: rotateY(180deg)">
                            <img src="https://i.ibb.co/LPLv5MD/Payment-Card-01.jpg"
                                class="relative object-cover w-full h-full rounded-xl" />
                            <h1 class="text-white">
                                <bold>TERCERA PHARMA</bold>
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <script>
            const toggleBackCard = () => {
                cardEl = document.getElementById("creditCard");
                if (cardEl.classList.contains("seeBack")) {
                    cardEl.classList.remove("seeBack");
                } else {
                    cardEl.classList.add("seeBack");
                }
            };
            const showBackCard = () => {
                cardEl = document.getElementById("creditCard");
                if (!cardEl.classList.contains("seeBack")) {
                    cardEl.classList.add("seeBack");
                }
            };
            const hideBackCard = () => {
                cardEl = document.getElementById("creditCard");
                if (cardEl.classList.contains("seeBack")) {
                    cardEl.classList.remove("seeBack");
                }
            };

            // Handle Card Number update
            const inputCardNumber = document.getElementById("cardNumber");
            const imageCardNumber = document.getElementById("imageCardNumber");

            inputCardNumber.addEventListener("input", (event) => {
                //   Remove all non-numeric characters from the input
                const input = event.target.value.replace(/\D/g, "");

                // Add a space after every 4 digits
                let formattedInput = "";
                for (let i = 0; i < input.length; i++) {
                    if (i % 4 === 0 && i > 0) {
                        formattedInput += " ";
                    }
                    formattedInput += input[i];
                }

                inputCardNumber.value = formattedInput;
                imageCardNumber.innerHTML = formattedInput;
            });

            // Handle CCV update
            const inputCCVNumber = document.getElementById("ccvNumber");
            const imageCCVNumber = document.getElementById("imageCCVNumber");

            inputCCVNumber.addEventListener("input", (event) => {
                // Remove all non-numeric characters from the input
                const input = event.target.value.replace(/\D/g, "");
                inputCCVNumber.value = input;
                imageCCVNumber.innerHTML = input;
            });

            // Handle Exp Date update
            const expirationDate = document.getElementById("expDate");
            const imageExpDate = document.getElementById("imageExpDate");

            expirationDate.addEventListener("input", (event) => {
                // Remove all non-numeric characters from the input
                const input = event.target.value.replace(/\D/g, "");

                // Add a '/' after the first 2 digits
                let formattedInput = "";
                for (let i = 0; i < input.length; i++) {
                    if (i % 2 === 0 && i > 0) {
                        formattedInput += "/";
                    }
                    formattedInput += input[i];
                }

                expirationDate.value = formattedInput;
                imageExpDate.innerHTML = formattedInput;
            });

            // Handle Card Name update
            const inputCardName = document.getElementById("cardName");
            const imageCardName = document.getElementById("imageCardName");

            inputCardName.addEventListener("input", (event) => {
                imageCardName.innerHTML = event.target.value;
            });
        </script>
    </main>
@endsection
