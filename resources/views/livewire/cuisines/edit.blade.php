@section('page_title')
    Edit Cuisine
@endsection
<div class="container-fluid py-4 bg-gray-200">
    <div class="row mb-5">
        <div class="col-lg-9 col-12 mx-auto position-relative">
            @if (session('status'))
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-success alert-dismissible text-white mt-3" role="alert">
                        <span class="text-sm">{{ Session::get('status') }}</span>
                        <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
            @endif
           
            <!-- Card Basic Info -->
            <div class="card mt-4" id="basic-info">
                <div class="card-body pt-5">
                    
                    <form wire:submit.prevent="edit">

                        <div class="row ">
                            <div class="col-12  mb-4">
                                <div class="input-group input-group-static">
                                    <label>Name *</label>
                                    <input wire:model.lazy="cuisine.name" type="text" class="form-control" placeholder="Enter a cuisine name">
                                </div>
                                @error('cuisine.name')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>

                            <div class="col-12  mb-4">
                                <label>Status</label>
                                <div class="form-check">
                                    <input wire:model.lazy="cuisine.status" type="checkbox" class="form-check-input" id="status">
                                    <label class="form-check-label" for="status"> Active </label>
                                </div>
                            </div>

                            <div class="col-12 mb-4">
                                <div class="input-group input-group-static">
                                <div class="avatar avatar-xl m-2 position-relative rounded-circle">
                                    <div class="position-relative preview">
                                        <label> Image </label>
                                        <label for="file-input"
                                            class="btn btn-sm btn-icon-only bg-gradient-light position-absolute bottom-0 end-0 mb-n2 me-n2">
                                            <i wire:loading.remove class="fa fa-pen top-0" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="" aria-hidden="true" data-bs-original-title="Edit Image"
                                                aria-label="Edit Image"></i><span class="sr-only">Edit Image</span>
                                                <div wire:loading wire:target="image">
                                                    <x-spinner></x-spinner>
                                                </div>
                                        </label>
                                        <span class="h-12 w-12 rounded-full overflow-hidden bg-gray-100 ">
                                            @if ($image)
                                            <img src="{{ $image->temporaryUrl() }}" alt="Profile Photo">
                                            @elseif ($cuisine->image)
                                            
                                             <img src="{{ Storage::disk(config('app_settings.filesystem_disk.value'))->url($cuisine->image)}}" alt="Photo">
                                            @else
                                            <img src="{{ asset('assets') }}/img/default-food-avatar.jpg" alt="avatar">
                                            @endif</span>
    
                                        <input wire:loading.attr="disabled" wire:model="image" type="file" id="file-input">
                                    </div>
                                </div>
                                </div>
                                @error('image')
                                <p class='text-danger inputerror m-3 ms-0'>{{ $message }} </p>
                                @enderror
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-end mt-4">
                                    <a  href="{{ route('cuisine-management') }}" class="btn btn-light m-0">Cancel</a>
                                    <button type="submit"  wire:loading.attr="disabled" name="submit" class="btn bg-gradient-dark m-0 ms-2">
                                        <span wire:loading.remove wire:target="edit"> Update Cuisine</span>
                                        <span wire:loading wire:target="edit"><x-buttonSpinner></x-buttonSpinner></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
 
        </div>
    </div>
</div>
 