<?php

/**
 * Classe mère de tous les modèles
 **/

abstract class Model extends FiltreListe
{
    protected static $dbInstance = null;
    protected $errors = array();
    protected $nombre_ligne;	// pour l'affichage du nombre de lignes des listes (utilisés dans les Xobjets)
    protected $log_id;
    public $requete;

    /* **********
    * Créateur	*
    ********** */
    /**
     * Crée une instance de classe avec les paramètres transmis
     * Typiquement $_REQUEST d'un formulaire
     **/
    public function __construct($params = array())
    {
        $this->initialisationVariablesAvantContructeur();
        foreach (array_keys(get_object_vars($this)) as $attribute) {
            if (isset($params[$attribute])) {
                $this->setAttribute($attribute, $params[$attribute]);
            }
        }
        return $this;
    }

    /*
     * cette fonction est appelée au tout début du constructeur.
     * elle est principalement utilisée pour la gestion des cases à cocher qui doivent être décochée
     * si elles ne sont pas envoyée dans le $_POST du formulaire.
     */
    public function initialisationVariablesAvantContructeur()
    {
        /* fonction à redéfinir dans le modèle au besoin */
    }

    /**
     * Retourne le nom du controller associé à la classe appelante
     */
    public static function getControllerName()
    {
        $classe_appelante = get_called_class();
        if(substr($classe_appelante, 0, 4) == 'Base') $classe_appelante = substr($classe_appelante, 4);
        return String::to_Case($classe_appelante);
    }

    /**
     * transforme un objet en tableau
     **/
    public function objectToTable($objet)
    {
        $tableau = array();
        foreach ($objet as $attribute => $value) {
            $tableau[$attribute] = $value;
        }
        return $tableau;
    }

    /**
     * transforme un objet en tableau sans recupérer l'id
     **/
    public function objectToTableSansId($objet)
    {
        $tableau = array();
        foreach ($objet as $attribute => $value) {
            if ($attribute != "id") {
                $tableau[$attribute] = $value;
            }
        }
        return $tableau;
    }

    /**
     * Crée une instance de la classe NaturePoint avec les paramètres transmis
     * Typiquement le résultat d'une requète
     */
    private static function create($params, $class_name)
    {
        $temp = Config::parametresConnexionDb();
        $class = new $class_name();
        foreach ($params as $attribut => $value) {
            if (substr($attribut, 0, 5) == 'date_' && $temp['driver'] == 'mssql') {
                $class->$attribut = Date::ukToFr(substr($value, 0, 19));
            } else {
                $class->$attribut = $value;
            }
        }
        return $class;
    }

    /* *************************
    * Affichage et convertion *
    ************************* */
    /**
     * Retourne une classe sous forme de chaîne
     **/
    public function __toString()
    {
        return Debug::toString($this);
    }

    /**
     * Convertit une collection en tableau
     * @param {Array} La collection
     * @param {Integer} L'attribut à mettre dans les index du tableau
     * @param {Integer} L'attribut à mettre dans les valeurs du tableau
     **/
    public static function arrayFromCollection($collection, $element_value, $element_text)
    {
        $array = array();
        foreach ($collection as $element) {
            $array[$element->getAttribute($element_value)] = $element->getAttribute($element_text);
        }
        return $array;
    }
    /**
     * Convertit une collection en tableau avec text multiple
     * @param {Array} La collection
     * @param {Integer} L'attribut à mettre dans les index du tableau
     * @param {Integer} Le premier attribut à mettre dans les valeurs du tableau
     * @param {Integer} La suite de l'attribut à mettre dans les valeurs du tableau séparé du premier attribut par ' - '
     **/
    public static function arrayMultipleFromCollection($collection, $element_value, $element_text, $element_text2)
    {
        $array = array();
        foreach ($collection as $element) {
            $array[$element->getAttribute($element_value)] = $element->getAttribute($element_text)." - ".$element->getAttribute($element_text2) ;
        }
        return $array;
    }
    /**
     * Convertit un objet en tableau
     * @param {Array} La collection
     **/
    public function arrayFromObject()
    {
        $array = array();
        foreach (array_keys(get_object_vars($this)) as $attribute) {
            $array[$attribute] = $this->getAttribute($attribute);
        }
        return $array;
    }

    /**
     * Crée des objets à partir d'une matrice (typiquement le résultat d'une requète)
     */
    protected static function objectsFromMatrix($matrix, $class_name)
    {
        $liste = array();
        if (!empty($matrix) && (is_array( $matrix ) || $matrix instanceof Traversable)) {
            foreach ($matrix as $array) {
                array_push($liste, Model::create($array, $class_name));
            }
        }
        return $liste;
    }
    protected static function objectsFromArray($array, $class_name)
    {
        return Model::create($array, $class_name);
    }
    protected static function objectsFromMatrixByAttribute($matrix, $class_name, $attribute = 'id')
    {
        $liste = array();
        if (!empty($matrix) && (is_array( $matrix ) || $matrix instanceof Traversable)) {
            foreach ($matrix as $array) {
                $objet = Model::create($array, $class_name);
                $liste[$objet->getAttribute($attribute)] = $objet;
            }
        }
        return $liste;
    }

