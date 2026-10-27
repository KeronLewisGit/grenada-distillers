<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AgeGate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/** The age check: two buttons in a plain form, so it works without JavaScript. */
class AgeController extends Controller
{
    public function show(Request $request): View
    {
        return view('pages.age', [
            'next' => AgeGate::safeNext($request->query('next')),
            'declined' => $request->boolean('declined'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['answer' => ['required', 'in:yes,no'], 'remember' => ['nullable', 'boolean']]);
        $next = AgeGate::safeNext($request->input('next'));

        if ($data['answer'] === 'no') {
            return to_route('age.show', ['declined' => 1]);
        }

        // Remembered for 30 days on this device, or until the browser closes.
        $minutes = $request->boolean('remember') ? 60 * 24 * 30 : 0;

        return redirect($next)->withCookie(cookie(AgeGate::COOKIE, '1', $minutes, sameSite: 'lax'));
    }
}
