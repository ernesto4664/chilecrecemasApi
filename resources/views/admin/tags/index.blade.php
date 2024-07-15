@extends('layouts.main')

@section('title', 'Listado de Tags')

@section('content')
    <div class="container mt-3">
        <h1>Tags</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($tags->isEmpty())
            <div class="alert alert-info mt-3">
                No hay etiquetas registradas.
            </div>
        @else
            <div class="table-responsive mt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Prioridad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $contador = 1;
                        @endphp
                        @foreach($tags as $tag)
                            <tr>
                                <td>{{ $contador }}</td> <!-- Mostrar el contador -->
                                <td>{{ $tag->nombre }}</td>
                                <td>{{ $tag->prioridad }}</td>
                                <td>
                                    <a href="{{ route('tags.show', $tag->idtags) }}" class="btn btn-info">Ver</a>
                                    <a href="{{ route('tags.edit', $tag->idtags) }}" class="btn btn-warning">Editar</a>
                                    <form action="{{ route('tags.destroy', $tag->idtags) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            @php
                                $contador++;
                            @endphp
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
        @endif

        <a href="{{ route('tags.create') }}" class="btn btn-primary mt-3">Crear nuevo Tag</a>
    </div>
@endsection
