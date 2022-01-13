<?php

namespace Packages\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = DB::table('users')
            ->select([
                'users.*',
                DB::raw('count(p.id) as posts_count'),
                DB::raw('count(c.id) as comments_count'),
                DB::raw("GROUP_CONCAT(r.name SEPARATOR ',') as roles"),
                DB::raw('DATE_FORMAT(users.created_at, "%d.%m.%Yг.") as date')
            ])
            ->leftJoin('user_has_roles as ur', 'users.id', '=', 'ur.user_id')
            ->leftJoin('roles as r', 'ur.role_id', '=', 'r.id')
            ->leftJoin('posts as p', 'users.id', '=', 'p.user_id')
            ->leftJoin('comments as c', function ($j) {
                $j->on('users.id', '=', 'c.user_id')
                    ->whereNull('c.parent_id')
                    ->where('c.commentable_type', Post::class);
            })
            ->where(function ($q) use ($request) {
                if ($search = $request->input('s', false)) {
                    $q->where('users.name', 'like', '%' . $search . '%')
                        ->orWhere('users.email', 'like', '%' . $search . '%');
                }
            })
            ->groupBy('users.id')
            ->orderBy($request->orderBy, $request->order === 'descending' ? 'desc' : 'asc')
            ->paginate($request->count ?? 15);

        return response()->json($users);
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function destroy(User $user)
    {
        abort_if(auth()->user()->is($user), '403', 'Нельзя удалить себя!');

        return response()->json($user->delete());
    }

    public function ban(Request $request, User $user)
    {
        abort_if(auth()->user()->is($user), '403', 'Нельзя заблокировать себя!');

        return response()->json($user->update(['is_banned' => (bool)$request->status]));
    }

    public function update(Request $request, User $user)
    {
        return response()->json($user->update($request->toArray()));
    }

    public function changeRoles(Request $request, User $user)
    {
        abort_if(auth()->user()->is($user), '403', 'Нельзя менять свои роли!');

        return response()->json($user->syncRoles($request->roles));
    }
}