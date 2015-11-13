<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Todo;

use AppBundle\Transformer\TodoTransformer;

use League\Fractal;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/api/todos")
 */
class TodoController extends Controller
{
    /**
     * @ApiDoc(
     *  description="Returns a collection of Todos",
     * )
     * @Route("/")
     * @Method({"GET"})
     */
    public function cgetAction()
    {
        // Determine the current user has the correct access

        $todos = $this->getDoctrine()->getRepository('AppBundle:Todo')->findAll();

        // Display the todo
        $fractal = new Fractal\Manager();
        $resource = new Fractal\Resource\Collection(
            $todos,
            new TodoTransformer($this->get('jms_serializer'))
        );

        return new JsonResponse($fractal->createData($resource)->toArray());
    }

    /**
     * @ApiDoc(
     *  description="Delete an existing Todo",
     * )
     * @Route("/{todo}")
     * @Method({"DELETE"})
     */
    public function deleteAction(Request $request, Todo $todo)
    {
        // Determine the current user has the correct access

        $this->getDoctrine()->getManager()->remove($todo);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse();
    }

    /**
     * This is the documentation description of your method, it will appear
     * on a specific pane. It will read all the text until the first
     * annotation.
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Returns a single Todo",
     * )
     * @Route("/{todo}")
     * @Method({"GET"})
     */
    public function getAction(Todo $todo)
    {
        // Determine the current user has the correct access

        // Display the todo
        $fractal = new Fractal\Manager();
        $resource = new Fractal\Resource\Item(
            $todo,
            new TodoTransformer($this->get('jms_serializer'))
        );

        return new JsonResponse($fractal->createData($resource)->toArray());
    }

    /**
     * @ApiDoc(
     *  description="Update an existing Todo",
     * )
     * @Route("/{todo}")
     * @Method({"PATCH"})
     */
    public function patchAction(Request $request, Todo $todo)
    {
        // Determine the current user has the correct access

        $content = json_decode($request->getContent(), true);
        if (array_key_exists('title', $content['data']['attributes'])) {
            $todo->setTitle($content['data']['attributes']['title']);
        }
        if (array_key_exists('isCompleted', $content['data']['attributes'])) {
            if ('false' === $content['data']['attributes']['isCompleted']) {
                $todo->setIsCompleted(false);
            } elseif ('true' === $content['data']['attributes']['isCompleted']) {
                $todo->setIsCompleted(true);
            }
        }
        $this->getDoctrine()->getManager()->flush($todo);
        // Display the todo
        $fractal = new Fractal\Manager();
        $resource = new Fractal\Resource\Item(
            $todo,
            new TodoTransformer($this->get('jms_serializer'))
        );

        return new JsonResponse($fractal->createData($resource)->toArray());
    }

    /**
     * @ApiDoc(
     *  description="Create a new Todo",
     * )
     * @Route("/")
     * @Method({"POST"})
     */
    public function postAction(Request $request)
    {
        // Determine the current user has the correct access

        $content = json_decode($request->getContent(), true);
        $todo = new Todo();
        $todo->setTitle($content['data']['attributes']['title']);
        $todo->setIsCompleted(false);
        $this->getDoctrine()->getManager()->persist($todo);
        $this->getDoctrine()->getManager()->flush($todo);
        // Display the todo
        $fractal = new Fractal\Manager();
        $resource = new Fractal\Resource\Item(
            $todo,
            new TodoTransformer($this->get('jms_serializer'))
        );

        return new JsonResponse($fractal->createData($resource)->toArray());
    }

}
