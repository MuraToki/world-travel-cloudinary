<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

        //可変項目
        protected $fillable = [
            'user_id',
            'title',
            'content',
        ];
        
        public function user(){
            return $this->belongsTo(\App\Models\User::class,'user_id');
        }

        public function users(){
            return $this->belongsToMany('App\Models\User')->withTimestamps();
        }
}
