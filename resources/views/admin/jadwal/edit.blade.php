@extends('layout.main')
@section('title', 'Tambah Jadwal')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Jadwal</h1>
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
            <form action="{{ route('jadwal.update', $jadwal->id_jadwal) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row mb-4">
                    <label for="inputLapangan" class="col-sm-2 col-form-label">Lapangan</label>
                    <div class="col-sm-10">
                        <select class="form-select form-control @error('id_lapangan') is-invalid @enderror"
                            name="id_lapangan" aria-label="Pilih Lapangan" id="inputLapangan">
                            <option selected disabled>Pilih Lapangan</option>
                            @foreach ($lapangan as $item)
                                <option value="{{ $item->id_lapangan }}"
                                    {{ old('id_lapangan', $jadwal->lapangan_id) == $item->id_lapangan ? 'selected' : '' }}>
                                    {{ $item->nama_lapangan }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_lapangan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="inputJam" class="col-sm-2 col-form-label">Jam</label>
                    <div class="col-sm-10">
                        <select class="form-select form-control @error('id_jam') is-invalid @enderror" name="id_jam"
                            aria-label="Pilih Jam" id="inputJam">
                            <option selected disabled>Pilih Jam</option>
                            @foreach ($jam as $item)
                                <option value="{{ $item->id_jam }}"
                                    {{ old('id_jam', $jadwal->jam_id) == $item->id_jam ? 'selected' : '' }}>
                                    {{ $item->nama_jam }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_jam')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('jadwal.index') }}"
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
