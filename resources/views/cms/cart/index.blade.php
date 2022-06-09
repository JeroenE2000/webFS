@extends('layouts.cms')

@section('content')

@if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        @elseif($message = Session::Get('warning'))
        <div class="alert alert-warning">
            <p>{{ $message }}</p>
        </div>
    @endif
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<span class="success" style="color:green; margin-top:10px; margin-bottom: 10px;"></span>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                        <h3 class="card-title">Bestelling maken</h3>
                        </div>
                        <form id ="formOrdering" action="" method="post">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div class="hidden-scrollbar">
                                        <table id="orderList" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>id</th>
                                                    <th>naam</th>
                                                    <th>prijs</th>
                                                    <th>opmerking</th>
                                                    <th>aantal</th>
                                                    <th>update</th>
                                                    <th>remove</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($cartItems as $item)
                                                <tr>
                                                    <td>{{$item->id}}</td>
                                                    <td>{{$item->name}}</td>
                                                    <td>{{$item->price}}</td>
                                                    <td></td>
                                                    <form action="{{ route('cart.update') }}" method="POST">
                                                        @csrf
                                                        <td>
                                                            <input name="amount" value="{{$item->quantity}}" type="number">
                                                            <input type="hidden" name="id" value="{{ $item->id}}" >
                                                        </td>
                                                        <td>
                                                            <button type="submit" class="btn btn-success md-4">update</button>
                                                        </td>
                                                    </form>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="float-left">
                                        Totaal
                                    </div>
                                    <div class="float-right">
                                        <span id="totalPRICE">€ 0,00</span>
                                    </div>
                                </div>
                                <div class="card-footer align-self-end ">
                                    <button type="submit" id = "submitBtn" class="btn btn-success">Afrekenen</button>
                                    <button type="submit" id = "btnRemove" class="btn btn-danger">Verwijderen</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>
@endsection


