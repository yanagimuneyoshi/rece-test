<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Reservation;

class QRCodeController extends Controller
{
    public function generate($reservationId)
    {
        try {
            $reservation = Reservation::findOrFail($reservationId);
            $qrCodeUrl = QrCode::format('png')->size(200)->generate(url('/reservation/' . $reservationId));

            return response()->json(['status' => 'success', 'qrCodeUrl' => 'data:image/png;base64,' . base64_encode($qrCodeUrl)]);
        } catch (\Exception $e) {
            \Log::error('QRコードの生成に失敗しました: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'QRコードの生成に失敗しました'], 500);
        }
    }

    public function verifyQRCode(Request $request)
    {
        try {
            $qrCodeContent = $request->input('qr_code_content');
            $url = parse_url($qrCodeContent);
            parse_str($url['query'], $params);
            $reservationId = $params['id'] ?? null;

            if (!$reservationId) {
                return response()->json(['status' => 'error', 'message' => 'QRコードの内容が無効です'], 400);
            }

            $reservation = Reservation::find($reservationId);

            if ($reservation) {
                return response()->json(['status' => 'success', 'message' => '照合が成功しました']);
            } else {
                return response()->json(['status' => 'error', 'message' => '照合に失敗しました'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
