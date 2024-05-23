<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class BarangModel extends Model
{
    use HasFactory;
    
    protected $table        = 'm_barang';
    protected $primaryKey   = 'id';
    protected $keyType      = 'string';
    public $incrementing    = false;
    protected $fillable     = ['id', 'kode', 'nama', 'harga'];

    public $timestamps = false; 

    public function salesDetails()
    {
        return $this->hasMany(SalesDetailModel::class, 'barang_id');
    }
}
