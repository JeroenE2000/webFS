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
                <div class="pull-right">
                     <a class="btn btn-success" href="{{ route('users.create') }}">Nieuwe gebruiker aanmaken</a>
                </div>
          </div>
       </div>
       <div class="row mt-4" >
          <div class="col-12 col-sm-12">
             <div class="card">
                <div class="card-header">
                   <h3 class="card-title">Gebruikers</h3>
                </div>
                 <div class="card-body">
                         <table id="" class="table table-bordered table-hover">
                             <thead>
                                 <tr>
                                    <td>Role</td>
                                    <td>Naam</td>
                                    <td>Email</td>
                                    <td>Bijwerken</td>
                                    <td>Verwijderen</td>
                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach($users as $u)
                                 <tr>
                                    <td>{{$u->RolesRelation->name}}</td>
                                    <td>{{$u->name}}</td>
                                    <td>{{$u->email}}</td>
                                    <td><a class="btn btn-primary" href="{{ route('users.edit',$u) }}">Bijwerken</a></td>
                                    <td>
                                        <form action="{{ route('users.destroy', $u->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" id="delete{{$u->id}}" class="btn btn-danger">Verwijderen</button>
                                        </form>
                                    </td>
                                 </tr>
                                 @endforeach
                             </tbody>
                         </table>
                     </div>
             </div>
          </div>
       </div>
    </div>
 </section>
@endsection
