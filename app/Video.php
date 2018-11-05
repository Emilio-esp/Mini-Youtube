<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['title','description','status','image','video_path'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function scopeSearch($query, $option){
        if (trim($option) != '') {
            return $query->where('title', 'like', '%'.$option.'%');
        }
    }
}
