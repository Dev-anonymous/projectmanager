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
        $role = auth()->user()->user_role;
        $data = [];
        if ('admin' == $role) {
            $type = request('type');
            $t = User::orderBy('name')->where('user_role', $type)->get();
            if ($type == 'driver') {
                foreach ($t as $el) {
                    $o = (object)$el->toArray();
                    $pro = $el->profils()->first();
                    if ($pro) {
                        $o->solde_cdf = v($pro->solde_cdf, 'CDF');
                        $o->solde_usd = v($pro->solde_usd, 'USD');
                        $o->adresse = $pro->adresse;
                        $o->typepiece = $pro->typepiece;
                        $o->pieceidentite = asset('storage/' . $pro->pieceidentite);
                    }
                    $img = $el->image;
                    if ($img) {
                        $img =   asset('storage/' . $img);
                    } else {
                        $img =   asset('/assets/images/faces/9.jpg');
                    }
                    $o->image = $img;
                    $data[] = $o;
                }
            } else {
                $data = $t;
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
            'user_role' => 'required|in:admin,agent,driver',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'image' => 'sometimes|mimes:jpeg,jpg,png|max:500',
            'phone' => 'required|max:10,min:10',
        ];

        if ('driver' == $user_role) {
            $rules['adresse'] = 'required';
            $rules['image'] = 'required|mimes:jpeg,jpg,png|max:500';
            $rules['pieceidentite'] = 'required|mimes:jpeg,jpg,png|max:500';
            $rules['typepiece'] = 'required|in:' . implode(',', typepiece());
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
        $data['code'] = userid($data['name']);
        $user = User::create($data);

        if ('driver' == $user_role) {
            $data['pieceidentite'] = request()->file('pieceidentite')->store('image', 'public');
            $data['users_id'] = $user->id;
            Profil::create($data);
        }
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
        $user_role = $user->user_role;

        $rules =  [
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id,
            'password' => 'sometimes',
            'image' => 'sometimes|mimes:jpeg,jpg,png|max:500',
            'phone' => 'required|max:10,min:10||unique:users,phone,' . $user->id,
        ];

        if ('driver' == $user_role) {
            $rules['adresse'] = 'required';
            $rules['pieceidentite'] = 'sometimes|mimes:jpeg,jpg,png|max:500';
            $rules['typepiece'] = 'required|in:' . implode(',', typepiece());
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
        if ('driver' == $user_role) {
            $profil = $user->profils()->first();
            if ($request->hasFile('pieceidentite')) {
                File::delete('storage/' . $profil->pieceidentite);
                $data['pieceidentite'] = request()->file('pieceidentite')->store('image', 'public');
            }
            $profil->update($data);
        }
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
        if ('driver' == $user->user_role) {
            $profil = $user->profils()->first();
            if ($profil->solde_usd or $profil->solde_cdf) {
                return [
                    'message' => 'Seuls les comptes avec un solde de 0 peuvent être supprimés.'
                ];
            }

            $n = $profil->depots()->count();
            if ($n) {
                return [
                    'message' => "Ce compte a déjà $n transaction(s), vous ne pouvez donc le supprimé."
                ];
            }
        }
        File::delete('storage/' . $user->image);
        $pro = $user->profils()->first();
        if ($pro) {
            File::delete('storage/' . $pro->pieceidentite);
        }
        $user->delete();
        return ['success' => true, 'message' => 'Compte supprimé'];
    }
}
