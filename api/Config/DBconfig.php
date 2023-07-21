<?php


define('HOST', 'localhost');
define('DB', 'eurosonl_elwsc_v2_login');
// define('DB', 'eurosonl_elwscpruebas');
define ('USER','eurosonl_btech');
define('PASSWORD', 'K%M$dqbV5z8q');
define('CHARSET', 'utf8mb4');

define('DBRESP', 'eurosonl_elvdc2021');

date_default_timezone_set('America/Mazatlan');

$tokenEvento="ELWSC2023";

session_start();


setlocale(LC_TIME, "spanish");

class Database{

    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;

    public function __construct(){
        $this->host = constant('HOST');
        $this->db = constant('DB');
        $this->user = constant('USER');
        $this->password = constant('PASSWORD');
        $this->charset = constant('CHARSET');
    }

    public function connect(){
        try{
            $connection= "mysql:host=" .$this->host. ";dbname=" .$this->db. ";charset=" .$this->charset;
            $options=[
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
            ];
            $pdo= new PDO($connection, $this->user, $this->password, $options);
            // echo "Conexión exitosa";
            return $pdo;
        }
        catch(PDOException $e)
        {
            echo "Conexión fallida: " . $e->getMessage();
        }
    }

}

class DatabaseResp{

    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;

    public function __construct(){
        $this->host = constant('HOST');
        $this->db = constant('DBRESP');
        $this->user = constant('USER');
        $this->password = constant('PASSWORD');
        $this->charset = constant('CHARSET');
    }

    public function connect(){
        try{
            $connection= "mysql:host=" .$this->host. ";dbname=" .$this->db. ";charset=" .$this->charset;
            $options=[
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
            ];
            $pdo= new PDO($connection, $this->user, $this->password, $options);
            // echo "Conexión exitosa";
            return $pdo;
        }
        catch(PDOException $e)
        {
            echo "Conexión fallida: " . $e->getMessage();
        }
    }

}

// Validar conexión a base de datos
$basededatos = new Database;

$basededatosresp = new DatabaseResp;


define('emailadmin', 'info@eurosonlatino.com.mx');
define('passwordadmin', 'pyramid2021*');
define('emailsuperadmin', 'bryan.martinez.romero@gmail.com');


define('FOLDER_SOLISTAS', '../comprobantes/solistas/' );
define('FOLDER_PAREJAS', '../comprobantes/parejas/' );
define('FOLDER_GRUPOS', '../comprobantes/grupos/' );
define('YEAR_EVENT', 2023);
define('NAME_EVENT', 'Miclan');
define('EMAIL_EVENT_CONTACTO','info@eurosonlatino.com.mx');
define('TAG_EVENT','#ELWSC2023');
define('OFFLINE_PAGE', 'pages/offlinepage.inc.php');


function statusFormular($form){
    global $basededatos;

    $query="SELECT * FROM tbl_weboptions where idform='$form'";
    $statusForm=$basededatos->connect()->prepare($query);
    $statusForm->execute();
    $getStatus=$statusForm->fetch(PDO::FETCH_ASSOC);

    $statusForm=$statusForm->rowCount()>0 ? $getStatus['status'] : 1;
    
    return $statusForm;
}


function dataPase($form){
    global $basededatos;
    $queryPase="SELECT *, a.statusWeb statusPase, a.id id FROM tbl_pases a
    INNER JOIN tbl_eventos b ON a.evento = b.id 
    where a.codigo_pase='".$form."'";
    $queryPaseExe=$basededatos->connect()->prepare($queryPase);
    $queryPaseExe->execute();
    $dataPase= $queryPaseExe->fetch();

    $respuesta = [
        'num_resultado' => $queryPaseExe->rowCount(),
        'resultados' => $dataPase
    ];
    
    return $respuesta;
}

function generate_string($input, $strength = 16) {
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];  
        $random_string .= $random_character;
    }

    return $random_string;
}

