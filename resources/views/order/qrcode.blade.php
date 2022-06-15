@extends('layouts.app')
@section('content')

<div class="content-container">
    <div class="d-flex justify-content-center row">
        <h1 class="pt-5 text-center">Bestelling QR code</h1>
        <div class="mt-5 mb-5 text-center">
            {!! QrCode::size(250)->generate($qr_code_string); !!}
        </div>
    </div>
</div>

@endsection
