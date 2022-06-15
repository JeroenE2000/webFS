@extends('layouts.app')

@section('content')

<div class="content-container">
    <div class="d-flex justify-content-center row">
        <h1 class="pt-5 text-center">Categorieën</h1>
        <div class="row">
                @foreach($categories as $category)
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <a href="{{route('getTableCourses', $category->id)}}" class="btn btn-default">{{$category->name }}</a>
                        </div>
                    </div>
                </div>
                @endforeach
        </div>
    </div>
</div>
@endsection

@if (session()->has('alert-success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'De bestelling is geplaatst'
        })
    </script>
@endif
