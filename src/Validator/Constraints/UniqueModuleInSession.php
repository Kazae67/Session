<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqueModuleInSession extends Constraint
{
    // Stocker le message d'erreur par défaut
    public $message = 'Le nom du module "{{ labelModule }}" est déjà utilisé dans cette session.';
}
?>
