@extends('adminlte::page')

@section('title', 'Fotos — '.$album->title)

@section('content_header')
    <h1>Fotos — {{ $album->title }}</h1>
@stop

@section('content')
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.albums.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Voltar para álbuns
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.albums.photos.store', $album) }}" method="POST" enctype="multipart/form-data" class="mb-4">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Enviar novas fotos</label>
                    <input type="file" name="photos[]" class="form-control @error('photos') is-invalid @enderror" accept="image/*" multiple required>
                    @error('photos')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @error('photos.*')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-upload"></i> Enviar fotos
                </button>
            </form>

            <div class="row">
                @forelse ($photos as $photo)
                    @php $file = $photo->files->first(); @endphp
                    <div class="col-md-3 col-6 mb-4">
                        <div class="card h-100">
                            @if ($file)
                                <img src="{{ Illuminate\Support\Facades\Storage::disk($file->disk)->url($file->path) }}" class="card-img-top" style="aspect-ratio:4/3;object-fit:cover;" alt="">
                            @endif
                            <div class="card-body p-2 d-flex justify-content-between align-items-center">
                                <form action="{{ route('admin.albums.photos.toggle-featured', [$album, $photo]) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $photo->is_featured ? 'btn-warning' : 'btn-outline-warning' }}" title="Destaque">
                                        <i class="bi bi-star-fill"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.albums.photos.destroy', [$album, $photo]) }}" method="POST" onsubmit="return confirm('Remover esta foto?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted py-4">Nenhuma foto enviada ainda.</div>
                @endforelse
            </div>
        </div>
    </div>
@stop
