<?php
// src/Controller/MailDebugController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailDebugController extends AbstractController
{
    #[Route('/test-mail', name: 'app_test_mail')]
    public function sendTestMail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('test@example.com')
            ->to('test@local.dev')
            ->subject('Test Mailpit')
            ->text('Ceci est un test d’envoi de mail vers Mailpit.');

        $mailer->send($email);

        return new Response('Mail envoyé (regarde dans Mailpit) !');
    }
}
