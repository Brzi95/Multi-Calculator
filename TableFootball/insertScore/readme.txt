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

Druga opcija je uneti datume "od -> do" i dobiti rezultat iz svakog dana posebno.
BONUS: uneti datume "od -> do" i dobiti zbir brzijevih i gorancetovih pobeda
Ideja: uz inpute za datume moze stajati i radio input gde bismo izabrali da li hocemo 
prvu varijantu (rezultat iz svakog dana posebno) ili
drugu varijantu (zbir svih brzijevih i gorancetovih pobeda)

BONUS: polje u koje unosimo ID ili ime igraca i dobijamo samo one redove gde je dati igrac imao veci broj pobeda
BONUS: LIVE STATS: svakim novim reloadom ce se iznova prikazati odnos zbira svih brzijevih i gorancetovih pobeda sa porukom: "BRZI/GORANCE VODI!"