function getTipoCategoria($idCategoria){
    global $basededatos;

    $queryCategoria="SELECT tipo FROM tbl_categorias
    where id='".$idCategoria."'";
    $queryCategoriaExe=$basededatos->connect()->prepare($queryCategoria);
    $queryCategoriaExe->execute();
    $datatipoCategoria= $queryCategoriaExe->fetch(PDO::FETCH_ASSOC);

    
    return $datatipoCategoria;
}

function getPais($idPais){
    global $basededatos;
    $queryPais="SELECT pais FROM tbl_paises where id='".$idPais."'";
    $queryPaisexe=$basededatos->connect()->prepare($queryPais);
    $queryPaisexe->execute();

    $dataPais=$queryPaisexe->fetch(PDO::FETCH_ASSOC);

    return $dataPais;

}

function getCategoria($idCategoria){
    global $basededatos;

    $queryCategoria="SELECT categoria_es, categoria_en FROM tbl_categorias
    where id='".$idCategoria."'";
    $queryCategoriaExe=$basededatos->connect()->prepare($queryCategoria);
    $queryCategoriaExe->execute();
    $datatipoCategoria= $queryCategoriaExe->fetch(PDO::FETCH_ASSOC);

    
    return $datatipoCategoria;
}

function getInfoEvento($tokenEvento){
    global $basededatos;
    $queryEvento="SELECT * FROM tbl_eventos WHERE token='".$tokenEvento."'";
    $queryEventoExe=$basededatos->connect()->prepare($queryEvento);
    $queryEventoExe->execute();
    $dataEvento=$queryEventoExe->fetch();

    return $dataEvento;
}

function infoEvento($idevento){
    global $basededatos;
    $queryInfoEvento="SELECT * FROM tbl_eventos where token='$idevento'";
    $queryGetInfoEvento=$basededatos->connect()->prepare($queryInfoEvento);
    $queryGetInfoEvento->execute();
    
    return $queryGetInfoEvento->fetch(PDO::FETCH_ASSOC);
}


