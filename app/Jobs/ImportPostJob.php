<?php

namespace App\Jobs;

use App\Models\User;
use Botble\Blog\Models\Post;
use Botble\Slug\Models\Slug;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportPostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $post;
    private $authors;
    /**
     * @var null
     */
    private $url;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($post, $authors, $url = null)
    {
        $this->post = $post;
        $this->authors = $authors;
        $this->url = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->post && count($this->post)){
            $image_name = null;
            if ($this->url && strlen($this->url) && $this->file_contents_exist($this->url)) {
                $image_name = uniqid() . time() . '.' . pathinfo($this->url, PATHINFO_EXTENSION);
                file_put_contents(storage_path('app/public/' . $image_name), file_get_contents($this->url));
                Post::query()->where('u_id',$this->post['ID'])->update([
                    'image'=>$image_name,
                ]);
            }
            $post = Post::query()->where('u_id',$this->post['ID'])->first();
            if ($post){
                Slug::query()->updateOrCreate([
                    'reference_id' => $post->id,
                    'reference_type' => $post->getMorphClass(),
                ],[
                    'key' => Str::slug($post['name'])."-".$post->u_id,
                    'reference_id' => $post->id,
                    'reference_type' => $post->getMorphClass(),
                    'prefix' => ""
                ]);
            }
        }
    }

    function file_contents_exist($url, $response_code = 200)
    {
        $headers = get_headers($url);

        if (substr($headers[0], 9, 3) == $response_code) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
