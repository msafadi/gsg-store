@extends('layouts.admin')

@section('title')
<div class="d-flex justify-content-between">
    <h2>Settings</h2>
</div>
@endsection

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active">Settings</li>
</ol>
@endsection

@section('content')

<form action="{{ route('settings') }}" method="post">
    @csrf
    <div class="form-group">
        <x-form-input label="App Name" name="config[app.name]" :value="config('app.name')" />
    </div>
    <div class="form-group">
        <x-form-select label="Currency" name="config[app.currency]" :options="$currencies" :selected="config('app.currency')" />
    </div>
    <div class="form-group">
        <x-form-select label="Default Language" name="config[app.locale]" :options="$locales" :selected="config('app.locale')" />
    </div>

    <div class="form-group">
        <x-form-input label="SMTP Host" name="config[mail.mailers.smtp.host]" :value="config('mail.mailers.smtp.host')" />
    </div>
    <div class="form-group">
        <x-form-input label="SMTP Port" name="config[mail.mailers.smtp.port]" :value="config('mail.mailers.smtp.port')" />
    </div>
    <div class="form-group">
        <x-form-input label="SMTP Username" name="config[mail.mailers.smtp.username]" :value="config('mail.mailers.smtp.username')" />
    </div>
    <div class="form-group">
        <x-form-input label="SMTP Password" type="password" name="config[mail.mailers.smtp.password]" :value="config('mail.mailers.smtp.password')" />
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Save</button>
</form>

@endsection