@extends('layouts.main')

@section('title', 'Editar Noticia')

@section('content')
    <div class="container mt-3">
        <h1>Editar Noticia</h1>
        <form action="{{ route('noticias.update', $noticia->idnoticia) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="titulo">Título:</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" value="{{ $noticia->titulo }}" required>
                    </div>
                

                    <div class="form-group mb-3">
                        <label for="descripcion">Descripción:</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="5" required>{{ $noticia->descripcion }}</textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="imagen">Imagen:</label>
                        <input type="file" class="form-control" id="imagen" name="imagen">
                        @if($noticia->imagen)
                            <div class="mt-2">
                                <img src="{{ asset($noticia->imagen) }}" alt="Imagen actual" class="img-thumbnail" width="300">
                            </div>
                        @endif
                    </div>
                </div>
                    

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="fecha_hora">Fecha y Hora:</label>
                        <input type="datetime-local" class="form-control" id="fecha_hora" name="fecha_hora" value="{{ $noticia->fecha_hora }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="status">Status:</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Seleccione uno</option>
                            <option value="Publicada" {{ $noticia->status == 'Publicada' ? 'selected' : '' }}>Publicada</option>
                            <option value="Desactivada o Archivada" {{ $noticia->status == 'Desactivada o Archivada' ? 'selected' : '' }}>Desactivada o Archivada</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="privilegio">Prioridad:</label>
                        <select name="privilegio" id="privilegio" class="form-select" aria-label="Default select example" required>
                            <option selected disabled value="">Seleccione Uno</option>
                            <option value="1" {{ $noticia->privilegio == 1 ? 'selected' : '' }}>1</option>
                            <option value="2" {{ $noticia->privilegio == 2 ? 'selected' : '' }}>2</option>
                            <option value="3" {{ $noticia->privilegio == 3 ? 'selected' : '' }}>3</option>
                            <option value="4" {{ $noticia->privilegio == 4 ? 'selected' : '' }}>4</option>
                            <option value="5" {{ $noticia->privilegio == 5 ? 'selected' : '' }}>5</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="tags_idtags">Tags:</label>
                        <select class="form-select" id="tags_idtags" name="tags_idtags">
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->idtags }}" {{ $tag->idtags == $noticia->tags_idtags ? 'selected' : '' }}>{{ $tag->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3" style="display:none">
                        <label for="usuariop_id">Usuario:</label>
                        <input type="text" class="form-control" id="usuariop_id" name="usuariop_id" value="1">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </div>
        </form>
    </div>
@endsection
