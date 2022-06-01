Postojeci tab 'updateScore' sluzi iskljucivo da se rezultati (win i loss) 
updatuju bez da se ima na uvid kad se koja partija odigrala.


Pravila sa 'insertScore' formu:

Forma treba da sadrzi dva inputa:
    - koliko partija je dobio prvi igrac
    - koliko partija je dobio drugi igrac

Tabela treba da sadrzi sledece kolone:
    - datume (kog dana su se odigrale partije)
    - broj dobijenih partija prvog igraca
    - broj dobijenih partija drugog igraca 
(broj izgubljenih se ne unosi)


Uzecemo za primer Brzi/Gorance par. Prvi input je Brzi, drugi Gorance.
Ideja je da prva kolumna bude datum, druga Brzi, treca Gorance.

TASK 1: NEW DAY - NEW ROW!

Ako danas (recimo 01.06.2022) jos nismo uneli nista, prilikom submita ce se kreirati novi row sa danasnjim datumom dok ce svaki sledeci submit tokom dana biti UPDATE postojeceg scora.


TASK 2: NEW WEEK - NEW TABLE!

Tabela treba sadrzati rezultate na nedeljnom nivou, od ponedeljka do nedelje. Ako smo poslednji score submitovali u petak i novi submitujemo u utorak, automatski treba da se kreira nova tabela za celu narednu nedelju. Podrazumeva se da u svakoj novoj tabeli treba da vaze pravila i TASK 1


TASK 3: NEW SHOW-SCORE !

Prikazivati rezultate na dnevnom, nedeljnom ili visenedeljnom nivou. Napraviti input za datum kako bi dobili odnos pobeda unetog dana. Ukoliko se tog dana nije igralo, korisnika treba obavestiti o tome i eventualno prikazati one datume te nedelje kada se jeste igralo. Druga opcija je uneti datume "od -> do" i dobiti listu rezultata iz svakog dana posebno.


BONUS: uneti datume "od -> do" i dobiti zbir brzijevih i gorancetovih pobeda
BONUS: polje u koje unosimo ID ili ime igraca i dobijamo samo one redove gde je dati igrac imao veci broj pobeda
BONUS: LIVE STATS: svakim novim reloadom ce se iznova prikazati ukupan zbih brzijevih i gorancetovih pobeda sa porukom: "BRZI/GORANCE VODI!"




