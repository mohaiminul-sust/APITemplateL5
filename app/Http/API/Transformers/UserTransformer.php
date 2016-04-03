<?php
/**
 * Created by PhpStorm.
 * User: Andromeda
 * Date: 4/3/2016
 * Time: 3:34 AM
 */

namespace App\Http\API\Transformers;

use App\Http\API\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'info'
    ];

    public function transform(User $user) {

        return [

            'id' => (int)$user->id,
            'email' => (string)$user->email,
            'created_at' => $user->getApiUserCreatedAt(),
            'updated_at' => $user->getApiUserUpdatedAt(),
            'links'      => [
                [
                    'rel' => \Config::get('customConfig.baseURL'),
                    'uri' => '/users/'.$user->id,
                ]
            ],

        ];
    }

    /**
     * @param User $user
     * @return \League\Fractal\Resource\Item
     */
    public function includeInfo(User $user){

        if($user->userInfo){

            return $this->item($user->userInfo, new UserInfoTransformer);

        }
    }
}