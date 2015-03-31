<?php
class DisplayHelper
{
    /**
     * Retourne la classe associée à un numéro de ligne donnée
     * @param Integer le numéro de la ligne
     **/
    public static function getClassLigne($numero_ligne, $type = "")
    {
        $classes = array('ligne_paire'.$type, 'ligne_impaire'.$type);
        return $classes[$numero_ligne % 2];
    }

    public static function getExergueLigue ($actif)
    {
        if ($actif) {
            $retour = "exergue";
        } else {
            $retour = "";
        }
        return $retour;
    }

    public static function getTitle ($message, $actif)
    {
        if ($actif) {
            $retour = " title='".$message."' ";
        } else {
            $retour = "";
        }
        return $retour;
    }

    public static function getClassLienMenu($controlleur_courant, $fonction_courante, $lien)
    {
        $controlleur_courant = preg_replace("/^ctrl_/", '', $controlleur_courant);

        $accueil = array();
        $accueil[0] = 'campagne';
        $accueil[1] = 'produit';
        $accueil[2] = 'categorie';
        $accueil[3] = 'sous_categorie';
        $accueil[4] = 'home';

        $mon_compte = array();
        $mon_compte[0] = 'filleul';
        $mon_compte[1] = 'client';
        $mon_compte[2] = 'commande';

        if ($controlleur_courant == 'le_club') {
            if ($lien == 'le club') {
                return '_actif';
            }
        }

        if (($controlleur_courant == 'contact') && ($fonction_courante == 'RemplirFormulaire')) {
            if ($lien == 'contact') {
                return '_actif';
            }
        }
        if (($controlleur_courant == 'filleul') && ($fonction_courante == 'Parrainage')) {
            if ($lien == 'parrainage') {
                return '_actif';
            }
        }

        foreach ($accueil as $i => $controlleur) {
            if ($controlleur_courant == $controlleur) {
                if ($lien == 'accueil') {
                    return '_actif';
                }
            }
        }

        foreach ($mon_compte as $i => $controlleur) {
            if ($controlleur_courant == $controlleur) {
                if (($lien == 'mon compte') && ($fonction_courante != 'Parrainage')) {
                    return '_actif';
                }
            }
        }
        return '';
    }

    public static function getClassDoublon($produit, $liste_doublons, $liste_tous_doublons, $tableau_inconnu)
    {
        if (isset($liste_tous_doublons) && ($liste_tous_doublons)) {
            foreach ($liste_tous_doublons as $doublon) {
                if (($produit -> getId() == $doublon -> getId())) {
                    $class =  'ligne_doublon';
                }
            }
        }
        foreach ($tableau_inconnu as $tableau) {
            if (isset($tableau['libelle'])) {
                if (($produit -> getLibelleTableau() == $tableau['libelle'])) {
                    $class = 'ligne_tableau_inconnu';
                }
            }
        }
        if (isset($liste_doublons) && ($liste_doublons)) {
            foreach ($liste_doublons as $doublon_unique) {
                if (($produit -> getId() == $doublon_unique -> getId())) {
                    $class = 'ligne_paire';
                }
            }
        }
        if (isset ($class)) {
            return $class;
        } else {
            return 'ligne_paire';
        }
    }
    /**
     * Affiche un tableau de toutes les erreurs de validation d'un objet donné
     * @params {Object} L'objet pour lequel afficher les erreurs
     **/
    public static function errorsFor($object)
    {
        if ($object->getErrors()) {
            return DisplayHelper::errors($object->getErrors())."<br/>";
        } else {
            return '';
        }
    }
    /**
     * Affiche des erreurs à partir d'un tableau d'erreurs
     * @params {Array} Le tableau d'erreurs
     **/
    public static function errors($array)
    {
        $retour = "";
        if (count($array)) {
            $retour .= "<div class='erreurs'>";
            $retour .= "	<p class='erreurs_titre'>".UniteHelper::getSingulierPluriel(count($array), "Erreur", "Erreurs", false)."</p>";
            $retour .= "	<ul>";
            foreach ($array as $erreur) {
                $retour .= "	<li>";
                $retour .= "			".$erreur;
                $retour .= "	</li>";
            }
            $retour .= "	</ul>";
            $retour .= "</div>";
        }
        return $retour;
    }

    public static function convertCaracteresSpeciaux($chaine)
    {
        $chaine = str_replace('"', '&#034;', $chaine);
        $chaine = str_replace("'", '&#039;', $chaine);
        $chaine = str_replace('à', '&#224;', $chaine);
        $chaine = str_replace('è', '&#232;', $chaine);
        $chaine = str_replace('ê', '&#234;', $chaine);
        $chaine = str_replace('é', '&#233;', $chaine);
        $chaine = str_replace('ô', '&#244;', $chaine);
        return $chaine;
    }

