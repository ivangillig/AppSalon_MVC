<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
        public $email;
        public $nombre;
        public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion() {
        
        
        //Creo el objeto del mail
        $mail = new PHPMailer();
        $mail ->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '708f2339eca3ba';
        $mail->Password = '7509b9558fb5c0';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Confirma tu cuenta';

        //Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';


        $contenido = "<html>";
        $contenido .= "<p>Hola " . $this->nombre . " has creado tu cuenta en AppSalon, solo debes confirmarla presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://localhost/confirmar-cuenta?token=" . $this->token. "'> Confirmar cuenta</a></p>";
        $contenido .= "<p> Si tu no solicitaste esta cuenta puedes ignorar el mensaje </p>";
        $contenido .= "</html>";
        $mail-> Body = $contenido;

        //Enviar Mail
        $mail->send();
    }

    public function enviarInstrucciones(){

        
        //Creo el objeto del mail
        $mail = new PHPMailer();
        $mail ->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '708f2339eca3ba';
        $mail->Password = '7509b9558fb5c0';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Reestablece tu password';

        //Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';


        $contenido = "<html>";
        $contenido .= "<p>Hola " . $this->nombre . ", has solicitado reestablecer tu password, sigue el siguiente enlace para hacerlo.</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://localhost/recuperar?token=" . $this->token. "'> Reestablecer password</a></p>";
        $contenido .= "<p> Si tu no solicitaste el reestablecimiento de contraseña puedes ignorar el mensaje </p>";
        $contenido .= "</html>";
        $mail-> Body = $contenido;

        //Enviar Mail
        $mail->send();
    }
}