<x-store-front-layout :title="__('Checkout')">

    <div class="ps-checkout pt-80 pb-80">
        <div class="ps-container">
            <form class="ps-checkout__form" action="{{ route('checkout') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 ">
                        <div class="ps-checkout__billing">
                            <h3>Billing Detail</h3>
                            <div class="form-group form-group--inline">
                                <x-form-input name="billing_name" :label="__('Name')" />
                            </div>
                            <div class="form-group form-group--inline">
                                <x-form-input name="billing_email" type="email" :label="__('Email Address')" />
                            </div>
                            <div class="form-group form-group--inline">
                                <x-form-input name="billing_phone" :label="__('Phone')" />
                            </div>
                            <div class="form-group form-group--inline">
                                <x-form-input name="billing_address" :label="__('address')" />
                            </div>
                            <div class="form-group form-group--inline">
                                <x-form-input name="billing_city" :label="__('City')" />
                            </div>
                            <div class="form-group form-group--inline">
                                <x-form-select name="billing_country" :label="__('Country')" :options="$countries" />
                            </div>
                            <div class="form-group">
                                <div class="ps-checkbox">
                                    <input class="form-control" type="checkbox" name="create_account" value="1" id="cb01">
                                    <label for="cb01">Create an account?</label>
                                </div>
                            </div>
                            <h3 class="mt-40"> Addition information</h3>
                            <div class="form-group form-group--inline textarea">
                                <label>Order Notes</label>
                                <textarea class="form-control" name="notes" rows="5" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 ">
                        <div class="ps-checkout__order">
                            <header>
                                <h3>Your Order</h3>
                            </header>
                            <div class="content">
                                <table class="table ps-checkout__products">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase">Product</th>
                                            <th class="text-uppercase">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cart->all() as $item)
                                        <tr>
                                            <td>{{ $item->product->name }} x{{ $item->quantity }}</td>
                                            <td>${{ $item->product->price * $item->quantity }}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td>Order Total</td>
                                            <td>${{ $cart->total() }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <footer>
                                <h3>Payment Method</h3>
                                <div class="form-group cheque">
                                    <div class="ps-radio">
                                        <input class="form-control" type="radio" id="rdo01" name="payment" checked>
                                        <label for="rdo01">Cheque Payment</label>
                                        <p>Please send your cheque to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</p>
                                    </div>
                                </div>
                                <div class="form-group paypal">
                                    <div class="ps-radio ps-radio--inline">
                                        <input class="form-control" type="radio" name="payment" id="rdo02">
                                        <label for="rdo02">Paypal</label>
                                    </div>
                                    <ul class="ps-payment-method">
                                        <li><a href="#"><img src="images/payment/1.png" alt=""></a></li>
                                        <li><a href="#"><img src="images/payment/2.png" alt=""></a></li>
                                        <li><a href="#"><img src="images/payment/3.png" alt=""></a></li>
                                    </ul>
                                    <button type="submit" class="ps-btn ps-btn--fullwidth">Place Order<i class="ps-icon-next"></i></button>
                                </div>
                            </footer>
                        </div>
                        <div class="ps-shipping">
                            <h3>FREE SHIPPING</h3>
                            <p>YOUR ORDER QUALIFIES FOR FREE SHIPPING.<br> <a href="#"> Singup </a> for free shipping on every order, every time.</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-store-front-layout>