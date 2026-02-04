@extends('layouts.home')

@section('contentSection1')
<br />
<div class="container-fluid">
    <div class="row">
        <!-- Main Content -->
        <div class="col-md-9">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item"><a href="/{{ $materia['vchr_LinkTitulo'] ?? '#' }}">{{ $categoria }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $materia['vchr_titulo'] ?? '' }}</li>
                </ol>
            </nav>

            <!-- Article -->
            <article class="materia-detail">
                <!-- Featured Image -->
                @if($featuredImage)
                <div class="materia-featured-image mb-4">
                    <img src="{{ asset($featuredImage['vchr_HRef']) }}" 
                         alt="{{ $materia['vchr_titulo'] ?? '' }}" 
                         class="img-fluid w-100">
                </div>
                @endif

                <!-- Title -->
                <h1 class="materia-title mb-3">{{ $materia['vchr_titulo'] ?? '' }}</h1>

                <!-- Meta Info -->
                <div class="materia-meta mb-4">
                    <span class="text-muted">
                        <i class="far fa-calendar"></i> {{ $materia['dt_post_formatted'] ?? '' }}
                    </span>
                    <span class="text-muted ms-3">
                        <i class="far fa-user"></i> {{ $materia['vchr_autor'] ?? '' }}
                    </span>
                </div>

                <!-- Lead -->
                @if(isset($materia['vchr_lide']) && !empty($materia['vchr_lide']))
                <div class="materia-lead mb-4">
                    <p class="lead">{{ $materia['vchr_lide'] }}</p>
                </div>
                @endif

                <!-- Content -->
                <div class="materia-content mb-5">
                    {!! $materia['content_decoded'] ?? '' !!}
                </div>

                <!-- Tags -->
                @if(count($tags) > 0)
                <div class="materia-tags mb-4">
                    <strong>Tags:</strong>
                    @foreach($tags as $tag)
                        <a href="/tag/{{ urlencode($tag) }}" style="color:white"class="badge bg-secondary me-1">{{ $tag }}</a>
                    @endforeach
                </div>
                @endif

                <!-- Writer Bio -->
                @if($writer)
                <div class="writer-bio mt-5 p-4 bg-light rounded">
                    <div class="row">
                        @if(isset($writer['foto']) && !empty($writer['foto']))
                        <div class="col-md-2">
                            <img src="{{ asset($writer['foto']) }}" 
                                 alt="{{ $writer['nick'] ?? '' }}" 
                                 class="img-fluid rounded-circle">
                        </div>
                        @endif
                        <div class="col-md-10">
                            <h4>
                                {{ $writer['nick'] ?? '' }}
                                @if(isset($writer['nome']) && !empty($writer['nome']))
                                    - {{ $writer['nome'] }}
                                @endif
                            </h4>
                            @if(isset($writer['biografia']) && !empty($writer['biografia']))
                            <div class="writer-description">
                                {!! $writer['biografia'] !!}
                            </div>
                            @endif
                            @if(isset($writer['instagram']) && !empty($writer['instagram']))
                            <div class="writer-social mt-2">
                                <a href="https://instagram.com/{{ ltrim($writer['instagram'], '@') }}" 
                                   target="_blank" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fab fa-instagram"></i> Instagram
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Related Articles -->
                @if(count($relatedArticles) > 0)
                <div class="related-articles mt-5">
                    <h3 class="mb-4">Artigos Relacionados</h3>
                    <div class="row">
                        @foreach($relatedArticles as $related)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                @if(isset($related['images']) && count($related['images']) > 0)
                                    @php
                                        $relatedImage = null;
                                        foreach($related['images'] as $img) {
                                            if($img['vchr_Tipo'] === 'Top_Materia') {
                                                $relatedImage = $img;
                                                break;
                                            }
                                        }
                                    @endphp
                                    @if($relatedImage)
                                    <img src="{{ asset($relatedImage['vchr_HRef']) }}" 
                                         class="card-img-top" 
                                         alt="{{ $related['vchr_titulo'] ?? '' }}">
                                    @endif
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="/{{ $related['vchr_LinkTitulo'] ?? '#' }}">
                                            {{ $related['vchr_titulo'] ?? '' }}
                                        </a>
                                    </h5>
                                    @if(isset($related['vchr_lide']))
                                    <p class="card-text">{{ Str::limit($related['vchr_lide'], 100) }}</p>
                                    @endif
                                    <p class="card-text">
                                        <small class="text-muted">{{ $related['dt_post_formatted'] ?? '' }}</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </article>
        </div>

        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="sidebar">
                <h2 class="mb-3">Últimas Matérias</h2>
                @if(isset($sidebarArticles) && count($sidebarArticles) > 0)
                <div class="list-group">
                    @foreach($sidebarArticles as $article)
                    <a href="/{{ $article['vchr_LinkTitulo'] ?? '#' }}" 
                       class="list-group-item list-group-item-action">
                       <img class="img-fluid" src="{{ $article['images'][0]['vchr_HRef'] ?? '' }}" alt="{{ $article['vchr_titulo'] }}" />
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">{{ $article['vchr_titulo'] ?? '' }}</h6>
                        </div>
                        <small class="text-muted">{{ $article['dt_post_formatted'] ?? '' }}</small>
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.materia-content img {
    max-width: 100%;
    height: auto;
}

.materia-content {
    font-size: 1.1rem;
    line-height: 1.8;
}

.materia-title {
    font-size: 2.5rem;
    font-weight: bold;
}

.materia-lead {
    font-size: 1.3rem;
    color: #666;
}

.writer-bio img {
    max-width: 150px;
}

.materia-tags .badge {
    cursor: pointer;
    text-decoration: none;
}

.materia-tags .badge:hover {
    opacity: 0.8;
}

.related-articles .card {
    transition: transform 0.2s;
}

.related-articles .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.related-articles .card-title a {
    color: inherit;
    text-decoration: none;
}

.related-articles .card-title a:hover {
    color: #007bff;
}
</style>
@endsection
