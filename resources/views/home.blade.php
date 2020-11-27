@extends('adminlte::page')

@section('title', 'Chuá Sorveteria')

@section('content_header')
<h1>Visão Geral</h1>
@stop

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-gradient-success">
            <div class="inner">
                <h3>R$ {{ number_format($totalRecebido, 2, ',', '.') }}</h3>
                <p>Vendas do Dia</p>
            </div>
            <div class="icon">
                <i class="fa fa-chart-bar"></i>
            </div>
            <a href="{{ route('vendas.index') }}" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-gradient-info">
            <div class="inner">
                <h3>{{ $contasReceber }}</h3>
                <p>{{ $contasReceber == 1 ? 'Conta a Receber' : 'Contas a Receber'}}</p>
            </div>
            <div class="icon">
                <i class="fa fa-cash-register"></i>
            </div>
            <a href="{{ route('contas-a-receber.index') }}" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-gradient-danger">
            <div class="inner">
                <h3>{{ $contasPagar ?? '-' }}</h3>
                <p>{{ $contasPagar == 1 ? 'Conta a Pagar' : 'Contas a Pagar'}}</p>
            </div>
            <div class="icon">
                <i class="fa fa-chart-pie"></i>
            </div>
            <a href="{{ route('contas-a-pagar.index') }}" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-gradient-warning">
            <div class="inner">
                <h3>{{ $totalClientes }}</h3>

                <p>Clientes Registrados</p>
            </div>
            <div class="icon">
                <i class="fa fa-user-plus"></i>
            </div>
            <a href="{{ route('clientes.index') }}" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
@stop
