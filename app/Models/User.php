<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'fone',
        'cpf',
        'auth',
        'email',
        'date_born',
        'id_permission',
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function permission(): Object
    {
        return $this->belongsTo(Permission::class, 'id_permission');
    }

    public function createClient($request): array
    {
        return self::create([
            'email' => $request->email,
            'name' => $request->name,
            'date_born' => $request->date_born,
            'cpf' => $request->cpf,
            'fone' => $request->fone,
            'id_permission' => 1,
            'password' => bcrypt($request->password)
        ])->toArray();
    }

    public function createUser($request): array
    {
        return self::create([
            'email' => $request->email,
            'name' => $request->name,
            'date_born' => $request->date_born,
            'cpf' => $request->cpf,
            'fone' => $request->fone,
            'id_permission' => $request->id_permission,
            'password' => bcrypt($request->password)
        ])->toArray();
    }

    public function readUsers(): array
    {
        return self::with('permission')
            ->get()
            ->toArray();
    }

    public function readUserId(int $id): array
    {
        return self::where('id', $id)
            ->with('permission')
            ->get()
            ->toArray();
    }

    public function updateUser(int $id, $request): bool
    {
        return self::where('id', $id)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                'fone' => $request->fone,
                'cpf' => $request->cpf,
                'date_born' => $request->date_born,
                'password' => bcrypt($request->password),
                'id_permission' => $request->id_permission,
                'updated_at' => null
            ]);
    }

    public function updateUserSelf(int $id, $request): bool
    {
        return self::where('id', $id)
            ->update([
                'name' => $request->name,
                'fone' => $request->fone,
                'cpf' => $request->cpf,
                'date_born' => $request->date_born,
            ]);
    }


    public function deleteUser(int $id): bool
    {
        return self::where('id', $id)
            ->delete();
    }

    public function updatePassword($auth, $request): bool
    {
        return self::where('id', $auth->id)
            ->update([
                "password" => bcrypt($request->newPassword)
            ]);
    }

    public function updatePasswordByEmail(string $email, string $pass): bool
    {
        return self::where('email', $email)
            ->update([
                "password" => $pass
            ]);
    }

    public function confirmAccount(string $email): bool
    {
        return self::where('email', $email)
            ->update([
                'auth' => 'approved'
            ]);
    }

    public function userWithPermission(int $id): array
    {
        return self::where('id', $id)
            ->with('permission')
            ->get()
            ->toArray();
    }
}
