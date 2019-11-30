<?php

use Illuminate\Database\Seeder;
use App\Models\User; //引入模型

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return [type] [<description>] void
     */
    public function run()
    {
        //填充50条数据
        $users = factory(User::class)->times(50)->make();
        //makeVisible 临时显示User Model里的隐藏属性
        User::insert($users->makeVisible(['password', 'remember_token'])->toArray());
    }
}
