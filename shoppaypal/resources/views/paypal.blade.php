<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Áo Quần - Thanh toán PayPal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <div class="max-w-6xl mx-auto py-10">
        <h1 class="text-3xl font-bold text-center mb-8 text-blue-700">🛍️ Cửa hàng Áo Quần</h1>

        {{-- Thông báo thành công / lỗi --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-md mb-6 text-center">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded-md mb-6 text-center">
                {{ session('error') }}
            </div>
        @endif

        {{-- Danh sách sản phẩm --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($products as $p)
                <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition p-4 flex flex-col min-h-[420px]">
                    <img src="{{ asset('img/'.$p->image) }}" alt="{{ $p->name }}" class="w-full h-50 object-cover rounded-xl mb-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-1">{{ $p->name }}</h2>
                    <p class="text-gray-500 mb-2">{{ number_format($p->price, 2) }} USD</p>
                    <p class="text-sm text-gray-400 flex-grow">{{ $p->description }}</p>

                    <a href="{{ route('paypal.payment', $p->id) }}"
                    class="mt-4 inline-flex items-center justify-center gap-2 bg-yellow-400 hover:bg-yellow-500 text-black font-medium py-2 px-4 rounded-lg shadow transition">
                        <img src="{{ asset('img/paypal.png') }}" alt="PayPal" class="w-20 h-6">
                        <span>Thanh toán</span>
                    </a>

                    {{-- <a href="{{ route('momo_payment', $p->id) }}"
                    class="mt-4 inline-flex items-center justify-center gap-2 bg-yellow-400 hover:bg-yellow-500 text-black font-medium py-2 px-4 rounded-lg shadow transition">
                        <img src="{{ asset('img/momo.png') }}" alt="PayPal" class="w-20 h-6">
                        <span>Thanh toán</span>
                    </a> --}}
                    <form action="{{ route('momo.payment', $p->id) }}" method="post">
                        @csrf
                        <input type="hidden" name="price_usd" value="{{ $p->price }}">
                        <button type="submit" class="mt-4 inline-flex items-center justify-center gap-2 bg-pink-200 hover:bg-yellow-500 text-black font-medium py-2 px-4 rounded-lg shadow transition">
                            <img src="{{ asset('img/momo.png') }}" alt="PayPal" class="w-8 h-8">
                            <span>Thanh toán MOMO</span>
                        </button>
                    </form>



                </div>
            @endforeach
        </div>
    </div>

</body>
</html>
