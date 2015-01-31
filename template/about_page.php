<?php

date_default_timezone_set('UTC');

global $response;
$url =  $response -> getProperty("url");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <?php

        initConfig::getInstance() -> getIncluder() -> includePage("scripts");
        global $response;
        $base_path = $response -> getProperty("base_path");

        ?>
	</head>
	<body>
		<div id="background">
                <?php
                initConfig::getInstance() -> getIncluder() -> includePage("menu");
                ?>

            <div id="content">
                <span id="pics">
                    <img src="<?php echo $url; ?>images/Livello10.png">
                </span>
                <span id="text">
                    <p>
                         GIAG ART -  gianluca è gay quando fa il figo con queste stronzate da geek nerdoso
                        polentoso e artistico, ma credo che alla fine si possa esclamare che sono abbastanza fatto
                        da dargli spago per vedere come il testo verrebbe realmente se stessimo scrivendo del testo
                        realmente senza fare i cretini come delle oce da giardino mozzate e riempite
                        di colla e abbondante cartaigenica senza guardarla negli occhi. Credo in fine che posso
                        affermare di aver battuto il record di scarpe farneticanti della giornata senza seppur interromermi
                        un secondo perche alla fine quello che conta e la varieta mista delle parole senza considerarne
                        il contenuto ortografico o sensatuale.

                        ps questo testo di prova prova che funziona il testo di prova se non dovesse funzionare dovremmo
                        riscrivere il testo da capo senza pero ispirarsi alla mia mano. ( caccolosa tralaltro da segate! )

                        Firmato ENRICO LA TESTA DI CAZZO!

                        Il lorem ipsum è un testo segnaposto utilizzato da grafici, designer, programmatori e
                        tipografi a modo riempitivo per bozzetti e prove grafiche[1].
                        È un testo privo di senso, composto da parole in lingua latina,
                        riprese pseudocasualmente da uno scritto di Cicerone del 45 a.C,
                        a volte alterate con l'inserzione di passaggi ironici.
                        La caratteristica principale è data dal fatto che offre
                        una distribuzione delle lettere uniforme, apparendo come un normale
                        blocco di testo leggibile.

                        FIGO
                    </p>
                </span>
                <div id="curriculum">
                    <div class="buttonDiv">CV</div>
                </div>
            </div>

		</div>
        <?php

        initConfig::getInstance() -> getIncluder() -> includePage("scripts_post");
        ?>
 </body>
 </html>