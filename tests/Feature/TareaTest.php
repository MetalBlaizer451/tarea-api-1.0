<?php

//Set de pruebas para cada endpoint

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tarea;

class TareaTest extends TestCase
{
    use RefreshDatabase;

/** @test */
public function puede_listar_todas_las_tareas()
{
    Tarea::factory()->count(3)->create();

    $response = $this->getJson('/api/tareas');

    dump($response->json());

    $response->assertStatus(200)
             ->assertJsonCount(3, 'data', 'La propiedad "data" debería contener 3 elementos.')
             ->assertJsonStructure(['data' => [
                 '*' => ['id', 'name', 'status', 'created_at', 'updated_at'],
             ]]);

    $data = $response->json('data');
    foreach ($data as $item) {
        $response->assertJsonFragment($item);
    }
}

    /** @test */
    public function puede_crear_una_tarea()
    {
       $response = $this->postJson('/api/tareas', [
           'name' => 'Nueva Tarea',
           'status' => false,
       ]);
    
       $response->assertStatus(201)
           ->assertJson([
               'name' => 'Nueva Tarea',
               'status' => false,
           ]);
    }

    /** @test */
    public function puede_eliminar_una_tarea()
    {
       $tarea = Tarea::factory()->create();
    
       $response = $this->deleteJson("/api/tareas/{$tarea->id}");
    
       $response->assertStatus(200)
           ->assertJson(['message' => 'Tarea eliminada con éxito']);
    
       $this->assertDatabaseMissing('tareas', ['id' => $tarea->id]);
    }

    /** @test */
    public function puede_actualizar_una_tarea()
    {
        $tarea = Tarea::factory()->create();
    
        $response = $this->putJson("/api/tareas/{$tarea->id}", [
            'name' => 'Tarea Actualizada',
            'status' => true,
        ]);
    
        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $tarea->id,
                'name' => 'Tarea Actualizada',
                'status' => 1,
                'created_at' => $tarea->created_at,
                'updated_at' => $tarea->fresh()->updated_at,
            ]);
    }
}
