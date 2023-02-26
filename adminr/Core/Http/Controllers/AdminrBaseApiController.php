<?php

namespace Adminr\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\{CanManageFiles, CanSendMail, HasResponse};

class AdminrBaseApiController extends Controller
{
    use CanSendMail, HasResponse, CanManageFiles;

}
