# Primavera Sound 2026

## Tema escolhido
Aplicação web para gerir e consultar o horário de concertos do festival Primavera Sound Porto 2026.

## Tecnologias utilizadas
- PHP
- MySQL
- HTML
- CSS
- Bootstrap 5

## Funcionalidades principais
- Registo e login de utilizadores
- Gestão de sessões e proteção de páginas privadas
- Consulta do horário de concertos (data, hora, artista, palco)
- CRUD de concertos (adicionar, editar, apagar)
- CRUD de artistas (adicionar, editar, apagar)
- Base de dados com 4 tabelas relacionadas (utilizadores, artistas, palcos, concertos)
- Uso de prepared statements (PDO) para segurança

## Estrutura da base de dados
- **utilizadores** — id, username, password
- **artistas** — id, nome
- **palcos** — id, nome
- **concertos** — id, artista_id, palco_id, dia_data, hora

## Limitações e ideias futuras
- Permitir filtrar o horário por dia ou por palco
- Adicionar página pública sem necessidade de login
- Gestão de palcos com CRUD completo