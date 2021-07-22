<?php

namespace App\Controller;


use App\Repository\SizeRepository;
use App\Entity\Size;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SizeController extends AbstractController
{
    /**
     * @Route("/size", name="size")
     */
    public function index(SizeRepository $sizeRepository): Response
    {
        return $this->render('size/index.html.twig', [
            'sizes' => $sizeRepository->findAll(),
        ]);
    }


    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Size $size): Response
    {

        return $this->render('size/show.html.twig', [
            'size' => $size,
        ]);
    }
}
