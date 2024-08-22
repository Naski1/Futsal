@extends('layout.main')
@section('title', 'Tambah Costumer')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit {{ Auth::user()->role === 'costumer' ? 'Profile' : 'Costumer' }}</h1>
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
            <form action="{{ route('user.update', $user->id_user) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row mb-4">
                    <label for="inputNama" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" name="nama" value="{{ old('nama', $user->name) }}"
                            class="form-control @error('nama') is-invalid @enderror" id="inputNama" placeholder="nama"
                            minlength="3" maxlength="50" required>
                        @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="form-control @error('email') is-invalid @enderror" id="inputEmail" placeholder="email"
                            required>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="inputTlpn" class="col-sm-2 col-form-label">No. Telepon</label>
                    <div class="col-sm-10">
                        <input type="number" name="no_tlpn" value="{{ old('no_tlpn', $user->no_tlpn) }}"
                            class="form-control @error('no_tlpn') is-invalid @enderror" id="inputTlpn"
                            placeholder="no. telepon" minlength="11" maxlength="12" required>
                        <small><b>PS*</b> : Nomer akan dijadikan password default </small>
                        @error('no_tlpn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="inputAlamat" class="col-sm-2 py-0 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="alamat" id="exampleFormControlTextarea1" rows="4" placeholder="alamat...">{{ old('alamat', $user->alamat) }}</textarea>
                        <small><b>PS*</b> : Alamat boleh tidak di isi </small>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('user.index') }}" class="btn btn-sm px-3 btn-secondary rounded-pill mr-2">Cancel</a>
                    <button type="submit" class="btn btn-sm px-3 btn-primary rounded-pill">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function() {});
    </script>
@endpush
