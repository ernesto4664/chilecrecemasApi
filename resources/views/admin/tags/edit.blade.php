@extends('layouts.main')
@section('title', 'Editar Tag')
@section('content')
    <div class="container mt-3">
        <h1>Editar Tag</h1>
        <form action="{{ route('tags.update', $tag->idtags) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $tag->nombre) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="prioridad">Prioridad:</label>
                            <select class="form-select" name="prioridad" id="prioridad" required>
                                <option value="" disabled>Seleccione uno</option>
                                <option value="1" {{ old('prioridad', $tag->prioridad) == 1 ? 'selected' : '' }}>1</option>
                                <option value="2" {{ old('prioridad', $tag->prioridad) == 2 ? 'selected' : '' }}>2</option>
                                <option value="3" {{ old('prioridad', $tag->prioridad) == 3 ? 'selected' : '' }}>3</option>
                                <option value="4" {{ old('prioridad', $tag->prioridad) == 4 ? 'selected' : '' }}>4</option>
                                <option value="5" {{ old('prioridad', $tag->prioridad) == 5 ? 'selected' : '' }}>5</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mt-2">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary mt-3">Guardar Cambios</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
