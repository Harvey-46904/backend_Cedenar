<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LugarVisitanteModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'id_lugar_visita';
    protected $table='lugar_visita';
}
