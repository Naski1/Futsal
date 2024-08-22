@extends('layout.main')
@section('title', 'Pemesanan')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        @php
            $colour;
            if ($pemesanan->status == 'booked') {
                $colour = 'badge-primary';
            } elseif ($pemesanan->status == 'done') {
                $colour = 'badge-success';
            } else {
                $colour = 'badge-danger';
            }
        @endphp
        <h1 class="h3 mb-0 text-gray-800">Pemesanan | {{ $pemesanan->kode_pemesanan }} | <span
                class="badge {{ $colour }} text-uppercase">{{ $pemesanan->status }}</span></h1>
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
    <!-- Content Row -->

    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Identitas
                    </h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td>Kode Pemesanan</td>
                            <td>:</td>
                            <td>{{ $pemesanan->kode_pemesanan }}</td>
                        </tr>
                        <tr>
                            <td>Tgl. Pemesanan</td>
                            <td>:</td>
                            <td>{{ $pemesanan->tgl_pemesanan }}</td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td>{{ $pemesanan->user->name }}</td>
                        </tr>
                        <tr>
                            <td>No. Tlpn</td>
                            <td>:</td>
                            <td>{{ $pemesanan->user->no_tlpn }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td>{{ $pemesanan->user->email }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td>{{ $pemesanan->user->alamat }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Detail | {{ $detail_pemesanan[0]['nama_lapangan'] }}
                    </h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Jam</th>
                                <th scope="col">Durasi</th>
                                <th scope="col">Biaya</th>
                            </tr>
                            @foreach ($detail_pemesanan as $item)
                                <tr>
                                    <td>{{ $item['nama_jam'] }}</td>
                                    <td>{{ $item['durasi'] }} jam</td>
                                    <td>{{ $item['biaya'] }}</td>
                                </tr>
                            @endforeach
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function() {

        });
    </script>
@endpush
