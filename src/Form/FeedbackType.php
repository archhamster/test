<?php


namespace App\Form;

use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\AbstractType as AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeedbackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label'=>'Ф.И.О',
                'required' => true,
                //'error_bubbling'=>true
            ])
            ->add('phone',IntegerType::class,[
                'label'=>'Телефон',
                'required' => false,
                //'error_bubbling'=>true,
                'attr' => [
                    'min' => 10000000000,
                    'max' => 99999999999,
                    'step' => 1
                ]
            ])
            ->add('email',EmailType::class,[
                'label'=>'Почта',
                'required' => false,
                //'error_bubbling'=>true
            ])
            ->add('question',TextareaType::class,[
                'label'=>'Задайте вопрос',
                'required' => true,
                //'error_bubbling'=>true
            ])
            //->add('submit',SubmitType::class,['label'=> ' Отправить'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {

    }

}