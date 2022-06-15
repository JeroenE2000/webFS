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
                  <h3 class="card-title">Categorieen</h3>
               </div>
               <div class="card-body table-responsive">
                <table id="table_id" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Naam</th>
                            <th>Bijwerken</th>
                            <th>Verwijderen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allergies as $a)
                        <tr>
                            <form id="update-allergies{{$a->id}}" method="POST">
                                @csrf
                                @method('PUT')
                                <td>
                                    <input type="text" name="name" id="name{{$a->id}}" value="{{$a->name}}" class="form-control"/>
                                </td>

                            </form>
                        <td>
                            <button type="submit" form="update-allergies{{$a->id}}" formaction="{{ route('allergies.update', $a->id) }}" id="update{{$a->id}}" class="btn btn-success">Bijwerken</button>
                            </td>
                            <td>
                                <form action="{{ route('allergies.destroy', $a->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" id="delete{{$a->id}}" class="btn btn-danger">Verwijderen</button>
                                </form>
                            </td>
                        </div>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Naam</th>
                            <th>Bijwerken</th>
                            <th>Verwijderen</th>
                        </tr>
                    </tfoot>
                </table>
               </div>
               <div class="mt-4">
                {!! $allergies->links('pagination::bootstrap-4')!!}
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
                <h3 class="card-title">Allergie aanmaken</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('allergies.store') }}" method="POST">
                    @csrf
                    <table class="table" id="multiForm">
                        <thead>
                            <tr>
                                <th>Naam</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><input type="text" name="name" id="addAllergie" class="form-control" required/></td>
                        </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Naam</th>
                            </tr>
                        </tfoot>
                    </table>
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
