@extends('layouts.app')

@section('content')

<div class="content-container">
    <div class="d-flex justify-content-center row">
        <h1 class="pt-5 text-center">Categorieën</h1>
        <a type="button" href="{{route('downloadMenu')}}" class="col mw-12em btn btn-warning mb-2" target="blanc">PDF Menukaart</a>
        <div class="row">
                @foreach($categories as $category)
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <a href="{{route('get-dishes', $category->id)}}" class="btn btn-default">{{$category->name }}</a>
                        </div>
                    </div>
                </div>
                @endforeach
        </div>
    </div>
</div>
@endsection
