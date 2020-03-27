<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
class Swiper extends Model
{
    public $table = 'swiper';
    public $primaryKey ="swiperid";
    public $updated_at =false;
    public $created_at =false;
    protected $guarded=[];
    // public function tojson($data){
    // 	return json_encode($data);
    // }
}