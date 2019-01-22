<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Domains\Services\FeedService;

class FeedServiceTest extends TestCase
{
    /**
     * Testa se o serviço retornou um array com a lista de artigos.
     *
     * @return void
     */
    public function testIfExistResponseArticlesFromServiceRemote()
    {
    	$service = new FeedService();
    	$response = $service->serviceNewsFeedRemote();
    	$this->assertContains($response['articles'], $response);
    }

    /**
     * Testa se o serviço retornou um array com a lista 
     * de artigos ordenados por página.
     *
     * @return void
     */
    public function testIfExistResponseArticlesByPagesFromServiceRemote()
    {
    	$service = new FeedService();
    	$response = $service->serviceNewsFeedRemote();
    	$this->assertContains($response['articles_by_pages'], $response);
    }

    /**
     * Testa se o método que retorna a lista de artigos
     * retornou um array com a lista de artigos.
     *
     * @return void
     */
    public function testIfgetAllArticlesReturnListArticles()
    {
    	$service = new FeedService();
    	$response = $service->getNewsFeed();
    	$articles = $service->getAllArticles();
    	$this->assertEquals($articles, $response['articles']);
    }

    /**
     * Testa se o método que retorna o identificado por um id
     * retornou um array com os dados do respectivo artigo na lista.
     *
     * @return void
     */
    public function testIfgetArticleById()
    {
    	$service = new FeedService();
    	$response = $service->getArticleById(2);
    	$this->assertObjectHasAttribute('title', $response);
    	$this->assertObjectHasAttribute('description', $response);
    	$this->assertObjectHasAttribute('id', $response);
    	$this->assertObjectHasAttribute('page', $response);
    	$this->assertEquals(2, $response->id);
    }

    /**
     * Testa se o método que retorna a lista de artigos de uma
     * determinada página retornou a lista correspondente a página
     * que foi solicitada no parâmetro.
     *
     * @return void
     */
    public function testIfgetArticlesByPageIdReturnListPage()
    {
    	$service = new FeedService();
    	$response = $service->getArticlesByPageId(2);
    	$this->assertEquals(2, $response[0]->page);
    }
}
