<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ApprenantRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ApprenantController extends AbstractController
{
    /**
     * @Route("/apprenant", name="apprenant")
     */
    public function index()
    {
        return $this->render('apprenant/index.html.twig', [
            'controller_name' => 'ApprenantController',
        ]);
    }

    /**
     * @Route(
     * name="apprenant_liste",
     * path="api/admin/apprenants",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\ApprenantController::listerApprenant",
     * "_api_resource_class"=User::class,
     * "_api_collection_operation_name"="get_apprenants"
     * }
     * )
     */
    public function listerApprenant(ApprenantRepository $repo,SerializerInterface $serializer)
    {
        $apprenants=$repo->findAll();
        foreach ($apprenants as $apprenant){
            if($apprenant->getArchivage()==1){
                $tabApprenants[]=$apprenant;
            }
        }
        $regionsJson =$serializer->serialize($tabApprenants,"json");
        return new JsonResponse($regionsJson,Response::HTTP_OK,[],true);
    }
    /**
     * @Route(
     * name="ajouter_apprenant",
     * path="api/ajouterApprenant",
     * methods={"POST"},
     * defaults={
     * "_controller"="App\ControllerApprenantController::ajouterApprenant",
     * "_api_resource_class"=User::class,
     * "_api_collection_operation_name"="post_ajouterApprenant"
     * }
     * )
     */
    public function ajouterApprenant(Request $request,UserRepository $repo,SerializerInterface $serializer)
    {

        $user= $serializer->deserialize($request->getContent(),User::class,'json');

        $em=  $this->getDoctrine()->getManager();
        $em->persist($user);

        $em->flush();
    }
    /**
     * @Route(
     * name="supprimerUSer",
     * path="api/supprimerUser/{id}",
     * methods={"DELETE"},
     * defaults={
     * "_controller"="\app\ControllerApprenantController::supprimerUser",
     * "_api_resource_class"=User::class,
     * "_api_item_operation_name"="delete_supprimerUSer"
     * }
     * )
     */
    public function supprimerApprenant(UserRepository $repo,SerializerInterface $serializer,$id)
    {
        $em=  $this->getDoctrine()->getManager();
        $regionsObject=$repo->find($id);
        $regionsObject->setArchivage(false);

        $em->persist($regionsObject);
        $em->flush();
    }
    /**
     * @Route(
     * name="modifierApprenant",
     * path="api/modifierApprenant/{id}",
     * methods={"PUT"},
     * defaults={
     * "_controller"="\app\ControllerApprenantController::modifierApprenant",
     * "_api_resource_class"=User::class,
     * "_api_item_operation_name"="put_modifierApprenant"
     * }
     * )
     */
    public function modifierApprenant(ApprenantRepository $appre,Request $request,UserRepository $repo,SerializerInterface $serializer,$id)
    {
        $apprenant=$appre->find($id);
        dd($apprenant);
        $em=$this->getDoctrine()->getManager();
        $user=$serializer->deserialize($request->getContent(),User::class,'json');
        $em->persist($user);
        $em->flush();

    }


    /**
     * @Route(
     * name="apprenant_liste_one",
     * path="api/apprenant/{id}",
     * methods={"GET"},
     * defaults={
     * "_controller"="\app\ControllerApprenantController::findApprenant",
     * "_api_resource_class"=User::class,
     * "_api_item_operation_name"="get_apprenant"
     * }
     * )
     */
    public function findApprenant(UserRepository $repo,SerializerInterface $serializer, $id)
    {
        $user=$repo->find($id);
        $x=$user->getRoles();
        if($x[0]=="ROLE_APPRENANT"){

            $user =$serializer->serialize($user,"json");
            return new JsonResponse($user,Response::HTTP_OK,[],true);
        }
    }

    /**
     * @Route(
     * name="getAppre",
     * path="/apprenantes/{id}",
     * methods={"GET"},
     * defaults={
     * "_controller"="\app\ControllerApprenantController::getApprenant",
     * "_api_resource_class"=Apprenant::class,
     * "_api_item_operation_name"="getOneAppren"
     * }
     * )
     */
    public function getApprenant(ApprenantRepository $repo,SerializerInterface $serializer, $id)
    {
        $user=$repo->find($id);

$user->id=$id;
            $user =$serializer->serialize($user,"json");
            return new JsonResponse($user,Response::HTTP_OK,[],true);

    }

}

