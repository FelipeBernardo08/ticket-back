<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\ProfileClient;
use App\Models\ProfileAdm;
use App\Models\ProfileProductor;
use App\Models\ProfileEmployee;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'auth',
        'email',
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

    public function client()
    {
        return $this->hasMany(ProfileClient::class, 'id_user');
    }

    public function adm()
    {
        return $this->hasMany(ProfileAdm::class, 'id_user');
    }

    public function productor()
    {
        return $this->hasMany(ProfileProductor::class, 'id_user');
    }

    public function employee()
    {
        return $this->hasMany(ProfileEmployee::class, 'id_user');
    }

    public function permission(): Object
    {
        return $this->belongsTo(Permission::class, 'id_permission');
    }

    public function login($email): string
    {
        $resp = self::where('email', $email)
            ->get()
            ->toArray();
        if (count($resp) != 0) {
            $result = self::where('email', $email)
                ->where('auth', 'approved')
                ->get()
                ->toArray();
            if (count($result) != 0) {
                return 'approved';
            } else {
                return 'pendding';
            }
        }
        return 'inexistente';
    }

    public function returnWithClient($user): array
    {
        return self::where('id', $user->id)
            ->with('client')
            ->get()
            ->toArray();
    }

    public function returnWithAdm($user): array
    {
        return self::where('id', $user->id)
            ->with('adm')
            ->get()
            ->toArray();
    }

    public function returnWithProdutctor($user): array
    {
        return self::where('id', $user->id)
            ->with('productor')
            ->get()
            ->toArray();
    }

    public function returnWithEmployee($user): array
    {
        return self::where('id', $user->id)
            ->with('employee')
            ->with('employee.profile')
            ->with('employee.profile.user')
            ->get()
            ->toArray();
    }

    public function createClient($request): array
    {
        return self::create([
            'email' => $request->email,
            'id_permission' => 1,
            'password' => bcrypt($request->password)
        ])->toArray();
    }

    public function createUser($request): array
    {
        return self::create([
            'email' => $request->email,
            'id_permission' => $request->id_permission,
            'auth' => 'approved',
            'password' => bcrypt($request->password)
        ])->toArray();
    }

    public function createUserEmployee($request): array
    {
        return self::create([
            'email' => $request->email,
            'id_permission' => 4,
            'auth' => 'approved',
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
        $result = self::where('id', $id)
            ->get()
            ->toArray();

        switch ($result[0]['id_permission']) {
            case 1:
                return self::where('id', $id)
                    ->with('permission')
                    ->with('client')
                    ->get()
                    ->toArray();
                break;
            case 2:
                return self::where('id', $id)
                    ->with('permission')
                    ->with('adm')
                    ->get()
                    ->toArray();
                break;
            case 3:
                return self::where('id', $id)
                    ->with('permission')
                    ->with('productor')
                    ->get()
                    ->toArray();
                break;
            case 4:
                return self::where('id', $id)
                    ->with('permission')
                    ->with('employee')
                    ->get()
                    ->toArray();
                break;
            default:
                break;
        }
    }

    public function updateUser(int $id, $request): bool
    {
        if ($request->password != null) {
            return self::where('id', $id)
                ->update([
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'id_permission' => $request->id_permission,
                    'updated_at' => null
                ]);
        } else {
            return self::where('id', $id)
                ->update([
                    'email' => $request->email,
                    'id_permission' => $request->id_permission,
                    'updated_at' => null
                ]);
        }
    }

    public function deleteUser(int $id): bool
    {
        return self::where('id', $id)
            ->delete();
    }

    public function updatePassword($auth, $request): bool
    {
        return self::where('id', $auth[0]['id'])
            ->update([
                "password" => bcrypt($request->newPassword)
            ]);
    }

    public function updatePasswordByEmail(string $email, string $pass): bool
    {
        return self::where('email', $email)
            ->update([
                "password" => bcrypt($pass)
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
