# Troubleshoot Soluções Tecnológicas

Website institucional + CRM Admin para gestão de contactos, visitantes e imagens.

## Estrutura

```
tshoot-angola/
├── index.html              # Site principal (Vue.js 3)
├── assets/img/             # Logos e imagens
├── css/custom.css          # Estilos customizados
├── js/scripts.js           # Scripts principais
└── admin/                  # Laravel 12 CRM
    ├── app/Http/Controllers/
    ├── app/Models/
    ├── database/
    ├── resources/views/
    └── routes/
```

## Stack

- **Frontend**: HTML5, CSS3, JavaScript, Vue.js 3 (CDN), Tailwind CSS, Chart.js
- **Backend**: Laravel 12, PHP 8.2, SQLite/MySQL
- **Design**: Gold (#D4A11D) + Navy (#1B2A41), minimal, responsivo

## Funcionalidades

### Site Principal
- Hero com carousel e slide automático
- Secções: Sobre, Serviços, Como Trabalhamos, Infraestrutura, Parceiros, Contacto
- Formulário de contacto funcional (guarda na base de dados)
- Tracking de visitantes (IP, browser, OS, dispositivo, país/cidade)
- Animações de scroll (IntersectionObserver)
- Design 100% responsivo

### Admin CRM (`/admin/public/login`)

#### Dashboard
- Gráficos (Chart.js): visitantes, browsers, países, dispositivos, páginas
- Estatísticas: contactos, visitantes, imagens, actividade diária

#### Gestão de Conteúdo
- **Banners/Carrossel**: CRUD completo, activar/desactivar, reordenar
- **Serviços**: CRUD completo com categorias, ícones, ordem
- **Equipa**: Gestão de membros (foto, cargo, redes sociais)
- **Blog/Notícias**: Publicação de artigos com categorias e destaque
- **Conteúdo das Secções**: Editor de texto para 8 secções do site
- **Imagens**: Upload, categorias (hero, about, gallery, infra, partners), reordenar

#### Gestão de Contactos
- Listagem com filtros (novo, lido, respondido, arquivado)
- Resposta por email (envio automático)
- Alteração de estado

#### Gestão de Visitantes
- Tracking completo (IP, geolocalização, browser, OS, dispositivo)
- Analytics com gráficos detalhados
- Histórico de visitas por utilizador

#### Definições
- Dados da empresa (nome, slogan, contactos)
- Redes sociais
- Horário de funcionamento
- **SEO**: Meta títulos, descrições, palavras-chave, Open Graph, Google Analytics

#### Autenticação
- Login com email/password
- Rate limiting (5 tentativas por IP)
- Loading screen animado
- Sidebar responsiva com menu mobile

## Credenciais Admin

- **Email**: admin@tshoot-angola.com
- **Password**: tshoot2024

## Instalação Local

```bash
git clone https://github.com/Masukulmiguel/tshoot.git
cd tshoot-angola/admin
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan serve
```

Acessar: `http://localhost:8000/public/login`

## Contactos

- **Telefone**: (+244) 933 189 868
- **WhatsApp**: +244 935 603 163
- **Email**: comercial@tshoot-angola.com
- **Localização**: Major Kanhangulo, Prédio da Suave, 3º Andar, Luanda, Angola