function generateRandomString($length = 10) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getCostosTotales($idform, $status, $cupon, $tipoform, $numIntegrantes){
    global $basededatos;
    global $tipoCambioDollar;    
    global $comisionPaypal;
    $tax=floatval($comisionPaypal['value']);
    $tipoCambio=floatval($tipoCambioDollar['value']);
    $divisaPase='MXN';

    

    $query="SELECT * FROM tbl_pases where id='".$idform."'";
    $queryExe=$basededatos->connect()->prepare($query);
    $queryExe->execute();
    $dataPase=$queryExe->fetch(PDO::FETCH_ASSOC);

    $dataCupon=getDataCupon($cupon, $dataPase['codigo_pase']);
    $descuentoCupon=$dataCupon['respuesta']>0 ? $dataCupon['descuento'] : 0;
    $nombreCupon=$dataCupon['respuesta']>0 ? $dataCupon['cupon'] : '';

    if($queryExe->rowCount()>0){
          switch ($tipoform) {
            case 'liquidar':
                $maxPases=$dataPase['maxPases'];
                $precioPase=$dataPase['precio']*$maxPases-$dataPase['precio_apartado']*$maxPases;
        
                $descuento=$dataCupon['respuesta']>0 ? $precioPase*$dataCupon['descuento'] : 0;
                
                $subtotal=$precioPase-$descuento;
                
                $comisionPase=$subtotal*$tax;
                $precioTotal=$subtotal+$comisionPase;
                $costosTotales=array(
                    'precioPase' => $precioPase,
                    'comisionPase' => $comisionPase,
                    'precioTotal' => $precioTotal,
                    'nombreticket' => $dataPase['descripcion_pase'],
                    'divisaPase' => $dataPase['divisa'],
                    'sku' => $dataPase['codigo_pase'],
                    'resultados' => $queryExe->rowCount(),
                    'maxPases' => $dataPase['maxPases'],
                    'cupon' => $nombreCupon,
                    'descuento' => $descuento,
                    'subtotalOrden' => $subtotal
                );
                break;  
            case 'competition':                
                if($dataPase['codigo_pase']=='ELWSC2023INSCGRU'){
                    
                    $precioPase=$dataPase['precio']*$numIntegrantes;
            
                    $descuento=$dataCupon['respuesta']>0 ? $precioPase*$dataCupon['descuento'] : 0;
                    
                    $subtotal=$precioPase-$descuento;
                    
                    $comisionPase=$subtotal*$tax;
                    $precioTotal=$subtotal+$comisionPase;
                    
                    $costosTotales=array(
                        'precioPase' => $precioPase,
                        'comisionPase' => $comisionPase,
                        'precioTotal' => $precioTotal,
                        'nombreticket' => $dataPase['descripcion_pase'],
                        'divisaPase' => $dataPase['divisa'],
                        'sku' => $dataPase['codigo_pase'],
                        'resultados' => $queryExe->rowCount(),
                        'maxPases' => $dataPase['maxPases'],
                        'cupon' => $nombreCupon,
                        'descuento' => $descuento,
                        'subtotalOrden' => $subtotal
                    );
                    
                }

                if($dataPase['codigo_pase']=='ELWSCINSCSOL'||'ELWSCINSCPAR'){                    
                    $precioPase=$dataPase['precio']*$numIntegrantes;
            
                    $descuento=$dataCupon['respuesta']>0 ? $precioPase*$dataCupon['descuento'] : 0;
                    
                    $subtotal=$precioPase-$descuento;
                    
                    $comisionPase=$subtotal*$tax;
                    $precioTotal=$subtotal+$comisionPase;
                    
                    $costosTotales=array(
                        'precioPase' => $precioPase,
                        'comisionPase' => $comisionPase,
                        'precioTotal' => $precioTotal,
                        'nombreticket' => $dataPase['descripcion_pase'],
                        'divisaPase' => $dataPase['divisa'],
                        'sku' => $dataPase['codigo_pase'],
                        'resultados' => $queryExe->rowCount(),
                        'maxPases' => $dataPase['maxPases'],
                        'cupon' => $nombreCupon,
                        'descuento' => $descuento,
                        'subtotalOrden' => $subtotal
                    );
                }
                
                
                break;
            case 'acceso':               
                $maxPases=$dataPase['maxPases'];
                $precioPase=$status==1 ? $dataPase['precio']*$tipoCambio*$maxPases : $dataPase['precio_apartado']*$tipoCambio*$maxPases;
        
                $descuento=$dataCupon['respuesta']>0 ? $precioPase*$dataCupon['descuento'] : 0;
                
                $subtotal=$precioPase-$descuento;
                
                $comisionPase=$subtotal*$tax;
                $precioTotal=$subtotal+$comisionPase;
                
                $costosTotales=array(
                    'precioPase' => $precioPase,
                    'comisionPase' => $comisionPase,
                    'precioTotal' => $precioTotal,
                    'nombreticket' => $dataPase['descripcion_pase'],
                    'divisaPase' =>  $divisaPase,
                    'sku' => $dataPase['codigo_pase'],
                    'resultados' => $queryExe->rowCount(),
                    'maxPases' => $dataPase['maxPases'],
                    'cupon' => $nombreCupon,
                    'descuento' => $descuento,
                    'subtotalOrden' => $subtotal
                );
                break;
                
        }
       
    }if($queryExe->rowCount()==0){
        $costosTotales=array(
            'resultados' => $queryExe->rowCount(),
        );
    }
    

    // var_dump($costosTotales);
    return $costosTotales;

}

