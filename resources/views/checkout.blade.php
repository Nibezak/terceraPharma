@extends('layouts.frontend')

@section('seo')
    <title>{{ $systemInfo->name }} | Checkout</title>
    <meta charset="UTF-8">
    <meta name="description" content="{{ $systemInfo->description }}">
    <meta name="keywords" content="{{ $systemInfo->description }}, {{ $systemInfo->description }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
@endsection

@section('content')
    <!-- checkout section  -->
    <section class="checkout-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 order-2 order-lg-1">
                    <form class="checkout-form" action="{{ route('checkout.store') }}" method="post">
                        @csrf
                        <div class="cf-title">Billing Address</div>
                        <div class="row">
                            <div class="col-md-7">
                                <p>*Billing Information</p>
                            </div>
                            <div class="col-md-5">
                                <div class="cf-radio-btns address-rb">
                                    <div class="cfr-item">
                                        <input type="radio" name="pm" id="one">
                                        <label for="one">Use my regular address</label>
                                    </div>
                                    <div class="cfr-item">
                                        <input type="radio" name="pm" id="two">
                                        <label for="two">Use a different address</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row address-inputs">
                            <div class="col-md-6">
                                <input type="text" name="billing_fullname" placeholder="Full Name"
                                    value="{{ auth()->user()->name }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="billing_email" placeholder="Email"
                                    value="{{ auth()->user()->email }}">
                            </div>
                            <div class="col-md-12">
                                <input type="text" name="billing_address" placeholder="Address"
                                    value="{{ auth()->user()->address }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="billing_city" placeholder="City"
                                    value="{{ auth()->user()->city }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="billing_province" placeholder="Province or State"
                                    value="{{ auth()->user()->province }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="billing_zipcode" placeholder="Zip code"
                                    value="{{ auth()->user()->zipcode }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="billing_phone" placeholder="Phone no."
                                    value="{{ auth()->user()->phone }}">
                            </div>
                            <div class="col-md-12">
                                <input type="text" name="notes"
                                    placeholder="Input the MTN Momo Transaction Code e.g : SDK817900KDB"
                                    value="{{ auth()->user()->notes }}">
                            </div>
                        </div>
                        {{-- <div class="cf-title">Delievery Info</div>
					<div class="row shipping-btns">
						<div class="col-6">
							<h4>Standard</h4>
						</div>
						<div class="col-6">
							<div class="cf-radio-btns">
								<div class="cfr-item">
									<input type="radio" name="shipping" id="ship-1">
									<label for="ship-1">Free</label>
								</div>
							</div>
						</div>
						<div class="col-6">
							<h4>Next day delievery  </h4>
						</div>
						<div class="col-6">
							<div class="cf-radio-btns">
								<div class="cfr-item">
									<input type="radio" name="shipping" id="ship-2">
									<label for="ship-2">$3.45</label>
								</div>
							</div>
						</div> --}}
                        {{-- </div> --}}
                        <div class="cf-title">Payment</div>
                        <ul class="payment-list">
                            {{-- @if (env('PAYPAL_SANDBOX_API_SECRET') != null) --}}
                            {{-- <li>
                                    <input type="radio" name="payment_method" value="paypal">
                                    Paypal<a href="#"><img src="{{ asset('frontend/img/paypal.png') }}"
                                            alt=""></a>
                                </li> --}}

                            <li>
                                <input type="radio" name="payment_method" value="momo">
                                MTN Momo<a href="#"><img src="{{ asset('frontend/img/mtnlogo.png') }}" alt=""
                                        width="50" height="50"></a>
                            </li>
                            {{-- @endif --}}
                            {{-- <li>Credit / Debit card<a href="#"><img src="{{ asset('frontend/img/mastercart.png') }}" alt=""></a>
							</li> --}}
                            <li>
                                <input type="radio" name="payment_method" value="cash_on_delivery">
                                Pay when you get the package
                            </li>

                        </ul>
                        <button type="submit" class="site-btn submit-order-btn">Place Order</button>
                    </form>
                </div>
                <div class="col-lg-4 order-1 order-lg-2">
                    <div class="checkout-cart">
                        <h3>Your Cart</h3>
                        <ul class="product-list">
                            @foreach (Cart::content() as $item)
                                <li>
                                    <div class="pl-thumb">
                                        @if ($item->model->photos->count() > 0)
                                            <img src="/storage/{{ $item->model->photos->first()->images }}" alt="">
                                        @else
                                            <img src="{{ asset('frontend/img/no-image.png') }}" alt="">
                                        @endif
                                    </div>
                                    <h6>{{ $item->model->name }}</h6>
                                    <p>rwf {{ $item->subtotal }}</p>
                                    <p>Qty {{ $item->qty }}</p>
                                </li>
                            @endforeach
                        </ul>
                        <ul class="price-list">
                            <li>Total<span>rwf {{ $newSubtotal }}.00</span></li>
                            <li class="total">Total<span>rwf {{ $newTotal }}.00</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- checkout section end -->
@endsection
