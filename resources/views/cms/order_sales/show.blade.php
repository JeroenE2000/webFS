@extends('layouts.cms')
@section('content')

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    {{-- show the dishes of the order --}}
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Bestellingen van order {{$singleOrder->order_time}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div>
                                    <a href="{{route('orders.index')}}" class="float-right btn btn-primary">Terug</a>
                                    <h2>Tafelnummer: {{$singleOrder->table_id}}</h2>
                                    <p>Besteld op: {{$singleOrder->order_time}}</p>
                                </div>
                                <div>
                                    <table id="table_id" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Gerecht</th>
                                                <th>Opmerking</th>
                                                <th>Aantal</th>
                                                <th>Prijs</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order->dishes as $dish)
                                                <tr>
                                                    <td>{{$dish->name}}</td>
                                                    <td>{{$dish->pivot->notation}}</td>
                                                    <td>{{$dish->pivot->amount}}</td>
                                                    <td>{{$dish->pivot->price}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Gerecht</th>
                                                <th>Opmerking</th>
                                                <th>Aantal</th>
                                                <th>Prijs</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
