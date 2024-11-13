<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
                'name',
                'email',
                'email_verified_at',
                'mobile',
                'mobile_verified_at',
                'otp_token',
                'email_verified_at',
                'password',
                'remember_token',
                'username',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'otp_token',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'mobile_verified_at' => 'datetime',
    ];

    /**
     * Generate OTP
     *
     * @return void
     */
    public static function newOTP(): int
    {
        return rand(100000, 999999);
    }

    /**
     * Register new Shop
     *
     * @param string $phone
     * @return void
     */
    public static function register(string $mobilePhone): self
    {
    
       // If phone exist, Generate a new token instead and 
       // Send it back. 
       if($shop = self::byMobile($mobilePhone)->first()){

           $shop->otp_token = self::newOTP();
           $shop->save();

           return $shop;
       }

        // New Shop, Create it
       return self::create([
            'name' => $mobilePhone,
            'email' => $mobilePhone ."@butike.com",
            'email_verified_at' => now(),
            'mobile' => $mobilePhone,
            'otp_token' => self::newOTP(),
            'password' =>  Hash::make(Str::random(20)),
            'remember_token' => Str::random(10),
        ]);
    }

    /**
     * Mobile phone
     *
     * @param QueryBuilder $query
     * @param string $mobile
     * @return void
     */
    public function scopeByMobile($query, string $mobile)
    {
        return $query->where("mobile", $mobile);
    }

    /**
     * Verify Mobile phon
     *
     * @param string $phone
     * @return self
     */
    public function scopeVerify($query)
    {
        return $query->update([
            "mobile_verified_at" => now()
        ]);
    }

        public function getAvatarAttribute($value)
    {
      return asset($value ? 'storage/'.$value : 'images/default-avatar.svg');
    }
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

     public function getAccountTypeAttribute()
          {
            $this->attribute['is_Admin'] = true;
          }
     public function posts()
     {
        return $this->hasMany(Post::class)->orderBy('created_at','DESC');
     }

      public function comments()
      {
        return $this->hasMany(Commnet::class);
      }
}
