@extends('adminlte::page')

@section('title', 'Configurações do site')

@section('content_header')
    <h1>Configurações do site</h1>
@stop

@section('content')
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="card">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Nome do site</label>
                    <input type="text" name="site_name" class="form-control @error('site_name') is-invalid @enderror" value="{{ old('site_name', $settings->site_name) }}" required>
                    @error('site_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Slogan do site</label>
                    <input type="text" name="site_slogan" class="form-control @error('site_slogan') is-invalid @enderror" value="{{ old('site_slogan', $settings->site_slogan) }}">
                    @error('site_slogan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Cor primária</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" value="{{ old('color_primary', $settings->color_primary ?? '#1a1a1a') }}" oninput="document.getElementById('color_primary').value = this.value">
                            <input type="text" id="color_primary" name="color_primary" class="form-control @error('color_primary') is-invalid @enderror" value="{{ old('color_primary', $settings->color_primary ?? '#1a1a1a') }}" required>
                        </div>
                        @error('color_primary')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Cor secundária</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" value="{{ old('color_secondary', $settings->color_secondary ?? '#4a4a4a') }}" oninput="document.getElementById('color_secondary').value = this.value">
                            <input type="text" id="color_secondary" name="color_secondary" class="form-control @error('color_secondary') is-invalid @enderror" value="{{ old('color_secondary', $settings->color_secondary ?? '#4a4a4a') }}" required>
                        </div>
                        @error('color_secondary')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Cor de destaque (Accent)</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" value="{{ old('color_accent', $settings->color_accent ?? '#e67e22') }}" oninput="document.getElementById('color_accent').value = this.value">
                            <input type="text" id="color_accent" name="color_accent" class="form-control @error('color_accent') is-invalid @enderror" value="{{ old('color_accent', $settings->color_accent ?? '#e67e22') }}" required>
                        </div>
                        @error('color_accent')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Salvar Configurações</button>
            </div>
        </form>
    </div>
@stop
