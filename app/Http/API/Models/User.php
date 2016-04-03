<?php
/**
 * Created by PhpStorm.
 * User: Andromeda
 * Date: 4/3/2016
 * Time: 3:02 AM
 */

namespace App\Http\API\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed updated_at
 * @property mixed created_at
 */
class User extends Model
{
    protected $table = 'apiuser';

    protected $guarded = ['id'];

    public static $rules = [
        'email'    => 'required|email|unique:apiuser,email',
        'password' => 'required|between:8,12|confirmed',
        'password_confirmation' => 'required|between:8,12'
    ];

    public static $rulesRegistration = [
        'email'    => 'required|email|unique:apiuser,email',
        'password' => 'required|between:8,12|confirmed',
        'password_confirmation' => 'required|between:8,12',
        'full_name' => 'required',
        'mobile' => 'required',
    ];

    public static $rulesActivation = [
        'email'    => 'required|exists:apiuser,email',
        'password' => 'required|between:8,12|confirmed',
        'password_confirmation' => 'required|between:8,12',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function userInfo(){
        return $this->hasOne('API\Models\ApiUserInfo','apiuser_id','id');
    }

    public function userPassowrd(){
        return $this->hasOne('API\Models\ForgetPassword','apiuser_id','id');
    }

    public function devices(){
        return $this->hasMany('API\Models\Device','apiuser_id','id');
    }

    public function getApiUserCreatedAt(){
        return $this->created_at->format('D, d.m.Y H:i:s');
    }

    public function getApiUserUpdatedAt(){
        return $this->updated_at->format('D, d.m.Y H:i:s');
    }
}