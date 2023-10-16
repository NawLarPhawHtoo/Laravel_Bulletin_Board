<!-- @extends('layouts.app') -->
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header py-3">{{ __(' Upload CSV File') }}</div>
                    <div class="card-body">

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (isset($errors) && $errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif

                        @if (session()->has('failures'))
                            <table class="table table-danger">
                                <tr>
                                    <th>Row</th>
                                    <th>Attribute</th>
                                    <th>Errors</th>
                                    <th>Value</th>
                                </tr>
                                @foreach (session()->get('failures') as $validation)
                                    <tr>
                                        <td>{{ $validation->row() }}</td>
                                        <td>{{ $validation->attribute() }}</td>
                                        <td>
                                            <ul>
                                                @foreach ($validation->errors() as $e)
                                                    <li>{{ $e }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            {{ $validation->values()[$validation->attribute()] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif

                        <form method="POST" action="{{ route('posts.fileupload') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row my-3">
                                <label for="file"
                                    class="col-md-4 col-form-label text-md-end">{{ __('CSV File') }}</label>

                                <div class="col-md-6">
                                    <input id="file" type="file"
                                        class="form-control @error('file') is-invalid @enderror" name="file" required
                                        autofocus>

                                    @error('file')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <button class="btn cmn-btn">
                                        {{ __('Upload') }}
                                    </button>
                                    <button type="reset" class="btn btn-secondary">
                                        {{ __('Clear') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
