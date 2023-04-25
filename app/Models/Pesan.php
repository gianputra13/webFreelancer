<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pesan extends Model
{
    //use HasFactory;
    use SoftDeletes;

    public $table = 'pesan';
    
    protected $guarded = [
        'id'
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at'
     ];

     //many to one
    public function user_buyer(){
        return $this->belongsTo('App\Models\User', 'buyer_id', 'id');
    }

    public function user_freelancer(){
        return $this->belongsTo('App\Models\User', 'freelancer_id', 'id');
    }

    public function service(){
        return $this->belongsTo('App\Models\Service', 'service_id', 'id');
    }

    public function order_status(){
        return $this->belongsTo('App\Models\PesanStatus', 'pesan_status_id', 'id');
    }
}
