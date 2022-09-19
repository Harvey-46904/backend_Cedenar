<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioXModel extends Model
{
    use HasFactory;
    public $timestamps = false;
  
    protected $table='usuario_x_rol';
}
