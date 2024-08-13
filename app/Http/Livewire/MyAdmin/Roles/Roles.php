<?php

namespace App\Http\Livewire\MyAdmin\Roles;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;


use Livewire\Component;
use Livewire\WithPagination;


class Roles extends Component
{
    use WithPagination;

    // primitive Variable
    public string $myTitle = 'Role SIRus';
    public string $mySnipet = 'Data Role ';

    public array $myData = ['name' => ''];
    public array $myDataPermission = ['permissionStatus' => []];


    // TopBar
    public array $myTopBar = [];

    public string $refSearch = '';
    // search logic -resetExcept////////////////
    protected $queryString = [
        'refSearch' => ['except' => '', 'as' => 'cariData'],
        'page' => ['except' => 1, 'as' => 'p'],
    ];


    // resetPage When refSearch is Typing
    public function updatedRefsearch()
    {

        $this->resetPage();
    }

    public function updatedMydatapermissionPermissionstatus()
    {
        dd('x');
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


    public function createRole(): void
    {
        $this->openModal();
        // $this->redirect('/register');
    }

    public function deleteRole($id): void
    {
        $deleted = Role::Where('id', $id)->delete();
    }

    public function store()
    {
        $this->validate([
            'myData.name' => ['required', 'string', 'max:255'],
        ]);

        $role = Role::create(['name' => $this->myData['name']]);
        $role->givePermissionTo('Read / Write');
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
        $myQueryData = DB::table('roles')
            ->join('role_has_permissions', 'roles.id', 'role_id')
            ->join('permissions', 'permissions.id', 'permission_id')
            ->select(
                'roles.id as id',
                'roles.name as roles_name',
                'guard_name',
                'permissions.name as permissions_name',
                // 'team_id',
                'created_at',
                'updated_at',

            );

        $myQueryData->where(function ($q) use ($mySearch) {
            $q->orWhere(DB::raw('upper(name)'), 'like', '%' . strtoupper($mySearch) . '%')
                ->orWhere(DB::raw('upper(id)'), 'like', '%' . strtoupper($mySearch) . '%')
                ->orWhere(DB::raw('upper(guard_name)'), 'like', '%' . strtoupper($mySearch) . '%');
        })

            ->orderBy('roles_name', 'asc')
            ->orderBy('permissions_name', 'asc');

        // myQuery




        return view(
            'livewire.my-admin.roles.roles',
            [
                'myQueryData' => $myQueryData->paginate(10),
            ]
        );
    }
}
