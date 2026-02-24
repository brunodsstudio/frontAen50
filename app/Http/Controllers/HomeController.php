<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

use App\Services\HomeApiService;
use App\Helpers\DateHelper;
use App\Helpers\HeaderHelper;

class HomeController extends Controller
{
    /**
     * Display the user's profile form.
     */
     protected $homeApiService;

    public function __construct(HomeApiService $homeApiService)
    {
        $this->homeApiService = $homeApiService;
    }

    public function show(Request $request): View
    {
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


        $thisViewAssign = [];
        $materiasHome = $this->homeApiService->fetchMateriasHome();
        
        // Formata as datas das matérias para dd-mm-yyyy
        foreach ($materiasHome as &$materia) {
            if (isset($materia['created_at'])) {
                $materia['created_at_formatted'] = DateHelper::formatDate($materia['created_at']);
            }
            if (isset($materia['updated_at'])) {
                $materia['updated_at_formatted'] = DateHelper::formatDate($materia['updated_at']);
            }
            if (isset($materia['data_publicacao'])) {
                $materia['data_publicacao_formatted'] = DateHelper::formatDate($materia['data_publicacao']);
            }
        }
        
        $categorias = $this->homeApiService->fetchCategorias();
     //dd($materiasHome);

        $matCosplay = $this->homeApiService->fetchMateriaCategoria(11);
        $matGames = $this->homeApiService->fetchMateriaCategoria(2);
        $matCritica = $this->homeApiService->fetchMateriaCategoria(13, 10);
        $videos = $this->homeApiService->fetchVideos(3);
        $tagsSummary = $this->homeApiService->fetchTagsSummary(100);

        foreach ($matCritica['data'] as &$materiacrítica) {
            if (isset($materiacrítica['created_at'])) {
                $materiacrítica['created_at_formatted'] = DateHelper::formatDate($materiacrítica['created_at']);
            }
            if (isset($materiacrítica['updated_at'])) {
                $materiacrítica['updated_at_formatted'] = DateHelper::formatDate($materiacrítica['updated_at']);
            }
            if (isset($materiacrítica['data_publicacao'])) {
                $materiacrítica['data_publicacao_formatted'] = DateHelper::formatDate($materiacrítica['data_publicacao']);
            }
        }
       

        foreach ($materiasHome as &$materiaHome) {
            if (isset($materiaHome['dt_post'])) {
                $materiaHome['dt_post_formatted'] = DateHelper::formatDate($materiaHome['dt_post']);
            }
        
        }

        foreach ($videos['data'] as &$vds) {
            if (isset($vds['dt_Publicado'])) {
                $vds['dt_Publicado_formatted'] = DateHelper::formatDate($vds['dt_Publicado']);
            }
        
        }

        

        //dd($matCritica['data']);
        
        $cats = [];
        foreach ($categorias as $key => $categoria) {
            if($categoria['type'] === "bd" && $categoria['menu'] == 1) {
              $cats[] = $categoria;  
            }
        }
        $thisViewAssign['categorias'] = $cats;

        //dd($videos['data']);

        $thisViewAssign['header'] = $header->getHeader();
        $thisViewAssign['matCosplay'] = $matCosplay['data'];
        $thisViewAssign['matGames'] = $matGames['data'];
        $thisViewAssign['materiasHome'] = $materiasHome;

        $thisViewAssign['matCritica'] = $matCritica['data'];
        $thisViewAssign['videos'] = $videos['data'];
        $thisViewAssign['tagsSummary'] = $tagsSummary;

       // dd($materiasHome);


        //dd($thisViewAssign);
        return view('pages.home',$thisViewAssign );
    }

    
    public function showteste(Request $request): View{
        dd($request->all());
    }

   public function showLogin()
    {
        //return Inertia::render('Auth/Login');
    }

}