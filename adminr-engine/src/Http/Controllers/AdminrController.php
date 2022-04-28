<?php

namespace Devsbuddy\AdminrEngine\Http\Controllers;

use App\Http\Controllers\Controller;
use Devsbuddy\AdminrEngine\Traits\CanManageFiles;
use Devsbuddy\AdminrEngine\Traits\CanSendMail;
use Devsbuddy\AdminrEngine\Traits\HasResponse;

class AdminrController extends Controller
{
    use CanManageFiles, HasResponse, CanSendMail;
}
