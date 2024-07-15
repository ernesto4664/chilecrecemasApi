@extends('layouts.main')
@section('title', 'Crear de Tags')
@section('content')
    <div class="container">
        <h1>Tag Details</h1>
        <table class="table">
            <tr>
                <th>ID:</th>
                <td>{{ $tag->idtags }}</td>
            </tr>
            <tr>
                <th>Nombre:</th>
                <td>{{ $tag->nombre }}</td>
            </tr>
            <tr>
                <th>Prioridad:</th>
                <td>{{ $tag->prioridad }}</td>
            </tr>
        </table>
        <a href="{{ route('tags.index') }}" class="btn btn-primary">Back</a>
    </div>
@endsection
