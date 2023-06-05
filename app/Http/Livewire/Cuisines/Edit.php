<?php

namespace App\Http\Livewire\Cuisines;

use Livewire\Component;
use App\Models\Cuisines\Cuisine;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\WithFileUploads;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Edit extends Component
{  
    use AuthorizesRequests;
    use WithFileUploads;

    public $lang = '';
    public $languages = '';
    public $image;
    public $cuisine;


    protected function rules(){
        $cuisine = isset($this->cuisine->translate($this->lang)->id)  ? ','.$this->cuisine->translate($this->lang)->id : null;
        return [
            'cuisine.name'    => 'required|string|max:75|unique:App\Models\Cuisines\CuisineTranslation,name'.$cuisine,
            'cuisine.status'   => 'nullable|between:0,1',
        ];
    }

    public function mount($id) {

        $this->cuisine = Cuisine::find($id);
        
        $this->lang = request()->ref_lang;
        $this->languages = request()->language;

        $this->cuisine->name = isset($this->cuisine->translate($this->lang)->name) ?  $this->cuisine->translate($this->lang)->name: $this->cuisine->translate(app()->getLocale())->name;
      
    }

    public function updated($propertyName){

        $this->validateOnly($propertyName);
    }

    public function edit(){

        $this->validate();

        if($this->image){
            $cuisineImage = Image::make($this->image->getRealPath());
            $cuisineImageName  = time() . '.' . $this->image->getClientOriginalExtension();
            Storage::disk(config('app_settings.filesystem_disk.value'))->put('StoreCuisine'.'/'.$cuisineImageName, (string) $cuisineImage->encode());
            
            $cuisineImage->resize(170,null, function ($constraint) {
                $constraint->aspectRatio();    
                $constraint->upsize();             
            });

            Storage::disk(config('app_settings.filesystem_disk.value'))->put('thumbnails'.'/'.$cuisineImageName, $cuisineImage->stream());
            $cuisineImagePath = 'thumbnails'.'/'.$cuisineImageName;
            $this->cuisine->image = $cuisineImagePath ;
        }

        $this->cuisine->update();

        return redirect(route('cuisine-management'))->with('status', __('cuisine.Cuisine successfully updated.'));
    }

    public function updatedImage() {
        $validator = Validator::make(
            ['image' => $this->image],
            ['image' => 'nullable|mimes:jpg,jpeg,png,bmp,tiff|max:4096'],
        );

        if ($validator->fails()) {
            $this->reset('image');
            $this->setErrorBag($validator->getMessageBag());
            return redirect()->back();
        }
    }

    public function editTranslate()
    {   
        $cuisine = isset($this->cuisine->translate($this->lang)->id)  ? ','.$this->cuisine->translate($this->lang)->id : null;
        $request =  $this->validate([
           'cuisine.name'    => 'required|string|max:75|unique:App\Models\Cuisines\CuisineTranslation,name'.$cuisine,
        ]);

        $data = [
            $this->lang => $request['cuisine']
        ];
        $cuisine = Cuisine::findOrFail($this->cuisine->id);
        $cuisine->update($data);

        $this->dispatchBrowserEvent('alert', 
        ['type' => 'success',  'message' => __('cuisine.Cuisine successfully updated.')]);
    }

    public function render()
    {
        if ($this->lang != app()->getLocale()) {
            return view('livewire.cuisines.edit-language');
        }
        return view('livewire.cuisines.edit');
    }
}
