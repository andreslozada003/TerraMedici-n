<x-layouts.admin>
    @php($label = ['service' => 'Servicios', 'project' => 'Proyectos', 'post' => 'Noticias'][$type])
    @php($resource = $type === 'service' ? 'services' : ($type === 'project' ? 'projects' : 'posts'))

    <div style="display:flex;justify-content:space-between;align-items:center">
        <h1>{{ $archived ?? false ? 'Archivados: ' : '' }}{{ $label }}</h1>
        @unless($archived ?? false)
            <a class="btn" href="{{ route('admin.'.$resource.'.create') }}">+ Crear nuevo</a>
        @endunless
    </div>

    <div class="card">
        <form>
            <input class="input" style="max-width:300px" name="q" value="{{ request('q') }}" placeholder="Buscar por título">
        </form>
        <table>
            <tr><th>Título</th><th>Estado</th><th>Fecha</th><th></th></tr>
            @forelse($items as $item)
                <tr>
                    <td><strong>{{ $item->title }}</strong><br><small>{{ $item->category }}</small></td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                    <td>
                        @unless($archived ?? false)
                            <a href="{{ route('admin.'.$resource.'.edit', $item) }}">Editar</a>
                            <form style="display:inline" method="post" action="{{ route('admin.'.$resource.'.destroy', $item) }}"
                                  data-confirm="El elemento se archivará y podrás restaurarlo después."
                                  data-confirm-title="¿Archivar este elemento?"
                                  data-confirm-button="Sí, archivar"
                                  data-confirm-color="#b84b4b">
                                @csrf
                                @method('DELETE')
                                <button style="border:0;background:none;color:#a33">Archivar</button>
                            </form>
                        @endunless
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">No hay registros.</td></tr>
            @endforelse
        </table>
        {{ $items->links() }}
    </div>
</x-layouts.admin>
