@component('mail::message')
# Terima kasih. Pesanan Anda telah dibuat, silahkan melanjutkan untuk pembayaran!

Pesanan Anda ditangguhkan hingga kami mengonfirmasi pembayaran telah diterima. Detail pesanan Anda ditunjukkan di bawah ini untuk referensi Anda:

## Pesanan #{{ $order->code }} ({{\App\Helpers\General::datetimeFormat($order->order_date) }})

@component('mail::table')
| Produk       | Kuantitas      | Harga  |
| ------------- |:-------------:| --------:|
@php
$subTotal = 0;
$ongkirTotal = 0;
$totalQty = 0;
$discount = 0;
@endphp
@foreach ($order->orderItems as $item)
| {{ $item->product->name }}      |  {{ $item->qty }}      | {{ number_format($item->price, 0) }}      |
@php
if ($item->product->discount) {
    $discount += $item->product->price_discount - $item->product->price;
    $discount = $discount * $item->qty;
    } else {
    $discount += 0;
}
$subTotal += $item->price * $item->qty;
$totalQty += $item->product_qty;
$ongkirTotal = $order->total_price - $subTotal;
@endphp
@endforeach
| &nbsp;         | <strong>Sub total</strong> | Rp. {{ number_format($subTotal, 0) }} |
| &nbsp;         | Ongkir     | Rp. {{ number_format($ongkirTotal, 0) }} |
| &nbsp;         | Diskon | Rp. {{ number_format($discount, 0) }} |
| &nbsp;         | <strong>Total</strong> | <strong>Rp. {{ number_format($order->total_price, 0) }}</strong>|
@endcomponent

## Detail Penagihan:
<strong>{{ $order->address->recipients_name }}</strong>
<br> {{ $order->address->village->name }}, Kecamatan {{ $order->address->district->name }}, {{ $order->address->city->name }}, Provinsi {{ $order->address->province->name }}, {{$order->address->postal_code}}. [TaniKula Note: {{$order->address->complete_address}} {{$order->address->note_for_courier}}].
<br> Email: {{ $order->user->email }}
<br> Phone: {{ $order->address->telp }}
<br> Postcode: {{ $order->address->postal_code }}

@component('mail::button', ['url' => url('cart/shipment/place-order/received/' . $order->id)])
Tampilkan detail pesanan
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
