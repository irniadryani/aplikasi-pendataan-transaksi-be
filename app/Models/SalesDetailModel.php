<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDetailModel extends Model
{
    use HasFactory;

    protected $table        = 't_sales_det';
    protected $primaryKey   = '';
    protected $keyType      = 'string';
    public $incrementing    = false;
    protected $fillable     = ['sales_id', 'barang_id', 'harga_bandrol', 'qty', 'diskon_pct', 'diskon_nilai', 'harga_diskon', 'total'];
    public $timestamps      = false;

    public function sales()
    {
        return $this->belongsTo(SalesModel::class, 'sales_id');
    }

    public function barang()
    {
        return $this->belongsTo(BarangModel::class, 'barang_id');
    }

}
