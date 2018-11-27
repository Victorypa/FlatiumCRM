<?php

namespace App\Http\Controllers\Api\Works;

use Cache;
use App\Models\Work\Work;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WorkController extends Controller
{
    public function index()
    {
        $works = Cache::rememberForever('works', function () {
            return Work::orderBy('name', 'asc')->get();
        });

        return response()->json($works);
    }
}
