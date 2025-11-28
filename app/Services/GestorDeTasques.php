<?php

namespace App\Services;

use App\Models\Tasca;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

/**
 * Classe GestorDeTasques
 *
 * Gestiona una col·lecció de tasques amb funcionalitats per afegir, eliminar,
 * actualitzar i filtrar tasques per estat.
 */
class GestorDeTasques
{
    /**
     * Afegeix una nova tasca a la base de dades.
     *
     * @param string $titol
     * @param string $descripcio
     * @param string $dataLimit
     * @return Tasca
     * @throws Exception
     */
    public function afegirTasca(string $titol, string $descripcio, string $dataLimit): Tasca
    {
        try {
            return Tasca::create([
                'titol' => $titol,
                'descripcio' => $descripcio,
                'data_limit' => $dataLimit,
                'estat' => 'pendent'
            ]);
        } catch (Exception $e) {
            throw new Exception("No s'ha pogut afegir la tasca: " . $e->getMessage());
        }
    }

    /**
     * Elimina una tasca per títol.
     *
     * @param string $titol
     * @return void
     * @throws ModelNotFoundException
     */
    public function eliminarTasca(string $titol): void
    {
        $tasca = Tasca::where('titol', $titol)->first();

        if (!$tasca) {
            throw new ModelNotFoundException("Tasca amb títol '{$titol}' no trobada.");
        }

        $tasca->delete();
    }

    /**
     * Actualitza l'estat d'una tasca per títol.
     *
     * @param string $titol
     * @param string $estat
     * @return Tasca
     * @throws Exception
     */
    public function actualitzarEstatTasca(string $titol, string $estat): Tasca
    {
        $validEstats = ['pendent', 'en_curs', 'completada'];

        if (!in_array($estat, $validEstats)) {
            throw new Exception("Estat no vàlid: {$estat}");
        }

        $tasca = Tasca::where('titol', $titol)->first();

        if (!$tasca) {
            throw new ModelNotFoundException("Tasca amb títol '{$titol}' no trobada.");
        }

        $tasca->estat = $estat;
        $tasca->save();

        return $tasca;
    }

    /**
     * Retorna totes les tasques.
     *
     * @return Collection
     */
    public function llistarTasques(): Collection
    {
        return Tasca::all();
    }

    /**
     * Filtra les tasques per estat.
     *
     * @param string $estat
     * @return Collection
     * @throws Exception
     */
    public function filtrarTasquesPerEstat(string $estat): Collection
    {
        $validEstats = ['pendent', 'en_curs', 'completada'];

        if (!in_array($estat, $validEstats)) {
            throw new Exception("Estat no vàlid: {$estat}");
        }

        return Tasca::where('estat', $estat)->get();
    }
}
