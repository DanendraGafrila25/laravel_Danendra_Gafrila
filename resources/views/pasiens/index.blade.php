@extends('layouts.app')

@section('title', 'Data Pasien')
@section('page-title', 'Data Pasien')

@section('page-actions')
<a href="{{ route('pasiens.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-2"></i>Tambah Pasien
</a>
@endsection

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-users me-2"></i>Daftar Pasien</h5>
    </div>
    <div class="card-body">
        <!-- Filter Section -->
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="filter_rumah_sakit" class="form-label fw-medium">Filter berdasarkan Rumah Sakit:</label>
                <select id="filter_rumah_sakit" class="form-select">
                    <option value="">Semua Rumah Sakit</option>
                    @foreach($rumahSakits as $rs)
                    <option value="{{ $rs->id }}" {{ request('rumah_sakit') == $rs->id ? 'selected' : '' }}>
                        {{ $rs->nama_rumah_sakit }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" id="btn_filter" class="btn btn-info">
                    <i class="fas fa-filter me-2"></i>Filter
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table id="pasienTable" class="table table-striped table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 20%;">Nama Pasien</th>
                        <th style="width: 25%;">Alamat</th>
                        <th style="width: 15%;">No Telepon</th>
                        <th style="width: 20%;">Rumah Sakit</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="pasien_tbody">
                    @forelse($pasiens as $index => $pasien)
                    <tr>
                        <td>{{ $pasiens->firstItem() + $index }}</td>
                        <td>{{ $pasien->nama_pasien }}</td>
                        <td>{{ $pasien->alamat }}</td>
                        <td>{{ $pasien->no_telepon }}</td>
                        <td>
                            <span class="badge bg-success">{{ $pasien->rumahSakit->nama_rumah_sakit }}</span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('pasiens.show', $pasien) }}"
                                    class="btn btn-info btn-sm" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('pasiens.edit', $pasien) }}"
                                    class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button"
                                    class="btn btn-danger btn-sm delete-btn"
                                    data-id="{{ $pasien->id }}"
                                    data-name="{{ $pasien->nama_pasien }}"
                                    title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            <div class="py-4">
                                <i class="fas fa-user-injured fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data pasien</p>
                                <a href="{{ route('pasiens.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Tambah Pasien Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pasiens->hasPages())
        <div class="d-flex justify-content-center mt-3">
            {{ $pasiens->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#pasienTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            },
            "pageLength": 10,
            "responsive": true,
            "columnDefs": [{
                "orderable": false,
                "targets": -1
            }]
        });

        // Filter by Rumah Sakit using AJAX
        $('#btn_filter').on('click', function() {
            const rumahSakitId = $('#filter_rumah_sakit').val();

            $.ajax({
                url: '{{ route("api.pasiens.filter") }}',
                type: 'GET',
                data: {
                    rumah_sakit_id: rumahSakitId
                },
                success: function(response) {
                    if (response.success) {
                        updateTable(response.data);
                    } else {
                        Swal.fire('Error!', 'Gagal memfilter data.', 'error');
                    }
                },
                error: function(xhr) {
                    Swal.fire('Error!', 'Terjadi kesalahan saat memfilter data.', 'error');
                }
            });
        });

        // Update table with filtered data
        function updateTable(data) {
            let tbody = $('#pasien_tbody');
            tbody.empty();

            if (data.length === 0) {
                tbody.append(`
                <tr>
                    <td colspan="6" class="text-center">
                        <div class="py-4">
                            <i class="fas fa-user-injured fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada data pasien yang sesuai dengan filter</p>
                        </div>
                    </td>
                </tr>
            `);
            } else {
                data.forEach(function(pasien, index) {
                    tbody.append(`
                    <tr>
                        <td>${index + 1}</td>
                        <td>${pasien.nama_pasien}</td>
                        <td>${pasien.alamat}</td>
                        <td>${pasien.no_telepon}</td>
                        <td><span class="badge bg-success">${pasien.rumah_sakit.nama_rumah_sakit}</span></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="/pasiens/${pasien.id}" class="btn btn-info btn-sm" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="/pasiens/${pasien.id}/edit" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm delete-btn" 
                                        data-id="${pasien.id}" data-name="${pasien.nama_pasien}" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `);
                });
            }
        }

        // Delete functionality with AJAX
        $(document).on('click', '.delete-btn', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');

            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Apakah Anda yakin ingin menghapus data pasien "${name}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/pasiens/${id}`,
                        type: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: response.message,
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error!', response.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', 'Terjadi kesalahan saat menghapus data.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endpush