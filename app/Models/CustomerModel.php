<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerModel extends Model
{
    use HasFactory;

    protected $table        = 'm_customer';
    protected $primaryKey   = 'id';
    protected $keyType      = 'string';
    public $incrementing    = false;
    protected $fillable     = ['id', 'kode', 'name', 'telp'];

    public $timestamps = false; 

    public function sales()
    {
        return $this->hasMany(SalesModel::class, 'cust_id');
    }
}
