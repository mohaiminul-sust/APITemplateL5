<?php
/**
 * Created by PhpStorm.
 * User: Andromeda
 * Date: 4/3/2016
 * Time: 3:38 AM
 */

namespace App\API\Transformers;


use App\API\Models\UserInfo;
use League\Fractal\TransformerAbstract;

class UserInfoTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'devices'
    ];

    public function transform(UserInfo $info){

        return [

            'id' => (int)$info->id,
            'full_name' => (string)$info->full_name,
            'mobile' => (string)$info->mobile,
            'status' => (int)$info->status,
            'balance' => (double) $info->balance,
        ];

    }

    public function includeDevices(UserInfo $info){

        $devices= $info->user->devices;

        if($devices){

            return $this->collection($devices, new DeviceTransformer);

        }
    }
}