    /**
     * Retourne tous les éléments éventuellement filtrés
     * @param {Array} un tableau de tous les filtres éventuels
     * @param {String} le champ sur lequel ordonner
     **/
    public static function findAll($where = array(), $options = array())
    {
        $classe_appelante = get_called_class();
        $params_connexion = Config::parametresConnexionDb();

        //si on appelle depuis un object complexe, on recupere la requete correspondante
        if (method_exists($classe_appelante, 'getQueryString')) {

            // gestion des affichages par défaut, sauf si on appelle un objet bien particulier, via la fonction findone
            if( !isset($options['fonction']) || $options['fonction'] != 'findOne' ){
                if (call_user_func(array($classe_appelante, 'afficherParDefautNonSupprimes'))) {
                    if (!isset ($where['date_suppression']) ) {
                        if ($params_connexion['driver'] == 'mssql') {
                            $where['date_suppression'] = "ISNULL(date_suppression, '') = ''";
                        } else {
                            $where['supprime'] = "supprime = 0";
                        }
                    }elseif( !isset($options['afficher_supprimes']) ){
                        // cette option va permettre de gérer les date de suppression dans les fonction getQuerryString
                        $options['afficher_supprimes'] = true;
                    }
                }
                if (call_user_func(array($classe_appelante, 'afficherParDefautDataVisibles'))) {
                    if (!isset($where['visible']) && !isset($where['identifiant'])) {
                        if ($params_connexion['driver'] == 'mssql') {
                            $where['visible'] = 'ISNULL(visible, 0) = 1';
                        } else {
                            $where['visible'] = 'visible = 1';
                        }
                    }
                }
            }

            $SQL = call_user_func(array($classe_appelante, 'getQueryString'), $options);
            $top = '';
            $orderby = '';
            $limit = '';

            if (isset($options["paging"])) {

                if (isset($options["order"]) && $options["order"] != '') {
                    $orderby = 'ORDER BY '.$options["order"];
                } else {
                    $orderby = 'ORDER BY getdate()';
                }

                switch ($params_connexion['driver']) {
                    case 'mysql':
                        echo "Driver non géné dans le findAll de Model (".$params_connexion['driver'].") JHA GOGO FAIRE LE CODE";
                        $vue = $SQL.Sql::parseWhere($where);

                        $SQL = 'SELECT  (SELECT COUNT(*) FROM '.$vue.' ) AS REQUETE_NOMBRE_LIGNE, *
                                FROM ('.$vue.') v
                                WHERE v.REQUETE_NUMERO_LIGNE BETWEEN ((('.$options["paging"]["numero_page"].' - 1) * '.$options["paging"]["nb_element"].') + 1) AND '.$options["paging"]["numero_page"].' * '.$options["paging"]["nb_element"].'';

                        die;
                        break;
                    case 'mssql':
                        $SQL = 'WITH x AS
                                (
                                    SELECT REQUETE_NUMERO_LIGNE = ROW_NUMBER() OVER ('.$orderby.')
                                            , V.*
                                    FROM
                                    (
                                        '.$SQL.'
                                    ) V
                                    '.Sql::parseWhere($where).'
                                )
                                SELECT  (SELECT COUNT(*) FROM x ) AS REQUETE_NOMBRE_LIGNE, *
                                FROM x
                                WHERE x.REQUETE_NUMERO_LIGNE BETWEEN ((('.$options["paging"]["numero_page"].' - 1) * '.$options["paging"]["nb_element"].') + 1) AND '.$options["paging"]["numero_page"].' * '.$options["paging"]["nb_element"].'';
                        break;
                    default:
                        echo "Driver non géné dans le findAll de Model (".$params_connexion['driver'].")";
                        die;
                }

            } else {
                if ($params_connexion['driver'] == 'mysql') {
                    if (!empty($options["limit"])) $limit = " LIMIT ".$options["limit"];
                } elseif ($params_connexion['driver'] == 'mssql') {
                    if (!empty($options["top"])) $top = " top ".$options["top"];
                }
                if (!empty($options["order"])) $orderby = " ORDER BY ".$options["order"];

                $SQL = 'SELECT '.$top.' * FROM ('.$SQL.') V ';
                $SQL .= Sql::parseWhere($where);
                $SQL .= ' '.$orderby;
                $SQL .= ' '.$limit;
            }
            //if ($classe_appelante == 'CommandeLigne') var_dump($SQL);
            //debug::output($SQL);

            // Exécution de la requète
            $result = Model::getDb()->requete($SQL);
        } else {
            if (call_user_func(array($classe_appelante, 'afficherParDefautNonSupprimes'))) {
                if (!isset ($where['supprime']) && (!isset($options['fonction']) || $options['fonction'] != 'findOne' )) {
                    $where['supprime'] = 'supprime = 0';
                }
            }
            //sinon appelle de l'objet de Base généré par le génératOR
            $result = Model::findAllFromTable(call_user_func(array($classe_appelante, 'getTableName')), $where, $options);
        }

        // Création d'un tableau d'objets
        return Model::objectsFromMatrix($result, $classe_appelante);
    }

