<?php


// Clase DataBase: Clase para manejar la conexión a la base de datos
class DataBase {

    //Atributos
    private static $instance;
    private $connection;
    private $config = [];

    //Constructor
    private function __construct() {
        $this->loadConfig();

        $this->connection = new PDO(
            'mysql:host=' . $this->config['host'] . ';dbname=' . $this->config['db_name'] . ';charset=utf8',
            $this->config['user'],
            $this->config['password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
    }

    //Metodo para cargar la configuración desde el archivo JSON db-config.json
    private function loadConfig() {
        $json_file = __DIR__ . '/../config/db-config.json';

        if (!file_exists($json_file)) {
            throw new Exception("ERROR: No se encontró el archivo de configuración en $json_file.");
        }

        $json_data = file_get_contents($json_file);
        $this->config = json_decode($json_data, true);

        if ($this->config === null) {
            throw new Exception("ERROR: El archivo de configuración tiene un JSON inválido.");
        }
    }

    //Metodo para obtener la instancia de la clase
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    //Metodo para obtener la conexión
    public function getConnection(): PDO {
        return $this->connection;
    }
}
