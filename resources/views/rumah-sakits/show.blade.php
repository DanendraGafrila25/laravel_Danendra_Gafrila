@extends('layouts.app')

@section('title', 'Detail Rumah Sakit')
@section('page-title', 'Detail Rumah Sakit')

@section('page-actions')
<div class="btn-group">
    <a href="{{ route('rumah-sakits.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
    <a href="{{ route('rumah-sakits.edit', $rumahSakit) }}" class="btn btn-warning">
        <i class="fas fa-edit me-2"></i>Edit
    </a>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-hospital me-2"></i>Informasi Rumah Sakit</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td width="200"><strong>ID</strong></td>
                            <td>{{ $rumahSakit->id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nama Rumah Sakit</strong></td>
                            <td>{{ $rumahSakit->nama_rumah_sakit }}</td>
                        </tr>
                        <tr>
                            <td><strong>Alamat</strong></td>
                            <td>{{ $rumahSakit->alamat }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                            <td>
                                <a href="mailto:{{ $rumahSakit->email }}" class="text-decoration-none">
                                    <i class="fas fa-envelope me-1"></i>{{ $rumahSakit->email }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Telepon</strong></td>
                            <td>
                                <a href="tel:{{ $rumahSakit->telepon }}" class="text-decoration-none">
                                    <i class="fas fa-phone me-1"></i>{{ $rumahSakit->telepon }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Dibuat</strong></td>
                            <td>{{ $rumahSakit->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Diupdate</strong></td>
                            <td>{{ $rumahSakit->updated_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-users me-2"></i>Statistik Pasien</h5>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <h3 class="text-success mb-3">{{ $rumahSakit->pasiens->count() }}</h3>
                    <p class="text-muted mb-3">Total Pasien Terdaftar</p>

                    @if($rumahSakit->pasiens->count() > 0)
                    <a href="{{ route('pasiens.index', ['rumah_sakit' => $rumahSakit->id]) }}"
                        class="btn btn-success btn-sm">
                        <i class="fas fa-eye me-2"></i>Lihat Daftar Pasien
                    </a>
                    @else
                    <div class="alert alert-info">
                        <small><i class="fas fa-info-circle me-1"></i>Belum ada pasien terdaftar</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card shadow-sm mt-3">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('rumah-sakits.edit', $rumahSakit) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit Data
                    </a>
                    <button type="button"
                        class="btn btn-danger delete-btn"
                        data-id="{{ $rumahSakit->id }}"
                        data-name="{{ $rumahSakit->nama_rumah_sakit }}">
                        <i class="fas fa-trash me-2"></i>Hapus Data
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
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
                                    window.location.href = '{{ route("rumah-sakits.index") }}';
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