	/**
     * Retourne un élément
     * @param {Integer} un identifiant
     */
    static function findOne($id)
    {
        $classe_appelante = get_called_class();

        $return = call_user_func(array($classe_appelante, 'findAll'), array('id = '.Sql::secureId($id)), array('fonction' => 'findOne'));
        if (count($return)>0) {
            return $return[0];
        } else {
            return null;
        }
    }

	/**
     * Retourne le premier élément
     * @param {Array} un tableau de tous les filtres éventuels
     * @param {String} le champ sur lequel ordonner
     */
    static function findFirst($where = array(), $order = '')
    {
        $classe_appelante = get_called_class();

        $return = call_user_func(array($classe_appelante, 'findAll'), $where, array('order' => $order, 'limit' => '0, 1', 'top' => '1'));
        if (count($return)) {
            return $return[0];
        } else {
            return false;
        }
    }

	/**
     * Retourne le nombre d'éléments d'une requète
     * @param {Array} un tableau de condititions
     */
    static function count($where = array())
    {
        $classe_appelante = get_called_class();
        return Model::countFromTable(call_user_func(array($classe_appelante, 'getTableName')), $where);
    }


    /**
     * Supprime l'objet dans la base de données
     */
    function delete()
    {
        $classe_appelante = get_called_class();
        return $this->deleteFromTable(call_user_func(array($classe_appelante, 'getTableName')));
    }

    /*
    * si la table de l'objet contient un champ date_suppression, et qu'il ne faut afficher que les donénes non supprimées par défaut
    * alors réécrire cette fonction dans l'objet avec return true
    */
    public static function afficherParDefautNonSupprimes()
    {
        return false;
    }
    /*
    * si la table de l'objet contient un champ visible, et qu'il ne faut afficher que les donénes visibles par défaut
    * alors réécrire cette fonction dans l'objet avec return true
    */
    public static function afficherParDefautDataVisibles()
    {
        return false;
    }


    /* **************************
    * Requète et SQL générique *
    ************************** */
    /**
     * Trouve tous les enregistrements d'une table donnée
     * @param {String} Le nom de la table
     * @param {Array} Un tableau de conditions
     * @param {Array} L'ordre, le limit, ...
     **/
    protected static function findAllFromTable($table, $where = array(), $options = array())
    {
        $varconnexion = Config::parametresConnexionDb();
        $SQL = "SELECT ";
        if ($varconnexion['driver'] == 'mysql') {
            if (isset($options["SQL_CALC_FOUND_ROWS"]) && $options["SQL_CALC_FOUND_ROWS"]) {
                $SQL .= ' SQL_CALC_FOUND_ROWS ';
            }
        } else {
            if (isset($options["top"]) && $options["top"]) {
                $SQL .= " TOP ".$options["top"];
            }
        }
        $SQL .= " * FROM $table";
        $SQL .= Sql::parseWhere($where);
        if (isset($options["group_by"]) && $options["group_by"]) {
            $SQL .= " group by ".$options["group_by"];
        }
        if (isset($options["order"]) && $options["order"]) {
            $SQL .= " ORDER BY ".$options["order"];
        }
        if ($varconnexion['driver'] == 'mysql') {
            if (isset($options["top"]) && $options["top"]) {
                $SQL .= " LIMIT ".$options["top"];
            } elseif (!empty($options['limit'])) {
                $SQL .= " LIMIT ".$options["limit"];
            }
        }

        // Exécution de la requète
        $result = Model::getDb()->requete($SQL);
        return $result;
    }

    /**
     * Retourne un tableau avec l'ID de la DMD et un attribut
     *      --> utilsié pour alléger les menus déroulant de l'application
     * @param {Array} un tableau de tous les filtres éventuels
     * @param {String} le champ sur lequel ordonner
     **/
    public static function findAllAttributeFromTable($table, $attribute, $where = array(), $options = array())
    {
        $SQL = "SELECT    id\n";
        if ($attribute != 'id') {
            $SQL .= ",".$attribute."\n";
        }
        $SQL .= "FROM $table ";
        $SQL .= Sql::parseWhere($where);

        if (isset($options["order"]) && $options["order"]) {
            $SQL .= " ORDER BY ".$options["order"];
        }
        if (isset($options["limit"]) && $options["limit"]) {
            $SQL .= " LIMIT ".$options["limit"];
        }
        //echo($SQL);
        // Exécution de la requète
        $result = Model::getDb()->requete($SQL);

        return $result;
    }

