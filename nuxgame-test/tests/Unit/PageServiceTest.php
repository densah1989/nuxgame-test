<?php

namespace Tests\Unit;

use App\DTOs\PageDTO;
use App\Models\Page;
use App\Models\User;
use App\Repositories\PageRepository;
use App\Services\PageService;
use Carbon\Carbon;
use Exception;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class PageServiceTest extends TestCase
{
    private MockInterface $pageRepository;
    private PageService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->pageRepository = Mockery::mock(PageRepository::class);
        $this->service = new PageService($this->pageRepository);
    }

    private function makeUser(): User
    {
        $user = new User();
        $user->forceFill(['id' => 1, 'username' => 'john', 'phone_number' => '+1234567890']);

        return $user;
    }

    private function makePageWithUser(): MockInterface&Page
    {
        $page = Mockery::mock(Page::class)->makePartial();
        $page->forceFill(['route' => 'old-route']);
        $page->setRelation('user', $this->makeUser());

        return $page;
    }

    // ── generatePage ─────────────────────────────────────────

    public function test_generate_page_calls_repository_with_page_dto(): void
    {
        $this->pageRepository
            ->shouldReceive('create')
            ->once()
            ->with(Mockery::type(PageDTO::class))
            ->andReturn(new Page());

        $this->service->generatePage($this->makeUser());
    }

    public function test_generate_page_returns_page_instance(): void
    {
        $this->pageRepository
            ->shouldReceive('create')
            ->once()
            ->andReturn(new Page());

        $result = $this->service->generatePage($this->makeUser());

        $this->assertInstanceOf(Page::class, $result);
    }

    public function test_generate_page_sets_expiry_to_7_days(): void
    {
        $captured = null;

        $this->pageRepository
            ->shouldReceive('create')
            ->once()
            ->withArgs(function (PageDTO $dto) use (&$captured) {
                $captured = $dto;

                return true;
            })
            ->andReturn(new Page());

        $this->service->generatePage($this->makeUser());

        $this->assertEqualsWithDelta(
            now()->addDays(7)->timestamp,
            $captured->getExpiresAt()->timestamp,
            5
        );
    }

    /**
     * @throws Exception
     */
    public function test_regenerate_route_updates_page(): void
    {
        $page = $this->makePageWithUser();

        $page->shouldReceive('update')->once()->andReturn(true);

        $this->pageRepository
            ->shouldReceive('getByRoute')
            ->once()
            ->andReturn(new Page());

        $this->service->regenerateRoute($page);
    }

    /**
     * @throws Exception
     */
    public function test_regenerate_route_changes_route_value(): void
    {
        $page = $this->makePageWithUser();
        $captured = null;

        $page->shouldReceive('update')
             ->once()
             ->withArgs(function (array $data) use (&$captured) {
                 $captured = $data;

                 return true;
             })
             ->andReturn(true);

        $this->pageRepository
            ->shouldReceive('getByRoute')
            ->once()
            ->andReturn(new Page());

        $this->service->regenerateRoute($page);

        $this->assertNotEquals('old-route', $captured['route']);
        $this->assertMatchesRegularExpression('/^[a-f0-9]{32}$/', $captured['route']);
    }

    /**
     * @throws Exception
     */
    public function test_regenerate_route_returns_page(): void
    {
        $page = $this->makePageWithUser();

        $page->shouldReceive('update')->once()->andReturn(true);

        $this->pageRepository
            ->shouldReceive('getByRoute')
            ->once()
            ->andReturn(new Page());

        $result = $this->service->regenerateRoute($page);

        $this->assertInstanceOf(Page::class, $result);
    }

    /**
     * @throws Exception
     */
    public function test_deactivate_route_sets_deleted_at(): void
    {
        $page = Mockery::mock(Page::class)->makePartial();

        $page->shouldReceive('update')
             ->once()
             ->withArgs(function (array $data) {
                 return isset($data['deleted_at'])
                     && $data['deleted_at'] instanceof Carbon;
             })
             ->andReturn(true);

        $this->service->deactivateRoute($page);
    }

    /**
     * @throws Exception
     */
    public function test_deactivate_route_returns_true(): void
    {
        $page = Mockery::mock(Page::class)->makePartial();
        $page->shouldReceive('update')->once()->andReturn(true);

        $result = $this->service->deactivateRoute($page);

        $this->assertTrue($result);
    }
}
