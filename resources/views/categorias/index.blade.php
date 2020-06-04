@extends('adminlte::page')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <i class="fa fa-list"></i>
            <h4 class="ml-3 mb-0">Categorias</h4>
        </div>
    </div>

    <div class="card-body">
        <div class="row">

            <div class="col-md-6">
                 <form method="GET" action="{{ route('categorias.index') }}">
                    <div class="input-group mb-3">
                        <input class="form-control" name="search" value="{{ request('search') ?? '' }}" />
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit" >
                                <i class="fa fa-search"></i> Buscar
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-6 text-right">
                <a href="{{ route('categorias.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Adicionar
                </a>
            </div>

            <hr>

            <div class="col-md-12 table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Cód.</th>
                            <th>Categoria</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($categorias as $categoria)
                        <tr>
                            <td>{{ $categoria->id }}</td>
                            <td>{{ $categoria->categoria }}</td>
                            <td class="text-center">
                                <div class="row no-gutters d-flex justify-content-center">
                                    <a class="btn btn-sm btn-spinner btn-primary mr-2" href="{{ route('categorias.edit', $categoria->id) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="alert alert-danger text-center">
                                    <i class="fa fa-exclamation-triangle"></i>
                                    Nenhum registro encontrado!
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

@endsection
