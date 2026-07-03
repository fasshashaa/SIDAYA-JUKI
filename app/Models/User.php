<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    protected $fillable = [
    'name',
    'email',
    'password',
    'role', // PASTIKAN KOLOM INI ADA DI SINI
    'status',
];
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
public function penerimaManfaat()
    {
        return $this->hasOne(PenerimaManfaat::class);
    }
    
    // Pastikan juga relasi lain sudah ada
    public function uep() 
    { 
        return $this->hasOne(Uep::class); 
    }

    public function kube() 
    { 
        return $this->hasOne(Kube::class); 
    }
}
