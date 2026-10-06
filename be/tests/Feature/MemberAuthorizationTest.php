<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class MemberAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::create(['name' => 'user', 'guard_name' => 'web']);
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        Role::create(['name' => 'super-admin', 'guard_name' => 'web']);
        Role::create(['name' => 'instruktur', 'guard_name' => 'web']);

        // Jangan panggil API Art of Living saat test dashboard.
        Cache::put('dashboard.artofliving.courses', [], now()->addHour());
    }

    private function member(): User
    {
        $user = User::factory()->create(['avatar' => 'test.png']);
        $user->assignRole('user');

        return $user;
    }

    private function admin(): User
    {
        $user = User::factory()->create(['avatar' => 'test.png']);
        $user->assignRole('admin');

        return $user;
    }

    public function test_member_cannot_open_admin_user_list(): void
    {
        $this->actingAs($this->member())
            ->get('/backend/pengguna')
            ->assertNotFound();
    }

    public function test_member_cannot_open_admin_articles(): void
    {
        $this->actingAs($this->member())
            ->get('/backend/articles')
            ->assertNotFound();
    }

    public function test_member_cannot_store_event(): void
    {
        $this->actingAs($this->member())
            ->post('/backend/events', ['judul' => 'XSS Event'])
            ->assertNotFound();
    }

    public function test_member_cannot_use_global_search(): void
    {
        $this->actingAs($this->member())
            ->get('/backend/search?q=user')
            ->assertNotFound();
    }

    public function test_member_cannot_open_contact_messages(): void
    {
        $this->actingAs($this->member())
            ->get('/backend/kontak')
            ->assertNotFound();
    }

    public function test_admin_can_use_global_search(): void
    {
        $this->actingAs($this->admin())
            ->get('/backend/search?q=test')
            ->assertOk();
    }

    public function test_member_dashboard_is_mobile_on_phone(): void
    {
        $this->actingAs($this->member())
            ->withHeader('User-Agent', 'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 Mobile Safari/537.36')
            ->get('/backend/dashboard')
            ->assertOk()
            ->assertViewIs('pages.mobile.home');
    }

    public function test_member_dashboard_is_desktop_on_laptop(): void
    {
        $this->actingAs($this->member())
            ->withHeader('User-Agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/120.0 Safari/537.36')
            ->get('/backend/dashboard')
            ->assertOk()
            ->assertViewIs('pages.dashboard.index');
    }

    public function test_member_own_orders_are_accessible(): void
    {
        $this->actingAs($this->member())
            ->withHeader('User-Agent', 'Mozilla/5.0 (Linux; Android 13) Mobile')
            ->get('/backend/orders')
            ->assertOk()
            ->assertViewIs('pages.mobile.orders');
    }
}
