<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\HomeApiService;
use App\Helpers\DateHelper;
use App\Helpers\HeaderHelper;

class CategoriaController extends Controller
{
    protected $homeApiService;

    public function __construct(HomeApiService $homeApiService)
    {
        $this->homeApiService = $homeApiService;
    }

    public function show(Request $request, string $categoria): View
    {
        // Buscar todas as categorias para encontrar o ID pela tag ou nome
        $categorias = $this->homeApiService->fetchCategorias();
        
        $categoriaEncontrada = null;
        foreach ($categorias as $cat) {
            $tag = !empty($cat['tag']) ? $cat['tag'] : $cat['nome'];
            
            if (strtolower($tag) === strtolower($categoria) || 
                strtolower($cat['nome']) === strtolower($categoria)) {
                $categoriaEncontrada = $cat;
                break;
            }
        }

        // Se categoria não encontrada, abortar com 404
        if (!$categoriaEncontrada) {
            abort(404, 'Categoria não encontrada');
        }

        // Obter página atual da query string
        $page = $request->query('page', 1);
        $perPage = 10;

        // Buscar matérias da categoria com paginação
        $materiasResponse = $this->homeApiService->fetchMateriaCategoria(
            $categoriaEncontrada['id'],
            $perPage,
            $page
        );

        // Formatar datas das matérias
        if (isset($materiasResponse['data'])) {
            foreach ($materiasResponse['data'] as &$materia) {
                if (isset($materia['created_at'])) {
                    $materia['created_at_formatted'] = DateHelper::formatDate($materia['created_at']);
                }
                if (isset($materia['updated_at'])) {
                    $materia['updated_at_formatted'] = DateHelper::formatDate($materia['updated_at']);
                }
                if (isset($materia['dt_post'])) {
                    $materia['dt_post_formatted'] = DateHelper::formatDate($materia['dt_post']);
                }
            }
        }

        // Buscar últimas 5 matérias (gerais) para sidebar
        $ultimasMaterias = $this->homeApiService->fetchMateriasHome();
        $ultimasMaterias = array_slice($ultimasMaterias, 0, 5);

        // Formatar datas das últimas matérias
        foreach ($ultimasMaterias as &$materia) {
            if (isset($materia['created_at'])) {
                $materia['created_at_formatted'] = DateHelper::formatDate($materia['created_at']);
            }
        }

        // Filtrar categorias para menu
        $cats = [];
        foreach ($categorias as $cat) {
            if ($cat['type'] === "bd" && $cat['menu'] == 1) {
                $cats[] = $cat;
            }
        }

         $header = new HeaderHelper;

        /* Facebook */
        $fb = array(array("property" => "og:url", "content" => "https://www.aeranerd.com.br"),
            array("property" => "og:type", "content" => "website"),
            array("property" => "og:description",
                "content" => "Cinema, Games, Quadrinhos, Animes , Series & \n\r todas as nerdices em um único lugar "),
            array("property" => "og:image", "content" => "https://www.aeranerd.com.br/images/compartilhe-aeranerd.jpg"),
            array("property" => "fb:app_id", "content" => "276823869362187"),
            array("property" => "fb:admins", "content" => "100001458528712")
        );
        $header->setTitle("A Era Nerd | Cinema, Games, Quadrinhos, Animes , Series  & Nerdices");
        $header->addArrayMeta(array("name" => "description", "content" => "Portal de Cimema, Quadrinhos, Animes, Games ... e troços NERDS"));
        foreach ($fb as $f) {
            $header->addArrayMeta($f);
        }

        return view('pages.categoria', [
            'categoria' => $categoriaEncontrada,
            'materias' => $materiasResponse['data'] ?? [],
            'paginacao' => [
                'current_page' => $materiasResponse['current_page'] ?? 1,
                'last_page' => $materiasResponse['last_page'] ?? 1,
                'per_page' => $materiasResponse['per_page'] ?? 10,
                'total' => $materiasResponse['total'] ?? 0,
            ],
            'ultimasMaterias' => $ultimasMaterias,
            'header' => $header->getHeader(),
            'categorias' => $cats,
        ]);
    }

    public function showByTag($tag)
    {
        try {
            $header = new HeaderHelper;
            
            // Set SEO meta tags
            $header->setTitle("Tag: {$tag} | A Era Nerd");
            $header->addArrayMeta(array("name" => "description", "content" => "Matérias com a tag {$tag} - Portal de Cinema, Quadrinhos, Animes, Games e muito mais!"));
            
            // Open Graph tags
            $header->addArrayMeta(array("property" => "og:title", "content" => "Tag: {$tag} | A Era Nerd"));
            $header->addArrayMeta(array("property" => "og:type", "content" => "website"));
            $header->addArrayMeta(array("property" => "og:url", "content" => "https://www.aeranerd.com.br/tag/{$tag}"));
            
            // Fetch categories for menu
            $categorias = $this->homeApiService->fetchCategorias();
            $cats = [];
            foreach ($categorias as $cat) {
                if ($cat['type'] === "bd" && $cat['menu'] == 1) {
                    $cats[] = $cat;
                }
            }

            // Fetch materias by tag
            $materias = $this->homeApiService->fetchMateriasByTag($tag, 50);
            
            // Format dates
            foreach ($materias as &$materia) {
                if (isset($materia['dt_post'])) {
                    $materia['dt_post_formatted'] = DateHelper::formatDate($materia['dt_post']);
                }
            }

            // Fetch latest materias for sidebar
            $ultimasMaterias = $this->homeApiService->fetchMateriasHome();
            if (is_array($ultimasMaterias)) {
                $ultimasMaterias = array_slice($ultimasMaterias, 0, 5);
                foreach ($ultimasMaterias as &$mat) {
                    if (isset($mat['dt_post'])) {
                        $mat['dt_post_formatted'] = DateHelper::formatDate($mat['dt_post']);
                    }
                }
            }

            return view('pages.tag', [
                'tag' => $tag,
                'materias' => $materias,
                'ultimasMaterias' => $ultimasMaterias,
                'header' => $header->getHeader(),
                'categorias' => $cats,

                
            ]);

        } catch (\Exception $e) {
            Log::error('Error loading tag page: ' . $e->getMessage());
            abort(500, 'Erro ao carregar página da tag');
        }
    }
}
