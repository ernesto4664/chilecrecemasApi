@extends('layouts.main')
@section('title', 'Registro de Tags')
@section('content')
    <div class="container">
        <h1>Tags</h1>
        <a href="{{ route('tags.create') }}" class="btn btn-primary">Create Tag</a>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Prioridad</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tags as $tag)
                    <tr>
                        <td>{{ $tag->idtags }}</td>
                        <td>{{ $tag->nombre }}</td>
                        <td>{{ $tag->prioridad }}</td>
                        <td>
                            <a href="{{ route('tags.show', $tag->idtags) }}" class="btn btn-info">View</a>
                            <a href="{{ route('tags.edit', $tag->idtags) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('tags.destroy', $tag->idtags) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center paginacion">
                    {{ $tags->links() }} <!-- Enlaces de paginación -->
                </div>
            </div>
        </div>
    </div>
@endsection
