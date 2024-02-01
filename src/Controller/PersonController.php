<?php

namespace App\Controller;

use App\Entity\Person;
use App\Repository\PersonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class PersonController extends AbstractController
{
    #[Route('/person', name: 'app_person')]
    public function index(): Response
    {
        return $this->render('person/index.html.twig', [
            'controller_name' => 'PersonController',
        ]);
    }

    #[Route('/create_person', name: 'create_person')]
    public function createPerson(EntityManagerInterface $entityManager): Response 
    {
        $person = new Person();
        $person->setNom('Mabrouk');
        $person->setPrenom('Mustapha');
        $person->setVille('Marseille');
        $person->setAge('37');
        $person->setDateNaissance(new \DateTime('1986-07-23'));

        $entityManager->persist($person);

        $entityManager->flush();

        return new Response('Saved new person with id ' .$person->getId());
    }

    #[Route('/persons', name: 'app_all_persons', methods :['GET'])]
    public function all_persons(PersonRepository $personRepository): Response 
    {

        return $this->render('person/all_persons.html.twig', [
            'persons' => $personRepository->findAll(),
        ]);
    }
    
    #[Route('/person/{id}', name: 'person_show')]
    public function show2(int $id, EntityManagerInterface $entityManager): Response 
    {
        $person = $entityManager->getRepository(Person::class)->find($id);

        if (!$person) {
            throw $this->createNotFoundException(
                'No person found for id '.$id
            );
        }
        return $this->render('person/show.html.twig', [
            'person' => $person,
        ]);
    }

    #[Route('/person/{id}/edit', name: 'person_edit')]
    public function edit(int $id, PersonRepository $personRepository)
        {
        $person = $personRepository->find($id);

        return $this->render('person/edit.html.twig', [
            'person' => $person,
        ]);
    }

    #[Route('/person/{id}/edit/request', name: 'person_edit_request')]
    public function editRequest(int $id, PersonRepository $personRepository, EntityManagerInterface $entityManager)
        {
        $person = $entityManager->getRepository(Person::class)->find($id);

        $person->setNom($_POST['nom']);
        $person->setPrenom($_POST['prenom']);
        $person->setVille($_POST['ville']);
        $person->setAge($_POST['age']);
        $person->setDateNaissance(new \DateTime($_POST['date_naissance']));

        $entityManager->persist($person);

        $entityManager->flush();

        return $this->redirectToRoute('app_all_persons', [], Response::HTTP_SEE_OTHER);

    }

    #[Route('/persons/add_person', name: 'add_person')]
    public function add_person(): Response
    {
        return $this->render('person/add_person.html.twig', [
        ]);
    }

    #[Route('/persons/add_person_request', name: 'add_person_request')]
    public function add_person_request(EntityManagerInterface $entityManager) : Response
    {
        $person = new Person();

        $person->setNom($_POST['nom']);
        $person->setPrenom($_POST['prenom']);
        $person->setVille($_POST['ville']);
        $person->setAge($_POST['age']);
        $person->setDateNaissance(new \DateTime($_POST['date_naissance']));

        $entityManager->persist($person);

        $entityManager->flush();

        return $this->redirectToRoute('app_all_persons', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/person/{id}/delete', name: 'person_delete')]
        public function delete(Request $request, Person $person, EntityManagerInterface $entityManager): Response
        {

            $entityManager->remove($person);
            $entityManager->flush();
       
    
        return $this->redirectToRoute('app_all_persons', [], Response::HTTP_SEE_OTHER);
        }



}

