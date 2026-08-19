<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'group',
        'key',
        'value',
        'type',
    ];

    /**
     * Ambil satu nilai setting via "group.key", contoh: Setting::get('contact.phone').
     */
    public static function get(string $groupDotKey, mixed $default = null): mixed
    {
        [$group, $key] = explode('.', $groupDotKey, 2);

        $value = static::group($group)[$key] ?? null;

        return $value ?? $default;
    }

    /**
     * Ambil seluruh setting dalam satu grup sebagai array key => value (di-cache).
     *
     * @return array<string, mixed>
     */
    public static function group(string $group): array
    {
        return Cache::rememberForever("settings.{$group}", function () use ($group) {
            return static::query()
                ->where('group', $group)
                ->get()
                ->mapWithKeys(function (self $setting) {
                    $value = $setting->value;

                    if ($setting->type === 'boolean') {
                        $value = (bool) $value;
                    }

                    return [$setting->key => $value];
                })
                ->all();
        });
    }

    /**
     * Set satu nilai setting (dibuat otomatis jika belum ada) dan bersihkan cache grupnya.
     */
    public static function set(string $group, string $key, mixed $value, string $type = 'text'): void
    {
        static::query()->updateOrCreate(
            ['group' => $group, 'key' => $key],
            ['value' => is_bool($value) ? (int) $value : $value, 'type' => $type],
        );

        Cache::forget("settings.{$group}");
    }

    protected static function booted(): void
    {
        static::saved(fn (self $setting) => Cache::forget("settings.{$setting->group}"));
        static::deleted(fn (self $setting) => Cache::forget("settings.{$setting->group}"));
    }
}
