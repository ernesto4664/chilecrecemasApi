@extends('layouts.main')

@section('title', 'Crear Noticia')

@section('content')
    <div class="container">
        <h1>Crear Noticia</h1>
        <form action="{{ route('noticias.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen:</label>
                <input type="text" class="form-control" id="imagen" name="imagen">
            </div>
            <div class="form-group">
                <label for="fecha_hora">Fecha y Hora:</label>
                <input type="datetime-local" class="form-control" id="fecha_hora" name="fecha_hora">
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <input type="text" class="form-control" id="status" name="status">
            </div>
            <div class="form-group">
                <label for="privilegio">Privilegio:</label>
                <input type="text" class="form-control" id="privilegio" name="privilegio">
            </div>
            <div class="form-group">
                <label for="tags_idtags">Tags:</label>
                <select class="form-control" id="tags_idtags" name="tags_idtags">
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->idtags }}">{{ $tag->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="usuariop_id">Usuario:</label>
                <input type="text" class="form-control" id="usuariop_id" name="usuariop_id">
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection
