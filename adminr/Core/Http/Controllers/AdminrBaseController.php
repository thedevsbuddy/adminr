<?php

namespace Adminr\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\{CanManageFiles, HasMetaHead, CanSendMail, HasResponse};

class AdminrBaseController extends Controller
{
    use CanSendMail, HasResponse, CanManageFiles, HasMetaHead;

}
