<?php

namespace App\Http\Livewire\MyAdmin\Users;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Validation\Rules;

use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;


use Livewire\Component;


class Users extends Component
{
    use WithPagination, WithFileUploads;

    // primitive Variable
    public string $myTitle = 'User SIRus';
    public string $mySnipet = 'Data User ';

    public array $myData = [
        'name' => '',
        'email' => '',
        'password' => '',
        'password_confirmation' => '',
        'myUserCode' => '',
        'myUserName' => '',
        'myUserSIP' => '',
        'myUserTtdImage' => '',
    ];

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
    private function openModalEdit($id): void
    {
        $this->isOpen = true;
        $this->isOpenMode = 'update';
        $this->findData($id);
    }
    private function findData($id): void
    {

        $findData = User::Where('email', $id)->first();
        $this->myData['name'] = $findData->name;
        $this->myData['email'] = $findData->email;
        // $this->myData['password'] = $findData->name;
        // $this->myData['password_confirmation'] = $findData->name;
        $this->myData['myUserCode'] = $findData->myuser_code;
        $this->myData['myUserName'] = $findData->myuser_name;
        $this->myData['myUserSIP'] = $findData->myuser_sip;
        $this->myData['myUserTtdImage'] = $findData->myuser_ttd_image;
    }

    private function openModalTampil(): void
    {
        $this->isOpen = true;
        $this->isOpenMode = 'tampil';
    }

    public function closeModal(): void
    {
        $this->reset(['isOpen', 'isOpenMode', 'myData']);
    }
    // open and close modal end////////////////


    public function createUser(): void
    {
        $this->openModal();
        // $this->redirect('/register');
    }

    public function deleteUser($id): void
    {
        $deleted = User::Where('email', $id)->delete();
    }

    public function editUser($id): void
    {
        $this->openModalEdit($id);
    }

    public function store()
    {
        $rules = [
            'myData.name' => ['required', 'string', 'max:255'],
        ];


        if ($this->isOpenMode == 'insert') {

            $rulse['myData.password'] = ['required', 'confirmed', Rules\Password::defaults()];
            $rulse['myData.email'] = ['required', 'string', 'email', 'max:255', 'unique:' . User::class . ',email'];

            $this->validate($rules);

            if ($this->myData['myUserTtdImage']) {
                // upload photo
                $myUserTtdImage = $this->myData['myUserTtdImage']->store('UserTtd');
            } else {
                $myUserTtdImage = '';
            }

            $user = User::create([
                'name' => $this->myData['name'],
                'email' => $this->myData['email'],
                'password' => Hash::make($this->myData['password']),
                'myuser_code' => $this->myData['myUserCode'],
                'myuser_name' => $this->myData['myUserName'],
                'myuser_sip' => $this->myData['myUserSIP'],
                'myuser_ttd_image' => $myUserTtdImage,
            ]);
            //
            //
        } else {
            $rulse['myData.email'] = ['required', 'string', 'email', 'max:255'];

            $this->validate($rules);
            $user = User::where('email', $this->myData['email']);

            // Foto/////////////////////////////////////////////////////////////////////////
            if ($user->first()->myuser_ttd_image !== $this->myData['myUserTtdImage']) {
                // delte photo
                if ($user->first()->myuser_ttd_image) {
                    Storage::delete($user->first()->myuser_ttd_image);
                }
                // upload photo
                $myUserTtdImage = $this->myData['myUserTtdImage']->store('UserTtd');
                $user->update([
                    'myuser_ttd_image' => $myUserTtdImage,
                ]);
            }
            // uploadphoto if foto false/////////////////////////////////////////////////////

            $user->update([
                'name' => $this->myData['name'],
                'email' => $this->myData['email'],
                'myuser_code' => $this->myData['myUserCode'],
                'myuser_name' => $this->myData['myUserName'],
                'myuser_sip' => $this->myData['myUserSIP'],

            ]);
        }



        $this->closeModal();
        $this->reset(['myData']);
    }
    public function assignRolePerawat($id)
    {
        $user = new User;
        $user = $user->where('id', $id)->first();
        $user->assignRole('Perawat');
    }
    public function assignRoleDokter($id)
    {
        $user = new User;
        $user = $user->where('id', $id)->first();
        $user->assignRole('Dokter');
    }
    public function assignRoleMr($id)
    {
        $user = new User;
        $user = $user->where('id', $id)->first();
        $user->assignRole('Mr');
    }
    public function assignRoleApoteker($id)
    {
        $user = new User;
        $user = $user->where('id', $id)->first();
        $user->assignRole('Apoteker');
    }
    public function assignRoleAdmin($id)
    {
        $user = new User;
        $user = $user->where('id', $id)->first();
        $user->assignRole('Admin');
    }





    public function removeRolePerawat($id)
    {
        $user = new User;
        $user = $user->where('id', $id)->first();
        $user->removeRole('Perawat');
    }
    public function removeRoleDokter($id)
    {
        $user = new User;
        $user = $user->where('id', $id)->first();
        $user->removeRole('Dokter');
    }
    public function removeRoleMr($id)
    {
        $user = new User;
        $user = $user->where('id', $id)->first();
        $user->removeRole('Mr');
    }
    public function removeRoleApoteker($id)
    {
        $user = new User;
        $user = $user->where('id', $id)->first();
        $user->removeRole('Apoteker');
    }
    public function removeRoleAdmin($id)
    {
        $user = new User;
        $user = $user->where('id', $id)->first();
        $user->removeRole('Admin');
    }

    public function mount()
    {
    }

    public function render()
    {
        // set mySearch
        $mySearch = $this->refSearch;

        // myQuery  /Collection
        $myQueryData = DB::table('users')
            ->select(
                'id',
                'name',
                'email',
                'email_verified_at',
                'password',
                'myuser_code',
                'myuser_ttd_image',
                'myuser_sip',
                'created_at',
                'updated_at',
                DB::raw('(select string_agg(roles.name) as myrole from roles,model_has_roles where roles.id=model_has_roles.role_id and model_id=users.id) as myrole'),

            );

        $myQueryData->where(function ($q) use ($mySearch) {
            $q->orWhere(DB::raw('upper(name)'), 'like', '%' . strtoupper($mySearch) . '%')
                ->orWhere(DB::raw('upper(id)'), 'like', '%' . strtoupper($mySearch) . '%')
                ->orWhere(DB::raw('upper(email)'), 'like', '%' . strtoupper($mySearch) . '%');
        })
            ->orderBy('myrole', 'asc')
            ->orderBy('name', 'asc');
        // myQuery


        return view(
            'livewire.my-admin.users.users',
            ['myQueryData' => $myQueryData->paginate(10)]
        );
    }
}
