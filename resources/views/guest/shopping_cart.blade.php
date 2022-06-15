@extends('layouts.app')
@section('content')

<div class="content-container p-4">
    <div class="row mt-5">
        <div class="col px-4">
            <a href="{{url('/categories')}}" class="btn border border-3 border-dark">Terug</a>
        </div>
        <h1 class="col text-center">Bestelling</h1>
    </div>
    <div class="h-30em border border-secondary text-center position-relative p-3 mt-3">
        <form id="form" action="{{route('postOrder')}}" method="post">
            @csrf
            <div class="table-responsive">
                <div id="shopping_cart" class="mh-22em mt-3 hidden-scrollbar p-3">
                </div>
                <div class="row mt-3">
                    <div class="col"></div>
                    <div class="col">
                        <p class="fw-bold m-0">Totaal</p>
                        <p id="total_price" class="fw-bold"></p>
                    </div>
                    <div class="col">
                        <button id="orderBtn" class="btn btn-primary">Bestelling plaatsen</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@if (session()->has('alert-success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'De bestelling is geplaatst'
        })
    </script>
@endif
<script>
     window.myArray= @json([$dishes->values()->all(), $sales])
</script>
<script src="{{ asset('js/shopping_cart.js') }}"></script>

@endsection





