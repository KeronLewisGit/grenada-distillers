<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Small store for what the distillery changes without a developer: guests per tour slot
 * and the largest party that can book online.
 *
 * @property string $name
 * @property string|null $value
 */
class Setting extends Model
{
    protected $primaryKey = 'name';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['name', 'value'];

    /** @var array<string, string|null> */
    private static array $cache = [];

    public static function get(string $name, ?string $default = null): ?string
    {
        if (! array_key_exists($name, self::$cache)) {
            self::$cache[$name] = self::query()->whereKey($name)->value('value');
        }
        $value = self::$cache[$name];

        return $value === null || $value === '' ? $default : $value;
    }

    public static function put(string $name, ?string $value): void
    {
        self::query()->updateOrCreate(['name' => $name], ['value' => $value]);
        self::$cache[$name] = $value;
    }

    public static function flush(): void
    {
        self::$cache = [];
    }

    /** Guests one tour slot can take. */
    public static function tourCapacity(): int
    {
        return max(1, (int) self::get('tour_slot_capacity', (string) config('gdl.tours.slot_capacity', 20)));
    }

    /** The largest party that can book online; bigger groups are asked to get in touch. */
    public static function tourMaxParty(): int
    {
        return min(self::tourCapacity(), max(1, (int) self::get('tour_max_party', (string) config('gdl.tours.max_party', 12))));
    }
}
