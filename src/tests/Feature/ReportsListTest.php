<?php

namespace Tests\Feature;

 use App\Models\Report;
 use App\Models\User;
 use App\Services\Reports\ReportGenerators\ReportGenerator;
 use GuzzleHttp\Psr7\Utils;
 use Illuminate\Foundation\Testing\RefreshDatabase;
 use Tests\TestCase;

 class ReportsListTest extends TestCase
{
    use RefreshDatabase;

    public function testList(): void
    {
        Report::factory()->count(10)->create();

        $user = User::factory()->create([
            'email' => 'test@test.dev'
        ]);

        $response = $this->get('/api/reports', [
            'Authorization' => 'Bearer ' . $user->createToken('test')->plainTextToken,
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => ['*' => ['id', 'status', 'query', 'downloadUrl', 'createdAt', 'updatedAt']],
            'meta' => ['prev_cursor', 'next_cursor']
        ]);

        $this->assertCount(10, $response->json('data'));
    }

    public function testCreate(): void
    {
        $user = User::factory()->create([
            'email' => 'test@test.dev'
        ]);

        $reportGenerator = $this->createMock(ReportGenerator::class);
        $reportGenerator->method('generate')
            ->willReturn(Utils::streamFor('test'));

        $this->app->bind(ReportGenerator::class, fn() => $reportGenerator);

        $response = $this->post('/api/reports', [
            'from_date' => '2023-01-01',
            'to_date' => '2023-03-03',
            'param_a' => 'test',
            'param_b' => 99,
        ],[
            'Authorization' => 'Bearer ' . $user->createToken('test')->plainTextToken,
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => ['id', 'status', 'query', 'downloadUrl', 'createdAt', 'updatedAt']
        ]);

        $this->assertDatabaseHas('reports', ['id' => $response->json('data.id')]);
    }
}
