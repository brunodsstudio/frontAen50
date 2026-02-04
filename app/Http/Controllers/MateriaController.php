<?php

namespace App\Http\Controllers;

use App\Services\HomeApiService;
use App\Helpers\DateHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\View\View;
use App\Helpers\HeaderHelper;

class MateriaController extends Controller
{
    protected $homeApiService;

    public function __construct(HomeApiService $homeApiService)
    {
        $this->homeApiService = $homeApiService;
    }

    public function show($linkTitulo)
    {
        try {
            // Fetch categories for menu
            $categorias = $this->homeApiService->fetchCategorias();


            
            $cats = [];
            foreach ($categorias as $key => $categoria) {
                if($categoria['type'] === "bd" && $categoria['menu'] == 1) {
                    $cats[] = $categoria;  
                }
            }

          

            // Fetch materia data
            $materia = $this->homeApiService->fetchMateriaByLink($linkTitulo);


            $header = new HeaderHelper;

           
            
            if (!$materia) {
                abort(404, 'Matéria não encontrada');
            }

            // Decode BASE64 content
            if (isset($materia['vchr_conteudo'])) {
                $materia['content_decoded'] = base64_decode($materia['vchr_conteudo']);
            }

            // Format date
            if (isset($materia['dt_post'])) {
                $materia['dt_post_formatted'] = DateHelper::formatDate($materia['dt_post']);
            }

            // Get Top_Materia image
            $featuredImage = null;
            if (isset($materia['images']) && is_array($materia['images'])) {
                foreach ($materia['images'] as $img) {
                    if ($img['vchr_Tipo'] === 'Top_Materia') {
                        $featuredImage = $img;
                        break;
                    }
                }
            }

            // Get writer data
            $writer = null;
            if (isset($materia['int_autor'])) {
                $writer = $this->homeApiService->fetchWriter($materia['int_autor']);
            }

            // Parse tags
            $tags = [];
            if (isset($materia['vchr_tags'])) {
                $tags = array_filter(explode(',', $materia['vchr_tags']), function($tag) {
                    return !empty(trim($tag));
                });
                $tags = array_map('trim', $tags);
            }

            // Get related articles by first tag
            $relatedArticles = [];
            if (count($tags) > 0) {
                $firstTag = $tags[0];
                $relatedArticles = $this->homeApiService->fetchMateriasByTag($firstTag, 3);
                
                // Remove current article from related
                $relatedArticles = array_filter($relatedArticles, function($article) use ($materia) {
                    return $article['id'] !== $materia['id'];
                });
                
                // Format dates
                foreach ($relatedArticles as &$article) {
                    if (isset($article['dt_post'])) {
                        $article['dt_post_formatted'] = DateHelper::formatDate($article['dt_post']);
                    }
                }
            }

            // Get sidebar articles (5 latest)
            $sidebarArticles = $this->homeApiService->fetchMateriasHome();
            if (is_array($sidebarArticles)) {
                $sidebarArticles = array_slice($sidebarArticles, 0, 5);
                foreach ($sidebarArticles as &$article) {
                    if (isset($article['dt_post'])) {
                        $article['dt_post_formatted'] = DateHelper::formatDate($article['dt_post']);
                    }
                }
            }


             if($materia['id_area'] == 11){ //galeria de cosplay
                $viewName = 'pages.galeria';
                
                // Fetch first page of galeria
                $galeriaData = $this->homeApiService->fetchGaleria($materia['vchr_s3_storage'], 1);
                
                $galeria = [
                    'pastaS3' => $materia['vchr_s3_storage'],
                    'firstPageData' => $galeriaData,
                    'apiUrl' => env('API_URL', 'http://127.0.0.1:3001/api')
                ];
            } else { //outras
                $viewName = 'pages.materia';
                $galeria = null;
            }

            // Prepare SEO and social media sharing meta tags
            $pageTitle = $materia['vchr_titulo'] ?? 'A Era Nerd';
            $pageDescription = $materia['vchr_Lide'] ?? 'Portal de Cinema, Quadrinhos, Animes, Games e muito mais conteúdo nerd!';
            $pageUrl = 'https://www.aeranerd.com.br/' . ($materia['vchr_LinkTitulo'] ?? '');
            
            // Get the best image for social sharing
            $socialImage = 'https://www.aeranerd.com.br/images/compartilhe-aeranerd.jpg';
            if (isset($materia['images']) && is_array($materia['images']) && count($materia['images']) > 0) {
                // Try to find Slider_Home or Top_Materia image first
                foreach ($materia['images'] as $img) {
                    if (!empty($img['vchr_ImgLink'])) {
                        $socialImage = 'https://www.aeranerd.com.br/images/' . $img['vchr_ImgLink'];
                        break;
                    }
                }
            }

            // Set page title
            $header->setTitle($pageTitle . ' | A Era Nerd');
            
            // Basic meta tags
            $header->addArrayMeta(array("name" => "description", "content" => $pageDescription));
            $header->addArrayMeta(array("name" => "keywords", "content" => implode(', ', $tags)));
            
            // Open Graph (Facebook, WhatsApp, LinkedIn)
            $header->addArrayMeta(array("property" => "og:type", "content" => "article"));
            $header->addArrayMeta(array("property" => "og:url", "content" => $pageUrl));
            $header->addArrayMeta(array("property" => "og:title", "content" => $pageTitle));
            $header->addArrayMeta(array("property" => "og:description", "content" => $pageDescription));
            $header->addArrayMeta(array("property" => "og:image", "content" => $socialImage));
            $header->addArrayMeta(array("property" => "og:image:width", "content" => "1200"));
            $header->addArrayMeta(array("property" => "og:image:height", "content" => "630"));
            $header->addArrayMeta(array("property" => "og:site_name", "content" => "A Era Nerd"));
            $header->addArrayMeta(array("property" => "og:locale", "content" => "pt_BR"));
            
            // Article specific Open Graph tags
            if (isset($materia['dt_post'])) {
                $header->addArrayMeta(array("property" => "article:published_time", "content" => $materia['dt_post']));
            }
            if (isset($materia['vchr_area'])) {
                $header->addArrayMeta(array("property" => "article:section", "content" => $materia['vchr_area']));
            }
            foreach ($tags as $tag) {
                $header->addArrayMeta(array("property" => "article:tag", "content" => $tag));
            }
            
            // Facebook specific
            $header->addArrayMeta(array("property" => "fb:app_id", "content" => "276823869362187"));
            $header->addArrayMeta(array("property" => "fb:admins", "content" => "100001458528712"));
            
            // Twitter Card
            $header->addArrayMeta(array("name" => "twitter:card", "content" => "summary_large_image"));
            $header->addArrayMeta(array("name" => "twitter:site", "content" => "@aeranerd"));
            $header->addArrayMeta(array("name" => "twitter:title", "content" => $pageTitle));
            $header->addArrayMeta(array("name" => "twitter:description", "content" => $pageDescription));
            $header->addArrayMeta(array("name" => "twitter:image", "content" => $socialImage));

            return view($viewName, [
                'materia' => $materia,
                
                'featuredImage' => $featuredImage,
                'writer' => $writer,
                'tags' => $tags,
                'relatedArticles' => array_values($relatedArticles),
                'sidebarArticles' => $sidebarArticles,
                'categoria' => $materia['vchr_area'] ?? 'Artigos',
                'categorias' => $cats,
                'header' => $header->getHeader(),
            
                'galeria' => $galeria // Add galeria data
            ]);

        } catch (\Exception $e) {
            Log::error('Error loading materia: ' . $e->getMessage());
            abort(500, 'Erro ao carregar matéria');
        }
    }

    /**
     * Proxy endpoint for galeria infinite scroll
     * Makes server-side request to backend API
     */
    public function galeriaProxy($pastaS3, $pagina)
    {
        try {
            $quantidadePorPagina = request()->query('quantidadePorPagina', 25);
            
            $galeriaData = $this->homeApiService->fetchGaleria(
                $pastaS3, 
                $pagina, 
                $quantidadePorPagina
            );

            if (!$galeriaData) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao buscar galeria'
                ], 500);
            }

            // Return data in the format expected by infinite scroll
            return response()->json($galeriaData);

        } catch (\Exception $e) {
            Log::error('Error in galeria proxy: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar galeria'
            ], 500);
        }
    }
}
