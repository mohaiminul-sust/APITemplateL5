<?php namespace App\Http\Controllers\API;
/**
 * Created by PhpStorm.
 * User: Andromeda
 * Date: 4/3/2016
 * Time: 3:24 AM
 */


use App\Http\API\Models\User;
use App\Http\API\Models\UserInfo;
use App\Http\API\Transformers\UserInfoTransformer;
use App\Http\API\Transformers\UserTransformer;
use App\Http\Controllers\Controller;
use EllipseSynergie\ApiResponse\Laravel\Response;
use League\Fractal\Serializer\DataArraySerializer;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use Input;
use Validator;
use Hash;
use Exception;
use Mail;

class UserController extends Controller
{
    /**
     * Construct for managing includes and responses.
     * @param Response
     * @uses \League\Fractal\Manager
     * @uses \EllipseSynergie\ApiResponse\Laravel\Response
     */
    public function __construct(Response $response)
    {

        if (isset($_GET['include'])) {
            $manager = new Manager;

            // Set serializer with link support
            $manager->setSerializer(new DataArraySerializer());

            // Set the request scope if you need embed data
            $manager->parseIncludes(explode(',', $_GET['include']));

            // Instantiate the response object, replace the class name by your custom class
            $response = new Response($manager);
        }

        $this->response = $response;
    }

    /**
     * Display a listing of the users.
     * @link GET /users
     *
     * @return Response
     */
    public function index()
    {
        $users = User::paginate(10);

        if(!$users->isEmpty()){

            return $this->response->withPaginator($users, new UserTransformer());
        }

        return $this->response->errorNotFound();
    }

    /**
     * Display the specified user by id.
     * @link GET /users/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if($user){

            return $this->response->withItem($user, new UserTransformer());
        }

        return $this->response->errorNotFound();
    }

    /**
     * Register new user.
     * POST /register
     *
     * @var Content-Type application/json
     * @uses  raw email, password, password-confirmation
     * @return Response
     */
    public function doRegister(){

        $data = Input::all();

        $validator = Validator::make($data, User::$rulesRegistration);

        if($validator->fails()){

            return $this->response->errorWrongArgsValidator($validator);
        }

        $user = new User;
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);

        if($user->save()){
            //user info
            $userInfo = new UserInfo;
            $userInfo->full_name = $data['full_name'];
            $userInfo->mobile = $data['mobile'];
            $userInfo->apiuser_id = $user->id;

            if($userInfo->save()){


                return \Response::json([
                    'success' => [
                        'http_code' => '201',
                        'message' => 'User registered successfully',
                        'user_data' => $user,
                    ]
                ],201);
            }
        }else{

            return $this->response->errorInternalError();
        }
    }

    /**
     * Logout user.
     * GET /logout
     *
     * @var Authorization Bearer {access_token}
     * @return Response
     */
    public function logout(){
        try{

            \DB::table('oauth_sessions')
                ->where('owner_type', \Authorizer::getResourceOwnerType())
                ->where('owner_id', \Authorizer::getResourceOwnerId())
                ->delete();

            return \Response::json([
                'success' => [
                    'http_code' => '200',
                    'message' => 'User logged out successfully'
                ]
            ],200);

        }catch(Exception $ex){

            return $this->response->errorInternalError();

        }
    }

    /**
     * User info getter.
     * GET /info
     *
     * @var Authorization Bearer {access_token}
     * @return Response
     */
    public function userInfo(){

        $resourceOwnerType = \Authorizer::getResourceOwnerType();
        $resourceOwnerId = \Authorizer::getResourceOwnerId();


        if ($resourceOwnerType === 'user')
        {
            try {

                $user = User::findOrFail($resourceOwnerId);
                return $this->response->withItem($user->userInfo, new UserInfoTransformer);

            } catch (Exception $e) {

                return $this->response->errorNotFound('User\'s info is not available.');
            }

        }
        return $this->response->errorInternalError();
    }

    /**
     * Sending activation link for forgotten password case
     * POST /forgetpass
     *
     * @var Content-Type application/json
     * @uses  raw {email, password, password-confirmation}
     * @return Response
     */
    public function forgetPassword(Request $request){
        //getting data
        $data = $request->all();
        $validator = Validator::make($data, User::$rulesActivation);
        // return $validator->errors();
        if($validator->fails()){

            return $this->response->errorWrongArgsValidator($validator);
        }

        //EXCEPTION HANDLING
        try{

            try{

                $user = User::where('email',$data['email'])->with('userInfo')->first();
            }catch(\Exception $e){

                return $this->response->errorInternalError("User can't be fetched!");
                // return $e;
            }
            // return $user;
            if($user != null){
                if ($user->userInfo->activation){
                    return \Response::json([
                        'success' => [
                            'http_code' => '200',
                            'message' => 'You are already activated!'
                        ]
                    ],200);
                }else if($user->userInfo->activation == 0){
                    return $this->response->errorForbidden("Your account is not activated!");
                }
            }
            else{

                return $this->response->errorForbidden('You are not registered!');
            }
        }catch (Exception $ex){

            return $this->response->errorInternalError("User can't be processed!");
        }

        //password rewrite
        try {
            $user->password = Hash::make($data['password']);
            $user->save();
        } catch (Exception $e) {
            return $this->response->errorInternalError('Password set error!');
        }

        //activation link gen
        $confirmation_code = str_random(30);

        $affectedRows = UserInfo::where('apiuser_id',$user->id)->update(['activation_key' => $confirmation_code]);

        //Mail
        if($affectedRows != null){

            try{
                Mail::send('apiuser.activation', ['confirmation_code'=>$confirmation_code, 'fullName'=>$user->userInfo->full_name], function($message) {
                    $message->to(\Input::get('email'))
                        ->subject('Verify password change');
                });

                return \Response::json([
                    'success' => [
                        'http_code' => '200',
                        'message' => 'Mail sent!'
                    ]
                ],200);
            }catch (Exception $ex){
                return $this->response->errorInternalError('Email-not sent!');
            }

        }else{

            return $this->response->errorForbidden('Error in Email Address or Password.');
        }
    }

    /**
     * Activating user from the link in email
     * GET /activate/{confirmation_code}
     *
     * @param  string confirmation_code
     * @return Response
     */
    public function activateUser($confirmation_code){

        if(!$confirmation_code)
        {
            return \Response::make("Invalid confirmation code", 431);

        }

        $user = UserInfo::where('activation_key',$confirmation_code)->first();

        if ($user != null)
        {
            $user->activation= true;
            $user->activation_key = null;
            $user->save();

            return \Response::make("Account activated successfully", 200);

        }else{
            return \Response::make("Confirmation code expired", 431);

        }
    }

}