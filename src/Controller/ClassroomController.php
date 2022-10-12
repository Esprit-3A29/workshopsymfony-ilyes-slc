<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use App\Repository\ClassroomRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }

    #[Route('/list', name: 'app_classroom')]
    public function list(ClassroomRepository $repository): Response
    {
        $list = $repository->findAll();
        return $this->render('classroom/list.html.twig', [
            'list' => $list,
        ]);
    }


    #[Route('/add', name: 'add_classroom')]
    public function add(ClassroomRepository $repository,ManagerRegistry $doctrine ,Request $request): Response
    {
        $classroom = new Classroom();
        $form = $this->createForm(ClassroomType::class,$classroom);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $em = $doctrine->getManager();
            $em->persist($classroom);
            $em->flush();
            return $this->redirectToRoute('app_classroom');
        }
        return $this->renderForm('classroom/add.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit_classroom')]
    public function edit(ClassroomRepository $repository,ManagerRegistry $doctrine,$id,Request $request): Response
    {
        $classroom = $repository->find($id);
        $form = $this->createForm(ClassroomType::class,$classroom);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $em = $doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('app_classroom');
        }
        return $this->renderForm('classroom/add.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/{id}/delete', name: 'delete_classroom')]
    public function delete(ClassroomRepository $repository,ManagerRegistry $doctrine,$id): Response
    {
        $classroom = $repository->find($id);
        $em = $doctrine->getManager();
        $em->remove($classroom);
        $em->flush();
        return $this->redirectToRoute('app_classroom');

    }



}
