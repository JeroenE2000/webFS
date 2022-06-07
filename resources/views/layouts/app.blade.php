<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/guest.css') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{url('images/dragon-small.png')}}"/>

    <!-- Scripts -->
    <script type="module" src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="main-table container-fluid h-100">
        <div class="row pt-3" id="main_table">
            <div class="dragon-cell col">
                <img class="align-middle h-img hide520px"  src="{{url('images/dragon-small.png')}}" alt="Golden Dragon">
                <a href="{{url('/')}}" class="font-chinese">
                    De Gouden Draak
                </a>
                <img class="align-middle h-img hide520px" src="{{url('images/dragon-small-flipped.png')}}" alt="Golden Dragon">
            </div>
            <div class="col ">
                <a href="{{url('/sale')}}" class="marque">
                    <marquee behavior="scroll" direction="left">
                        Welkom bij De Gouden Draak. Klik op deze tekst om de aanbiedingen van deze week te zien!
                    </marquee>
                </a>
            </div>
            <div class="dragon-cell col hide1030px">
                <img class="align-middle h-img" src="{{url('images/dragon-small.png')}}" alt="Golden Dragon">
                <a href="{{url('/')}}" class="font-chinese">
                    De Gouden Draak
                </a>
                <img class="align-middle h-img" src="{{url('images/dragon-small-flipped.png')}}" alt="Golden Dragon">
            </div>
        </div>
        <!-- CONTENT HERE! -->
        <div class="h-100 pt-2">
            <div class="h-25px row m-0">
                <div class="w-50px h-100 p-0 b-y-r b-y-l b-y-t"></div>
                <div class="w-21px h-100 b-y-r p-0"></div>
                <div class="col b-y-t"></div>
                <div class="w-21px h-100 b-y-l p-0"></div>
                <div class="w-50px h-100 p-0 b-y-r b-y-l b-y-t"></div>
            </div>
            <div class="h-25px row m-0">
                <div class="w-50px h-100 p-0">
                    <div class="float-start w-25px h-100 b-y-l b-y-b"></div>
                    <div class=" float-end w-25px h-100 b-y-r b-y-l b-y-t b-y-b"></div>
                </div>
                <div class="w-21px h-100 b-y-r b-y-t b-y-b p-0"></div>
                <div class="col b-y-t"></div>
                <div class="w-21px h-100 b-y-l b-y-t b-y-b p-0"></div>
                <div class="w-50px h-100 p-0">
                    <div class="float-start w-25px h-100 b-y-r b-y-l b-y-t b-y-b"></div>
                    <div class="float-end w-25px h-100 b-y-r b-y-b"></div>
                </div>
            </div>
            <div class="h-25px row m-0">
                <div class="w-50px h-100 p-0">
                    <div class="float-start w-25px h-100 b-y-b"></div>
                    <div class="float-end w-25px h-100 b-y-r b-y-l b-y-b"></div>
                </div>
                <div class="col"></div>
                <div class="w-50px h-100 p-0">
                    <div class="float-start w-25px h-100 b-y-r b-y-l b-y-b"></div>
                    <div class="float-end w-25px h-100 b-y-b"></div>
                </div>
            </div>
            <div class="row m-0 b-y-r b-y-l p-21px">
                <div class="row m-0 b-y-r b-y-l ">
                    <div class="row m-0">
                    <div class="text-center">
                        <img src="{{url('images/dragon-small.png')}}" class="img-l hide700px" style="float:left;height:200px"
                             alt="Golden Dragon">
                        <img src="{{url('images/dragon-small-flipped.png')}}" class="img-r hide700px" style="float:right;height:200px"
                             alt="Golden Dragon">
                        <span class="t-2">Chinees Indische Specialiteiten</span>
                        <br>
                        <span class="t-1">De Gouden Draak</span><br>
                    </div>
                        <nav class="navbar navbar-expand-lg navbar-dark rounded">
                            <a class="navbar-brand" href="#"></a>
                            <button class="navbar-toggler mb-2" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse  justify-content-center" id="navbarNav">
                                <ul class="navbar-nav">
                                    <li class="nav-item text-center bg-primary bg-gradient mx-1 rounded">
                                        <a href="{{url('/')}}" class="nav-link text-white">Home</a>
                                    </li>
                                    <li class="nav-item text-center bg-primary bg-gradient mx-1 rounded">
                                        <a href="{{url('/categories')}}" class="nav-link text-white">Menukaart</a>
                                    </li>
                                    <li class="nav-item text-center bg-primary bg-gradient mx-1 rounded">
                                        <a href="{{url('/news')}}" class="nav-link text-white">Nieuws</a>
                                    </li>
                                    <li class="nav-item text-center bg-primary bg-gradient mx-1 rounded">
                                        <a href="{{url('/contact')}}" class="nav-link text-white">Contact</a>
                                    </li>
                                    <li class="nav-item text-center bg-primary bg-gradient mx-1 rounded">
                                        <a href="{{url('/sale')}}" class="nav-link text-white">Aanbiedingen</a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                    <br>
                    <div>
                        <br>
                        @yield('content')
                    </div>

                    <div class="text-center pt-3">
                        <a href="">Naar Contact</a>
                    </div>
                    </div>
                </div>
            </div>
            <div class="h-25px row m-0">
                <div class="w-50px h-100 p-0">
                    <div class="float-start w-25px h-100 b-y-t"></div>
                    <div class=" float-end w-25px h-100 b-y-r b-y-l b-y-t"></div>
                </div>
                <div class="col"></div>
                <div class="w-50px h-100 p-0">
                    <div class="float-start w-25px h-100 b-y-r b-y-l b-y-t"></div>
                    <div class="float-end w-25px h-100 b-y-t"></div>
                </div>
            </div>
            <div class="h-25px row m-0">
                <div class="w-50px h-100 p-0">
                    <div class="float-start w-25px h-100 b-y-l b-y-t"></div>
                    <div class=" float-end w-25px h-100 b-y-r b-y-l b-y-t b-y-b"></div>
                </div>
                <div class="w-21px h-100 b-y-r b-y-b b-y-t p-0"></div>
                <div class="col b-y-b"></div>
                <div class="w-21px h-100 b-y-l b-y-b b-y-t p-0"></div>
                <div class="w-50px h-100 p-0">
                    <div class="float-start w-25px h-100 b-y-r b-y-l b-y-t b-y-b"></div>
                    <div class="float-end w-25px h-100 b-y-r b-y-t"></div>
                </div>
            </div>
            <div class="h-25px row m-0">
                <div class="w-50px h-100 p-0 b-y-r b-y-l b-y-b"></div>
                <div class="w-21px h-100 b-y-r p-0"></div>
                <div class="col b-y-b"></div>
                <div class="w-21px h-100 b-y-l p-0"></div>
                <div class="w-50px h-100 p-0 b-y-r b-y-l b-y-b"></div>
            </div>
            <br>
        </div>
    </div>
</body>
</html>
