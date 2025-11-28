<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Gestor de Tasques</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-6">Gestor de Tasques</h1>

        {{-- Formulari per filtrar per estat --}}
        <form action="{{ route('tasques.index') }}" method="GET" class="mb-6 flex items-center gap-2">
            <label for="estat" class="font-semibold">Filtra per estat:</label>
            <select name="estat" id="estat" class="p-2 border rounded">
                <option value="" {{ request('estat') == '' ? 'selected' : '' }}>-- Tots --</option>
                <option value="pendent" {{ request('estat') == 'pendent' ? 'selected' : '' }}>Pendent</option>
                <option value="en_curs" {{ request('estat') == 'en_curs' ? 'selected' : '' }}>En curs</option>
                <option value="completada" {{ request('estat') == 'completada' ? 'selected' : '' }}>Completada</option>
            </select>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filtrar</button>
        </form>

        {{-- Formulari per afegir nova tasca --}}
        <form action="{{ route('tasques.store') }}" method="POST" class="bg-white p-4 rounded shadow mb-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="text" name="titol" placeholder="Títol" required class="p-2 border rounded" value="{{ old('titol') }}">
                <input type="text" name="descripcio" placeholder="Descripció" required class="p-2 border rounded" value="{{ old('descripcio') }}">
                <input type="date" name="data_limit" required class="p-2 border rounded" value="{{ old('data_limit') }}">
            </div>
            <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Afegir Tasca</button>
        </form>

        {{-- Missatges d'error --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (isset($tasques) && count($tasques) > 0)
            <table class="min-w-full table-auto bg-white rounded shadow">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">Títol</th>
                        <th class="px-4 py-2">Descripció</th>
                        <th class="px-4 py-2">Data Límit</th>
                        <th class="px-4 py-2">Estat</th>
                        <th class="px-4 py-2">Accions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasques as $tasca)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $tasca->titol }}</td>
                            <td class="px-4 py-2">{{ $tasca->descripcio }}</td>
                            <td class="px-4 py-2">{{ $tasca->data_limit }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded text-white
                                    @if($tasca->estat == 'pendent') bg-red-500
                                    @elseif($tasca->estat == 'en_curs') bg-yellow-500
                                    @else bg-green-500 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $tasca->estat)) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                {{-- Formulari per eliminar tasca --}}
                                <form action="{{ route('tasques.destroy', $tasca->titol) }}" method="POST" onsubmit="return confirm('Segur que vols eliminar-la?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">🗑️</button>
                                </form>

                                {{-- Formulari per actualitzar estat (exemple simplificat) --}}
                                <form action="{{ route('tasques.update', $tasca->titol) }}" method="POST" class="inline-block ml-2">
                                    @csrf
                                    @method('PUT')
                                    <select name="estat" onchange="this.form.submit()" class="p-1 border rounded text-sm">
                                        <option value="pendent" {{ $tasca->estat == 'pendent' ? 'selected' : '' }}>Pendent</option>
                                        <option value="en_curs" {{ $tasca->estat == 'en_curs' ? 'selected' : '' }}>En curs</option>
                                        <option value="completada" {{ $tasca->estat == 'completada' ? 'selected' : '' }}>Completada</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center text-gray-600">No hi ha tasques disponibles.</p>
        @endif
    </div>

</body>
</html>
