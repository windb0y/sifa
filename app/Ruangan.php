<?php
 
namespace App;
 
use Illuminate\Database\Eloquent\Model;
 
class Ruangan extends Model
{ 
    protected $table = 'ruangans';
    protected $fillable = ['nama_ruangan', 'building_id'];
    protected $primaryKey = 'id';
}