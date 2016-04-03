<?php
/**
 * Created by PhpStorm.
 * User: Andromeda
 * Date: 4/3/2016
 * Time: 3:16 AM
 */

namespace App\API\Models;
use Illuminate\Database\Eloquent\Model;


/**
 * @property mixed id
 * @property mixed device_id
 */
class Device extends Model
{
    protected $guarded = ['id'];
    protected $table = 'device_id';

    public static $rules = [
        'device_id' => 'required',
    ];

    public function user(){
        return $this->belongsTo('API\Models\User', 'apiuser_id', 'id');
    }
}