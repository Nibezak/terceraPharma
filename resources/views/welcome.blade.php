@extends('layouts.frontend')
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
@section('seo')
    <title>Welcome To | Tercera</title>
    <meta charset="UTF-8">
    <meta name="description" content="Tercera - Your Trusted Online Pharmacy">
    <meta name="keywords" content="Tercera, Pharmacy, Online Pharmacy, Medicine Delivery">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="assets/css/styles.css">
@endsection
<!-- Add this inside the <head> section of your document -->
<style>
    @keyframes gradient-bg {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    .bg-gradient-animated {
        background: linear-gradient(270deg, #48bb78, #6a11cb, #2575fc, #3b82f6, #f56565, #f6ad55, #48bb78);
        background-size: 600% 600%;
        animation: gradient-bg 15s ease infinite;
    }
</style>

@section('content')
    <!--========== SCROLL TOP ==========-->
    <a href="#" class="scrolltop" id="scroll-top">
        <i class='bx bx-up-arrow-alt scrolltop__icon'></i>
    </a>

    <main class="l-main ">
        <!--========== HOME ==========-->
        <section class="home  font-sans bg-gradient-animated py-4" id="home">
            <div class="home__container md:-mt-24 bd-container bd-grid ">
                <div class="home__img">
                    <img src="assets/img/home.png" alt="" class="">
                </div>

                <div class="home__data">
                    <h3 class="home__title text-gray-200 font-sans text-md" style="font-size:40px;">Medicine at affordable
                        prices</h3>
                    <p class="home__description text-gray-100 font-sans font-semibold">In these end of the year holidays
                        send a gift to
                        your loved
                        one
                        and
                        share the happiness at Christmas.</p>
                    <a href="/categories" class="button shadow-md">Shop now 🛍️</a>
                </div>
            </div>
        </section>


        <!--========== FEATURE ==========-->

        <section class="decoration section bd-container md:-mt-10" id="decoration">
            <div class="decoration__container bd-grid">
                <div class="decoration__data">
                    <center>
                        <img src="assets/img/decoration1.png" alt="" class="w-1/2 my-6 decoration__img">
                    </center>
                    <h3 class="decoration__title">Affordable</h3>
                    <a href="/categories" class="button button-link">Shop Now</a>
                </div>

                <div class="decoration__data">
                    <center>
                        <img src="assets/img/decoration2.png" alt="" class="w-1/2 my-6 decoration__img">
                    </center>
                    <h3 class="decoration__title">Delivery</h3>
                    <a href="/categories" class="button button-link">Shop Now</a>
                </div>

                <div class="decoration__data">
                    <center>
                        <img src="assets/img/decoration3.png" alt="" class="w-1/2 my-6 decoration__img">
                    </center>
                    <h3 class="decoration__title">24/7</h3>
                    <a href="/categories" class="button button-link">Shop Now</a>
                </div>
            </div>
        </section>


        <!--========== SHARE ==========-->
        <section class="share section bd-container" id="share">
            <div class="share__container bd-grid">
                <div class="share__data">
                    <h2 class="section-title-center">Reliable Medicine Delivery <br> to Your Home</h2>
                    <p class="share__description">Tercera ensures that you get your essential medicines conveniently and
                        swiftly.</p>
                    <a href="/categories" class="button">Order Now</a>
                </div>

                <div class="share__img">
                    <img src="assets/img/shared.png" alt="Medicine Delivery">
                </div>
            </div>
        </section>



        <!--========== ACCESSORIES ==========-->
        <section class="accessory section bd-container" id="accessory">
            <h2 class="section-title">Products & Accessories </h2>

            <div class="accessory__container bd-grid ">
                @foreach ($products as $p)
                    <div class="accessory__content">
                        <center>
                            <a href="{{ route('single-product', $p->slug) }}">
                                @if ($p->photos->count() > 0)
                                    <img src="/storage/{{ $p->photos->first()->images }} " alt=""
                                        class="accessory__img">
                                @else
                                    <img src="{{ asset('frontend/img/no-image.png') }}" alt=""
                                        class="accessory__img">
                                @endif
                            </a>
                        </center>

                        <a href="{{ route('single-product', $p->slug) }}">
                            <h3 class="accessory__title">{{ $p->name }}</h3>
                        </a>
                        <span class="accessory__category">{{ $p->category['name'] }}</span>
                        <span class="accessory__preci">rwf{{ $p->price }}</span>
                        <div class="pi-links">
                            <form action="{{ route('cart.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $p->id }}">
                                <input type="hidden" name="name" value="{{ $p->name }}">
                                <input type="hidden" name="price" value="{{ $p->price }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="add-card"><i class="flaticon-bag"></i><span>ADD TO
                                        CART</span></button>
                            </form>
                            <form action="{{ route('wishlist.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $p->id }}">
                                <input type="hidden" name="name" value="{{ $p->name }}">
                                <input type="hidden" name="price" value="{{ $p->price }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="wishlist-btn"><i class="flaticon-heart"></i></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

        </section>

        <!--========== SEND GIFT ==========-->
        <section class="send section">
            <div class="send__container bd-container bd-grid">
                <div class="send__content">
                    <h2 class="section-title-center send__title">Send Medicines</h2>
                    <p class="send__description">To send you medicine , Please checkout our store , and buy some products .
                    </p>
                    <form action="">
                        {{-- <input type="text" placeholder="Recipient's Address" class="send__input"> --}}
                        <a href="/categories" class="button">Checkout</a>
                    </form>
                </div>

                <div class="send__img">
                    <center>
                        <img src="assets/img/send.png" alt="" class="w-1/2">
                    </center>
                </div>
            </div>
        </section>
    </main>



    <!--========== SCROLL REVEAL ==========-->
    <script src="https://unpkg.com/scrollreveal"></script>

    <!--========== MAIN JS ==========-->
    <script src="assets/js/main.js"></script>
@endsection
