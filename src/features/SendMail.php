<?php

    class SendMailRequest {
        public $Expediteur ;
        public $Message ;
        public function __construct ($Expediteur,$Message) {
            $this->Expediteur = $Expediteur ;
            $this->Message = $Message ;
        }
    }

    class SendMailResult {
        public $success ;
        public function __construct ($success) {
            $this->success = $success ;
        }
    }

    class SendMailHandler {

        //public const DESTINATAIRE = "marion.grange@yahoo.fr" ;
        const DESTINATAIRE = "arthur.brouart@gmail.com" ;
        const OBJET = "Requête client" ;

        public function Handle ($request) {

            $headers  = 'MIME-Version: 1.0' . "\n"; // Version MIME
            $headers .= 'From: "Nom_de_expediteur"<'.$request->Expediteur.'>'."\n"; // Expediteur
            $headers .= 'Delivered-to: '.self::DESTINATAIRE."\n"; // Destinataire
            //$headers .= 'Cc: '.$copie."\n"; // Copie Cc
            //$headers .= 'Bcc: '.$copie_cachee."\n\n"; // Copie cachée Bcc 

            return new SendMailResult ( mail(self::DESTINATAIRE, self::OBJET, $request->Message, $headers) ) ;

        }
    }

?>