function getCostosPublico($idform, $status, $cupon, $tipoform, $numIntegrantes){
    global $basededatos;
    global $tipoCambioDollar;    
    global $comisionPaypal;
    $tax=floatval($comisionPaypal['value']);

    $query="SELECT * FROM tbl_pases where id='".$idform."'";
    $queryExe=$basededatos->connect()->prepare($query);
    $queryExe->execute();
    $dataPase=$queryExe->fetch(PDO::FETCH_ASSOC);


    $dataCupon=getDataCupon($cupon, $dataPase['codigo_pase']);
    $descuentoCupon=$dataCupon['respuesta']>0 ? $dataCupon['descuento'] : 0;
    $nombreCupon=$dataCupon['respuesta']>0 ? $dataCupon['cupon'] : '';


    if($queryExe->rowCount()>0){

        switch ($tipoform) {
            case 'liquidar':
                $maxPases=$dataPase['maxPases'];
                $precioPase=$dataPase['precio']*$maxPases-$dataPase['precio_apartado']*$maxPases;
        
                $descuento=$dataCupon['respuesta']>0 ? $precioPase*$dataCupon['descuento'] : 0;
                
                $subtotal=$precioPase-$descuento;
                
                $comisionPase=$subtotal*$tax;
                $precioTotal=$subtotal+$comisionPase;
                $costosTotales=array(
                    'precioPase' => $precioPase,
                    'comisionPase' => $comisionPase,
                    'precioTotal' => $precioTotal,
                    'nombreticket' => $dataPase['descripcion_pase'],
                    'divisaPase' => $dataPase['divisa'],
                    'sku' => $dataPase['codigo_pase'],
                    'resultados' => $queryExe->rowCount(),
                    'maxPases' => $dataPase['maxPases'],
                    'cupon' => $nombreCupon,
                    'descuento' => $descuento,
                    'subtotalOrden' => $subtotal
                );
                break;  
            case 'competition':                
                if($dataPase['codigo_pase']=='ELWSC2023INSCGRU'){
                    
                    $precioPase=$dataPase['precio']*$numIntegrantes;
            
                    $descuento=$dataCupon['respuesta']>0 ? $precioPase*$dataCupon['descuento'] : 0;
                    
                    $subtotal=$precioPase-$descuento;
                    
                    $comisionPase=$subtotal*$tax;
                    $precioTotal=$subtotal+$comisionPase;
                    
                    $costosTotales=array(
                        'precioPase' => $precioPase,
                        'comisionPase' => $comisionPase,
                        'precioTotal' => $precioTotal,
                        'nombreticket' => $dataPase['descripcion_pase'],
                        'divisaPase' => $dataPase['divisa'],
                        'sku' => $dataPase['codigo_pase'],
                        'resultados' => $queryExe->rowCount(),
                        'maxPases' => $dataPase['maxPases'],
                        'cupon' => $nombreCupon,
                        'descuento' => $descuento,
                        'subtotalOrden' => $subtotal
                    );
                    
                }

                if($dataPase['codigo_pase']=='ELWSCINSCSOL'||'ELWSCINSCPAR'){                    
                    $precioPase=$dataPase['precio']*$numIntegrantes;
            
                    $descuento=$dataCupon['respuesta']>0 ? $precioPase*$dataCupon['descuento'] : 0;
                    
                    $subtotal=$precioPase-$descuento;
                    
                    $comisionPase=$subtotal*$tax;
                    $precioTotal=$subtotal+$comisionPase;
                    
                    $costosTotales=array(
                        'precioPase' => $precioPase,
                        'comisionPase' => $comisionPase,
                        'precioTotal' => $precioTotal,
                        'nombreticket' => $dataPase['descripcion_pase'],
                        'divisaPase' => $dataPase['divisa'],
                        'sku' => $dataPase['codigo_pase'],
                        'resultados' => $queryExe->rowCount(),
                        'maxPases' => $dataPase['maxPases'],
                        'cupon' => $nombreCupon,
                        'descuento' => $descuento,
                        'subtotalOrden' => $subtotal
                    );
                }
                
                
                break;
            case 'acceso':            
                $maxPases=$dataPase['maxPases'];
                $precioPase=$status==1 ? $dataPase['precio']*$maxPases : $dataPase['precio_apartado']*$maxPases;
        
                $descuento=$dataCupon['respuesta']>0 ? $precioPase*$dataCupon['descuento'] : 0;
                
                $subtotal=$precioPase-$descuento;
                
                $comisionPase=$subtotal*$tax;
                $precioTotal=$subtotal+$comisionPase;
                
                $costosTotales=array(
                    'precioPase' => $precioPase,
                    'comisionPase' => $comisionPase,
                    'precioTotal' => $precioTotal,
                    'nombreticket' => $dataPase['descripcion_pase'],
                    'divisaPase' => $dataPase['divisa'],
                    'sku' => $dataPase['codigo_pase'],
                    'resultados' => $queryExe->rowCount(),
                    'maxPases' => $dataPase['maxPases'],
                    'cupon' => $nombreCupon,
                    'descuento' => $descuento,
                    'subtotalOrden' => $subtotal
                );
                break;
                
        }
        
    }if($queryExe->rowCount()==0){
        $costosTotales=array(
            'resultados' => $queryExe->rowCount(),
        );
    }

    return $costosTotales;
}

