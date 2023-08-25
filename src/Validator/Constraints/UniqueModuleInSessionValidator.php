<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManagerInterface;

class UniqueModuleInSessionValidator extends ConstraintValidator
{
    private $entityManager;

    // Le constructeur reçoit l'EntityManagerInterface pour accéder à la base de données
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // La méthode de validation, elle reçoit la valeur à valider et la contrainte en cours
    public function validate($value, Constraint $constraint)
    {
        // Récupération de l'objet Module en cours de validation
        $module = $this->context->getObject();

        // Récupération des sessions liées à ce module
        $sessions = $module->getSessions();

        // Parcours des sessions
        foreach ($sessions as $session) {
            // Parcours des modules de chaque session
            foreach ($session->getModules() as $existingModule) {
                // Vérification si le nom du module existe déjà dans la session
                if ($existingModule->getLabelModule() === $value) {
                    // Construction d'une violation de contrainte avec le message personnalisé
                    $this->context->buildViolation($constraint->message)
                        ->setParameter('{{ labelModule }}', $value)
                        ->addViolation();
                    return; // On arrête la vérification dès qu'on trouve une violation
                }
            }
        }
    }
}

?>
