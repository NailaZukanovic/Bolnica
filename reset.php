<?php
include_once("assets/php/funkcije.php");

//korisnici
set("DELETE FROM korisnik");

//admin
set("INSERT INTO korisnik VALUES(NULL,'admin1','admin1','admin1','admin1','musko','mesto','srbija','1997-01-01','111','23423434','a@gmail.com','a.jpg','admin','odobren')");


//lekari
set("INSERT INTO korisnik VALUES(NULL,'lekar1','lekar1','lekar1','lekar1','musko','mesto','srbija','1997-01-01','111','23423434','b@gmail.com','a.jpg','lekar','odobren')");
set("INSERT INTO korisnik VALUES(NULL,'lekar2','lekar2','lekar2','lekar2','musko','mesto','srbija','1997-01-01','111','23423434','c@gmail.com','a.jpg','lekar','odobren')");
set("INSERT INTO korisnik VALUES(NULL,'lekar3','lekar3','lekar3','lekar3','musko','mesto','srbija','1997-01-01','111','23423434','d@gmail.com','a.jpg','lekar','odobren')");
set("INSERT INTO korisnik VALUES(NULL,'lekar4','lekar4','lekar4','lekar4','musko','mesto','srbija','1997-01-01','111','23423434','d@gmail.com','a.jpg','lekar','cekanje')");
set("INSERT INTO korisnik VALUES(NULL,'lekar5','lekar5','lekar5','lekar5','musko','mesto','srbija','1997-01-01','111','23423434','d@gmail.com','a.jpg','lekar','cekanje')");

//pacijent
set("INSERT INTO korisnik VALUES(NULL,'pacijent1','pacijent1','pacijent1','pacijent1','musko','mesto','srbija','1997-01-01','111','23423434','y@gmail.com','a.jpg','pacijent','odobren')");
set("INSERT INTO korisnik VALUES(NULL,'pacijent2','pacijent2','pacijent2','pacijent2','musko','mesto','srbija','1997-01-01','111','23423434','h@gmail.com','a.jpg','pacijent','odobren')");
set("INSERT INTO korisnik VALUES(NULL,'pacijent3','pacijent3','pacijent3','pacijent3','musko','mesto','srbija','1997-01-01','111','23423434','g@gmail.com','a.jpg','pacijent','odobren')");
set("INSERT INTO korisnik VALUES(NULL,'pacijent4','pacijent4','pacijent4','pacijent4','musko','mesto','srbija','1997-01-01','111','23423434','g4@gmail.com','a.jpg','pacijent','cekanje')");
set("INSERT INTO korisnik VALUES(NULL,'pacijent5','pacijent5','pacijent5','pacijent5','musko','mesto','srbija','1997-01-01','111','23423434','g5@gmail.com','a.jpg','pacijent','cekanje')");
