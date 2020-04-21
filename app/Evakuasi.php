<?php
 
namespace App;
 
use Illuminate\Database\Eloquent\Model;
 
class Evakuasi extends Model
{ 
    protected $table = 'evacuations';
    protected $fillable = ['ruangan_id', 'langkah', 'pesan'];
    protected $primaryKey = 'id';
}