    public static function findAllAttributeFromLeftJoinTable($table, $left_table, $link_table, $attribute, $where = array(), $options = array())
    {
        $SQL = "SELECT $attribute \n";
        $SQL .= " FROM $table  \n LEFT JOIN $left_table  \n";
        $SQL .= " ON $link_table  \n";
        $SQL .= Sql::parseWhere($where);

        if (isset($options["order"]) && $options["order"]) {
            $SQL .= " ORDER BY ".$options["order"]."  \n";
        }
        if (isset($options["limit"]) && $options["limit"]) {
            $SQL .= " LIMIT ".$options["limit"];
        }
        //debug::output($SQL);
        // Exécution de la requète
        $result = Model::getDb()->requete($SQL);
        return $result;
    }

    /**
     * Retourne le nombre d'éléments d'une requéte pour une table donnée
     * @param {String} Le nom de la table
     * @param {Array} un tableau de condititions
     **/
    protected static function countFromTable($table, $where = array(), $options = array())
    {
        $SQL = "SELECT COUNT(*) AS nb FROM $table";
        $SQL .= sql::ParseWhere($where);
        if (isset($options["group_by"]) && $options["group_by"]) {
            $SQL .= " group by ".$options["group_by"];
        }
        // Exécution de la requète
        $result = Model::getDb()->requete($SQL);
        return $result[0]["nb"];
    }

    /**
     * Retourne la somme des valeurs d'une colonne pour une table et une colonne donnée
     * @param {String} Le nom de la table
     * @param {String} le nom de la colonne à sommer
     * @param {Array} un tableau de condition
     * @param {Array} un tableau d'options
     * @return mixed La somme si pas de group by en option, un tableau de couple somme / valeur de la colonne sinon
     **/
    protected static function sumFromTable($table, $colonne, $where = array(), $options = array())
    {
        $select = "SUM($colonne) as somme";
        $group_by = "";
        if (isset($options["group_by"]) && $options["group_by"]) {
                $select .= ", $table.$colonne";
                $group_by = " GROUP BY ".$options["group_by"];
        }
        $sql = "SELECT $select FROM $table";
        $sql .= sql::ParseWhere($where);
        $sql .= $group_by;
        // Exécution de la requête
        $result = Model::getDb()->requete($sql);
        if ($group_by != "") $retour = $result;
        else $retour = $result[0]["somme"];
        return $retour;
    }

    /**
     * Supprime l'objet dans la base de données
     * @param {String} Le nom de la table
     **/
    protected function deleteFromTable($table)
    {
        if (($this->id > 0) && ($this->canBeDeleted())) {
            // Cas ou le champ de suppression existe
            if (property_exists($this, 'supprime')) {
                $this->supprime = true;
                $infos_suppression = '';
                if (property_exists($this, 'date_suppression')) {
                    $infos_suppression .= ', date_suppression = CURRENT_TIMESTAMP()';
                    $this->date_suppression = Date::today(false, 'US');
                }
                if (property_exists($this, 'id_suppresseur')) {
                    if (isset($_SESSION['id_utilisateur'])) {
                        $id_utilisateur = $_SESSION['id_utilisateur'];
                    }
                    $infos_suppression .= ', id_suppresseur = '.Sql::secureId($id_utilisateur);
                    $this->id_suppresseur = $id_utilisateur;
                }
                $this->logerChangement("delete");
                $SQL = "UPDATE $table
                        SET supprime = 1
                        $infos_suppression
                        WHERE id = ".$this->id;
                if (Model::getDb()->execute($SQL)) {
                    Controller::setFlash(Constantes::getMessageFlashSuppressionOk());
                    return true;
                } else {
                    Controller::setFlash(Constantes::getMessageFlashErreurSuppression(), 1);
                    return false;
                }
            // Cas de la suppression physique
            } else {
                /* Loger le changement */
                $this->logerChangement("delete");
                $SQL = "DELETE FROM $table WHERE id = ".$this->id;
                if (Model::getDb()->execute($SQL)) {
                    $this->id = "";
                    Controller::setFlash(Constantes::getMessageFlashSuppressionOk());
                    return true;
                } else {
                    Controller::setFlash(Constantes::getMessageFlashErreurSuppression(), 1);
                    return false;
                }
            }
        } else {
            Controller::setFlash(Constantes::getMessageFlashBlocageSuppression(), 1);
            return false;
        }
    }

    /**
     * Retourne l'instance de base de données
     */
    public static function getDb()
    {
        if (self::$dbInstance) {
            return self::$dbInstance;
        }
        return null;
    }

    /**
     * Define Db instance
     * @param $dbInstance
     */
    public static function setDb($dbInstance)
    {
        self::$dbInstance = $dbInstance;
    }

