@extends('layouts.app')

@section('title', 'Detail Pasien')
@section('page-title', 'Detail Pasien')

@section('page-actions')
<div class="btn-group">
    <a href="{{ route('pasiens.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
    <a href="{{ route('pasiens.edit', $pasien) }}" class="btn btn-warning">
        <i class="fas fa-edit me-2"></i>Edit
    </a>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-user-injured me-2"></i>Informasi Pasien</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td width="200"><strong>ID</strong></td>
                            <td>{{ $pasien->id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nama Pasien</strong></td>
                            <td>{{ $pasien->nama_pasien }}</td>
                        </tr>
                        <tr>
                            <td><strong>Alamat</strong></td>
                            <td>{{ $pasien->alamat }}</td>
                        </tr>
                        <tr>
                            <td><strong>No Telepon</strong></td>
                            <td>
                                <a href="tel:{{ $pasien->no_telepon }}" class="text-decoration-none">
                                    <i class="fas fa-phone me-1"></i>{{ $pasien->no_telepon }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Rumah Sakit</strong></td>
                            <td>
                                <span class="badge bg-success fs-6">{{ $pasien->rumahSakit->nama_rumah_sakit }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Dibuat</strong></td>
                            <td>{{ $pasien->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Diupdate</strong></td>
                            <td>{{ $pasien->updated_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-hospital me-2"></i>Info Rumah Sakit</h5>
            </div>
            <div class="card-body">
                <h6 class="card-title">{{ $pasien->rumahSakit->nama_rumah_sakit }}</h6>
                <p class="card-text">
                    <small class="text-muted">
                        <i class="fas fa-map-marker-alt me-1"></i>{{ $pasien->rumahSakit->alamat }}
                    </small>
                </p>
                <p class="card-text">
                    <small class="text-muted">
                        <i class="fas fa-envelope me-1"></i>{{ $pasien->rumahSakit->email }}
                    </small>
                </p>
                <p class="card-text">
                    <small class="text-muted">
                        <i class="fas fa-phone me-1"></i>{{ $pasien->rumahSakit->telepon }}
                    </small>
                </p>
                <a href="{{ route('rumah-sakits.show', $pasien->rumahSakit) }}" class="btn btn-success btn-sm">
                    <i class="fas fa-eye me-2"></i>Lihat Detail RS
                </a>
            </div>
        </div>

        <div class="card shadow-sm mt-3">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('pasiens.edit', $pasien) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit Data
                    </a>
                    <button type="button"
                        class="btn btn-danger delete-btn"
                        data-id="{{ $pasien->id }}"
                        data-name="{{ $pasien->nama_pasien }}">
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
                                    window.location.href = '{{ route("pasiens.index") }}';
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