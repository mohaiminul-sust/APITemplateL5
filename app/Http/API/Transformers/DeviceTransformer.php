<?php
/**
 * Created by PhpStorm.
 * User: Andromeda
 * Date: 4/3/2016
 * Time: 3:41 AM
 */

namespace App\Http\API\Transformers;


use App\Http\API\Models\Device;
use League\Fractal\TransformerAbstract;

class DeviceTransformer extends TransformerAbstract
{
    public function transform(Device $device){

        return [

            'id' => (int)$device->id,
            'device_id' => (string)$device->device_id
        ];

    }
}