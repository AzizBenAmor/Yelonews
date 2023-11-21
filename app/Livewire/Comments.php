<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Comments extends Component
{
    use WithPagination;

    public Post $post;
    #[Rule('min:2|max:200|required')]
    public string $comment;

    #[Computed()]
    public function comments()
    {
        return $this?->post?->comments()->with('user')->latest()->paginate(5);
    }

    public function postComment(){

        if (auth()->guest()) {
            return;
        }
        $this->validate();

        $this->post->comments()->create([
            'comment'=>$this->comment,
            'user_id'=>Auth::user()->id,
        ]);

        $this->reset('comment');

    }

    public function render()
    {
        return view('livewire.comments');
    }
}
