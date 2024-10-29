# API Documentation

## Visão Geral

Esta pasta contém várias APIs que fornecem diferentes funcionalidades. Abaixo está uma breve descrição de cada API e seus endpoints.

## Endpoints da API

### 1. API de Jogadores

- **Endpoint:** `/api/getJogadores`
- **Métodos:**
  - `GET`: Recuperar uma lista de jogadores.
- **Descrição:** Esta API permite a recuperação de informações de jogadores existentes.

### 2. API de Jogador

- **Endpoint:** `/api/geJogadores?email={id}&senha={senha}`
- **Métodos:**
  - `GET`: Recuperar informações de um jogador específico.
- **Descrição:** Esta API permite a recuperação de informações de um jogador específico, identificado pelo seu email e senha.

### 3. API de Usuários

- **Endpoint:** `/api/getUsuarios`
- **Métodos:**
  - `GET`: Recuperar uma lista de usuários.
- **Descrição:** Esta API permite a recuperação de informações de usuários existentes.

### 4. API de Usuário

- **Endpoint:** `/api/getUsuario?email={email}&senha={senha}`
- **Métodos:**
  - `GET`: Recuperar informações de um usuário específico.
- **Descrição:** Esta API permite a recuperação de informações de um usuário específico, identificado pelo seu email e senha.
