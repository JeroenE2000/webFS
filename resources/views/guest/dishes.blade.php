@extends('layouts.app')

@section('content')
<div class="content-container">
    <div class="d-flex justify-content-center row" id="app">
        <div class="row mt-5">
            <div class="col px-4">
                <div class="col px-4">
                    <a href="{{url('/categories')}}" class="btn border border-3 border-dark">Terug</a>
                </div>
                <h1 class="col text-center">{{$category->name}}</h1>
            </div>
        </div>
        @foreach($dishes as $dish)
            <dish-component :sales = "{{json_encode($sales)}}" :dish = "{{$dish->toJson()}}" :allergens = "{{$dish->Allergies()->get()->toJson()}}"></dish-component course="@json($dish)">
        @endforeach
    </div>
</div>
<a href="{{url('/shopping_cart')}}" title="Ga naar winkelwagen" class="btn btn-primary btn-lg shopping-cart">
    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-cart"
    viewBox="0 0 16 16">
   <path
       d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
</svg>
Bestelling</a>
<script>
    window.myArray= @json($dishes->values()->all())
</script>
<script src="{{ asset('js/order.js') }}"></script>

@endsection
