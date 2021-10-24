@extends('layouts.front.fmaster')


@section('content')

    <div class="container">
        <main>
            <div class="py-5 text-center">
                <img class="d-block mx-auto mb-4" src="https://getbootstrap.com/docs/5.1/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
                <h2>Success</h2>
                <p class="lead">Below is an example form built entirely with Bootstrap’s form controls. Each required form group has a validation state that can be triggered by attempting to submit the form without completing it.</p>

                <a href="{{ url('/checkout') }}" class="w-50 btn btn-info">Back</a>
            </div>
        </main>
    </div>

@endsection