@extends('adminlte::page')

@section('title', 'Perfil do fotógrafo')

@section('content_header')
    <h1>Perfil do fotógrafo</h1>
@stop

@section('content')
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="card">
        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Título do site</label>
                    <input type="text" name="site_title" class="form-control @error('site_title') is-invalid @enderror" value="{{ old('site_title', $profile->site_title) }}" required>
                    @error('site_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Subtítulo</label>
                    <input type="text" name="site_subtitle" class="form-control @error('site_subtitle') is-invalid @enderror" value="{{ old('site_subtitle', $profile->site_subtitle) }}" required>
                    @error('site_subtitle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Texto "Sobre"</label>
                    <textarea name="about_text" class="form-control @error('about_text') is-invalid @enderror" rows="4" required>{{ old('about_text', $profile->about_text) }}</textarea>
                    @error('about_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Biografia (opcional)</label>
                    <textarea name="bio" class="form-control" rows="3">{{ old('bio', $profile->bio) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">WhatsApp (com DDI+DDD, só números)</label>
                        <input type="text" name="whatsapp_number" class="form-control @error('whatsapp_number') is-invalid @enderror" value="{{ old('whatsapp_number', $profile->whatsapp_number) }}" placeholder="5521999999999" required>
                        @error('whatsapp_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">E-mail de contato</label>
                        <input type="email" name="contact_email" class="form-control @error('contact_email') is-invalid @enderror" value="{{ old('contact_email', $profile->contact_email) }}" required>
                        @error('contact_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Endereço / localização</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address', $profile->address) }}">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Instagram (URL)</label>
                        <input type="url" name="instagram" class="form-control" value="{{ old('instagram', $profile->social_links['instagram'] ?? '') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Facebook (URL)</label>
                        <input type="url" name="facebook" class="form-control" value="{{ old('facebook', $profile->social_links['facebook'] ?? '') }}">
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
@stop
