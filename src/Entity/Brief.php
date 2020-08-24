<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BriefRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     attributes={"force_eager"=false,"denormalization_context"={"groups"={"writeGRP"},"enable_max_depth"=true}},
 *        normalizationContext={"groups"={"getBrief"}},
 *        denormalizationContext={"groups"={"postGroupe"}},
 *        collectionOperations={
 *         "getBrief"={
 *             "method"="GET",
 *             "path"="formateurss/promo/{idP}/groupe/{id}/briefs",
 *             "access_control"="(is_granted('ROLE_ADMIN'))",
 *             "access_control_message"="Vous n'avez pas access à cette Ressource",
 *             "normalization_context"={"groups":"getbrief2"},             
 *          }, 
 *         "get_brief"={
 *             "method"="GET",
 *             "path"="formateurss/briefs",
 *             "access_control"="(is_granted('ROLE_ADMIN'))",
 *             "access_control_message"="Vous n'avez pas access à cette Ressource",
 *             "route_name"="Briefs",
 *             "normalization_context"={"groups"={"getBrief3"}},
 *           },  
 *          "get_prombrief"={
 *             "method"="GET",
 *             "path"="formateurss/promo/{id}/briefs",
 *             "access_control"="(is_granted('ROLE_ADMIN'))",
 *             "access_control_message"="Vous n'avez pas access à cette Ressource",
 *             "route_name"="promBriefs",
 *              "normalization_context"={"groups"={"getBrief7"}},
 *          },
 *         "get_briefB"={
 *             "method"="GET",
 *             "path"="formateurss/{id}/briefs/brouillon",
 *             "access_control"="(is_granted('ROLE_ADMIN'))",
 *             "access_control_message"="Vous n'avez pas access à cette Ressource",
 *             "route_name"="BriefsBrouillon",
 *              "normalization_context"={"groups"={"getBrief4"}},
 *          },
 *         "get_briefV"={
 *             "method"="GET",
 *             "path"="formateurss/{id}/briefs/valide",
 *             "access_control"="(is_granted('ROLE_ADMIN'))",
 *             "access_control_message"="Vous n'avez pas access à cette Ressource",
 *             "route_name"="BriefsValide",
 *              "normalization_context"={"groups"={"getBrief5"}},
 *          },
 *         "get_Oneprombrief"={
 *             "method"="GET",
 *             "path"="formateurss/promo/{id}/briefs/{idB}",
 *             "access_control"="(is_granted('ROLE_ADMIN'))",
 *             "access_control_message"="Vous n'avez pas access à cette Ressource",
 *             "route_name"="OnepromBriefs",
 *             "normalization_context"={"groups"={"getBrief6"}},
 *          },
 *         "brief_app"={
 *             "method"="GET",
 *             "path"="apprenants/promos/{id}/briefs",
 *             "access_control"="(is_granted('ROLE_ADMIN'))",
 *             "access_control_message"="Vous n'avez pas access à cette Ressource",
 *             "route_name"="BriefsByApp",
 *             "normalization_context"={"groups"={"getBrief8"}},
 *          },
 *     }
 * )
 * @ORM\Entity(repositoryClass=BriefRepository::class)
 */
