<?php

namespace App\Controller;

use App\Entity\OrderContact;
use App\Form\OrderContactType;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;

/**
     * @Route("/cart", name="cart_")
     */
class CartController extends AbstractController
{
    public const MAILER_TO = "wildagenceimmogroupe4@gmail.com";
    public const MAILER_SUBJECT = "Nouveau commande";
    /**
     * @Route("/", name="index")
     */
    public function index(SessionInterface $session, ProductRepository $productRepo, Request $request, MailerInterface $mailer): Response
    {
       
        $panier = $session->get("panier",[]);
        $dataPanier = [];
       
        foreach($panier as $id => $quantity) {
            $dataPanier[] = [
                'product' => $productRepo->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0;
         
        foreach($dataPanier as $item) {
            $totalItem = $item['product']->getPrix() * $item['quantity'];
            $total += $totalItem;
        }

        $contact = new OrderContact();
        $contactForm = $this->createForm(OrderContactType::class, $contact);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $contactForm = $contactForm->getData();
            $email = (new Email())
            ->from(new Address($contactForm->getEmail()))
            ->to(self::MAILER_TO)
            ->subject(self::MAILER_SUBJECT)
            ->html($this->renderView('contact/newOrder.html.twig', ['contact' => $contact]));
            $mailer->send($email);
            $this->addFlash('message', 'Votre commande a été bien validé,
                nous vous contacterons ultérieurement !');
            return $this->redirectToRoute('index');     
        }
        
        return $this->render('cart/index.html.twig', [
            'items' =>  $dataPanier,
            'total' => $total,
            'contact' => $contactForm->createView()
        ]);
    }

    /**
     * @Route("/add/{id}", name="add")
     */
    public function add($id, SessionInterface $session): Response
    {
        // Get the actual panier
       
        $panier = $session->get('panier', []);

        if(!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }
        $session->set('panier', $panier);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/remove/{id}", name="remove")
     */
    public function remove(Product $product, SessionInterface $session): Response
    {
        // Get the actual panier
        $panier = $session->get('panier', []);
        $id = $product->getId();

        if(!empty($panier[$id])) {
            if ($panier[$id] > 1) {
                $panier[$id]--;
            } else {
                unset($panier[$id]);
            }
        }

        $session->set("panier", $panier);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Product $product, SessionInterface $session): Response
    {
        // Get the actual panier
        $panier = $session->get('panier', []);
        $id = $product->getId();

        if(!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $session->set("panier", $panier);

        return $this->redirectToRoute("cart_index");
    }


}

