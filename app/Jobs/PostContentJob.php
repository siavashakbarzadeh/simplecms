<?php

namespace App\Jobs;

use DOMDocument;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class PostContentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $post;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($post)
    {
        $this->post = $post;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $dom = new DOMDocument();
        $dom->loadHTML($this->post->content);
        $urls = collect($dom->getElementsByTagName('a'))->map(function ($item) {
            return $item->getAttribute('href');
        })->filter(function ($item) {
            if (filter_var($item, FILTER_VALIDATE_URL) && @getimagesize($item)) return true;
            return false;
        });
        if ($urls->count()) {
            $content = $this->post->content;
            foreach ($urls as $url) {
                $image_name = uniqid() . time() . '.' . pathinfo($url, PATHINFO_EXTENSION);
                file_put_contents(storage_path('app/public/' . $image_name), file_get_contents($url));
                $content = Str::replace(Str::beforeLast($url, '.'), Str::beforeLast(asset($image_name),'.'), $content);
            }
            $this->post->update(['content'=>$content]);
        }
    }
}
