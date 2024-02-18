<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toastable;
use Spatie\Permission\Models\Role;

class UserForm extends ModalComponent
{
    use Toastable;
    public $user, $name, $email, $password, $password_confirmation, $user_id, $roles, $role_name;

    public function render()
    {
        $users = User::all();
        $roles = Role::all();
        return view('livewire.user-form', compact('users', 'roles'));
    }

    public function resetCreateForm()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->role_name = '';
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min:3',
            'role_name' => 'required',
            'password' => 'required|min:6|confirmed',
        ];

        if ($this->user_id) {
            // If updating an existing user, ignore the current user's email
            $rules['email'] = ['required', 'email', Rule::unique('users')->ignore($this->user_id)];
        } else {
            // If creating a new user, the email must be unique
            $rules['email'] = 'required|email|unique:users,email';
        }

        $this->validate($rules);

        if ($this->user_id) {
            $user = User::find($this->user_id);
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'password' => bcrypt($this->password),
            ]);
            $user->syncRoles($this->role_name);
        } else {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => bcrypt($this->password),
            ]);
            $user->assignRole($this->role_name);
        }

        $this->closeModalWithEvents([
            UserTable::class => 'userUpdated',
        ]);

        $this->success($user->wasRecentlyCreated ? 'User berhasil dibuat' : 'User berhasil diubah');

        $this->resetCreateForm();
    }

    public function mount($rowId = null)
    {
        $this->roles = Role::all();
        if (!is_null($rowId)) {
            $this->user = User::find($rowId);
            $this->user_id = $this->user->id;
            $this->name = $this->user->name;
            $this->email = $this->user->email;
        }
    }
}