    /* ************************
    * Sauvegarde des données *
    ************************ */
    /**
     * Sauvegarde ou met à jour l'objet dans la base de donnée
     * @param $force_enregistrement = si TRUE, alors le système contrepasse le VALIDATE et enregistre quand même l'objet
     * 			(ATTENTION à l'utilisation de ce paramètre)
     **/
    public function save($force_enregistrement = false)
    {
       // debug::output($this, true);
        if ($force_enregistrement || $this->validate(true)) {
            if (Is::id($this->id)) {
                /* Loger le changement */
                $this->logerChangement("update");
                if ($this->update() !== false) {
                   // print_r($this);
                   // die();
//					$this->logerChangement("update");
                    $this->comparerDifferences();
                } else {
                    throw new Error(Constantes::getMessageFlashErreurEnregistrement());
                }
            } else {
                /* Loger le changement */
                $this->id = $this->insert();
                $this->logerChangement("insert");
            }
            //appel de la fonction post SAVE, si l'enregistrement a fonctionné
            if ($this->id) {
                $this->setValeursDefautPostSave();
            }
            return $this->id;
        } else {
            Console::enregistrer($this->getErrors());
            return false;
        }
    }
    /**
     * Insertion
     */
    abstract protected function insert();
    /**
     * Mise à jour
     */
    abstract protected function update();


    /**
     * Le message affiché à la création
     */
    public static function getMessageInsertionOK()
    {
        return Constantes::getMessageFlashInsertionOk();
    }
    /**
     * Le message affiché à l'update
     */
    public static function getMessageUpdateOK()
    {
        return Constantes::getMessageFlashModificationOk();
    }
    /**
     * Le message affiché à la suppression
     */
    public static function getMessageSuppressionOK()
    {
        return Constantes::getMessageFlashSuppressionOk();
    }
    /**
     * Le message affiché à l'upload d'un document
     */
    public static function getMessageInsersionDocumentOK()
    {
        return Constantes::getMessageFlashEnregistrementDocumentOk();
    }


    /* ***************************************
    * gestion des créateur et modificateurs *
    *            d'objet en base            *
    *************************************** */

    /**
     * Retourne le createur de l'objet
     **/
    public function getCreateur ()
    {
        $createur = Utilisateur::findOne($this->id_createur);
        if (!$createur) {
            $createur = new Utilisateur();
        }
        return $createur;
    }

    /**
     * Retourne le dernier modificateur de l'objet
     **/
    public function getModificateur ()
    {
        $modificateur = Utilisateur::findOne($this->id_modificateur);
        if (!$modificateur) {
            $modificateur = new Utilisateur();
        }
        return $modificateur;
    }

    public function getDateCreationComplete()
    {
        return str_replace(' ', ' à ', $this->getDateCreation());
    }
    /*
     * retourne la concaténation de la date et l'heure de dernière modification de l'objet
     */
    public function getDateModificationComplete()
    {
        return str_replace(' ', ' à ', $this->getDateModification());
    }

    /**
     * Retourne le champ date_creation
     **/
    public function getDateCreation()
    {
        return Date::ukToFr($this->date_creation);
    }

    /**
     * Modifie le champ date_creation par la date actuelle
     **/
    public function setDateCreation($value = '')
    {
        if ($value) {
            $this->date_creation = Date::frToSql($value);
        } else {
            $this->date_creation = Date::frToSql(Date::today(true));
        }
        return true;
    }
    /**
     * Modifie le champ createur par la personne connectée
     **/
    public function setIdCreateur($value = 0)
    {
        if ($value) {
            $this->id_createur = $value;
        } elseif (!empty($_SESSION['id_utilisateur'])) {
            $this->id_createur = $_SESSION['id_utilisateur'];
        } else {
            $this->id_createur = Config::idCron();
        }
        return true;
    }

    /**
     * Retourne le champ date_modification
     **/
    public function getDateModification()
    {
        return Date::ukToFr($this->date_modification);
    }

    /**
     * Modifie le champ date de dernière modification par la date actuelle
     **/
    public function setDateModification($value = '')
    {
        if ($value==='null') {
            $this->date_modification = '';
        } elseif ($value) {
            $this->date_modification = Date::frToSql($value);
        } else {
            $this->date_modification = Date::frToSql(Date::today(true));
        }
        return true;
    }

    /**
     * Modifie le champ dernier modificateur par la personne connectée
     **/
    public function setIdModificateur($value = 0)
    {
        if ($value==='null') {
            $this->id_modificateur = '';
        } elseif ($value) {
            $this->id_modificateur = $value;
        } elseif (isset($_SESSION['id_utilisateur'])) {
            $this->id_modificateur = $_SESSION['id_utilisateur'];
        } else {
            // ce cas ne peut arriver que si l'on modifie l'objet dans une page où personne n'est connecté (ex: page de première connexion)
            $this->id_modificateur = Config::idCron();
        }
        return true;
    }

