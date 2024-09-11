<?php

namespace App\Http\Controllers;

use App\Models\TransaksiTransfer;
use App\Models\RekeningAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class TransferController extends Controller
{
    public function transfer(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $validator = Validator::make($request->all(), [
            'bank_pengirim_id' => 'required|exists:banks,id',
            'bank_tujuan_id' => 'required|exists:banks,id',
            'jumlah_transfer' => 'required|numeric|min:10000',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $counter = str_pad(TransaksiTransfer::count() + 1, 5, '0', STR_PAD_LEFT);
        $idTransaksi = 'TF' . date('ymd') . $counter;
        $kodeUnik = rand(100, 999);

        // Checking Rek
        $rekeningPengirim = RekeningAdmin::where('bank_id', $request->bank_pengirim_id)->first();
        $rekeningTujuan = RekeningAdmin::where('bank_id', $request->bank_tujuan_id)->first();

        if (!$rekeningPengirim || !$rekeningTujuan) {
            return response()->json(['error' => 'Rekening admin tidak ditemukan untuk bank terkait.'], 400);
        }

        $transaksi = TransaksiTransfer::create([
            'id_transaksi' => $idTransaksi,
            'user_id' => $user->id,
            'bank_pengirim_id' => $request->bank_pengirim_id,
            'bank_tujuan_id' => $request->bank_tujuan_id,
            'kode_unik' => $kodeUnik,
            'jumlah_transfer' => $request->jumlah_transfer,
            'total_transfer' => $request->jumlah_transfer + $kodeUnik,
            'status' => 'pending',
        ]);

        return response()->json(['transaksi' => $transaksi], 201);
    }
}

