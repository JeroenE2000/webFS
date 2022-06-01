@extends('layouts.cms')

@section('content')

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <span class="float-left h2">Gerecht {!! $course->name  !!}  aanpassen</span>
                <a href="{{route('dishes.index')}}" class="float-right btn btn-primary">Terug</a>
                <br><br>
                <form action="{{ route('dishes.update', $course->id) }}" method="post">
                    @method('PUT')
                    @csrf
                    <div class="form-group mt-2" >
                        <label for="name">Naam</label>
                        <input type="text" class="form-control" id="name" name="name" value="@if(old('name') !== null){{ old('name') }}@else{!! $course->name !!}@endif" placeholder="Vul gerecht naam in">
                    </div>
                    <div class="form-group mt-2" >
                        <label for="name">Dish additon</label>
                        <input type="text" class="form-control" id="dish_addition" name="dish_addition" value="@if(old('dish_addition') !== null){{ old('dish_addition') }}@else{!! $course->dish_addition !!}@endif" placeholder="Vul dish addition in">
                    </div>
                    <div class="form-group" >
                        <label for="category_id">Categorie</label>
                        <select  class="form-control" name="category_id" id="category_id">
                            @foreach($categories as $category)
                                @if(old('category_id') !== null && old('category_id') == $category->id)
                                    <option value="{{$category->id}}" selected>{{$category->name}}</option>
                                @else
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-2"" >
                        <label for="spiciness">Pittigheid</label>
                        <input class="form-control" type="number" name="spicness_scale" value="{{$course->spicness_scale}}">
                    </div>
                    <div class="form-group mt-2" >
                        <label for="allergens">Allergenen</label>
                        <br/>
                        <select class="row selectpicker" multiple data-live-search="true"  multiple ="multiple" name="allergens[]" id="allergens">
                            @foreach($allergens as $allergen)
                                @if(old('allergens') && in_array($allergen->id,old('allergens')))
                                    <option value="{{$allergen->id}}" selected>{{$allergen->name}}</option>
                                @elseif($course->Allergies()->get()->contains($allergen))
                                    <option value="{{$allergen->id}}" selected>{{$allergen->name}}</option>
                                @else
                                    <option value="{{$allergen->id}}">{{$allergen->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" >
                        <label for="price">Prijs in (€)</label>
                        <input type="number" step = "any" class="form-control" id="price" name="price" value="@if(old('price') !== null){{ old('price') }}@else{{$course->price}}@endif" placeholder="Vul prijs in">
                    </div>
                    <div class="form-group mb-3">
                        <label for="city">Beschrijving</label>
                        <input type="text" class="form-control" id="description" name="description" value="@if(old('description') !== null){{ old('description') }}@else{{$course->description}}@endif" placeholder="Vul beschrijving in">
                    </div>
                    <button type="submit" class="btn btn-success">Aanpassen</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
<script type="text/javascript">
    $(document).ready(function() {
        $('allergens').selectpicker();
    });
</script>
