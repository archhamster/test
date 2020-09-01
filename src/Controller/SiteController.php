<?php

namespace App\Controller;

use App\Form\FeedbackType;
use App\Repository\FeedbackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use App\Entity\Feedback;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormError;

class SiteController extends AbstractController
{
    /**
     * @Route("/", methods="GET", name="site_index")
     */
    public function index(): Response
    {
        $form = $this->createForm(FeedbackType::class);

        return $this->render('site/index.html.twig',['form' => $form->createView()]);
    }

    /**
     * @Route("/", methods="POST", name="site_feedback")
     */
    public function new(Request $request): Response
    {
        $feedback = new Feedback();
        $form = $this->createForm(FeedbackType::class, $feedback);
        $form->handleRequest($request);

        $message = 'Произошла какая-то ошибка';
        if ($form->isSubmitted() && (empty($feedback->getPhone()) and
                empty($feedback->getEmail()) )) {
            $message = 'Хотя бы одно из полей - телефон, электронная почта должны быть заполнены!';
            $form->addError(new FormError($message));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($feedback);
            $em->flush();

            return new JsonResponse([
                'valid' => true,
                'message' => 'Ваши данные добавлены!',
                'alert' => 'success',
                'errors' => []
            ]);
        }//$form->getErrors(true)

        return new JsonResponse([
            'valid' => false,
            'message' => $message,
            'alert' => 'danger',
            'errors' => $this->getErrorMessages($form)
        ]);
    }

    /**
     * @Route("/db", methods="GET", name="site_database")
     */
    public function database(FeedbackRepository $repository){
        $items = $repository->findAll();
        return $this->render('site/database.html.twig',['items'=>$items]);
    }

    protected function getErrorMessages(\Symfony\Component\Form\Form $form)
    {
        $errors = array();

        foreach ($form->getErrors() as $key => $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getErrorMessages($child);
            }
        }

        return $errors;
    }
}
