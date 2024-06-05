@extends('layouts.frontend')
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
@section('seo')
    <title>Welcome To | {{ $systemName->name }}</title>
    <meta charset="UTF-8">
    <meta name="description" content="{{ $systemName->description }}">
    <meta name="keywords" content="{{ $systemName->name }}, {{ $systemName->name }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
@endsection

@section('content')
    <!-- Hero section -->
    <section class="hero-section bg-gradient-to-b from-blue-500 to-indigo-600 py-48 text-white"
        style="background-image: url('{{ asset('/frontend/img/pharmacist.jpg') }}'); background-size: cover; background-position: center;">
        <div class="container mx-auto text-center">
            <h2 class="text-4xl font-bold mb-8">Proudly caring for our community</h2>
        </div>
    </section>


    <!-- Hero section end -->

    <!-- Service section -->
    <section class="service-section py-16 bg-white">
        <div class="container mx-auto">
            <center>
                <div class="text-center mb-12 w-9/12">
                    <h3 class="text-3xl font-semibold mb-4">Our Services</h3>
                    <p class="text-lg">Our team does more than fill your medication; at our pharmacy, we provide services
                        and
                        products to our patients in a manner that maximizes our patients' health and communities' welfare.
                    </p>
                </div>
            </center>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-gray-100 rounded-lg p-6">
                    <h4 class="text-xl font-semibold mb-4">Prescription services</h4>

                </div>
                <div class="bg-gray-100 rounded-lg p-6">
                    <h4 class="text-xl font-semibold mb-4">24/7 Refill</h4>

                </div>
                <div class="bg-gray-100 rounded-lg p-6">
                    <h4 class="text-xl font-semibold mb-4">Compounding</h4>

                </div>
                <div class="bg-gray-100 rounded-lg p-6">
                    <h4 class="text-xl font-semibold mb-4">Vitamins & supplements</h4>

                </div>
                <div class="bg-gray-100 rounded-lg p-6">
                    <h4 class="text-xl font-semibold mb-4">Delivery everywhere in Kigali city</h4>

                </div>
                <div class="bg-gray-100 rounded-lg p-6">
                    <h4 class="text-xl font-semibold mb-4">Lyme Disease Consults</h4>

                </div>
            </div>
        </div>
    </section>
    <div class="product-slider owl-carousel">
        @foreach ($products as $p)
            <div class="product-item">
                <div class="pi-pic">
                    @if ($p->on_sale == 1)
                        <div class="tag-sale">ON SALE</div>
                    @endif
                    @if ($p->is_new == 1)
                        <div class="tag-new">New</div>
                    @endif
                    <a href="{{ route('single-product', $p->slug) }}">
                        @if ($p->photos->count() > 0)
                            <img src="/storage/{{ $p->photos->first()->images }} " alt="">
                        @else
                            <img src="{{ asset('frontend/img/no-image.png') }}" alt="">
                        @endif
                    </a>
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
                <div class="pi-text">
                    <h6>rwf {{ $p->price }}</h6>
                    <a href="{{ route('single-product', $p->slug) }}">
                        <p>{{ $p->name }}</p>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    <section class="special-section bg-gray-100 py-16">
        <div class="container mx-auto">
            <div class="text-center mb-12">
                <h3 class="text-3xl font-semibold mb-4">What Makes Us Special?</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <h4 class="text-xl font-semibold mb-4">Delivery <i class="fas fa-truck mx-3" style="color: #2484f2"></i>
                    </h4>
                    <p class="text-lg">Super-fast deliveries within 15 min. </p>
                </div>

                <div class="p-6 bg-white rounded-lg shadow-md">
                    <h4 class="text-xl font-semibold mb-4">Money Back <i class="fas fa-money-bill-wave mx-3"
                            style="color: #2484f2"></i></h4>
                    <p class="text-lg">We promise to give back your money if anything goes wrong</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <h4 class="text-xl font-semibold mb-4">100% Secure <i class="fas fa-shield-alt mx-3"
                            style="color: #2484f2"></i></h4>
                    <p class="text-lg">Every operation made on our platform is 100% secure.</p>
                </div>

            </div>
        </div>
    </section>
    <!-- Special section end -->
@endsection
