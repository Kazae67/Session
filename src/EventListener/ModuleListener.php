<?php
namespace App\EventListener;

use App\Entity\Module;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Exception;

class ModuleListener
{
    // Méthode exécutée avant la persistance d'une entité
    public function prePersist(PrePersistEventArgs $args)
    {
        // Récupération de l'entité Module en cours de persistance
        $module = $args->getEntity();

        // Vérification si l'entité est bien une instance de la classe Module
        if (!$module instanceof Module) {
            return; // Si ce n'est pas un Module, on arrête le traitement
        }

        // Récupération de l'EntityManager pour accéder à la base de données
        $entityManager = $args->getEntityManager();

        // Récupération des sessions liées à ce module
        $sessions = $module->getSessions();

        // Parcours des sessions
        foreach ($sessions as $session) {
            // Parcours des modules de chaque session
            foreach ($session->getModules() as $existingModule) {
                // Vérification si le nom du module existe déjà dans la session
                if ($existingModule->getLabelModule() === $module->getLabelModule()) {
                    // Lancer une exception en cas de doublon de nom de module dans la session
                    throw new Exception('Le nom du module "' . $module->getLabelModule() . '" est déjà utilisé dans cette session.');
                }
            }
        }
    }
}
?>
