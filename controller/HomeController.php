<?php 
class HomeController extends Controller{
	public $layout = "home_layout";
        
	public function index(){
            $data = Postal::getAll("","postal");
            //var_dump($all);
            $this->loadView('index',$data);
        }
        
        public function postalCodes(){
            $data = Postal::getAll("","postal");
            //var_dump($all);
            $this->response(array('data'=>$data));
        }
       private function response($response){
           header('Content-type:aplication/json');
            echo json_encode($response);
        }
        public function loadData(){
           $region = $_POST['region'];
          
            $data = Postal::getAll("WHERE postal={$region}");
           
            if(!empty($data)){
                $datas = array(
                    'message'=>'Success',
                    'postals'=>$data,
                    'error'=>false
                );
                $this->response($datas);
            }else{
                $data = array(
                    'error'=>true,
                    'message'=>'No data'
                );
                $this->response($data);
            }
        }
           public function update(){
               $postal = new Postal();
               $postal->id = $_POST['id'];
               $postal->city = $_POST['city'];
               $postal->region_name = $_POST['region_name'];
               $postal->region_iso = $_POST['region_iso'];
               $postal->latitude =  $_POST['latitude'];
               $postal->longitude = $_POST['longitude'];
              if($postal->save()){
                $this->response(array('message'=>'Uspesno ste izmenili podatke.','error'=>false));
              }else{
                  $this->response(array('message'=>'Doslo je do greske.','error'=>true));
              }
         }
         
         public function insert(){
            $postal = new Postal();
            //$postal->id = $_POST['id'];
            $postal->postal = $_POST['input_postal'];
            $postal->city = $_POST['city'];
            $postal->region_name = $_POST['region_name'];
            $postal->region_iso = $_POST['region_iso'];
            $postal->latitude =  $_POST['latitude'];
            $postal->longitude =  $_POST['longitude'];
            if ($postal->insert()) {
                $this->response(array('message' => 'Uspesno ste uneli podatke.', 'error' => false));
            } else {
                $this->response(array('message' => 'Doslo je do greske.', 'error' => true));
            }
        }
        
        public function delete(){
            $id = $_POST['id'];
            $postal = new Postal();
            if ($postal->delete($id)) {
                $this->response(array('message' => 'Uspesno ste obrisali podatke.', 'error' => false));
            } else {
                $this->response(array('message' => 'Doslo je do greske.', 'error' => true));
            }
            
        }
        
        public function search(){
            $postal = $_POST['postal_search'];
            $p = Postal::getAll("WHERE postal='{$postal}'","latitude,longitude");
            if (!empty($p)) {
                $this->response(array('message' => 'Uspesno', 'error' => false,'postal'=>$p));
            } else {
                $this->response(array('message' => 'Nepostoji uneti postal code.', 'error' => true));
            }
        }
    }
           
