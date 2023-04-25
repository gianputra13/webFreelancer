<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PesanStatus extends Model
{
    //use HasFactory;
    use SoftDeletes;

    public $table = 'pesan_status';
    
    protected $guarded = [
        'id'
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at'
     ];

     //one to many
     public function order(){
        return $this->hasMany('App\Models\Order', 'order_status_id');
    }
}
