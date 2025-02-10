#!/bin/bash

echo "🚀 Iniciando o setup do projeto..."

# Subir os containers Docker
echo "🐳 Subindo os containers..."
docker-compose down --remove-orphans
docker-compose up --build -d

# Aguardar um tempo para garantir que os containers iniciaram
echo "⏳ Aguardando os serviços subirem..."
sleep 20

# Configuração do Backend
echo "⚙️ Configurando o backend..."

# Copiar .env caso não exista
docker exec -it salesflow_backend sh -c 'test -f .env || cp .env.example .env'

# Rodar migrations e seeders
echo "🛠️ Rodando migrations e seeders..."
docker exec -it salesflow_backend php artisan migrate
docker exec -it salesflow_backend php artisan db:seed

# Limpar e cachear as configurações
echo "🔄 Limpando e cacheando configurações..."
docker exec -it salesflow_backend php artisan config:clear
docker exec -it salesflow_backend php artisan cache:clear
docker exec -it salesflow_backend php artisan route:clear
docker exec -it salesflow_backend php artisan view:clear

# Criar storage link (caso necessário)
echo "🔗 Criando storage link..."
docker exec -it salesflow_backend php artisan storage:link

# Reiniciar os workers
echo "⚙️ Reiniciando workers..."
docker exec -it salesflow_backend php artisan queue:restart

# Configuração do Frontend
echo "🌍 Configurando o frontend..."

# Copiar .env do frontend caso não exista
docker exec -it salesflow_frontend sh -c 'test -f .env || cp .env.example .env'

# Atualizar a variável VITE_API_URL no frontend
docker exec -it salesflow_frontend sh -c 'echo "VITE_API_URL=http://localhost:8000/api" > .env'

# Instalar dependências do frontend
echo "📦 Instalando dependências do frontend..."
docker exec -it salesflow_frontend sh -c 'npm install'

# Rodar o build do frontend
echo "🛠️ Construindo frontend..."
docker exec -it salesflow_frontend sh -c 'npm run build'

# Iniciar o frontend
echo "🌍 Iniciando frontend..."
docker exec -it salesflow_frontend sh -c 'npm run dev &'

# Finalizando
echo "✅ Setup finalizado com sucesso! O projeto está pronto para uso."
echo "🌍 Backend rodando em http://localhost:8000"
echo "🖥️ Frontend rodando em http://localhost:5173"
