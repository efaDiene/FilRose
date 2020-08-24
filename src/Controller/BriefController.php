<?php

namespace App\Controller;

use App\Entity\Brief;
use App\Repository\Promo;
use App\Repository\BriefRepository;
use App\Repository\PromoRepository;
use App\Repository\GroupeRepository;
use App\Repository\FormateurRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BriefController extends AbstractController
{
    /**
     * @Route(
     * path="api/formateurss/promo/{idP}/groupe/{id}/briefs",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\BriefController::listerBrief",
     * "_api_resource_class"=Brief::class,
     * "_api_collection_operation_name"="getBrief"
     * }
     * )
     */
    public function listerBrief(PromoRepository $repo, GroupeRepository $repoGr, SerializerInterface $serializer,$idP,$id)
    {
        $promoObject=$repo->find($idP);
        $GroupPromo= $promoObject->getGroupe();       
        $GroupPromo=$serializer->normalize($GroupPromo,"json");
         
        foreach ($GroupPromo as $group ) {
            $tab_id[]=$group['id'];
        }
        
        if ($tab_id) {
            $isFound=false;
            foreach ($tab_id as $key) {
                if ($key==$id) {
                    $isFound=true;
                }
            }
            if ($isFound==true) {
                $group=$repoGr->find($id);
                $brief=$group->getBriefs();
                $briefJson =$serializer->serialize($brief,"json");
       return new JsonResponse($briefJson,Response::HTTP_OK,[],true);
            }
        }
        
       
    }

    /**
     * @Route(
     * name="Briefs",
     * path="api/formateurss/briefs",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\BriefController::getBrief",
     * "_api_resource_class"=Brief::class,
     * "_api_collection_operation_name"="get_brief"
     * }
     * )
     */
    public function getBrief(BriefRepository $repo, SerializerInterface $serializer)
    {
       
        $briefs=$repo->findAll();
        //$this->denyAccessUnlessGranted('getCompetence',$grpeCompetences,'Accés non autorisé');
       
       $briefs =$serializer->serialize($briefs,"json");
       return new JsonResponse($briefs,Response::HTTP_OK,[],true);
    }

    /**
     * @Route(
     * name="PromBriefs",
     * path="api/formateurss/promos/{id}/briefs",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\BriefController::getPromBrief",
     * "_api_resource_class"=Brief::class,
     * "_api_collection_operation_name"="get_prombrief"
     * }
     * )
     */
    public function getPromBrief(PromoRepository $repo, BriefRepository $briefRepo, SerializerInterface $serializer,$id)
    {
        
        $promoObject=$repo->find($id);
        $GroupPromo= $promoObject->getGroupe();
       
        foreach ($GroupPromo as $group ) { 
            $tab_brief=$group->getBriefs();
            foreach ($tab_brief as $brief) {
                $tab[]=$brief;
            }            
        }
        //$this->denyAccessUnlessGranted('getCompetence',$grpeCompetences,'Accés non autorisé');
       
       $briefs =$serializer->serialize($tab,"json");
       return new JsonResponse($briefs,Response::HTTP_OK,[],true);
    }

    /**
     * @Route(
     * name="BriefsBrouillon",
     * path="api/formateurss/{id}/briefs/brouillon",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\BriefController::getBriefBrouillon",
     * "_api_resource_class"=Brief::class,
     * "_api_collection_operation_name"="get_briefB"
     * }
     * )
     */
    public function getBriefBrouillon(FormateurRepository $repo, BriefRepository $briefRepo, SerializerInterface $serializer,$id)
    {
        
        $formateur=$repo->find($id);        
        $brief= $formateur->getBriefs();
        $brief=$serializer->normalize($brief,"json");

        foreach ($brief as $bf ) { 
            if ($bf['statutBrief'] == "brouillon") {
                $briefB[]=$bf;
            }            
        }
       
        //$this->denyAccessUnlessGranted('getCompetence',$grpeCompetences,'Accés non autorisé');
       
       $briefs =$serializer->serialize($briefB,"json");
       return new JsonResponse($briefs,Response::HTTP_OK,[],true);
    }

    /**
     * @Route(
     * name="BriefsValide",
     * path="api/formateurss/{id}/briefs/valide",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\BriefController::getBriefValide",
     * "_api_resource_class"=Brief::class,
     * "_api_collection_operation_name"="get_briefV"
     * }
     * )
     */
    public function getBriefValide(FormateurRepository $repo,  SerializerInterface $serializer,$id)
    {
        
        $formateur=$repo->find($id);
        if (!isset($formateur)) {
            return new JsonResponse("Ce formateur n'existe pas",Response::HTTP_NOT_FOUND,[],true);
        }        
        $brief= $formateur->getBriefs();
        $brief=$serializer->normalize($brief,"json");

        foreach ($brief as $bf ) { 
            if ($bf['statutBrief'] == "validé") {
                $briefB[]=$bf;
            }            
        }
        if (!isset($briefB)) {
            return new JsonResponse("Aucun brief validé",Response::HTTP_NOT_FOUND,[],true);
        }
       
        //$this->denyAccessUnlessGranted('getCompetence',$grpeCompetences,'Accés non autorisé');
       
       $briefs =$serializer->serialize($briefB,"json");
       return new JsonResponse($briefs,Response::HTTP_OK,[],true);
    }

    /**
     * @Route(
     * name="OnePromBriefs",
     * path="formateurss/promos/{id}/briefs/{idB}",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\BriefController::getOnePromBrief",
     * "_api_resource_class"=Brief::class,
     * "_api_collection_operation_name"="get_Oneprombrief"
     * }
     * )
     */
    public function getOnePromBrief(PromoRepository $repo, BriefRepository $briefRepo, SerializerInterface $serializer,$id, $idB)
    {
        
        $promoObject=$repo->find($id);
        $GroupPromo= $promoObject->getGroupe();

        $briefObject=$briefRepo->find($idB);
        if(isset($briefObject)){
            $isFound=false;
            foreach ($GroupPromo as $group ) { 
                $tab_brief=$group->getBriefs();
                foreach ($tab_brief as $brief) {
                    if ($briefObject==$brief) {
                        $isFound=true;
                    }
                }            
            }
            if ($isFound=true) {
                $briefs =$serializer->serialize($briefObject,"json");
                return new JsonResponse($briefs,Response::HTTP_OK,[],true);
            }
        }
        return new JsonResponse("Ce brief n'existe pas dans cette promo",Response::HTTP_NOT_FOUND,[],true);
        
        //$this->denyAccessUnlessGranted('getCompetence',$grpeCompetences,'Accés non autorisé');
       
       
    }
    
    /**
     * @Route(
     * name="BriefsByApp",
     * path="apprenants/promos/{id}/briefs",
     * methods={"GET"},
     * defaults={
     * "_controller"="App\Controller\BriefController::getBriefByApp",
     * "_api_resource_class"=Brief::class,
     * "_api_collection_operation_name"="brief_app"
     * }
     * )
     */
    public function getBriefByApp(PromoRepository $repo, BriefRepository $briefRepo, SerializerInterface $serializer,$id)
    {
        
        $promoObject=$repo->find($id);
        $GroupPromo= $promoObject->getGroupe();
        $tab=array();
        foreach ($GroupPromo as $group ) { 
            $tab_brief=$group->getBriefs();
            foreach ($tab_brief as $brief) {
                $tab[]=$brief;
            }            
        }
        $tab=$serializer->normalize($tab,"json");
        foreach ($tab as $bf ) { 
            if ($bf['statutBrief'] == "assigné") {
                
                $briefB[]=$bf;
            }            
        }
        if (!isset($briefB)) {
            return new JsonResponse("Aucun brief assigné à ce promo",Response::HTTP_NOT_FOUND,[],true);
        }

        $briefs =$serializer->serialize($briefB,"json");
        return new JsonResponse($briefs,Response::HTTP_OK,[],true);
    }


    
}
