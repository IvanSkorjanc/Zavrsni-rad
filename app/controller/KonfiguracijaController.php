<?php

class KonfiguracijaController extends Controller
{

    private $viewGreska="";
    private $id=0;


    public function index()
    {  
        $this->view->render("privatno/konfiguracije/index",
            ["konfiguracije"=>Konfiguracija::getKonfiguracije()]);
    }



    public function pripremaNovi()
    {
        $this->view->render("privatno/konfiguracije/novi",
        ["smjerovi"=>Smjer::getSmjerovi(),
        "predavaci"=>Predavac::getPredavaci()]);
    }




    public function novi()
    {  
       $this->viewGreska="privatno/konfiguracije/novi";

      if(!$this->kontrole()){
          return;
      }

       Konfiguracija::novi();
       $this->index();
    }



    public function pripremaPromjeni($id)
    {
        $konfiguracija = Konfiguracija::read($id);  
        $konfiguracija["datumpocetka"] = date("c",strtotime($konfiguracija["datumpocetka"]));
        App::setParams($grupa);

       $this->view->render("privatno/konfiguracije/promjeni", 
       ['id'=>$id,
       "smjerovi"=>Smjer::getSmjerovi(),
       "predavaci"=>Predavac::getPredavaci()]);
    }


    public function promjeni($id)
    {
        $this->viewGreska="privatno/konfiguracije/promjeni";
        $this->id=$id;

        if(!$this->kontrole()){
            return;
        }
  
        Konfiguracija::promjeni($id);
         $this->index();
    }


    public function brisanje($id)
    {  

        if(!Konfiguracija::isDeletable($id)){
            $this->index();
            return;
        }

        Konfiguracija::brisi($id);
       $this->index();
    }


    private function kontrole()
    {
        return true;
    }

    private function greska($polje,$poruka)
    {
        $this->view->render($this->viewGreska,
            ['greska'=>
                ['polje'=>$polje,
                 'poruka'=>$poruka],
             'id'=>$this->id
            ]);
    }


}