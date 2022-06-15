@extends('layouts.cms')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tafel aanmaken</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('tables.update', $table->id) }}" method="post">
                    @method('PUT')
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
@endsection
