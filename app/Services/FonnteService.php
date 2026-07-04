<?php

namespace App\Services;

class FonnteService
{
    /**
     * Mengirimkan kode OTP ke WhatsApp via Fonnte API Gateway
     */
    public static function sendOtp($nomorWa, $kodeOtp)
    {
        // Ambil token dari file .env, atau langsung fallback ke token kamu jika .env belum terbaca
        $token = env('FONNTE_TOKEN', 'dFEon26Sa6vtgyyPBrVq');
        
        $curl = curl_init();

        // Pastikan nomor tujuan bersih dari karakter '+' atau spasi
        $nomorTujuan = preg_replace('/[^0-9]/', '', $nomorWa);

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $nomorTujuan,
                'message' => "Kode OTP Keamanan SIDAYA Anda adalah: *{$kodeOtp}*. Kode ini rahasia dan berlaku selama 5 menit.",
                'countryCode' => '62', // Default Indonesia
            ),
            CURLOPT_HTTPHEADER => array(
                "Authorization: " . $token
            ),
        ));

        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        // CATAT KE LOG UNTUK DEBUGGING (Cek di storage/logs/laravel.log)
        if ($error) {
            \Log::error("cURL Error dari Fonnte: " . $error);
        } else {
            \Log::info("Respons API Fonnte untuk [{$nomorTujuan}]: " . $response);
        }

        return $response;
    }
}