@extends('layouts.app')
@section('title', 'Pesanan Saya')

@section('content')
    <div class="card">
        <h1>Riwayat Pesanan Saya</h1>

        @if (session('success'))
            <div style="padding: 10px; background: #ecfdf5; color: #065f46; border-radius: 6px; margin-bottom: 12px;">
                {{ session('success') }}
            </div>
        @endif

        @if ($orders->isEmpty())
            <p class="muted">Kamu belum memiliki riwayat pesanan.</p>
            <a href="{{ route('shop.index') }}" class="btn">Mulai Belanja</a>
        @else
            <table>
                <thead>
                    <tr>
                        <th>No. Pesanan</th>
                        <th>Tanggal</th>
                        <th>Ekspedisi</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td><strong>{{ $order->order_number }}</strong></td>
                            <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                            <td>{{ $order->shippingService->name ?? '-' }}</td>
                            <td>Rp{{ number_format($order->total ?? $order->grand_total, 2, ',', '.') }}</td>
                            <td>{{ strtoupper($order->status) }}</td>
                            <td>
                                <a href="{{ route('orders.show', $order) }}">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top: 12px;">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
@endsection