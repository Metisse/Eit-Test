<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

use App\Entity\User;
use App\Entity\Service;


class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/contact', name: 'app_user_contact')]
    public function contact(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {   
        // Create form 
        $user   = new User();
        $form   = $this->createForm('App\Form\ContactType', $user);

        // Get all services in db 
        $services = $doctrine->getRepository(Service::class)->findAll();
       
        
        if ($request->isMethod('POST')) {
            // Get data from post
            $form   ->handleRequest($request);
            $data   = $form->getData();
            
            // Save data in db 
            $entityManager     ->persist($user);
            $entityManager     ->flush();

            // Call function for sending mail
            $this->send($data, $request->request->get('services'));

            //return 
            return $this->redirect($this->generateUrl('app_user_contact'));
        }

        return $this->renderForm('user/contact.html.twig', [
            'form' => $form,
            'services' => $services,
        ]);
       
    }

    /**
     * Send Mail
     */
    public function send($data, $services, MailerInterface $mailer):Void
    {
        try {
            $email  = $data->getEmail();
            $email  = (new Email())
            ->from($data->getEmail())
            ->to($services)
            ->subject('Test EIT')
            ->text($data->getMessage());

            $mailer->send($email);

        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
