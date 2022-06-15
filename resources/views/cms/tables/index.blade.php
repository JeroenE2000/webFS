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
                                    <th>Tafelnummer</th>
                                    <th>aantal personen</th>
                                    <th>Wijzigen</th>
                                    <th>Verwijderen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tables as $t)
                                <tr>
                                    <td>{{$t->table_number}}</td>
                                    <td>{{$t->guest_amount}}</td>
                                    <td>
                                        <a id="update{{$t->id}}" class="btn btn-success" href="{{ route('tables.edit',$t) }}">Bijwerken</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('tables.destroy', $t->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" id="delete{{$t->id}}" class="btn btn-danger">Verwijderen</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Tafelnummer</th>
                                    <th>aantal personen</th>
                                    <th>Wijzigen</th>
                                    <th>Verwijderen</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tafel aanmaken</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('tables.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tafelnummer</label>
                            <input type="text" class="form-control" name="table_number" id="table_number" placeholder="TafelNummer">
                        </div>
                        <div class="form-group">
                            <label for="price">Plaats</label>
                            <input type="text" class="form-control" name="guest_amount" id="guest_amount" placeholder="Plaats">
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
