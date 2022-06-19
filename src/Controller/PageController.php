<?php

namespace App\Controller;

use App\Entity\Employes;
use App\Form\EmployesType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController{

    #[Route("/employes" , name:"page_employes")]
    public function employes(ManagerRegistry $doctrine):Response{
        $employe = $doctrine->getRepository(Employes::class)->findAll();

        return $this->render("Page/Liste_employes.html.twig" , ["employe" => $employe]);
    }

    #[Route("/new_employe" , name:"employe_new")]
    public function new_employe(Request $request , ManagerRegistry $doctrine):Response{

        $employes = new Employes();

        $form = $this->createForm(EmployesType::class, $employes);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($employes);
            $em->flush();
            $this->addFlash("message" , "l'employe a bien été ajouté");
        }

        return $this->render("Page/new_employe.html.twig", ["form" => $form->createView()]);
    }

    #[Route("/employe/suppr/{id}", name:"page_suppr")]
    public function employe_suppr($id, ManagerRegistry $doctrine):Response{

        $employe = $doctrine->getManager()->getRepository(Employes::class)->find($id);

        if($employe === null){
            $this->addFlash("erreur" , "l'employe numéro $id n'existe pas");
            return $this->redirectToRoute("page_employes");
        }

        $this->addFlash("message", "employe numéro " . $employe->getId() . " vient d'être supprimer");
        $em = $doctrine->getManager();
        $em->remove($employe);
        $em->flush();
        return $this->redirectToRoute("page_employes");
    }

    #[Route("/employe/update/{id}", name:"page_update")]
    public function update_employe($id, ManagerRegistry $doctrine, Request $request):Response{

        $employe = $doctrine->getManager()->getRepository(Employes::class)->find($id);

        if($employe === null){
            $this->addFlash("erreur", "employé numéro $id n'existe pas");
            return $this->redirectToRoute("page_employes");
        }

        $form = $this->createForm(EmployesType::class, $employe);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($employe);
            $em->flush();
            return $this->redirectToRoute("page_employes");
        }

        return $this->render("Page/new-form.html.twig", ["form" => $form->createView()]);
    }
}