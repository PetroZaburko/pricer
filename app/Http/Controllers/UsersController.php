<?php

namespace App\Http\Controllers;

use App\History;
use App\Rules\CheckOldPassword;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::where('company_id', Auth::user()->company_id)->paginate(config('view.per_page'));
        return view('pages.users', ['users' => $users]);
    }


    public function update(Request $request, $id)
    {
//        $user = User::find($id);
        $user = User::where('id', $id)->where('company_id', Auth::user()->company_id)->first();
        if(!$request->filled('password')){
            $this->validate($request, [
                'name' => 'required',
                'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            ]);
            $user->update($request->except('password'));
        }
        else{
            $this->validate($request, [
                'name' => 'required',
                'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
                'old_password' => ['required', new CheckOldPassword($user->getAuthPassword())],
                'password' => ['required', 'string', 'min:8', 'confirmed']
            ]);
            $user->update([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password'))
            ]);
        }

        return response()->json([
            'name' => $user->name,
            'email' =>$user->email,
            'status' => $user->wasChanged()

        ]);
    }

    public function delete($id)
    {
//        $user = User::find($id);
        $user = User::where('id', $id)->where('company_id', Auth::user()->company_id)->first();
        $user->delete();
        return response()->json([
            'message' => "User $user->name is deleted !!!"
        ]);
    }

    public function status($id)
    {
        $user = User::find($id);

        if (User::all()->where('status', 1)->where('is_admin', 1)->count() == 1 ) {
            if($user->status == 1 && $user->is_admin == 1) {
                return response()->json([
                    'message'=> "$user->name is the last active admin, there must be at least one active admin",
                    'rejected' => 1,
                    'status' => 0
                ]);
            }
        }
        $user->toggleStatus(!$user->status);
//        return redirect()->back()->with([
//            'message'=> ($user->status) ? "User $user->name enabled": "User $user->name disabled",
//            'status' => $user->status
//        ]);
        return response()->json([
            'message'=> "User $user->name " . $user->getUserStatus(),
            'rejected' => 0,
            'status' => $user->status
        ]);
    }

    public function permissions($id)
    {
        $user = User::find($id);

        if (User::all()->where('status', 1)->where('is_admin', 1)->count() == 1 ) {
            if($user->status == 1 && $user->is_admin == 1) {
                return response()->json([
                    'message'=> "$user->name is the last active admin, there must be at least one active admin",
                    'rejected' => 1,
                    'status' => 0
                ]);
            }
//            return redirect()->back()->with([
//                'message'=> "$user->name is the last admin in system, there must be at least one admin ",
//                'status' => 0
//            ]);
        }
        $user->changePermissions(!$user->is_admin);
//        return redirect()->back()->with([
//          'message'=> ($user->is_admin) ? "User $user->name permissions are Admin": "User $user->name permissions are User",
//          'status' => $user->is_admin
//        ]);
        return response()->json([
            'message'=> ($user->is_admin) ? "User $user->name permissions are Admin": "User $user->name permissions are User",
            'rejected' => 0,
            'status' => $user->is_admin
        ]);
    }


    public function history($userId)
    {
//        $histories = History::where('user_id', $userId)->where('company_id', Auth::user()->company_id)->orderBy('id', 'desc')->paginate(config('view.per_page'));
//        return view('pages.history', ['histories' => $histories ]);

        $histories = History::where('user_id', $userId)->where('company_id', Auth::user()->company_id)->orderBy('id', 'desc')->get();

        $result = [];
        foreach ($histories as $history) {
            $elem = [
                'id' => "<b><a href=" . route('history.details', ['id' => $history->id]) .">$history->id</a></b>",
                'date' => $history->created_at->format('d-m-Y'),
                'time' => $history->created_at->format('H:i:s'),
                'category'=> $history->category->title,
                'action' => $history->getFormattedAction(),
                'author' => $history->user->name,
                'company' => $history->company->name
            ];
            array_push($result, $elem);
        }
        return view('pages.history',['result' => json_encode($result)]);
    }


}
