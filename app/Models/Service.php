<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    //use HasFactory;
    use SoftDeletes;

    public $table = 'service';
    
    protected $guarded = [
        'id'
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at'
     ];

     // many to one
     public function user(){
        return $this->belongsTo('App\Models\User', 'users_id', 'id');
    }

    // one to many
    public function advantage_user(){
        return $this->hasMany('App\Models\AdvantageUser', 'service_id');
    }

    public function advatage_service(){
        return $this->hasMany('App\Models\AdvantageService', 'service_id');
    }

    public function thumbnail_service(){
        return $this->hasMany('App\Models\ThumbnailService', 'service_id');
    }

    public function tagline(){
        return $this->hasMany('App\Models\Tagline', 'service_id');
    }

    public function order(){
        return $this->hasMany('App\Models\Order', 'service_id');
    }
}
