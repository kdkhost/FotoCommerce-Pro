@extends('adminlte::page')

@section('title', 'Álbuns')

@section('content_header')
    <h1>Álbuns</h1>
@stop

@section('content')
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.albums.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Novo álbum
            </a>
        </div>
        <div class="card-body p-0">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Capa</th>
                        <th>Título</th>
                        <th>Categoria</th>
                        <th>Status</th>
                        <th>Visibilidade</th>
                        <th>Fotos</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($albums as $album)
                        <tr>
                            <td>
                                @if ($album->cover_image)
                                    <img src="{{ Illuminate\Support\Facades\Storage::disk('photos_public')->url($album->cover_image) }}" alt="" style="width:56px;height:42px;object-fit:cover;border-radius:.25rem;">
                                @endif
                            </td>
                            <td>{{ $album->title }}</td>
                            <td>{{ $album->category?->name ?? '—' }}</td>
                            <td><span class="badge text-bg-secondary">{{ $album->status->value }}</span></td>
                            <td><span class="badge text-bg-info">{{ $album->visibility->value }}</span></td>
                            <td>
                                <a href="{{ route('admin.albums.photos.index', $album) }}">
                                    {{ $album->photos_count }} <i class="bi bi-camera"></i>
                                </a>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.albums.edit', $album) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.albums.destroy', $album) }}" method="POST" class="d-inline" onsubmit="return confirm('Remover este álbum e todas as suas fotos?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Nenhum álbum cadastrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $albums->links() }}
        </div>
    </div>
@stop
