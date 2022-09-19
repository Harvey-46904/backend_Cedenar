<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreasModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'id_area';
    protected $table='area';
}
