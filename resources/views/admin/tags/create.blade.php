@extends('layouts.main')
@section('title', 'Crear de Tags')
@section('content')
    <div class="container">
        <h1>Create Tag</h1>
        <form action="{{ route('tags.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="form-control">
            </div>
            <div class="form-group">
                <label for="prioridad">Prioridad:</label>
                <input type="number" name="prioridad" id="prioridad" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
