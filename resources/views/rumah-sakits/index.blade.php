@extends('layouts.app')

@section('title', 'Data Rumah Sakit')
@section('page-title', 'Data Rumah Sakit')

@section('page-actions')
<a href="{{ route('rumah-sakits.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-2"></i>Tambah Rumah Sakit
</a>
@endsection

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-hospital me-2"></i>Daftar Rumah Sakit</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="rumahSakitTable" class="table table-striped table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 25%;">Nama Rumah Sakit</th>
                        <th style="width: 30%;">Alamat</th>
                        <th style="width: 20%;">Email</th>
                        <th style="width: 15%;">Telepon</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rumahSakits as $index => $rumahSakit)
                    <tr>
                        <td>{{ $rumahSakits->firstItem() + $index }}</td>
                        <td>{{ $rumahSakit->nama_rumah_sakit }}</td>
                        <td>{{ $rumahSakit->alamat }}</td>
                        <td>{{ $rumahSakit->email }}</td>
                        <td>{{ $rumahSakit->telepon }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('rumah-sakits.show', $rumahSakit) }}"
                                    class="btn btn-info btn-sm" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('rumah-sakits.edit', $rumahSakit) }}"
                                    class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button"
                                    class="btn btn-danger btn-sm delete-btn"
                                    data-id="{{ $rumahSakit->id }}"
                                    data-name="{{ $rumahSakit->nama_rumah_sakit }}"
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
                                <i class="fas fa-hospital fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data rumah sakit</p>
                                <a href="{{ route('rumah-sakits.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Tambah Rumah Sakit Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($rumahSakits->hasPages())
        <div class="d-flex justify-content-center mt-3">
            {{ $rumahSakits->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#rumahSakitTable').DataTable({
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

        // Delete functionality with AJAX
        $(document).on('click', '.delete-btn', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');

            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Apakah Anda yakin ingin menghapus rumah sakit "${name}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/rumah-sakits/${id}`,
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