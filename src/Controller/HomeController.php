<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Repository\ProductRepository;


class HomeController extends AbstractController
{
    private const MAX_PRODUCTS = 6;
    /**
     * @Route("/", name="index")
     */
    public function index(ProductRepository $products): Response
    {
        return $this->render('home/index.html.twig', [
            'products' => $products->findBy([], ['createdAt' => 'DESC'], self::MAX_PRODUCTS)
        ]);
    }
}