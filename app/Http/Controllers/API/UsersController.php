<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Profil;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = request('filiere_has_promotion_id');
        $role = auth()->user()->user_role;
        $data = [];
        if ('admin' == $role) {
            $type = request('type');
            $t = User::orderBy('name')->where('user_role', $type);

            if ($id) {
                if ('student' == $type) {
                    $t->where('filiere_has_promotion_id', $id);
                }
            }

            foreach ($t->get() as $el) {
                $o = (object)$el->toArray();
                $o->image = userimage($el);
                if ('student' == $type) {
                    $h = $el->filiere_has_promotion()->first();
                    $o->promotion = "{$h->promotion->promotion} {$h->filiere->filiere}";
                }
                $data[] = $o;
            }
        }

        return [
            'success' => true,
            'data' => $data
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_role = request('user_role');
        $rules =  [
            'user_role' => 'required|in:admin,student',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'image' => 'sometimes|mimes:jpeg,jpg,png|max:500',
            'phone' => 'required|max:10,min:10',
        ];

        if ('student' == $user_role) {
            $rules['filiere_has_promotion_id'] = 'required|exists:filiere_has_promotion,id';
        }

        $validator = Validator::make(request()->all(), $rules);

        if ($validator->fails()) {
            return [
                'message' => implode(" ", $validator->errors()->all())
            ];
        }

        $phone = request('phone');
        if (!isvalidenumber($phone)) {
            return [
                'message' => "Numéro de téléphone non valide"
            ];
        }
        $data  = $validator->validated();

        DB::beginTransaction();
        if ($request->hasFile('image')) {
            $data['image'] = request()->file('image')->store('image', 'public');
        }

        $data['password'] = Hash::make($data['password']);
        $data['name'] = ucfirst($data['name']);
        $data['users_id'] = auth()->user()->id;
        $user = User::create($data);

        DB::commit();

        return ['success' => true, 'message' => 'Utilisateur créé.'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $u = auth()->user();
        $user_role = $user->user_role;
        $rules =  [
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id,
            'password' => 'sometimes',
            'image' => 'sometimes|mimes:jpeg,jpg,png|max:500',
            'phone' => 'required|max:10,min:10||unique:users,phone,' . $user->id,
        ];

        $validator = Validator::make(request()->all(), $rules);

        if ($validator->fails()) {
            return [
                'message' => implode(" ", $validator->errors()->all())
            ];
        }
        $phone = request('phone');
        if (!isvalidenumber($phone)) {
            return [
                'message' => "Numéro de téléphone non valide"
            ];
        }
        $data  = $validator->validated();
        $ps = request('password');
        if (!empty($ps)) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('image')) {
            File::delete('storage/' . $user->image);
            $data['image'] = request()->file('image')->store('image', 'public');
        }

        $data['name'] = ucfirst($data['name']);
        DB::beginTransaction();
        $user->update($data);
        DB::commit();

        return ['success' => true, 'message' => 'Utilisateur mis à jour.'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (auth()->user()->id == $user->id) {
            return [
                'message' => 'Veuillez demander à un autre administrateur de supprimer votre compte'
            ];
        }
        if ('student' == $user->user_role) {
            $n = $user->projects()->count();
            if ($n) {
                return [
                    'message' => "Ce compte est déjà lié à $n projet(s), vous ne pouvez donc le supprimé."
                ];
            }
        }
        File::delete('storage/' . $user->image);
        $user->delete();
        return ['success' => true, 'message' => 'Compte supprimé'];
    }
}
