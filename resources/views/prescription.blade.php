@extends('layouts.frontend')

<title>Prescription</title>
<meta charset="UTF-8">
<meta name="description" content="Login">
<meta name="keywords" content="login, sign">
<meta name="viewport" content="width=device-width, initial-scale=1.0">


@section('css')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

@section('content')
    <!-- Page info -->
    <div class="page-top-info">
        <div class="container">
            <h4>Prescription</h4>
            <div class="site-pagination">
                <a href="/">Home</a> /
                <a href="">Prescription</a>
            </div>
        </div>
    </div>
    <!-- Page info end -->


    <!-- Contact section -->
    <section class="contact-section">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Added justify-content-center class to align content in the middle -->
                <div class="col-lg-6 contact-info">
                    <h3 class="text-center">You have a Doctor's Prescription ?</h3>
                    <!-- Added text-center class to center align the heading -->
                    <!-- flash success messages -->
                    @if (Session::has('success'))
                        <div class="alert alert-primary" role="alert">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    <!-- contact form area -->
                    <form action="{{ route('store-contact') }}" method="post" class="contact-form">
                        @csrf
                        <!-- name -->
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            id="name" placeholder="Full name" value="{{ old('name') }}">
                        <!-- email -->
                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
                            id="email" placeholder="Your e-mail" value="{{ old('email') }}">
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                            id="phone" placeholder="Your phone" value="{{ old('phone') }}">
                        <!-- subject -->
                        <input type="file" name="image" class="form-control-file @error('image') is-invalid @enderror"
                            id="image" placeholder="Upload Image">


                        <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                            id="address" placeholder="Address" value="{{ old('Address') }}">
                        <!-- message -->
                        <textarea name="message" class="form-control @error('message') is-invalid @enderror" id="message"
                            placeholder="Message">{{ old('message') }}</textarea>
                        <!-- google recaptcha -->
                        @if (config('services.recaptcha.key'))
                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}">
                                </div>
                                @error('g-recaptcha-response')
                                    <span class="invalid-feedback mt-3" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        @endif
                        <button type="submit" class="site-btn">SEND NOW</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
