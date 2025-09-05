<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;


class ApiProxyController extends Controller
{
    public function handle(Request $request, string $any)
    {
        $base = rtrim(config('services.api.url', env('API_URL')), '/');
        $url = $base.'/'.ltrim($any, '/');


        $method = strtoupper($request->getMethod());


        $client = Http::withHeaders([
        'Accept' => 'application/json',
    ]);


    if ($token = $request->cookie('jwt')) {
        $client = $client->withToken($token);
    }


// Encaminha corpo/query/arquivos
    $options = [];
    if (in_array($method, ['POST','PUT','PATCH'])) {
        if ($request->hasFile(null)) {
            $options['multipart'] = [];
            foreach ($request->allFiles() as $key => $files) {
                $files = is_array($files) ? $files : [$files];
                foreach ($files as $file) {
                    $options['multipart'][] = [
                        'name' => $key,
                        'contents' => fopen($file->getRealPath(), 'r'),
                        'filename' => $file->getClientOriginalName(),
                        'headers' => ['Content-Type' => $file->getMimeType()],
                        ];
                }
            }
            foreach ($request->except(array_keys($request->allFiles())) as $key => $val) {
                $options['multipart'][] = [ 'name' => $key, 'contents' => is_scalar($val) ? $val : json_encode($val) ];
            }
        } else {
            $options['json'] = $request->all();
        }
    }


    $options['query'] = $request->query();

    $response = $client->send($method, $url, $options);

    return new Response(
        $response->body(),
        $response->status(),
            array_merge(
                ['Content-Type' => $response->header('Content-Type', 'application/json')],
                // Propaga headers úteis da API
                $response->headers()
            )
        );
    }
}