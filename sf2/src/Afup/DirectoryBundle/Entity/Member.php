<?php

namespace Afup\DirectoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Member
 *
 * @ORM\Table(name="annuairepro_MembreAnnuaire")
 * @ORM\Entity
 */
class Member
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var LegalForm
     *
     * @ORM\ManyToOne(targetEntity="LegalForm", inversedBy="DirectoryMembers")
     * @ORM\JoinColumn(name="FormeJuridique", referencedColumnName="ID")
     * @ORM\OrderBy({"name" = "ASC"})
     * @Assert\NotNull()
     */
    private $LegalForm;

    /**
     * @var string
     *
     * @ORM\Column(name="RaisonSociale", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="SIREN", type="string", length=255)
     */
    private $siren;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="SiteWeb", type="string", length=255)
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="Telephone", type="string", length=255)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="Fax", type="string", length=20)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="Adresse", type="text")
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="CodePostal", type="string", length=5)
     */
    private $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="Ville", type="string", length=255)
     */
    private $city;

    /**
     * @var Country
     *
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="DirectoryMembers")
     * @ORM\JoinColumn(name="id_pays", referencedColumnName="id")
     * @ORM\OrderBy({"name" = "ASC"})
     * @Assert\NotNull()
     */
    private $Country;

    /**
     * @var Zone
     *
     * @ORM\ManyToOne(targetEntity="Zone", inversedBy="DirectoryMembers")
     * @ORM\JoinColumn(name="Zone", referencedColumnName="ID")
     * @ORM\OrderBy({"name" = "ASC"})
     * @Assert\NotNull()
     */
    private $Zone;

    /**
     * @var string
     *
     * @ORM\Column(name="NumeroFormateur", type="string", length=255)
     */
    private $trainerNumber;

    /**
     * @var boolean
     *
     * @ORM\Column(name="MembreAFUP", type="boolean")
     */
    private $isAfupMember;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Valide", type="boolean")
     */
    private $isEnabled;

    /**
     * @var datetime
     *
     * @ORM\Column(name="DateCreation", type="datetime")
     */
    private $createdAt;

    /**
     * @var CompanySize
     *
     * @ORM\ManyToOne(targetEntity="CompanySize", inversedBy="DirectoryMembers")
     * @ORM\JoinColumn(name="TailleSociete", referencedColumnName="ID")
     * @ORM\OrderBy({"name" = "ASC"})
     * @Assert\NotNull()
     */
    private $CompanySize;

    /**
     * @var string
     *
     * @ORM\Column(name="Password", type="string", length=50)
     */
    private $password;



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
     * Set name
     *
     * @param string $name
     * @return Member
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set siren
     *
     * @param string $siren
     * @return Member
     */
    public function setSiren($siren)
    {
        $this->siren = $siren;

        return $this;
    }

    /**
     * Get siren
     *
     * @return string
     */
    public function getSiren()
    {
        return $this->siren;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Member
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return Member
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Member
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return Member
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Member
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set zipCode
     *
     * @param string $zipCode
     * @return Member
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Member
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set trainerNumber
     *
     * @param string $trainerNumber
     * @return Member
     */
    public function setTrainerNumber($trainerNumber)
    {
        $this->trainerNumber = $trainerNumber;

        return $this;
    }

    /**
     * Get trainerNumber
     *
     * @return string
     */
    public function getTrainerNumber()
    {
        return $this->trainerNumber;
    }

    /**
     * Set isAfupMember
     *
     * @param boolean $isAfupMember
     * @return Member
     */
    public function setIsAfupMember($isAfupMember)
    {
        $this->isAfupMember = $isAfupMember;

        return $this;
    }

    /**
     * Get isAfupMember
     *
     * @return boolean
     */
    public function getIsAfupMember()
    {
        return $this->isAfupMember;
    }

    /**
     * Set isEnabled
     *
     * @param boolean $isEnabled
     * @return Member
     */
    public function setIsEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }

    /**
     * Get isEnabled
     *
     * @return boolean
     */
    public function getIsEnabled()
    {
        return $this->isEnabled;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Member
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set LegalForm
     *
     * @param \Afup\DirectoryBundle\Entity\LegalForm $legalForm
     * @return Member
     */
    public function setLegalForm(\Afup\DirectoryBundle\Entity\LegalForm $legalForm = null)
    {
        $this->LegalForm = $legalForm;

        return $this;
    }

    /**
     * Get LegalForm
     *
     * @return \Afup\DirectoryBundle\Entity\LegalForm
     */
    public function getLegalForm()
    {
        return $this->LegalForm;
    }

    /**
     * Set Country
     *
     * @param \Afup\DirectoryBundle\Entity\Country $country
     * @return Member
     */
    public function setCountry(\Afup\DirectoryBundle\Entity\Country $country = null)
    {
        $this->Country = $country;

        return $this;
    }

    /**
     * Get Country
     *
     * @return \Afup\DirectoryBundle\Entity\Country
     */
    public function getCountry()
    {
        return $this->Country;
    }

    /**
     * Set Zone
     *
     * @param \Afup\DirectoryBundle\Entity\Zone $zone
     * @return Member
     */
    public function setZone(\Afup\DirectoryBundle\Entity\Zone $zone = null)
    {
        $this->Zone = $zone;

        return $this;
    }

    /**
     * Get Zone
     *
     * @return \Afup\DirectoryBundle\Entity\Zone
     */
    public function getZone()
    {
        return $this->Zone;
    }

    /**
     * Set CompanySize
     *
     * @param \Afup\DirectoryBundle\Entity\CompanySize $companySize
     * @return Member
     */
    public function setCompanySize(\Afup\DirectoryBundle\Entity\CompanySize $companySize = null)
    {
        $this->CompanySize = $companySize;

        return $this;
    }

    /**
     * Get CompanySize
     *
     * @return \Afup\DirectoryBundle\Entity\CompanySize
     */
    public function getCompanySize()
    {
        return $this->CompanySize;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Member
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
