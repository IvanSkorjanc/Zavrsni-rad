<?php

class Proizvodac
{


    public static function getProizvodaci()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        select a.sifra, a.zemlja, 
        b.naziv from proizvodac a 
        inner join komponenta b on a.naziv=b.sifra
        ");
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function read($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        select * from proizvodac
        
        ");
        $izraz->execute(['proizvodac'=>$id]);
        return $izraz->fetch(PDO::FETCH_ASSOC);

    }


    public static function novi()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        insert into proizvodac values
        (null,:naziv,:zemlja)
        
        ");
        $izraz->execute([
            'naziv'=>$_POST['naziv'],
            'zemlja'=>$_POST['zemlja']
        ]);

    }

    public static function promjeni($id)
    {   
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        update proizvodac
        set 
            naziv=:naziv,
            zemlja =:zemlja
        
        ");
        $_POST['sifra']=$id;
        $izraz->execute($_POST);
    }


    public static function brisi($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        delete from proizvodac where sifra=:sifra

        
        ");
        $izraz->execute(['sifra'=>$id]);
    }



    public static function isDeletable($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        select count(sifra) from komponenta where proizvodac=:proizvodac
        
        ");
        $izraz->execute(['proizvodac'=>$id]);
        $ukupno = $izraz->fetchColumn();
        return $ukupno==0;

    }

    
}