@extends('layouts.admin')

@section('content')

    <h2>User Profile</h2>
    @if (session('status') == 'profile-information-updated')
        <div class="alert alert-success">
            Your profile updated.
        </div>
    @endif
    <form action="{{ route('user-profile-information.update') }}" method="post">
        @csrf
        @method('put')
        <div class="form-group">
            <label for="">{{ __('Name') }}</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}">
            @error('name')
            <p class="invalid-feedback">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="">{{ __('Email') }}</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}">
            @error('email')
            <p class="invalid-feedback">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <button class="btn btn-primary" type="submit">Update</button>
        </div>
    </form>
    <hr>
    <h2>Two Factor Authentication</h2>
    @if (session('status') == 'two-factor-authentication-enabled')
        <div class="alert alert-success">
            Two factor authentication has been enabled.
        </div>
    @endif
    <h5>Recovery Codes</h5>
    <ul>
        @foreach ($user->recoveryCodes() as $code)
        <li>{{ $code }}</li>
        @endforeach
    </ul>
    {!! $user->twoFactorQrCodeSvg() !!}

    <form action="{{ route('two-factor.enable') }}" method="post">
        @csrf
        <button class="btn btn-success" type="submit">Enable</button>
    </form>

@endsection