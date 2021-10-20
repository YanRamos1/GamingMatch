<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use jcobhams\NewsApi\NewsApi;

class NewsController extends Controller
{
    public function index(){


        $secret = "792fd89a7dc04d6384b3be1b99625971";
        $newsapi = new NewsApi($secret);

        $this->news = $newsapi->getEverything("games", null, null, null, null, null, "pt", null,  null, null);

        (array)$this->news = $this->news->articles;



        return view('news.index', [
            'news' => $this->news,
        ]);
    }
}
