@extends('layout.main')
@section('title', 'Pemesanan Harian')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pemesanan Hari Ini | {{ \Carbon\Carbon::parse($tgl)->format('j F, Y') }}</h1>
        <form action="{{ route('pemesanan.harian') }}" class="">
            <div class="d-flex justify-content-end">
                <input type="date" name="q" value="{{ old('q', request()->q) }}"
                    class="form-control mr-2 @error('q') is-invalid @enderror" required>
                <button type="submit" class="btn btn-sm px-3 btn-primary rounded-pill">Cari</button>
            </div>
        </form>
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

    <div class="row mb-4">
        @foreach ($hasil as $item)
            <div class="col-lg-4">
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
        $(function() {

        });
    </script>
@endpush
