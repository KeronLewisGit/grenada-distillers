<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings', [
            'capacity' => Setting::tourCapacity(),
            'maxParty' => Setting::tourMaxParty(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'tour_slot_capacity' => ['required', 'integer', 'min:1', 'max:500'],
            'tour_max_party' => ['required', 'integer', 'min:1', 'lte:tour_slot_capacity'],
        ], ['tour_max_party.lte' => 'The largest online party can\'t be bigger than a whole tour.'], [
            'tour_slot_capacity' => 'guests per tour', 'tour_max_party' => 'largest online party',
        ]);

        Setting::put('tour_slot_capacity', (string) $data['tour_slot_capacity']);
        Setting::put('tour_max_party', (string) $data['tour_max_party']);

        return back()->with('status', 'Settings saved.');
    }
}