    public static function caracteresSpeciauxToNormal($chaine)
    {
        $chaine = str_replace('&#034;', '"', $chaine);
        $chaine = str_replace('&#039;', "'", $chaine);
        $chaine = str_replace('&#224;', 'à', $chaine);
        $chaine = str_replace('&agrave;', 'à', $chaine);
        $chaine = str_replace('&#232;', 'è', $chaine);
        $chaine = str_replace('&egrave;', 'è', $chaine);
        $chaine = str_replace('&#234;', 'ê', $chaine);
        $chaine = str_replace('&ecirc;', 'ê', $chaine);
        $chaine = str_replace('&#233;', 'é', $chaine);
        $chaine = str_replace('&eacute;', 'é', $chaine);
        $chaine = str_replace('&#244;', 'ô', $chaine);
        $chaine = str_replace('&ocirc;', 'ô', $chaine);
        $chaine = str_replace('&ouml;', 'ö', $chaine);
        $chaine = str_replace('&icirc;', 'î', $chaine);
        $chaine = str_replace('&euml;', 'ë', $chaine);
        $chaine = str_replace('&auml;', 'ä', $chaine);
        $chaine = str_replace('&atilde;', 'ã', $chaine);
        $chaine = str_replace('&ccidil;', 'ç', $chaine);
        $chaine = str_replace('&euro;', '€', $chaine);
        return $chaine;
    }

    /* ****************************
     * true/false affiche oui/non *
      **************************** */
    public static function getLibelleboolean($value)
    {
        if ($value ==1) {
            return "oui";
        } else {
            return "non";
        }
    }

    /**
     * Convertit un texte en syntaxe Wiki-like
     * en html
     *
     * **gras**
     * //italique//
     * __souligné__
     * %% nouvelle ligne
     *
     * @params {String} $text le texte à convertir
     * @return le html correspondant
     **/
    public function wikiToHtml($text)
    {
        $return = $text;
        // le gras
        $return = preg_replace('/\*\*(.*?)\*\*/ms', '<b>$1</b>', $return);
        // l'italique
        $return = preg_replace('/\/\/(.*?)\/\//ms', '<i>$1</i>', $return);
        // le souligné
        $return = preg_replace('/__(.*?)__/ms', '<u>$1</u>', $return);
        // les retours à la ligne
        $return = preg_replace('/%%/ms', '<br />', $return);
        // les titres
        $return = preg_replace('/!!(.*?)!!/ms', '<h3>$1</h3>', $return);

        return $return;
    }

    /*
     * Nettoie le texte de toute les balises html
     */
    public static function htmlToText($text)
    {
        $pattern = '/<[^<>]*>/';
        return preg_replace($pattern, '', $text);
    }
    /**
     *
     */
    public static function formatterCommentaire($text)
    {
        $order   = array("\r\n", "\n", "\r");
        $replace = '<br />';
        return str_replace($order, $replace, $text);
    }
    /**
     * Retourne les @taille premières lettre du texte donnée en paramètre
     * en ne coupant pas un mot
     **/
    public static function getTexteCoupe($valeur, $taille, $coupe_violement = false, $balise_fermante = "")
    {
        //$phrase_coupee = split('\|', wordwrap($valeur, $taille, '|', $coupe_violement));
        $phrase_coupee = explode('|', wordwrap($valeur, $taille, '|', $coupe_violement));
        $valeur_formate = $phrase_coupee[0];

        //if (strlen($valeur) > $taille + 3) {
        if (strlen($valeur) > $taille) {
            if (!$coupe_violement) $valeur_formate .= ' ';
            $valeur_formate .= '...';
            $valeur_formate .= $balise_fermante;	 // dans le cas d'une coupure de commentaire avec un <p> dedans.
        }
        return $valeur_formate;
    }

    /*
     * si le texte est trop long, alors on ne l'affiche pas
     * @param  TXT texte à tester et afficher au besoi
     * @param  INT taille maximum authorisée
     * @return TXT texte à afficher
     */
    public static function getTexteSiPasTropLong($valeur, $taille)
    {
        if (strlen($valeur) > $taille) {
            return "<i>trop long à afficher</i>...";
        } else {
            return $valeur;
        }
    }

    public static function getClassForFinalise($id_statut)
    {
        $retour = "";
        switch ($id_statut) {
            case Constantes::getIdStatutCommandeRealisee():
                $retour = "a_realiser_";
                break;
            default:
        }
        return $retour;
    }

    public static function getIdForTrimestre($trimestre)
    {
        if (Utilisateur::isEcologic()) {
            return $trimestre->getId();
        } else {
            return $trimestre->getIdTrimestre();
        }
    }

    public static function errorsClass ($tableau_erreurs, $libelle)
    {
        $retour = '';
        if (isset($tableau_erreurs[$libelle])) {
            $retour = 'erreur';
        }
            return $retour;
    }
}