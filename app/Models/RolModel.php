<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'id_rol';
    protected $table='rol';
}
