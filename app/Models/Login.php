<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Nav;
class Login extends Model
{
    protected $table = 'login';
    public $primaryKey ="login_id";
    public $updated_at =false;
    public $created_at =false;
    protected $guarded=[];
}
