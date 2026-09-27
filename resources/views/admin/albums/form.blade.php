@extends('adminlte::page')

@section('title', $album->exists ? 'Editar álbum' : 'Novo álbum')

@section('content_header')
    <h1>{{ $album->exists ? 'Editar álbum' : 'Novo álbum' }}</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ $album->exists ? route('admin.albums.update', $album) : route('admin.albums.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($album->exists)
                @method('PUT')
            @endif

            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label">Título</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $album->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Slug (opcional, gerado automaticamente se vazio)</label>
                            <input type="text" name="slug" class="form-control" value="{{ old('slug', $album->slug) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descrição</label>
                            <textarea name="description" class="form-control" rows="4">{{ old('description', $album->description) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nome do evento</label>
                                <input type="text" name="event_name" class="form-control" value="{{ old('event_name', $album->event_name) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Local do evento</label>
                                <input type="text" name="event_location" class="form-control" value="{{ old('event_location', $album->event_location) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Data do evento</label>
                            <input type="date" name="event_date" class="form-control" value="{{ old('event_date', optional($album->event_date)->format('Y-m-d')) }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Categoria</label>
                            <select name="category_id" class="form-select">
                                <option value="">Sem categoria</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id', $album->category_id) == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                @foreach (['draft' => 'Rascunho', 'published' => 'Publicado', 'private' => 'Privado', 'archived' => 'Arquivado', 'closed' => 'Fechado'] as $value => $label)
                                    <option value="{{ $value }}" @selected(old('status', $album->status?->value ?? 'draft') === $value)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Visibilidade</label>
                            <select name="visibility" id="visibility" class="form-select">
                                @foreach (['public' => 'Público', 'private' => 'Privado', 'password' => 'Protegido por senha'] as $value => $label)
                                    <option value="{{ $value }}" @selected(old('visibility', $album->visibility?->value ?? 'public') === $value)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Senha (apenas se protegido por senha)</label>
                            <input type="password" name="password" class="form-control" placeholder="Deixe em branco para manter a atual">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Capa do álbum</label>
                            <input type="file" name="cover_image" class="form-control" accept="image/*">
                            @if ($album->cover_image)
                                <img src="{{ Illuminate\Support\Facades\Storage::disk('photos_public')->url($album->cover_image) }}" alt="" class="mt-2" style="max-width:100%;border-radius:.5rem;">
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('admin.albums.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
@stop
