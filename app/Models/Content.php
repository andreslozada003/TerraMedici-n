<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
class Content extends Model {
 use SoftDeletes;
 protected $fillable=['type','title','slug','excerpt','body','location','category','cover_path','status','published_at','meta_description'];
 protected $casts=['published_at'=>'datetime'];
 protected static function booted(): void { static::creating(function($item){ $item->slug ??= static::uniqueSlug($item->title); }); }
 public static function uniqueSlug(string $title, ?int $ignore=null): string { $base=Str::slug($title) ?: 'contenido'; $slug=$base; $n=2; while(static::withTrashed()->where('slug',$slug)->when($ignore,fn($q)=>$q->whereKeyNot($ignore))->exists()) $slug=$base.'-'.$n++; return $slug; }
 public function scopePublic($q){ return $q->where('status','published')->where(fn($x)=>$x->whereNull('published_at')->orWhere('published_at','<=',now())); }
}
