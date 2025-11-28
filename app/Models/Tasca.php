<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tasca extends Model
{
    use HasFactory;

    protected $table = 'tasques';

    protected $fillable = [
        'titol',
        'descripcio',
        'data_limit',
        'estat'
    ];

    // Constants d'estat
    public const ESTATS = ['pendent', 'en_curs', 'completada'];
}
