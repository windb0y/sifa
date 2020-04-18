<?php
 
namespace App;
 
use Illuminate\Database\Eloquent\Model;
 
class Perangkat extends Model
{ 
    protected $table = 'perangkats';
    protected $fillable = ['sensor_id', 'control','threshold','ruangan_id'];
    protected $primaryKey = 'id';
}