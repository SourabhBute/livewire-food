<?php

namespace App\Http\Livewire\Page;

use Livewire\Component;
use App\Models\Posts\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Edit extends Component
{   
    use AuthorizesRequests;
    public Post $post;

    public $lang = '';
    public $languages = '';

    protected function rules(){
        return [
            'post.title'    => 'required|max:255|string',
            'post.content'  => 'required|string|min:20',
            'post.status'   => 'in:draft,published,unpublished',
        ];
    }

    public function mount($id) {

        $this->post = Post::find($id);
        //page translation
        $this->lang = request()->ref_lang;
        $this->languages = request()->language;

        $this->post->title = isset($this->post->translate($this->lang)->title) ?  $this->post->translate($this->lang)->title: $this->post->translate(app()->getLocale())->title;
        $this->post->content = isset($this->post->translate($this->lang)->content) ? $this->post->translate($this->lang)->content : $this->post->translate(app()->getLocale())->content;
        //page translation
    }

    public function updated($propertyName){

        $this->validateOnly($propertyName);
    }

    public function edit() {
       $this->validate();
        $this->post->update([
            'user_id'   => auth()->user()->id,
            'title'     => $this->post->title,
            'content'   => $this->post->content,
            'status'    => $this->post->status ? $this->post->status:'draft',
        ]);
        
       return redirect(route('page-management'))->with('status', __('pages.Page successfully updated'));
    }


    public function editTranslate()
    {
        $request =  $this->validate([
            'post.title' => 'required',
            'post.content' => 'required',
        ]);

        $data = [
            $this->lang => $request['post']
        ];
        $post = Post::findOrFail($this->post->id);
        $post->update($data);

        $this->dispatchBrowserEvent('alert', 
        ['type' => 'success',  'message' => 'Page successfully updated.']);
    }

    public function render()
    {   
        if ($this->lang != app()->getLocale()) {
            return view('livewire.page.edit-language');
        }
        return view('livewire.page.edit');
    }
}
