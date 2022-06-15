@extends('layouts.cms')

@section('content')
<div class="row">
    @if(auth()->user()->role_id == 1)
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3></h3>
                <p>{{ __("Categories") }}</p>
            </div>
            <div class="icon">
                <i class="ion ion-android-list"></i>
            </div>
            <a href="{{url('cms/categories')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    @endif
</div>
@endsection
