Postojeci tab 'updateScore' sluzi iskljucivo da se rezultati (win i loss) 
updatuju bez da se ima na uvid kad se koja partija odigrala.


Pravila sa 'insertScore' formu:

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

NEW SHOW-SCORE !

Prikazivati rezultate na dnevnom, nedeljnom ili visenedeljnom nivou. Napraviti input za datum kako bi dobili score za upisan datum. Ukoliko se tog dana nije igralo, korisnika treba obavestiti o tome i/ili eventualno prikazati one datume te nedelje kada se jeste igralo.

Uneti datume "od -> do" i dobiti rezultat za svaki dan posebno.
Uneti datume "od -> do" i dobiti zbir brzijevih i gorancetovih pobeda
Ideja: uz inpute za datume moze stajati i radio input gde bismo izabrali da li hocemo prvu ili drugu varijantu

*BONUS: polje u koje unosimo ID ili ime igraca i dobijamo samo one redove gde je dati igrac imao veci broj pobeda. Dodati jos igraca tako da treba takodje da se oznaci koji par je u pitanju (tipa brzi vs. pera ili brzi vs. gorance), pa potom ime igraca kako bi dobili rezulate za odgovarajuci par. 
BONUS: LIVE STATS: svakim novim reloadom ce se iznova prikazati odnos zbira svih brzijevih i gorancetovih pobeda sa porukom: "BRZI/GORANCE VODI!"
