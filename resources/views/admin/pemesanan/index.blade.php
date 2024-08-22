@extends('layout.main')
@section('title', 'Data Pemesanan')
@section('style-on-this-page-only')
    {{-- <link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />

@endsection
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Pemesanan</h1>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Notifikasi |</strong> {{ session()->get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session()->has('fail'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Notifikasi |</strong> {{ session()->get('fail') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List Pemesanan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode</th>
                            <th>Tgl. Pemesanan</th>
                            <th>Pemesan</th>
                            <th>Total Durasi</th>
                            <th>Total Biaya</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pemesanan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['kode_pemesanan'] }}</td>
                                <td>{{ $item['tgl_pemesanan'] }} </td>
                                <td>{{ $item['nama_pemesan'] }} </td>
                                <td>{{ $item['total_durasi'] }} jam</td>
                                <td>{{ $item['total_biaya'] }} </td>
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
                                <td>
                                    {{-- <select class="form-select"
                                        onchange="this.className=this.options[this.selectedIndex].className"
                                        onfocus="this.className=this.options[this.selectedIndex].className" >
                                        <option value="booked" {{ $item['status'] == 'booked' ? 'selected' : '' }}
                                            class="badge-primary">BOOKED
                                        </option>
                                        <option value="done" {{ $item['status'] == 'done' ? 'selected' : '' }}
                                            class="badge-success">DONE
                                        </option>
                                        <option value="cancel" {{ $item['status'] == 'cancel' ? 'selected' : '' }}
                                            class="badge-danger c">CANCEL
                                        </option>
                                    </select> --}}
                                    <span class="badge {{ $colour }} text-uppercase">{{ $item['status'] }}</span>
                                </td>
                                <td><a href="{{ route('pemesanan.detail', $item['id_pemesanan']) }}"
                                        class="btn btn-sm px-3 btn-secondary rounded-pill mr-2">Detail</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <!-- Page level plugins -->
    {{-- <script src="{{ url('template/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('template/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script> --}}

    {{-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap4.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.bootstrap4.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.colVis.min.js"></script>

    <script type="text/javascript">
        new DataTable('#dataTable', {
            layout: {
                topStart: {
                    //     buttons: ['copy', 'excel', 'pdf', 'colvis']
                    // }
                    // topStart: {
                    buttons: [{
                            extend: 'copy',
                            exportOptions: {
                                columns: [0, 1, 2, 5, 6]
                            }
                        },
                        {
                            extend: 'excel',
                            exportOptions: {
                                columns: [0, 1, 2, 5, 6]
                            }
                        },
                        {
                            extend: 'pdf',
                            exportOptions: {
                                columns: [0, 1, 2, 5, 6]
                            }
                        },
                        'colvis'
                    ]
                }
            }
        });
    </script>
@endpush
