@extends('layouts.admin')
@section('content')

<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-navy">Configurações do Site</h1>
        <p class="text-sm text-gray-500 mt-1">Informações gerais, contactos e redes sociais</p>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-building text-gold"></i> Empresa
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nome da Empresa</label>
                    <input type="text" name="company_name" value="{{ $settings['general']['company_name'] ?? 'Troubleshoot Soluções Tecnológicas' }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Slogan</label>
                    <input type="text" name="slogan" value="{{ $settings['general']['slogan'] ?? '' }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-phone text-gold"></i> Contactos
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Telefone</label>
                    <input type="text" name="phone" value="{{ $settings['general']['phone'] ?? '(+244) 933 189 868' }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ $settings['general']['whatsapp'] ?? '+244 935 603 163' }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ $settings['general']['email'] ?? 'comercial@tshoot-angola.com' }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Morada</label>
                    <input type="text" name="address" value="{{ $settings['general']['address'] ?? 'Major Kanhangulo, Luanda' }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-share-alt text-gold"></i> Redes Sociais
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Facebook URL</label>
                    <input type="url" name="facebook" value="{{ $settings['general']['facebook'] ?? '' }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none" placeholder="https://facebook.com/...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Instagram URL</label>
                    <input type="url" name="instagram" value="{{ $settings['general']['instagram'] ?? '' }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none" placeholder="https://instagram.com/...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">LinkedIn URL</label>
                    <input type="url" name="linkedin" value="{{ $settings['general']['linkedin'] ?? '' }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none" placeholder="https://linkedin.com/...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">YouTube URL</label>
                    <input type="url" name="youtube" value="{{ $settings['general']['youtube'] ?? '' }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none" placeholder="https://youtube.com/...">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-clock text-gold"></i> Horário
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Seg - Sex</label>
                    <input type="text" name="hours_weekday" value="{{ $settings['general']['hours_weekday'] ?? '8h00 - 16h30' }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sábado</label>
                    <input type="text" name="hours_saturday" value="{{ $settings['general']['hours_saturday'] ?? '8h30 - 11h30' }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-search text-gold"></i> SEO (Search Engine Optimization)
            </h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Meta Título</label>
                    <input type="text" name="meta_title" value="{{ $settings['seo']['meta_title'] ?? '' }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none" placeholder="Título que aparece no Google">
                    <p class="text-xs text-gray-400 mt-1">Máximo 60 caracteres</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Meta Descrição</label>
                    <textarea name="meta_description" rows="2" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none resize-y" placeholder="Descrição que aparece nos resultados de busca">{{ $settings['seo']['meta_description'] ?? '' }}</textarea>
                    <p class="text-xs text-gray-400 mt-1">Máximo 160 caracteres</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Palavras-chave</label>
                    <input type="text" name="meta_keywords" value="{{ $settings['seo']['meta_keywords'] ?? '' }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none" placeholder="informática, assistência técnica, software">
                    <p class="text-xs text-gray-400 mt-1">Separadas por vírgula</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-share-alt text-gold"></i> Open Graph (Redes Sociais)
            </h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">OG Título</label>
                    <input type="text" name="og_title" value="{{ $settings['seo']['og_title'] ?? '' }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none" placeholder="Título ao partilhar nas redes sociais">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">OG Descrição</label>
                    <textarea name="og_description" rows="2" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none resize-y" placeholder="Descrição ao partilhar nas redes sociais">{{ $settings['seo']['og_description'] ?? '' }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">OG Imagem URL</label>
                    <input type="url" name="og_image" value="{{ $settings['seo']['og_image'] ?? '' }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none" placeholder="https://tshoot-angola.com/assets/img/logo.png">
                    <p class="text-xs text-gray-400 mt-1">Imagem recomendada: 1200x630 pixels</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-line text-gold"></i> Google Analytics
            </h3>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Google Analytics ID</label>
                <input type="text" name="google_analytics" value="{{ $settings['seo']['google_analytics'] ?? '' }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none" placeholder="G-XXXXXXXXXX">
                <p class="text-xs text-gray-400 mt-1">ID do Google Analytics (ex: G-XXXXXXXXXX)</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-image text-gold"></i> Imagens do Site
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Imagem - Sobre Nós</label>
                    @if($settings['general']['about_image ?? null'])
                        <div class="mb-2">
                            <img src="{{ asset($settings['general']['about_image'] ?? '') }}" alt="Sobre" class="h-32 rounded-lg object-cover border">
                        </div>
                    @endif
                    <input type="file" name="about_image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gold file:text-white hover:file:bg-yellow-600">
                    <p class="text-xs text-gray-400 mt-1">Imagem da secção Sobre Nós</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Imagem - Fundo Contacto</label>
                    @if($settings['general']['contact_bg'] ?? null)
                        <div class="mb-2">
                            <img src="{{ asset($settings['general']['contact_bg'] ?? '') }}" alt="Contacto" class="h-32 rounded-lg object-cover border">
                        </div>
                    @endif
                    <input type="file" name="contact_bg" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gold file:text-white hover:file:bg-yellow-600">
                    <p class="text-xs text-gray-400 mt-1">Imagem de fundo da secção Contacto</p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="px-5 py-2.5 bg-gold text-white text-sm font-medium rounded-lg hover:bg-gold/90 transition-colors">Guardar Configurações</button>
        </div>
    </form>
</div>
@endsection
