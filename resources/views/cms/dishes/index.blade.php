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
        <div class="row ">
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
                @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                    <a href="{{route('cart.index')}}" title="Ga naar winkelwagen" class="btn btn-primary btn-lg shopping-cart">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-cart"
                        viewBox="0 0 16 16">
                    <path
                        d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                    Winkelmandje {{Cart::getTotalQuantity()}}</a>
                @endif
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
                                    @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                                        <th>Toevoegen</th>
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
                                    <td>&euro; {{$d->price}}</td>
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
                                    <td>
                                    @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                                        <form action="{{ route('cart.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" value="{{ $d->id }}" name="id">
                                            <input type="hidden" value="{{ $d->name }}" name="name">
                                            @if($d->Discounts()->count() > 0)
                                                @foreach($d->Discounts as $sale)
                                                    @if(date('Y-m-d H:i:s') >= $sale->start_time && date('Y-m-d H:i:s') <= $sale->end_time)
                                                        <input type="hidden" value="{{($d->price*(1-($sale->discount/100)))}}" name="price">
                                                    @endif
                                                @endforeach
                                            @else
                                                <input type="hidden" value="{{ $d->price }}" name="price">
                                            @endif
                                                <input type="hidden" value=""  name="description">
                                                <input type="hidden" value="1" name="quantity">
                                                <button class="btn btn-success md-4">Add to cart</button>
                                        </form>
                                    </td>
                                    @endif
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
                                    @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                                        <th>Toevoegen</th>
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
