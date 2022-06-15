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
<div class="content-container">
    <div class="d-flex justify-content-center row">
        <h1 class="pt-5 text-center">Vul uw tafelnummer in</h1>
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <form action="{{ route('postTableNumber') }}" method="POST">
                        @csrf
                        <div class="form-group mt-2">
                            <label for="table_number">Lijstje van alle tafels</label>
                            <select class="form-control" name="table_number">
                                @foreach($tables as $table)
                                    <option value="{{ $table->id }}">{{ $table->table_number }}</option>
                                @endforeach
                            </select>
                            <label for="table">Tafelnummer</label>
                            <input type="number" class="form-control" id="table" name="number" placeholder="Tafelnummer" value="{{old('number')}}">
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Bevestigen</button>
                    </form>
                </div>
            </div>
        </div>
</div>
@endsection
