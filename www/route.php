<?php
	header("Content-Type: text/html; charset=utf-8");
	require_once 'key/db_connection.php';
	session_start();
	$result = mysql_query("SET NAMES UTF8");
	if (isset($_SESSION['user_id'])) {
		$nickname = $_SESSION["name"];
		$user_id = $_SESSION['user_id'];
	};

// class Storage {

//     /**
//      * @var array storage of dependency
//      */
//     static private $map;
    
//     static public function get($name)
//     {
//         return self::$map->$name;
//     }

//     static public function set($name, $dependency)
//     {
//         if(self::$map === null) {
//             self::$map = (object) array();
//         }
//         self::$map->$name = $dependency;
//     }
// }

// class Router {

//     /**
//      * @var Request
//      */
//     private $request;

//     public function __construct()
//     {
//         $this->request = Storage::get('Request');
//     }

//     /**
//      * @var array request map
//      */
//     private $map = [];

//     public function get($path, $params)
//     {
//         $this->map['GET'][$path] = $params;
//     }

//     public function post($path, $params)
//     {
//         $this->map['POST'][$path] = $params;
//     }

//     public function getCurrent()
//     {
//         if (empty($this->map[$this->request->request_method])) {
//             throw new \Exception('Not found method');
//         }
//         $current_map = $this->map[$this->request->request_method];

//         if (empty($current_map[$this->request->uri])) {
//             $current_route = $current_map['/404'];
//         } else {
//             $current_route = $current_map[$this->request->uri];
//         }
//         $this->request->setRoute($current_route);
//         return $this->request;
//     }
// }
 
// $fn = ($p = key($_GET)) ? 'content/' . $p . '/index.php' : 'content/home/index.php';
 
// (file_exists($fn)) ? require $fn : require 'content/404.php'; 
 
//$r->addRoute('GET', '/user/{id:[0-9]+}', 'handler1');


?>
<?php
 
/**
 * ДАННЫЕ ДЛЯ ПОДКЛЮЧЕНИЯ К ПЛАТЕЖНОМУ ШЛЮЗУ
 *
 * USERNAME         Логин магазина, полученный при подключении.
 * PASSWORD         Пароль магазина, полученный при подключении.
 * GATEWAY_URL      Адрес платежного шлюза.
 * RETURN_URL       Адрес, на который надо перенаправить пользователя
 *                  в случае успешной оплаты.
 */
 
/**
 * Для отправки POST запросов на платежный шлюз используется
 * стандартная библиотека cURL.
 *
 * ПАРАМЕТРЫ
 *      method      Метод из API.
 *      data        Массив данных.
 *
 * ОТВЕТ
 *      response    Ответ.
 */
function gateway($method, $data) {
    $curl = curl_init(); // Инициализируем запрос
    curl_setopt_array($curl, array(
        CURLOPT_URL => GATEWAY_URL.'/'.$method, // Полный адрес метода
        CURLOPT_RETURNTRANSFER => true, // Выполняемозвращать ответ
        CURLOPT_POST => true, // Метод POST
        CURLOPT_POSTFIELDS => http_build_query($data) // Данные в запросе
    ));
    $response = curl_exec($curl); // Выполняем запрос
     
    $response = json_decode($response, true); // Декодируем из JSON в массив
    curl_close($curl); // Закрываем соединение
    return $response; // Возвращаем ответ
}
 
 $arrayName = array('key' => 8, );
 $result = gateway("order_from_router.php", $arrayName);

header('Content-Type: application/json');
echo $result->content;

  $response = gateway('order_from_router.php', $data);
     
    // Вывод кода ошибки и статус заказа
    echo '
        <b>Error code:</b> ' . $response['ErrorCode'] . '<br />
        <b>Order status:</b> ' . $response['OrderStatus'] . '<br />
    ';
    
    include('key/footer.php');          
?>