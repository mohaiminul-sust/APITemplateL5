<?php
/**
 * Created by PhpStorm.
 * User: Andromeda
 * Date: 4/3/2016
 * Time: 4:34 AM
 */

namespace App\Http\Controllers;


use App\API\Models\Device;
use App\API\Models\User;
use Illuminate\Routing\Controller;
use Auth;
use Redirect;
use Response;
use Input;
use LucaDegasperi\OAuth2Server\Authorizer;

class OAuthController extends Controller
{
    protected $authorizer;

    public function __construct(Authorizer $authorizer)
    {
        $this->authorizer = $authorizer;

        $this->middleware('auth', ['only' => ['getAuthorize', 'postAuthorize']]);
        $this->middleware('csrf', ['only' => 'postAuthorize']);
        $this->middleware('check-authorization-params', ['only' => ['getAuthorize', 'postAuthorize']]);
    }

    public function postAccessToken()
    {
        $authorizer = $this->authorizer->issueAccessToken();

        if(isset($authorizer['access_token'])){

            if(!Input::has('device_id')){

                return Response::json([
                    'error' => [
                        'http_code' => '400',
                        'message' => 'device_id not given'
                    ]
                ],400);
            }

            $apiuserId = User::where('email', Input::get('username'))->first()->id;
            $device = Device::where('device_id', Input::get('device_id'))->where('apiuser_id', $apiuserId)->first();

            if(!$device){

                $device = new Device;
                $device->device_id = Input::get('device_id');
                $device->apiuser_id = $apiuserId;
                $device->save();
            }

            $authorizer['device_id'] = $device->id;
        }

        return Response::json($authorizer);
    }

    public function getAuthorize()
    {
        return view('authorization-form', $this->authorizer->getAuthCodeRequestParams());
    }

    public function postAuthorize()
    {
        // get the user id
        $params['user_id'] = Auth::user()->id;

        $redirectUri = '';

        if (Input::get('approve') !== null) {
            $redirectUri = $this->authorizer->issueAuthCode('user', $params['user_id'], $params);
        }

        if (Input::get('deny') !== null) {
            $redirectUri = $this->authorizer->authCodeRequestDeniedRedirectUri();
        }

        return Redirect::to($redirectUri);
    }
}