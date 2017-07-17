> **Sintassi &ensp;:**  Numerici&emsp;|&emsp;Temporali&emsp;|&emsp;Posizionamento ==&gt; {} [] ()<br>
> **Esempio :** eta{&gt;30}\[25-6-2017=10.53.40:1-7-2017=23.59.59]\(0:49)
<br>

Numerici {}
---

- 27&emsp; &emsp;|&emsp;solo il valore 27
- &gt;27&emsp;&ensp;|&emsp;uguale e maggiore di 27&emsp;|&emsp;ordinati da 27 in su
- &lt;27&emsp;&ensp;|&emsp;uguale e minore di 27&emsp;&emsp;|&emsp;ordinati da 27 in giù
- 27:47&emsp;|&emsp;compreso fra 27 e 47&emsp; &emsp;|&emsp;ordinati da 27 a 47 compresi
- 47:27&emsp;|&emsp;compreso fra 47 e 27&emsp; &emsp;|&emsp;ordinati da 47 a 27 compresi
<br>
<br>

Temporali []
---
- 30                                        |  ultimi 30 secondi
- 30                                        |  ultimi 5 minuti e 30 secondi
- 0.0                                        |  ultime 24 ore
- 15-7-2015                                |  15 luglio 2015 dalle 00.00.00 al 15 luglio 2015 alle 23.59.59
- 2015-7-15                                |  15 luglio 2015 dalle 00.00.00 al 15 luglio 2015 alle 23.59.59
- 1-1-2015=10                                |  1 gennaio 2015 dalle 10.00.00 alle 10.59.59
- 1-1-2015=10.30                        |  1 gennaio 2015 dalle 10.30.00 alle 10.59.59
- 1-1-2015=10.30.45                        |  1 gennaio 2015 dalle 10.30.45 alle 10.59.59
- 1-1-2015:3-1-2015                        |  1 gennaio 2015 dalle 00.00.00 al 3 gennaio 2015 alle 23.59.59
- 1-1-2015=5:3-1-2015=10.30                |  1 gennaio 2015 dalle 05.00.00 al 3 gennaio 2015 alle 10.30.00
- 1-1-2015=6.30.15:3-1-2015=12.00.45        |  1 gennaio 2015 dalle 06.30.15 al 3 gennaio 2015 alle 12.00.45
<br>
<br>

Posizionamento ()
---
- Niente        |  default min ( 10 risultati ) dal più recente al più vecchio
- 0        |  default MAX ( 100 risultati ) dal più recente al più vecchio
- (25)        |  i primi 25 risultati dal più recente al più vecchio
- (30:60) |  dalle posizioni 30 alla posizione 60 dal più recente al più vecchio
- (60:30) |  dalle posizioni 60 alla posizione 30 dal più vecchio al più recente
- (-)        |  default min ( 10 risultati ) dal più vecchio al più recente
- (-0)        |  default MAX ( 100 risultati ) dal più vecchio al più recente
- (-1:-9)        |  dalle posizioni 1 alla posizione 9 dal più vecchio al più recente
- (-9:-1)        |  dalle posizioni 9 alla posizione 1 dal più recente al più vecchio
<br>
<br>

Ordinamento !+-!
---
- \+        |  dal più piccolo al più grante ( 0-9 &amp; a-Z ) es. eta+
- \-        |  dal più grante al più piccolo ( 9-0 &amp; Z-a ) es. eta-
- !        |  per quantità                        es. !citta
- !+!        |  per quantità crescente        es. !citta+!
- !-!        |  per quantità decrescente        es. !citta-!
