<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Entidades\Sucursal;
use App\Entidades\Cliente;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class ControladorWebRecuperarClave extends Controller{

      public function index(Request $request){

            $sucursal = new Sucursal;
            $aSucursales = $sucursal->obtenerTodos();

            return view('web.recuperarclave', compact('aSucursales'));
      }

      public function recuperar(Request $request){
            $titulo='Recupero de clave';
            $email= $request->input('txtMail');
    
            $cliente = new Cliente();
            if($cliente->verificarExistenciaMail($email)){
                //Envia  mail con las instrucciones
    
                $data = "Instrucciones";
    
                $mail = new PHPMailer(true);                            
                try {
                    //Server settings
                    $mail->SMTPDebug = 0;                               
                    $mail->isSMTP();
                    $mail->Host = env('MAIL_HOST');
                    $mail->SMTPAuth = true;
                    $mail->Username = env('MAIL_USERNAME');
                    $mail->Password = env('MAIL_PASSWORD');
                    $mail->SMTPSecure = env('MAIL_ENCRYPTION');
                    $mail->Port = env('MAIL_PORT');
    
                    //Recipients
                    $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    $mail->addAddress($email);
                    $mail->addReplyTo('no-reply@fmed.uba.ar');
    
                    //Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Recupero de clave';
                    $mail->Body    = "Haz clic en el siguiente enlace para cambiar la clave: 
    
                    ". env("APP_URL") ."/cambio-clave/$email/" . csrf_token();
    
                    $mail->send();
    
                    $mensaje = "Te hemos enviado las instrucciones al correo.";
                    return view('web.recuperarclave', compact('titulo', 'mensaje'));
    
                } catch (Exception $e) {
                    $mensaje = "Hubo un error al enviar el correo.";
                    return view('web.recuperarclave', compact('titulo', 'mensaje'));
                }  
            } else {
                return view('web.recuperarclave', compact('titulo', 'mensaje'));
            }
        }

}






?>