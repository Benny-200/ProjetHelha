<?php
    class Db{
    
        /*Varible de connection */
        private static $dbHost = "localhost";
        private static $dbName = "McSoupex_DataBase";
        private static $dbUser = "root";
        private static $dbUserPassword =""; 
        private static $connectToDB = null;

        public static function connect(){
            try{
                /*On va se connecter à la base de donnée*/
                // les :: c'est pour accéder au var static
                //self:: équivaut au this. mais pour les variables statics donc la classe elle même
                self::$connectToDB = new PDO("mysql:host=". self::$dbHost . ";dbname=" . self::$dbName,self::$dbUser,self::$dbUserPassword);
            
            }catch(PDOExeption $e){
                /*Die arrete l'execution du code et getMessage renvoie une erreur*/
                die($e->getmessage());
            }
            /*Retourner la connection */
            return self::$connectToDB;
        }

        public static function disconnect(){
            // déconnecter la base de donnée
            self::$connectToDB = null;
        }

        

    }


?>