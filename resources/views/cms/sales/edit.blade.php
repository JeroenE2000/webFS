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
                <a href="{{route('discounts.index')}}" class="float-right btn btn-primary">Terug</a>
                <br><br>
                <form action="{{ route('discounts.update', $discount->id) }}" method="post">
                    @method('PUT')
                    @csrf
                    <div class="form-group mt-2" >
                        <label for="dishes_id">Gerechten</label>
                        <select class="form-control selectpicker" id="dishes_id" multiple data-live-search="true" multiple ="multiple" name="dishes[]" title="Geen gerecht geselecteerd">
                            @foreach($dishes as $dish)
                                    @if(old('dishes') && in_array($dish->id,old('dishes')))
                                        <option value="{{$dish->id}}" selected>{!! $dish->name !!}</option>
                                    @elseif($discount->Dishes()->get()->contains($dish))
                                        <option value="{{$dish->id}}" selected>{!! $dish->name !!}</option>
                                    @else
                                        <option value="{{$dish->id}}">{!! $dish->name !!}</option>
                                    @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-2" >
                        <label for="start_time">Korting</label>
                        <input type="number" class="form-control" name="discount" value="{{$discount->discount}}" id="discount">
                    </div>
                    <div class="form-group mt-2" >
                        <label for="start_time">Start tijd</label>
                        <input type="datetime-local" class="form-control" name="start_time" value="{{date('Y-m-d\TH:i', strtotime($discount->start_time))}}" id="start_time">
                    </div>
                    <div class="form-group mt-2" >
                        <label for="end_time">Eind tijd</label>
                        <input type="datetime-local" class="form-control" name="end_time" value="{{date('Y-m-d\TH:i', strtotime($discount->end_time))}}" id="end_time">
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
        $('dishes_id').selectpicker();
    });
</script>
