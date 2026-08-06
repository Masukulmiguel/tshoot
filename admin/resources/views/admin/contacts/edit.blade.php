@extends('layouts.admin')
@section('content')

<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.contacts.index') }}" class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
        </a>
        <div>
            <h1 class="text-xl font-bold text-gray-900">Editar Contacto</h1>
            <p class="text-sm text-gray-500">{{ $contact->name }} — {{ $contact->email }}</p>
        </div>
    </div>

    <form action="{{ route('admin.contacts.update', $contact) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nome <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $contact->name) }}" required
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-gold/20 focus:border-gold transition-colors @error('name') border-red-300 @enderror">
                        @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $contact->email) }}" required
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-gold/20 focus:border-gold transition-colors @error('email') border-red-300 @enderror">
                        @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Telefone</label>
                        <input type="text" name="phone" value="{{ old('phone', $contact->phone) }}"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-gold/20 focus:border-gold transition-colors @error('phone') border-red-300 @enderror">
                        @error('phone') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Assunto</label>
                        <input type="text" name="subject" value="{{ old('subject', $contact->subject) }}"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-gold/20 focus:border-gold transition-colors @error('subject') border-red-300 @enderror">
                        @error('subject') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Estado</label>
                    <select name="status"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-gold/20 focus:border-gold transition-colors @error('status') border-red-300 @enderror">
                        <option value="new" {{ old('status', $contact->status) === 'new' ? 'selected' : '' }}>Novo</option>
                        <option value="read" {{ old('status', $contact->status) === 'read' ? 'selected' : '' }}>Lido</option>
                        <option value="replied" {{ old('status', $contact->status) === 'replied' ? 'selected' : '' }}>Respondido</option>
                        <option value="archived" {{ old('status', $contact->status) === 'archived' ? 'selected' : '' }}>Arquivado</option>
                    </select>
                    @error('status') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Mensagem <span class="text-red-500">*</span></label>
                    <textarea name="message" rows="5" required
                              class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-gold/20 focus:border-gold transition-colors resize-none @error('message') border-red-300 @enderror">{{ old('message', $contact->message) }}</textarea>
                    @error('message') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja eliminar este contacto?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 rounded-xl transition-colors">
                        Eliminar
                    </button>
                </form>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.contacts.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" form="edit-form" class="px-5 py-2.5 text-sm font-semibold text-navy bg-gold rounded-xl hover:bg-gold-light transition-colors shadow-sm">
                        Guardar Alterações
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection