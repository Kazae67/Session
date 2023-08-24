<?php 

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="module_session", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="module_session_unique", columns={"module_id", "session_id"})
 * })
 */
class ModuleSession
{
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Module", inversedBy="moduleSessions")
     * @ORM\JoinColumn(name="module_id", referencedColumnName="id", nullable=false)
     */
    private $module;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Session", inversedBy="moduleSessions")
     * @ORM\JoinColumn(name="session_id", referencedColumnName="id", nullable=false)
     */
    private $session;

    public function getModule(): ?Module
    {
        return $this->module;
    }
    
    public function setModule(?Module $module): self
    {
        $this->module = $module;
        return $this;
    }
    
    public function getSession(): ?Session
    {
        return $this->session;
    }
    
    public function setSession(?Session $session): self
    {
        $this->session = $session;
        return $this;
    }
}
