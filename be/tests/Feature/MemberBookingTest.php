<?php

namespace Tests\Feature;

use App\Models\Class\ClassBooking;
use App\Models\Class\ClassModel;
use App\Models\Class\ClassSchedule;
use App\Models\Package\Package;
use App\Models\Package\PackageOption;
use App\Models\Payment\Order;
use App\Models\User;
use App\Models\UserPackage;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class MemberBookingTest extends TestCase
{
    use RefreshDatabase;

    private User $member;

    private ClassSchedule $schedule;

    private string $today;

    protected function setUp(): void
    {
        parent::setUp();

        foreach (['user', 'admin', 'super-admin', 'instruktur'] as $role) {
            Role::create(['name' => $role, 'guard_name' => 'web']);
        }
        \Illuminate\Support\Facades\Cache::put('dashboard.artofliving.courses', [], now()->addHour());

        $this->member = User::factory()->create(['avatar' => 'test.png']);
        $this->member->assignRole('user');

        $class = ClassModel::create([
            'name' => 'Morning Flow',
            'slug' => 'morning-flow',
            'level' => 'foundation',
            'is_active' => 'active',
        ]);

        $this->today = now()->format('Y-m-d');
        $day = strtolower(now()->format('l'));

        $this->schedule = ClassSchedule::create([
            'class_uuid' => $class->uuid,
            'studio_uuid' => null,
            'day' => $day,
            'date' => $this->today,
            'start_time' => now()->copy()->addHours(5)->format('H:i:s'),
            'end_time' => now()->copy()->addHours(6)->format('H:i:s'),
            'capacity' => 10,
            'status' => 'active',
        ]);

        $package = Package::create([
            'name' => 'Monthly Pass',
            'slug' => 'monthly-pass',
            'is_active' => 'active',
        ]);

        $option = PackageOption::create([
            'package_uuid' => $package->uuid,
            'name' => 'Standard',
            'quota' => 8,
            'price' => 500000,
            'discount_price' => null,
            'duration' => 1,
            'duration_unit' => 'month',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $order = Order::create([
            'user_uuid' => $this->member->uuid,
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'type' => 'package',
            'package_uuid' => $package->uuid,
            'package_option_uuid' => $option->uuid,
            'amount' => 500000,
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        UserPackage::create([
            'user_uuid' => $this->member->uuid,
            'package_uuid' => $package->uuid,
            'order_uuid' => $order->uuid,
            'quota' => 8,
            'started_at' => now(),
            'expired_at' => now()->addMonth(),
            'status' => 'active',
        ]);
    }

    private function bookPayload(ClassSchedule $schedule, string $date, bool $checkin = false): array
    {
        return array_filter([
            'class_schedule_uuid' => $schedule->uuid,
            'booking_date' => $date,
            'checkin' => $checkin ? 1 : null,
        ]);
    }

    public function test_one_tap_book_and_checkin(): void
    {
        $response = $this->actingAs($this->member)->post(
            '/backend/class-bookings',
            $this->bookPayload($this->schedule, $this->today, true)
        );

        $response->assertRedirect()->assertSessionHas('success');

        $booking = ClassBooking::where('user_uuid', $this->member->uuid)->first();
        $this->assertNotNull($booking);
        $this->assertSame('attended', $booking->status);
        $this->assertSame(7, $this->member->userPackages()->first()->quota);
    }

    public function test_double_booking_same_session_blocked(): void
    {
        $this->actingAs($this->member)->post(
            '/backend/class-bookings',
            $this->bookPayload($this->schedule, $this->today)
        )->assertSessionHas('success');

        $this->actingAs($this->member)->post(
            '/backend/class-bookings',
            $this->bookPayload($this->schedule, $this->today)
        )->assertSessionHas('error');

        $this->assertSame(1, ClassBooking::where('user_uuid', $this->member->uuid)->count());
    }

    public function test_overlapping_time_booking_blocked(): void
    {
        $other = ClassSchedule::create([
            'class_uuid' => $this->schedule->class_uuid,
            'studio_uuid' => null,
            'day' => strtolower(now()->format('l')),
            'date' => $this->today,
            'start_time' => now()->copy()->addHours(5)->addMinutes(30)->format('H:i:s'),
            'end_time' => now()->copy()->addHours(6)->addMinutes(30)->format('H:i:s'),
            'capacity' => 10,
            'status' => 'active',
        ]);

        $this->actingAs($this->member)->post(
            '/backend/class-bookings',
            $this->bookPayload($this->schedule, $this->today)
        )->assertSessionHas('success');

        $this->actingAs($this->member)->post(
            '/backend/class-bookings',
            $this->bookPayload($other, $this->today)
        )->assertSessionHas('error');
    }

    public function test_same_schedule_different_date_allowed(): void
    {
        $nextWeek = now()->addDays(7)->format('Y-m-d');

        $this->actingAs($this->member)->post(
            '/backend/class-bookings',
            $this->bookPayload($this->schedule, $this->today)
        )->assertSessionHas('success');

        $this->actingAs($this->member)->post(
            '/backend/class-bookings',
            $this->bookPayload($this->schedule, $nextWeek)
        )->assertSessionHas('success');

        $this->assertSame(2, ClassBooking::where('user_uuid', $this->member->uuid)->count());
    }

    public function test_cancel_blocked_within_two_hours(): void
    {
        $soon = ClassSchedule::create([
            'class_uuid' => $this->schedule->class_uuid,
            'studio_uuid' => null,
            'day' => strtolower(now()->format('l')),
            'date' => $this->today,
            'start_time' => now()->copy()->addHour()->format('H:i:s'),
            'end_time' => now()->copy()->addHours(2)->format('H:i:s'),
            'capacity' => 10,
            'status' => 'active',
        ]);

        $this->actingAs($this->member)->post(
            '/backend/class-bookings',
            $this->bookPayload($soon, $this->today)
        )->assertSessionHas('success');

        $booking = ClassBooking::where('user_uuid', $this->member->uuid)->first();

        $this->actingAs($this->member)->post("/backend/class-bookings/{$booking->uuid}/cancel")
            ->assertSessionHas('error');

        $this->assertSame('confirmed', $booking->fresh()->status);
    }

    public function test_member_can_rate_attended_class(): void
    {
        $booking = ClassBooking::create([
            'user_uuid' => $this->member->uuid,
            'class_schedule_uuid' => $this->schedule->uuid,
            'booking_date' => $this->today,
            'booking_type' => 'package',
            'quota_used' => 1,
            'status' => 'attended',
            'booked_at' => now()->subDay(),
            'attended_at' => now()->subDay(),
        ]);

        $this->actingAs($this->member)->post("/backend/class-bookings/{$booking->uuid}/rate", [
            'rating' => 5,
            'rating_comment' => 'Great class!',
        ])->assertSessionHas('success');

        $this->assertSame(5, (int) $booking->fresh()->rating);
    }

    public function test_reorder_expired_order_creates_pending(): void
    {
        $option = PackageOption::first();

        $expired = Order::create([
            'user_uuid' => $this->member->uuid,
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'type' => 'package',
            'package_uuid' => $option->package_uuid,
            'package_option_uuid' => $option->uuid,
            'amount' => 500000,
            'status' => 'expired',
            'expired_at' => now()->subHour(),
        ]);

        $response = $this->actingAs($this->member)->post("/backend/orders/{$expired->uuid}/reorder");

        $response->assertRedirect();
        $this->assertTrue(
            Order::where('user_uuid', $this->member->uuid)->where('status', 'pending')->exists()
        );
    }

    public function test_scan_lookup_forbidden_for_member(): void
    {
        $this->actingAs($this->member())
            ->get('/backend/class-bookings/lookup?uuid=' . (string) Str::uuid())
            ->assertForbidden();
    }

    public function test_bookings_page_is_desktop_on_laptop(): void
    {
        $this->actingAs($this->member())
            ->withHeader('User-Agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0')
            ->get('/backend/my-bookings')
            ->assertOk()
            ->assertViewIs('pages.bookings.index');
    }

    public function test_bookings_page_is_mobile_on_phone(): void
    {
        $this->actingAs($this->member())
            ->withHeader('User-Agent', 'Mozilla/5.0 (Linux; Android 13) Mobile')
            ->get('/backend/my-bookings')
            ->assertOk()
            ->assertViewIs('pages.mobile.bookings');
    }

    public function test_schedules_page_is_desktop_on_laptop(): void
    {
        $this->actingAs($this->member())
            ->withHeader('User-Agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0')
            ->get('/backend/schedules')
            ->assertOk()
            ->assertViewIs('pages.schedules.index');
    }

    private function member(): User
    {
        return $this->member;
    }
}
