<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelians extends Model
{
    use HasFactory;

    protected $table = 'pembelians';
    protected $casts = [
        'tanggal' => 'datetime',
    ];
    
    protected $fillable = [
        'customer_name',
        'invoice_number',
        'grand_total',
        'tanggal',
        'dibuat_oleh',
        'kembalian'
    ];


    public function details()
    {
        return $this->hasMany(DetailPembelian::class, 'pembelian_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }


}