@section('page_title')
    Add City
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
                    <form wire:submit.prevent="store">
                        <div class="row ">
                            <div class="col-12 mb-4">
                                <div class="input-group input-group-static">
                                    <label>Name *</label>
                                    <input wire:model.lazy="name" type="text" class="form-control" placeholder="Enter a City name">
                                </div>
                                @error('name')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>

                            <div class="col-12  mb-4">
                                <div class="input-group input-group-static">
                                    <label >Country *</label>
                                    <select class="form-control input-group input-group-dynamic" wire:model.lazy="country_id" id="countryName" onfocus="focused(this)" onfocusout="defocused(this)">
                                        <option value=''selected>Choose Your Country</option>
                                        @foreach ($country  as $value)
                                        <option value="{{ $value['id'] }}">{{ $value['name']}}</option>
                                        @endforeach
                                     </select>
                                </div>
                                @error('country_id')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>       
                            @if (!is_null($country_id))
                            <div class="col-12  mb-4">
                                <div class="input-group input-group-static">
                                    <label >State *</label>
                                    <select class="form-control input-group input-group-dynamic"wire:model.lazy="state_id" id="projectName" onfocus="focused(this)" onfocusout="defocused(this)">
                                        <option value=''selected>Choose Your State</option>
                                        @foreach ($state  as $value)
                                        <option value="{{ $value['id'] }}">{{ $value['name']}}</option>
                                        @endforeach
                                     </select>
                                </div>
                                @error('state_id')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>   
                            @endif
                            <div class="col-12 ">
                                <div class="form-group">
                                    
                                    <div class="form-check">
                                        <input wire:model="is_default" class="form-check-input" type="checkbox"  id="flexCheckFirst">
                                        <label class="form-check-label" for="flexCheckFirst">Is Default</label>
                                     </div>
                                </div>
                                @error('is_default')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>    

                            <div class="col-12">
                                <div class="form-group ">
                                  
                                     <div class="form-check">
                                        <input wire:model="status" class="form-check-input" type="checkbox"  id="flexCheckActive">
                                        <label class="form-check-label" for="flexCheckActive">Active</label>
                                     </div>
                                </div>
                                @error('status')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>    

                        </div>
        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-end mt-4">
                                    <a  href="{{ route('city-management') }}" class="btn btn-light m-0">Cancel</a>
                                    <button type="submit" wire:loading.attr="disabled" name="submit" class="btn bg-gradient-dark m-0 ms-2">
                                        <span wire:loading.remove wire:target="store"> Create City</span>
                                        <span wire:loading wire:target="store"><x-buttonSpinner></x-buttonSpinner></span>
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
 