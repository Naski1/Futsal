@extends('layout.main')
@section('title', 'Tambah Pemesanan')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Pemesanan</h1>
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
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- <div class="row">
        <div class="col-xl-12 col-md-6 mb-4"> --}}
    <div class="card border-left-primary shadow h-100 py-2 mb-2">
        <div class="card-body">
            <form action="{{ route('pemesanan.search') }}" method="post" enctype="multipart/form-data">
                @csrf
                @if (Auth::user()->role == 'admin')
                    <div class="row mb-4">
                        <label for="inputCs" class="col-sm-2 col-form-label">Costumer</label>
                        <div class="col-sm-10">
                            <select class="form-select form-control @error('cs') is-invalid @enderror" name="cs"
                                aria-label="Pilih Costumer" id="inputCs" required>
                                <option selected disabled>Pilih Costumer</option>
                                @foreach ($costumer as $item)
                                    <option value="{{ $item->id_user }}"
                                        {{ request()->cs == $item->id_user ? 'selected' : 'disabled' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cs')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                @endif
                <div class="row mb-4">
                    <label for="inputLapangan" class="col-sm-2 col-form-label">Lapangan</label>
                    <div class="col-sm-10">
                        <select class="form-select form-control @error('lpng') is-invalid @enderror" name="lpng"
                            aria-label="Pilih Lapangan" id="inputLapangan">
                            <option selected disabled>Pilih Lapangan</option>
                            @foreach ($lapangan as $item)
                                <option value="{{ $item->id_lapangan }}"
                                    {{ request()->lpng == $item->id_lapangan ? 'selected' : 'disabled' }}>
                                    {{ $item->nama_lapangan }}
                                </option>
                            @endforeach
                        </select>
                        @error('lpng')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="inputTgl" class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="col-sm-10">
                        <input type="date" name="tgl" value="{{ old('tgl', request()->tgl) }}"
                            class="form-control @error('tgl') is-invalid @enderror" id="inputTgl"
                            placeholder="tgl pemesanan" readonly>
                        @error('tgl')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                {{-- <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('pemesanan.index') }}"
                        class="btn btn-sm px-3 btn-secondary rounded-pill mr-2">Cancel</a>
                    <button type="submit" class="btn btn-sm px-3 btn-primary rounded-pill">Cari Jadwal</button>
                </div> --}}
            </form>
        </div>
    </div>

    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <form action="{{ route('pemesanan.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="cs"
                    value="{{ request()->cs != '' ? request()->cs : Auth::user()->id_user }}">
                <input type="hidden" name="tgl_pemesanan" value="{{ request()->tgl }}">
                <input type="hidden" name="lap" value="{{ request()->lpng }}">
                <div class="row mb-4">
                    <label for="" class="col-sm-2 col-form-label">Jadwal</label>
                    <div class="col-sm-10">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Jam</th>
                                    <th scope="col">Durasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jadwal as $item)
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check form-check-lg">
                                                <input class="form-check-input form-check-input-lg" type="checkbox"
                                                    value="{{ $item->id_jadwal }}" name="jam[{{ $item->jam_id }}]"
                                                    {{ $item->status === 'booked' ? 'disabled checked' : '' }}>
                                            </div>
                                        </th>
                                        <td>{{ $item->jam->nama_jam }}</td>
                                        <td>{{ $item->jam->durasi }} jam
                                            <input type="hidden" value="{{ $item->jam->durasi }}"
                                                name="durasi[{{ $item->jam_id }}]"
                                                {{ $item->status === 'booked' ? 'disabled' : '' }}>
                                            <input type="hidden" value="{{ $item->jam->biaya }}"
                                                name="biaya[{{ $item->jam_id }}]"
                                                {{ $item->status === 'booked' ? 'disabled' : '' }}>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Belum ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('pemesanan.index') }}"
                        class="btn btn-sm px-3 btn-secondary rounded-pill mr-2">Cancel</a>
                    <button type="submit" class="btn btn-sm px-3 btn-primary rounded-pill">Buat Pesanan</button>
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
