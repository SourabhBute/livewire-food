<?php

namespace App\Http\Livewire\World\Country;

use App\Models\Worlds\Country;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'desc';
    public $perPage = 10;
    public $country = '';
    public $filter = [];
    public $deleteId = ''; 
    public $countryId = '';
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
    }

    public function sortBy($field){
        if($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function render()
    {
        return view('livewire.world.country.index' ,[
            'countries' =>$this->loadData ? country::searchMultipleCoutry(trim(strtolower($this->search)))->orderBy($this->sortField, $this->sortDirection)->paginate($this->perPage) : [],
        ]);
    }

     /**
     * Write code on Method
     *
     * @return response()
     */
    public function destroyConfirm($countryId)
    {
        $this->deleteId  = $countryId;
        $this->dispatchBrowserEvent('swal:confirm', [
                'action' => 'remove',
                'type' => 'warning',  
                'confirmButtonText' => __('world.Yes, delete it!'),
                'cancelButtonText' => __('world.No, cancel!'),
                'message' => __('world.Are you sure?'), 
                'text' => __('world.If deleted, you will not be able to recover this Country!')
            ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove()
    {
        Country::find($this->deleteId)->delete();
        
        $this->dispatchBrowserEvent('alert', 
            ['type' => 'success',  'message' => __('world.Country Delete Successfully!')]);
    }


    public function updatingSearch()
    {
        $this->gotoPage(1);
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }   

     /**
     * update store status
     *
     * @return response()
     */
    public function statusUpdate($countryId, $status)
    {        
        $status = ( $status == 1 ) ? 0 : 1;
        Country::where('id', '=' ,$countryId)->update(['status' => $status]);      

   }
}
