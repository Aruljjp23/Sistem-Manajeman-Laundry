<?php

namespace App\Http\Controllers\Api;

use App\Models\Pesanan;
use App\Models\Transaksi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LaporanController extends Controller
{
    /**
     * GET /api/dashboard
     * Ringkasan statistik untuk dashboard (total pesanan per status, pendapatan, dsb).
     */
    public function dashboard()
    {
        $totalPesanan = Pesanan::count();

        $perStatus = [
            'Baru' => Pesanan::where('status', 'Baru')->count(),
            'Proses' => Pesanan::where('status', 'Proses')->count(),
            'Selesai' => Pesanan::where('status', 'Selesai')->count(),
            'Diambil' => Pesanan::where('status', 'Diambil')->count(),
        ];

        $perKategori = [
            'reguler' => Pesanan::where('kategori', 'reguler')->count(),
            'ekspres' => Pesanan::where('kategori', 'ekspres')->count(),
        ];

        $pendapatanHariIni = Transaksi::whereDate('tanggal_bayar', now()->toDateString())->sum('bayar');
        $pendapatanBulanIni = Transaksi::whereYear('tanggal_bayar', now()->year)
            ->whereMonth('tanggal_bayar', now()->month)
            ->sum('bayar');
        $pendapatanTotal = Transaksi::sum('bayar');

        return response()->json([
            'message' => 'Dashboard statistics retrieved successfully',
            'data' => [
                'total_pesanan' => $totalPesanan,
                'pesanan_per_status' => $perStatus,
                'pesanan_per_kategori' => $perKategori,
                'pendapatan_hari_ini' => (int) $pendapatanHariIni,
                'pendapatan_bulan_ini' => (int) $pendapatanBulanIni,
                'pendapatan_total' => (int) $pendapatanTotal,
            ],
        ], 200);
    }

    /**
     * GET /api/laporan?type=daily|monthly|yearly&date=&month=&year=
     * Laporan transaksi berdasarkan periode (harian/bulanan/tahunan).
     */
    public function index(Request $request)
    {
        try {
            $validated = $request->validate([
                'type' => 'sometimes|in:daily,monthly,yearly',
                'date' => 'sometimes|date',
                'month' => 'sometimes|date_format:Y-m',
                'year' => 'sometimes|integer|min:2000|max:2100',
            ]);

            $type = $validated['type'] ?? 'daily';
            $date = $validated['date'] ?? now()->toDateString();
            $month = $validated['month'] ?? now()->format('Y-m');
            $year = (int) ($validated['year'] ?? now()->year);

            $query = Transaksi::with('pesanan')->whereNotNull('tanggal_bayar');

            switch ($type) {
                case 'monthly':
                    [$yearValue, $monthValue] = explode('-', $month);
                    $query->whereYear('tanggal_bayar', (int) $yearValue)
                        ->whereMonth('tanggal_bayar', (int) $monthValue);
                    break;

                case 'yearly':
                    $query->whereYear('tanggal_bayar', $year);
                    break;

                case 'daily':
                default:
                    $query->whereDate('tanggal_bayar', $date);
                    break;
            }

            $transaksi = $query->latest('tanggal_bayar')->get();

            return response()->json([
                'message' => 'Laporan retrieved successfully',
                'data' => [
                    'type' => $type,
                    'period' => match ($type) {
                        'monthly' => $month,
                        'yearly' => (string) $year,
                        default => $date,
                    },
                    'total_transaksi' => $transaksi->count(),
                    'total_pendapatan' => $transaksi->sum(fn ($item) => $item->pesanan->total_harga ?? 0),
                    'total_bayar' => (int) $transaksi->sum('bayar'),
                    'total_kembalian' => (int) $transaksi->sum('kembalian'),
                    'transaksi' => $transaksi,
                ],
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }
    }
}
