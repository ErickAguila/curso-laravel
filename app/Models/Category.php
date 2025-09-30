<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category'; //Relaciona esta clase con la tabla categories
    protected $fillable = ['name']; //Campos que se pueden asignar masivamente

    public function products(){
        return $this->hasMany(Product::class);
    }
}
