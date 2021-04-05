<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class AdminController extends Controller
{

      public function getIds() {
          $users = DB::table('attlog')->select("employeeID")->distinct()->get();
          return $users;
      } 


       public function photo(Request $request) {

            $ext = $request->file('photo')->getClientOriginalExtension();
            $name = md5(time()).".".$ext;
            $file = $request->file('photo')->move("./files", $name);

            return $file;
        }


        public function usercreate(Request $request) {
            $turi = $request->input("turi"); 
            $id = $request->input("id"); 
            $fio = $request->input("fio"); 
            $lavozim = $request->input("lavozim"); 
            $rasm = $request->input("rasm"); 
         
        

            $inserted = DB::table('users')->updateOrInsert(
              [  'id' => $id,],
              [
                'fio' => $fio,
                'lavozim' => $lavozim,
                'bolim' => $turi,
                'rasm' => $rasm,
              ]);

            return $inserted;
        }

           public function users(Request $request) {
            if($request->has("id")) {
              $id = $request->input("id");
              $users = DB::table('users')->where('bolim', $id)->get();
            }else {
              $users = DB::table('users')->get();
            }  
          

          return $users;
      } 

      public function useredit(Request $request, $id) {
          $data = $request->input('data');
         $data = json_decode($data, true);

         $affected = DB::table('users')
              ->where('id', $id)
              ->update($data);

         return $affected;     
    }

      public function userdelete(Request $request, $id) {
         $affected =  DB::table('users')->where('id', '=', $id)->delete();
         return $affected;
    }


      public function login(Request $request)
            {   
              $login = $request->input('login');
              $parol = $request->input('parol');  

              $users = DB::table('admin')
            ->select('turi')->where('login', '=', $login)->where('parol', '=', $parol)
            ->get();

            return $users;
            }


      public function getizoh() {
          $users = DB::table('izohlar')->get();
          return $users;
      }      


       public function izohcreate(Request $request) {
            $user_id = $request->input("user_id"); 
            $time = $request->input("time"); 
            $izoh = $request->input("izoh"); 
            $izoh_turi = $request->input("izoh_turi"); 
          
        

            $inserted = DB::table('izohlar')->insert([
                'user_id' => $user_id,
                'time' => $time,
                'izoh' => $izoh,
                'izoh_turi' => $izoh_turi,
            ]);

            return $inserted;
        }

            public function izohdelete(Request $request, $id) {
         $affected =  DB::table('izohlar')->where('id', '=', $id)->delete();
         return $affected;
    }



     public function izohedit(Request $request, $id) {
          $data = $request->input('data');
         $data = json_decode($data, true);

         $affected = DB::table('izohlar')
              ->where('id', $id)
              ->update($data);

         return $affected;     
    }


    public function getaparat() {
       $users = DB::table('aparat')->get();
          return $users;
    }

    public function aparatcreate(Request $request) {
            $sana = $request->input("sana"); 

            $inserted = DB::table('aparat')->updateOrInsert(
              [
                'sana' => $sana,
              ],
              [
                'sana' => $sana,
              ]
          );

            return $inserted;
    }
}
