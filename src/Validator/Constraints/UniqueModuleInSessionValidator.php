<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManagerInterface;

class UniqueModuleInSessionValidator extends ConstraintValidator
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function validate($value, Constraint $constraint)
    {
        $module = $this->context->getObject();
        $sessions = $module->getSessions();

        foreach ($sessions as $session) {
            foreach ($session->getModules() as $existingModule) {
                if ($existingModule->getLabelModule() === $value) {
                    $this->context->buildViolation($constraint->message)
                        ->setParameter('{{ labelModule }}', $value)
                        ->addViolation();
                    return;
                }
            }
        }
    }
}

?>