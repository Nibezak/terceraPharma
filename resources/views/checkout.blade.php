@extends('layouts.frontend')

@section('seo')
    <title>{{ $systemInfo->name }} | Checkout</title>
    <meta charset="UTF-8">
    <meta name="description" content="{{ $systemInfo->description }}">
    <meta name="keywords" content="{{ $systemInfo->description }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
.checkout-section .cf-title {
    font-size: 1.5rem;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.info-text {
    font-weight: 600;
    color: #555;
}

.payment-icon {
    width: 40px;
    margin-left: 10px;
}

.product-item {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

.pl-thumb {
    width: 60px;
    height: 60px;
    margin-right: 10px;
}

.product-info {
    flex: 1;
}

.scan-to-pay {
    margin-top: 20px;
    padding: 15px;
    background-color: #f9f9f9;
    text-align: center;
    border-radius: 5px;
}

.scan-to-pay h4 {
    font-size: 1.3rem;
    margin-bottom: 10px;
}

.qr-code {
    width: 150px;
    height: 150px;
}

        </style>
@endsection

@section('content')
    <!-- Checkout Section -->
    <section class="checkout-section spad">
        <div class="container">
            <div class="row">
                <!-- Billing Form -->
                <div class="col-lg-8 order-2 order-lg-1">
                    <form class="checkout-form" action="{{ route('checkout.store') }}" method="post">
                        @csrf
                        <h4 class="cf-title">Billing Address</h4>
                        <div class="row">
                            <div class="col-md-7">
                                <p class="info-text">*Billing Information</p>
                            </div>
                            <div class="col-md-5">
                                <div class="cf-radio-btns">
                                    <div class="cfr-item">
                                        <input type="radio" name="pm" id="one" checked>
                                        <label for="one">Use my regular address</label>
                                    </div>
                                    <div class="cfr-item">
                                        <input type="radio" name="pm" id="two">
                                        <label for="two">Use a different address</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Address Inputs -->
                        <div class="row address-inputs">
                            <div class="col-md-6">
                                <input type="text" name="billing_fullname" placeholder="Full Name" value="{{ auth()->user()->name }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="billing_email" placeholder="Email" value="{{ auth()->user()->email }}">
                            </div>
                            <div class="col-md-12">
                                <input type="text" name="billing_address" placeholder="Address" value="{{ auth()->user()->address }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="billing_city" placeholder="City" value="{{ auth()->user()->city }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="billing_province" placeholder="Province or State" value="{{ auth()->user()->province }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="billing_zipcode" placeholder="Zip code" value="{{ auth()->user()->zipcode }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="billing_phone" placeholder="Phone no." value="{{ auth()->user()->phone }}">
                            </div>
                            <div class="col-md-12">
                                <input type="text" name="notes" placeholder="MTN Momo Transaction Code" value="{{ auth()->user()->notes }}">
                            </div>
                        </div>

                        <!-- Payment Section -->
                        <h4 class="cf-title">Payment</h4>
                        <ul class="payment-list">
                            <li>
                                <input type="radio" name="payment_method" value="momo" checked>
                                MTN Momo <img src="{{ asset('frontend/img/mtnlogo.png') }}" alt="MTN Logo" class="payment-icon">
                            </li>
                            <li>
                                <input type="radio" name="payment_method" value="cash_on_delivery">
                                Pay at delivery
                            </li>
                        </ul>
                        <button type="submit" class="site-btn submit-order-btn">Place Order</button>
                    </form>
                </div>

                <!-- Cart Summary and Scan to Pay -->
                <div class="col-lg-4 order-1 order-lg-2">
                    <div class="checkout-cart">
                        <h3>Your Cart</h3>
                        <ul class="product-list">
                            @foreach (Cart::content() as $item)
                                <li class="product-item">
                                    <div class="pl-thumb">
                                        <img src="{{ $item->model->photos->count() > 0 ? '/storage/' . $item->model->photos->first()->images : asset('frontend/img/no-image.png') }}" alt="">
                                    </div>
                                    <div class="product-info">
                                        <h6>{{ $item->model->name }}</h6>
                                        <p>RWF {{ $item->subtotal }}</p>
                                        <p>Qty: {{ $item->qty }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <ul class="price-list">
                            <li>Total<span>RWF {{ $newSubtotal }}.00</span></li>
                            <li class="total">Total<span>RWF {{ $newTotal }}.00</span></li>
                        </ul>
                    </div>

                    <!-- Scan to Pay Section -->
                    <div class="scan-to-pay">
                        <h4>Scan to Pay</h4>
                        <center>
                        <p>Use your mobile camera to scan & complete your payment.</p>
                        <img src="{{ asset('assets/qr-code.png') }}" alt="QR Code" class="qr-code">
                        </center>
                        
                        <p>Powered by Payflow.</p>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
