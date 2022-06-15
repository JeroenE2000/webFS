@extends('layouts.app')
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
<div class="content-container p-4">
    <h1 class="h1 text-center">Tafel {{$tableNumber}} uitchecken</h1>
    <div class="w-100 d-flex justify-content-center">
        <form class="w-50" id="form" action="{{ route('checkOut') }}" method="post">
            @csrf
            <div class="form-group">
                <h2 for="text">Weet u zeker dat u deze bestelling wilt uitchecken?</h2>
            </div>
            <button class="btn btn-primary mt-3" type="submit">Uitchecken</button>
        </form>
    </div>
</div>

@endsection
