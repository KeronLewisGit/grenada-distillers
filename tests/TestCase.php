<?php

namespace Tests;

use App\Enums\Role;
use App\Http\Middleware\AgeGate;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Setting::flush();
    }

    /** A visitor who has already passed the age check. */
    protected function ofAge(): static
    {
        return $this->withUnencryptedCookie(AgeGate::COOKIE, '1');
    }

    protected function staff(Role $role): User
    {
        return User::factory()->role($role)->create();
    }

    /** @return array<string, string> */
    protected function contact(array $overrides = []): array
    {
        return array_merge(['name' => 'Kezia Charles', 'phone' => '473-440-1234', 'email' => 'kezia@example.com', 'contact_pref' => 'email'], $overrides);
    }
}
