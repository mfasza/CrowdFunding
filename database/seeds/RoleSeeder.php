<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Doctrine\DBAL\Types\Type;

class RoleSeeder extends Seeder
{

    private $user;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // role admin
        $admin = New App\Roles();
        $admin->role = 'admin';
        $admin->save();

        // role user
        $this->user = New App\Roles();
        $this->user->role = "user";
        $this->user->save();

        // ubah default value kolom users.role_id
        Schema::table('users', function (Blueprint $table) {
            Type::addType('uuid', 'Ramsey\Uuid\Doctrine\UuidType');
            $table->uuid('role_id')->default($this->user->role_id)->change();
        });
    }
}
