<?php

namespace App\Http\Controllers;

use App\Company;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['Administrador']);
        return view('users.index', ['users' => User::all()]);
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['Administrador']);
        $pemex = Company::where('name', 'like', '%pemex%')->first();
        return view('users.create', ['roles' => Role::all(), 'companies' =>
        $pemex != null ? Company::where('id', '!=', $pemex->id)->get() : Company::where('main', 0)->get()]);
    }

    /**
     * Store a newly created user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $request->user()->authorizeRoles(['Administrador']);
        if ($request->rol == 2) {
            request()->validate(['company_id' => 'required|integer']);
        }
        if ($request->rol == 3) {
            request()->validate(['companies' => 'required']);
        }
        if ($request->rol == 3) {
            $user = User::create($request->merge(['password' => bcrypt($request->password), 'active' => 1])->except(['company_id']));
            $user->companies()->attach($request->companies);
        } else {
            $user = User::create($request->merge(['password' => bcrypt($request->password), 'active' => 1])->all());
        }
        $user->roles()->sync($request->rol);
        return redirect()->route('users.index')->withStatus(__('Usuario registrado correctamente'));
    }

    /**
     * Show the form for editing the specified user
     *
     * @param  \App\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, User $user)
    {
        $request->user()->authorizeRoles(['Administrador']);
        $pemex = Company::where('name', 'like', '%pemex%')->first();
        return view('users.edit', ['user' => $user, 'roles' => Role::all(), 'companies' =>
        $pemex != null ? Company::where('id', '!=', $pemex->id)->get() : Company::where('main', 0)->get()]);
    }

    /**
     * Update the specified user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User  $user)
    {
        $request->user()->authorizeRoles(['Administrador']);
        if ($request->rol != 1) {
            request()->validate(['company_id' => 'required|integer']);
        }
        if ($request->password != null) {
            $user->update(['password' => bcrypt($request->password)]);
        }
        $user->update($request->except(['active', 'password']));
        $user->roles()->sync($request->rol);
        if ($request->rol != 2)
            $user->update(['company_id', null]);
        if ($request->rol == 3) {
            foreach ($user->companies as $company) {
                if (!in_array($company->id, $request->companies)) {
                    $user->companies()->detach($company->id);
                }
            }
            foreach ($request->companies as $company) {
                if (!$user->companies->contains($company)) {
                    $user->companies()->attach($company);
                }
            }
        } else {
            foreach ($user->companies as $company) {
                $user->companies()->detach($company->id);
            }
        }
        return redirect()->route('users.index')->withStatus(__('Usuario actualizado correctamente.'));
    }

    /**
     * Remove the specified user from storage
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, User $user)
    {
        $request->user()->authorizeRoles(['Administrador']);
        $user->delete();
        return redirect()->route('users.index')->withStatus(__('Usuario dado de baja correctamente.'));
    }
}
