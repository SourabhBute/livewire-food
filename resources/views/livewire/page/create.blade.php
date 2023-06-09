@section('page_title')
    Add Page
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
                            <div class="col-12 mb-2">
                                <div class="input-group input-group-static">
                                    <label>Title *</label>
                                    <input wire:model.lazy="title" type="text" class="form-control" placeholder="Enter a page title">
                                </div>
                                @error('title')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                            </div>
                            <div class="col-12 mt-2 mb-6">
                                <div class="input-group input-group-static">
                                    <label>Content *</label>
                                    <div wire:ignore class="h-300  ms-auto me-1 w-100">
                                        <div x-data x-ref="quill" x-init="quill = new Quill($refs.quill, {theme: 'snow'});
                                        quill.on('text-change', function () {
                                            $dispatch('quill-text-change', quill.root.innerHTML);
                                        });"
                                            x-on:quill-text-change.debounce.200ms="@this.set('content', $event.detail)">
        
                                            {!! $content !!}
                                        </div>
                                    </div>
                                </div>
                                @error('content')
                                <p class='text-danger inputerror mt-5 mb-xl-n6 '>{{ $message }} </p>
                                @enderror
                            </div>  
                            <div class="col-12  mb-4">
                                <div class="input-group input-group-static">
                                    <label for="status" class="">Status</label>
                                    <select  wire:model.lazy="status" class="form-control" id="status">
                                        <option value ="">Choose a status</option>
                                        <option value="published">Published</option>
                                        <option value="draft">Draft</option>
                                        <option value="unpublished">Unpublished</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-end mt-4">
                                    <a  href="{{ route('page-management') }}" class="btn btn-light m-0">Cancel</a>
                                    <button wire:loading.attr="disabled"  type="submit" name="submit" class="btn bg-gradient-dark m-0 ms-2">
                                        <span wire:loading.remove wire:target="store">Create Page</span>
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
@push('js') 
<script src="{{ asset('assets') }}/js/plugins/quill.min.js"></script>
@endpush
