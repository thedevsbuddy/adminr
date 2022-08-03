<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VerificationToken;
use App\Traits\{CanManageFiles, HasMetaHead, CanSendMail, HasResponse};
use Illuminate\Foundation\{Auth\Access\AuthorizesRequests, Bus\DispatchesJobs, Validation\ValidatesRequests};
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use CanSendMail, HasResponse, CanManageFiles, HasMetaHead;

    protected function generateTokenForUser(User $user)
    {
        $token = Str::random(64);
        $vt = $user->verificationToken()->first();

        if(!is_null($vt)){
            $vt->delete();
        }

        return VerificationToken::create([
            "user_id" => $user->id,
            "token" => $token,
        ]);
    }

    protected function generateOtpForUser(User $user): int
    {
        $otp = rand(100000, 999999);

        $user->update([
            "otp" => $otp
        ]);

        return $otp;
    }
}

