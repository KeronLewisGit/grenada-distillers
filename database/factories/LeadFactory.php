<?php

namespace Database\Factories;

use App\Enums\LeadStatus;
use App\Enums\LeadType;
use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Lead> */
class LeadFactory extends Factory
{
    public function definition(): array
    {
        return [
            'type' => LeadType::Enquiry,
            'status' => LeadStatus::New,
            'name' => fake()->name(),
            'phone' => '473-'.fake()->numberBetween(403, 449).'-'.fake()->numerify('####'),
            'email' => fake()->unique()->safeEmail(),
            'contact_pref' => 'email',
            'message' => fake()->sentence(),
            'details' => ['topic' => 'general'],
        ];
    }

    public function type(LeadType $type): static
    {
        return $this->state(fn () => ['type' => $type, 'details' => []]);
    }

    public function tour(string $date, string $time, int $guests = 2): static
    {
        return $this->state(fn () => [
            'type' => LeadType::Tour, 'visit_date' => $date, 'visit_time' => $time, 'guests' => $guests,
            'details' => ['adults' => $guests, 'children' => 0, 'group_type' => 'family'],
        ]);
    }

    public function trade(string $organisation = 'Harbour Wines Ltd', string $country = 'United Kingdom'): static
    {
        return $this->state(fn () => [
            'type' => LeadType::Trade, 'organisation' => $organisation, 'country' => $country,
            'details' => ['business_type' => 'importer', 'volume' => 'pallet', 'licensed' => 'yes', 'products' => []],
        ]);
    }

    public function application(): static
    {
        return $this->state(fn () => [
            'type' => LeadType::Application, 'country' => 'Grenada',
            'details' => ['parish' => 'st_george', 'experience' => '3_5', 'qualification' => 'cxc'],
        ]);
    }
}
