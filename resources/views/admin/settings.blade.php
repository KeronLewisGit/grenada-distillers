<x-layouts.admin title="Settings">
    <form method="POST" action="{{ route('admin.settings.update') }}" class="max-w-2xl space-y-6">
        @csrf @method('PUT')
        <section class="a-card space-y-4 p-5">
            <h2 class="font-semibold">Distillery tours</h2>
            <p class="text-sm text-ink-2">How many guests one tour takes, and the largest party that can book online. Tours that reach capacity show as full on the website; bigger groups are asked to send an enquiry instead.</p>
            <div class="grid gap-4 sm:grid-cols-2">
                <div><label for="cap" class="mb-1 block text-sm font-semibold">Guests per tour</label>
                    <input id="cap" name="tour_slot_capacity" type="number" min="1" max="500" value="{{ old_string('tour_slot_capacity', $capacity) }}" class="a-input w-full" required></div>
                <div><label for="party" class="mb-1 block text-sm font-semibold">Largest online party</label>
                    <input id="party" name="tour_max_party" type="number" min="1" max="500" value="{{ old_string('tour_max_party', $maxParty) }}" class="a-input w-full" required></div>
            </div>
            <p class="text-xs text-ink-3">Tour days and times are set in <code>config/gdl.php</code> (tours.slots), with public holidays in <code>closed_dates</code>.</p>
        </section>
        <button class="a-btn a-btn-primary">Save settings</button>
    </form>
</x-layouts.admin>
