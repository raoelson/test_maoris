<?php

namespace Test\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Test\AppBundle\Entity\Type;
use Test\AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    /**
     * @Route("/",name="index")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $types = $em->getRepository("AppBundle:Type")->getAll();
        $user = $em->getRepository("AppBundle:User")->getAllTypes();
        return $this->render('AppBundle:Default:index.html.twig', array('data'
                    => $types, 'users' => $user));
    }

    /**
     * @Route("ajouter", name="typeaction_ajouter")
     * @param Request $request
     */
    public function ajouterAction(Request $request) {
        if ($request->isXmlHttpRequest()) {
            $libelle = $request->request->get('libelle');
            $age = $request->request->get('age');
            $race = $request->request->get('race');
            $nourriture = $request->request->get('nourriture');
            $famille = $request->request->get('famille');
            $type = new Type();
            $type->setNom($libelle);
            $type->setNourriture($nourriture);
            $type->setFamille($famille);
            $type->setRace($race);
            $type->setAge($age);
            $em = $this->getDoctrine()->getManager();
            if ($request->request->get('user')) {
                $utilisateur = array();
                foreach (explode(',', $request->request->get('user'))
                as $userName) {
                    $userEntity = null;
                    if (isset($utilisateur[$userName])) {
                        $userEntity = $utilisateur[$userName];
                    } else {
                        $userEntity = $em->
                                getRepository("AppBundle:User")
                                ->findOneBy(array('username' => $userName));
                        $utilisateur[$userName] = $userEntity;
                    }
                    if ($userEntity) {
                        $user = $userEntity;
                        $type->setUser($user);
                    }
                    $em->persist($user);
                }
            }
            try {
                $em->persist($type);
                $em->flush();
                $resultat = 1;
            } catch (\Exception $ex) {
                var_dump($ex->getMessage());
                $resultat = 0;
            }
            return new JsonResponse($resultat);
        }
    }

    /**
     * @Route("/type-action-modif/{idTypeAction}", name="typeaction_modifier")
     * @param integer idTypeAction
     * @param Request $request
     */
    public function modifierAction($idTypeAction, Request $request) {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $typeAction = $em->find("AppBundle:Type", $request->request->get('id'));
            $libelle = $request->request->get('libelle');
            $age = $request->request->get('age');
            $race = $request->request->get('race');
            $nourriture = $request->request->get('nourriture');
            $typeAction->setNom($libelle);
            $typeAction->setNourriture($nourriture);
            $typeAction->setFamille($request->request->get('famille'));
            $typeAction->setRace($race);
            $typeAction->setAge($age);

            //supprimer tous les status et catégories
            $db = $em->getConnection();
            $stmt = $db->prepare("DELETE FROM liste_ami WHERE type_id = '" . $request->request->get('id') . "'");
            $stmt->execute();
            if ($request->request->get('user')) {
                $utilisateur = array();
                foreach (explode(',', $request->request->get('user'))
                as $userName) {
                    $userEntity = null;
                    if (isset($utilisateur[$userName])) {
                        $userEntity = $utilisateur[$userName];
                    } else {
                        $userEntity = $em->
                                getRepository("AppBundle:User")
                                ->findOneBy(array('username' => $userName));
                        $utilisateur[$userName] = $userEntity;
                    }

                    if (!$userEntity) {
                        $user = new Test\AppBundle\Entity\User;
                        $user->setUsername($userName);
                        $user->setType($typeAction);
                        $typeAction->addUser($user);
                    } else {
                        $user = $userEntity;
                        $typeAction->setUser($user);
                    }
                    $em->persist($user);
                }
            }
            try {
                $em->persist($typeAction);
                $em->flush();
                $resultat = 1;
            } catch (\Exception $ex) {
                var_dump($ex->getMessage());
                $resultat = 0;
            }
            return new JsonResponse(array('data' => $resultat));
        }
    }
    
    /**
     * @Route("/type-action-supp/{id}", name="typeaction_supprimer")
     * @param integer id
     * @param Request $request
     */
    public function supprimerAction($id, Request $request) {
        if ($request->isXmlHttpRequest()) {
            $id =$request->request->get('id');
            $em = $this->getDoctrine()->getManager();
            $typeAction = $em->find("AppBundle:Type", $id);
            $db = $em->getConnection();
            $stmt = $db->prepare("DELETE FROM liste_ami WHERE type_id = '" . $id. "'");
            $stmt->execute();
            $em->remove($typeAction);
            $em->flush();
            return new JsonResponse($id);
        }
    }

}
