<?php


namespace App\Controller;


use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\AgeRangeRepository;
use App\Repository\ArtistRepository;
use App\Repository\BannerRepository;
use App\Repository\CategoryPerfRepository;
use App\Repository\PerformanceRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_index")
     * @param BannerRepository $banner
     * @param CategoryPerfRepository $category
     * @return Response
     */
    public function index(BannerRepository $banner,CategoryPerfRepository $category): Response
    {
        $banner = $banner->findAll();
        $categories = $category->findAll();
        return $this->render('home/index.html.twig', [
            'banner' => $banner[0],
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/performances", name="performances")
     * @param PerformanceRepository $performance
     * @return Response
     */
    public function performances(PerformanceRepository $performance): Response
    {
        $performances = $performance->findAll();
        return $this->render('home/performances.html.twig', [
            'performances' => $performances
        ]);
    }

    /**
     * @Route("/prices", name="prices")
     * @param PerformanceRepository $performance
     * @param AgeRangeRepository $range
     * @return Response
     */
    public function price(PerformanceRepository $performance, AgeRangeRepository $range): Response
    {
        $performances = $performance->findAll();
        $ranges = $range->findAll();
        return $this->render('home/prices.html.twig', [
            'performances' => $performances,
            'ranges' => $ranges
        ]);
    }

    /**
     * @Route("/artist", name="artist")
     * @param ArtistRepository $artist
     * @return Response
     */
    public function artist(ArtistRepository $artist): Response
    {
        $artists = $artist->findAll();
        return $this->render('home/artist.html.twig', [
            'artists' => $artists
        ]);
    }

    /**
     * @Route("/aboutus", name="aboutus")
     * @return Response
     */
    public function aboutUs(): Response
    {
        return $this->render('home/aboutus.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     * @param Request $request
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new TemplatedEmail())
                ->from('sten.test4php@gmail.com')
                ->to('sten.test4php@gmail.com')
                ->subject($contact->getObject())
                ->htmlTemplate('Home/email/notification.html.twig')
                ->context(['contact' => $contact]);
            $mailer->send($email);
            $this->addFlash('success', 'Your email has been sent !');

            return $this->redirectToRoute('home_index');
        }

        return $this->render('home/contact.html.twig',[
            'form' => $form->createView()
        ]);
    }
}