<?php

namespace App\Http\Livewire\Cuisines;
use App\Models\Cuisines\Cuisine;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Index extends Component
{
    
    use AuthorizesRequests;
    use WithPagination;

    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'asc';
    public $perPage = 10;
    
    public $deleteId = '';
    
    protected $listeners = ['remove'];
    protected $queryString = ['sortField', 'sortDirection'];
    protected $paginationTheme = 'bootstrap';
    public bool $loadData = false;
  
    public function init()
    {
         $this->loadData = true;
    }

    public function sortBy($field){
        if($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function mount() {
        $this->perPage = config('commerce.pagination_per_page');
    }

    public function render()
    {
       return view('livewire.cuisines.index', [
          'cuisines' =>$this->loadData ? Cuisine::withTranslation()->searchMultipleCuisine(trim(strtolower($this->search)))->orderByTranslation($this->sortField, $this->sortDirection)->paginate($this->perPage) : [],
       ]);

    }

     /**
     * remove cuisine 
     *
     * @return response()
     */
    public function remove()
    {
        
        Cuisine::find($this->deleteId)->delete();
        
        $this->dispatchBrowserEvent('alert', 
        ['type' => 'success',  'message' => __('cuisine.Cuisine Delete Successfully!')]);

    } 

     /**
     * Confirm cuisine to destroy.
     *
     * @return response()
     */
    public function destroyConfirm($tagId)
    {
        $this->deleteId  = $tagId;
        $this->dispatchBrowserEvent('swal:confirm', [
                'action' => 'remove',
                'type' => 'warning',  
                'confirmButtonText' => __('cuisine.Yes, delete it!'),
                'cancelButtonText' => __('cuisine.No, cancel!'),
                'message' => __('cuisine.Are you sure?'), 
                'text' => __('cuisine.If deleted, you will not be able to recover this cuisine data!')
            ]);
    }

     
     /**
     * Go to page on search.
     *
     * @return response()
     */
    public function updatingSearch()
    {
        $this->gotoPage(1);
    }

    /**
     * Reset page.
     *
     * @return response()
     */

    public function updatingPerPage()
    {
        $this->resetPage();
    }   
    
     /**
     * update cuisine status
     *
     * @return response()
     */
    public function statusUpdate($tagId, $status)
    {        
        $status = ( $status == 1 ) ? 0 : 1;
        Cuisine::where('id', '=' ,$tagId )->update(['status' => $status]);      

   }
}
