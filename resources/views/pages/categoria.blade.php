@extends('layouts.home')
@section('contentSection1')
<br />
  

 

    <!-- Main News Start -->
    <div class="main-news">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">

                  <!-- Breadcrumb Start -->
       <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item active">{{ $categoria['nome'] }}</li>
            </ol>
        </nav>
  
    <!-- Breadcrumb End -->

                    <div class="row">
                        <div class="col-md-12">
                            <h2><i class="fas fa-align-justify"></i>{{ $categoria['nome'] }} - Matérias</h2>
                            
                            @if(count($materias) > 0)
                                <div class="row">
                                    <div class="col-lg-12">
                                        @foreach($materias as $index => $materia)
                                            @if($index == 0)
                                                <!-- Matéria Principal -->
                                                <div class="mn-img">
                                                    <img src="{{ $materia['images'][0]['vchr_HRef'] ?? '' }}" alt="{{ $materia['vchr_titulo'] }}" />
                                                </div>
                                                <div class="mn-content">
                                                    <a class="mn-title" href="/{{ $materia['vchr_LinkTitulo'] }}">{{ $materia['vchr_titulo'] }}</a>
                                                    <a class="mn-date" href=""><i class="far fa-clock"></i>{{ $materia['dt_post_formatted'] ?? $materia['created_at_formatted'] ?? '' }}</a>
                                                    <p>{{ $materia['vchr_lide'] ?? '' }}</p>
                                                </div>
                                                <hr style="margin: 30px 0;">
                                            @endif
                                        @endforeach
                                    </div>

                                    <div class="col-lg-12">
                                        <!-- Cards para índices 1, 2, 3 -->
                                        <div class="row">
                                            @foreach($materias as $index => $materia)
                                                @if($index >= 1 && $index <= 3)
                                                    <div class="col-md-4 mb-4">
                                                        <div class="card h-100">
                                                            @if(isset($materia['images']) && count($materia['images']) > 0)
                                                                @php
                                                                    $image = null;
                                                                    foreach($materia['images'] as $img) {
                                                                        if($img['vchr_Tipo'] === 'Top_Materia') {
                                                                            $image = $img;
                                                                            break;
                                                                        }
                                                                    }
                                                                @endphp
                                                                @if($image)
                                                                <img src="{{ asset($image['vchr_HRef']) }}" 
                                                                    class="card-img-top" 
                                                                    alt="{{ $materia['vchr_titulo'] ?? '' }}">
                                                                @endif
                                                            @endif
                                                            <div class="card-body">
                                                                <h5 class="card-title">
                                                                    <a href="/{{ $materia['vchr_LinkTitulo'] ?? '#' }}">
                                                                        {{ $materia['vchr_titulo'] ?? '' }}
                                                                    </a>
                                                                </h5>
                                                                @if(isset($materia['vchr_lide']))
                                                                <p class="card-text">{{ Str::limit($materia['vchr_lide'], 150) }}</p>
                                                                @endif
                                                                <p class="card-text">
                                                                    <small class="text-muted">
                                                                        {{ $materia['dt_post_formatted'] ?? '' }}
                                                                        @if(isset($materia['vchr_autor']))
                                                                        | {{ $materia['vchr_autor'] }}
                                                                        @endif
                                                                    </small>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>



                                    <div class="col-lg-12">
                                        <!-- Lista de Matérias -->
                                        @foreach($materias as $index => $materia)
                                            @if($index >= 4)
                                                <div class="mn-list" style="border-bottom: 1px solid rgba(0,0,0,.1); padding-bottom: 20px; margin-bottom: 20px;">
                                                    <div class="mn-img">
                                                        <img src="{{ $materia['images'][0]['vchr_HRef'] ?? '' }}" alt="{{ $materia['vchr_titulo'] }}" />
                                                    </div>
                                                    <div class="mn-content">
                                                        <a class="mn-title" href="/{{ $materia['vchr_LinkTitulo'] }}">{{ $materia['vchr_titulo'] }}</a>
                                                        <a class="mn-date" href=""><i class="far fa-clock"></i>{{ $materia['dt_post_formatted'] ?? $materia['created_at_formatted'] ?? '' }}</a>
                                                        @if(!empty($materia['vchr_lide']))
                                                            <p>{{ Str::limit($materia['vchr_lide'], 150) }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                             
                                               
                                            @endif
                                             
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Paginação -->
                                @if($paginacao['last_page'] > 1)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination justify-content-center">
                                                    <!-- Primeira Página -->
                                                    @if($paginacao['current_page'] > 1)
                                                        <li class="page-item">
                                                            <a class="page-link" href="?page=1" aria-label="Primeira">&laquo;&laquo;</a>
                                                        </li>
                                                    @endif

                                                    <!-- Botão Anterior -->
                                                    @if($paginacao['current_page'] > 1)
                                                        <li class="page-item">
                                                            <a class="page-link" href="?page={{ $paginacao['current_page'] - 1 }}" aria-label="Anterior">&laquo;</a>
                                                        </li>
                                                    @endif

                                                    @php
                                                        $start = max(1, $paginacao['current_page'] - 4);
                                                        $end = min($paginacao['last_page'], $paginacao['current_page'] + 4);
                                                        
                                                        // Ajusta para sempre mostrar 9 páginas quando possível
                                                        if ($end - $start < 8) {
                                                            if ($start == 1) {
                                                                $end = min($paginacao['last_page'], 9);
                                                            } else {
                                                                $start = max(1, $end - 8);
                                                            }
                                                        }
                                                    @endphp

                                                    <!-- Reticências inicial -->
                                                    @if($start > 1)
                                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                                    @endif

                                                    <!-- Números das Páginas -->
                                                    @for($i = $start; $i <= $end; $i++)
                                                        @if($i == $paginacao['current_page'])
                                                            <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
                                                        @else
                                                            <li class="page-item"><a class="page-link" href="?page={{ $i }}">{{ $i }}</a></li>
                                                        @endif
                                                    @endfor

                                                    <!-- Reticências final -->
                                                    @if($end < $paginacao['last_page'])
                                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                                    @endif

                                                    <!-- Botão Próximo -->
                                                    @if($paginacao['current_page'] < $paginacao['last_page'])
                                                        <li class="page-item">
                                                            <a class="page-link" href="?page={{ $paginacao['current_page'] + 1 }}" aria-label="Próximo">&raquo;</a>
                                                        </li>
                                                    @endif

                                                    <!-- Última Página -->
                                                    @if($paginacao['current_page'] < $paginacao['last_page'])
                                                        <li class="page-item">
                                                            <a class="page-link" href="?page={{ $paginacao['last_page'] }}" aria-label="Última">&raquo;&raquo;</a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </nav>
                                            
                                            <p class="text-center text-muted">
                                                Página {{ $paginacao['current_page'] }} de {{ $paginacao['last_page'] }} 
                                                ({{ $paginacao['total'] }} matérias)
                                            </p>
                                        </div>
                                    </div>
                                @endif

                            @else
                                <div class="alert alert-info">
                                    Nenhuma matéria encontrada nesta categoria.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-md-4">
                    <div class="sidebar">
                        <div class="sidebar-widget">
                            <h2><i class="fas fa-align-justify"></i>Últimas Matérias</h2>
                            <div class="list-group">
                            @foreach($ultimasMaterias as $materia)
                                        <a href="/{{ $materia['vchr_LinkTitulo'] }}"   class="list-group-item list-group-item-action">
                                            <img class="img-fluid" src="{{ $materia['images'][0]['vchr_HRef'] ?? '' }}" alt="{{ $materia['vchr_titulo'] }}" />
                                       
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">{{ $materia['vchr_titulo'] ?? '' }}</h6>
                                        </div>
                                        <small class="text-muted"><i class="far fa-clock"></i>{{ $materia['created_at_formatted'] ?? '' }}</small>
                                </a>
                                <br/>
                            @endforeach
                             </div>
                        </div>

                        <div class="sidebar-widget">
                            <h2><i class="fas fa-align-justify"></i>Categorias</h2>
                            <div class="category">
                                <ul class="fa-ul">
                                    @foreach($categorias as $cat)
                                        @php
                                            $linkCat = !empty($cat['tag']) ? strtolower($cat['tag']) : strtolower($cat['nome']);
                                        @endphp
                                        <li>
                                            <span class="fa-li"><i class="far fa-arrow-alt-circle-right"></i></span>
                                            <a href="/{{ $linkCat }}">{{ $cat['nome'] }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="sidebar-widget">
                            <h2><i class="fas fa-align-justify"></i>Ads</h2>
                            <div class="image">
                                <a href=""><img src="{{ asset('img/adds-1.jpg') }}" alt="Advertisement"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main News End -->

<style>
.card {
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.card-title a {
    color: inherit;
    text-decoration: none;
}

.card-title a:hover {
    color: #007bff;
}
</style>
@endsection
