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
                  <h3 class="card-title">Dishes</h3>
               </div>
               <div class="card-body">
                <div class="table-responsive">
                    <table id="table_id" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Dishnumber</th>
                                <th>Naam</th>
                                <th>Discount</th>
                                <th>Start tijd</th>
                                <th>Eind tijd</th>
                                <th>Bijwerken</th>
                                <th>Verwijderen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sales as $sale)
                                @foreach($dishes as $d)
                                    @if($sale->dishes_id == $d->id)
                                    <tr>
                                        <td>{{$d->dishnumber}}</td>
                                        <td>{{$d->name}}</td>
                                        <td>{{$sale->discount}}</td>
                                        <td>{{$sale->start_time}}</td>
                                        <td>{{$sale->end_time}}</td>
                                    @endif
                                @endforeach
                                        <td>
                                            <a id="update{{$d->id}}" class="btn btn-success" href="{{ route('discounts.edit',$sale) }}">Bijwerken</a>
                                        </td>
                                        <td>
                                            <form action="{{ route('discounts.destroy', $sale->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" id="delete{{$sale->id}}" class="btn btn-danger">Verwijderen</button>
                                            </form>
                                        </td>
                                    </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Dishnumber</th>
                                <th>Naam</th>
                                <th>Discount</th>
                                <th>Start tijd</th>
                                <th>Eind tijd</th>
                                <th>Bijwerken</th>
                                <th>Verwijderen</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gerecht korting aanmaken</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('discounts.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="dishes_id">Gerecht</label>
                            <select class="form-control" name="dishes_id" id="dishes_id">
                                @foreach($dishes as $d)
                                <option value="{{$d->id}}">{{$d->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="start_time">Korting</label>
                            <input type="number" class="form-control" name="discount" id="discount">
                        </div>
                        <div class="form-group">
                            <label for="start_time">Start tijd</label>
                            <input type="datetime-local" class="form-control" name="start_time" id="start_time">
                        </div>
                        <div class="form-group">
                            <label for="end_time">Eind tijd</label>
                            <input type="datetime-local" class="form-control" name="end_time" id="end_time">
                        </div>
                        <div class="pull-right md-8 ">
                            <button type="submit" class="btn btn-success md-4">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</section>


@endsection
