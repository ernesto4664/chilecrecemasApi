@extends('layouts.main')
@section('title', 'Usuarios Registrados y sus Grupos Familiares')
@section('content')
<div class="container mt-5">
    <h1>Usuarios Registrados y sus Grupos Familiares</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Edad</th>
                <th>Región</th>
                <th>Comuna</th>
                <th>Familiares</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->nombres }} {{ $usuario->apellidos }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->edad }} años</td>
                    <td>{{ $usuario->region ? $usuario->region->nombre : 'No aplica' }}</td>
                    <td>{{ $usuario->comuna ? $usuario->comuna->nombre : 'No aplica' }}</td>
                    <td>
                        @if($usuario->familiares->isEmpty())
                            <p>No hay familiares registrados.</p>
                        @else
                            <ul>
                                @foreach($usuario->familiares as $familiar)
                                    <li>
                                        {{ $familiar->nombres }} {{ $familiar->apellidos }} - {{ $familiar->parentesco }}
                                        ({{ $familiar->edad }} años, Sexo: {{ $familiar->sexo }},
                                        Fecha de Nacimiento: {{ $familiar->fecha_nacimiento }})
                                        @if($familiar->semanasEmbarazo)
                                            , Semanas de Embarazo: {{ $familiar->semanasEmbarazo->semana }}
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
