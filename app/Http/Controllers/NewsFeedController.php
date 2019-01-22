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

    public function index()
    {
		$response = $this->serviceFeed->getAllArticles(); 
		return response()->json($response);
    }

    public function show($id)
    {
		$response = $this->serviceFeed->getArticleById($id);
		return response()->json($response);
    }

    public function showByPage($pageId)
    {
    	$response = $this->serviceFeed->getArticlesByPageId($pageId);
    	return response()->json($response);
    }

}
