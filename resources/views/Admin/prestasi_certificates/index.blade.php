@extends('Admin.layouts.app')

@section('title','Sertifikat Prestasi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Sertifikat Prestasi</h4>
        <div class="d-flex gap-2">
            <span class="badge bg-success">Total: {{ $counts['total'] ?? 0 }}</span>
            <span class="badge bg-success-subtle text-success">Approved: {{ $counts['approved'] ?? 0 }}</span>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Prestasi</th>
                        <th>User</th>
                        <th>File</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ optional($item->prestasi)->kompetisi }}</div>
                            <div class="text-muted small">{{ optional($item->prestasi)->nama }}</div>
                        </td>
                        <td>
                            <div>{{ optional($item->user)->name }}</div>
                            <div class="text-muted small">{{ optional($item->user)->email }}</div>
                        </td>
                        <td>
                            <div class="text-muted small">{{ $item->original_name }}</div>
                            @php($size = $item->size ? round($item->size/1024,1).' KB' : '')
                            @if($size)<div class="text-muted small">{{ $size }}</div>@endif
                        </td>
                        <td class="d-flex gap-1 flex-wrap">
                            <a href="{{ route('admin.prestasi_certificates.download', $item->id) }}" class="btn btn-sm btn-outline-secondary">Download</a>
                            @if($item->url)
                                <a href="{{ $item->url }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat</a>
                            @endif
                            <form action="{{ route('admin.prestasi_certificates.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus sertifikat ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted">Belum ada sertifikat.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $items->links() }}
    </div>
</div>
@endsection
