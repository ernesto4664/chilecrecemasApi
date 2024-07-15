@extends('layouts.main')

@section('title', 'Listado de Noticias')

@section('content')
    <div class="container">
        <h1>Noticias</h1>
        <a href="{{ route('noticias.create') }}" class="btn btn-primary">Crear Noticia</a>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>#</th> <!-- Columna para el contador -->
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Imagen</th>
                    <th>Fecha y Hora</th>
                    <th>Status</th>
                    <th>Privilegio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $contador = 1;
                @endphp
                @foreach($noticias as $noticia)
                    <tr>
                        <td>{{ $contador }}</td> <!-- Mostrar el contador -->
                        <td>{{ $noticia->titulo }}</td>
                        <td>{{ $noticia->descripcion }}</td>
                        <td>{{ $noticia->imagen }}</td>
                        <td>{{ $noticia->fecha_hora }}</td>
                        <td>{{ $noticia->status }}</td>
                        <td>{{ $noticia->privilegio }}</td>
                        <td>
                            <a href="{{ route('noticias.show', $noticia->idnoticia) }}" class="btn btn-info">Ver</a>
                            <a href="{{ route('noticias.edit', $noticia->idnoticia) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('noticias.destroy', $noticia->idnoticia) }}" method="POST" style="display:inline;">
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
                    {{ $noticias->links() }} <!-- Enlaces de paginación -->
                </div>
            </div>
        </div>
    </div>
@endsection
