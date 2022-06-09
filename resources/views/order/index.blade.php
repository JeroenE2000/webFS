@extends('layouts.app')

@section('content')

<div class="content-container">
    <div class="d-flex justify-content-center row">
        <h1 class="pt-5 text-center">Vul uw tafelnummer in</h1>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form action="{{ route('postTableNumber') }}" method="POST">
                    @csrf
                    <div class="form-group mt-2">
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
