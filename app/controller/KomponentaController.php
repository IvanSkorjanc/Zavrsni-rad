<?php

class KomponentaController extends Controller
{

    private $viewGreska="";
    private $id=0;


    public function index($stranica=1)
    {  
        if(isset($_GET["trazi"])){
            $stranica=1;
        }

        if($stranica==1){
            $prethodnaStranica=1;
        }else{
            $prethodnaStranica=$stranica-1;
        }

       


        $ukupnoStranica = Komponenta::ukupnoStranica();

        if($stranica>=$ukupnoStranica){
            $sljedecaStranica=$ukupnoStranica;
        }else{
            $sljedecaStranica=$stranica+1;
        }

        $this->view->render("privatno/komponente/index",
            ["komponente"=>Komponenta::getKomponente($stranica),
            "prethodnaStranica"=>$prethodnaStranica,
            "stranica"=>$stranica,
            "sljedecaStranica"=>$sljedecaStranica,
            "ukupnoStranica"=>$ukupnoStranica]);
    }



    public function pripremaNovi()
    {
        $this->view->render("privatno/komponente/novi");
    }




    public function novi()
    {  
       $this->viewGreska="privatno/komponente/novi";

      if(!$this->kontrole()){
          return;
      }

       Komponenta::novi();
       $this->index();
    }



    public function pripremaPromjeni($id)
    {
      App::setParams(Komponenta::read($id));
      $this->view->render("privatno/komponente/promjeni", ['id'=>$id]);
    }


    public function promjeni($id)
    {
        $this->viewGreska="privatno/komponente/promjeni";
        $this->id=$id;

        if(!$this->kontrole()){
            return;
        }
  
         Komponenta::promjeni($id);
         $this->index();
    }


    public function brisanje($id)
    {  

        if(!Komponenta::isDeletable($id)){
            $this->index();
            return;
        }

       Komponenta::brisi($id);
       $this->index();
    }


    private function kontrole()
    {
        //nema (još) kontrola
    return true;
    }


    //nju za sada nitko ne poziva 
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