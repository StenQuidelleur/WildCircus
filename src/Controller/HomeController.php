<?php


namespace App\Controller;


use App\Repository\BannerRepository;
use App\Repository\CategoryPerfRepository;
use App\Repository\PerformanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/aboutus", name="aboutus")
     * @return Response
     */
    public function aboutUs(): Response
    {
        return $this->render('home/aboutus.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     * @return Response
     */
    public function contact(): Response
    {
        return $this->render('home/contact.html.twig');
    }
}