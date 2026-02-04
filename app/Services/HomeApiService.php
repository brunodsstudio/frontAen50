<?php

// app/Services/homeApiService.php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Helpers\PaginacaoHelper;
use Illuminate\Support\Facades\Storage;
use Exception;

class HomeApiService
{
    public function fetchMateriasHome()
    {
        try {
            $response = Http::timeout(10)->get(env('API_URL').'/MateriasHome'); //

            if ($response->successful()) {
                return $response->json();
            }

            // Handle API errors gracefully
            throw new Exception('External API request failed');

        } catch (\GuzzleHttp\Exception\RequestException $e) { // Catch Guzzle-specific exceptions
            // Log error or rethrow a custom exception
            \Log::error($e->getMessage());
            throw new Exception('Network error or API down');
        }
    }

    public function fetchCategorias()
    {
        try {
            $response = Http::timeout(10)->get(env('API_URL').'/areas?page=1&perPage=20'); //

            if ($response->successful()) {
                return $response->json();
            }

            // Handle API errors gracefully
            throw new Exception('External API request failed');

        } catch (\GuzzleHttp\Exception\RequestException $e) { // Catch Guzzle-specific exceptions
            // Log error or rethrow a custom exception
            \Log::error($e->getMessage());
            throw new Exception('Network error or API down');
        }
    }

    public function fetchMateriaCategoria(int $areaId, int $perpage = null, int $page = 1)
    {
        try {
         
            if($perpage === null){
                $perpage = 3;
            }

        
            $response = Http::timeout(10)->get(env('API_URL').'/MateriasCategoria?id_area='.$areaId.'&page='.$page.'&perPage='.$perpage.'&orderBy=created_at&orderDirection=desc'); //

            if ($response->successful()) {
                return $response->json();
            }

            // Handle API errors gracefully
            throw new Exception('External API request failed');

        } catch (\GuzzleHttp\Exception\RequestException $e) { // Catch Guzzle-specific exceptions
            // Log error or rethrow a custom exception
            \Log::error($e->getMessage());
            throw new Exception('Network error or API down');
        }
    }
    //http://127.0.0.1:3001/api/MateriasCategoria?id_area=1&page=1&perPage=10&orderBy=created_at&orderDirection=desc

    public function fetchVideos(int $areaId, int $perpage = null)
    {
        try {
         
            if($perpage === null){
                $perpage = 3;
            }

        
            $response = Http::timeout(10)->get(env('API_URL').'/videos?page=1&perPage='.$perpage); //

            if ($response->successful()) {
                return $response->json();
            }

            // Handle API errors gracefully
            throw new Exception('External API request failed');

        } catch (\GuzzleHttp\Exception\RequestException $e) { // Catch Guzzle-specific exceptions
            // Log error or rethrow a custom exception
            \Log::error($e->getMessage());
            throw new Exception('Network error or API down');
        }
    }

    public function fetchMateriaByLink(string $linkTitulo)
    {
        try {
            $response = Http::timeout(10)->get(env('API_URL') . '/MateriaByLink/' . urlencode($linkTitulo));

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('API error fetching materia by link: ' . $response->body());
            return null;
        } catch (Exception $e) {
            Log::error('Error fetching materia by link: ' . $e->getMessage());
            return null;
        }
    }

    public function fetchWriter(int $writerId)
    {
        try {
            $response = Http::timeout(10)->get(env('API_URL') . '/writers/' . $writerId);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('API error fetching writer: ' . $response->body());
            return null;
        } catch (Exception $e) {
            Log::error('Error fetching writer: ' . $e->getMessage());
            return null;
        }
    }

    public function fetchMateriasByTag(string $tag, int $limit = 3)
    {
        try {
            $response = Http::timeout(10)->get(env('API_URL') . '/MateriasByTag/' . urlencode($tag), [
                'limit' => $limit
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('API error fetching materias by tag: ' . $response->body());
            return [];
        } catch (Exception $e) {
            Log::error('Error fetching materias by tag: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Fetch galeria from backend API (proxy)
     * 
     * @param string $pastaS3 Nome da pasta no S3
     * @param int $pagina Número da página
     * @param int $quantidadePorPagina Quantidade de itens por página
     * @return array|null
     */
    public function fetchGaleria($pastaS3, $pagina = 1, $quantidadePorPagina = 25)
    {
        try {
            // Get token from session or config
            $token = session('api_token') ?? env('API_TOKEN');
            
            if (!$token) {
                // If no token, try to get from admin login
                $token = $this->getAdminToken();
            }

            $response = Http::timeout(30)
                ->withToken($token)
                ->get(env('API_URL') . '/Galerias/' . urlencode($pastaS3) . '/' . $pagina, [
                    'quantidadePorPagina' => $quantidadePorPagina
                ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('API error fetching galeria: ' . $response->body());
            return null;
        } catch (Exception $e) {
            Log::error('Error fetching galeria: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Fetch tags summary from API
     * 
     * @param int $limit Number of articles to analyze
     * @return array
     */
    public function fetchTagsSummary(int $limit = 50)
    {
        try {
            $response = Http::timeout(10)->get(env('API_URL') . '/materias/tags/summary', [
                'limit' => $limit
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['data'] ?? [];
            }

            Log::error('API error fetching tags summary: ' . $response->body());
            return [];
        } catch (Exception $e) {
            Log::error('Error fetching tags summary: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get admin token for server-side requests
     * 
     * @return string|null
     */
    private function getAdminToken()
    {
        try {
            $response = Http::timeout(10)->post(env('API_URL') . '/login', [
                'email' => env('API_ADMIN_EMAIL', 'admin@aeranerd.com'),
                'password' => env('API_ADMIN_PASSWORD')
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $token = $data['access_token'] ?? null;
                
                // Store token in session for reuse
                if ($token) {
                    session(['api_token' => $token]);
                }
                
                return $token;
            }

            return null;
        } catch (Exception $e) {
            Log::error('Error getting admin token: ' . $e->getMessage());
            return null;
        }
    }


}
