<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Assistência Técnica',
                'slug' => 'assistencia-tecnica',
                'description' => 'Reparação e manutenção profissional de computadores, laptops, impressoras e outros equipamentos informáticos. Diagnóstico rápido e soluções eficientes.',
                'short_description' => 'Reparação e manutenção de equipamentos',
                'icon' => 'fas fa-tools',
                'category' => 'hardware',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Desenvolvimento de Software',
                'slug' => 'desenvolvimento-de-software',
                'description' => 'Criação de aplicações web, sistemas de gestão, e soluções personalizadas para optimizar os processos do seu negócio.',
                'short_description' => 'Aplicações web e sistemas personalizados',
                'icon' => 'fas fa-code',
                'category' => 'software',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Infraestrutura de Redes',
                'slug' => 'infraestrutura-de-redes',
                'description' => 'Projecto, instalação e manutenção de redes locais (LAN/WAN), servidores, switches, routers e cabeamento estruturado.',
                'short_description' => 'Projecto e instalação de redes',
                'icon' => 'fas fa-network-wired',
                'category' => 'network',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Segurança Informática',
                'slug' => 'seguranca-informatica',
                'description' => 'Protectores de rede, firewall, antivirus, backups e soluções de segurança para proteger os dados da sua empresa.',
                'short_description' => 'Protecção de dados e redes',
                'icon' => 'fas fa-shield-alt',
                'category' => 'security',
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
