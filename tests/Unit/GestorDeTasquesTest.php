<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Tasca;
use App\Services\GestorDeTasques;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GestorDeTasquesTest extends TestCase
{
    use RefreshDatabase;

    protected GestorDeTasques $gestor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->gestor = new GestorDeTasques();
    }

    public function testAfegirTasca()
    {
        $tasca = $this->gestor->afegirTasca('Test', 'Desc', now()->addDay());

        $this->assertDatabaseHas('tasques', ['titol' => 'Test']);
    }

    public function testEliminarTasca()
    {
        $this->gestor->afegirTasca('Prova', 'Eliminar', now()->addDay());
        $this->gestor->eliminarTasca('Prova');

        $this->assertDatabaseMissing('tasques', ['titol' => 'Prova']);
    }

    public function testActualitzarEstatTasca()
    {
        $this->gestor->afegirTasca('Estat', 'Update', now()->addDay());
        $tasca = $this->gestor->actualitzarEstatTasca('Estat', 'en_curs');

        $this->assertEquals('en_curs', $tasca->estat);
    }

    public function testFiltrarTasquesPerEstat()
    {
        $this->gestor->afegirTasca('T1', 'Desc1', now()->addDay());
        $this->gestor->afegirTasca('T2', 'Desc2', now()->addDay());
        $this->gestor->actualitzarEstatTasca('T2', 'completada');

        $tasques = $this->gestor->filtrarTasquesPerEstat('completada');

        $this->assertCount(1, $tasques);
        $this->assertEquals('T2', $tasques->first()->titol);
    }
}
