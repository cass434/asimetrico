<?php
ini_set('display_errors', 1);

$config = array(
    "config" => "C:/xampp/php/extras/openssl/openssl.cnf",
    "private_key_bits" => 2048,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
);

// Crear la llave public y privada
$res = openssl_pkey_new($config);

if ($res === false) die('Error al generar llaves'."\n"); 

if (!openssl_pkey_export($res, $privKey, "phrase", $config)) die('Error al generar llaves'."\n"); 


$boton1="";
$boton2="";
$boton3="";

if(isset($_POST['boton1']))$boton1=$_POST['boton1'];
if(isset($_POST['boton2']))$boton2=$_POST['boton2'];
if(isset($_POST['boton3']))$boton3=$_POST['boton3'];

if($boton1)
{
// Extraer la llave privada
openssl_pkey_export($res, $privKey, "phrase", $config);

echo "Llave Privada = <br>".$privKey;
echo"<br/>";
echo"<br/>";


// Extraer la llave publica
$pubKey = openssl_pkey_get_details($res);
$pubKey = $pubKey["key"];

echo "Llave publica = <br>".$pubKey;


}
if($boton2)
{
openssl_pkey_export($res, $privKey, "phrase", $config);

$pubKey = openssl_pkey_get_details($res);
$pubKey = $pubKey["key"];


$data = $_POST['nombre'];

 // Encriptar el mensaje con la llave publica
openssl_public_encrypt($data, $encrypted, $pubKey);

echo "Mensaje encriptado = <br>".$encrypted;

}
if($boton3)
{
openssl_pkey_export($res, $privKey, "phrase", $config);

$pubKey = openssl_pkey_get_details($res);
$pubKey = $pubKey["key"];

$data = $_POST['nombre'];

openssl_public_encrypt($data, $encrypted, $pubKey);

// Desencriptar con ayuda de la llave privada
openssl_private_decrypt($encrypted, $decrypted, openssl_pkey_get_private($privKey, "phrase"));

echo "Mensaje = ".$decrypted;

}

?>