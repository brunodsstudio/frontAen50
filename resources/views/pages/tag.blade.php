@extends('layouts.home')

@section('contentSection1')
<div class="container-fluid">
    <div class="row">
        <!-- Main Content -->
        <div class="col-md-9">
            <h2 class="mb-4">Tag: {{ $tag }}</h2>
            
            @if(count($materias) > 0)
                <div class="row">
                    @foreach($materias as $materia)
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
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">
                    Nenhuma matéria encontrada com a tag "{{ $tag }}".
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="sidebar">
                <h4 class="mb-3">Últimas Matérias</h4>
                @if(isset($ultimasMaterias) && count($ultimasMaterias) > 0)
                <div class="list-group">
                    @foreach($ultimasMaterias as $materia)
                    <a href="/{{ $materia['vchr_LinkTitulo'] ?? '#' }}" 
                       class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">{{ $materia['vchr_titulo'] ?? '' }}</h6>
                        </div>
                        <small class="text-muted">{{ $materia['dt_post_formatted'] ?? '' }}</small>
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

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
