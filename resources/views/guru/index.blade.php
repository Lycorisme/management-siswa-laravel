@extends('layouts.app')

@section('title', 'Data Guru/Staff')

@section('content')
<div x-data="guruApp()" x-init="init()">
    
    {{-- Header & Statistics --}}
    @include('guru.partials.header')

    {{-- Main Content Card --}}
    <div class="glass-card rounded-3xl overflow-hidden">
        
        {{-- Filter & Search Bar --}}
        @include('guru.partials.filter')

        {{-- Data Table --}}
        @include('guru.partials.table')

        {{-- Pagination --}}
        @include('guru.partials.pagination')
    </div>

    {{-- Form Modal (Create/Edit) --}}
    @include('guru.partials.form-modal')

    {{-- Detail Modal --}}
    @include('guru.partials.detail-modal')

    {{-- Delete Confirmation Modal --}}
    @include('guru.partials.delete-modal')

    {{-- Reset Password Modal --}}
    @include('guru.partials.reset-password-modal')

</div>

{{-- Scripts --}}
@include('guru.partials.scripts')

@endsection