    /* ******************************
    * Affichage d'infos et erreurs *
    ****************************** */

    /**
     * Réinitialise le tableau d'erreurs
     */
    public function initialiseErrors()
    {
        $this->errors = array();
    }

    /**
     * Retourne les erreurs de validation d'un object
     **/
    public function getErrors($attribute = false)
    {
        if ($attribute) {
            $tab_error = $this->errors;
            if (isset($tab_error[$attribute])) {
                return $tab_error[$attribute];
            } else {
                return false;
            }
        } else {
            return $this->errors;
        }
    }

    /*
     * Fonction utilisée par les demandes et commandes afin de trouver les différences
     * par rapport a une version modifiée
     */
    public function compareVersion()
    {
        return array();
    }


    /**
     * Met à jour le tableau des erreurs d'un objet.
     * @param {Array} $errors Le tableau d'erreurs à ajouter.
     * @return true
     */
    public function setErrors($errors)
    {
        $this->errors = array_merge($errors, $this->errors);
        return true;
    }

    /* *********************
    * Accesseurs généraux *
    ********************* */
    /**
     * Retourne la valeur d'un attribut si il existe
     * @param {String} l'attribut auquel accéder
     **/
    public function getAttribute($attribute)
    {
        return call_user_func(array($this, 'get'.String::toCamlCase($attribute)));
    }
    /**
     * Modifie la valeur d'un attribut si il existe
     * @param {String} l'attribut auquel accéder
     * @value {String} la valeur à enregistrer
     **/
    public function setAttribute($attribute, $value)
    {
        call_user_func(array($this, 'set'.String::toCamlCase($attribute)), $value);
        return true;
    }

    /**
     * Met à jour un objet (*sans* l'enregistrer dans la base de données) avec de
     * nouveaux paramètres
     * @param {Array} un tableau de nouvelles valeurs
     **/
    public function modify($params)
    {
        foreach ($params as $attribute => $value) {
            $this->setAttribute($attribute, $value);
        }
    }

    /**
     * Retourne ou modifie la valeur d'un attribut
     * @param {String} l'attribut auquel accéder
     * @value {String} la valeur à enregistrer
     **/
    public function __call($function, $argument = array())
    {
        $ISOtoUTF8 = Config::paramsVariables('ISOtoUTF8');
        $attribut = String::to_Case(substr($function, 3));
        if (property_exists($this, $attribut)) {
            if (preg_match('#^get#i', $function)) {
                if ($ISOtoUTF8 && !String::isUtf8($this->$attribut)) return utf8_encode($this->$attribut);
                return $this->$attribut;
            }

            if (preg_match('#^set#i', $function) && count($argument)) {
                if ($ISOtoUTF8 && String::isUtf8($argument[0])) {
                    $this->$attribut = utf8_decode($argument[0]);
                } else {
                    $this->$attribut = $argument[0];
                }
                return true;
            }
        } else {
            if (preg_match('#^get#i', $function)
              || preg_match('#^set#i', $function)) {
                throw new Error("Attribut inexistant $attribut dans l'objet ".get_called_class());
            } else {
                throw new Error("Fonction inexistante $function dans l'objet ".get_called_class());
            }
        }
        return null;
    }

    /**
    * Retourne l'id de l'objet
    **/
    /*public function getId()
    {
        return $this->id;
    }*/

    /**
    * Retourne le code langue de l'utilisateur
    **/
    public function getCodeLangue()
    {
        return $this->code_langue;
    }

    /* *********************
    *  Sécurisation des   *
    *      éditions       *
    ***********************/

    /**
    * Renvoi le tableau des champs autorisés
    * pour l'utilisateur en cours
    *
    * @return tableau des champs autorisés
    */
    public function listeChampsModifiable()
    {
        return array();
    }

    /**
     * Donne le droit à modifier l'objet mais par une méthode différente (non directe par l'attribut)
     **/
     public function setIdNew($valeur = '')
     {
         $this->id = $valeur;
     }

