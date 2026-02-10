# Instruções para Limpar Cache e Configurar Upload

## Problemas Corrigidos

1. ✅ **Erro 413 (Content Too Large)**: Adicionada compressão de imagens e aumentados limites PHP
2. ✅ **jQuery fadeIn/fadeOut**: Trocado jQuery slim pela versão completa
3. ✅ **Componentes Vuetify**: Atualizado DashboardSidebar para Vuetify 3

## ⚠️ IMPORTANTE: Configurar Nginx (se aplicável)

Se você estiver usando **Nginx**, o erro 413 pode continuar. Configure:

```nginx
# Em /etc/nginx/nginx.conf ou no bloco server do seu site:
http {
    client_max_body_size 50M;
    # ... resto da configuração
}

# Ou dentro do bloco server:
server {
    client_max_body_size 50M;
    # ... resto da configuração
}
```

**Após editar, reinicie o Nginx:**
```bash
sudo systemctl restart nginx
# ou
sudo service nginx restart
```

## Limpar Cache do Navegador

Os erros do DashboardSidebar.vue (v-list-item-content, v-list-item-icon) são **cache do navegador**.

### Solução Rápida:

1. **No navegador**, pressione:
   - **Chrome/Edge**: `Ctrl + Shift + Delete` (ou `Cmd + Shift + Delete` no Mac)
   - Selecione "Imagens e arquivos em cache"
   - Clique em "Limpar dados"

2. **Ou force refresh**:
   - `Ctrl + F5` (Windows/Linux)
   - `Cmd + Shift + R` (Mac)

### Limpar Cache do Vite/Laravel:

```bash
# No terminal WSL, dentro da pasta frontAen50:
pnpm run build
# ou
npm run build

# Limpar cache do Laravel (se necessário):
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## Verificar Alterações

Após limpar o cache:

1. **Upload de Imagem**: Tente fazer upload novamente - agora com compressão automática
2. **jQuery**: Os erros de fadeIn/fadeOut devem desaparecer
3. **Vuetify**: Os warnings do Vue sobre componentes devem sumir

## Limites Configurados

- Upload máximo (Laravel): **50MB**
- Post máximo (PHP): **50MB**
- Tempo de execução: **300 segundos**
- Compressão de imagem: **85% de qualidade JPEG**
- Dimensão máxima: **2560px**
- **Nginx**: Configurar `client_max_body_size 50M` (se aplicável)
