@extends('layouts.main')

@section('title', 'Detalle de Noticia')

@section('content')
    <div class="container">
        <h1>Detalle de Noticia</h1>
        <div class="card">
            <div class="card-header">
                {{ $noticia->titulo }}
            </div>
            <div class="card-body">
                <p><strong>Descripción:</strong> {{ $noticia->descripcion }}</p>
                <p><strong>Imagen:</strong> <img src="{{ $noticia->imagen }}" alt="Imagen de la noticia" style="max-width: 100px;"></p>
                <p><strong>Fecha y Hora:</strong> {{ $noticia->fecha_hora }}</p>
                <p><strong>Status:</strong> {{ $noticia->status }}</p>
                <p><strong>Privilegio:</strong> {{ $noticia->privilegio }}</p>
                <p><strong>Tags:</strong> {{ $noticia->tag->nombre }}</p>
                <p><strong>Usuario:</strong> {{ $noticia->usuariop_id }}</p>
            </div>
        </div>
        <a href="{{ route('noticias.index') }}" class="btn btn-primary mt-3">Volver al Listado</a>
    </div>
@endsection
