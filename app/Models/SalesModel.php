<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesModel extends Model
{
    use HasFactory;

    protected $table        = 't_sales';
    protected $primaryKey   = 'id';
    protected $keyType      = 'integer';
    public $incrementing    = true;
    protected $fillable     = ['id', 'kode', 'tgl', 'cust_id', 'subtotal', 'diskon', 'ongkir', 'total_bayar'];
    public $timestamps      = false;

    public function details()
    {
        return $this->hasMany(SalesDetailModel::class, 'sales_id');
    }

    public function  customer()
    {
        return $this->belongsTo(CustomerModel::class, 'cust_id');
    }

}