function getAllPasesActivos($idevento){
    global $basededatos;
    $queryinfoPase="
    SELECT *, a.id id FROM tbl_pases a
    INNER JOIN tbl_eventos b ON a.evento = b.id
    where b.token = '".$idevento."' AND a.statusWeb=1";
    $infoPase=$basededatos->connect()->prepare($queryinfoPase);
    $infoPase->execute();
    $dataInfoPases=$infoPase->fetchAll(PDO::FETCH_ASSOC);
    return $dataInfoPases;
}

function getCostosInscripcion($idform, $status, $cupon){
    global $basededatos;
    global $tipoCambioDollar;
    global $comisionPaypal;
    $tax=floatval($comisionPaypal['value']);
    $tipoCambio=floatval($tipoCambioDollar['value']);
    $divisaPase='MXN';

    $cupon=strlen($cupon)>0 ? $cupon : 0;

    $data = [
        'cupon' => $cupon,        
    ];

    try{
        $querycupon=$basededatos->connect()->prepare("SELECT * 
        FROM tbl_cupones WHERE cupon=:cupon and status=0");
        $querycupon->execute($data);
        $col=$querycupon->fetch(PDO::FETCH_ASSOC);
        $numfilas=$querycupon->rowCount();

        if($numfilas>0){
            $respuestacupon = array(
                'respuesta' => $numfilas,
                'descuento' => $col['descuento'],
                'cupon' => $cupon
            );
        }else{
            $respuestacupon = array(
                'respuesta' => $numfilas
            );
        }
    }catch(PDOException $e){
        $respuestacupon = array(
            'respuesta' => 'error',
            'mensaje' => $e->getMessage()
        );
    }

    $query="SELECT * FROM tbl_pases where id='".$idform."'";
    $queryExe=$basededatos->connect()->prepare($query);
    $queryExe->execute();
    $dataPase=$queryExe->fetch(PDO::FETCH_ASSOC);

    if($queryExe->rowCount()>0){
        

        $precioPase=$dataPase['precio']*$tipoCambio;
        $descuento=$respuestacupon['respuesta']>0 ? $dataPase['precio']*$respuestacupon['descuento']*$tipoCambio : 0;
        
        $subtotal=$precioPase-$descuento;
        
        $comisionPase=$subtotal*$tax;
        $precioTotal=$subtotal+$comisionPase;
    
        $costosTotales=array(
            'precioPase' => $precioPase,
            'descuento' => $descuento,            
            'subtotal' => $subtotal,
            'comisionPase' => $comisionPase,
            'precioTotal' => $precioTotal,            
            'nombreticket' => $dataPase['descripcion_pase'],
            'divisaPase' => $divisaPase,
            'sku' => $dataPase['codigo_pase'],
            'resultados' => $queryExe->rowCount(),
        );
    }if($queryExe->rowCount()==0){
        $costosTotales=array(
            'resultados' => $queryExe->rowCount(),
        );
    }
    
    return $costosTotales;

}

function calculateOrderAmount(array $items) {
    global $basededatos;

    $tipocambio=20;
    $ivatax=0.16;
    $stripetax=0.038;
    $comisionpesos=3.00;
    $comisionplataforma=3.00;

    $cupon=isset($_SESSION['cupon']) ? $_SESSION['cupon'] : '';
    

    $montosubtotal=[];
    foreach($items as $item){

        $queryinfoPase="SELECT * FROM tbl_pases a
        RIGHT JOIN tbl_eventos b ON a.evento = b.id
        where a.codigo_pase = '".$item['sku']."'";
        $infoPase=$basededatos->connect()->prepare($queryinfoPase);
        $infoPase->execute();
        $dataPase=$infoPase->fetch(PDO::FETCH_ASSOC);

        

        $precio=$dataPase['precio'];
        $cantidad=$item['quantity'];
        $descuento=0;
        
        if(isset($_SESSION['cupon'])){
            if($dataPase['tipo_pase']===$cupon['tipocupon']){
                $descuento=number_format($cupon['descuento'], 2);
            }else if($dataPase['tipo_pase']==='general'){
                $descuento=number_format($cupon['descuento'], 2);
            }
        }

        $montoDescontar=$precio*$descuento;
        $precioPase=$precio-$montoDescontar;
        $subTotalPase=$precioPase*$cantidad;
        
        $montosubtotal[]=$subTotalPase;
        
    }

    $subtotal=array_sum($montosubtotal);
    $subtotalmxn=$subtotal*$tipocambio;

    $comisionplataformausd=$comisionplataforma/$tipocambio;

    $comisionstripe=$stripetax*$subtotalmxn+$comisionpesos;
    $iva=$comisionstripe*$ivatax;
    


    $comision=$comisionstripe+$iva+$comisionplataforma;
    $comisionUSD=$comision/$tipocambio;


    $total_mxn=$subtotalmxn+$comision;
    $total=$subtotal+$comisionUSD;

    $totalCarrito= [
        'total' => $total,
        'subtotal' => $subtotal,
        'tax' => $comisionUSD,
        'subtotalmxn' => $subtotalmxn,
        'tax_mxn' => $comision,
        'totalmxn' => round($total_mxn),
    ];

    return $totalCarrito;
    
}

function calcularPrecio(array $items, $metodoPago) {    
    global $basededatos;

    $tipocambio=20;
    $ivatax=0.16;
    $stripetax=0.038;
    $comisionpesos=3.00;
    $comisionplataforma=3.00;

    $cupon=isset($_SESSION['cupon']) ? $_SESSION['cupon'] : '';
    

    $montosubtotal=[];
    $montotax=[];
    $montoDescuento=[];
    foreach($items as $item){   

        

        $queryinfoPase="SELECT * FROM tbl_pases a
        RIGHT JOIN tbl_eventos b ON a.evento = b.id
        where a.codigo_pase = '".$item['sku']."'";
        $infoPase=$basededatos->connect()->prepare($queryinfoPase);
        $infoPase->execute();
        $dataPase=$infoPase->fetch(PDO::FETCH_ASSOC);

        $precio=$dataPase['precio'];
        $cantidad=$item['quantity'];
        $descuento=0;
        
        if(isset($_SESSION['cupon'])){
            if($dataPase['tipo_pase']===$cupon['tipocupon']){
                $descuento=number_format($cupon['descuento'], 2);
            }else if($dataPase['tipo_pase']==='general'){
                $descuento=number_format($cupon['descuento'], 2);
            }
        }
        
        $montoDescontar=$precio*$descuento;
        $precioPase=$precio-$montoDescontar;
        $subTotalPase=$precioPase*$cantidad;
        
        $montosubtotal[]=$subTotalPase;
        $montoDescuento[]=$montoDescontar;
        
    }

    $subtotal=array_sum($montosubtotal);
    $descuentos=array_sum($montoDescuento);

    $subtotalmxn=$subtotal*$tipocambio;

    $comisionplataformausd=$comisionplataforma/$tipocambio;

    $comisionstripe=$stripetax*$subtotalmxn+$comisionpesos;
    $iva=$comisionstripe*$ivatax;
    


    $comision=$metodoPago=='transfer' ? 0 : $comisionstripe+$iva+$comisionplataforma;
    $comisionUSD=$metodoPago=='transfer' ? 0 :$comision/$tipocambio;


    $total_mxn=$subtotalmxn+$comision;
    $total=$subtotal+$comisionUSD;

    $totalCarrito= [
        'subTotalCarrito' => $subtotal,
        'tax' => $comisionUSD,
        'total_amount' => $total,
        'descuentos' => $descuentos
    ];

    return $totalCarrito;

}

function getPrecioPase($sku){
    global $basededatos;
    $descuento=0;
    $cupon=isset($_SESSION['cupon']) ? $_SESSION['cupon'] : '';
    

    $query="SELECT tbl_pases.tipo_pase, tbl_pases.codigo_pase, tbl_pases.descripcion_pase,
    tbl_pases.divisa, tbl_eventos.nombre nombreEvento, tbl_pases.precio
    FROM tbl_pases 
    INNER JOIN tbl_eventos ON tbl_pases.evento = tbl_eventos.id
    where tbl_pases.codigo_pase='$sku'";
    $queryPase=$basededatos->connect()->prepare($query);
    $queryPase->execute();


    $fetchPase=$queryPase->fetch(PDO::FETCH_ASSOC);

    // var_dump($fetchPase);    
    
    if(isset($_SESSION['cupon'])){
        if($fetchPase['tipo_pase']===$cupon['tipocupon']){
            $descuento=isset($_SESSION['cupon']) ? $cupon['descuento'] : 0;
        }if($fetchPase['tipo_pase']==='general'){
            $descuento=$cupon['descuento'];
        }
    }

    $montoDescontar=$fetchPase['precio']*$descuento;
    $precioPase=$fetchPase['precio']-$montoDescontar;

    $datosPase= [
        'codigo_pase' => $fetchPase['codigo_pase'],
        'precio' => $precioPase,
        'descripcion_pase' => $fetchPase['descripcion_pase'],
        'divisaPase' => $fetchPase['divisa'],
        'nombreEvento' => $fetchPase['nombreEvento']
    ];

    return $datosPase;
}

function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

$ipAddress=getUserIpAddr();
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$ip_address = $_SERVER['REMOTE_ADDR'];

function getBrowser($user_agent){

    if(strpos($user_agent, 'MSIE') !== FALSE)
    return 'Internet explorer';
    elseif(strpos($user_agent, 'Edge') !== FALSE) //Microsoft Edge
    return 'Microsoft Edge';
    elseif(strpos($user_agent, 'Trident') !== FALSE) //IE 11
        return 'Internet explorer';
    elseif(strpos($user_agent, 'Opera Mini') !== FALSE)
    return "Opera Mini";
    elseif(strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR') !== FALSE)
    return "Opera";
    elseif(strpos($user_agent, 'Firefox') !== FALSE)
    return 'Mozilla Firefox';
    elseif(strpos($user_agent, 'Chrome') !== FALSE)
    return 'Google Chrome';
    elseif(strpos($user_agent, 'Safari') !== FALSE)
    return "Safari";
    else
    return 'No hemos podido detectar su navegador';

}

$navegador = getBrowser($user_agent);

$tablet_browser = 0;
$mobile_browser = 0;
$body_class = 'desktop';

if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $tablet_browser++;
    $body_class = "tablet";
}

if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $mobile_browser++;
    $body_class = "mobile";
}

