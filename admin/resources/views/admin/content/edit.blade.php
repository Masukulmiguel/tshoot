@extends('layouts.admin')
@section('content')

<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.content.index') }}" class="p-2 text-gray-400 hover:text-navy hover:bg-gray-100 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-navy">Editar: {{ ucfirst(str_replace('_', ' ', $section)) }}</h1>
            <p class="text-sm text-gray-500">Altere os textos desta secção do site</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.content.update', $section) }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        @csrf @method('PUT')

        @if($contents->count())
            @foreach($contents as $content)
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ ucfirst(str_replace('_', ' ', $content->key)) }}</label>
                    @if(strlen($content->value ?? '') > 100)
                        <textarea name="{{ $content->key }}" rows="4" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none">{{ old($content->key, $content->value) }}</textarea>
                    @else
                        <input type="text" name="{{ $content->key }}" value="{{ old($content->key, $content->value) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none">
                    @endif
                </div>
            @endforeach
        @else
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Adicionar campo de texto</label>
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <input type="text" name="_new_keys[]" placeholder="Nome do campo (ex: title)" class="px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none">
                    <input type="text" name="_new_values[]" placeholder="Valor do campo" class="px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none">
                </div>
                <button type="button" onclick="addMoreFields()" class="text-sm text-gold hover:underline">+ Adicionar mais campo</button>
                <div id="moreFields"></div>
            </div>
        @endif

        <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
            <button type="submit" class="px-5 py-2.5 bg-gold text-white text-sm font-medium rounded-lg hover:bg-gold/90 transition-colors">Guardar</button>
            <a href="{{ route('admin.content.index') }}" class="px-5 py-2.5 text-gray-500 text-sm font-medium hover:text-navy transition-colors">Cancelar</a>
        </div>
    </form>
</div>

<script>
function addMoreFields() {
    const div = document.createElement('div');
    div.className = 'grid grid-cols-2 gap-3 mb-3';
    div.innerHTML = `
        <input type="text" name="_new_keys[]" placeholder="Nome do campo" class="px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none">
        <input type="text" name="_new_values[]" placeholder="Valor do campo" class="px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none">
    `;
    document.getElementById('moreFields').appendChild(div);
}
</script>
@endsection
