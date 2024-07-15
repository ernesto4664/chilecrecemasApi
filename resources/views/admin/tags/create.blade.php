@extends('layouts.main')
@section('title', 'Crear de Tags')
@section('content')
    <div class="container mt-3">
        <h1>Creación de Tag</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tags.store') }}" method="POST">
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" required value="{{ old('nombre') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="prioridad">Prioridad:</label>
                            <select name="prioridad" id="prioridad" class="form-select" aria-label="Default select example" required>
                                <option selected disabled value="">Seleccione Uno</option>
                                <option value="1" {{ old('prioridad') == 1 ? 'selected' : '' }}>1</option>
                                <option value="2" {{ old('prioridad') == 2 ? 'selected' : '' }}>2</option>
                                <option value="3" {{ old('prioridad') == 3 ? 'selected' : '' }}>3</option>
                                <option value="4" {{ old('prioridad') == 4 ? 'selected' : '' }}>4</option>
                                <option value="5" {{ old('prioridad') == 5 ? 'selected' : '' }}>5</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mt-2">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
