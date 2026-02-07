<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HealthController extends Controller
{
    /**
     * Health check endpoint for monitoring and container orchestration.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $checks = [
            'database' => $this->checkDatabase(),
            'storage' => $this->checkStorage(),
        ];

        $isHealthy = $checks['database']['status'] === 'ok' && $checks['storage']['status'] === 'ok';

        return response()->json([
            'status' => $isHealthy ? 'healthy' : 'unhealthy',
            'timestamp' => now()->toIso8601String(),
            'service' => config('app.name', 'snaptale-backend'),
            'checks' => $checks,
        ], $isHealthy ? 200 : 503);
    }

    /**
     * Simple health check - just returns OK.
     * Useful for basic container health checks.
     *
     * @return JsonResponse
     */
    public function ping(): JsonResponse
    {
        return response()->json([
            'status' => 'ok',
            'timestamp' => now()->toIso8601String(),
        ], 200);
    }

    /**
     * Check database connection.
     *
     * @return array
     */
    private function checkDatabase(): array
    {
        try {
            DB::connection()->getPdo();
            return [
                'status' => 'ok',
                'message' => 'Database connection successful',
            ];
        } catch (\Exception $e) {
            Log::error('Health check - Database connection failed', [
                'error' => $e->getMessage(),
            ]);
            
            return [
                'status' => 'error',
                'message' => 'Database connection failed',
            ];
        }
    }

    /**
     * Check if storage is writable.
     *
     * @return array
     */
    private function checkStorage(): array
    {
        $storagePath = storage_path();
        
        if (!is_writable($storagePath)) {
            return [
                'status' => 'error',
                'message' => 'Storage is not writable',
            ];
        }

        return [
            'status' => 'ok',
            'message' => 'Storage is writable',
        ];
    }
}
