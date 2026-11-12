@extends('layouts.app')
@section('title', 'Detail Pesanan ' . $order->order_number)

@section('content')
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1>Detail Pesanan #{{ $order->order_number }}</h1>
            <a href="{{ route('orders.index') }}">← Kembali ke Daftar Pesanan</a>
        </div>

        <p class="muted">
            Tanggal: {{ $order->created_at->format('d-m-Y H:i') }} |
            Status: <strong>{{ strtoupper($order->status) }}</strong>
        </p>

        <div style="margin: 16px 0; padding: 12px; background: #f9fafb; border-radius: 6px;">
            <strong>Pengiriman ({{ $order->shippingService->name ?? '-' }})</strong>
            <p style="margin: 4px 0;">{{ $order->shipping_address }}</p>
            @if ($order->notes)
                <p class="muted" style="margin: 4px 0;">Catatan: {{ $order->notes }}</p>
            @endif
        </div>

        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name ?? $item->product->name }}</td>
                        <td>Rp{{ number_format($item->price ?? $item->unit_price, 2, ',', '.') }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp{{ number_format($item->subtotal, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 16px; text-align: right;">
            <div>Subtotal Produk: Rp{{ number_format($order->subtotal, 2, ',', '.') }}</div>
            <div>Ongkos Kirim: Rp{{ number_format($order->shipping_cost, 2, ',', '.') }}</div>
            <div style="font-size: 1.1em; margin-top: 4px;">
                <strong>Total Bayar: Rp{{ number_format($order->total ?? $order->grand_total, 2, ',', '.') }}</strong>
            </div>
        </div>
    </div>
@endsection