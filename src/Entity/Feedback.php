<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FeedbackRepository")
 * @ORM\Table(name="feedback")
 */
class Feedback
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Length(
     *     min=10,
     *     minMessage="Слишком мало символов в имени. Необходимо больше 10 символов",
     *     max=200,
     *     maxMessage="Слишком много символов в имени. Необходимо менее 100 символов"
     * )
     *
     * @ORM\Column(type="string",length=255)
     */
    private $name;

    /**
     * @Assert\Positive()
     *
     * @ORM\Column(type="integer")
     */
    private $phone;

    /**
     * @Assert\Email()
     * @Assert\Length(
     *     min=10,
     *     minMessage="Слишком мало символов в электронной почте. Необходимо больше 10 символов",
     *     max=500,
     *     maxMessage="Слишком много символов в вопросе. Необходимо менее 500 символов"
     * )
     *
     * @ORM\Column(type="string",length=511)
     */
    private $email;

    /**
     * @Assert\Length(
     *     min=10,
     *     minMessage="Слишком мало символов в вопросе. Необходимо больше 10 символов",
     *     max=1000,
     *     maxMessage="Слишком много символов в вопросе. Необходимо менее 1000 символов"
     * )
     *
     * @ORM\Column(type="string",length=1023)
     */
    private $question;

    public function getName(){
        return $this->name;
    }

    public function setName(string $name){
        $this->name = $name;
    }

    public function getPhone(){
        return $this->phone;
    }

    public function setPhone(string $phone){
        $this->phone = $phone;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail(string $email){
        $this->email = $email;
    }

    public function getQuestion(){
        return $this->question;
    }

    public function setQuestion(string $question){
        $this->question = $question;
    }

}