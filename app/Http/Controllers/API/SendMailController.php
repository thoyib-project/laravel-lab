<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\throwException;

class SendMailController extends Controller
{
    public function sendOTP(Request $req) {
        try {
            // validate request
            $validator  = Validator::make($req->all(), [
                'email' => 'required',
            ]);
            if ($validator ->fails()) {
                $response['result'] = false;
                $response['message'] = $validator ->messages();
                return  response()->json($response);
            }
            $validatedaReq = $validator->validated();

            // get user by id
            $data = User::where('email',$validatedaReq['email'])->first();

            // set OTP on Redis
            $data->OTP = mt_rand(0000,9999);
            $redisName = $data->email."-OTP";
            Redis::set($redisName, $data->OTP, "EX", 10*60);
            // send OTP email
            $response = [
                "status" => 200,
                "data" => $data
            ];
            return response()->json($response);
        } catch (Exception $e) {
            return response("There was a problem in send OTP, please contact us if the problem persists.", 400);
        }
    }

    public function verificationOTP(Request $req) {
        try {
            // validate request
            $validator  = Validator::make($req->all(), [
                'email' => 'required',
                'otp' => 'required|digits:4|numeric',
            ]);
            if ($validator ->fails()) {
                $response['result'] = false;
                $response['message'] = $validator ->messages();
                return  response()->json($response);
            }
            $validatedaReq = $validator->validated();
            // get user by id
            $data = User::where('email',$validatedaReq['email'])->first();
            // find OTP on Redis
            $otp = Redis::get($data->email."-OTP");
            // validate OTP send with OTP on Redis
            if($otp !== $validatedaReq['otp']){
                throw new Exception("OTP not match", 1);
            }
            $response = [
                "status" => 200,
                "data" => $data
            ];
            return response()->json($response);
        } catch (Exception $e) {
            // dd($e->getMessage());
            $response = [
                // "status" => 400,
                "message" => $e->getMessage()
            ];
            return response()->json($response);
        }
    }
}
