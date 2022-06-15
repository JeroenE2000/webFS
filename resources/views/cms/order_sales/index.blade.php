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
                    <table id="table_id" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Tafelnummer</th>
                                <th>Order Time</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{$order->table_id}}</td>
                                    <td>{{$order->order_time}}</td>
                                    <td><a id="show{{$order->id}}" class="btn btn-success" href="{{ route('orders.show',$order) }}">Details</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Tafelnummer</th>
                                <th>Order Time</th>
                                <th>Details</th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="mt-4">
                        {!! $orders->links('pagination::bootstrap-4')!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
