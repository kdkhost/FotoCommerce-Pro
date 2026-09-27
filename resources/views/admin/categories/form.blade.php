@extends('adminlte::page')

@section('title', $category->exists ? 'Editar categoria' : 'Nova categoria')

@section('content_header')
    <h1>{{ $category->exists ? 'Editar categoria' : 'Nova categoria' }}</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST">
            @csrf
            @if ($category->exists)
                @method('PUT')
            @endif

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Slug (opcional, gerado automaticamente se vazio)</label>
                    <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $category->slug) }}">
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Descrição</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ordem</label>
                    <input type="number" name="order_column" class="form-control" value="{{ old('order_column', $category->order_column ?? 0) }}">
                </div>

                <div class="form-check form-switch">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Ativa</label>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
@stop
