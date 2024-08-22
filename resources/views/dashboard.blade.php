@extends('layout.main')
@section('title', 'Dashboard')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div><!-- Content Row -->
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Lapangan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $lapangan->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Costumer
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $costumer->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Pemesanan Booked
                            </div>
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                {{ $pemesananBooked->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pemesanan Done
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $pemesananDone->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Jadwal Hari Ini | {{ \Carbon\Carbon::now()->parse()->format('j F, Y') }}
        </h1>
        <form action="/" class="">
            <div class="d-flex justify-content-end">
                <input type="date" name="q" value="{{ old('q', request()->q) }}"
                    class="form-control mr-2 @error('q') is-invalid @enderror" required>
                <button type="submit" class="btn btn-sm px-3 btn-primary rounded-pill">Cari</button>
            </div>
        </form>
    </div>
    <!-- Content Row -->
    <div class="row">
        <!-- Third Column -->

        @foreach ($hasil as $item)
            <div class="col-lg-4">
                <!-- Grayscale Utilities -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 text-center">
                        <h6 class="m-0 font-weight-bold text-primary">{{ $item['nama_lapangan'] }}</h6>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Jam</th>
                                    <th scope="col">Durasi</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($item['jadwal'] as $item)
                                    <tr>
                                        <td>{{ $item['nama_jam'] }}</td>
                                        <td>{{ $item['durasi'] }} jam</td>
                                        @php
                                            $colour;
                                            if ($item['status'] == 'booked') {
                                                $colour = 'badge-primary';
                                            } elseif ($item['status'] == 'done') {
                                                $colour = 'badge-success';
                                            } else {
                                                $colour = 'badge-danger';
                                            }
                                        @endphp
                                        <td><span
                                                class="badge {{ $colour }} text-uppercase">{{ $item['status'] }}</span>
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
            </div>
        @endforeach
    </div>

@endsection

@push('scripts')
    <script type="text/javascript">
        $(function() {});
    </script>
@endpush
