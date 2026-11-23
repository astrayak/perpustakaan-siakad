<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use SoftDeletes;
    protected $fillable = ['nama_kategori', 'slug', 'deskripsi'];

    public function bukus() { return $this->hasMany(Buku::class); }
}