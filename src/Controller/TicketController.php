<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Ticket;
use App\Form\TicketType;
use App\Repository\PerformanceDateRepository;
use App\Repository\TicketRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ticket")
 */
class TicketController extends AbstractController
{
    /**
     * @Route("/order", name="ticket_order", methods={"GET","POST"})
     * @param Request $request
     * @param TicketRepository $ticket
     * @param PerformanceDateRepository $perfDate
     * @return Response
     */
    public function new(Request $request, TicketRepository $ticket, PerformanceDateRepository $perfDate): Response
    {
        $tickets = null;
        if (!empty($ticket)) {
            $tickets = $ticket->findAll();
        }

        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $ticket->setUser($this->getUser());
                $ticket->setDate($_POST['perfDate']);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($ticket);
                $entityManager->flush();

                return $this->redirectToRoute('ticket_order');
            }
        }
        $perfDates = $perfDate->findAll();
        return $this->render('booking/booking.html.twig', [
            'ticket' => $ticket,
            'tickets' => $tickets,
            'form' => $form->createView(),
            'perfDates' => $perfDates
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ticket_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Ticket $ticket
     * @return Response
     */
    public function edit(Request $request, Ticket $ticket): Response
    {
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $ticket->setUser($this->getUser());
            $ticket->setDate($_POST['perfDate']);

            return $this->redirectToRoute('ticket_order');
        }

        return $this->render('ticket/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ticket_delete", methods={"DELETE"})
     * @param Request $request
     * @param Ticket $ticket
     * @return Response
     */
    public function delete(Request $request, Ticket $ticket): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ticket->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ticket);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ticket_order');
    }

    /**
     * @Route("/order-payment", name="order_payment")
     * @return Response
     */
    public function orderPayment(): Response
    {
        return $this->render('booking/orderPayment.html.twig');
    }

    /**
     * @Route("/order-validation", name="order_validation")
     * @return Response
     */
    public function orderValidation(): Response
    {
        return $this->render('booking/orderValidation.html.twig');
    }

    /**
     * @Route("/ajax-generate-pdfOrder", name="ajax-generate-pdfOrder",  methods={"GET", "POST"}))
     * @param PerformanceDateRepository $perfDate
     * @return JsonResponse
     */
    public function generatePdfOrder(PerformanceDateRepository $perfDate)
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);
        $tickets = $this->getUser()->getTickets();
        $perfDates = $perfDate->findAll();
        $html = $this->renderView('pdf/order.html.twig', [
            'tickets' => $tickets,
            'perfDates' => $perfDates
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $output = $dompdf->output();
        $pdfFilepath = 'assets/orders/order'.$this->getUser()->getEmail().$this->getUser()->getId().'.pdf';
        file_put_contents($pdfFilepath, $output);

        return $this->json(['message' => 'Le pdf a bien été générée'], 200);
    }

    /**
     * @Route("/ajax-send-mail", name="ajax-send-mail",  methods={"GET", "POST"}))
     * @param MailerInterface $mailer
     * @return JsonResponse
     * @throws TransportExceptionInterface
     */
    public function sendMailToUser(MailerInterface $mailer)
    {
        $filesystem = new Filesystem();
        $email = (new TemplatedEmail())
            ->from('sten.test4php@gmail.com')
            ->to('sten.test4php@gmail.com')
            ->subject('Your Order of WildCircus')
            ->htmlTemplate('Home/email/order.html.twig')
            ->context(['user' => $this->getUser()])
            ->attachFromPath('assets/orders/order'.$this->getUser()->getEmail().$this->getUser()->getId().'.pdf');
        $mailer->send($email);

        $filesystem->remove(['assets/orders/order'.$this->getUser()->getEmail().$this->getUser()->getId().'.pdf']);

        $em = $this->getDoctrine()->getManager();
        $tickets = $this->getUser()->getTickets();
        foreach($tickets as $ticket) {
            $em->remove($ticket);
        }
        $em->flush();

        return $this->json(['message' => 'Le mail a bien été envoyée'], 200);
    }
}

