@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="content-container text-center">
            @foreach($sales as $sale)
                @foreach($dishes as $d)
                    @if($sale->dishes_id == $d->id)
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{$d->name}}</h5>
                                <p class="card-text">{{$d->description}}</p>
                                <p class="card-text"><del>{{number_format($d->price, 2, '.', ',')}}</del></p>
                                <p class="card-text">€ {{number_format($d->price*(1-($sale->discount/100)), 2, '.', ',')}}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            @endforeach
        </div>
    </div>
</div>
@endsection
