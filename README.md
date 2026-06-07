# Primavera Sound 2026

## Tema escolhido
Aplicação web para consulta e gestão do horário de concertos do festival Primavera Sound Porto 2026.

## Tecnologias utilizadas
- PHP
- MySQL
- HTML
- CSS
- Bootstrap 5
- JavaScript

## Funcionalidades principais
- Registo e login de utilizadores com sessões
- Consulta do horário de concertos por data, hora, artista e palco
- Gestão de concertos (adicionar, editar, apagar)
- Proteção de páginas privadas
- Base de dados com 3 tabelas relacionadas (artistas, palcos, concertos)

## Estrutura da base de dados
- **artistas** — id, nome
- **palcos** — id, nome
- **concertos** — id, artista_id, palco_id, dia_data, hora

## Limitações e ideias futuras
- Adicionar CRUD completo para artistas e palcos
- Permitir filtrar o horário por dia ou por palco
- Adicionar página pública sem necessidade de login