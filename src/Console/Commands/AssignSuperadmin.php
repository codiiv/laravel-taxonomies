<?php

namespace Codiiv\Taxonomies\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class AssignSuperadmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'taxonomies:superadmin {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a default super admin user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->argument('email');

        if(User::where('email',$email)->exists()){
          $userX  = User::where('email',$email)->first();
          $userid  = $userX->id;
          $usermeta = new \Codiiv\Extrameta\Models\Usermeta;
          $adminset = \Codiiv\Extrameta\Models\Usermeta::where('user_id',$userid)->where('meta_key','user_level')->first();
          if($adminset){
            $usermeta->user_id = $userid;
            $usermeta->meta_key = 'user_level';
            $usermeta->meta_value = 10;
            $usermeta->update();
            echo 'Super admin updated successfully'. PHP_EOL;
            return '';
          }else{

            $usermeta->user_id = $userid;
            $usermeta->meta_key = 'user_level';
            $usermeta->meta_value = 10;
            $saved  = $usermeta->save();
            $lastInsertedId = $usermeta->id;
            if($lastInsertedId){
              echo 'Super admin set successfully'. PHP_EOL;
              return '';
            }else{
              echo 'There were errors setting admin'. PHP_EOL;
              return '';
            }
          }
        }else{
          echo 'User does NOT exist'. PHP_EOL;
        }
      exit;
    }
}
