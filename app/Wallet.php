<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Wallet extends Model
{
    //protected $fillable = ['user_id','account_number','amount'];
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');//(Model name, foreign key, primary key)
    }

}
