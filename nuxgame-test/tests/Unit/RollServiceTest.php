<?php

namespace Tests\Unit;

use App\Repositories\RollRepository;
use App\Services\RollService;
use Mockery;
use Tests\TestCase;

class RollServiceTest extends TestCase
{
    private RollService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new RollService(
            Mockery::mock(RollRepository::class)
        );
    }

    public function test_even_number_is_win(): void
    {
        $this->assertTrue($this->service->isWin(2));
        $this->assertTrue($this->service->isWin(100));
        $this->assertTrue($this->service->isWin(1000));
    }

    public function test_odd_number_is_lose(): void
    {
        $this->assertFalse($this->service->isWin(1));
        $this->assertFalse($this->service->isWin(99));
        $this->assertFalse($this->service->isWin(999));
    }

    public function test_odd_number_returns_zero_prize(): void
    {
        $this->assertSame(0.0, $this->service->calculatePrize(1));
        $this->assertSame(0.0, $this->service->calculatePrize(901));
        $this->assertSame(0.0, $this->service->calculatePrize(999));
    }

    public function test_prize_is_70_percent_when_number_above_900(): void
    {
        $this->assertSame(700.0, $this->service->calculatePrize(1000)); // 1000 * 0.7
        $this->assertSame(631.4, $this->service->calculatePrize(902));  // 902 * 0.7 = 631.4
    }

    public function test_boundary_900_is_not_in_70_percent_tier(): void
    {
        $this->assertSame(450.0, $this->service->calculatePrize(900)); // 900 * 0.5
    }

    public function test_prize_is_50_percent_when_number_above_600(): void
    {
        $this->assertSame(450.0, $this->service->calculatePrize(900)); // 900 * 0.5
        $this->assertSame(302.0, $this->service->calculatePrize(604)); // 604 * 0.5 = 302
    }

    public function test_boundary_600_is_not_in_50_percent_tier(): void
    {
        $this->assertSame(180.0, $this->service->calculatePrize(600)); // 600 * 0.3
    }

    public function test_prize_is_30_percent_when_number_above_300(): void
    {
        $this->assertSame(180.0, $this->service->calculatePrize(600)); // 600 * 0.3
        $this->assertSame(150.0, $this->service->calculatePrize(500)); // 500 * 0.3
        $this->assertSame(90.6, $this->service->calculatePrize(302)); // 302 * 0.3 = 90.6
    }

    public function test_boundary_300_is_not_in_30_percent_tier(): void
    {
        $this->assertSame(30.0, $this->service->calculatePrize(300)); // 300 * 0.1
    }

    public function test_prize_is_10_percent_when_number_300_or_below(): void
    {
        $this->assertSame(30.0, $this->service->calculatePrize(300)); // 300 * 0.1
        $this->assertSame(20.0, $this->service->calculatePrize(200)); // 200 * 0.1
        $this->assertSame(0.2, $this->service->calculatePrize(2));   // 2 * 0.1 = 0.2
    }
}
