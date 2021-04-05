<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class MaktabController extends Controller
{


         public function index(Request $request)
            {   
                $id = $request->input("id");
                $yil = $request->input("yil");
                $filter = array();
                $results = $request->input('results');
                if($request->input('bitirgan_yili')) {
                  array_push($filter, ['maktab_talabalari.bitirgan_yili', '=',$request->input('bitirgan_yili')]);
                }

                 if($request->input('viln')) {
                  array_push($filter, ['maktab_talabalari.viloyat_idsi', '=',$request->input('viln')]);
                }

                 if($request->input('shahn')) {
                  array_push($filter, ['maktab_talabalari.shahar_id', '=',$request->input('shahn')]);
                }

                if($request->input('lavozimi')) {
                  array_push($filter, ['maktab_talabalari.lavozimi', '=',$request->input('lavozimi')]);
                }

                 if($request->input('jinsi')) {
                  array_push($filter, ['maktab_talabalari.jinsi','=',$request->input('jinsi')]);
                }



                if(count($filter) > 0) {
                         $talabalar = DB::table('vakansiya')->
                     select('maktab_talabalari.viloyat_idsi','maktab_talabalari.ism','maktab_talabalari.Id',DB::raw('vakansiya.orin_soni  AS jami'), 'maktab_talabalari.shahar_id', 'maktab_talabalari.familiya', 'maktab_talabalari.otasi', 'maktab_talabalari.manzil', 'maktab_talabalari.telefon', 'maktab_talabalari.bitirgan_yili', 'maktab_talabalari.lavozimi', 'maktab_talabalari.passport', 'maktab_talabalari.jinsi')->
                     leftJoin('maktab_holati', 'maktab_holati.vakansiya_id','vakansiya.id')->
                     rightJoin('maktab_talabalari', 'maktab_talabalari.Id', 'maktab_holati.talaba_id')->
                     groupBy('maktab_talabalari.Id','maktab_talabalari.ism','vakansiya.orin_soni','maktab_talabalari.viloyat_idsi', 'maktab_talabalari.shahar_id', 'maktab_talabalari.familiya', 'maktab_talabalari.otasi', 'maktab_talabalari.manzil', 'maktab_talabalari.telefon', 'maktab_talabalari.bitirgan_yili', 'maktab_talabalari.lavozimi', 'maktab_talabalari.passport', 'maktab_talabalari.jinsi')->
                     where($filter)->
                     where('maktab_talabalari.maktab_id', '=', $id)->
                     where('maktab_talabalari.status', '=', '0')->
                     where('maktab_talabalari.bitirgan_yili', '=', $yil)->
                     paginate($results);
                  }else {
                     $talabalar = DB::table('maktab_holati')->
                     select('maktab_talabalari.viloyat_idsi','maktab_talabalari.ism','maktab_talabalari.Id',DB::raw('vakansiya.orin_soni - count(maktab_holati.talaba_id) AS jami'), 'maktab_talabalari.shahar_id', 'maktab_talabalari.familiya', 'maktab_talabalari.otasi', 'maktab_talabalari.manzil', 'maktab_talabalari.telefon', 'maktab_talabalari.bitirgan_yili', 'maktab_talabalari.lavozimi', 'maktab_talabalari.passport', 'maktab_talabalari.jinsi')->
                     leftJoin('vakansiya', 'vakansiya.id', 'maktab_holati.vakansiya_id')->
                     rightJoin('maktab_talabalari', 'maktab_talabalari.Id', 'maktab_holati.talaba_id')->
                     groupBy('maktab_talabalari.Id','maktab_talabalari.ism','vakansiya.orin_soni','maktab_talabalari.viloyat_idsi', 'maktab_talabalari.shahar_id', 'maktab_talabalari.familiya', 'maktab_talabalari.otasi', 'maktab_talabalari.manzil', 'maktab_talabalari.telefon', 'maktab_talabalari.bitirgan_yili', 'maktab_talabalari.lavozimi', 'maktab_talabalari.passport', 'maktab_talabalari.jinsi')->
                      where('maktab_talabalari.maktab_id', '=', $id)->
                     where('maktab_talabalari.status', '=', '0')->
                     where('maktab_talabalari.bitirgan_yili', '=', $yil)->
                     paginate($results);
                  }
          
              return $talabalar;

            }

            public function bitiruvchiexcel(Request $request) {
               $id = $request->input("id");
              $talabalar = DB::table('maktab_holati')->
                     select('maktab_talabalari.viloyat_idsi','maktab_talabalari.ism','maktab_talabalari.Id',DB::raw('vakansiya.orin_soni - count(maktab_holati.talaba_id) AS jami'), 'maktab_talabalari.shahar_id', 'maktab_talabalari.familiya', 'maktab_talabalari.otasi', 'maktab_talabalari.manzil', 'maktab_talabalari.telefon', 'maktab_talabalari.bitirgan_yili', 'maktab_talabalari.lavozimi', 'maktab_talabalari.passport', 'maktab_talabalari.jinsi')->
                     leftJoin('vakansiya', 'vakansiya.id', 'maktab_holati.vakansiya_id')->
                     rightJoin('maktab_talabalari', 'maktab_talabalari.Id', 'maktab_holati.talaba_id')->
                     groupBy('maktab_talabalari.Id','maktab_talabalari.ism','vakansiya.orin_soni','maktab_talabalari.viloyat_idsi', 'maktab_talabalari.shahar_id', 'maktab_talabalari.familiya', 'maktab_talabalari.otasi', 'maktab_talabalari.manzil', 'maktab_talabalari.telefon', 'maktab_talabalari.bitirgan_yili', 'maktab_talabalari.lavozimi', 'maktab_talabalari.passport', 'maktab_talabalari.jinsi')->
                      where('maktab_talabalari.maktab_id', '=', $id)->
                     where('maktab_talabalari.status', '=', '0')->
                     get();

                     return $talabalar;
            }
            public function muta()
            {   
          

                // return $request->input('gender');
            $muta = DB::table('mutaxasislik')->get();
                return $muta;
            }

            public function lavozim(Request $request)
            {   

              $data =  $request->input("data");

              $data = json_decode($data, true);

               foreach ($data as $value) {
                      $up = array();
                      if(isset($value['lavozimi'])) {
                          $up = array_merge($up, ['lavozimi'=> $value['lavozimi']]);
                      }

                      if(isset($value['vil_id'])) {
                          $up = array_merge($up, ['viloyat_idsi'=> $value['vil_id']]);
                      }

                      if(isset($value['shahar_id'])) {
                          $up = array_merge($up, ['shahar_id'=> $value['shahar_id']]);
                      }

                     
                            DB::table('maktab_talabalari')
                          ->where('id', $value['id'])
                          ->update($up);    
                      

                         
                } 

              return $data;               
            
            }
             public function search(Request $request)
            {   

                $bit_yili = $request->input('bitirgan_yili'); 
                $results = $request->input('results');
                $search = $request->input('query');
                $muassasa = $request->input('id'); 

                if($bit_yili) {
                     $talabalar = DB::table('maktab_talabalari')       
                ->where('ism', 'like', '%'.$search.'%')
                ->orWhere('familiya', 'like', '%'.$search.'%')->where('bitirgan_yili', $bit_yili)->where('maktab_id', $muassasa)->paginate($results);
                return $talabalar;
                
            }else {
                 $talabalar = DB::table('maktab_talabalari')       
                ->where('ism', 'like', '%'.$search.'%')
                ->orWhere('familiya', 'like', '%'.$search.'%')->where('maktab_id', $muassasa)->paginate($results);
                return $talabalar;
            }


            
            }





             public function avatar(Request $request)
                {
                   $request->file('file')->move('assets', 'avatar.png');
                   return $request;
                }




            public function create(Request $request)
                {
                  $maktab = $request->input('maktab');
                  $ism = $request->input('ism');  
                  $fam = $request->input('fam');  
                  $sharf = $request->input('sharf');  
                  $passport = $request->input('passport');  
                  $jinsi = $request->input('jinsi');  
                  $vil = $request->input('vil');  
                  $shah = $request->input('shah');  
                  $muta = $request->input('muta');  
                  $manzil = $request->input('manzil');  
                  $tel = $request->input('tel'); 
                  $bit_yili = $request->input('bit_yili'); 
                  // $sec_id = $request->input('sec_id');
                  // $maktab_id = $request->input('maktab_id');

                  $id = DB::table('maktab_talabalari')->insertGetId([
                        'ism' => $ism,
                        'familiya' => $fam,
                        'otasi' => $sharf,
                        'passport' => $passport,
                        'viloyat_idsi' => $vil,
                        'shahar_id' => $shah,
                        'lavozimi' => $muta,
                        'manzil' => $manzil,
                        'telefon' => $tel,
                        'bitirgan_yili' => $bit_yili,
                        'jinsi' => $jinsi,
                        'maktab_id'=> $maktab
                    ]
                    );

                    return $id;
                }



                 public function update(Request $request)
                {
                
                    $id = $request->input('id');
                  $ism = $request->input('ism');  
                  $fam = $request->input('fam');  
                  $sharf = $request->input('sharf');  
                  $passport = $request->input('passport');  
                  $jinsi = $request->input('jinsi');  
                  $vil = $request->input('vil');  
                  $shah = $request->input('shah');  
                  $muta = $request->input('muta');  
                  $manzil = $request->input('manzil');  
                  $tel = $request->input('tel');  
                  // $sec_id = $request->input('sec_id');
                  // $maktab_id = $request->input('maktab_id');


                $affected = DB::table('maktab_talabalari')
                  ->where('Id', $id)
                  ->update([  
                        'ism' => $ism,
                        'familiya' => $fam,
                        'otasi' => $sharf,
                        'passport' => $passport,
                        'viloyat_idsi' => $vil,
                        'shahar_id' => $shah,
                        'lavozimi' => $muta,
                        'manzil' => $manzil,
                        'telefon' => $tel,
                        'jinsi' => $jinsi,
                        'time_update'=> Carbon::now(),
                    ]);

                    return $affected;
                }
            

            public function delete(Request $request)
                {
                
                    $id = $request->input('id');
               
                    $affected = DB::table('maktab_talabalari')->where('Id', '=', $id)->delete();
                    return $affected;
                }





                 public function ishbilantaminlash(Request $request)
                {
                
                   $id = $request->input('id'); 
                   $nomi = null;
                   $manzil = null;
                   $buyruq = null;
                   $tel =null;
                   $yonalish = null;
                   $izoh = null;
                   $vak_id= 0;
                   $file = null;
                   $lavozimi = null;
                   if($request->has('nomi')) {
                      $nomi = $request->input('nomi'); 
                   } 
                     if($request->has('extra_lavozim')) {
                      $lavozimi = $request->input('extra_lavozim'); 
                   } 
                    if($request->has('file')) {
                      $file = $request->input('file'); 
                   } 
                    if($request->has('buyruq')) {
                      $buyruq = $request->input('buyruq'); 
                   } 
                   $lavozim = $request->input('lavozim');

                    if($request->has('manzil')) {
                        $manzil = $request->input('manzil'); 
                     }   
                     if($request->has('tel')) {
                        $tel = $request->input('tel'); 
                      }   

                       if($request->has('yonalish')) {
                          $yonalish = $request->input('yonalish'); 
                      }   
                       if($request->has('izoh')) {
                          $izoh = $request->input('izoh'); 
                      }   
                   
                       if($request->has('izoh')) {
                          $izoh = $request->input('izoh'); 
                      }
                        if($request->has('vakansiya_id')) {
                          $vak_id = $request->input('vakansiya_id'); 
                        }  
                    
                  DB::table('maktab_talabalari')->where('Id', $id)->update(['status'=> 1]); 

                  $id = DB::table('maktab_holati')->updateOrInsert(
                    [
                        'talaba_id'=> $id
                    ],
                    [
                        'talaba_id' => $id,
                        'muossasa_nomi' => $nomi,
                        'buyruq_raqami' => $buyruq,
                        'bandlik_id' => $lavozim,
                        'vakansiya_id'=> $vak_id,
                        'muassasa_manzil' => $manzil,
                        'muassasa_tel' => $tel,
                        'yonalish' => $yonalish,
                        'izoh' => $izoh,
                        'file_nomi' => $file,
                        'lavozimi'=> $lavozimi
                    ]
                    );

                    return $id;
                }

                public function excel(Request $request) {

                        $data = $request->input('data');

                        $data = json_decode($data, true);

                         DB::table('maktab_talabalari')->insertOrIgnore($data);
                    
                }

                public function vildist(Request $request) {
              $id = $request->input('id');
              
              $vils = DB::table('maktab_talabalari')->join('viloyatlar', 'maktab_talabalari.viloyat_idsi', '=', 'viloyatlar.Id')->select('viloyatlar.Id as value', 'viloyatlar.nomi as text')->distinct()->where('maktab_id','=', $id)->get();
              return $vils; 
          } 

            public function shahdist(Request $request) {
              $id = $request->input('id');
              
              $vils = DB::table('maktab_talabalari')->join('shaharlar', 'maktab_talabalari.shahar_id', '=', 'shaharlar.Id')->select('shaharlar.Id as value', 'shaharlar.nomi as text')->distinct()->where('maktab_id','=', $id)->get();
              return $vils; 
          }

            public function mutadist(Request $request) {
              $id = $request->input('id');
            
              $vils = DB::table('maktab_talabalari')->join('mutaxasislik', 'maktab_talabalari.lavozimi', '=', 'mutaxasislik.id')->distinct()->select('mutaxasislik.id as value', 'mutaxasislik.mutaxasis_nomi as text'  )->where('maktab_id','=', $id)->get();
              return $vils; 
           }


          public function bandlik() {

               $shahs = DB::table('bandlik')->get();
                return $shahs;
          }


           public function hisobot(Request $request) {
                $id = $request->input('id');
                $yil = $request->input("yil");
               $shahs = DB::table('maktab_talabalari')->leftJoin("maktab_holati", 'maktab_talabalari.Id', '=', 'maktab_holati.talaba_id')->select('maktab_talabalari.*', 'maktab_holati.bandlik_id')->
               where('maktab_talabalari.maktab_id', $id)->where('maktab_talabalari.bitirgan_yili', $yil)
               ->get();
                return $shahs;
            }   


        public function ishfile(Request $request) {

            $ext = $request->file('document')->getClientOriginalExtension();
            $name = md5(time()).".".$ext;
            $file = $request->file('document')->move("./files", $name);

            return $file;
        }


        public function untasdiq(Request $request) {
                $id = $request->input('id'); 
               $data =  DB::table('maktab_talabalari')->where('Id', $id)->update(['status'=> 0]);
               DB::table('maktab_holati')->where('talaba_id', '=', $id)->delete();

                return $data;
        }
            

        public function maktab_name(Request $request) {
            $id = $request->input('id'); 

             $data =DB::table('maktablar')->select("shahar_id", "nomi")->where('Id', $id)->get();

             return $data;
        }   

}
