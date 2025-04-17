<?php

namespace App\Http\Controllers;

use App\Models\DetailPembelian;
use App\Models\Pembelians;
use App\Models\Product;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PembelianController extends Controller
{
    public function index()
    {
        $pembelians = Pembelians::orderBy('created_at', 'desc',)->paginate(10);
        $startingNumber = ($pembelians->currentPage() - 1) * $pembelians->perPage() + 1;
        return view('pembelian.index', compact('pembelians', 'startingNumber'));
    }

    public function create()
    {
        $products = Product::all();
        return view('pembelian.create', compact('products'));
    }

public function confirm(Request $request)
{
    if (!$request->has('items') || empty($request->items)) {
        return redirect()->route('pembelian.create')
               ->with('error', 'Pilih minimal satu produk');
    }

    $selectedProducts = [];
    $total = 0;

    foreach($request->items as $productId => $item) {
        $product = Product::find($productId);
        if ($product && $item['quantity'] > 0) {
            $subtotal = $product->harga * $item['quantity'];
            $selectedProducts[] = [
                'id' => $productId,
                'name' => $product->nama_produk,
                'price' => $product->harga,
                'quantity' => $item['quantity'],
                'subtotal' => $subtotal,
                'img' => $product->img
            ];
            $total += $subtotal;
        }
    }

    if (empty($selectedProducts)) {
        return redirect()->route('pembelian.create')
               ->with('error', 'Tidak ada produk valid yang dipilih');
    }

    // Ambil data member untuk dropdown
    $members = Member::orderBy('name')->get();

    return view('pembelian.confirm', compact('selectedProducts', 'total', 'members'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'items' => 'required|array',
        'total_amount' => 'required|numeric',
        'payment_amount' => 'required|numeric',
        'member_type' => 'required|in:member,non_member',
        'phone_number' => 'nullable|required_if:member_type,member',
        'use_points' => 'nullable|boolean',
        'points_used' => 'nullable|numeric|min:0'
    ]);

    DB::beginTransaction();
    try {
        // Handle member
        $customerName = 'Non Member';
        $pointsUsed = 0;
        $discountFromPoints = 0;
        $pointsEarned = 0;
        
        if ($request->member_type === 'member') {
            $member = Member::where('phone_number', $request->phone_number)->first();
            if (!$member) {
                return back()->with('error', 'Member tidak ditemukan');
            }
            $customerName = $member->name;
            
            // Handle penggunaan poin
            if ($request->use_points && $request->points_used > 0) {
                $pointsUsed = min($request->points_used, $member->points);
                // Maksimal diskon 50% dari total belanja
                $maxDiscount = $request->total_amount * 0.5;
                $discountFromPoints = min($pointsUsed * 1000, $maxDiscount);
                $pointsUsed = floor($discountFromPoints / 1000); // Sesuaikan kembali poin yang digunakan
                
                $member->points -= $pointsUsed;
                $member->save();
            }
            
            // Hitung poin yang didapat (jika tidak menggunakan poin)
            if (!$request->use_points) {
                $pointsEarned = floor($request->total_amount / 10000); // Rp 10.000 = 1 poin
                $member->points += $pointsEarned;
                $member->save();
            }
        }

        // Create purchase record
        $pembelian = Pembelians::create([
            'customer_name' => $customerName,
            'invoice_number' => 'INV-' . date('YmdHis') . rand(100, 999),
            'grand_total' => $request->total_amount,
            'tanggal' => now(),
            'dibuat_oleh' => auth()->user()->name, 
            'kembalian' => $request->payment_amount - ($request->total_amount - $discountFromPoints),
            'points_used' => $pointsUsed,
            'discount_from_points' => $discountFromPoints,
            'points_earned' => $pointsEarned,
            'member_phone' => $request->member_type === 'member' ? $request->phone_number : null
        ]);

        // Save purchase details
        foreach ($request->items as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                // Kurangi stok produk
                $product->stok -= $item['quantity'];
                $product->save();
        
                // Simpan detail pembelian
                DetailPembelian::create([
                    'pembelian_id' => $pembelian->id,
                    'id_produk' => $productId,
                    'quantity' => $item['quantity'],
                    'total_price' => $product->harga * $item['quantity']
                ]);
            }
        }
        

        DB::commit();
        return redirect()->route('pembelian.pembayaran', ['id' => $pembelian->id]);
        
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Pembelian error: ' . $e->getMessage());
        return back()->with('error', 'Terjadi kesalahan saat menyimpan transaksi');
    }
}

    public function pembayaran(Pembelians $pembelian)
    {
        $detailPembelian = DetailPembelian::where('pembelian_id', $pembelian->id)
            ->with('product')
            ->get();
    
        $selectedProducts = $detailPembelian->map(function ($detail) {
            return [
                'id' => $detail->id_produk,
                'name' => $detail->product->nama_produk,
                'price' => $detail->product->harga,
                'quantity' => $detail->quantity,
                'subtotal' => $detail->total_price,
                'img' => $detail->product->img
            ];
        })->toArray();
    
        return view('pembelian.pembayaran', [
            'pembelian' => $pembelian,
            'selectedProducts' => $selectedProducts,
            'total' => $pembelian->grand_total,
            'total_bayar' => $pembelian->grand_total + $pembelian->kembalian,
            'kembalian' => $pembelian->kembalian,
            'invoice_number' => $pembelian->invoice_number
        ]);
    }

    public function show(Pembelians $pembelian)
    {
        $detailPembelian = DetailPembelian::where('pembelian_id', $pembelian->id)
            ->with('product')
            ->get();
    
        return view('pembelian.show', compact('pembelian', 'detailPembelian'));
    }
}