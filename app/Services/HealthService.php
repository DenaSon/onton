<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;

class HealthService
{
    public static function database(): array
    {
        try {
            DB::connection()->getPdo();
            return ['status' => true, 'message' => 'Connected'];
        } catch (\Throwable $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    public static function disk(): array
    {
        $total = disk_total_space('/');
        $free = disk_free_space('/');

        return [
            'status' => true,
            'total' => formatBytes($total),
            'free' => formatBytes($free),
            'used_percent' => round(100 - ($free / $total * 100), 2) . '%',
        ];
    }

    public static function cache(): array
    {
        try {
            Cache::put('health_test', 'ok', 10);
            return [
                'status' => Cache::get('health_test') === 'ok',
                'message' => 'Cache is working'
            ];
        } catch (\Throwable $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    public static function laravel(): array
    {
        return [
            'version' => app()->version()
        ];
    }

    public static function php(): array
    {
        return [
            'version' => PHP_VERSION
        ];
    }

    public static function mail(): array
    {
        return [
            'driver' => config('mail.default'),
            'host' => config('mail.mailers.smtp.host'),
            'port' => config('mail.mailers.smtp.port'),
        ];
    }

    public static function queue(): array
    {
        try {
            $connection = config('queue.default');

            $pending = DB::table('jobs')->count();

            return [
                'status' => 'Running',
                'connection' => $connection,
                'pending_jobs' => $pending
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 'Down',
                'error' => $e->getMessage()
            ];
        }
    }

    public static function all(): array
    {
        return [
            'laravel' => self::laravel(),
            'php' => self::php(),
            'database' => self::database(),
            'disk' => self::disk(),
            'cache' => self::cache(),
            'mail' => self::mail(),
            'queue' => self::queue(),
        ];
    }
}
