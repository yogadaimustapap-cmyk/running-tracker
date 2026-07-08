<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WorkoutLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorkoutLogCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test guests are redirected to login.
     */
    public function test_guests_cannot_access_workout_logs(): void
    {
        $this->get('/workout-logs')->assertRedirect('/login');
        $this->get('/workout-logs/create')->assertRedirect('/login');
        $this->post('/workout-logs', [])->assertRedirect('/login');
        $this->get('/workout-logs/1/edit')->assertRedirect('/login');
        $this->put('/workout-logs/1', [])->assertRedirect('/login');
        $this->delete('/workout-logs/1')->assertRedirect('/login');
    }

    /**
     * Test authenticated user can view their empty workout logs list.
     */
    public function test_user_can_view_empty_workout_logs_list(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/workout-logs');

        $response->assertStatus(200);
        $response->assertSee('Aktivitas Olahraga');
        $response->assertSee('Belum ada aktivitas olahraga yang dicatat.');
    }

    /**
     * Test user can store a valid workout log.
     */
    public function test_user_can_create_workout_log(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/workout-logs', [
            'workout_date' => '2026-07-08',
            'workout_type' => 'Lari',
            'duration' => 30,
            'distance' => 5.5,
            'notes' => 'Lari sore santai',
        ]);

        $response->assertRedirect('/workout-logs');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('workout_logs', [
            'user_id' => $user->id,
            'workout_date' => '2026-07-08',
            'workout_type' => 'Lari',
            'duration' => 30,
            'distance' => 5.50,
            'notes' => 'Lari sore santai',
        ]);
    }

    /**
     * Test validation during creation.
     */
    public function test_create_workout_log_validation_fails(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/workout-logs', [
            'workout_date' => '',
            'workout_type' => 'invalid-type',
            'duration' => -10,
            'distance' => 0,
        ]);

        $response->assertSessionHasErrors(['workout_date', 'workout_type', 'duration', 'distance']);
        $this->assertEquals(0, WorkoutLog::count());
    }

    /**
     * Test user can update their workout log.
     */
    public function test_user_can_update_their_workout_log(): void
    {
        $user = User::factory()->create();
        $log = WorkoutLog::factory()->create([
            'user_id' => $user->id,
            'workout_date' => '2026-07-01',
            'workout_type' => 'Bersepeda',
            'duration' => 60,
            'distance' => 15.0,
            'notes' => 'Endurance ride',
        ]);

        $response = $this->actingAs($user)->put("/workout-logs/{$log->id}", [
            'workout_date' => '2026-07-02',
            'workout_type' => 'Lari',
            'duration' => 45,
            'distance' => 8.2,
            'notes' => 'Pace run',
        ]);

        $response->assertRedirect('/workout-logs');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('workout_logs', [
            'id' => $log->id,
            'workout_date' => '2026-07-02',
            'workout_type' => 'Lari',
            'duration' => 45,
            'distance' => 8.20,
            'notes' => 'Pace run',
        ]);
    }

    /**
     * Test user can delete their workout log.
     */
    public function test_user_can_delete_their_workout_log(): void
    {
        $user = User::factory()->create();
        $log = WorkoutLog::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete("/workout-logs/{$log->id}");

        $response->assertRedirect('/workout-logs');
        $this->assertDatabaseMissing('workout_logs', ['id' => $log->id]);
    }

    /**
     * Test user isolation: cannot modify other user's log.
     */
    public function test_user_cannot_modify_other_users_workout_log(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $logB = WorkoutLog::factory()->create(['user_id' => $userB->id]);

        // Attempt edit B from user A
        $this->actingAs($userA)->get("/workout-logs/{$logB->id}/edit")->assertStatus(404);

        // Attempt update B from user A
        $this->actingAs($userA)->put("/workout-logs/{$logB->id}", [
            'workout_date' => '2026-07-08',
            'workout_type' => 'Lari',
            'duration' => 30,
            'distance' => 5.0,
        ])->assertStatus(404);

        // Attempt delete B from user A
        $this->actingAs($userA)->delete("/workout-logs/{$logB->id}")->assertStatus(404);

        // Verify log is untouched
        $this->assertDatabaseHas('workout_logs', ['id' => $logB->id]);
    }
}
