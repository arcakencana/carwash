<?php

namespace App\Helpers;

class WhatsappHelper
{
    /**
     * Generate pesan WhatsApp
     */
    public static function notifikasi($nomor, $nama, $noAntrian, $url)
    {
        $message = "Halo $nama, 
        pendaftaran kamu berhasil ✅

        Nomor Antrian: *$noAntrian*
        Silakan download bukti pendaftaran melalui link berikut:
        $url

        Terima kasih.
        ";

        $url = env('WA_API_URL') . 'send/message';

        $auth = env('WA_API_USER') . ':' . env('WA_API_PASSWORD');

        $nomor = '62' . substr($nomor, 1);

        $data = [
            'phone' => $nomor . '@s.whatsapp.net',
            'message' => $message,
            'reply_message_id' => '',
            'is_forwarded' => false,
            'duration' => 1800
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $auth);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        curl_close($ch);

        // $responseData = json_decode($response);

        // if (empty($responseData->results)) {

        //     $status = $responseData->message;
        //     $id_message = '';

        // } else {

        //     $status = $responseData->message;
        //     $id_message = $responseData->results->message_id;

        // }
    }
}
