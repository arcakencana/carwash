<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class WhatsappHelper
{
    /**
     * List device
     */
    public static function devices()
    {
        return [
            [
                'device'     => '928X49',
                'base_url'   => 'https://pati.wablas.com/api/',
                'token'      => 'lpos93SQ5VZz8kb33JTTpHBaQHWkbg1uKTa5BPyCswq9VHfaDHVIpSy',
                'secret_key' => 'J2a7c9CI',
            ],
            [
                'device'     => 'E03T6W',
                'base_url'   => 'https://pati.wablas.com/api/',
                'token'      => '5D5A5yRnnehdkjf7BDZ5CyPy0iCOLo341SsVHzdg3zRV3K9vAC5cIaE',
                'secret_key' => 'lm34ijlK',
            ],
        ];
    }

    /**
     * Round Robin via Cache
     */
    private static function getNextDevice()
    {
        $devices = self::devices();
        $count   = count($devices);

        // pointer dari cache
        $pointer = Cache::get('wa_pointer', 0);

        // device yang dipilih
        $device = $devices[$pointer];

        // update pointer untuk next request
        Cache::put('wa_pointer', ($pointer + 1) % $count, 86400);

        return $device;
    }

    /**
     * Kirim WhatsApp (Round Robin + Failover 1 loop)
     */
    public static function sendMessage($phone, $message)
    {
        $devices = self::devices();
        $count   = count($devices);

        for ($i = 0; $i < $count; $i++) {

            $device = self::getNextDevice();
            $result = self::sendViaDevice($device, $phone, $message);

            if ($result['success']) {
                return $result;
            }
        }

        return [
            'success' => false,
            'message' => 'Semua device gagal mengirim pesan'
        ];
    }

    /**
     * Kirim via device tertentu (cURL sesuai aturan kamu)
     */
    private static function sendViaDevice($device, $phone, $message)
    {
        $data = [
            'phone'   => $phone,
            'message' => $message,
        ];

        $auth = $device['token'] . '.' . $device['secret_key'];

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Authorization: $auth",
            'Accept: application/json'
        ]);

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL, $device['base_url'] . 'send-message');
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($curl);
        $error    = curl_error($curl);

        curl_close($curl);

        if ($error || !$response) {
            return [
                'success' => false,
                'device'  => $device['device'],
                'error'   => $error ?: 'Tidak ada response'
            ];
        }

        $json = json_decode($response, true);

        return [
            'success'  => isset($json['status']) && $json['status'] === true,
            'device'   => $device['device'],
            'response' => $json
        ];
    }
}
