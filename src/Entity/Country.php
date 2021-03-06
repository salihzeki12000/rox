<?php
/*
 * @codingStandardsIgnoreFile
 *
 * Auto generated file ignore for Code Sniffer
*/

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Country.
 *
 * @ORM\Table(name="geonamescountries")
 * @ORM\Entity
 *
 * @SuppressWarnings(PHPMD)
 * Auto generated class do not check mess
 */
class Country
{
    /**
     * @var int
     *
     * @ORM\Column(name="geonameId", type="integer", nullable=true)
     */
    private $geonameid;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=200, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="continent", type="string", length=2, nullable=true)
     */
    private $continent;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=2)
     * @ORM\Id
     */
    private $country;

    /**
     * Set geonameId.
     *
     * @param int $geonameid
     *
     * @return Country
     */
    public function setGeonameid($geonameid)
    {
        $this->geonameId = $geonameid;

        return $this;
    }

    /**
     * Get geonameId.
     *
     * @return int
     */
    public function getGeonameid()
    {
        return $this->geonameId;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Country
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set continent.
     *
     * @param string $continent
     *
     * @return Country
     */
    public function setContinent($continent)
    {
        $this->continent = $continent;

        return $this;
    }

    /**
     * Get continent.
     *
     * @return string
     */
    public function getContinent()
    {
        return $this->continent;
    }

    /**
     * Get country.
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set country.
     *
     * @param string $country
     *
     * @return string
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }
}
