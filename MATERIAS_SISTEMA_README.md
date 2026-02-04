# Sistema de Gerenciamento de Matérias

Sistema completo para cadastro e gerenciamento de matérias do AERANERD, incluindo editor CKEditor, campos SEO e gerenciamento de imagens.

## 📁 Estrutura de Arquivos Criados

```
frontAen50/resources/js/
├── Pages/
│   └── Dashboard/
│       ├── Materias.vue          # Grid com listagem de matérias
│       └── Materias/
│           ├── Form.vue          # Formulário de criar/editar
│           └── Imagens.vue       # Gerenciamento de imagens
└── Composables/
    └── useMateriaState.js        # Estado global da matéria
```

## 🎯 Funcionalidades Implementadas

### 1. Grid de Matérias (`/dashboard/materias`)
- ✅ Listagem paginada de matérias
- ✅ Filtros por título, autor e status (Online/Offline)
- ✅ Busca com debounce
- ✅ Ações: Editar, Toggle Online/Offline, Gerenciar Imagens, Excluir
- ✅ Interface similar ao grid de Eventos

### 2. Formulário de Matérias (`/dashboard/materias/criar` e `/dashboard/materias/editar/:id`)

#### Campos da Matéria:
- **Título** (obrigatório, máx. 200 caracteres)
- **Subtítulo** (máx. 250 caracteres)
- **Lead/Resumo** (resumo para listagens)
- **Corpo** (editor CKEditor com HTML, salvo em BASE64)
- **Autor**
- **Categoria/Área** (obrigatório, dropdown com áreas da API)
- **Tags** (seleção múltipla)
- **Data de Publicação**
- **Status Online** (switch para publicar/despublicar)

#### Campos SEO Completos:
- **Meta Title** (título para buscadores, máx. 60 caracteres)
- **Meta Description** (descrição para buscadores, máx. 160 caracteres)
- **Meta Keywords** (palavras-chave separadas por vírgula)
- **Slug** (URL amigável, gerado automaticamente do título)
- **Canonical URL** (URL canônica para evitar conteúdo duplicado)
- **Open Graph Title** (título ao compartilhar em redes sociais)
- **Open Graph Description** (descrição ao compartilhar)
- **Open Graph Image** (URL da imagem social)
- **Open Graph Type** (tipo: article, website, blog)

#### Editor CKEditor 5:
- ✅ Editor WYSIWYG completo
- ✅ Toolbar com: cabeçalhos, negrito, itálico, sublinhado, listas, links, tabelas
- ✅ Botão "Ver código HTML" para edição avançada
- ✅ Conteúdo salvo em BASE64
- ✅ Imagens do corpo NÃO em BASE64 (linkadas do S3)

### 3. Gerenciamento de Imagens (`/dashboard/materias/:id/imagens`)

#### Imagens Destacadas:
- Local: `/public/imagens/materias`
- Banco: `tb_aen_images`
- Funcionalidades:
  - Upload de imagens
  - Definir como imagem de destaque
  - Excluir imagens
  - Referência via `int_id_imagem_destaque`

#### Imagens S3 (Corpo da Matéria):
- Local: Pasta S3 da AWS
- Listagem de todas as imagens da pasta
- Copiar URL para usar no corpo da matéria
- **Importante:** Imagens linkadas, não em BASE64

### 4. Estado Memorizado (`useMateriaState`)
- ✅ Composable global para armazenar ID da matéria
- ✅ Memoriza após criar ou editar
- ✅ Permite acesso ao gerenciamento de imagens
- ✅ Compartilhado entre componentes

## 🚀 Rotas Criadas

```php
// web.php
Route::middleware([RequireJwt::class])->group(function () {
    Route::get('/dashboard/materias', ...)->name('dashboard.materias');
    Route::get('/dashboard/materias/criar', ...)->name('dashboard.materias.criar');
    Route::get('/dashboard/materias/editar/{id}', ...)->name('dashboard.materias.editar');
    Route::get('/dashboard/materias/{id}/imagens', ...)->name('dashboard.materias.imagens');
});
```

## 📦 Dependências Instaladas

