<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Post;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\SiteImage;
use Illuminate\Database\Seeder;

class DefaultContentSeeder extends Seeder
{
    public function run(): void
    {
        if (Banner::count() === 0) {
            Banner::insert([
                ['title' => 'Soluções Tecnológicas Completas', 'subtitle' => 'Infraestrutura, software, segurança e suporte para impulsionar o seu negócio.', 'button_text' => 'Nossos Serviços', 'button_link' => '#services', 'image' => null, 'order' => 1, 'active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['title' => 'Desenvolvimento de Software', 'subtitle' => 'Aplicações web, mobile e desktop à medida para automatizar processos.', 'button_text' => 'Solicitar Orçamento', 'button_link' => '#contact', 'image' => null, 'order' => 2, 'active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['title' => 'Infraestrutura de Redes', 'subtitle' => 'Projecto, instalação e manutenção de redes com as melhores tecnologias.', 'button_text' => 'Saiba Mais', 'button_link' => '#infraestrutura', 'image' => null, 'order' => 3, 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        if (Service::count() === 0) {
            Service::insert([
                ['icon' => 'fas fa-tools', 'title' => 'Assistência Técnica', 'description' => 'Diagnóstico e reparação profissional de computadores, impressoras e equipamentos de rede.', 'sort_order' => 1, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['icon' => 'fas fa-laptop-code', 'title' => 'Desenvolvimento de Software', 'description' => 'Aplicações web, mobile e desktop à medida para automatizar os seus processos.', 'sort_order' => 2, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['icon' => 'fas fa-network-wired', 'title' => 'Infraestrutura', 'description' => 'Instalação e manutenção de redes, servidores, cabeamento estruturado e cloud.', 'sort_order' => 3, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['icon' => 'fas fa-microchip', 'title' => 'Reparação de Equipamentos', 'description' => 'Reparação especializada de hardware, substituição de componentes e actualizações.', 'sort_order' => 4, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['icon' => 'fas fa-graduation-cap', 'title' => 'Formação', 'description' => 'Cursos de informática para empresas e particulares, desde nível básico ao avançado.', 'sort_order' => 5, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['icon' => 'fas fa-shield-alt', 'title' => 'Segurança', 'description' => 'Soluções de segurança informática, antivirus, firewall e backup de dados.', 'sort_order' => 6, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['icon' => 'fas fa-print', 'title' => 'Impressoras', 'description' => 'Venda, manutenção e reparação de impressoras de todos os modelos e marcas.', 'sort_order' => 7, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['icon' => 'fas fa-headset', 'title' => 'Suporte Remoto', 'description' => 'Assistência técnica à distância para resolução rápida de problemas.', 'sort_order' => 8, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        if (TeamMember::count() === 0) {
            TeamMember::insert([
                ['name' => 'Masukul Miguel', 'role' => 'CEO & Fundador', 'bio' => 'Especialista em infraestrutura de redes e soluções tecnológicas com mais de 10 anos de experiência no mercado angolano.', 'photo' => null, 'sort_order' => 1, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        if (Post::count() === 0) {
            Post::insert([
                [
                    'title' => 'Novas Soluções Cloud para Empresas',
                    'slug' => 'novas-solucoes-cloud-para-empresas',
                    'excerpt' => 'A Troubleshoot apresenta novas soluções de cloud computing para optimizar a infraestrutura da sua empresa com segurança e eficiência.',
                    'content' => 'A cloud computing tornou-se essencial para empresas que querem escalar os seus negócios de forma eficiente. Com as nossas novas soluções cloud, oferecemos infraestrutura segura, escalável e com custos optimizados.',
                    'image' => null,
                    'category' => 'Tecnologia',
                    'author' => 'Masukul Miguel',
                    'is_published' => true,
                    'is_featured' => true,
                    'published_at' => now()->subDays(5),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Segurança Informática: Dicas Essenciais',
                    'slug' => 'seguranca-informatica-dicas-essenciais',
                    'excerpt' => 'Conheça as melhores práticas para proteger os seus dados e sistemas contra ameaças cibernéticas crescentes.',
                    'content' => 'A segurança informática é uma prioridade para qualquer empresa. Neste artigo, partilhamos dicas essenciais para proteger os seus dados contra malware, phishing e outras ameaças.',
                    'image' => null,
                    'category' => 'Segurança',
                    'author' => 'Equipa Técnica',
                    'is_published' => true,
                    'is_featured' => false,
                    'published_at' => now()->subDays(12),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Infraestrutura de Redes: Guia Completo',
                    'slug' => 'infraestrutura-de-redes-guia-completo',
                    'excerpt' => 'Tudo o que precisa de saber sobre projecto e implementação de redes de dados profissionais para a sua empresa.',
                    'content' => 'Uma boa infraestrutura de rede é a base de qualquer empresa moderna. Desde cabeamento estruturado até switches e roteadores, cada componente conta para garantir performance e confiabilidade.',
                    'image' => null,
                    'category' => 'Redes',
                    'author' => 'Masukul Miguel',
                    'is_published' => true,
                    'is_featured' => false,
                    'published_at' => now()->subDays(19),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}
