<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Branch;
use App\Models\Status;
use App\Models\RoleUser;
use App\Models\BranchUser;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view("users.index",compact("users"));
    }

    public function create()
    {
        try {
            $branches = Branch::where('branch_active',true)->get();
            // $roles = Role::pluck('name', 'id')->all();
            return view('users.create', compact(
                // 'roles',
                'branches'));
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return redirect()
                ->intended(route("users.index"))
                ->with('error', 'Fail to load Create Form!');
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
            $this->validate($request, [
                'name' => 'required',
                'employee_id' => 'required|unique:users,employee_id',
                'branch_id' => 'required',
                // 'email' => 'required|email|unique:users,email',
                'password' => 'required|same:confirm-password',
                // 'roles' => 'required',
            ]);

        try {

            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            $input['status'] = 1;
            unset($input['branch_id']);
            $user = User::create($input);

            $user_id = $user->id;
            $branch_ids = $request->branch_id;
            foreach ($branch_ids  as $branch_id) {
                $userBranch['user_id'] = $user_id;
                $userBranch['branch_id'] = $branch_id;
                BranchUser::create($userBranch);
            }

             // Assign Role
            // $roles = $request->roles;
            // foreach($roles as $role){
            //     $roleuser = new RoleUser();
            //     $roleuser->role_id = $role;
            //     $roleuser->user_id = $user_id;
            //     $roleuser->save();
            // }

            DB::commit();
            return redirect()->route('users.index')
                ->with('success', 'User created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::debug($e->getMessage());
            return redirect()
                ->intended(route("users.index"))
                ->with('error', 'Fail to Store User!');
        }
    }

     public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $branches = Branch::get();
        $roles = Role::pluck('name', 'id')->all();
        $userRole = $user->roles->pluck('id')->all();
        $userBranches = BranchUser::where('user_id',$user->id)->pluck('branch_id')->toArray();

        $statuses = Status::whereIn('id',[1,2])->get();

        return view("users.edit")->with("user",$user)
        ->with("statuses",$statuses)
        ->with("branches",$branches)
        ->with("roles",$roles)
        ->with("userRole",$userRole)
    
        ->with("userBranches",$userBranches);
    }


    public function update(Request $request, $id)
    {
            $this->validate($request, [
                'name' => 'required',
                // 'email' => 'required|email|unique:users,email,' . $id,
                // 'password' => 'same:confirm-password',
                // 'roles' => 'required'
            ]);

        try {

            $input = $request->all();
            if (!empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            } else {
                $input = Arr::except($input, array('password'));
            }

            unset($input['branch_id']);
            $user = User::find($id);
            $user->update($input);
            $user_id = $user->id;
            // DB::table('branch_users')->where('user_id', $user_id)->delete();
            // $branch_ids = $request->branch_id;
            // foreach ($branch_ids  as $branch_id) {
            //     $userBranch['user_id'] = $user_id;
            //     $userBranch['branch_id'] = $branch_id;
            //     BranchUser::create($userBranch);
            // }

            // // Assign Role
            $roles = $request->roles;
            DB::table('role_users')->where('user_id', $user_id)->delete();
            foreach($roles as $role){
                $roleuser = new RoleUser();
                $roleuser->role_id = $role;
                $roleuser->user_id = $user_id;
                $roleuser->save();
            }

            return redirect()->route('users.index')
                ->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Fail to update User!');
        }
    }

}
