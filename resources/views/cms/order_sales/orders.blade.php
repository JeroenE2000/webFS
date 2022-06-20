@extends('layouts.cms')

@section('content')

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif
<section class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12 col-sm-12">
            <div class="card">
               <div class="card-header">
                  <h3 class="card-title">Bestellingen</h3>
               </div>
               <div class="card-body">
                <div class="table-responsive">
                    <form action="{{ route('orders.betweenDates.post') }}" method="post">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-12 col-sm-12">
                                <div class="form-group">
                                    <label for="start_time">Start datum</label>
                                    <input type="date" class="form-control" id="start_time" name="start_time">
                                </div>
                            </div>
                            <div class="col-12 col-sm-12">
                                <div class="form-group">
                                    <label for="end_time">Eind datum</label>
                                    <input type="date" class="form-control" id="end_time" name="end_time">
                                </div>
                            </div>
                            <div class="col-12 col-sm-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Zoek</button>
                                </div>
                            </div>
                    </form>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Gerecht</th>
                                <th>Amount</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        @if($orders != null)

                        <tbody>
                                @foreach ($orders as $order)
                                    @foreach($order->dishes as $dish)
                                        <tr>
                                            <td>{{ $dish->name }}</td>
                                            <td>{{ $dish->pivot->amount }}</td>
                                            <td>&euro; {{ $dish->pivot->price }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                <tr>
                                    <td>Totaal</td>
                                    <td></td>

                                </tr>
                        </tbody>
                    </table>
                        <p>Totale prijs: &euro; {{ $totalprice }}<p>
                        <p>Btw: &euro; {{ number_format((($totalprice / 121) * 21 ),2)}}<p>
                        <p>Excusief BTW: &euro; {{ number_format((($totalprice / 121) * 100),2 )}}<p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
