<?php

namespace App\Http\Livewire\MyAdmin\Permissions;

use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

use Illuminate\Support\Facades\Auth;

use App\Models\User;

use Livewire\WithPagination;

use Livewire\Component;


class Permissions extends Component
{
    use WithPagination;

    // primitive Variable
    public string $myTitle = 'Permission SIRus';
    public string $mySnipet = 'Data Permission ';

    public array $myData = ['name' => ''];

    // TopBar
    public array $myTopBar = [];

    public string $refSearch = '';
    // search logic -resetExcept////////////////
    protected $queryString = [
        'refSearch' => ['except' => '', 'as' => 'cariData'],
        'page' => ['except' => 1, 'as' => 'p'],
    ];


    // resetPage When refSearch is Typing
    public function updatedMytopbarRefsearch()
    {
        $this->resetPage();
    }
    public function updatedMytopbarRefDate()
    {
        $this->resetPage();
    }

    // open and close modal start////////////////
    //  modal status////////////////
    public bool $isOpen = false;
    public string $isOpenMode = 'insert';
    public bool $forceInsertRecord = false;
    // 
    private function openModal(): void
    {
        $this->isOpen = true;
        $this->isOpenMode = 'insert';
    }
    private function openModalEdit($rjNo): void
    {
        $this->isOpen = true;
        $this->isOpenMode = 'update';
    }

    private function openModalTampil(): void
    {
        $this->isOpen = true;
        $this->isOpenMode = 'tampil';
    }

    public function closeModal(): void
    {
        $this->reset(['isOpen', 'isOpenMode']);
    }
    // open and close modal end////////////////


    public function createPermission(): void
    {
        $this->openModal();
        // $this->redirect('/register');
    }

    public function deletePermission($id): void
    {
        $deleted = Permission::Where('id', $id)->delete();
    }

    public function store()
    {
        $this->validate([
            'myData.name' => ['required', 'string', 'max:255'],
        ]);

        $Permission = Permission::create(['name' => $this->myData['name']]);
        $this->closeModal();
        $this->reset(['myData']);
    }

    public function mount()
    {
    }

    public function render()
    {
        // set mySearch
        $mySearch = $this->refSearch;

        // myQuery  /Collection
        $myQueryData = DB::table('permissions')
            ->select(
                'id',
                'name',
                'guard_name',
                'created_at',
                'updated_at',

            );

        $myQueryData->where(function ($q) use ($mySearch) {
            $q->orWhere(DB::raw('upper(name)'), 'like', '%' . strtoupper($mySearch) . '%')
                ->orWhere(DB::raw('upper(id)'), 'like', '%' . strtoupper($mySearch) . '%')
                ->orWhere(DB::raw('upper(guard_name)'), 'like', '%' . strtoupper($mySearch) . '%');
        })

            ->orderBy('name', 'asc');
        // myQuery


        return view(
            'livewire.my-admin.permissions.permissions',
            ['myQueryData' => $myQueryData->paginate(10)]
        );
    }
}
