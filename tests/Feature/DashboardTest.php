<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Sale;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_dashboard_with_optimized_statistics(): void
    {
        // Create an admin user
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        // Create some sales for testing statistics
        Sale::create([
            'user_id' => $admin->id,
            'product_id' => 1,
            'description' => 'Test item',
            'quantity' => 2,
            'total' => 500,
            'store_session_id' => 1,
        ]);

        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertOk();
        $response->assertViewIs('admin.home.dashboard');
        $response->assertViewHasAll([
            'dailyEarnings',
            'monthlyEarnings',
            'annualEarnings',
            'yearlyData',
            'yearlyLabels',
            'totalUsers',
        ]);
    }
}
