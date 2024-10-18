<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\EtuRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\EtuType;
use App\Entity\Etu;

class EtuController extends AbstractController
{
    #[Route('/etu', name: 'app_etu')]
    public function index(): Response
    {
        return $this->render('etu/index.html.twig', [
            'controller_name' => 'EtuController',
        ]);
    }

    #[Route('/affiche',name:'app_affiche')]
    public function afficher(EtuRepository $ar):Response
    {
        $list=$ar->findAll();
        return $this->render('etu/afficher.html.twig',['list'=>$list]);
    }


    #[Route('/ajouter',name:'etud_app')]
    public function ajouter(ManagerRegistry $doctrine, Request $request):response
    {
        $etu=new Etu();
        $form = $this->createForm(EtuType::class, $etu);
          $form->handleRequest($request);
          if ($form->isSubmitted() && $form->isValid()) {
        $em=$doctrine->getManager(); 
        $em->persist($etu); 
        $em->flush();
        return $this->redirectToRoute('app_affiche');
        }
             return $this->render('etu/ajouter.html.twig', [
            'form' => $form->createView()
        ]);
    }
     //delete data
     #[route('/delete/{id}',name:'app_delete')]
     public function delete(EtudientRepository $er,int $id,EntityManagerInterface $entityManager):Response{
         $etu=$er->find($id);
         $entityManager->remove($etu);
          $entityManager->flush();
         return $this->redirectToRoute('affiche_app');
     
     }
      #[Route('/Update/{id}',name:'etu_update')]
         public function update(ManagerRegistry $doctrine,Request $request,$id,EtudientRepository $etu):response
         {
             $etud=$etu->find($id);
             $form=$this->createForm(EtuType::class,$etud);
             $form->handleRequest($request);
            if ($form->isSubmitted() )
            {
             $em=$doctrine->getManager(); 
             $em->flush();
             return $this->redirectToRoute('affiche_app');
         }
         return $this->render('etu/update.html.twig',['form'=>$form->createView()]) ;
         
         }
         
     
    
}
