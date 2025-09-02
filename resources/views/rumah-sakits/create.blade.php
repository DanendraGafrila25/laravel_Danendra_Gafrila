@extends('layouts.app')

@section('title', 'Tambah Rumah Sakit')
@section('page-title', 'Tambah Rumah Sakit')

@section('page-actions')
<a href="{{ route('rumah-sakits.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left me-2"></i>Kembali
</a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-plus me-2"></i>Form Tambah Rumah Sakit</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('rumah-sakits.store') }}" method="POST" id="rumahSakitForm">
                    @csrf

                    <div class="mb-3">
                        <label for="nama_rumah_sakit" class="form-label">
                            Nama Rumah Sakit <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                            class="form-control @error('nama_rumah_sakit') is-invalid @enderror"
                            id="nama_rumah_sakit"
                            name="nama_rumah_sakit"
                            value="{{ old('nama_rumah_sakit') }}"
                            placeholder="Masukkan nama rumah sakit">
                        @error('nama_rumah_sakit')
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
                            placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                        @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <input type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="contoh@email.com">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telepon" class="form-label">
                                    Telepon <span class="text-danger">*</span>
                                </label>
                                <input type="tel"
                                    class="form-control @error('telepon') is-invalid @enderror"
                                    id="telepon"
                                    name="telepon"
                                    value="{{ old('telepon') }}"
                                    placeholder="081234567890">
                                @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('rumah-sakits.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan
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
        $('#rumahSakitForm').on('submit', function(e) {
            let isValid = true;

            // Reset previous validation
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            // Validate required fields
            const requiredFields = ['nama_rumah_sakit', 'alamat', 'email', 'telepon'];

            requiredFields.forEach(function(field) {
                const value = $(`#${field}`).val().trim();
                if (!value) {
                    $(`#${field}`).addClass('is-invalid');
                    $(`#${field}`).after(`<div class="invalid-feedback">Field ini wajib diisi.</div>`);
                    isValid = false;
                }
            });

            // Validate email format
            const email = $('#email').val().trim();
            if (email && !isValidEmail(email)) {
                $('#email').addClass('is-invalid');
                $('#email').after(`<div class="invalid-feedback">Format email tidak valid.</div>`);
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                Swal.fire('Peringatan!', 'Mohon lengkapi semua field yang wajib diisi.', 'warning');
            }
        });

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
    });
</script>
@endpush