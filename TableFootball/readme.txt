*INSERT SCORE
Forma treba da sadrzi dva inputa:
    - ID ili nadimak prvog igraca
    - koliko partija je dobio prvi igrac
    - ID ili nadimak drugog igraca
    - koliko partija je dobio drugi igrac

Tabela treba da sadrzi sledece kolone:
    - datume (kog dana su se odigrale partije)
    - brzi (broj dobijenih partija prvog igraca)
    - gorance (broj dobijenih partija drugog igraca) 
(broj izgubljenih se ne unosi)

Ako danas (recimo 01.06.2022) jos nismo uneli nista, nakon submita ce se kreirati novi row sa danasnjim datumom dok ce svaki sledeci submit tokom dana biti UPDATE postojeceg scora.




*NEW PLAYER
Nakon dodavanja novog igraca, on ce imati svoj ID i Nick. 
BONUS: Pored toga sto korisniku treba da budu prikazani ID i Nick nakon toga sto se prijavi, moze postojati opcija da se automatski Player ID i Nick posalju na mail; ukljucuje dodatan field sa mailom


*INSERT SCORE
Nepotrebno je da se dodaju automatski tabele tj. dueli sa svim postojecim igracima prilikom dodavanja Playera. Tabela se treba kreirati prilikom unosenja scorova i tom prilikom proveriti:

1. Da li dati igraci (cije smo Nickove ili ID-jeve uneli) postoje u tabeli Players.
2. Ukoliko postoje onda program proverava da li tabela tj duel izmedju ta dva igraca postoji, ako ne

- program napravi novu tabelu sa svim neophodnim, unapred podesenim kolonama (uneti nickovi trebaju biti imena kolona) i insertuje score,
ime tabele treba da se sastoji iz Nickova: aleksa97_vs_gorance
iako npr unesemo ID-jeve, tabela treba opet sadrzati Nickove (vazi i za kolone)

- ako tabela postoji, onda se samo updateuje score.



*SHOW-SCORE 
Prikazivati rezultate od xx-xx-xx do xx-xx-xx datuma. Napraviti 2 inputa za datume. Ukoliko se nekog dana nije igralo, prikazati one datume kada se jeste igralo.
BONUS: Ukoliko popunimo samo jedan input, treba se prikazati rezultat samo za taj datum, ili ti da prazan input ima istu vrednost kao taj koji ima.

Uneti datume "od -> do" i dobiti rezultat za svaki dan posebno.
Uneti datume "od -> do" i dobiti zbir brzijevih i gorancetovih pobeda
BONUS: uz inpute za datume moze stajati i radio input gde bismo izabrali da li hocemo prvu ili drugu varijantu

U inpute treba uneti 
-Nick ili 
-PlayerID
Unete podatke treba proveriti da li su validni (da li postoje u Player Tabeli) i :

*Da li postoji tabela/duel izmedju ta dva igraca
Posto je logicno da redosled unetih podataka treba biti nebitan (vec da budu ispravni) treba proveriti da li se inputi podudaraju sa postojecim tabelama:

1. Nacin - Prilikom (automatskog) kreiranja tabele, ona ce u nazivu sadrzati nickove. Izvuci listu/niz/kolonu sa svim postojecim tabelama i uz pomoc str_contains, strpos() ili dr funckija proveriti da li postoji odgovarajuca tabela i prikazati odgovarajuce rezultate. (u ovom slucaju, ako su uneti ID-jevi, treba ih nekako promeniti u Nickove)
2. Nacin - Tabele sadrze kolone cija se imena podudaraju sa Nickovima, dakle uporediti input sa imenima kolona i tako utvrditi da li tabela postoji (takodje, ID promeniti nekako u Nick)


BONUS: LIVE STATS: svakim submitom ce se pored rezultata za unete datume prikazati i ukupan rezultat od prve do poslednje partije




*NOVO 
Insert Score 
Uneti Nick/PlayerID i score i updatovati tabelu game_results. Kada se unesu Nickovi ili PlayerID-evi sa scorom, automatski treba na osnovu njih da se prepozna njihov pair_id i da se insertuje novi row (ili da se updatuje postojeci ako se unosi score po drugi put u danu)
