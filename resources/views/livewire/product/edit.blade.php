@section('page_title')
    Edit Product 
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
            <form wire:submit.prevent="update" enctype="multipart/form-data">

             <!-- Card Basic Info -->
            <div class="card mt-4" id="basic-info">
                <div class="card-header">
                    <h5>Product Info</h5>
                </div>
                <div class="card-body pt-0">
                    <div class="row mt-3">
                        <div class="col-12 col-sm-6">
                            <div class="input-group input-group-static">
                                <label>Name *</label>
                                <input wire:model.lazy="product.name" class="multisteps-form__input form-control" type="text" placeholder="Enter a Product name" />
                            </div>
                            @error('product.name')
                            <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                        </div>
                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                            <div class="input-group input-group-static">
                                <label>SKU </label>
                                <input wire:model.lazy="product.sku" class="multisteps-form__input form-control" type="text" placeholder="Enter a SKU" />
                            </div>
                            @error('product.sku')
                            <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                        </div>
                    </div>


                    <div class="row mt-3">
                        <div class="col-12 col-sm-6">
                            <div class="input-group input-group-static">
                            <select class="form-control " wire:model.lazy="product.categories_ids"  id="projectName" onfocus="focused(this)" onfocusout="defocused(this)">
                                <option value=''>Choose your Category *</option>
                                @foreach ($category as $value)
                                <option value="{{ $value['id'] }}">{{ $value['name']}}</option>
                                @endforeach
                            </select>
                            </div>
                            @error('product.categories_ids')
                            <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                        </div>
                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                            <div class="input-group input-group-static">                        
                                <select class="form-control input-group input-group-dynamic" wire:model.lazy="product.tax_id"  id="projectName" onfocus="focused(this)" onfocusout="defocused(this)">
                                    <option value=''>Choose Your Tax</option>
                                    @foreach ( $taxs as $value)
                                    <option value="{{ $value['id'] }}">{{ $value['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('product.tax')
                            <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                    @if (auth()->user()->hasRole('Admin'))
                    <div class="row mt-3">
                        <div class="col-12 col-sm-12 mt-6 mt-sm-0">
                            <div class="input-group input-group-static">
                                <label>Store * </label>
                                <select class="form-control input-group input-group-dynamic select2" wire:model.lazy="product.store_id"  id="projectName" onfocus="focused(this)" onfocusout="defocused(this)">
                                    <option value=''>Choose Your Store</option>
                                    @foreach ($this->product_store as $value)
                                    <option value="{{ $value['id'] }}">{{ $value['name']}}</option>
                                    @endforeach
                                 </select>
                            </div>
                            @error('product.store_id')
                            <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                        </div>
                    </div> 
                    @endif
                    <div class="row mt-3">
                        <div class="col-12 col-sm-12 mt-3 mt-sm-0">
                            <div class="input-group input-group-static">
                                <label>Description </label>
                                <div wire:ignore class="h-200 m-2 me-1 ms-auto w-100">
                                    <div x-data x-ref="quill" x-init="quill = new Quill($refs.quill, {theme: 'snow',});
                                            quill.on('text-change', function () {
                                            $dispatch('quill-text-change', quill.root.innerHTML);
                                        });"
                                        x-on:quill-text-change.debounce.2000ms="@this.set('product.descriptions', $event.detail)">
                                        {!!$product->descriptions!!}
                                    </div>
                                </div>
                            </div>
                            @error('product.descriptions')
                            <p class='text-danger inputerror mt-5 mb-xl-n6'>{{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 col-sm-6 mt-6 mt-sm-6">
                            <div class="input-group">
                                <div class="form-check form-switch ms-3">
                                    <label>Active</label>
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault35" wire:model="product.status">
                                </div>
                                @error('product.status')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>
                        </div>
                     
                    </div>                       
                </div>          
            </div>

            <!-- Pricing tab -->
            <div class="card mt-4" id="basic-info">
                <div class="card-header">
                    <h5>Pricing</h5>
                </div>
                <div class="card-body pt-0">                  
                    <div class="row mt-3">
                        <div class="col-12 col-sm-6">
                            <div class="input-group input-group-static">
                                <label>Actual Price *</label>
                                <input wire:model.lazy="product.price" class="multisteps-form__input form-control" type="text" placeholder="Enter a Actual Price" />
                            </div>
                            @error('product.price')
                            <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                        </div>
                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                            <div class="input-group input-group-static">
                                <label>Sale Price </label>
                                <input wire:model.lazy="product.price_sale" class="multisteps-form__input form-control" type="text" placeholder="Enter a Sale Price" />
                            </div>
                            @error('product.price_sale')
                            <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                            <div class="input-group input-group-static" wire:ignore x-data x-init="flatpickr($refs.picker, {allowInput: false});">
                                <label>Sale Start Date</label>
                                <input wire:model.lazy="product.sale_start_date"  x-ref="picker" class="form-control" type="text" placeholder="Enter a start sale date" />
                            </div>
                            @error('product.sale_start_date')
                            <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                        </div>
                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                            <div class="input-group input-group-static" wire:ignore x-data x-init="flatpickr($refs.picker, {allowInput: false});">
                                <label>Sale End Date</label>
                                <input wire:model.lazy="product.sale_end_date"  x-ref="picker" class="form-control" type="text" placeholder="Enter a end sale date" />
                            </div>
                            @error('product.sale_end_date')
                            <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mt-4" id="basic-info">
                <div class="card-header">
                    <h5>Select Addon Options</h5>
                </div>
                <div class="card-body pt-0">
                    
                        <div class="row mt-3">
                            <div class="col-12 col-sm-12">
                                <div class="input-group input-group-static">  
                                    <label for="product_addon_option_id" class="ms-0">Choose Your Addon Options</label>
                                    <select multiple="multiple"  wire:model.lazy="product_addon_option_id"  class="form-control pb-4" id="product_addon_option_id">
                                            @foreach ($addonValue as $value)
                                            <option @if(in_array($value['id'], $product_addon_option_id)) selected @endif value="{{ $value['id'] }}">{{ $value['name']}}  - ({{ ucfirst($value['addon_type']).' Options'}})</option>
                                            @endforeach
                                    </select>
                                </div>
                                @error('product_addon_option_id')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>
                        </div>  
                    </div>
                </div> 

            <div class="card mt-4" id="basic-info">
                <div class="card-header">
                    <h5>Product Image *</h5>
                </div>
                <div class="card-body pt-0">                     
                        <div class="col-12 mb-4">
                            <div class="input-group input-group-static">
                            <div class="avatar avatar-xl m-2 position-relative rounded-circle">
                                <div class="position-relative preview">
                                    <label for="file-input"
                                        class="btn btn-sm btn-icon-only bg-gradient-light position-absolute bottom-0 end-0 mb-n2 me-n2">
                                        <i wire:loading.remove class="fa fa-pen top-0" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="" aria-hidden="true" data-bs-original-title="Select Image"
                                            aria-label="Select Image"></i><span class="sr-only">Select Image</span>
                                            <div wire:loading wire:target="image">
                                                <x-spinner></x-spinner>
                                            </div>
                                    </label>
                                    <span class="h-12 w-12 rounded-full overflow-hidden bg-gray-100 ">
                                        @if ($image)
                                            <img src="{{ $image->temporaryUrl() }}" alt="Profile Photo" class="w-100 rounded-circle shadow-sm">
                                        @else
                                        @if ($product->image)
                                                <img src="{{ Storage::disk(config('app_settings.filesystem_disk.value'))->url($product->image->image_path)}}" alt="Profile Photo">
                                            @else
                                                <img src="{{ asset('assets') }}/img/default-food-avatar.jpg" alt="avatar">
                                            @endif
                                        @endif
                                    </span>
                                    <input wire:model="image" type="file" id="file-input">
                                </div>
                            </div>
                            </div>
                            @error('image')
                            <p class='text-danger inputerror m-3 ms-0'>{{ $message }} </p>
                            @enderror
                            </div>    
                       </div>
                         </div> 
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-end mt-4">
                                    <a  href="{{ route('product-management') }}" class="btn btn-light m-0">Cancel</a>
                                   <button wire:loading.attr="disabled" type="submit" name="submit" class="btn bg-gradient-dark m-0 ms-2">
                                    <span wire:loading.remove wire:target="update">Update Product</span>
                                        <span wire:loading wire:target="update"><x-buttonSpinner></x-buttonSpinner></span>
                                   </button>
                                </div>
                            </div>
                        </div>
                    
                </div>
           </div>

           </form>
    </div>
</div>
@push('js')
<script src="{{ asset('assets') }}/js/plugins/flatpickr.min.js"></script> 
<script src="{{ asset('assets') }}/js/plugins/quill.min.js"></script>
 
 
@endpush

@push('js')
<script>   
    $(document).ready(function() {
        window.initSelectAddonOption=()=>{
            $('#product_addon_option_id').select2({
                placeholder: 'Select a Addons',
                allowClear: true});
        }
        initSelectAddonOption();
        $('#product_addon_option_id').on('change', function (e) {
            var selected_element = $(e.currentTarget);
            var select_val = selected_element.val();   console.log(select_val);
            window.livewire.emit('getAddonOptionForInput', select_val);
        });
        window.livewire.on('select2',()=>{
            initSelectAddonOption();
        });

    });
</script>
@endpush
