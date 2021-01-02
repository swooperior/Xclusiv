<?php

namespace App\View\Components\Feed;

use Illuminate\View\Component;
use App\Models\Post as PostModel;
use App\Models\User;

class Post extends Component
{
    /**
     * Post Model.
     *
     * @var \App\Models\Post
     */
    public $post;
    public $owner;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(int $id)
    {
        $this->post = PostModel::where('id', $id)->first();
        $this->owner = User::where('id', $this->post->owner)->first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.feed.post', ['post' => $this->post, 'owner' => $this->owner]);
    }
}
