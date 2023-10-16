<!-- @extends('layouts.app') -->
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header py-3">{{ __('User Edit Confirm') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('users.update', $id) }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="type"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Type') }}</label>

                                <div class="col-md-6">
                                    <input id="type" type="text"
                                        class="form-control @error('type') is-invalid @enderror" name="type"
                                        value="{{ old('type') == 1 ? 'User' : 'Admin' }}" required autocomplete="type" autofocus readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="phone"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Phone') }}</label>

                                <div class="col-md-6">
                                    <input id="phone" type="text"
                                        class="form-control @error('phone') is-invalid @enderror" name="phone" required
                                        autocomplete="phone" value="{{ old('phone') }}" readonly />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="dob"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Date of Birth') }}</label>

                                <div class="col-md-6">
                                    <input id="dob" type="date"
                                        class="form-control @error('dob') is-invalid @enderror" name="dob" required
                                        autocomplete="dob" value="{{ old('dob') }}" readonly />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="address"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Address') }}</label>

                                <div class="col-md-6">
                                    <textarea id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address"
                                        required autocomplete="address" readonly>{{ old('address') }} </textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="profile"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Profile') }}</label>

                                <div class="col-md-6">
                                    <input id="profile" type="text"
                                        class="form-control mb-3 @error('profile') is-invalid @enderror" name="profile" required
                                        autocomplete="profile" value="{{ session('profile') }}" readonly />
                                    <img class="profile-image" src="{{ asset('profiles/' . Session::get('profile')) }}"
                                        alt="Profile Image" />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
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
