<?php
/**
 * Created by PhpStorm.
 * User: Andromeda
 * Date: 4/3/2016
 * Time: 3:13 AM
 */

namespace App\API\Models;
use Illuminate\Database\Eloquent\Model;


/**
 * @property mixed user
 */
class UserInfo extends Model
{
    protected $guarded = ['id'];
    protected $table = 'apiuser_info';

    public function user(){
        return $this->belongsTo('API\Models\User', 'apiuser_id', 'id');
    }

}