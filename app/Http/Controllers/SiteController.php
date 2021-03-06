<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class SiteController extends Controller
{
    const API_BASE = 'https://blog-api.stmik-amikbandung.ac.id/api/v2/blog/_table/';
    const API_KEY = 'ef9187e17dce5e8a5da6a5d16ba760b75cadd53d19601a16713e5b7c4f683e1b';
    private $apiClient;

    public function __construct() {
        $this->apiClient = new Client([
            'base_uri' => self::API_BASE,
            'headers' => [
                'X-DreamFactory-API-Key' => self::API_KEY
            ]
        ]);
    }
    
    public function index() {        
        $data = Cache::get('index', function() {
            try {
                $reqData = $this->apiClient->get('articles');
                $resource = json_decode($reqData->getBody())->resource;
                
                Cache::add('index', $resource);
                return $resource;
            } catch(Exception $e) {
                return [];
            }
        }); 

        return view('home', ['data' => $data]);
    }

    public function getArticles($id) {
        $key = "articles/{$id}";

        $data = Cache::get($key, function() use ($key) {
            try {
                $reqData = $this->apiClient->get($key);
                $resource = json_decode($reqData->getBody());

                Cache::add($key, $resource);
                return $resource;
            } catch(Exception $e) {
                abort(404);
            }
        });
        
        $comments = $this->comments($data->id);

        return view('viewArticle', ['data' => $data, 'comments' => $comments]);
    }

    public function newArticles(Request $request) {
        if ($request->isMethod('post')) {
            $title = $request->input('frm-title');
            $content = $request->input('frm-content');
            $dataModel = [
                'resource' => []
            ];

            $dataModel['resource'][] = [
                'author' => '12',
                'title' => $title,
                'content' => $content
            ];

            try {
                $reqData = $this->apiClient->post('articles', [
                    'json' => $dataModel
                ]);
                $apiResponse = json_decode($reqData->getBody())->resource;
                $newId = $apiResponse[0]->id;

                Cache::forget('index');

                return redirect("articles/{$newId}");
            } catch (Exception $e) {
                abort(501);
            }
        }

        return view('newArticle');
    }

    public function updateArticles(Request $request, $id) {
        $key = "articles/{$id}";
        Cache::forget($key);
        $data = Cache::get($key, function () use ($key) {
            try {
                $reqData = $this->apiClient->get($key);
                $resource = json_decode($reqData->getBody());

                Cache::add($key, $resource);
                return $resource;
            } catch (Exception $e) {
                abort(404);
            }
        });

        if ($request->isMethod('patch')) {
            $ida = $request->input('idf');
            $title = $request->input('frm-title');
            $content = $request->input('frm-content');

            $dataModel = [
                'resource' => []
            ];
            $dataModel['resource'][] = [
                'id' => $ida,
                'title' => $title,
                'content' => $content
            ];

            $reqData = $this->apiClient->patch("articles", [
                'json' => $dataModel
            ]);       

            $resource = $dataModel['resource'][0];
            
            Cache::add($key, $resource);
            Cache::forget('index');
            Cache::forget($key);

            return redirect('home');
        }

        return view('updateArticle', ['data' => $data]);
    }

    public function deleteArticles($id) {
        $dataModel = [
            'resource' => []
        ];

        $dataModel['resource'][] = [
            'id'=>$id
        ];
        $key = "articles/{$id}";
        try{
            $reqData = $this->apiClient->delete("articles/{$id}", [
                'json' => $dataModel
            ]);

            Cache::forget('index');
            Cache::forget($key);
            
            return redirect('home');
        } catch(Exception $e){
            abort(501);
        }
    }

    public function newComment(Request $request) {
        
        if($request->isMethod('post')) {
            //2. Ambil nama authornya dulu dongzz dari login
            $article_id = $request->input('frm-article-id');
            $author = $request->input('frm-author');
            $comment = $request->input('frm-comment');

            $dataModel = [
                'resource' => []
            ];

            $dataModel['resource'][] = [
                'article' => $article_id,
                'author' => $author,
                'content' => $comment,
            ];

            try {
                $reqData = $this->apiClient->post('comments', [
                    'json' => $dataModel
                ]);
                $apiResponse = json_decode($reqData->getBody())->resource;
                $newId = $apiResponse[0]->id;

                Cache::forget('index');

                return redirect("articles/{$article_id}");
            } catch (Exception $e) {
                abort(501);
            }
        }

        return redirect('home');
    }

    public function seeComment() {
        $com = Cache::get('index', function () {
            try {
                $reqData = $this->apiClient->get('comments');
                $resource = json_decode($reqData->getBody())->resource;

                Cache::add('index', $resource);
                return $resource;
            } catch (Exception $e) {
                return [];
            }
        });

        return view('comment', ['cm' => $com]);
    }

    public function getComment()
    {
        Cache::forget('comments');
        return Cache::get('comments', function() {
            try {
                $reqData = $this->apiClient->get('comments');
                $resource = json_decode($reqData->getBody())->resource;
                
                Cache::add('comments', $resource);
                return $resource;
            } catch(Exception $e) {
                return [];
            }
        }); 

    }

    public function comments(int $articleID)
    {
        $data = $this->getComment();
        $hasil = [];
        foreach ($data as $key) {
            if($key->article === $articleID){
                $hasil[] = $key;
            }
        }
        return $hasil;
    }
}
