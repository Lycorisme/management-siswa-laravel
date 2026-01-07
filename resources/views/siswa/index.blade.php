@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')
<div x-data="siswaApp()" x-init="init()">
    
    {{-- Header & Statistics --}}
    @include('siswa.partials.header')

    {{-- Main Content Card --}}
    <div class="glass-card rounded-3xl overflow-hidden">
        
        {{-- Filter & Search Bar --}}
        @include('siswa.partials.filter')

        {{-- Data Table --}}
        @include('siswa.partials.table')

        {{-- Pagination --}}
        @include('siswa.partials.pagination')
    </div>

    {{-- Form Modal (Create/Edit) --}}
    @include('siswa.partials.form-modal')

    {{-- Detail Modal --}}
    @include('siswa.partials.detail-modal')

    {{-- Delete Confirmation Modal --}}
    @include('siswa.partials.delete-modal')

</div>

{{-- Scripts --}}
@include('siswa.partials.scripts')

@endsection
