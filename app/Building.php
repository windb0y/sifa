<?php
 
namespace App;
 
use Illuminate\Database\Eloquent\Model;
 
class Building extends Model
{ 
    protected $table = 'buildings';
    protected $fillable = ['nama_gedung'];
    protected $primaryKey = 'id';
}