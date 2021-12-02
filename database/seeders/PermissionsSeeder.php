<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\Permission;
use Carbon\Carbon;
use DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $modules = array(
            'Category' => 'category',
            'Subcategory'=>'subcategory',
            'User' => 'user' ,
            'UserDocument' => 'user_document' ,
            'UserAddress'=>'user_address',
            'BlogCategory' => 'blog_category',
            'BlogDetails '=> 'blog_details' ,
            'BlogComments' => 'blog_comments'
    
        ); 
        foreach($modules as $key =>$value){
            $permissions=array();
            $create=$value .'_create';
            $update=$value .'_update';
            $delete=$value .'_delete';
            $view=$value .'_view';

            $permissions[] = $create;
            $permissions[] = $update;
            $permissions[] = $delete;
            $permissions[] = $view;

            
            foreach ($permissions as $per) {
               
                Permission::create([
                    'name'          => $per,
                    'module'        => $key,
                    'guard_name'    => 'admin',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ]);
            }
        }
    }
}
