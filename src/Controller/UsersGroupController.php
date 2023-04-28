<?php

namespace App\Controller;

use App\Entity\UsersGroup;
use App\Form\CreateGroupFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UsersGroupRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/groups')]
class UsersGroupController extends AbstractController
{
    #[Route('/', name: 'app_group_index')]
    public function index(EntityManagerInterface $entityManager, UsersGroupRepository $userGroups)
    {
        $groups = $entityManager->createQueryBuilder()
            ->select('g', 'COUNT(u) AS userCount')
            ->from('App\Entity\UsersGroup', 'g')
            ->leftJoin('g.users', 'u')
            ->groupBy('g.id')
            ->getQuery()
            ->getResult();

        return $this->render('group/index.html.twig', [
            'groups' => $groups,
            'userGroups' => $userGroups->findAll()
        ]);
    }

    #[Route('/create', name: 'app_group_create')]
    public function create(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $usersGroup = new UsersGroup();
    
        $form = $this->createForm(CreateGroupFormType::class, $usersGroup, [
            'users' => $userRepository->findAll(),
        ]);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($usersGroup->getUsers() as $user) {
                $entityManager->persist($user);
            }
            $entityManager->persist($usersGroup);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_group_index');
        }
    
        return $this->render('group/new-group.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_group_show', methods: ['GET'])]
    public function show(EntityManagerInterface $em, UsersGroup $usersGroup): Response
    {
        return $this->render('group/details-group.html.twig', [
            'usersGroup' => $usersGroup,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_group_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UsersGroup $usersGroup, UsersGroupRepository $usersGroupRepository): Response
    {
        $form = $this->createForm(CategoryType::class, $usersGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $usersGroupRepository->save($usersGroup, true);

            return $this->redirectToRoute('app_group_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('group/edit-group.html.twig', [
            'group' => $usersGroup,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_group_delete', methods: ['POST'])]
    public function delete(Request $request, UsersGroup $usersGroup, UsersGroupRepository $usersGroupRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$usersGroup->getId(), $request->request->get('_token'))) {
            $usersGroupRepository->remove($usersGroup, true);
        }

        return $this->redirectToRoute('app_group_index', [], Response::HTTP_SEE_OTHER);
    }
}
