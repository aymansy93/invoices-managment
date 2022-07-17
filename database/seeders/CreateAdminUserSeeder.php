<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profil;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class CreateAdminUserSeeder extends Seeder
{
/**
* Run the database seeds.
*
* @return void
*/
public function run()
{
$user = User::create([
'name' => 'ayman',
'email' => 'ayman@admin.com',
'password' => bcrypt('123456789'),
'roles_name' => ['Admin'],
'status' => 'مفعل',
]);
//
$role = Role::create(['name' => 'Admin']);
$permissions = Permission::pluck('id','id')->all();
$role->syncPermissions($permissions);
$user->assignRole([$role->id]);


//
$id = User::latest()->first()->id;
$roles = User::latest()->first()->roles_name;

Profil::create([
    'user_id' => $id,
    'role' => $roles['0'],
]);

$role1 = Role::create(['name' => 'user']);
$role1->givePermissionTo('الفواتير');
$role1->givePermissionTo('قائمة الفواتير');
$role1->givePermissionTo('paidding');
$role1->givePermissionTo('اضافة فاتورة');
$role1->givePermissionTo('التقارير');
$role1->givePermissionTo('تقرير الفواتير');

}
}
