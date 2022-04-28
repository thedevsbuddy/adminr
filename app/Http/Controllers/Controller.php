<?php

namespace App\Http\Controllers;

use Devsbuddy\AdminrEngine\Traits\CanManageFiles;
use Devsbuddy\AdminrEngine\Traits\CanSendMail;
use Devsbuddy\AdminrEngine\Traits\HasResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use CanSendMail, HasResponse, CanManageFiles;
}

