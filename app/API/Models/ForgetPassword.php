<?php
/**
 * Created by PhpStorm.
 * User: Andromeda
 * Date: 4/3/2016
 * Time: 3:18 AM
 */

namespace app\API\Models;
use Illuminate\Database\Eloquent\Model;


class ForgetPassword extends Model
{
    protected $guarded = ['id'];
    protected $table = 'forget_password';

    public function user(){
        return $this->belongsTo('API\Models\User', 'apiuser_id', 'id');
    }
}