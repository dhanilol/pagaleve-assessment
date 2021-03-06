@extends('layouts.front.fmaster')


@section('content')

    <div class="container">
        <main>
            <div class="py-5 text-center">
                <img class="d-block mx-auto mb-4" src="https://getbootstrap.com/docs/5.1/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
                <h2>Checkout form</h2>
            </div>
      
            <div class="row g-5">
                <div class="col-md-5 col-lg-4 order-md-last">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-primary">Your cart</span>
                        <span class="badge bg-primary rounded-pill">3</span>
                    </h4>

                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">Product name</h6>
                                <small class="text-muted">Brief description</small>
                            </div>
                            <span class="text-muted">$12</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between bg-light">
                            <div class="text-success">
                                <h6 class="my-0">Promo code</h6>
                                <small>EXAMPLECODE</small>
                            </div>
                            <span class="text-success">−$5</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total (USD)</span>
                            <strong>$20</strong>
                        </li>
                    </ul>
            
                    <form class="card p-2">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Promo code">
                            <button type="submit" class="btn btn-secondary">Redeem</button>
                        </div>
                    </form>
                </div>

                <div class="col-md-7 col-lg-8">
                    <h4 class="mb-3">Billing address</h4>

                    <form action="{{ url("checkout/place-order") }}" class="needs-validation" novalidate="" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label for="firstName" class="form-label">First name</label>
                                <input type="text" name="first_name" class="form-control" id="firstName" placeholder="" value="" required="">
                                <div class="invalid-feedback">
                                    Valid first name is required.
                                </div>
                            </div>
                
                            <div class="col-sm-6">
                                <label for="lastName" class="form-label">Last name</label>
                                <input type="text" name="last_name" class="form-control" id="lastName" placeholder="" value="" required="">
                                <div class="invalid-feedback">
                                    Valid last name is required.
                                </div>
                            </div>
                
                            <div class="col-sm-6">
                                <label for="cpf" class="form-label">CPF</label>
                                <input type="text" name="cpf" class="form-control" id="cpf" placeholder="" value="" required="">
                                <div class="invalid-feedback">
                                    Valid CPF is required.
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label for="mobile-phone" class="form-label">Mobile Phone</label>
                                <input type="text" name="mobile_phone" class="form-control" id="mobile-phone" placeholder="" value="" required="">
                                <div class="invalid-feedback">
                                    Valid mobile phone is required.
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="you@example.com" value="" required="">
                                <div class="invalid-feedback">
                                    Please enter a valid email address for shipping updates.
                                </div>
                            </div>
                

                
                            <div class="col-md-3">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="text" name="dob" class="form-control" id="dob" placeholder="" required="">
                                <div class="invalid-feedback">
                                    Date of Birth is required.
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">
            
                        <h4 class="mb-3">Payment</h4>
            
                        <div class="my-3">
                            <div class="form-check">
                                <input id="credit" name="paymentMethod" type="radio" class="form-check-input" checked="" required="">
                                <label class="form-check-label" for="credit">Credit card</label>
                            </div>
                            <div class="form-check">
                                <input id="debit" name="paymentMethod" type="radio" class="form-check-input" required="">
                                <label class="form-check-label" for="debit">Debit card</label>
                            </div>
                        </div>

                        <hr class="my-4">
                        <input type="hidden" name="cart_value" class="form-control" id="cart-value" value="1">

                        <button type="submit" name="action" value="pay-with-card" class="w-100 btn btn-primary btn-lg">Continue to Payment Method</button>
                        &nbsp;
                        <button type="submit" name="action" value="pay-with-pagaleve" class="w-100 btn btn-primary btn-lg">Pay with pagaleve</button>
                    </form>
                </div>
            </div>
        </main>
    </div>


@endsection