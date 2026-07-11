@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Laporan Laundry</h2>
        <p class="text-muted mb-0" style="font-size:14px;">Admin dapat melihat laporan harian, bulanan, dan tahunan.</p>
    </div>

    @if(auth()->check() && auth()->user()->role === 'admin')
        <div class="d-flex gap-2">
            <a href="{{ route('laporan.pdf', ['type' => $type, 'date' => $date, 'month' => $month, 'year' => $year]) }}" target="_blank" class="btn btn-danger btn-sm">
                <i class="bi bi-file-earmark-pdf me-1"></i> Cetak PDF
            </a>
            <button type="button" class="btn btn-dark btn-sm" onclick="window.print()">
                <i class="bi bi-printer me-1"></i> Cetak Print
            </button>
        </div>
    @endif
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('laporan.index') }}" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="type" class="form-label fw-semibold">Jenis Laporan</label>
                <select name="type" id="type" class="form-select" onchange="this.form.submit()">
                    <option value="daily" {{ $type === 'daily' ? 'selected' : '' }}>Laporan Harian</option>
                    <option value="monthly" {{ $type === 'monthly' ? 'selected' : '' }}>Laporan Bulanan</option>
                    <option value="yearly" {{ $type === 'yearly' ? 'selected' : '' }}>Laporan Tahunan</option>
                </select>
            </div>

            @if($type === 'daily')
                <div class="col-md-3">
                    <label for="date" class="form-label fw-semibold">Tanggal</label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ $date }}">
                </div>
            @elseif($type === 'monthly')
                <div class="col-md-3">
                    <label for="month" class="form-label fw-semibold">Bulan</label>
                    <input type="month" name="month" id="month" class="form-control" value="{{ $month }}">
                </div>
            @else
                <div class="col-md-3">
                    <label for="year" class="form-label fw-semibold">Tahun</label>
                    <input type="number" name="year" id="year" class="form-control" min="2020" value="{{ $year }}">
                </div>
            @endif

            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="text-muted small">Judul Laporan</div>
                <div class="fw-bold fs-5">{{ $reportTitle }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="text-muted small">Periode</div>
                <div class="fw-bold fs-5">{{ $reportPeriod }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="text-muted small">Total Pendapatan</div>
                <div class="fw-bold fs-5 text-success">Rp {{ number_format($totalPendapatan) }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Tanggal Bayar</th>
                    <th>Kode Pesanan</th>
                    <th>Nama Pelanggan</th>
                    <th>Total Tagihan</th>
                    <th>Jumlah Bayar</th>
                    <th>Kembalian</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksi as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->tanggal_bayar->format('d M Y H:i') }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $item->pesanan->kode_pesanan ?? '-' }}</span></td>
                        <td>{{ $item->pesanan->nama_pelanggan ?? '-' }}</td>
                        <td>Rp {{ number_format($item->pesanan->total_harga ?? 0) }}</td>
                        <td>Rp {{ number_format($item->bayar) }}</td>
                        <td>Rp {{ number_format($item->kembalian) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-file-earmark-text fs-1 d-block mb-2 opacity-50"></i>
                            Tidak ada data transaksi untuk periode ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
