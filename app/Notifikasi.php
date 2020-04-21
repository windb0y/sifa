<?php
 
namespace App;
 
use Illuminate\Database\Eloquent\Model;
 
class Notifikasi extends Model
{ 
    protected $table = 'notifications';
    protected $fillable = ['sensor_id', 'pesan'];
    protected $primaryKey = 'id';
}