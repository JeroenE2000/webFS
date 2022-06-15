@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="content-container text-center">
            @foreach($dishes as $dish)
                    @foreach($dish->Discounts()->get() as $sale)
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{$dish->name}}</h5>
                                    <p class="card-text">{{$dish->description}}</p>
                                    <p class="card-text"><del>{{number_format($dish->price, 2, '.', ',')}}</del></p>
                                    <p class="card-text">€ {{number_format($dish->price*(1-($sale->discount/100)), 2, '.', ',')}}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
            @endforeach
        </div>
    </div>
</div>
@endsection
