<?php

namespace App\Http\Livewire\Product\Addon;

use App\Models\Product\AddonOption;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\GlobalTrait;

class Index extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    use GlobalTrait;

    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'desc';
    public $perPage = 10;
    public $addOnOption = '';
    public $filter = [];
    public $deleteId = '';
   
    public $categoyId = '';
 
    protected $listeners = ['remove', 'confirm'];

    protected $queryString = ['sortField', 'sortDirection'];
    protected $paginationTheme = 'bootstrap';

    public bool $loadData = false;
  
    public function init()
    {
         $this->loadData = true;
    }

    public function mount() { 
        $this->perPage = config('commerce.pagination_per_page');
        if(auth()->user()->hasRole('Provider')){
            $this->filter['is_provider'] = true;
            $this->filter['store_id'] = $this->getStoreId();
        }
    }

    public function sortBy($field){
        if($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }


    public function updatingSearch()
    {
        $this->gotoPage(1);
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }   


    public function render()
    {
        return view('livewire.product.add-on-option.index',[
          'addonOptions' =>$this->loadData ? AddonOption::withTranslation()->with(['store'])->searchMultipleAddOnOption(trim(strtolower($this->search)), $this->filter)->orderByTranslation($this->sortField, $this->sortDirection)->paginate($this->perPage) : [],
        ]);
    }


    /**
     * Write code on Method
     *
     * @return response()
     */
    public function destroyConfirm($addOnOptionId)
    {
        $this->deleteId  =$addOnOptionId;
        $this->dispatchBrowserEvent('swal:confirm', [
                'action' => 'remove',
                'type' => 'warning',  
                'confirmButtonText' => __('product.Yes delete it'),
                'cancelButtonText' => __('product.No cancel'),
                'message' => __('product.Are you sure'), 
                'text' => __('product.If deleted you will not be able to recover this AddOn Option')
            ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove()
    {
        AddonOption::find($this->deleteId)->delete();
       
        $this->dispatchBrowserEvent('alert', 
            ['type' => 'success',  'message' => __('product.Addon Option Delete Successfully') ]);
    }

     /**
     * update store status
     *
     * @return response()
     */
    public function statusUpdate($addOnOptionId, $status)
    {        
        $status = ( $status == 1 ) ? 0 : 1;
        AddonOption::where('id', '=' ,$addOnOptionId )->update(['status' => $status]);      

   }
}
