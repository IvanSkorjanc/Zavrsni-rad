<?php

class Komponenta
{


    public static function getKomponente()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        select * from komponenta
        
        ");
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function read($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        select * from komponenta where sifra=:komponenta
        
        ");
        $izraz->execute(['komponenta'=>$id]);
        return $izraz->fetch(PDO::FETCH_ASSOC);

    }


    public static function novi()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        insert into komponenta values
        (null,:naziv,:opis,:proizvodac,:cijena)
        
        ");
        $izraz->execute($_POST);
    }

    public static function promjeni($id)
    {   
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        update komponenta set
        naziv=:naziv,
        opis=:opis,
        proizvodac=:proizvodac,
        cijena=:cijena,
        where sifra=:sifra
        
        ");
        $_POST['sifra']=$id;
        $izraz->execute($_POST);
    }


    public static function brisi($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        delete from komponenta where sifra=:sifra
        
        ");
        $izraz->execute(['sifra'=>$id]);
    }



    public static function isDeletable($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        select count(konfiguracija) from dio where komponenta=:komponenta
        
        ");
        $izraz->execute(['komponenta'=>$id]);
        $ukupno = $izraz->fetchColumn();
        return $ukupno==0;

    }

    
}