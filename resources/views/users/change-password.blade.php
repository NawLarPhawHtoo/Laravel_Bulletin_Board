<!-- @extends('layouts.app') -->
@section('content')
    <link href="{{ asset('css/common.css') }}" rel="stylesheet">

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header py-3">{{ __('Change Password') }}</div>

                    <div class="card-body">
                        <form class="needs-validation" novalidate method="POST" action="{{ route('change.password') }}"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label required text-md-end">{{ __('Current Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('current_password') is-invalid @enderror"
                                        name="current_password" value="{{ old('current_password') }}" required
                                        autocomplete="current_password" autofocus>
                                    <span toggle="#password" class="field-icon"><i class="bi bi-eye-slash"
                                            id="togglePassword"></i></span>
                                    @error('current_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label required text-md-end">{{ __('New Password') }}</label>

                                <div class="col-md-6">
                                    <input id="new_password" type="password"
                                        class="form-control @error('new_password') is-invalid @enderror" name="new_password"
                                        value="{{ old('new_password') }}" required autocomplete="new_password" autofocus>
                                    <span toggle="#new_password" class="field-icon"><i class="bi bi-eye-slash"
                                            id="toggleNewPassword"></i></span>
                                    @error('new_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="new_password_confirmation"
                                    class="col-md-4 col-form-label required text-md-end">{{ __('New Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="new_password_confirmation" type="password"
                                        class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                        name="new_password_confirmation" value="{{ old('new_password_confirmation') }}"
                                        required autocomplete="new_password_confirmation" autofocus>
                                    <span toggle="#new_password_confirmation" class="field-icon"><i class="bi bi-eye-slash"
                                            id="toggleNewPasswordConfirm"></i></span>
                                    @error('new_password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn cmn-btn">
                                        {{ __('Update Password') }}
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
