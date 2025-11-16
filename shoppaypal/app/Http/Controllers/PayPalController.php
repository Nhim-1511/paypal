<?php

namespace App\Http\Controllers;

use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class PayPalController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $total_after = $products->sum('price'); // tổng tất cả giá sản phẩm
        return view('paypal', compact('products','total_after'));
    }

    // Thanh toán sản phẩm theo id
    public function payment($id)
    {
        $product = Product::findOrFail($id);

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.payment.success'),
                "cancel_url" => route('paypal.payment.cancel'),
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $product->price
                    ],
                    "description" => $product->name
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    // lưu product_id tạm vào session để biết sản phẩm nào
                    session(['paypal_product_id' => $product->id]);
                    return redirect()->away($link['href']);
                }
            }
        }

        return redirect()->route('paypal')->with('error', 'Không thể tạo đơn hàng.');
    }

    public function paymentCancel()
    {
        return redirect()->route('paypal')->with('error', 'Bạn đã hủy giao dịch.');
    }

    public function paymentSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {

            $productId = session('paypal_product_id');
            $product = Product::find($productId);

            // Lưu đơn hàng
            Order::create([
                'product_id' => $product->id,
                'amount' => $product->price,
                'payer_email' => $response['payer']['email_address'] ?? null,
                'paypal_order_id' => $response['id'],
            ]);

            session()->forget('paypal_product_id');

            return redirect()->route('paypal')->with('success', 'Thanh toán thành công!');
        }

        return redirect()->route('paypal')->with('error', 'Đã xảy ra lỗi khi xử lý giao dịch.');
    }
}
