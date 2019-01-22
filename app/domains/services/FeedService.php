<?php

namespace App\Domains\Services;

use Illuminate\Support\Facades\Cache;

class FeedService
{
	private $numberOfPages = [];
	private $listFeed = [];
	private $urlFeed = "http://pox.globo.com/rss/g1/economia";

	public function getNewsFeed()
    {
		$newsFeed = [];
    	$articlesFeed = []; 
    	$articlesOrderByPage = []; 
    	
    	if (Cache::has('articles') && Cache::has('articles_by_pages')) {

    		$articlesFeed = Cache::get('articles'); 
    		$articlesOrderByPage = Cache::get('articles_by_pages');
    		$this->numberOfPages = Cache::get('number_of_pages');
    		
		    return [
				'articles' => $articlesFeed, 
				'articles_by_pages' => $articlesOrderByPage,
				'number_of_pages' => $this->numberOfPages
			];
		}

		$newsFeed = $this->serviceNewsFeedRemote();

		$articlesFeed = $newsFeed['articles'];
		$articlesOrderByPage = $newsFeed['articles_by_pages'];

		return [
			
			'number_of_pages' => $this->makeCacheFeed('number_of_pages', $this->numberOfPages),

			'articles' => $this->makeCacheFeed(
				'articles',$articlesFeed
			),

			'articles_by_pages' => $this->makeCacheFeed(
				'articles_by_pages',$articlesOrderByPage
			)
		];
    }

    public function serviceNewsFeedRemote()
    {
    	$articlesFeed = []; 
    	$articlesOrderByPage = []; 

    	$feed = file_get_contents($this->urlFeed);
		$rss =  new \SimpleXMLElement($feed);
		$counter = 0;
		$indexPage = 1;
		$indexArray = 0;

		foreach($rss->channel->item as $article) {

			if($counter == 10){
				$indexPage = $indexPage+1;
				$this->numberOfPages = $indexPage;
				$counter = 0;
			}
			
			$counter = $counter+1;

			$article->id = $indexArray++;
			$article->page = $indexPage;
			$articlesFeed[] = $article;
			$articlesOrderByPage['pages'][$indexPage][] = $article;
		}

		return [
			'articles' => $articlesFeed, 
			'articles_by_pages' => $articlesOrderByPage,
			'pages' => $this->numberOfPages
		];
    }

    /**
     * Retorna array de objetos com os 10 primeiros artigos
     * @return [array] $response
     */
    public function getAllArticlesFirstPage()
    {
    	$response = [];
    	$this->listFeed = $this->getNewsFeed();
    	if(!isset($this->listFeed['articles'])){
    		abort(403, 'not found news.');
    	}
    	$response['articles'] = array_slice($this->listFeed['articles'], 0, 10);
    	$response['number_of_pages'] = $this->listFeed['number_of_pages'];
    	return $response;	
    }

    public function getArticleById($id)
    {
    	$this->listFeed = $this->getNewsFeed();
    	if(!isset($this->listFeed['articles'][$id])){
    		abort(403, 'article requested not found.');
    	}
		return $this->listFeed['articles'][$id];
    }

    /**
     * @param  [int] $pageId
     * @return [array]
     */
    public function getArticlesByPageId($pageId)
    {
    	$this->listFeed = $this->getNewsFeed();
    	if(!isset($this->listFeed['articles_by_pages']->pages->$pageId)){
    		abort(403, 'page requested not found.');
    	}
    	return $this->listFeed['articles_by_pages']->pages->$pageId;
    }

    /**
     * Cria cache do dado pelo key/value definido no parâmetro
     * @param  [string] $listNameCache
     * @param  [array] $listName
     * @return [array]
     */
    public function makeCacheFeed($listNameCache, $listName)
    {
    	$expiresAt = now()->addMinutes(15);
		$listName = json_decode(json_encode($listName));
		Cache::put($listNameCache, $listName, $expiresAt);
		return Cache::get($listNameCache);
    }

}
