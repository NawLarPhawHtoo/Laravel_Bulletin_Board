<!-- @extends('layouts.app') -->
@section('content')
    <link href="{{ asset('css/post.css') }}" rel="stylesheet">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header py-3">{{ __('Edit Post Confirm') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('posts.update', $id) }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <label for="title"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Title') }}</label>

                                <div class="col-md-6">
                                    <input id="title" type="text"
                                        class="form-control @error('title') is-invalid @enderror" readonly="readonly"
                                        name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="description"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>

                                <div class="col-md-6">
                                    <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror"
                                        readonly="readonly" name="description" required autocomplete="description">{{ old('description') }}</textarea>

                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">

                                <label class="col-md-4 form-check-label text-md-end"
                                    for="status">{{ __('Status') }}</label>

                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" name="status"
                                            id="status" @if (old('status') !== null) checked="checked" @endif
                                            readonly onclick="return false;"/>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    @method('POST')
                                    <button type="submit" class="btn cmn-btn">
                                        {{ __('Confirm') }}
                                    </button>
                                    <a class="cancel-btn btn btn-secondary"
                                        onClick="window.history.back()">{{ __('Cancel') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
