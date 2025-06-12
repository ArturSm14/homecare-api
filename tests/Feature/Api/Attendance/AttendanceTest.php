<?php

namespace Tests\Feature\Api\Attendance;

use App\Enums\AttendanceStatus;
use App\Models\Attendance\Attendance;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_pode_criar_um_atendimento(): void
    {
        $data = [
            'name' => 'Paciente Teste',
            'phone' => '(11) 99999-9999',
            'address' => 'Rua de Teste, 123',
            'symptoms' => 'Sintomas de teste',
        ];

        $response = $this->postJson('/api/attendances', $data);

        $response->assertCreated();
        $this->assertDatabaseHas('attendances', [
            'name' => 'Paciente Teste',
            'phone' => '(11) 99999-9999',
            'address' => 'Rua de Teste, 123',
            'symptoms' => 'Sintomas de teste',
        ]);
    }

    public function test_pode_listar_atendimentos(): void
    {
        Attendance::factory()->count(3)->create();

        $response = $this->getJson('/api/attendances');

        $response->assertOk();
        $response->assertJsonCount(3, 'data');
    }

    public function test_pode_visualizar_um_atendimento_especifico(): void
    {
        $attendance = Attendance::factory()->create();

        $response = $this->getJson("/api/attendances/{$attendance->id}");

        $response->assertOk();
        $response->assertJsonPath('response.id', $attendance->id);
    }

    public function test_pode_atualizar_um_atendimento(): void
    {
        $attendance = Attendance::factory()->create();

        $data = [
            'name' => 'Paciente Atualizado',
            'status' => AttendanceStatus::IN_PROGRESS->value,
        ];

        $response = $this->putJson("/api/attendances/{$attendance->id}", $data);

        $response->assertOk();
        $this->assertDatabaseHas('attendances', [
            'id' => $attendance->id,
            'name' => 'Paciente Atualizado',
            'status' => AttendanceStatus::IN_PROGRESS->value,
        ]);
    }

    public function test_pode_excluir_um_atendimento(): void
    {
        $attendance = Attendance::factory()->create();

        $response = $this->deleteJson("/api/attendances/{$attendance->id}");

        $response->assertOk();
        $this->assertSoftDeleted('attendances', [
            'id' => $attendance->id,
        ]);
    }
}