<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitaModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'id_visita';
    protected $table='visita';
}
