<?php

namespace Framelab\Bundle\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use FR3D\LdapBundle\Model\LdapUserInterface;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Framelab\Bundle\UserBundle\Entity\UserRepository")
 */
class User extends BaseUser implements LdapUserInterface
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(
     * targetEntity="Framelab\Bundle\DocumentBundle\Entity\Document",
     * mappedBy="owner",
     * cascade={"remove"})
     * @ORM\OrderBy({"date" = "desc"})
     */
    protected $documents;

    /**
     * Ldap Object Distinguished Name
     * @ORM\Column(type="string", length=128, nullable=true)
     * @var string $dn
     */
    private $dn;

    public function __construct()
    {
        parent::__construct();
        if (empty($this->roles)) {
            $this->roles[] = 'ROLE_USER';
        }
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function setDn($dn)
    {
        $this->dn = $dn;
    }

    /**
     * {@inheritDoc}
     */
    public function getDn()
    {
        return $this->dn;
    }
}
