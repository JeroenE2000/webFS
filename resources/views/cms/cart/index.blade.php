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
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                        <h3 class="card-title">Winkelmandje</h3>
                        </div>
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
                                                    <form action="{{ route('cart.update') }}" method="POST">
                                                        @csrf
                                                        <td>
                                                            <input name="description" value="{{$item->description}}" type="text">
                                                        </td>
                                                        <td>
                                                            <input name="quantity" value="{{$item->quantity}}" type="number">
                                                            <input type="hidden" name="id" value="{{ $item->id}}" >
                                                        </td>
                                                        <td>
                                                            <button type="submit" class="btn btn-success md-4">update</button>
                                                        </td>
                                                    </form>
                                                    <form action="{{ route('cart.remove') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" value="{{ $item->id }}" name="id">
                                                        <td>
                                                            <button type="submit" class="btn btn-success md-4">remove</button>
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
                                        <span id="totalPRICE">${{ Cart::getTotal() }}</span>
                                    </div>
                                </div>
                                <div class="card-footer align-self-end ">
                                    <form action="{{ route('cart.checkout') }}" method="POST">
                                        @csrf
                                        <label for="tabelnumber">Tafelnummer</label>
                                        <select class="form-control" name="table_id" id="table_id">
                                            <option value=""></option>
                                            @foreach($tables as $t)
                                                <option value="{{$t->id}}">{{$t->id}}</option>
                                            @endforeach
                                        </select>
                                        <br>
                                        <button type="submit" id = "submitBtn" class="btn btn-success">Afrekenen</button>
                                    </form>
                                    <form action="{{ route('cart.clearAllCart') }}" method="POST">
                                        @csrf
                                        <button type="submit" id="btnRemove" class="btn btn-danger">Verwijderen</button>
                                    </form>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
    </section>
@endsection


