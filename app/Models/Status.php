<?php
/**
 * 微博模型-动态 用户和微博 一对多关系
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //把content 字段设置为可以更新的，Laravel默认保护
    protected $fillable = ['content'];

    /**
     * 该方法指明一条微博属于一个用户，函数名单数
     * @return [type] [description]
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

