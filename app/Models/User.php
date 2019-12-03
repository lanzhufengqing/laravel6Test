<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Str;//生成用户激活令牌随机字符串

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     * 这些字段是可以更新的
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";

    }

    /**
     * boot 方法会在用户模型类完成初始化之后进行加载
     * @return [type] [description]
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            //数据入库前生成给用户生成activation_token注册令牌
            $user->activation_token = Str::random(10);
        });
    }

    /**
     * 用户和微博一对多关联，指明一个用户可以有多条微博，函数名复数
     * @return [type] [description]
     */
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }


}
