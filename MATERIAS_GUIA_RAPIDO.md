# 🚀 Guia Rápido - Sistema de Matérias

## Como Criar uma Matéria

### 1️⃣ Acessar o Grid
```
URL: /dashboard/materias
```
- Clique em **"Nova Matéria"** (botão azul no topo)

### 2️⃣ Preencher o Formulário

#### ✏️ Conteúdo Principal
1. **Título*** → Digite o título da matéria
2. **Subtítulo** → Adicione um subtítulo (opcional)
3. **Lead/Resumo** → Breve descrição para listagens
4. **Corpo da Matéria*** → Use o editor CKEditor:
   - Escreva o conteúdo
   - Formate com a barra de ferramentas
   - Adicione links, tabelas, listas
   - **Importante:** Imagens devem ser linkadas (não em BASE64)

#### 🔍 SEO (Auto-preenchido)
Os campos SEO são preenchidos automaticamente a partir do título:
- **Meta Title** → Título para Google (máx. 60 chars)
- **Meta Description** → Descrição para Google (máx. 160 chars)
- **Slug** → URL amigável (ex: minha-super-materia)
- **Open Graph** → Dados para redes sociais

**Dica:** Revise e ajuste os campos SEO para otimizar!

#### ⚙️ Configurações (Barra Lateral)
1. **Autor** → Nome do autor
2. **Categoria*** → Selecione a categoria (obrigatório)
3. **Tags** → Adicione tags relevantes (múltipla escolha)
4. **Data de Publicação** → Data/hora de publicação
5. **Publicar Online** → ✅ Ativo = visível no site

### 3️⃣ Salvar a Matéria
- Clique em **"Criar Matéria"** (botão verde)
- Aguarde a confirmação
- O ID da matéria é memorizado automaticamente

### 4️⃣ Gerenciar Imagens (Após Salvar)
- Clique em **"Gerenciar Imagens"** (botão roxo)

#### 🖼️ Imagens Destacadas
1. Clique em **"Upload"**
2. Selecione a imagem do seu computador
3. Clique em **"Definir Destaque"** para usar como capa
4. Localização: `/public/imagens/materias`
5. Registro: tabela `tb_aen_images`

#### ☁️ Imagens S3 (Corpo)
- Visualize imagens já enviadas para o S3
- Clique em **"Copiar URL"** para usar no corpo da matéria
- Cole a URL no editor usando o botão de link

---

## Como Editar uma Matéria

1. No grid `/dashboard/materias`, localize a matéria
2. Clique no botão **azul** (lápis) → Editar
3. Modifique os campos desejados
4. Clique em **"Atualizar Matéria"**

---

## Ações Disponíveis no Grid

| Botão | Cor | Ação |
|-------|-----|------|
| 📝 | Azul | Editar matéria |
| 👁️ / 👁️‍🗨️ | Verde/Laranja | Publicar/Despublicar |
| 🖼️ | Roxo | Gerenciar imagens |
| 🗑️ | Vermelho | Excluir matéria |

---

## Filtros e Busca

### 🔍 Buscar
- Digite no campo de busca (pesquisa por título)
- Aguarde 500ms para aplicar automaticamente

### 🎯 Filtros
- **Por Autor:** Selecione no dropdown
- **Por Status:** Online ou Offline
- **Limpar:** Clique em "Limpar Filtros"

### 📄 Paginação
- Selecione itens por página: 10, 25, 50 ou 100
- Navegue com as setas ← →

---

## ⚡ Dicas Importantes

### ✅ Campos Obrigatórios
- Título
- Categoria
- Corpo da matéria

### 💾 Salvamento do Corpo
- Conteúdo é convertido para **BASE64** automaticamente
- Suporta HTML completo
- Imagens devem ser **linkadas** (não embarcadas)

### 🖼️ Tipos de Imagem
1. **Imagem Destacada:** Capa, thumbnail, compartilhamento
2. **Imagens S3:** Dentro do conteúdo da matéria

### 🔐 Publicação
- **Online = OFF:** Matéria não aparece no site
- **Online = ON:** Matéria visível para o público

### 📱 Auto-preenchimento
- **Slug:** Gerado do título automaticamente
- **Meta Title:** Copia o título (limitado)
- **OG Title:** Copia o Meta Title

---

## 🆘 Problemas Comuns

### ❌ "Erro ao salvar matéria"
- Verifique se preencheu os campos obrigatórios
- Confirme que está autenticado (token JWT)
- Verifique a conexão com a API

### ❌ "Salve a matéria antes de gerenciar imagens"
- Primeiro salve a matéria clicando em "Criar Matéria"
- Depois acesse "Gerenciar Imagens"

### ❌ Editor não aparece
- Certifique-se de que o CKEditor foi instalado
- Execute: `npm install` na pasta do projeto

---

## 📞 API Endpoints

```
GET    /api/materias              → Listar
GET    /api/materias/:id          → Obter uma
POST   /api/materias              → Criar
PUT    /api/materias/:id          → Atualizar
DELETE /api/materias/:id          → Excluir
PATCH  /api/materias/:id          → Toggle online
GET    /api/areas                 → Categorias
GET    /api/tags                  → Tags
GET    /api/materias/autores      → Autores
```

---

**✨ Sistema criado com sucesso!**  
Para mais detalhes técnicos, consulte: `MATERIAS_SISTEMA_README.md`
