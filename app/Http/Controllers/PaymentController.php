<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createTransaction(Request $request)
    {
        $orderId = 'INV-' . time();

        $transactionDetails = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $request->amount,
            ],
            'customer_details' => [
                'first_name' => $request->first_name,
                'email' => $request->email,
                'phone' => $request->phone,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($transactionDetails);

            Transaction::create([
                'order_id' => $orderId,
                'amount' => $request->amount,
                'status' => 'pending',
            ]);

            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal membuat transaksi'], 500);
        }
    }

    public function handleNotification(Request $request)
    {
        try {
            $notification = new Notification();

            $transaction = Transaction::where('order_id', $notification->order_id)->first();

            if (!$transaction) {
                return response()->json(['error' => 'Transaksi tidak ditemukan'], 404);
            }

            switch ($notification->transaction_status) {
                case 'capture':
                case 'settlement':
                    $transaction->update(['status' => 'success']);
                    break;

                case 'pending':
                    $transaction->update(['status' => 'pending']);
                    break;

                case 'deny':
                case 'expire':
                case 'cancel':
                    $transaction->update(['status' => 'failed']);
                    break;
            }

            return response()->json(['message' => 'Notifikasi diproses']);
        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal memproses notifikasi'], 500);
        }
    }
}