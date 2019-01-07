<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 04/12/2018
 * Time: 10:17
 */

namespace App\Controller;

use App\Entity\Administrator;
use App\Security\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Utility\Auth0Api;
use App\Form\Type\AdminType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class AdminController extends AbstractController
{
    /**
     * @Route("/adminpage", name="admin_page")
     */
    public function index(Auth0Api $auth0Api)
    {

        $user = $this->getUser();

         $users= $auth0Api->getUsers();
         dump($users);
        $form = $this->createForm(AdminType::class, null, array(
            'users_id'=> $auth0Api->getUsersIdAndName()
        ));


        return $this->render('admin/index.html.twig', array(
            'user'=>$user,
            'users'=>$users,
            'form'=>$form->createView(),
        ));
    }

    /**
     * @Route("/save-user-role-data", name="user_role_save_user_role_data")
     * @Method({"POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function saveUserRoleDataAction(Request $request, Auth0Api $auth0Api)
    {
        if(!$request->isXmlHttpRequest()) {
            $response = new Response('not allowed');
            $response->setStatusCode(403);
            return $response;
        }

        foreach($request->get('usersId') as $userId) {
            $user = $auth0Api->getUserByUserId($userId);

            $roles = (isset($user->user_metadata->role) && is_array($user->user_metadata->role)) ? $user->user_metadata->role : array();
            $roles[] = $request->get('role');

            //return new Response(var_dump(array_unique($roles)));

            $auth0Api->updateUserMetadata($userId, array_unique($roles));
        }

        return new Response();
    }

}