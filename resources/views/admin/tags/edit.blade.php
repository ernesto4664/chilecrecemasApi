@extends('layouts.main')
@section('title', 'Crear de Tags')
@section('content')
    <div class="container">
        <h1>Edit Tag</h1>
        <form action="{{ route('tags.update', $tag->idtags) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $tag->nombre }}">
            </div>
            <div class="form-group">
                <label for="prioridad">Prioridad:</label>
                <input type="number" name="prioridad" id="prioridad" class="form-control" value="{{ $tag->prioridad }}">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
