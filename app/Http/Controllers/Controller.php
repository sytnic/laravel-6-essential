<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    // Трэйты обходят проблему множественного наследования в php:
    // DispatchesJobs определяют очереди,
    // AuthorizesRequests и ValidatesRequests проверяют запросы на авторизацию и фильтруют запросы
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
