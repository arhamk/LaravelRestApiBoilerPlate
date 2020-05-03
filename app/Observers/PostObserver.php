<?php

namespace App\Observers;

use App\Post;
use Illuminate\Support\Str;

class PostObserver
{
    /**
     * Handle the post "created" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function created(Post $post)
    {

        $originalSlug = $slug = str_slug($post->title);
        $posts = Post::slugLike($slug)->pluck('slug');

        $i=0;
        while($posts->contains($slug)){
            $slug = $originalSlug .'-'. ++$i;
        }

        $post->slug = $slug;
    }

    public function retrieved(Post $post)
    {

        $post->title = ucfirst(str_replace('-', ' ',$post->title));

    }

    /**
     * Handle the post "updated" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function updated(Post $post)
    {
        //
    }



    /**
     * Handle the post "deleted" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function deleted(Post $post)
    {
        //
    }

    /**
     * Handle the post "restored" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function restored(Post $post)
    {
        //
    }

    /**
     * Handle the post "force deleted" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function forceDeleted(Post $post)
    {
        //
    }

}
