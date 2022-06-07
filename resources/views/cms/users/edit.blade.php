@extends('layouts.cms')

@section('content')

@if($errors->any())
    <div class="alert alert-danger">
        <strong>{{('errors.Whoops')}}</strong> {{('errors.errorMessage')}}<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<section class="content">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title ">{{$user->name}}</h3>
                <br>
                <h3 class="card-title">{{$user->email}}</h3>
                <br>
                <h3 class="card-title">Bijwerken</h3>
            </div>
            <form action="{{route ('users.update' , $user->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <select type="text" name="role_id" class="form-control">
                            @foreach($roles as $r)
                                <option value="{{$r->id}}" {{$r->id == $user->role_id ? 'selected' : ''}}>{{$r->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('users.index') }}">Terug</a>
            </div>
        </div>
    </div>
</section>

@endsection
