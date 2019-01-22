<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Domains\Services\FeedService;

class NewsFeedController extends Controller
{

    private $serviceFeed;

	public function __construct(FeedService $feed)
    {
        $this->serviceFeed = $feed;
    }

    /**
     * Retorna lista de artigos, apenas primeira página
     * contendo 10 itens, e o número total de páginas
     * @return $response [json]
     */
    public function index()
    {
		$response = $this->serviceFeed->getAllArticlesFirstPage(); 
		return response()->json($response);
    }

    /**
     * Retorna artigo específico de acordo com id
     * enviado como parâmetro
     * @param  $id [int]
     * @return $response [json]
     */
    public function show($id)
    {
		$response = $this->serviceFeed->getArticleById($id);
		return response()->json($response);
    }

    /**
     * Retorna página com 10 artigos de acordo com com 
     * pageId enviado como parâmetro
     * @param  $pageId [int]
     * @return $response [json]
     */
    public function showByPage($pageId)
    {
    	$response = $this->serviceFeed->getArticlesByPageId($pageId);
    	return response()->json($response);
    }

}
