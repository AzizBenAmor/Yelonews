<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
class Post extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded=[];
    protected $casts = [
        'published_at' => 'datetime',
    ];
    public function scopePublished($query){

        $query->where('published_at','<=',now());

    }

    public function scopeFeatured($query){
        $query->where('featured',true);
    }

    public function scopeCategory($query,$category){

        $query->whereHas('categories',function ($query) use($category) {
            $query->where('slug',$category);
        });

    }

    public function scopePopular($query){

        $query->withCount('likes')
        ->orderBy('likes_count','desc');

    }

    public function author(){
       return $this->belongsTo(User::class,'user_id');
    }

    public function categories(){

        return $this->belongsToMany(Category::class);
     }

    public function getExcerpt(){
        
        return Str::limit(strip_tags($this->body),150) ;

    }

    public function readingTime(){

        $mins= round(str_word_count($this->body) /250) ;
        return ($mins < 1) ? '1' : $mins;

    }

    public function likes(){
        return $this->belongsToMany(User::class,'post_like')->withTimestamps();   
    }

    public function comments(){
        return $this->hasMany(Comment::class);   
    }
}
