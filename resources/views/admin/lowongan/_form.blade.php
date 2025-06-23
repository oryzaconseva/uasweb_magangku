<div class="row g-3">
    <div class="col-md-6 form-group">
        <label for="judul" class="form-label">Judul Lowongan <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="judul" value="{{ old('judul', $lowongan->judul ?? '') }}" required>
    </div>
    <div class="col-md-6 form-group">
        <label for="nama_perusahaan" class="form-label">Nama Perusahaan <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="nama_perusahaan" value="{{ old('nama_perusahaan', $lowongan->nama_perusahaan ?? '') }}" required>
    </div>
    <div class="col-12 form-group">
        <label for="lokasi" class="form-label">Lokasi <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="lokasi" value="{{ old('lokasi', $lowongan->lokasi ?? '') }}" required>
    </div>
    <div class="col-12 form-group">
        <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
        <textarea class="form-control" name="deskripsi" rows="5" required>{{ old('deskripsi', $lowongan->deskripsi ?? '') }}</textarea>
    </div>
    <div class="col-12 form-group">
        <label for="kualifikasi" class="form-label">Kualifikasi <span class="text-danger">*</span></label>
        <textarea class="form-control" name="kualifikasi" rows="5" required>{{ old('kualifikasi', $lowongan->kualifikasi ?? '') }}</textarea>
    </div>
    <div class="col-md-6 form-group">
        <label for="jenis" class="form-label">Jenis <span class="text-danger">*</span></label>
        <select name="jenis" class="form-select" required>
            <option value="Magang" @selected(old('jenis', $lowongan->jenis ?? '') == 'Magang')>Magang</option>
            <option value="Kerja Praktik" @selected(old('jenis', $lowongan->jenis ?? '') == 'Kerja Praktik')>Kerja Praktik</option>
        </select>
    </div>
    <div class="col-md-6 form-group">
        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
        <select name="status" class="form-select" required>
            <option value="Dibuka" @selected(old('status', $lowongan->status ?? '') == 'Dibuka')>Dibuka</option>
            <option value="Ditutup" @selected(old('status', $lowongan->status ?? '') == 'Ditutup')>Ditutup</option>
        </select>
    </div>
     <div class="col-md-6 form-group">
        <label for="batas_akhir_lamaran" class="form-label">Batas Akhir Lamaran</label>
        <input type="date" class="form-control" name="batas_akhir_lamaran" value="{{ old('batas_akhir_lamaran', isset($lowongan) && $lowongan->batas_akhir_lamaran ? $lowongan->batas_akhir_lamaran->format('Y-m-d') : '') }}">
    </div>
     <div class="col-md-6 form-group">
        <label for="logo_perusahaan" class="form-label">Logo Perusahaan</label>
        <input type="file" class="form-control" name="logo_perusahaan" accept="image/*">
        @if(isset($lowongan) && $lowongan->logo_perusahaan)
            <small class="text-muted d-block mt-2">Logo saat ini: <img src="{{ asset('storage/' . $lowongan->logo_perusahaan) }}" alt="Logo" width="30" class="ms-2">. Kosongkan jika tidak ingin ganti.</small>
        @endif
    </div>
</div>
