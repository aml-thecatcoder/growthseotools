<?php

namespace App\Http\Livewire\Admin\Pages\Tools;

use Livewire\Component;
use App\Models\Admin\Page;
use App\Models\Admin\PageTranslation;
use App\Models\Admin\Languages;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use DateTime;
use Cviebrock\EloquentSluggable\Services\SlugService;

class Showlist extends Component
{

    use WithPagination;

    public $searchQuery = '';
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['onDeletePage', 'sendUpdatePageStatus' => 'onUpdatePageStatus'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.pages.tools.showlist', [
            'default_lang'         => Languages::where('default', true)->first()->code,
            'tools'                => Page::where('tool_name', 'like', '%'.$this->searchQuery.'%')->where('type', 'tool')->orderBy('id', 'DESC')->paginate(15),
            'total_lang'           => DB::table('languages')->count(),
            'translation_progress' => PageTranslation::select( 'page_id', DB::raw('count(*) as progress') )->groupBy('page_id')->get()->toArray()
        ]);
    }

    public function onUpdatePageStatus(){
        $this->render();
    }

    /**
     * -------------------------------------------------------------------------------
     *  arrayKeySearch
     * -------------------------------------------------------------------------------
    **/
    private function arrayKeySearch($array, $key) {

        $result = (array_search($key, array_column($array, 'tool_name')));

        return ($result === 0) ? true : $result;
    }

    /**
     * -------------------------------------------------------------------------------
     *  onImportTools
     * -------------------------------------------------------------------------------
    **/
    public function onImportTools()
    {

        try {

                $toolData   = Storage::disk('local')->get('tools.json');

                $deJson     = json_decode($toolData);

                $toolsArray = Page::where('type', 'tool')->get(['tool_name', 'position'])->toArray();

                $count      = Page::where('type', 'tool')->get()->max('position');

                foreach ($deJson as $key => $value) {

                    $check = $this->arrayKeySearch($toolsArray, $value);

                    if ( $check == false ){

                        $count++;
                        
                        $slug                   = SlugService::createSlug(Page::class, 'slug', $value);

                        $page                   = new Page;
                        $page->slug             = $slug;
                        $page->type             = 'tool';
                        $page->icon_image       = asset('assets/img/tools/' . $slug . '.svg');
                        $page->featured_image   = asset('assets/img/nastuh.jpg');
                        $page->tool_name        = $value;
                        $page->category_id      = null;
                        $page->custom_tool_link = null;
                        $page->position         = $count;
                        $page->created_at       = new DateTime();
                        $page->save();

                    }

                }

                $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Data imported successfully!') ]);
                
                $this->mount();

        } catch (\Exception $e) {

            $this->addError('error', __($e->getMessage()) );
            
        }

    }
    
    /**
     * -------------------------------------------------------------------------------
     *  Show Modal Edit
     * -------------------------------------------------------------------------------
    **/

    public function onShowEditPageModal($id)
    {
        $page        = Page::findOrFail($id);
        $this->emit('sendDataEditPage', ['id' => $page->id]);
        $this->dispatchBrowserEvent('showModal', ['id' => 'editPage']);
    }

    /**
     * -------------------------------------------------------------------------------
     *  onEnableTool
     * -------------------------------------------------------------------------------
    **/
    public function onEnableTool($id)
    {
        try {

            $tool              = Page::findOrFail($id);
            $tool->tool_status = true;
            $tool->updated_at  = new DateTime();
            $tool->save();

            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Data enabled successfully!') ]);
            $this->mount();
            
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __($e->getMessage()) ]);
        }

    }

    /**
     * -------------------------------------------------------------------------------
     *  onDisableTool
     * -------------------------------------------------------------------------------
    **/
    public function onDisableTool($id)
    {
        try {

            $tool              = Page::findOrFail($id);
            $tool->tool_status = false;
            $tool->updated_at  = new DateTime();
            $tool->save();

            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Data disabled successfully!') ]);
            $this->mount();
            
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __($e->getMessage()) ]);
        }

    }

    /**
     * -------------------------------------------------------------------------------
     *  Delete Page
     * -------------------------------------------------------------------------------
    **/

    public function onDeleteConfirmPage($id)
    {

        $this->dispatchBrowserEvent('swal:modal', ['id' => $id, 'type' => 'warning', 'title' => __('Are you sure?'), 'text' => __('You won\'t be able to revert this!') ]);
    }

    public function onDeletePage($id)
    {
        try {
            $page = Page::findOrFail($id);

            $page->delete($id);

            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Data deleted successfully!') ]);
            
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __($e->getMessage()) ]);
        }

    }

}
