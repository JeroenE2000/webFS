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
                        <div>
                            {!!$dish->description!!}
                        </div>
                        <div>
                            € {{number_format($dish->price, 2, '.', ',')}}
                        </div>
                    </div>
                    @endforeach
            @endforeach
        </div>
     @endif
</div>
<div>
    <h2>Aanbiedingen</h2>
    @foreach($dishes as $dish)
        @foreach($sales as $sale)
            @if($sale->dishes_id === $dish->id)
                {{$dish->dishnumber}}{{$dish->dish_addition}}
                {!!$dish->name!!}
                <div>
                    <del style="color: red">€ {{number_format($dish->price, 2, '.', ',')}}</del>
                </div>
                <span style="color:green">€ {{number_format($dish->price*(1-($sale->discount/100)), 2, '.', ',')}}</span>
                <br/>
            @endif
        @endforeach
    @endforeach
</div>
</body>
</html>
