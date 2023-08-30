<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use GuzzleHttp\Client;
use App\Models\Comment;

class extract_post_comments_data extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:extract_post_comments_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Загружает список записей и комментариев в БД';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $Client = new Client([
            'base_uri' => "https://jsonplaceholder.typicode.com/",
            'timeout' => 20.0,
            'verify' => false,
        ]);

        try {
            $posts = $this->postUploader($Client);
            $comments = $this->commentUploader($Client);
            echo("Загружено " . $posts . " записей и " . $comments . " комментариев");
        } catch (\Exception $e) {
            echo("Ошибка при загрузке данных: " . $e->getMessage());
        }
    }

    private function postUploader(Client $Client): int{
        $response = $this->sendRequest($Client, '/posts');
        
        $requestDB = [];

        $dataIncomes = $this->parseResponse($response);
        
        foreach ($dataIncomes as $income) {
            $incomesDataDB = [
                'id' => $income->id, 
                'user_id' => $income->userId, 
                'title' => $income->title, 
                'body' => $income->body, 
            ];
        
            $requestDB[] = $incomesDataDB;
        }

        $this->savePostsToDB($requestDB);

        return count($dataIncomes);
    }

    private function commentUploader(Client $Client): int{
        $response = $this->sendRequest($Client, '/comments');
        
        $requestDB = [];
        
        $dataIncomes = $this->parseResponse($response);
        
        foreach ($dataIncomes as $income) {
            $incomesDataDB = [
                'id' => $income->id, 
                'post_id' => $income->postId, 
                'name' => $income->name, 
                'email' => $income->email,
                'body' => $income->body, 
            ];
        
            $requestDB[] = $incomesDataDB;
        }
        
        $this->saveCommentsToDB($requestDB);

        return count($dataIncomes);
    }

    private function sendRequest(Client $Client, string $path)
    {
        return $Client->request('GET', $path);
    }

    private function parseResponse($response)
    {
        return json_decode($response->getBody()->getContents());
    }

    private function savePostsToDB(array $postsData)
    {
        foreach(array_chunk($postsData, 10) as $request){
            Post::upsert($request, ['id']);
        }
    }

    private function saveCommentsToDB(array $commentsData)
    {
        foreach(array_chunk($commentsData, 10) as $request){
            Comment::upsert($request, ['id']);
        }
    }
}
