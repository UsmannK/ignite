<?php
use Illuminate\Database\Seeder;
use App\Models\Role;
class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		Role::firstOrCreate(['name' => 'mentor']);
        Role::firstOrCreate(['name' => 'admin']);
    	Role::firstOrCreate(['name' => 'mentee']);
    }
}