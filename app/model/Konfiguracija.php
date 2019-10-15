<?php

class Konfiguracija
{


    public static function getKonfiguracije()
    {

        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        select * from konfiguracija

        "
    
        );
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function read($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        select * from konfiguracija
        
        ");
        $izraz->execute(['konfiguracija'=>$id]);
        return $izraz->fetch(PDO::FETCH_ASSOC);

    }


    public static function novi()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        insert into konfiguracija values
        (null,:naziv,:opis,:cijena)
        
        ");
        $izraz->execute([
            'naziv'=>$_POST['naziv'],
            'opis'=>$_POST['opis'],
            'cijena'=>$_POST['cijena']
        ]);
    }

    public static function promjeni($id)
    {   
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        update konfiguracija set 
            naziv=:naziv,
            opis =:opis,
            cijena=:cijena
        
        ");
        $_POST['sifra']=$id;
        $izraz->execute($_POST);
    }


    public static function brisi($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("

        delete from konfiguracija where sifra=:sifra
       
        ");
        $izraz->execute(['sifra'=>$id]);
    }



    public static function isDeletable($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        select count(komponenta) from dio where konfiguracija=:konfiguracija
        
        ");
        $izraz->execute(['konfiguracija'=>$id]);
        $ukupno = $izraz->fetchColumn();
        return $ukupno==0;
    }