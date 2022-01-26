<?php

namespace Packages\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAll',User::class);

        $users = DB::table('users')
            ->select([
                'users.*',
                DB::raw("GROUP_CONCAT(DISTINCT r.name SEPARATOR ',') as roles"),
                DB::raw('DATE_FORMAT(users.created_at, "%d.%m.%Yг.") as date')
            ])
            ->leftJoin('user_has_roles as ur', 'users.id', '=', 'ur.user_id')
            ->leftJoin('roles as r', 'ur.role_id', '=', 'r.id')
            ->where(function ($q) use ($request) {
                if ($search = $request->input('s', false)) {
                    $q->where('users.name', 'like', '%' . $search . '%')
                        ->orWhere('users.email', 'like', '%' . $search . '%');
                }

                if ($role = $request->input('role')){
                    $q->whereIn('r.id', $role);
                }

                if ($date = $request->input('date')){
                    $q->whereBetween('users.created_at', $date);
                }
            })
            ->groupBy('users.id')
            ->orderBy($request->orderBy, $request->order === 'descending' ? 'desc' : 'asc')
            ->paginate($request->count ?? 15);

        return response()->json([
            'users' => $users,
            'roles' => Role::query()->get()
        ]);
    }

    public function show(User $user)
    {
        $this->authorize('show',User::class);

        $user->ignoredKeywords = $user->ignoredKeywords()->pluck('keyword');
        $user->posts = $user->posts()->latest()->limit(25)->get();
        $user->comments = $user->comments()->with('post')->whereNull('parent_id')->latest()->limit(25)->get();
        $user->notifications = $user->notificationSettings;
        $user->roles = implode(',',$user->roles()->pluck('name')->toArray());

        return response()->json($user);
    }

    public function destroy(User $user)
    {
        $this->authorize('delete',User::class);

        abort_if(auth()->user()->is($user), '403', 'Нельзя удалить себя!');

        return response()->json($user->delete());
    }

    public function ban(Request $request, User $user)
    {
        $this->authorize('ban',User::class);

        abort_if(auth()->user()->is($user), '403', 'Нельзя заблокировать себя!');

        return response()->json($user->update(['is_banned' => (bool)$request->status]));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update',User::class);

        $data = $request->all();

        if ($request->exists('password')) $data['password'] = bcrypt($request->password);

        return response()->json($user->update($data));
    }

    public function changeRoles(Request $request, User $user)
    {
        $this->authorize('changeRole',User::class);

        abort_if(auth()->user()->is($user), '403', 'Нельзя менять свои роли!');

        return response()->json($user->syncRoles($request->roles));
    }
}