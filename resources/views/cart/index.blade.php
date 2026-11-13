@extends('layouts.app')
@section('title', 'Keranjang Belanja')

@section('content')
    <div class="card">
        <h1>Keranjang Belanja</h1>

        @if (collect($items)->isEmpty())
            <p class="muted">Keranjang belanja kamu masih kosong.</p>
            <a href="{{ route('shop.index') }}" class="btn">Mulai Belanja</a>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
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
                            <td>
                                <a href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a>
                                <div class="muted">Stok tersedia: {{ $product->stock }}</div>
                            </td>
                            <td>Rp{{ number_format($product->price, 2, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('cart.update', $product) }}" method="POST" style="display:flex; gap:8px;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $quantity }}" min="1" max="{{ $product->stock }}" style="width:70px;">
                                    <button type="submit">Ubah</button>
                                </form>
                            </td>
                            <td>Rp{{ number_format($lineSubtotal, 2, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('cart.destroy', $product) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @php
                $grandTotal = $total ?? $subtotal ?? collect($items)->sum(function ($item) {
                    return $item['subtotal'] ?? $item['line_total'] ?? ($item['product']->price * $item['quantity']);
                });
            @endphp

            <div style="margin-top: 16px; display: flex; justify-content: space-between; align-items: center;">
                <a href="{{ route('shop.index') }}">← Lanjut Belanja</a>
                <div>
                    <strong>Total: Rp{{ number_format($grandTotal, 2, ',', '.') }}</strong>
                    <a href="{{ route('checkout.index') }}" class="btn" style="margin-left: 12px;">Lanjut ke Checkout</a>
                </div>
            </div>
        @endif
    </div>
@endsection