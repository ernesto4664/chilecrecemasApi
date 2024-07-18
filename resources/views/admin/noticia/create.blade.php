@extends('layouts.main')

@section('title', 'Crear Noticia')

@section('content')
    <div class="container mt-3">
        <h1>Crear Noticia</h1>
        <form action="{{ route('noticias.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="titulo">Título:</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="descripcion">Descripción:</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="5" required></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="imagen">Imagen:</label>
                        <input type="file" class="form-control" id="imagen" name="imagen">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="fecha_hora">Fecha y Hora:</label>
                        <input type="datetime-local" class="form-control" id="fecha_hora" name="fecha_hora">
                    </div>
                    <div class="form-group mb-3">
                        <label for="status">Status:</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Seleccione uno</option>
                            <option value="Publicada">Publicada</option>
                            <option value="Desactivada o Archivada">Desactivada o Archivada</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="privilegio">Prioridad:</label>
                        <select name="privilegio" id="privilegio" class="form-select" aria-label="Default select example" required>
                            <option selected disabled value="">Seleccione Uno</option>
                            <option value="1" {{ old('prioridad') == 1 ? 'selected' : '' }}>1</option>
                            <option value="2" {{ old('prioridad') == 2 ? 'selected' : '' }}>2</option>
                            <option value="3" {{ old('prioridad') == 3 ? 'selected' : '' }}>3</option>
                            <option value="4" {{ old('prioridad') == 4 ? 'selected' : '' }}>4</option>
                            <option value="5" {{ old('prioridad') == 5 ? 'selected' : '' }}>5</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="tags_idtags">Tags:</label>
                        <select class="form-select" id="tags_idtags" name="tags_idtags">
                            <option value="">Seleccione uno</option>
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->idtags }}">{{ $tag->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3" style="display:none">
                        <label for="usuariop_id">Usuario:</label>
                        <input type="text" class="form-control" value="1" id="usuariop_id" name="usuariop_id">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mb-5">Guardar</button>
        </form>
    </div>
@endsection
