@extends('layouts.app')

@section('content')
<div class="content-container">
    <div class="d-flex justify-content-center row" id="app">
        <div class="row mt-5">
            <div class="col px-4">
                <div class="col px-4">
                    <a href="{{url('/order/categories')}}" class="btn border border-3 border-dark">Terug</a>
                </div>
                <h1 class="col text-center">{{$category->name}}</h1>
            </div>
        </div>
        @foreach($dishes as $dish)
            <dish-component :sales = "{{json_encode($sales)}}" :dish = "{{$dish->toJson()}}" :allergens = "{{$dish->Allergies()->get()->toJson()}}"></dish-component course="@json($dish)">
        @endforeach
    </div>
</div>
<script>
    window.myArray= @json($dishes->values()->all())
</script>
<script src="{{ asset('js/order.js') }}"></script>

@endsection