class Brief
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"getBrief"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Groups({"getBrief"})
     */
    private $langue;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"getBrief"})
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Groups({"getBrief"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Groups({"getBrief"})
     */
    private $contexte;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Groups({"getBrief"})
     */
    private $livrableAttendus;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $modalitesPedagogiques;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $critereDePerformance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $modalitesEvaluation;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $avatar;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"getBrief"})
     */
    private $statutBrief;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $archivage;

    /**
     * @ORM\ManyToOne(targetEntity=Formateur::class, inversedBy="briefs")
     */
    private $formateur;

    /**
     * @ORM\ManyToMany(targetEntity=Groupe::class, inversedBy="briefs")
     */
    private $groupe;

    /**
     * @ORM\ManyToOne(targetEntity=Referentiel::class, inversedBy="briefs")
     */
    private $referentiel;

    /**
     * @ORM\OneToMany(targetEntity=Niveau::class, mappedBy="brief")
     *  @Groups({"getBrief"})
     */
    private $niveau;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="briefs")
     *  @Groups({"getBrief"})
     */
    private $tag;

    /**
     * @ORM\OneToMany(targetEntity=Ressource::class, mappedBy="brief")
     *  @Groups({"getBrief"})
     */
    private $ressources;

    /**
     * @ORM\OneToMany(targetEntity=PromoBrief::class, mappedBy="brief")
     */
    private $promoBriefs;

    /**
     * @ORM\ManyToMany(targetEntity=LivrablesAttendus::class, mappedBy="brief")
     */
    private $livrablesAttenduses;

    public function __construct()
    {
        $this->groupe = new ArrayCollection();
        $this->niveau = new ArrayCollection();
        $this->tag = new ArrayCollection();
        $this->ressources = new ArrayCollection();
        $this->promoBriefs = new ArrayCollection();
        $this->livrablesAttenduses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(?string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getContexte(): ?string
    {
        return $this->contexte;
    }

    public function setContexte(?string $contexte): self
    {
        $this->contexte = $contexte;

        return $this;
    }

    public function getLivrableAttendus(): ?string
    {
        return $this->livrableAttendus;
    }

    public function setLivrableAttendus(?string $livrableAttendus): self
    {
        $this->livrableAttendus = $livrableAttendus;

        return $this;
    }

    public function getModalitesPedagogiques(): ?string
    {
        return $this->modalitesPedagogiques;
    }

    public function setModalitesPedagogiques(?string $modalitesPedagogiques): self
    {
        $this->modalitesPedagogiques = $modalitesPedagogiques;

        return $this;
    }

    public function getCritereDePerformance(): ?string
    {
        return $this->critereDePerformance;
    }

    public function setCritereDePerformance(?string $critereDePerformance): self
    {
        $this->critereDePerformance = $critereDePerformance;

        return $this;
    }

    public function getModalitesEvaluation(): ?string
    {
        return $this->modalitesEvaluation;
    }

    public function setModalitesEvaluation(?string $modalitesEvaluation): self
    {
        $this->modalitesEvaluation = $modalitesEvaluation;

        return $this;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(?\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getStatutBrief(): ?string
    {
        return $this->statutBrief;
    }

    public function setStatutBrief(?string $statutBrief): self
    {
        $this->statutBrief = $statutBrief;

        return $this;
    }

    public function getArchivage(): ?bool
    {
        return $this->archivage;
    }

    public function setArchivage(?bool $archivage): self
    {
        $this->archivage = $archivage;

        return $this;
    }

    public function getFormateur(): ?Formateur
    {
        return $this->formateur;
    }

    public function setFormateur(?Formateur $formateur): self
    {
        $this->formateur = $formateur;

        return $this;
    }

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupe(): Collection
    {
        return $this->groupe;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupe->contains($groupe)) {
            $this->groupe[] = $groupe;
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupe->contains($groupe)) {
            $this->groupe->removeElement($groupe);
        }

        return $this;
    }

    public function getReferentiel(): ?Referentiel
    {
        return $this->referentiel;
    }

    public function setReferentiel(?Referentiel $referentiel): self
    {
        $this->referentiel = $referentiel;

        return $this;
    }

    /**
     * @return Collection|Niveau[]
     */
    public function getNiveau(): Collection
    {
        return $this->niveau;
    }

    public function addNiveau(Niveau $niveau): self
    {
        if (!$this->niveau->contains($niveau)) {
            $this->niveau[] = $niveau;
            $niveau->setBrief($this);
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->niveau->contains($niveau)) {
            $this->niveau->removeElement($niveau);
            // set the owning side to null (unless already changed)
            if ($niveau->getBrief() === $this) {
                $niveau->setBrief(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tag->contains($tag)) {
            $this->tag[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tag->contains($tag)) {
            $this->tag->removeElement($tag);
        }

        return $this;
    }

    /**
     * @return Collection|Ressource[]
     */
    public function getRessources(): Collection
    {
        return $this->ressources;
    }

    public function addRessource(Ressource $ressource): self
    {
        if (!$this->ressources->contains($ressource)) {
            $this->ressources[] = $ressource;
            $ressource->setBrief($this);
        }

        return $this;
    }

    public function removeRessource(Ressource $ressource): self
    {
        if ($this->ressources->contains($ressource)) {
            $this->ressources->removeElement($ressource);
            // set the owning side to null (unless already changed)
            if ($ressource->getBrief() === $this) {
                $ressource->setBrief(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PromoBrief[]
     */
    public function getPromoBriefs(): Collection
    {
        return $this->promoBriefs;
    }

    public function addPromoBrief(PromoBrief $promoBrief): self
    {
        if (!$this->promoBriefs->contains($promoBrief)) {
            $this->promoBriefs[] = $promoBrief;
            $promoBrief->setBrief($this);
        }

        return $this;
    }

    public function removePromoBrief(PromoBrief $promoBrief): self
    {
        if ($this->promoBriefs->contains($promoBrief)) {
            $this->promoBriefs->removeElement($promoBrief);
            // set the owning side to null (unless already changed)
            if ($promoBrief->getBrief() === $this) {
                $promoBrief->setBrief(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|LivrablesAttendus[]
     */
    public function getLivrablesAttenduses(): Collection
    {
        return $this->livrablesAttenduses;
    }

    public function addLivrablesAttendus(LivrablesAttendus $livrablesAttendus): self
    {
        if (!$this->livrablesAttenduses->contains($livrablesAttendus)) {
            $this->livrablesAttenduses[] = $livrablesAttendus;
            $livrablesAttendus->addBrief($this);
        }

        return $this;
    }

    public function removeLivrablesAttendus(LivrablesAttendus $livrablesAttendus): self
    {
        if ($this->livrablesAttenduses->contains($livrablesAttendus)) {
            $this->livrablesAttenduses->removeElement($livrablesAttendus);
            $livrablesAttendus->removeBrief($this);
        }

        return $this;
    }
}
