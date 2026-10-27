<?php

namespace App\Http\Controllers;

use App\Support\Rums;
use Illuminate\View\View;

class RumController extends Controller
{
    public function index(): View
    {
        return view('pages.rums.index', ['families' => Rums::byFamily()]);
    }

    public function show(string $rum): View
    {
        $product = Rums::get($rum);
        abort_if($product === null, 404);

        return view('pages.rums.show', ['key' => $rum, 'rum' => $product, 'related' => Rums::related($rum)]);
    }
}
