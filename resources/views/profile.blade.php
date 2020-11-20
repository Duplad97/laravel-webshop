@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Adatok') }}</div>

                <div class="card-body">
                <h6 class="card-title mb-2">Név: {{ $user->name }}</h6>
                <h6 class="card-title mb-2">Email cím: {{ $user->email }}</h6>
                <h6 class="card-title mb-2">Szerepkör: {{ $user->is_admin ? __('Admin') : __('Felhasználó') }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection