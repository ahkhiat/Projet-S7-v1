<?php

namespace App\Controller;

use App\Entity\Person;
use App\Repository\PersonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        $person->setNom('Hamiche');
        $person->setPrenom('Nadia');
        $person->setVille('Marseille');
        $person->setAge('43');
        $person->setDateNaissance(new \DateTime('1980-05-05'));

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
        //var_dump($personne);

        return $this->render('person/edit.html.twig', [
            'person' => $person,
        ]);
      }

    #[Route('/personne/{id}/delete', name: 'person_delete')]
        public function delete(Request $request, Person $person, PersonRepository
        $personRepository): Response
        {
        $personRepository->remove($person, true);
        return $this->redirectToRoute('app_personnes', [], Response::HTTP_SEE_OTHER);
        }



}

