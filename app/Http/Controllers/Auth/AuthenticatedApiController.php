<?php

namespace App\Http\Controllers\Auth;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\UtilityFunction;
use Illuminate\Validation\Rules;
use Sales\Customer\Models\Customer;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Ekhoncharge\Vehicle\Models\CustomerVehicle;
use Illuminate\Support\Facades\Hash;
use Ekhoncharge\Vehicle\Models\Vehicle;
use Illuminate\Support\Facades\Validator;
// use Pondit\PonditHelper\Http\Traits\UtilityFunction;

class AuthenticatedApiController extends Controller
{
    use UtilityFunction;

    public function login(Request $request)
    {
        try {
            $req = $request->all();
            $loginField = filter_var($req['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

            $validator = Validator::make($req, [
                'login'    => 'required',
                'password' => 'required',
            ]);
            $validator->setAttributeNames(['login' => 'Email or Phone']); 

            $this->checkValidation($validator);

            $credentials = [
                $loginField => $req['login'],
                'password'  => $req['password'],
            ];

            // Manually check authentication
            if (!User::where($loginField, $credentials[$loginField])->exists()) {
                if (filter_var($credentials[$loginField], FILTER_VALIDATE_EMAIL)) {
                    throw new Exception("Email Not Registered.", 400);
                } else{ // Assuming  phone number
                    throw new Exception("Phone Number Not Registered.", 400);
                }
            }
            

            if (!Auth::attempt($credentials)) {
                throw new Exception("Invalid password.", 400);
            }

            // $token = Auth::user()->createToken('api auth token')->accessToken;
            $token = Auth::user()->createToken('api auth token')->accessToken;

        
            $user = User::where('id', Auth::user()->id)->first();
                return response()->json([
                    'success'             => true,
                    'access_token'        => $token,
                    'user'                => $user,
                ], 200);
            
        } catch (Exception $e) {
            return response()->json($this->catchException($e), $this->exceptionCode($e));
        }
    }

    public function verifyLogin(Request $request)
    {
        try 
        {
            $req = $request->all();
            $validator = Validator::make($req, [
                'email'    => 'required|email',
                'password' => 'required',
            ]);
            $this->checkValidation($validator);
            if(!Auth::attempt($req))
                throw new Exception("Credentials Mismatch", 400);
            return response()->json([
                'success'      => true,
                'user'         => Auth::user()
            ], 200);
        } 
        catch (Exception $e) {
            return response()->json($this->catchException($e), $this->exceptionCode($e));
        }
    }

    public function register(Request $request)
    {
        try 
        {
            $req       = $request->all();
            
            $validator = Validator::make($req, [
                'name'     => 'required|string|max:255',
                'email'    => 'required|string|email|max:255|unique:users',
                'password' => ['required', 'confirmed', Rules\Password::min(8)],
            ]);
            $this->checkValidation($validator);
    
            $user = User::create([
                'name'           => $req['name'],
                'email'          => $req['email'],
                'phone'          => $req['phone'] ?? null,
                'address'        => $req['address'] ?? null,
                'profession'     => $req['profession'] ?? null,
                'password'       => Hash::make($req['password']),
                'active_role_id' => $req['active_role_id'] ?? null,

            ]);
            // $user->roles()->attach([5]);

            return response()->json([
                'success' => true,
                'data'    => $user,
                'message'     => 'User Created Successfully'
            ], 201);
        } 
        catch (Exception $e) {
            return response()->json($this->catchException($e), $this->exceptionCode($e));
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function refreshToken(Request $request)
    {
        try 
        {
            $token = Auth::user()->createToken('api auth token')->accessToken;
            $customer = Customer::where('user_id', Auth::user()->id)->first();
            $vehicle = CustomerVehicle::with('vehicle')->where('customer_id', $customer->id)->first();

            $vehicles = CustomerVehicle::with('vehicle')->where('customer_id', $customer->id)->get();

            $user = User::with('customer')->where('id', Auth::user()->id)->first();
            $user['image_path'] = $user->customer->individual->graphic != null ? 'storage/sales-customer/customers/'.$user->customer->individual->graphic->unique_name : null;
            if (is_null($vehicle)) {
                return response()->json([
                    'success'             => true,
                    'access_token'        => $token,
                    'user'                => $user,
                    'graphic'             => $user->customer->individual->graphic ?? null,
                    'is_vehicle_update'   => false
                ], 200);
            } else {
                return response()->json([
                    'success'             => true,
                    'access_token'        => $token,
                    'user'                => $user,
                    'graphic'             => $user->customer->individual->graphic ?? null,
                    'is_vehicle_update'   => true,
                    'vehicles'            => $vehicles
                ], 200);
            }
            
            
        } 
        catch (Exception $e) {
            return response()->json($this->catchException($e), $this->exceptionCode($e));
        }

        
    }
}