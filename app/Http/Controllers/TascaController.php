<?php

namespace App\Http\Controllers;

use App\Models\Tasca;
use Illuminate\Http\Request;

class TascaController extends Controller
{
    /**
     * Mostra la vista principal amb totes les tasques.
     */
    public function mostrarWelcome(Request $request)
    {
        $estat = $request->query('estat');

        if ($estat && in_array($estat, ['pendent', 'en_curs', 'completada'])) {
            $tasques = Tasca::where('estat', $estat)->get();
        } else {
            $tasques = Tasca::all();
        }

        return view('welcome', compact('tasques'));
    }

    /**
     * Guarda una nova tasca (per a futures funcionalitats POST).
     */
    public function store(Request $request)
    {
        $request->validate([
            'titol' => 'required|unique:tasques',
            'descripcio' => 'required',
            'data_limit' => 'required|date',
        ]);

        Tasca::create([
            'titol' => $request->titol,
            'descripcio' => $request->descripcio,
            'data_limit' => $request->data_limit,
            'estat' => 'pendent'
        ]);

        return redirect('/')->with('success', 'Tasca creada correctament!');
    }

    /**
     * Actualitza l'estat d'una tasca.
     */
    public function update(Request $request, $titol)
    {
        $tasca = Tasca::where('titol', $titol)->firstOrFail();

        $request->validate([
            'estat' => 'required|in:pendent,en_curs,completada',
        ]);

        $tasca->estat = $request->estat;
        $tasca->save();

        return redirect('/')->with('success', 'Estat actualitzat correctament!');
    }

    /**
     * Elimina una tasca pel títol.
     */
    public function destroy($titol)
    {
        $tasca = Tasca::where('titol', $titol)->firstOrFail();
        $tasca->delete();

        return redirect('/')->with('success', 'Tasca eliminada correctament!');
    }
}
