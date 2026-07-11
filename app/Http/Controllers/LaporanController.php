<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type', 'daily');
        $date = $request->query('date', now()->toDateString());
        $month = $request->query('month', now()->format('Y-m'));
        $year = (int) $request->query('year', now()->year);

        $report = $this->buildReport($type, $date, $month, $year);

        return view('laporan.index', array_merge($report, [
            'type' => $type,
            'date' => $date,
            'month' => $month,
            'year' => $year,
        ]));
    }

    public function pdf(Request $request)
    {
        $type = $request->query('type', 'daily');
        $date = $request->query('date', now()->toDateString());
        $month = $request->query('month', now()->format('Y-m'));
        $year = (int) $request->query('year', now()->year);

        $report = $this->buildReport($type, $date, $month, $year);

        $pdf = Pdf::loadView('laporan.pdf', $report);

        return $pdf->stream('laporan-'.$type.'.pdf');
    }

    protected function buildReport(string $type, string $date, string $month, int $year): array
    {
        $query = Transaksi::with('pesanan')
            ->whereNotNull('tanggal_bayar');

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

        return [
            'transaksi' => $transaksi,
            'totalTransaksi' => $transaksi->count(),
            'totalPendapatan' => $transaksi->sum(fn ($item) => $item->pesanan->total_harga ?? 0),
            'totalBayar' => $transaksi->sum('bayar'),
            'totalKembalian' => $transaksi->sum('kembalian'),
            'reportTitle' => match ($type) {
                'monthly' => 'Laporan Bulanan',
                'yearly' => 'Laporan Tahunan',
                default => 'Laporan Harian',
            },
            'reportPeriod' => match ($type) {
                'monthly' => date('F Y', strtotime($month . '-01')),
                'yearly' => (string) $year,
                default => date('d F Y', strtotime($date)),
            },
        ];
    }
}
