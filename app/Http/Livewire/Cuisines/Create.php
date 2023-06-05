<?php

namespace App\Http\Livewire\Cuisines;

use Livewire\Component;
use App\Models\Cuisines\Cuisine;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\WithFileUploads;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Create extends Component
{   
    use AuthorizesRequests;
    use WithFileUploads;

    public $name = '';
    public $status = '';
    public $image;

    protected $rules = [
        'name'   => 'required|string|max:75|unique:App\Models\Cuisines\CuisineTranslation,name',
        'status' => 'nullable|between:0,1',
    ];


    public function updated($propertyName){

        $this->validateOnly($propertyName);

    } 

    public function store(){

        $this->validate();
        $cuisineImagePath="";

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
        }

        Cuisine::create([
            'name'  => $this->name,
            'image' =>$cuisineImagePath,
            'status' => $this->status ? 1:0,
        ]);

        return redirect(route('cuisine-management'))->with('status',__('cuisine.Cuisine successfully created.'));
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

    public function render()
    {
        return view('livewire.cuisines.create');
    }
}
