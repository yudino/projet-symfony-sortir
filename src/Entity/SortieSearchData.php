<?php


namespace App\Entity;

use Symfony\Component\Validator\Constraints\DateTime;


class SortieSearchData
{
    /**
     * @var string | null
     */
    private $nomCampus = '';


    /**
     * @var string | null
     */
    private $motCle = '';

    /**
     * @var datetime
     */
    private $dateDebutSearch;

    /**
     * @var datetime
     */
    private $dateFinSearch;

    /**
     * @var boolean
     */
    private $sortieOrganisateur = false;

    /**
     * @var boolean
     */
    private $sortieInscrit = false;
    /**
     * @var boolean
     */
    private $sortieNonInscrit = false;
    /**
     * @var boolean
     */
    private $sortiePassees = false;

    /**
     * @return string
     */
    public function getNomCampus()
    {
        return $this->nomCampus;
    }

    /**
     * @param string $nomCampus
     */
    public function setNomCampus($nomCampus): void
    {
        $this->nomCampus = $nomCampus;
    }

    /**
     * @return string|null
     */
    public function getMotCle(): ?string
    {
        return $this->motCle;
    }

    /**
     * @param string|null $motCle
     */
    public function setMotCle(?string $motCle): void
    {
        $this->motCle = $motCle;
    }

    /**
     * @return mixed
     */
    public function getDateDebutSearch()
    {
        return $this->dateDebutSearch;
    }

    /**
     * @param mixed $dateDebutSearch
     */
    public function setDateDebutSearch($dateDebutSearch): void
    {
        $this->dateDebutSearch = $dateDebutSearch;
    }

    /**
     * @return mixed
     */
    public function getDateFinSearch()
    {
        return $this->dateFinSearch;
    }

    /**
     * @param mixed $dateFinSearch
     */
    public function setDateFinSearch($dateFinSearch): void
    {
        $this->dateFinSearch = $dateFinSearch;
    }

    /**
     * @return bool
     */
    public function isSortieOrganisateur(): bool
    {
        return $this->sortieOrganisateur;
    }

    /**
     * @param bool $sortieOrganisateur
     */
    public function setSortieOrganisateur(bool $sortieOrganisateur): void
    {
        $this->sortieOrganisateur = $sortieOrganisateur;
    }

    /**
     * @return bool
     */
    public function isSortieInscrit(): bool
    {
        return $this->sortieInscrit;
    }

    /**
     * @param bool $sortieInscrit
     */
    public function setSortieInscrit(bool $sortieInscrit): void
    {
        $this->sortieInscrit = $sortieInscrit;
    }

    /**
     * @return bool
     */
    public function isSortieNonInscrit(): bool
    {
        return $this->sortieNonInscrit;
    }

    /**
     * @param bool $sortieNonInscrit
     */
    public function setSortieNonInscrit(bool $sortieNonInscrit): void
    {
        $this->sortieNonInscrit = $sortieNonInscrit;
    }

    /**
     * @return bool
     */
    public function isSortiePassees(): bool
    {
        return $this->sortiePassees;
    }

    /**
     * @param bool $sortiePassees
     */
    public function setSortiePassees(bool $sortiePassees): void
    {
        $this->sortiePassees = $sortiePassees;
    }

}