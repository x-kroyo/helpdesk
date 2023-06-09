<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'section_id',
    ];


    public function section()
{
    return $this->belongsTo(Section::class);
}

    public function article(){
        return $this->hasMany(Article::class);
    }

}
