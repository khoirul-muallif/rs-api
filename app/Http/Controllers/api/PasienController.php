<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasien;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PasienController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = $request->all();

            // 🔹 Catat payload masuk
            Log::info('API /api/pasien menerima data', [
                'payload' => $data,
                'ip'      => $request->ip(),
            ]);

            if (!empty($data['tgl_lahir'])) {
                $data['tgl_lahir'] = Carbon::parse($data['tgl_lahir'])->format('Y-m-d');
            }

            if (!empty($data['tgl_daftar'])) {
                $data['tgl_daftar'] = Carbon::parse($data['tgl_daftar'])->format('Y-m-d');
            }

            // Simpan ke DB
            $pasien = Pasien::create($data);

            Log::info('API /api/pasien sukses simpan', [
                'id'   => $pasien->id ?? null,
                'nama' => $pasien->nm_pasien ?? null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pasien berhasil disimpan',
                'data' => $pasien
            ], 201);

        } catch (\Exception $e) {
            // 🔹 Log error detail
            Log::error('API /api/pasien error', [
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'payload' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan pasien',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
