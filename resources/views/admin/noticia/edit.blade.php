@extends('layouts.main')

@section('title', 'Editar Noticia')

@section('content')
    <div class="container">
        <h1>Editar Noticia</h1>
        <form action="{{ route('noticias.update', $noticia->idnoticia) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="{{ $noticia->titulo }}" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="5" required>{{ $noticia->descripcion }}</textarea>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen:</label>
                <input type="text" class="form-control" id="imagen" name="imagen" value="{{ $noticia->imagen }}">
            </div>
            <div class="form-group">
                <label for="fecha_hora">Fecha y Hora:</label>
                <input type="datetime-local" class="form-control" id="fecha_hora" name="fecha_hora" value="{{ $noticia->fecha_hora }}">
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <input type="text" class="form-control" id="status" name="status" value="{{ $noticia->status }}">
            </div>
            <div class="form-group">
                <label for="privilegio">Privilegio:</label>
                <input type="text" class="form-control" id="privilegio" name="privilegio" value="{{ $noticia->privilegio }}">
            </div>
            <div class="form-group">
                <label for="tags_idtags">Tags:</label>
                <select class="form-control" id="tags_idtags" name="tags_idtags">
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->idtags }}" {{ $tag->idtags == $noticia->tags_idtags ? 'selected' : '' }}>{{ $tag->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="usuariop_id">Usuario:</label>
                <input type="text" class="form-control" id="usuariop_id" name="usuariop_id" value="{{ $noticia->usuariop_id }}">
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
@endsection
