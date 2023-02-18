<?php

namespace App\Controller;

use App\Entity\Demo;
use App\Form\DemoType;
use App\Repository\DemoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/demo')]
class DemoController extends AbstractController
{
    #[Route('/', name: 'app_demo_index', methods: ['GET'])]
    public function index(DemoRepository $demoRepository): Response
    {
        return $this->render('demo/index.html.twig', [
            'demos' => $demoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_demo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DemoRepository $demoRepository): Response
    {
        $demo = new Demo();
        $form = $this->createForm(DemoType::class, $demo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $demoRepository->save($demo, true);

            return $this->redirectToRoute('app_demo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('demo/new.html.twig', [
            'demo' => $demo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_demo_show', methods: ['GET'])]
    public function show(Demo $demo): Response
    {
        return $this->render('demo/show.html.twig', [
            'demo' => $demo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_demo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Demo $demo, DemoRepository $demoRepository): Response
    {
        $form = $this->createForm(DemoType::class, $demo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $demoRepository->save($demo, true);

            return $this->redirectToRoute('app_demo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('demo/edit.html.twig', [
            'demo' => $demo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_demo_delete', methods: ['POST'])]
    public function delete(Request $request, Demo $demo, DemoRepository $demoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $demo->getId(), $request->request->get('_token'))) {
            $demoRepository->remove($demo, true);
        }

        return $this->redirectToRoute('app_demo_index', [], Response::HTTP_SEE_OTHER);
    }
}
