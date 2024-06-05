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
    <section class="hero-section bg-gradient-to-b from-blue-500 to-indigo-600 py-48 text-white">
        <div class="container mx-auto text-center">
            <h2 class="text-4xl font-semibold mb-8">Take a Look at our Partners</h2>
        </div>
    </section>
    <!-- Hero section end -->

    <!-- Service section -->
    <section class="service-section py-16 bg-white">
        <div class="container mx-auto">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
                <div class="bg-gray-100 rounded-lg p-6">
                    <img src="{{ asset('frontend/img/download.png') }}" alt="" width="70%">

                </div>
                <div class="bg-gray-100 rounded-lg p-6">
                    <img src="{{ asset('frontend/img/prime.jpg') }}" alt="" width="70%">

                </div>

            </div>
        </div>
    </section>

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
