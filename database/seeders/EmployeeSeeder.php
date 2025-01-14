<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        $employees = [
            ['Albertina','Dyet','Albertina Dyet'],
            ['Rubina','Elion','Rubina Elion'],
            ['Nobie','Sand','Nobie Sand'],
            ['Etti','Garman','Etti Garman'],
            ['Ansell','Durant','Ansell Durant'],
            ['Crissie','Hollyer','Crissie Hollyer'],
            ['Norry','Christofe','Norry Christofe'],
            ['Vivianne','Aggs','Vivianne Aggs'],
            ['Abagael','Ozelton','Abagael Ozelton'],
            ['Cthrine','Jeste','Cthrine Jeste'],
            ['Danya','Farrey','Danya Farrey'],
            ['Reed','Jacquot','Reed Jacquot'],
            ['Fayth','Fossey','Fayth Fossey'],
            ['Rena','Callaby','Rena Callaby'],
            ['Julietta','Helix','Julietta Helix'],
            ['Zahara','Dengate','Zahara Dengate'],
            ['Claiborne','Westman','Claiborne Westman'],
            ['Sibylle','Stanbury','Sibylle Stanbury'],
            ['Eula','Fink','Eula Fink'],
            ['Marlie','Castrillo','Marlie Castrillo'],
            ['Viva','Neenan','Viva Neenan'],
            ['Cobbie','Wilden','Cobbie Wilden'],
            ['Quinn','Pawlowicz','Quinn Pawlowicz'],
            ['Drud','McNaughton','Drud McNaughton'],
            ['Colet','Lanegran','Colet Lanegran'],
            ['Nickie','Tolliday','Nickie Tolliday'],
            ['Calypso','Gawne','Calypso Gawne'],
            ['Stephani','Pithie','Stephani Pithie'],
            ['Brenda','Dury','Brenda Dury'],
            ['Dulcie','Portigall','Dulcie Portigall'],
            ['Nicolas','Stivani','Nicolas Stivani'],
            ['Fania','Cleobury','Fania Cleobury'],
            ['Pierce','MacGiolla','Pierce MacGiolla'],
            ['Timmi','Loveland','Timmi Loveland'],
            ['Karil','Zorzi','Karil Zorzi'],
            ['Odey','Boyce','Odey Boyce'],
            ['Eunice','Merle','Eunice Merle'],
            ['Teddy','Cleaves','Teddy Cleaves'],
            ['Retha','Stuchbury','Retha Stuchbury'],
            ['Deerdre','Zanolli','Deerdre Zanolli'],
            ['Friedrich','Bilham','Friedrich Bilham'],
            ['Amory','Hurlston','Amory Hurlston'],
            ['Clara','Peeter','Clara Peeter'],
            ['Michel','Janata','Michel Janata'],
            ['Saunder','Jaray','Saunder Jaray'],
            ['Abram','Arndtsen','Abram Arndtsen'],
            ['Bobine','Rottgers','Bobine Rottgers'],
            ['Peirce','Standbridge','Peirce Standbridge'],
            ['Fawn','Cottell','Fawn Cottell'],
            ['Marrilee','Elgood','Marrilee Elgood'],
            ['Viviyan','Nordass','Viviyan Nordass'],
            ['Junina','Bailey','Junina Bailey'],
            ['Rea','Block','Rea Block'],
            ['Guillermo','Seely','Guillermo Seely'],
            ['Seward','Burtwhistle','Seward Burtwhistle'],
            ['Hardy','Cansdall','Hardy Cansdall'],
            ['Kally','Wagge','Kally Wagge'],
            ['Annabel','Ardley','Annabel Ardley'],
            ['Jeffry','Greaves','Jeffry Greaves'],
            ['Rosemary','Somerbell','Rosemary Somerbell'],
            ['Natala','Scrowton','Natala Scrowton'],
            ['Clovis','Turnpenny','Clovis Turnpenny'],
            ['Valina','Borres','Valina Borres'],
            ['Dionysus','Steggles','Dionysus Steggles'],
            ['Husein','Ounsworth','Husein Ounsworth'],
            ['Hewet','Houseago','Hewet Houseago'],
            ['Trip','Gaywood','Trip Gaywood'],
            ['Shaun','Vonderdell','Shaun Vonderdell'],
            ['Rudie','McCormack','Rudie McCormack'],
            ['Georgeanna','Bertolaccini','Georgeanna Bertolaccini'],
            ['Gerladina','Ciric','Gerladina Ciric'],
            ['Babbette','Astin','Babbette Astin'],
            ['Archie','Ault','Archie Ault'],
            ['Rik','Roney','Rik Roney'],
            ['Dorolice','Ogdahl','Dorolice Ogdahl'],
            ['Selie','Hellin','Selie Hellin'],
            ['Margarita','Hanaford','Margarita Hanaford'],
            ['Monah','Anthonsen','Monah Anthonsen'],
            ['Nadine','Kuhne','Nadine Kuhne'],
            ['Aron','Fritschmann','Aron Fritschmann'],
            ['Horatio','Muzzall','Horatio Muzzall'],
            ['Constance','Bilston','Constance Bilston'],
            ['Mandy','Veljes','Mandy Veljes'],
            ['Moreen','Allabarton','Moreen Allabarton'],
            ['Guthrie','MacGoun' ,'GuthrMac Gounname' ],
            ['Geralda','Meekins','Geralda Meekins'],
            ['Urbano','Rosettini','Urbano Rosettini'],
            ['Cher','Ricciardelli','Cher Ricciardelli'],
            ['Essy','Dullingham','Essy Dullingham'],
            ['Constantine','Ingerman','Constantine Ingerman'],
            ['Colet','Breens','Colet Breens'],
            ['De','Goforth','De Goforth'],
            ['Archambault','Daveridge','Archambault Daveridge'],
            ['Shirlene','Stockhill','Shirlene Stockhill'],
            ['Alyce','Wooffitt','Alyce Wooffitt'],
            ['Minny','Walklott','Minny Walklott'],
            ['Farr','Sperling','Farr Sperling'],
            ['Alonso','Zylbermann','Alonso Zylbermann'],
            ['Nicolais','Sheasby','Nicolais Sheasby'],
            ['Hermy','Shuter','Hermy Shuter'],
            ['Marjorie','Lally','Marjorie Lally'],
            ['Fawnia','Raper','Fawnia Raper'],
            ['Nelie','Rohloff','Nelie Rohloff'],
            ['Wilona','Kaine','Wilona Kaine'],
            ['Dona','Theakston','Dona Theakston'],
            ['Geoffrey','Raye','Geoffrey Raye'],
            ['Bria','Vispo','Bria Vispo'],
            ['Jenilee','Iacovucci','Jenilee Iacovucci'],
            ['Chelsy','Maxsted','Chelsy Maxsted'],
            ['Melodee','Robilart','Melodee Robilart'],
            ['Rooney','Heasman','Rooney Heasman'],
            ['Katrinka','Spurritt','Katrinka Spurritt'],
            ['Ansell','Underhill','Ansell Underhill'],
            ['Diahann','Pudge','Diahann Pudge'],
            ['Dollie','Stansby','Dollie Stansby'],
            ['Bili','Linck','Bili Linck'],
            ['Fidela','Brocking','Fidela Brocking'],
            ['Norene','Doel','Norene Doel'],
            ['Tedra','Enriques','Tedra Enriques'],
            ['Harwilll','Vannuccinii','Harwilll Vannuccinii'],
            ['Blair','Ciccerale','Blair Ciccerale'],
            ['Fedora','Davydoch','Fedora Davydoch'],
            ['Dylan','Polin','Dylan Polin'],
            ['Timmie','Yuryatin','Timmie Yuryatin'],
            ['Gerrard','Cargill','Gerrard Cargill'],
            ['Katharina','Haskett','Katharina Haskett'],
            ['Ninetta','Stallworth','Ninetta Stallworth'],
            ['Jess','Lansberry','Jess Lansberry'],
            ['Bryant','Dodswell','Bryant Dodswell'],
            ['Ola','Opie','Ola Opie'],
            ['Lindi','Jorioz','Lindi Jorioz'],
            ['Laurianne','Doggett','Laurianne Doggett'],
            ['Archibald','Shackleford','Archibald Shackleford'],
            ['Susan','Malan','Susan Malan'],
            ['Jenda','Banaszewski','Jenda Banaszewski'],
            ['Lisle','Parley','Lisle Parley'],
            ['Zane','Hurworth','Zane Hurworth'],
            ['Boy','Darrigoe','Boy Darrigoe'],
            ['Kalie','Trevett','Kalie Trevett'],
            ['Dareen','Creser','Dareen Creser'],
            ['Jilli','Casserley','Jilli Casserley'],
            ['Mohandis','Durno','Mohandis Durno'],
            ['Viki','Tuffin','Viki Tuffin'],
            ['Roze','Revance','Roze Revance'],
            ['Arman','Tolland','Arman Tolland'],
            ['Hyacinthie','Ruecastle','Hyacinthie Ruecastle'],
            ['Cindy','Robins','Cindy Robins'],
            ['Bill','June','Bill June'],
            ['Mycah','Dimic','Mycah Dimic'],
            ['Westleigh','Eburah','Westleigh Eburah'],
            ['Mella','Marre','Mella Marre'],
            ['Mitchell','Sutheran','Mitchell Sutheran'],
            ['Noby','Harlock','Noby Harlock'],
            ['Teddi','Hirtzmann','Teddi Hirtzmann'],
            ['Lynea','Dymocke','Lynea Dymocke'],
            ['Chrystal','Stanluck','Chrystal Stanluck'],
            ['Carling','Wakley','Carling Wakley'],
            ['Travers','Gullivent','Travers Gullivent'],
            ['Cassandra','Gallone','Cassandra Gallone'],
            ['Adeline','Ouslem','Adeline Ouslem'],
            ['Lorenzo','Sheivels','Lorenzo Sheivels'],
            ['Livvie','Spaldin','Livvie Spaldin'],
            ['Gerek','Colliber','Gerek Colliber'],
            ['Titus','Mwandobo','Titus Mwandobo'],
            ['Juma','Shabani','Juma Shabani'],
            ['Amigo','Mwajuma','Amigo Mwajuma'],
            ['Amina','Chifupa','Amina Chifupa'],
            ['Dulla','Makabila','Dulla Makabila'],
            ['Deo','Denis','Deo Denis'],
            ['Djuma','Shabani','Djuma Shabani'],
            ['Kassim','Mganga','Kasim Mganga'],
            ['Diamond','Platnum','Diamond Platinum'],
            ['Wema','Sepetu','Wema Sepetu']
        ];


        $employee= DB::table('employee')->get();



        $index=0;
        foreach ($employee as $emp) {
            DB::table('employee')
            ->where('id',$emp->id)
                ->update([
                'fname' => $employees[$index][0],
                'lname' => $employees[$index][1],
                'full_name' => $employees[$index][2],
            ]);
            $index ++;
            if($index==173){

                $index=0;
            }

    }
    }
}
