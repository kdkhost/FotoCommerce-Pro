@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-primary">
                <div class="inner">
                    <h3>{{ $albumsCount }}</h3>
                    <p>Álbuns</p>
                </div>
                <i class="bi bi-images small-box-icon"></i>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-success">
                <div class="inner">
                    <h3>{{ $publishedAlbumsCount }}</h3>
                    <p>Álbuns publicados</p>
                </div>
                <i class="bi bi-check-circle small-box-icon"></i>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-warning">
                <div class="inner">
                    <h3>{{ $categoriesCount }}</h3>
                    <p>Categorias</p>
                </div>
                <i class="bi bi-tags small-box-icon"></i>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-info">
                <div class="inner">
                    <h3>{{ $photosCount }}</h3>
                    <p>Fotos</p>
                </div>
                <i class="bi bi-camera small-box-icon"></i>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <p class="mb-0">
                Use o menu lateral para gerenciar <strong>Álbuns</strong>, <strong>Categorias</strong>,
                o <strong>Perfil do fotógrafo</strong> e as <strong>Configurações do site</strong>.
                As alterações feitas aqui aparecem imediatamente na página pública.
            </p>
        </div>
    </div>
@stop
