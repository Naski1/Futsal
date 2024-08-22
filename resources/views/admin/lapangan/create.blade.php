@extends('layout.main')
@section('title', 'Tambah Lapangan')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Lapangan</h1>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Notifikasi |</strong> {{ session()->get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Notifikasi |</strong> Pastikan data yang anda benar!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- <div class="row">
        <div class="col-xl-12 col-md-6 mb-4"> --}}

    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <form action="{{ route('lapangan.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row mb-4">
                    <label for="inputNama" class="col-sm-2 col-form-label">Nama Lapangan</label>
                    <div class="col-sm-10">
                        <input type="text" name="nama_lapangan" value="{{ old('nama_lapangan') }}"
                            class="form-control @error('nama_lapangan') is-invalid @enderror" id="inputNama"
                            placeholder="nama lapangan">
                        @error('nama_lapangan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="deskripsi" class="col-sm-2 py-0 col-form-label">Deksripsi Lapangan</label>
                    <div class="col-sm-10">
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi"
                            id="exampleFormControlTextarea1" rows="4" placeholder="deskripsi...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="inputKategori" class="col-sm-2 col-form-label">Status Lapangan</label>
                    <div class="col-sm-10">
                        <select class="form-select form-control @error('status') is-invalid @enderror" name="status"
                            aria-label="Pilih Status">
                            <option selected disabled>Pilih Status</option>
                            <option value="y" {{ old('status') == 'y' ? 'selected' : '' }}>Aktif</option>
                            <option value="t" {{ old('status') == 't' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('lapangan.index') }}"
                        class="btn btn-sm px-3 btn-secondary rounded-pill mr-2">Cancel</a>
                    <button type="submit" class="btn btn-sm px-3 btn-primary rounded-pill">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript"></script>
@endpush
