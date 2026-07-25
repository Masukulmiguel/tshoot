<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;
use App\Models\SiteContent;
use App\Models\SiteSetting;

class SiteContentSeeder extends Seeder
{
    public function run(): void
    {
        // Banners
        Banner::create(['title' => 'Soluções Tecnológicas Completas', 'subtitle' => 'Infraestrutura, software, segurança e suporte técnico para empresas e particulares em Angola.', 'button_text' => 'Nossos Serviços', 'button_link' => '#servicos', 'image' => null, 'order' => 0, 'active' => true]);
        Banner::create(['title' => 'Desenvolvimento de Software', 'subtitle' => 'Aplicações web, mobile e desktop à medida para automatizar os seus processos.', 'button_text' => 'Solicitar Orçamento', 'button_link' => '#contacto', 'image' => null, 'order' => 1, 'active' => true]);
        Banner::create(['title' => 'Infraestrutura de Redes', 'subtitle' => 'Projecto, instalação e manutenção de redes com as melhores tecnologias do mercado.', 'button_text' => 'Saiba Mais', 'button_link' => '#infraestrutura', 'image' => null, 'order' => 2, 'active' => true]);

        // About
        SiteContent::set('about', 'title', 'A Troubleshoot tem o que você precisa!');
        SiteContent::set('about', 'description', 'A Troubleshoot - Soluções Tecnológicas é uma empresa de direito Angolano com actuação na área da tecnologia de informação, fornecendo soluções completas e oferecendo aos seus clientes sistemas integrados que proporcionam vantagens e benefícios significativos.');
        SiteContent::set('about', 'description_2', 'A estratégia da diferenciação, a qualidade dos serviços prestados, constitui a nossa aposta para estabelecer relações de confiança com nossos clientes.');
        SiteContent::set('about', 'feature_1', 'Suporte 24/7');
        SiteContent::set('about', 'feature_2', 'Equipas Especializadas');
        SiteContent::set('about', 'feature_3', 'Preços Competitivos');
        SiteContent::set('about', 'feature_4', 'Garantia de Serviço');
        SiteContent::set('about', 'experience_years', '10+');
        SiteContent::set('about', 'experience_label', 'Anos de Experiência');

        // Services
        SiteContent::set('services', 'title', 'Nossos Serviços');
        SiteContent::set('services', 'subtitle', 'Oferecemos soluções completas para todas as suas necessidades em tecnologia de informação');

        // How it works
        SiteContent::set('how_it_works', 'title', 'Como Trabalhamos');
        SiteContent::set('how_it_works', 'subtitle', 'Processo simples e transparente para todos os nossos clientes');

        // Infra
        SiteContent::set('infra', 'title', 'Redes e Infraestrutura');
        SiteContent::set('infra', 'subtitle', 'Soluções completas de infraestrutura de rede para empresas de todos os tamanhos');

        // Partners
        SiteContent::set('partners', 'title', 'Nossos Clientes e Parceiros');
        SiteContent::set('partners', 'subtitle', 'Empresas que confiam nas nossas soluções tecnológicas');

        // Contact
        SiteContent::set('contact', 'title', 'Fale Connosco');
        SiteContent::set('contact', 'subtitle', 'Estamos prontos para ajudar a transformar as suas ideias em soluções tecnológicas.');
        SiteContent::set('contact', 'form_title', 'Envie-nos uma mensagem');
        SiteContent::set('contact', 'form_subtitle', 'Preencha o formulário e entraremos em contacto.');

        // Settings
        SiteSetting::set('company_name', 'Troubleshoot Soluções Tecnológicas', 'general');
        SiteSetting::set('phone', '(+244) 933 189 868', 'general');
        SiteSetting::set('whatsapp', '+244 935 603 163', 'general');
        SiteSetting::set('email', 'comercial@tshoot-angola.com', 'general');
        SiteSetting::set('address', 'Major Kanhangulo, Prédio da Suave, 3º Andar, Luanda', 'general');
        SiteSetting::set('hours_weekday', '8h00 - 16h30', 'general');
        SiteSetting::set('hours_saturday', '8h30 - 11h30', 'general');
        SiteSetting::set('facebook', 'https://www.facebook.com/Tshoot-Soluções-Tecnológicas-107151237849422/', 'general');
        SiteSetting::set('instagram', '', 'general');
        SiteSetting::set('linkedin', '', 'general');
        SiteSetting::set('youtube', '', 'general');
    }
}
