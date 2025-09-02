@extends('layouts.app')

@section('title', 'Edit Pasien')
@section('page-title', 'Edit Pasien')

@section('page-actions')
<a href="{{ route('pasiens.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left me-2"></i>Kembali
</a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Form Edit Pasien</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('pasiens.update', $pasien) }}" method="POST" id="pasienForm">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama_pasien" class="form-label">
                            Nama Pasien <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                            class="form-control @error('nama_pasien') is-invalid @enderror"
                            id="nama_pasien"
                            name="nama_pasien"
                            value="{{ old('nama_pasien', $pasien->nama_pasien) }}"
                            placeholder="Masukkan nama lengkap pasien">
                        @error('nama_pasien')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">
                            Alamat <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror"
                            id="alamat"
                            name="alamat"
                            rows="3"
                            placeholder="Masukkan alamat lengkap">{{ old('alamat', $pasien->alamat) }}</textarea>
                        @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="no_telepon" class="form-label">
                                    No Telepon <span class="text-danger">*</span>
                                </label>
                                <input type="tel"
                                    class="form-control @error('no_telepon') is-invalid @enderror"
                                    id="no_telepon"
                                    name="no_telepon"
                                    value="{{ old('no_telepon', $pasien->no_telepon) }}"
                                    placeholder="081234567890">
                                @error('no_telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="id_rumah_sakit" class="form-label">
                                    Rumah Sakit <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('id_rumah_sakit') is-invalid @enderror"
                                    id="id_rumah_sakit"
                                    name="id_rumah_sakit">
                                    <option value="">Pilih Rumah Sakit</option>
                                    @foreach($rumahSakits as $rs)
                                    <option value="{{ $rs->id }}"
                                        {{ old('id_rumah_sakit', $pasien->id_rumah_sakit) == $rs->id ? 'selected' : '' }}>
                                        {{ $rs->nama_rumah_sakit }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('id_rumah_sakit')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('pasiens.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-2"></i>Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Form validation
        $('#pasienForm').on('submit', function(e) {
            let isValid = true;

            // Reset previous validation
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            // Validate required fields
            const requiredFields = ['nama_pasien', 'alamat', 'no_telepon', 'id_rumah_sakit'];

            requiredFields.forEach(function(field) {
                const value = $(`#${field}`).val();
                if (!value || value.trim() === '') {
                    $(`#${field}`).addClass('is-invalid');
                    $(`#${field}`).after(`<div class="invalid-feedback">Field ini wajib diisi.</div>`);
                    isValid = false;
                }
            });

            if (!isValid) {
                e.preventDefault();
                Swal.fire('Peringatan!', 'Mohon lengkapi semua field yang wajib diisi.', 'warning');
            }
        });
    });
</script>
@endpush