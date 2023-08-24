<?php
namespace App\EventListener;

use App\Entity\Module;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Exception;

class ModuleListener
{
    public function prePersist(PrePersistEventArgs $args)
    {
        $module = $args->getEntity();

        if (!$module instanceof Module) {
            return;
        }

        $entityManager = $args->getEntityManager();
        $sessions = $module->getSessions();

        foreach ($sessions as $session) {
            foreach ($session->getModules() as $existingModule) {
                if ($existingModule->getLabelModule() === $module->getLabelModule()) {
                    throw new Exception('Le nom du module "' . $module->getLabelModule() . '" est déjà utilisé dans cette session.');
                }
            }
        }
    }
}
?>
