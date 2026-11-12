@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
    <div class="card">
        <h1>Checkout Pesanan</h1>

        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    @php
                        $product = $item['product'];
                        $quantity = $item['quantity'];
                        $lineSubtotal = $item['subtotal'] ?? $item['line_total'] ?? ($product->price * $quantity);
                    @endphp
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>Rp{{ number_format($product->price, 2, ',', '.') }}</td>
                        <td>{{ $quantity }}</td>
                        <td>Rp{{ number_format($lineSubtotal, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @php
            $calculatedSubtotal = $subtotal ?? $total ?? collect($items)->sum(function ($item) {
                return $item['subtotal'] ?? $item['line_total'] ?? ($item['product']->price * $item['quantity']);
            });
            $servicesList = $shippingServices ?? $services ?? $shipping_services ?? [];
        @endphp

        <p style="margin-top: 12px;">
            <strong>Subtotal Produk: Rp{{ number_format($calculatedSubtotal, 2, ',', '.') }}</strong>
        </p>

        <form action="{{ route('checkout.store') }}" method="POST" style="margin-top: 16px;">
            @csrf

            <div style="margin-bottom: 12px;">
                <label for="recipient_name"><strong>Nama Penerima</strong></label><br>
                <input type="text" name="recipient_name" id="recipient_name" value="{{ old('recipient_name', auth()->user()->name) }}" required style="width: 100%; padding: 8px;">
            </div>

            <div style="margin-bottom: 12px;">
                <label for="phone"><strong>Nomor Telepon / HP</strong></label><br>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" required style="width: 100%; padding: 8px;">
            </div>

            <div style="margin-bottom: 12px;">
                <label for="shipping_service_id"><strong>Pilih Layanan Ekspedisi</strong></label><br>
                <select name="shipping_service_id" id="shipping_service_id" required style="width: 100%; padding: 8px;">
                    <option value="">-- Pilih Ekspedisi --</option>
                    @foreach ($servicesList as $service)
                        @php
                            $serviceLabel = $service->name ?? trim(($service->courier ?? '') . ' ' . ($service->service ?? $service->service_name ?? ''));
                        @endphp
                        <option value="{{ $service->id }}" {{ old('shipping_service_id') == $service->id ? 'selected' : '' }}>
                            {{ $serviceLabel }} - Rp{{ number_format($service->cost, 2, ',', '.') }}
                            @if(!empty($service->estimated_days)) ({{ $service->estimated_days }}) @endif
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 12px;">
                <label for="address"><strong>Alamat Pengiriman Lengkap</strong></label><br>
                <textarea name="address" id="address" rows="3" required style="width: 100%; padding: 8px;">{{ old('address') }}</textarea>
            </div>

            <div style="margin-bottom: 16px;">
                <label for="notes">Catatan Pesanan (Opsional)</label><br>
                <input type="text" name="notes" id="notes" value="{{ old('notes') }}" style="width: 100%; padding: 8px;">
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center;">
                <a href="{{ route('cart.index') }}">← Kembali ke Keranjang</a>
                <button type="submit" class="btn">Buat Pesanan</button>
            </div>
        </form>
    </div>
@endsection