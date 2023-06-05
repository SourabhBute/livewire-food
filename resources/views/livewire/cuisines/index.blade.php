@section('page_title')
    Cuisines
@endsection
<div class="container-fluid py-4" wire:init="init">
    <div class="row mt-4">
        <div class="col-12">
            <x-alert></x-alert> 
            <div class="card custom-card">
                <!-- Card header -->
                @include('livewire.cuisines.filter')
                <!-- Card header end -->
             <div class="card-body pt-0">  
                <x-table>

                    <x-slot name="head">
                        <x-table.heading sortable wire:click="sortBy('name')"
                            :direction="$sortField === 'name' ? $sortDirection : null"> name
                        </x-table.heading> 
                        <x-table.heading> Status
                        </x-table.heading>  
                        <x-table.heading>
                            {{ implode(' | ',config('translatable.locales')) }}
                        </x-table.heading>   
                        <x-table.heading sortable wire:click="sortBy('created_at')"
                        :direction="$sortField === 'created_at' ? $sortDirection : null">
                             Creation Date
                        </x-table.heading> 

                        <x-table.heading>Actions</x-table.heading>
                    </x-slot>

                    <x-slot name="body">
                        @foreach ($cuisines as $cuisine)
                        <x-table.row wire:key="row-{{ $cuisine->id }}">
                            <x-table.cell class="position-relative text-sm font-weight-normal align-middle">
                                <div class="d-flex">
                                    @if ($cuisine->image)
                                     <img src="{{ Storage::disk(config('app_settings.filesystem_disk.value'))->url($cuisine->image) }} " alt="picture"
                                         class="avatar avatar-sm mt-2">
                                     @else
                                     <img src="{{ Storage::disk(config('app_settings.filesystem_disk.value'))->url(config('app_settings.product_image.value')) }}" alt="avatar"
                                         class="avatar avatar-sm mt-2">
                                     @endif
                                     <span class="ms-3 my-auto">{{ $cuisine->name }}</span>                                      
                                </div>
                                
                                
                            </x-table.cell> 
                            <x-table.cell> <div class="form-check form-switch ms-3">
                                <input class="form-check-input" wire:loading.attr="disabled"  type="checkbox" id="flexSwitchCheckDefault35"  wire:change="statusUpdate({{  $cuisine->id }},{{ $cuisine->status}})"
                                    @if( $cuisine->status) checked="" @endif>
                            </div></x-table.cell>
                            <x-table.cell> 
                                @foreach (config('translatable.locales') as $locale)
                                <a href="@if(app()->getLocale() != $locale) {{ route('edit-cuisine', ['id' => $cuisine->id,'ref_lang' => $locale]) }}  @else {{ route('edit-cuisine', $cuisine) }} @endif" class="" data-original-title="{{ $locale }}" title="{{ $locale }}"> 
                                    <span class="material-symbols-outlined text-md">
                                        {{ in_array($locale, array_column(json_decode($cuisine->translations, true), 'locale')) ? 'edit' : 'add' }}
                                    </span>
                                </a> 
                                @endforeach
                            </x-table.cell>
                            <x-table.cell>{{  $cuisine->created_at->format(config('app_settings.date_format.value'))  }}</x-table.cell>
                            <x-table.cell>
                                <div class="dropdown dropup dropleft">
                                    <button class="btn bg-gradient-default" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="material-icons">
                                            more_vert
                                        </span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @can('edit-cuisine')
                                            <li><a class="dropdown-item"  data-original-title="Edit" title="Edit" href="{{ route('edit-cuisine', $cuisine) }}">Edit</a></li>
                                        @endcan
                                        <li><a class="dropdown-item text-danger"  data-original-title="Remove" title="Remove" wire:click="destroyConfirm({{ $cuisine->id }})">Delete</a></li>
                                   </ul>
                                </div>   

                            </x-table.cell>
                        </x-table.row>
                        @endforeach
                    </x-slot>
                </x-table>
                @if($cuisines && $cuisines->total() > 10)
                <div class="row mx-2">
                    <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"><div class="dataTables_length" id="kt_ecommerce_sales_table_length">
                        <label>
                            <select  wire:model="perPage"  name="kt_ecommerce_sales_table_length" aria-controls="kt_ecommerce_sales_table" class="form-select form-select-sm form-select-solid">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </label>
                    </div>
                    </div>
                    <div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
                        <div class="dataTables_paginate paging_simple_numbers" id="kt_ecommerce_sales_table_paginate">
                            @if ($cuisines)
                            <div id="datatable-bottom">
                                {{ $cuisines->links() }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
               @endif
                @if($cuisines && $cuisines->total() == 0)
                    <div>
                        <p class="text-center">No records found!</p>
                    </div>
                @endif
             </div>
            </div>
        </div>
    </div>
    <x-loder ></x-loder>
</div>
 