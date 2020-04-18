<?php
 
namespace App;
 
use Illuminate\Database\Eloquent\Model;
 
class Cekdata extends Model
{ 
    protected $table = 'cekdatas';
    protected $fillable = ['sensor_id', 'room_temperature', 'room_smoke'];
    protected $primaryKey = 'id';
}