<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class KamarController extends Controller
{
    /**
     * Get bed availability data
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            // Cache selama 5 menit untuk mengurangi load database
            $data = Cache::remember('kamar_data', 300, function () {
                return DB::table('kamar')
                    ->selectRaw("
                        CASE 
                            WHEN kd_bangsal IN ('HCU') THEN 'HCU'
                            WHEN kd_bangsal IN ('ICU') THEN 'ICU'
                            WHEN kd_bangsal IN ('ISO') THEN 'ISO'
                            WHEN kd_bangsal IN ('NICU') THEN 'NICU'
                            WHEN kd_bangsal IN ('PICU') THEN 'PICU'
                            WHEN kd_bangsal IN ('PRINA') THEN 'PRINA'
                            ELSE kelas
                        END AS kelas_kamar,
                        COUNT(*) AS total,
                        SUM(CASE WHEN status = 'ISI' THEN 1 ELSE 0 END) AS isi,
                        SUM(CASE WHEN status = 'KOSONG' THEN 1 ELSE 0 END) AS kosong
                    ")
                    ->where('statusdata', '1')
                    ->groupBy('kelas_kamar')
                    ->orderByRaw("
                        FIELD(
                            kelas_kamar, 
                            'Kelas VVIP','Kelas VIP',
                            'HCU','ICU','ISO','NICU','PICU','PRINA',
                            'Kelas 1','Kelas 2','Kelas 3'
                        )
                    ")
                    ->get();
            });

            return response()->json([
                'success' => true,
                'message' => 'Data kamar berhasil diambil',
                'data' => $data,
                'timestamp' => now()->toIso8601String(),
            ], 200);

        } catch (\Exception $e) {
            Log::error('Failed to fetch kamar data', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data kamar',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error',
            ], 500);
        }
    }

    /**
     * Clear cache (untuk admin/cron job)
     */
    public function clearCache()
    {
        Cache::forget('kamar_data');
        
        return response()->json([
            'success' => true,
            'message' => 'Cache berhasil dihapus',
        ]);
    }
}