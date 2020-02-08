<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
class Login extends Model
{
    public $table = 'login';
    public $primaryKey ="login_id";
    public $updated_at =false;
    public $created_at =false;
    protected $guarded=[];
}