```bash
npm install @ckeditor/ckeditor5-vue @ckeditor/ckeditor5-build-classic
```

## 🔧 Configuração

### Variáveis de Ambiente
```env
VITE_API_URL=http://127.0.0.1:3001/api
```

### API Endpoints Utilizados
- `GET /api/materias` - Listar matérias
- `GET /api/materias/:id` - Obter matéria
- `POST /api/materias` - Criar matéria
- `PUT /api/materias/:id` - Atualizar matéria
- `PATCH /api/materias/:id` - Atualizar parcial
- `DELETE /api/materias/:id` - Excluir matéria
- `GET /api/materias/autores` - Listar autores
- `GET /api/areas` - Listar áreas/categorias
- `GET /api/tags` - Listar tags
- `GET /api/materias/:id/imagens-destacadas` - Listar imagens destacadas
- `GET /api/materias/:id/imagens-s3` - Listar imagens S3
- `POST /api/materias/:id/upload-imagem-destacada` - Upload imagem
- `DELETE /api/imagens/:id` - Excluir imagem

## 💡 Fluxo de Uso

### Criar Nova Matéria:
1. Acesse `/dashboard/materias`
2. Clique em "Nova Matéria"
3. Preencha os campos obrigatórios (Título, Categoria, Corpo)
4. Preencha os campos SEO (auto-preenchidos a partir do título)
5. Clique em "Criar Matéria"
6. O ID da matéria é memorizado automaticamente
7. Use "Gerenciar Imagens" para fazer upload de imagens destacadas

### Editar Matéria:
1. No grid, clique no botão de editar (lápis azul)
2. Modifique os campos necessários
3. Clique em "Atualizar Matéria"
4. Use "Gerenciar Imagens" para adicionar/remover imagens

### Gerenciar Imagens:
1. Após criar/editar, clique em "Gerenciar Imagens"
2. **Imagens Destacadas:** Faça upload, defina como destaque
3. **Imagens S3:** Visualize e copie URLs para usar no corpo

## ⚠️ Observações Importantes

### BASE64 no Corpo:
- O conteúdo do editor é convertido para BASE64 antes de salvar
- Usar `btoa(unescape(encodeURIComponent(conteudo)))` para codificar
- Usar `atob(conteudo)` para decodificar ao carregar

### Imagens:
- **Destacadas:** Armazenadas localmente, registradas em `tb_aen_images`
- **Corpo:** Linkadas do S3, NÃO em BASE64 (otimização)

### Auto-preenchimento SEO:
- `seo_slug`: Gerado automaticamente do título
- `seo_title`: Auto-preenchido com o título (limitado a 60 chars)
- `seo_og_title`: Auto-preenchido com o seo_title

### Validações:
- Título obrigatório
- Categoria obrigatória
- Corpo obrigatório
- Meta Description máx. 160 caracteres
- Meta Title máx. 60 caracteres

## 🔐 Autenticação

Todas as rotas de matérias exigem autenticação JWT (`RequireJwt` middleware).

## 🎨 Interface

- Design baseado em Vuetify 3
- Responsivo (mobile-first)
- Cards laterais fixos (sticky) no formulário
- Tooltips nos botões de ação
- Feedback visual de loading e salvamento

## 📝 Próximos Passos (Não Implementados)

- [ ] Implementar endpoints de API no backend (se não existirem)
- [ ] Sistema de versionamento de matérias
- [ ] Preview da matéria antes de publicar
- [ ] Agendamento de publicação
- [ ] Sistema de revisão/aprovação
- [ ] Editor de imagens inline no CKEditor
- [ ] Análise SEO em tempo real

## 🐛 Troubleshooting

### Erro ao salvar conteúdo:
- Verifique se o endpoint da API está correto
- Confirme que o token JWT está válido
- Verifique os logs do console

### CKEditor não aparece:
- Certifique-se de que as dependências foram instaladas
- Execute `npm install` novamente se necessário

### Imagens não carregam:
- Verifique permissões da pasta `/public/imagens/materias`
- Confirme configuração do S3 no backend

---

**Criado por:** GitHub Copilot  
**Data:** 01/02/2026  
**Versão:** 1.0.0
