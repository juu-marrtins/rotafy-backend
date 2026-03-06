<div align="center">

# 🚗 Rotafy — Backend API

**Plataforma de caronas universitárias intermunicipais**

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-16-336791?style=flat-square&logo=postgresql&logoColor=white)](https://postgresql.org)
[![Docker](https://img.shields.io/badge/Docker-ready-2496ED?style=flat-square&logo=docker&logoColor=white)](https://docker.com)
[![Status](https://img.shields.io/badge/Status-Em%20Desenvolvimento-yellow?style=flat-square)]()

> Projeto de TCC — API REST para conectar estudantes universitários que precisam de carona com motoristas que já fazem o mesmo trajeto, promovendo mobilidade solidária e redução de custos.

[Sobre](#-sobre) · [Funcionalidades](#-funcionalidades) · [Instalação](#-instalação) · [Autenticação](#-autenticação)

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

## 🔐 Autenticação

A API usa **Laravel Sanctum** com tokens de acesso pessoal. Todas as rotas protegidas requerem o header:

```
Authorization: Bearer {seu_token}
```

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
