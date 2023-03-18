<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use App\Entidades\Sistema\Usuario;
use Session;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ControladorWebContacto extends Controller
{
    public function index()
    {
            return view("web.contacto");
    }

    public function recuperar(Request $request){

        $nombre = $request->input('txtNombre');
        $telefono = $request->input('txtTelefono');
        $correo = $request->input('txtCorreo');
        $comentario = $request->input('txtComentario');

        $cliente = new Cliente();
        $cliente->obtenerPorCorreo($correo);

        if($cliente->correo !=""){
            $data ="Instrucciones";

            $mail = new PHPMailer(true);
            try{
                $mail->SMTPDebug = 0;
                $mail->isSMTP();
                $mail->Host = env('MAIL_HOST');
                $mail->SMTPAuth = true;
                $mail->Username = env('MAIL_USERNAME');
                $mail->Password = env('MAIL_PASSWORD');
                $mail->SMTPSecure = env('MAIL_ENCRYPTION');
                $mail->Port = env('MAIL_PORT');

                $mail->setFrom(env('MAIL_FORM_ADRRESS'), env('MAIL_FROM_NAME'));
                $mail->addAddress($correo);
                $mail->addReplyTo('no-reply@fmed.uba.ar');

                $mail->isHTML(true);
                $mail->Subject = 'Gracias por contactarte';
                $mail->Body = 'Los datos del formulario son: 
                    Nombre: $nombre<br>
                    Telefono: $telefono<br>
                    Correo: $correo<br>
                    Comentario: $comentario<br>

                ';

                //$mail->send();


                return view('web.contacto-gracias');

            }catch(Exception $e){
                $mensaje = "Hubo un error al enviar el correo.";
                return view('web.contacto', compact('mensaje'));
            }
        }else{
            $mensaje="Complete los datos.";
            return view('web.contacto', compact('mensaje'));

        }
    }
}