    /**
     * Renvoi l'autorisation d'un champ pour l'utilisateur en cours
     *
     * @param champ à vérifier
     * @return booléen d'autorisation
     */
    public function isChampModifiable($champ)
    {
        $liste = $this->listeChampsModifiable();
        if (isset($liste[$champ])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param Tableau des valeurs de l'objet typiquement $_POST
     * @return l'objet
     */
    public function setAttributesSecure($attributes)
    {
        //Sécurisation de l'id
        $identifiant = (isset($attributes['id']) && Is::id($attributes['id'])) ? $attributes['id'] : 0;
        //Récupération de l'objet en base (inutile de charger s'il n'y a pas d'ID)
        if ($identifiant) {
            $object = call_user_func(array(get_class($this), 'FindOne'), $identifiant);
        }
        if (!$identifiant || !$object) $object = $this;
        // récuperation des champs modifiable pour l'utilisateur courant
        $editable_fields = $object->listeChampsModifiable();
        //Si on fournit une donnée et si l'on peut la modifier
        // dans le cas de POST, il faut gérer les checkbox non cochées
        $object->initialisationVariablesAvantContructeur();
        foreach ($editable_fields as $field) {
            if (isset($attributes[$field])) {
                $object->setAttribute($field, $attributes[$field]);
            }
        }
        return $object;
    }

    public function setValeursDefautPostSave()
    {
    }

    /* *********************
    *       Logs          *
    ********************* */

    /**
     * fonction utilisée pour récupérer la liste des champs (dans l'ordre) de la table pour les requete de log
     * /!\  la clef primaire ID doit s'appeler 'id_objet_log' !!!
     * @return string
     */
    public static function listeChampsObjet()
    {
        return 'id_objet_log';
    }

     /**
      * Spécifie les champs de la table à comparer
      * Retourne un taleau vide si tous les champs de la table à comparer
      * @return Array $array
      */
     public function fieldsToCompare()
     {
         $array = array();
         return $array;
     }

     /**
      * Spécifie les champs à ne pas prendre en compte pour la comparaison
      * Tableau non vide contenant tout le temps, au moins le champ id
      * @return Array $array
      */
     public function fieldsInException()
     {
         $array = array();
        $array['id'] 					= 'Id';
         return $array;
     }

    /**
     * fonction de log
     * @param $type_action
     */
    public function logerChangement($type_action)
    {
        $varconnexion = Config::parametresConnexionDb();
        if (Config::isLogue() && call_user_func(array(get_class($this), 'tableToLog')) && $this->id) {
            if (!Historisation::getIdHistoCourant()) {
                // si on a pas initialisé cette variable, alors on en crée une par défaut, pour avoir toujours un lien entre les différetns logs
                if (get_class($this) != 'Historisation')
                    Historisation::init('* SYSTEME *');
            }

            $default_id 	= (!empty($varconnexion['defaultid'])) ? $varconnexion['defaultid']."," : "";
            $tab 	= call_user_func(array(get_class($this), 'listeChampsObjet'));
            $tab = explode(', ', $tab);

            if (isset($tab[0]) && (trim($tab[0]) == 'id')) {
                $tab[0] = 'id_objet_log';
            }
            $liste_champ = implode(', ', $tab);

            if (isset($tab[0]) && (trim($tab[0]) == 'id_objet_log')) {
                $tab[0] = 'id';
            }
            $liste_champ_valeur = implode(', ', $tab);

            $id_utilisateur = isset($_SESSION['id_utilisateur'])?$_SESSION['id_utilisateur']:-1; //possible par cron

            $SQL = 'INSERT INTO log__'.$this->getTableName().'
                            ('.$liste_champ.'
                                , id_historisation
                                , libelle_historisation
                                , contenu_log
                                , id_utilisateur_log
                                , date_action_log
                                , action_log
                            )
                        SELECT '.$default_id.'
                                '.$liste_champ_valeur.',
                                '.Sql::secureId(Historisation::getIdHistoCourant()).',
                                \'\',
                                \'\',
                                '.Sql::secureId($id_utilisateur).',
                                '.Sql::secureDate(Date::frToSql(Date::today(true))).',
                                '.Sql::secure($type_action).'
                        FROM '.$this->getTableName().' T
                        WHERE id = '.Sql::secureId($this->id).'
                    ';
            $this->log_id = Model::getDb()->execute($SQL, '', false);
        }
    }

    /**
     * fonction permettant de comparer 2 tableaux de données d'un objet et sa sauvegarde en log
     * et d'enregistrer les modifications effectuées
     */
    public function comparerDifferences()
    {
        $tab_champs_comparaison = $this->fieldsToCompare();
        $tab_champs_exception 	= $this->fieldsInException();
        $tab_champs_base 		= array();
        $tab_champs_log 		= array();
        $tab_contenu			= array();

        $champs_specifiques = false;
        if (!empty($tab_champs_comparaison)) {
            $champs_specifiques = true;
        }

        if (empty($tab_champs_exception)) {
            $tab_champs_exception["#exception#"] = "Exception";
        }


        if (Config::paramsVariables('is_logue') && call_user_func(array(get_class($this), 'tableToLog'))) {
            // données de la table courante
            $sql = $this->getSqlLog();
            $res = Model::getDb()->requeteUneLigne($sql);

            if ($res) {
                foreach ($res as $index => $value) {
                    if ($champs_specifiques) {
                        if (array_key_exists($index, $tab_champs_comparaison)) {
                            $tab_champs_base[$index] = $value;
                        }
                    } else {
                        if (!array_key_exists($index, $tab_champs_exception)) {
                            $tab_champs_base[$index] = $value;
                        }
                    }
                }
            }

            // données de la table de log
            $sql = $this->getSqlLog('log');
            $res = Model::getDb()->requeteUneLigne($sql);

            if ($res) {
                foreach ($res as $index => $value) {
                    if (!array_key_exists($index, $tab_champs_exception)) {
                        if ($index == "id_objet_log") {
                            $index = "id";
                        }

                        if (array_key_exists($index, $tab_champs_base)) {
                            $tab_champs_log[$index] = $value;
                        }
                    }
                }
            }

            $tab_diff = array_diff_assoc($tab_champs_base, $tab_champs_log);

            // insertion de la différence dans la table de log
            if (count($tab_diff) > 0) {
                $libelle = "";

                foreach ($tab_diff as $index => $value) {
                    $field = ($champs_specifiques) ? $tab_champs_comparaison[$index] : $index;
                    $libelle .= "Le champ '".$field."' a été modifié : '".$tab_champs_log[$index]."' a été remplacé par '".$value."'\n";

                    $tab_contenu[$index] = array(
                                                    "old_value"	=> ($tab_champs_log[$index]),
                                                    "new_value"	=> ($value)
                                                );
                }

                $contenu = serialize($tab_contenu);
                //$contenu = json_encode($tab_contenu);

                $sql = "UPDATE log__".$this->getTableName()."
                        SET libelle_historisation = ".Sql::secure(($libelle))."
                        , contenu_log = ".Sql::secure($contenu)."
                        WHERE id = ".Sql::secureId($this->log_id);
                Model::getDb()->execute($sql);
            }
        }
    }

    /**
     * formate les requetes de log
     */
    public function getSqlLog($from = "")
    {
        if ($from == 'log') {
            $table = 'log__'.$this->getTableName();
            $condition = " T.id = ".Sql::secureId($this->log_id);
        } else {
             $table = $this->getTableName();
            $condition = " T.id = ".Sql::secureId($this->id);
        }

        $sql = "SELECT T.*
                FROM ".$table." T
                WHERE ".$condition;
        return $sql;
    }

    /**
     * fonction permettant de récupérer sous forme de tableau les différences
     */
    public static function returnArrayByJson($string = "")
    {
        return json_decode($string, true);
    }

    /**
     * fonction permettant de récupérer les historiques d'un objet
     */
    public function getHistoriqueSurObjet()
    {
        $sql = "SELECT *
                FROM log__".$this->getTableName()."
                WHERE id_objet_log = ".Sql::secureId($this->id)."
                ORDER BY id";
        $res = Model::getDb()->requete($sql);

        return $res;
    }

    /**
     * fonction permettant de récupérer les historiques de libelle d'un objet
     */
    public function getHistoriqueSurObjetDiffLibelle()
    {
        $sql = "SELECT libelle_historisation, id_utilisateur_log, date_action_log, action_log
                FROM log__".$this->getTableName()."
                WHERE id_objet_log = ".Sql::secureId($this->id)."
                ORDER BY id";
        $res = Model::getDb()->requete($sql);

        return $res;
    }

    /**
     * fonction permettant de récupérer les historiques tableau d'un objet
     */
    public function getHistoriqueSurObjetDiffArray()
    {
        $array = array();
        $sql = "SELECT id, contenu_log, id_utilisateur_log, date_action_log, action_log
                FROM log__".$this->getTableName()."
                WHERE id_objet_log = ".Sql::secureId($this->id)."
                ORDER BY id";
        $res = Model::getDb()->requete($sql);

        foreach ($res as $rs) {
            $array[$rs["id"]] = array(
                                    "id_utilisateur_log" => $rs["id_utilisateur_log"]
                                    , "date_action_log" => $rs["date_action_log"]
                                    , "action_log" => $rs["action_log"]
                                    , "contenu_log" => self::returnArrayByJson($rs["contenu_log"])
                                );
        }
        return $array;
    }

    /* ************
    * Validation *
    ************ */
    /**
     * L'objet est-il enregistrable en base de données
     **/
    abstract public function validate();
    /**
     * L'objet est-il effaçable
     */
    abstract public function canBeDeleted();

    public function isUniqueAttribute($attribut, $where = array())
    {
        if (is_array($attribut)) {
            foreach ($attribut as $current_attribut) {
                $where[$current_attribut] = 'IFNULL('.$current_attribut.', 0) = IFNULL('.sql::Secure($this->$current_attribut).', 0)';
            }
        } else {
            $where[$attribut] = 'IFNULL('.$attribut.', 0) = IFNULL('.sql::Secure($this->$attribut).', 0)';
        }
        $where['id'] = "IFNULL(id, 0) <> IFNULL(".sql::secureId($this->id).", 0)";
        $doublon = call_user_func(array(get_class($this), 'FindFirst'), $where);

        if ($doublon) {
            return false;
        } else {
            return true;
        }
    }
}