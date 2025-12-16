@extends('admin.layouts.app')

@section('title', 'Daftar Pendaftar - HIMA TI Politala')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold mb-1">Daftar Pendaftar HIMA TI</h2>
            <p class="text-muted mb-0">Proses status pendaftar secara massal atau ekspor rekap CSV.</p>
        </div>
        <a href="{{ route('admin.pendaftaran.export') }}" class="btn btn-outline-primary d-flex align-items-center gap-2">
            <i class="fas fa-file-csv"></i><span>Ekspor CSV</span>
        </a>
    </div>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tabel daftar pendaftar --}}
    <div class="card shadow-sm">
        <form method="POST" action="{{ route('admin.pendaftaran.process_bulk') }}">
            @csrf
            <div class="card-header bg-white border-0 d-flex align-items-center gap-2 flex-wrap">
                <label class="mb-0 fw-semibold">Ubah status terpilih ke:</label>
                <select name="status" class="form-select form-select-sm" required style="max-width: 180px;">
                    @foreach (['Pending','Diterima','Ditolak'] as $status)
                        <option value="{{ $status }}">{{ $status }}</option>
                    @endforeach
                </select>
                <button class="btn btn-sm btn-primary d-flex align-items-center gap-1" type="submit">
                    <i class="fas fa-check"></i><span>Proses</span>
                </button>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th style="width:32px;"><input type="checkbox" id="select-all"></th>
                                <th style="width:48px;">No</th>
                                <th>Nama Lengkap</th>
                                <th>NIM</th>
                                <th>Jurusan</th>
                                <th style="width:80px;">Angkatan</th>
                                <th>Email</th>
                        <th>No. WhatsApp</th>
                                <th>Divisi Pilihan</th>
                                <th>Motivasi</th>
                                <th style="width:220px;">Status & Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $key => $p)
                                <tr>
                                    <td class="text-center"><input type="checkbox" name="ids[]" value="{{ $p->id }}" class="row-check"></td>
                                    <td>{{ $items->firstItem() + $key }}</td>
                                    <td>{{ $p->nama_lengkap }}</td>
                                    <td>{{ $p->nim }}</td>
                                    <td>{{ $p->jurusan }}</td>
                                    <td>{{ $p->angkatan }}</td>
                                    <td>{{ $p->email }}</td>
                                    <td>{{ $p->no_telp }}</td>
                                    <td>{{ $p->divisi_pilihan }}</td>
                                    <td>{{ $p->motivasi }}</td>
                                    <td class="text-nowrap">
                                        <form method="POST" action="{{ route('admin.pendaftaran.update', $p) }}" class="d-flex align-items-center gap-2 flex-wrap mb-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="form-select form-select-sm" style="width:130px;">
                                                @foreach (['Pending','Diterima','Ditolak'] as $status)
                                                    <option value="{{ $status }}" @selected($p->status === $status)>{{ $status }}</option>
                                                @endforeach
                                            </select>
                                            <button class="btn btn-sm btn-outline-primary" type="submit">Simpan</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.pendaftaran.destroy', $p) }}" onsubmit="return confirm('Hapus pendaftaran ini?')" class="mb-0">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger w-100" type="submit">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center">Belum ada pendaftar</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-0">
                {{ $items->links() }}
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const selectAll = document.getElementById('select-all');
    if (selectAll) {
        selectAll.addEventListener('change', (e) => {
            document.querySelectorAll('.row-check').forEach(cb => cb.checked = e.target.checked);
        });
    }
</script>
@endpush
@endsection
