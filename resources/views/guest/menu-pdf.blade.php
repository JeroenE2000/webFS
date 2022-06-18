<!DOCTYPE html>
<html >
<head>
    <title>De gouden draak menu</title>
</head>
<body >
<div style="margin-left: 20px ">
    <h3 class="orderlist-t">AFHAALLIJST</h3>
</div>
<div>
    @if($categories ?? false)
        <div>
            @foreach($categories ?? [] as $category)
                <h2 id="{{$category->name}}">{{$category->name}}</h2>
                    @foreach($category->dishes as $dish )
                    <div>
                        {{$dish->dishnumber}}{{$dish->dish_addition}}
                        {{$dish->name}}
                        <p>Spiciness: {{$dish->spicness_scale}}</p>
                        <p>Allergieen: </p>
                        <div>
                            @foreach($dish->Allergies as $allergie)
                                {{$allergie->name}}
                            @endforeach
                        </div>
                        <div>
                            Beschrijving : {!!$dish->description!!}
                        </div>
                        <div>
                            Prijs: € {{number_format($dish->price, 2, '.', ',')}}
                        </div>
                    </div>
                    <br>
                    @endforeach
            @endforeach
        </div>
     @endif
</div>
<div>
    <h2>Aanbiedingen</h2>
    @foreach($dishes as $dish)
        @foreach($dish->Discounts()->get() as $sale)
                {{$dish->dishnumber}}{{$dish->dish_addition}}
                {!!$dish->name!!}
                <div>
                   <del style="color: red">€ {{number_format($dish->price, 2, '.', ',')}}</del>
                    <span style="color:green">€ {{number_format($dish->price*(1-($sale->discount/100)), 2, '.', ',')}}</span>
                    <span>{{$sale->discount}}%</span>
                    <span>Korting van  {{$sale->start_time}} en tot {{$sale->end_time}}</span>
                    <br/>
                </div>

        @endforeach
@endforeach
</div>
</body>
</html>
