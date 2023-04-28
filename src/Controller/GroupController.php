<?php

namespace App\Controller;

use App\Entity\Group;
use App\Form\GroupType;
use App\Repository\GroupRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/groups')]
class GroupController extends AbstractController
{
    #[Route('/', name: 'app_group_index', methods: ['GET'])]
    public function index(GroupRepository $groupRepository): Response
    {
        $group = $groupRepository->findAll();
    
        return $this->render('group/index.html.twig', [
            'groups' => $group,
        ]);
    }

    #[Route('/new', name: 'app_group_create', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $group = new Group();
        $form = $this->createForm(GroupType::class, $group);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($group);

            foreach ($group->getUsers() as $user) {
                $entityManager->persist($user);
            }
    
            $entityManager->flush();
    
            return $this->redirectToRoute('app_group_index');
        }
    
        return $this->render('group/new-group.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // #[Route('/{id}', name: 'app_group_show', methods: ['GET'])]
    // public function show(group $group): Response
    // {
    //     return $this->render('group/details-group.html.twig', [
    //         'group' => $group,
    //     ]);
    // }

    // #[Route('/{id}/edit', name: 'app_group_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, group $group, GroupRepository $groupRepository): Response
    // {
    //     $form = $this->createForm(groupType::class, $group);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $groupRepository->save($group, true);

    //         return $this->redirectToRoute('app_group_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('group/edit-group.html.twig', [
    //         'group' => $group,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_group_delete', methods: ['POST'])]
    // public function delete(Request $request, group $group, GroupRepository $groupRepository): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$group->getId(), $request->request->get('_token'))) {
    //         $groupRepository->remove($group, true);
    //     }

    //     return $this->redirectToRoute('app_group_index', [], Response::HTTP_SEE_OTHER);
    // }
}