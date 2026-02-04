@extends('layouts.home')
@section('contentSection1')
    <!-- Top News Start-->
    <div class="top-news">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 tn-left">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <a href="/{{$materiasHome[0]['vchr_LinkTitulo']}}" alt="">
                                    <img src="{{$materiasHome[0]['images'][0]['vchr_HRef'] ?? ''}}" class="d-block w-100" alt="...">
                                </a>
                                <div class="carousel-caption d-none d-md-block">
                                    <a class="cn-title" href="/{{$materiasHome[0]['vchr_LinkTitulo']}}">
                                        <h5>{{$materiasHome[0]['vchr_Titulo'] ?? 'First slide label'}}</h5>
                                        <p><i class="far fa-clock"></i> {{$materiasHome[0]['data_publicacao_formatted'] ?? $materiasHome[0]['created_at_formatted'] ?? ''}}</p>
                                    </a>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <a href="/{{$materiasHome[1]['vchr_LinkTitulo']}}" alt="">
                                    <img src="{{$materiasHome[1]['images'][0]['vchr_HRef'] ?? ''}}" class="d-block w-100" alt="...">
                                </a>
                                <div class="carousel-caption d-none d-md-block">
                                     <a class="cn-title" href="/{{$materiasHome[1]['vchr_LinkTitulo']}}">
                                        <h5>{{$materiasHome[1]['vchr_Titulo'] ?? 'Second slide label'}}</h5>
                                        <p><i class="far fa-clock"></i> {{$materiasHome[1]['data_publicacao_formatted'] ?? $materiasHome[1]['created_at_formatted'] ?? ''}}</p>
                                    </a>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <a href="/{{$materiasHome[2]['vchr_LinkTitulo']}}" alt="">
                                    <img src="{{$materiasHome[2]['images'][0]['vchr_HRef'] ?? ''}}" class="d-block w-100" alt="...">
                                </a>
                                <div class="carousel-caption d-none d-md-block">
                                    <a class="cn-title" href="/{{$materiasHome[2]['vchr_LinkTitulo']}}">
                                        <h5>{{$materiasHome[2]['vchr_Titulo'] ?? 'Third slide label'}}</h5>
                                        <p><i class="far fa-clock"></i> {{$materiasHome[2]['data_publicacao_formatted'] ?? $materiasHome[2]['created_at_formatted'] ?? ''}}</p>
                                    </a>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <a href="/{{$materiasHome[3]['vchr_LinkTitulo']}}" alt="">
                                    <img src="{{$materiasHome[3]['images'][0]['vchr_HRef'] ?? ''}}" class="d-block w-100" alt="...">
                                </a>
                                <div class="carousel-caption d-none d-md-block">
                                     <a class="cn-title" href="/{{$materiasHome[3]['vchr_LinkTitulo']}}">
                                        <h5>{{$materiasHome[3]['vchr_Titulo'] ?? 'Fourth slide label'}}</h5>
                                        <p><i class="far fa-clock"></i> {{$materiasHome[3]['data_publicacao_formatted'] ?? $materiasHome[3]['created_at_formatted'] ?? ''}}</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-target="#carouselExampleIndicators" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-target="#carouselExampleIndicators" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </button>
                    </div>
                </div>

                <div class="col-md-6 tn-right">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="tn-img">
                                <img src="{{$materiasHome[4]['images'][0]['vchr_HRef'] ?? ''}}" class="d-block w-100" alt="headerBanner.title">
                                <div class="tn-content">
                                    <div class="tn-content-inner">
                                        <a class="tn-title" href="/{{$materiasHome[4]['vchr_LinkTitulo']}}">{{$materiasHome[4]['vchr_titulo']}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="tn-img">
                                <img src="{{$materiasHome[5]['images'][0]['vchr_HRef'] ?? ''}}" class="d-block w-100" alt="headerBanner.title">
                                <div class="tn-content">
                                    <div class="tn-content-inner">
                                        <a class="tn-title" href="/{{$materiasHome[5]['vchr_LinkTitulo']}}">{{$materiasHome[5]['vchr_titulo']}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:15px;">
                        <div class="col-md-6">
                            <div class="tn-img">
                                <img src="{{$materiasHome[6]['images'][0]['vchr_HRef'] ?? ''}}" class="d-block w-100" alt="headerBanner.title">
                                <div class="tn-content">
                                    <div class="tn-content-inner">
                                        <a class="tn-title" href="/{{$materiasHome[6]['vchr_LinkTitulo']}}">{{$materiasHome[6]['vchr_titulo']}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="tn-img">
                                <img src="{{$materiasHome[7]['images'][0]['vchr_HRef'] ?? ''}}" class="d-block w-100" alt="headerBanner.title">
                                <div class="tn-content">
                                    <div class="tn-content-inner">
                                        <a class="tn-title" href="/{{$materiasHome[7]['vchr_LinkTitulo']}}">{{$materiasHome[7]['vchr_titulo']}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Top News End-->
    <hr/>

    <!-- Category News Start-->
    <div class="cat-news">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <h2><i class="fas fa-align-justify"></i>Games</h2>
                    <div class="row cn-slider">
                        <div class="col-md-6">
                            <div class="cn-img">
                                <img src="{{$matGames[0]['images'][0]['vchr_HRef'] ?? ''}}" />
                                <div class="cn-content">
                                    <div class="cn-content-inner">

                                        <a class="cn-title" href="{{$matGames[0]['vchr_LinkTitulo']}}">{{$matGames[0]['vchr_titulo']}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="cn-img">
                                <img src="{{$matGames[1]['images'][0]['vchr_HRef'] ?? ''}}" />
                                <div class="cn-content">
                                    <div class="cn-content-inner">
                                      
                                        <a class="cn-title" href="{{$matGames[1]['vchr_LinkTitulo']}}">{{$matGames[1]['vchr_titulo']}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="cn-img">
                                <img src="{{$matGames[2]['images'][0]['vchr_HRef'] ?? ''}}" />
                                <div class="cn-content">
                                    <div class="cn-content-inner">
                                        
                                        <a class="cn-title" href="{{$matGames[2]['vchr_LinkTitulo']}}">{{$matGames[2]['vchr_titulo']}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <h2><i class="fas fa-align-justify"></i>Cosplay</h2>
                    <div class="row cn-slider">
                        <div class="col-md-6">
                            <div class="cn-img">
                                <img src="{{$matCosplay[0]['images'][0]['vchr_HRef'] ?? ''}}" />
                                <div class="cn-content">
                                    <div class="cn-content-inner">
                                        
                                        <a class="cn-title" href="{{$matCosplay[0]['vchr_LinkTitulo']}}">{{$matCosplay[0]['vchr_titulo']}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="cn-img">
                                <img src="{{$matCosplay[1]['images'][0]['vchr_HRef'] ?? ''}}" />
                                <div class="cn-content">
                                    <div class="cn-content-inner">
                                        
                                        <a class="cn-title" href="{{$matCosplay[1]['vchr_LinkTitulo']}}">{{$matCosplay[1]['vchr_titulo']}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="cn-img">
                                <img src="{{$matCosplay[2]['images'][0]['vchr_HRef'] ?? ''}}" />
                                <div class="cn-content">
                                    <div class="cn-content-inner">
                                        
                                        <a class="cn-title" href="{{$matCosplay[2]['vchr_LinkTitulo']}}">{{$matCosplay[2]['vchr_titulo']}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Category News End-->

    <!-- Category News Start
    <div class="cat-news">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <h2><i class="fas fa-align-justify"></i>Business</h2>
                    <div class="row cn-slider">
                        <div class="col-md-6">
                            <div class="cn-img">
                                <img src="img/cat-news-7.jpg" />
                                <div class="cn-content">
                                    <div class="cn-content-inner">
                                        <a class="cn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                        <a class="cn-title" href="">Interdum et malesuada fames ac ante</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="cn-img">
                                <img src="img/cat-news-8.jpg" />
                                <div class="cn-content">
                                    <div class="cn-content-inner">
                                        <a class="cn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                        <a class="cn-title" href="">Mauris non ligula eget ante sagittis</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="cn-img">
                                <img src="img/cat-news-9.jpg" />
                                <div class="cn-content">
                                    <div class="cn-content-inner">
                                        <a class="cn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                        <a class="cn-title" href="">Integer non nunc nec nulla aliquet</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h2><i class="fas fa-align-justify"></i>Entertainment</h2>
                    <div class="row cn-slider">
                        <div class="col-md-6">
                            <div class="cn-img">
                                <img src="img/cat-news-10.jpg" />
                                <div class="cn-content">
                                    <div class="cn-content-inner">
                                        <a class="cn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                        <a class="cn-title" href="">Ut laoreet justo non ornare</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="cn-img">
                                <img src="img/cat-news-11.jpg" />
                                <div class="cn-content">
                                    <div class="cn-content-inner">
                                        <a class="cn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                        <a class="cn-title" href="">Proin a nulla ut enim feugiat</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="cn-img">
                                <img src="img/cat-news-12.jpg" />
                                <div class="cn-content">
                                    <div class="cn-content-inner">
                                        <a class="cn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                        <a class="cn-title" href="">Sed mauris sem sollicitudin at neque</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     Category News End-->

    <!-- Main News Start-->
    <div class="main-news">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <h2><i class="fas fa-align-justify"></i>Últimas Notícias</h2>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mn-img">
                                            <img src="{{$materiasHome[0]['images'][0]['vchr_HRef'] ?? ''}}" />
                                        </div>
                                        <div class="mn-content">
                                            <a class="mn-title" href="{{$materiasHome[0]['vchr_LinkTitulo']}}">{{$materiasHome[0]['vchr_titulo']}}</a>
                                            <a class="mn-date" href=""><i class="far fa-clock">{{$materiasHome[0]['dt_post_formatted']}}</i></a>
                                            <p>
                                                {{$materiasHome[0]['vchr_lide']}}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">

                                        @foreach($materiasHome as $key => $materia)
                                            @if($key > 0 && $key < 6)
                                            <div class="mn-list">
                                                <div class="mn-img">
                                                    <img src="{{$materia['images'][0]['vchr_HRef'] ?? ''}}" />
                                                </div>
                                                <div class="mn-content">
                                                    <a class="mn-title" href="{{$materia['vchr_LinkTitulo']}}">{{$materia['vchr_titulo']}}</a>
                                                    <a class="mn-date" href=""><i class="far fa-clock"></i>{{$materia['dt_post_formatted']}}</a>
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h2><i class="fas fa-align-justify"></i>Críticas</h2>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mn-img">
                                            <img src="{{ $matCritica[0]['images'][0]['vchr_HRef'] ?? '' }}" />
                                        </div>
                                        <div class="mn-content">
                                            <a class="mn-title" href="{{ $matCritica[0]['vchr_LinkTitulo'] }}">{{ $matCritica[0]['vchr_titulo'] }}</a>
                                            <a class="mn-date" href=""><i class="far fa-clock"></i>{{ $matCritica[0]['created_at_formatted']  }}</a>
                                            <p>
                                                {{ $matCritica[0]['vchr_lide'] ?? '' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        @foreach($matCritica as $key => $critica)
                                            @if($key > 0 && $key < 6)
                                            <div class="mn-list">
                                                <div class="mn-img">
                                                    <img src="{{ $critica['images'][0]['vchr_HRef'] ?? '' }}" />
                                                </div>
                                                <div class="mn-content">
                                                    <a class="mn-title" href="{{ $critica['vchr_LinkTitulo'] }}">{{ $critica['vchr_titulo'] }}</a>
                                                    <a class="mn-date" href=""><i class="far fa-clock"></i>{{ $critica['created_at_formatted'] }}</a>
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                     <!--   <div class="mn-list">
                                            <div class="mn-img">
                                                <img src="img/popular-news.jpg" />
                                            </div>
                                            <div class="mn-content">
                                                <a class="mn-title" href="">Pellentesque ultrices quam id ipsum tempor</a>
                                                <a class="mn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                            </div>
                                        </div>
                                        <div class="mn-list">
                                            <div class="mn-img">
                                                <img src="img/popular-news.jpg" />
                                            </div>
                                            <div class="mn-content">
                                                <a class="mn-title" href="">Nam ex magna, commodo sed turpis rutrum</a>
                                                <a class="mn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                            </div>
                                        </div>
                                        <div class="mn-list">
                                            <div class="mn-img">
                                                <img src="img/popular-news.jpg" />
                                            </div>
                                            <div class="mn-content">
                                                <a class="mn-title" href="">Aliquam condimentum metus</a>
                                                <a class="mn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                            </div>
                                        </div>
                                        <div class="mn-list">
                                            <div class="mn-img">
                                                <img src="img/popular-news.jpg" />
                                            </div>
                                            <div class="mn-content">
                                                <a class="mn-title" href="">Ut ornare rutrum ligula erat volutpat</a>
                                                <a class="mn-date" href=""><i class="far fa-clock"></i>05-Feb-2020</a>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="sidebar">
                            <div class="sidebar-widget">
                                <h2><i class="fas fa-align-justify"></i>Category</h2>
                                <div class="category">
                                    <ul class="fa-ul">
                                        @foreach($categorias as $categoria)
                                        @php
                                            $linkCategoria = !empty($categoria['tag']) ? strtolower($categoria['tag']) : strtolower($categoria['nome']);
                                        @endphp
                                        <li><span class="fa-li"><i class="far fa-arrow-alt-circle-right"></i></span><a href="/{{ $linkCategoria }}">{{$categoria['nome']}}</a></li>
                                        @endforeach
                             
                                    </ul>
                                </div>
                            </div>

                            <div class="sidebar-widget">
                                <h2><i class="fas fa-align-justify"></i>Tags Populares</h2>
                                <div class="tags">
                                    @foreach($tagsSummary as $index => $tagItem)
                                        @if($index < 15)
                                            <a href="/tag/{{ urlencode($tagItem['tag']) }}" title="{{ $tagItem['count'] }} matérias">
                                                {{ $tagItem['tag'] }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <div class="sidebar-widget">
                                <h2><i class="fas fa-align-justify"></i>Ads 1 column</h2>
                                <div class="image">
                                    <a href=""><img src="img/adds-1.jpg" alt="Image"></a>
                                </div>
                            </div>

                            <div class="sidebar-widget">
                                <h2><i class="fas fa-align-justify"></i>Ads 2 column</h2>
                                <div class="image">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <a href=""><img src="img/adds-2.jpg" alt="Image"></a>
                                        </div>
                                        <div class="col-sm-6">
                                            <a href=""><img src="img/adds-2.jpg" alt="Image"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main News End-->

    <!-- Category News Start-->
    <div class="cat-news">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <h2><i class="fas fa-align-justify"></i>Videos do canal</h2>
                    <div class="row cn-slider">
                        <div class="col-md-6">
                            <div class="cn-img">
                                @php 
                                $thumb = explode('|', $videos[0]['vchr_YTThumbHigh']);
                                $tit = base64_decode($videos[0]['vchr_Titulo']);
                                $dt = $videos[0]['dt_Publicado_formatted'];
                                @endphp
                                <img class="img-fluid" src="{{$thumb[0]}}" />
                                <div class="cn-content">
                                    <div class="cn-content-inner">
                                        <i class="far fa-clock"></i>{{$dt}}
                                        <a class="cn-title" href="">{{$tit}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="cn-img">
                                @php 
                                $thumb = explode('|', $videos[1]['vchr_YTThumbHigh']);
                                $tit = base64_decode($videos[1]['vchr_Titulo']);
                                $dt = $videos[1]['dt_Publicado_formatted'];
                                @endphp
                                <img class="img-fluid" src="{{$thumb[0]}}" />
                                <div class="cn-content">
                                    <div class="cn-content-inner">
                                        <i class="far fa-clock"></i>{{$dt}}
                                        <a class="cn-title" href="">{{$tit}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="cn-img">
                                @php 
                                $thumb = explode('|', $videos[2]['vchr_YTThumbHigh']);
                                $tit = base64_decode($videos[2]['vchr_Titulo']);
                                $dt = $videos[2]['dt_Publicado_formatted'];
                                @endphp
                                <img class="img-fluid" src="{{$thumb[0]}}" />
                                <div class="cn-content">
                                    <div class="cn-content-inner">
                                        <i class="far fa-clock"></i>{{$dt}}
                                        <a class="cn-title" href="">{{$tit}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>


                <div class="col-md-6">
                    <h2><i class="fas fa-align-justify"></i>Cosplay</h2>
                    <div class="row cn-slider">
                        <div class="col-md-6">
                            <div class="cn-img">
                                <img src="{{$matCosplay[0]['images'][0]['vchr_HRef'] ?? ''}}" />
                                <div class="cn-content">
                                    <div class="cn-content-inner">
                                        <i class="far fa-clock"></i>05-Feb-2020
                                        <a class="cn-title" href="">{{$matCosplay[0]['vchr_titulo']}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="cn-img">
                                <img src="{{$matCosplay[1]['images'][0]['vchr_HRef'] ?? ''}}" />
                                <div class="cn-content">
                                    <div class="cn-content-inner">
                                        <i class="far fa-clock"></i>05-Feb-2020
                                        <a class="cn-title" href="">{{$matCosplay[1]['vchr_titulo']}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="cn-img">
                                <img src="{{$matCosplay[2]['images'][0]['vchr_HRef'] ?? ''}}" />
                                <div class="cn-content">
                                    <div class="cn-content-inner">
                                        <i class="far fa-clock"></i>05-Feb-2020
                                        <a class="cn-title" href="">{{$matCosplay[2]['vchr_titulo']}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Category News End-->
@endsection