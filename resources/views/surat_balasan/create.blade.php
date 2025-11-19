@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-3">Tambah Surat Balasan</h3>

    <form method="POST" action="{{ route('surat-balasan.store') }}">
        @csrf

        @include('surat_balasan.form')

        <button type="submit" class="btn btn-success mt-3">Simpan</button>
        <a href="{{ route('surat-balasan.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </form>

</div>
@endsection