if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
    $mobile_browser++;
    $body_class = "mobile";
}

$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
$mobile_agents = array(
    'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
    'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
    'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
    'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
    'newt','noki','palm','pana','pant','phil','play','port','prox',
    'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
    'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
    'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
    'wapr','webc','winw','winw','xda ','xda-');

if (in_array($mobile_ua,$mobile_agents)) {
    $mobile_browser++;
}

if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
    $mobile_browser++;
    //Check for tablets on opera mini alternative headers
    $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
    if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
    $tablet_browser++;
    }
}
if ($tablet_browser > 0) {
    // Si es tablet has lo que necesites
    $dispositivo='tablet';
}
else if ($mobile_browser > 0) {
    // Si es dispositivo mobil has lo que necesites
    $dispositivo = 'mobile';
}
else {
    // Si es ordenador de escritorio has lo que necesites
    $dispositivo = 'desktop';
}  

function getDataCupon($cupon, $form){
    global $basededatos;
    $data = [
        'cupon' => $cupon,
        'form'  => $form
    ];

    

    try{
        $querycupon=$basededatos->connect()->prepare("SELECT * 
        FROM tbl_cupones WHERE cupon=:cupon and form=:form and status=0");
        $querycupon->execute($data);
        $col=$querycupon->fetch(PDO::FETCH_ASSOC);
        $numfilas=$querycupon->rowCount();

        if($numfilas>0){
            $respuestacupon = array(
                'respuesta' => $numfilas,
                'descuento' => $col['descuento'],
                'cupon' => $cupon
            );
        }else{
            $respuestacupon = array(
                'respuesta' => $numfilas
            );
        }
    }catch(PDOException $e){
        $respuestacupon = array(
            'respuesta' => 'error',
            'mensaje' => $e->getMessage()
        );
    }

    return $respuestacupon;
}


function getActionOption($action, $idEvent){
    global $basededatos;
    
    
    $query="SELECT * FROM tbl_global_options where idEvent='".$idEvent."' and action='$action'";
    $queryExe=$basededatos->connect()->prepare($query);
    $queryExe->execute();
    
    $respuesta=$queryExe->rowCount()>0 ? $dataOptions=$queryExe->fetch() : 0;

    return $respuesta;
}

function getAllCountries(){
    global $basededatos;
    $query='SELECT * FROM tbl_paises';                    
    $queryCountries=$basededatos->connect()->prepare($query);
    $queryCountries->execute();

    $AllCountries=$queryCountries->fetchAll(PDO::FETCH_ASSOC);

    return $AllCountries;

}

function generar_token_seguro($longitud){
    if ($longitud < 4) {
        $longitud = 4;
    }

    return bin2hex(random_bytes(($longitud - ($longitud % 2)) / 2));
}

$dataEvento=getInfoEvento($tokenEvento);

$nombreEvento='Miclan';
$descripcionEvento='Tu punto de entretenimiento';
$tagEvento='MICLANAPP';
$imagenEvento=$dataEvento['imageMail'];
$idEvent=$dataEvento['id'];


// Paypal
$clientidSandboxPaypal=getActionOption('clientid_sandbox_paypal', $idEvent);
$clientidProductionPaypal=getActionOption('clientid_live_paypal', $idEvent);
$secretkeySandboxPaypal=getActionOption('secret_sandbox_paypal', $idEvent);
$secretkeyLivePaypal=getActionOption('secret_live_paypal', $idEvent);

$tipoCambioDollar=getActionOption('tipoCambio', $idEvent);
$comisionPaypal=getActionOption('comisionPaypal', $idEvent);


// Stripe
$comisionPlataforma=getActionOption('comisionPlataforma', $idEvent);
$comisionStripe=getActionOption('comisionStripe', $idEvent);
$ivaTax=getActionOption('ivaTax', $idEvent);


$statusSandbox=getActionOption('status_sandbox_paypal', $idEvent);
$clientidPaypal=$statusSandbox['value']==0 ? $clientidSandboxPaypal : $clientidProductionPaypal;

$apiLivePaypal=getActionOption('url_live_paypal', $idEvent);
$apiSandboxPaypal=getActionOption('url_sandbox_paypal', $idEvent);

$rootUrlPaypal=$statusSandbox['value']==1 ? $apiLivePaypal['value'] : $apiSandboxPaypal['value'];
$secretTokenPaypal=$statusSandbox['value']==1 ? $secretkeyLivePaypal['value'] : $secretkeySandboxPaypal['value'];

$googleAnalytics=getActionOption('google-analytics', $idEvent);
$facebookPixel=getActionOption('facebook-pixel', $idEvent);

// Redes Sociales
$contactoWhatsapp=getActionOption('contacto-whatsapp', $idEvent);
$socialFacebook=getActionOption('social-facebook', $idEvent);
$socialInstagram=getActionOption('social-instagram', $idEvent);
$socialYoutube=getActionOption('social-youtube', $idEvent);

function globalStatusWeb(){
    global $basededatos;
    $query="SELECT * FROM tbl_weboptions where idform='global'";
    $queryExe=$basededatos->connect()->prepare($query);
    $queryExe->execute();

    return $queryExe->fetch()['status'];
}



?>