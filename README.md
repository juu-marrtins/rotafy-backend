<div align="center">

# 🚗 Rotafy — Backend API

**Plataforma de caronas universitárias intermunicipais**

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-16-336791?style=flat-square&logo=postgresql&logoColor=white)](https://postgresql.org)
[![Docker](https://img.shields.io/badge/Docker-ready-2496ED?style=flat-square&logo=docker&logoColor=white)](https://docker.com)
[![Status](https://img.shields.io/badge/Status-Em%20Desenvolvimento-yellow?style=flat-square)]()

> Projeto de TCC — API REST para conectar estudantes universitários que precisam de carona com motoristas que já fazem o mesmo trajeto, promovendo mobilidade solidária e redução de custos.

[Sobre](#-sobre) · [Funcionalidades](#-funcionalidades) · [Arquitetura](#-arquitetura) · [Instalação](#-instalação) · [API](#-endpoints) · [Precificação](#-modelo-de-precificação)

</div>

---

## 📖 Sobre

O **Rotafy** nasceu de uma necessidade real: estudantes de cidades menores que precisam se deslocar diariamente até o polo universitário enfrentam altos custos de transporte. A plataforma conecta passageiros e motoristas que já fazem o mesmo trajeto, permitindo o rateio proporcional do custo de combustível — caracterizando **ajuda de custo**, não transporte remunerado.

**Contexto:** Cidades satélite → polo universitário (ex: 53 km de distância). Carona informal custa R$20. Com Rotafy, o passageiro paga entre R$8 e R$13, dependendo do número de pessoas no carro.

---

## ✅ Funcionalidades

### Implementadas
- [x] Autenticação via **Laravel Sanctum** (registro, login, logout, tokens)
- [x] Cadastro de perfil de motorista com documentos (CNH, CRLV, fotos)
- [x] Integração com **AbacatePay** para pagamentos via PIX
- [x] Criação de customer no AbacatePay ao aprovar motorista

### Em desenvolvimento
- [ ] Listagem e busca de caronas disponíveis
- [ ] Sistema de solicitação e aceite de carona
- [ ] Cálculo automático de preço (INMETRO + ANP)
- [ ] Avaliações bidirecionais (passageiro ↔ motorista)
- [ ] Painel administrativo para aprovação de documentos
- [ ] Sistema de saque para motoristas

---

## 🏗️ Arquitetura

```
rotafy-backend/
├── app/
│   ├── Http/
│   │   ├── Controllers/        # Controllers da API
│   │   ├── Requests/           # Form Requests (validação)
│   │   └── Resources/          # API Resources (transformação)
│   ├── Models/                 # Eloquent Models
│   │   ├── User.php
│   │   ├── DriverProfile.php
│   │   ├── Vehicle.php
│   │   ├── DriverDocument.php
│   │   ├── University.php
│   │   ├── Ride.php
│   │   ├── RideRequest.php
│   │   ├── Payment.php
│   │   └── Rating.php
│   ├── Observers/              # Model Observers (ex: AbacatePay ao aprovar)
│   ├── Services/               # Lógica de negócio
│   │   ├── PricingService.php  # Cálculo de precificação
│   │   └── AbacatePayService.php
│   └── Jobs/                   # Jobs assíncronos
│       └── CreateAbacatePayCustomer.php
├── database/
│   ├── migrations/
│   └── seeders/
├── routes/
│   └── api.php
└── docker-compose.yml
```

### Stack tecnológica

| Camada | Tecnologia |
|---|---|
| Framework | Laravel 11.x |
| Linguagem | PHP 8.2+ |
| Banco de dados | PostgreSQL 16 |
| Autenticação | Laravel Sanctum |
| Pagamentos | AbacatePay (PIX) |
| Containerização | Docker + Docker Compose |
| Hospedagem (prod) | Google Cloud Run + Cloud SQL |
| Storage (docs) | Google Cloud Storage |
| Distância | Google Maps Distance Matrix API |
| Consumo veicular | Tabela INMETRO |
| Preço combustível | API ANP |

---

## 🗄️ Modelo de Banco de Dados

```
universities ──< users ──────────< ride_requests >── rides
                  │                     │                │
                  └── driver_profiles ──┘         driver_profiles
                            │                           │
                        vehicles                  driver_documents
                            
ride_requests ──── payments (1:1)
ride_requests ──< ratings
```

### Tabelas principais

| Tabela | Descrição |
|---|---|
| `users` | Usuários (estudantes, professores, funcionários) |
| `universities` | Universidades cadastradas na plataforma |
| `driver_profiles` | Perfil de motorista (separado de users) |
| `vehicles` | Veículo do motorista (placa, modelo, consumo INMETRO) |
| `driver_documents` | CNH, CRLV, selfie — com status de aprovação |
| `rides` | Caronas ofertadas pelos motoristas |
| `ride_requests` | Solicitações de passageiros com preço congelado |
| `payments` | Transações financeiras via AbacatePay |
| `ratings` | Avaliações bidirecionais pós-carona |

---

## 💰 Modelo de Precificação

O Rotafy usa um modelo de **rateio parcial de custo** — o passageiro paga apenas uma fração proporcional do trajeto, não o valor integral.

### Fórmula

```
Consumo_real     = Consumo_INMETRO × 0,85  (fator de correção para uso real)
Custo_total      = (Distância ÷ Consumo_real) × Preço_combustível
Custo_rateado    = Custo_total × P          (P varia com nº de passageiros)
Valor_base       = Custo_rateado ÷ N_passageiros
Valor_final      = Valor_base × 1,12        (12% taxa da plataforma)
```

### Percentual de rateio (P)

| Passageiros | Rateio | Justificativa |
|---|---|---|
| 1 | 50% | Motorista ainda arca com metade |
| 2 | 60% | Divisão mais equilibrada |
| 3+ | 70% | Máximo permitido — evita lucro |

> **Por que no máximo 70%?** Acima disso o motorista obtém lucro líquido, o que descaracteriza a ajuda de custo e pode enquadrar a atividade como transporte remunerado (irregular).

### Fontes de dados automáticas

| Dado | Fonte |
|---|---|
| Distância entre municípios | Google Maps Distance Matrix API |
| Consumo do veículo | Tabela INMETRO (por modelo/ano) |
| Preço do combustível | ANP — atualizado semanalmente por município |

### Divisão financeira (exemplo: 53km, 2 passageiros)

```
Passageiro paga:     R$ 11,21  (valor final com 12% de taxa)
Motorista recebe:    R$ 10,01  (valor base × 2 passageiros ÷ 2)
Custo provedor:      R$  0,80  (AbacatePay — fixo por transação PIX)
Plataforma líquida:  R$  1,20  (12% - custo provedor)
```

---

## 🚀 Instalação

### Pré-requisitos

- Docker e Docker Compose instalados
- Git

### Passo a passo

```bash
# 1. Clone o repositório
git clone https://github.com/juu-marrtins/rotafy-backend.git
cd rotafy-backend

# 2. Copie o arquivo de ambiente
cp .env.example .env

# 3. Suba os containers
docker compose up -d

# 4. Instale as dependências
docker compose exec app composer install

# 5. Gere a chave da aplicação
docker compose exec app php artisan key:generate

# 6. Execute as migrations
docker compose exec app php artisan migrate

# 7. (Opcional) Rode os seeders
docker compose exec app php artisan db:seed
```

### Variáveis de ambiente

```env
APP_NAME=Rotafy
APP_ENV=local
APP_URL=http://localhost:8000

DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=rotafy
DB_USERNAME=postgres
DB_PASSWORD=secret

# AbacatePay
ABACATEPAY_API_KEY=your_api_key_here
ABACATEPAY_BASE_URL=https://api.abacatepay.com/v1

# Google Maps
GOOGLE_MAPS_API_KEY=your_api_key_here

# Google Cloud Storage
GCS_BUCKET=rotafy-documents
GCS_PROJECT_ID=your_project_id
```

---

## 📡 Endpoints

### Autenticação

```
POST   /api/auth/register         Cadastro de usuário
POST   /api/auth/login            Login
POST   /api/auth/logout           Logout (requer token)
GET    /api/auth/me               Dados do usuário autenticado
```

### Perfil de motorista

```
POST   /api/driver/profile        Criar perfil de motorista
POST   /api/driver/documents      Upload de documentos (CNH, CRLV)
GET    /api/driver/profile        Visualizar perfil
PATCH  /api/driver/profile        Atualizar perfil
```

### Caronas *(em desenvolvimento)*

```
GET    /api/rides                 Listar caronas disponíveis
POST   /api/rides                 Criar carona (motorista)
GET    /api/rides/{id}            Detalhes de uma carona
DELETE /api/rides/{id}            Cancelar carona
```

### Solicitações *(em desenvolvimento)*

```
POST   /api/rides/{id}/requests   Solicitar carona
PATCH  /api/requests/{id}         Aceitar ou recusar solicitação
GET    /api/requests              Listar solicitações do usuário
```

### Pagamentos *(em desenvolvimento)*

```
POST   /api/payments/{requestId}  Iniciar pagamento PIX
GET    /api/payments/{id}         Status do pagamento
POST   /api/withdrawals           Solicitar saque (motorista)
```

### Avaliações *(em desenvolvimento)*

```
POST   /api/ratings               Avaliar carona
GET    /api/users/{id}/ratings    Ver avaliações de um usuário
```

---

## 🔐 Autenticação

A API usa **Laravel Sanctum** com tokens de acesso pessoal. Todas as rotas protegidas requerem o header:

```
Authorization: Bearer {seu_token}
```

### Tipos de usuário

| user_type | Acesso |
|---|---|
| `passenger` | Buscar e solicitar caronas |
| `driver` | Oferecer caronas (requer perfil aprovado) |
| `both` | Acesso completo |

### Status de verificação

| status | Descrição |
|---|---|
| `pending` | Aguardando verificação |
| `verified` | Aprovado — acesso completo |
| `rejected` | Documentação reprovada |

---

## 🧪 Testes

```bash
# Rodar todos os testes
docker compose exec app php artisan test

# Com cobertura
docker compose exec app php artisan test --coverage
```

---

## 📦 Infraestrutura de Produção (GCP)

| Serviço | Uso | Custo estimado |
|---|---|---|
| Cloud Run | API Laravel (PHP) | ~R$ 5–15/mês |
| Cloud SQL | PostgreSQL db-f1-micro | ~R$ 50/mês |
| Cloud Storage | Documentos e fotos | < R$ 1/mês |
| Maps API | Distance Matrix | Gratuito (crédito $200) |
| AbacatePay | PIX por transação | R$ 0,80/tx |

> O maior custo fixo é o Cloud SQL (~R$50/mês). Cloud Run escala para zero quando não há tráfego, tornando o custo variável mínimo em estágios iniciais.

---

## 👤 Autor

**Julia Martins**
TCC — Sistemas de Informação
GitHub: [@juu-marrtins](https://github.com/juu-marrtins)

---

## 📄 Licença

Este projeto é desenvolvido para fins acadêmicos (TCC).

---

<div align="center">
  <sub>Feito com ☕ e Laravel · Rotafy © 2025</sub>
</div>
