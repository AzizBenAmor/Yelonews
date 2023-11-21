<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class PostList extends Component
{
   use WithPagination;
   
    #[Url()]
    public $sort='desc';
    #[Url()]
    public $search='';
    #[Url()]
    public $category='';
    #[Url()]
    public $popular=false;

    public function setSort($sort){

        $this->sort=($sort == 'desc')? 'desc': 'asc';
        $this->resetPage();

    }    

    #[On('search')]
    public function updateSearch($search){

        $this->search=$search;
        $this->resetPage();


    }

    #[Computed()]
    public function posts(){

        return Post::published()
        ->with('author','categories')
        ->where('title','LIKE',"%$this->search%")
        ->when($this->activeCategory(),function($query){
            $query->category($this->category);
        })
        ->when($this->popular,function($query){
            $query->popular();
        })
        ->orderBy('published_at',$this->sort)
        ->paginate(3);

    }
    
    #[Computed()]
    public function activeCategory(){
        if ($this->category== null || $this->category== ' ') {
            return null;
        }
        return Category::where('slug',$this->category)->first();
    }

    public function clearFilters(){

        $this->reset('category','search');
        $this->resetPage();
    }
    public function render()
    {
        return view('livewire.post-list');
    }
}
