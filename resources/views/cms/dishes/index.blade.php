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
           <div class="col-lg-12 margin-tb">
            <form action="dishes" method="GET" class="form-inline mb-3">
                @csrf
                <input class="form-control col-sm-2 mr-sm-2" name="dishsearch" type="search" placeholder="Zoeken..." aria-label="Zoeken">
                <select name="category" class="form-select col-md-1 mr-sm-2" aria-label="Categorie">
                    <option selected></option>
                    @foreach($categories as $c)
                    <option value="{{$c->id}}">{{$c->name}}</option>
                    @endforeach
                </select>
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Zoek</button>
            </form>
            </div>
           </div>
    </div>
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
                                <th>Dish_addition</th>
                                <th>Category</th>
                                <th>Allergieen</th>
                                <th>Naam</th>
                                <th>Prijs</th>
                                <th>Beschrijving</th>
                                <th>Spice scale</th>
                                @if(auth()->user()->role_id == 1)
                                    <th>Bijwerken</th>
                                    <th>Verwijderen</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dishes as $d)
                            <tr>
                                <td>{{$d->dishnumber}}</td>
                                <td>{{$d->dish_addition}}</td>
                                @foreach($categories as $c)
                                    @if($c->id == $d->categories_id)
                                        <td>{{$c->name}}</td>
                                    @endif
                                @endforeach
                                <td>
                                @foreach($d->Allergies as $a )
                                {{$a->name}}
                                @endforeach
                                </td>
                                <td>{{$d->name}}</td>
                                <td>€ {{$d->price}}</td>
                                <td>{{$d->description}}</td>
                                <td>{{$d->spicness_scale}}</td>
                                @if(auth()->user()->role_id == 1)
                                    <td>
                                        <a id="update{{$d->id}}" class="btn btn-success" href="{{ route('dishes.edit',$d) }}">Bijwerken</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('dishes.destroy', $d->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" id="delete{{$d->id}}" class="btn btn-danger">Verwijderen</button>
                                        </form>
                                    </td>
                                @endif
                            </div>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Dishnumber</th>
                                <th>Dish_addition</th>
                                <th>Category</th>
                                <th>Allergieen</th>
                                <th>Naam</th>
                                <th>Prijs</th>
                                <th>Beschrijving</th>
                                <th>Spice scale</th>
                                @if(auth()->user()->role_id == 1)
                                    <th>Bijwerken</th>
                                    <th>Verwijderen</th>
                                @endif
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </div>
    @if(auth()->user()->role_id == 1)
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Dish aanmaken</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('dishes.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Naam</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Naam">
                        </div>
                        <div class="form-group">
                            <label for="price">Prijs</label>
                            <input type="text" class="form-control" name="price" id="price" placeholder="Prijs">
                        </div>
                        <div class="form-group">
                            <label for="description">Beschrijving</label>
                            <input type="text" class="form-control" name="description" id="description" placeholder="Beschrijving">
                        </div>
                        <div class="form-group">
                            <label for="spicness_scale">Spice scale</label>
                            <input type="number" class="form-control" name="spicness_scale" id="spicness_scale" placeholder="Spice scale">
                        </div>
                        <div class="form-group">
                            <label for="dish_addition">Dish_addition</label>
                            <input type="text" class="form-control" name="dish_addition" id="dish_addition" placeholder="Dish_addition">
                        </div>
                        <div class="form-group">
                            <label for="category_id">Categorie</label>
                            <select class="form-control" name="category_id" id="category_id">
                                @foreach($categories as $c)
                                <option value="{{$c->id}}">{{$c->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="allergies">Allergieen</label>
                            <select class="row selectpicker" multiple data-live-search="true"  multiple ="multiple" name="allergens[]" id="allergens">
                                @foreach($allergies as $a)
                                <option value="{{$a->id}}">{{$a->name}}</option>
                                @endforeach
                            </select>
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
    @endif
</section>
<script type="text/javascript">
    $(document).ready(function() {
        $('allergens').selectpicker();
    });
</script>

@endsection
