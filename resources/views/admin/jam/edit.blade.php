@extends('layout.main')
@section('title', 'Edit Jam')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Jam</h1>
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
            <form action="{{ route('jam.update', $jam) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row mb-4">
                    <label for="inputJamAwal" class="col-sm-2 col-form-label">Jam Awal</label>
                    <div class="col-sm-10">
                        <input type="time" name="jam_awal" value="{{ old('jam_awal', $jam->jam_awal) }}"
                            class="form-control @error('jam_awal') is-invalid @enderror" id="inputJamAwal"
                            placeholder="jam awal" min="08:00" max="23:00">
                        @error('jam_awal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="inputJamAkhir" class="col-sm-2 col-form-label">Jam Akhir</label>
                    <div class="col-sm-10">
                        <input type="time" name="jam_akhir" value="{{ old('jam_akhir', $jam->jam_akhir) }}"
                            class="form-control @error('jam_akhir') is-invalid @enderror" id="inputJamAkhir"
                            placeholder="jam akhir" min="08:00" max="23:00">
                        @error('jam_akhir')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="inputNama" class="col-sm-2 col-form-label">Nama Jam</label>
                    <div class="col-sm-10">
                        <input type="text" name="nama_jam" value="{{ old('nama_jam', $jam->nama_jam) }}"
                            class="form-control @error('nama_jam') is-invalid @enderror" id="inputNama"
                            placeholder="nama jam" readonly>
                        @error('nama_jam')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                {{-- <div class="row mb-4">
                    <label for="inputDurasi" class="col-sm-2 col-form-label">Durasi</label>
                    <div class="col-sm-10">
                        <input type="number" name="durasi" value="{{ old('durasi') }}"
                            class="form-control @error('durasi') is-invalid @enderror" id="inputDurasi" placeholder="durasi"
                            min="1" readonly>
                        @error('durasi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div> --}}
                <div class="row mb-4">
                    <label for="inputDiaya" class="col-sm-2 col-form-label">Biaya</label>
                    <div class="col-sm-10">
                        <input type="number" name="biaya" value="{{ old('biaya', $jam->biaya) }}"
                            class="form-control @error('biaya') is-invalid @enderror" id="inputDiaya" placeholder="biaya"
                            min="1">
                        @error('biaya')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="inputKategori" class="col-sm-2 col-form-label">Status Jam</label>
                    <div class="col-sm-10">
                        <select class="form-select form-control @error('status') is-invalid @enderror" name="status"
                            aria-label="Pilih Status">
                            <option selected disabled>Pilih Status</option>
                            <option value="y" {{ old('status', $jam->status) == 'y' ? 'selected' : '' }}>Aktif
                            </option>
                            <option value="t" {{ old('status', $jam->status) == 't' ? 'selected' : '' }}>Tidak Aktif
                            </option>
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
    <script type="text/javascript">
        $(function() {
            // let jamAwal = $("#inputJamAwal").val();
            // let jamAkhir = $("#inputJamAkhir").val();
            // var time1 = jamAwal.split(':');
            // var time2 = jamAkhir.split(':');
            // var hours1 = parseInt(time1[0], 10),
            //     hours2 = parseInt(time2[0], 10),
            //     mins1 = parseInt(time1[1], 10),
            //     mins2 = parseInt(time2[1], 10);
            // var hours = hours2 - hours1,
            //     mins = 0;
            // if (hours < 0) hours = 24 + hours;
            // if (mins2 >= mins1) {
            //     mins = mins2 - mins1;
            // } else {
            //     mins = (mins2 + 60) - mins1;
            //     hours--;
            // }
            // if (mins < 9) {
            //     mins = '0' + mins;
            // }
            // if (hours < 9) {
            //     hours = '0' + hours;
            // }
            $("#inputJamAkhir, #inputJamAwal").on("change", function() {
                $("#inputNama").val($("#inputJamAwal").val() + '-' + $("#inputJamAkhir").val());
                // console.log(parseInt(jamAkhir) - parseInt(jamAwal));
                // console.log(jQuery.type(jamAkhir));
                // console.log(hours + ':' + mins);
            });

        });
    </script>
@endpush
