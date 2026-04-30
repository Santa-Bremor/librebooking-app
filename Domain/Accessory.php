<?php

class Accessory
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var int */
    private $quantityAvailable;

    /** @var ResourceAccessory[] */
    private $resources = [];

    /** @var int|null */
    private $responsibleUserId;

    /**
     * @param int $id
     * @param string $name
     * @param int $quantityAvailable
     * @param int|null $responsibleUserId
     */
    public function __construct($id, $name, $quantityAvailable, $responsibleUserId = null)
    {
        $this->id = $id;
        $this->SetName($name);
        $this->SetQuantityAvailable($quantityAvailable);
        $this->SetResponsibleUserId($responsibleUserId);
    }

    /**
     * @return int
     */
    public function GetId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function GetName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return void
     */
    public function SetName($name)
    {
        $this->name = $name;
    }

    /**
     * @param int $quantity
     */
    public function SetQuantityAvailable($quantity)
    {
        $q = intval($quantity);
        $this->quantityAvailable = empty($q) ? null : $q;
    }

    /**
     * @return int
     */
    public function GetQuantityAvailable()
    {
        return $this->quantityAvailable;
    }

    /**
     * @return int|null
     */
    public function GetResponsibleUserId()
    {
        return $this->responsibleUserId;
    }

    /**
     * @param int|null $userId
     */
    public function SetResponsibleUserId($userId)
    {
        $this->responsibleUserId = empty($userId) ? null : (int)$userId;
    }

    /**
     * @return ResourceAccessory[]
     */
    public function Resources()
    {
        return $this->resources;
    }

    /**
     * @return int[]
     */
    public function ResourceIds()
    {
        $ids = [];
        foreach ($this->resources as $resource) {
            $ids[] = $resource->ResourceId;
        }

        return $ids;
    }

    /**
     * @static
     * @param string $name
     * @param int $quantity
     * @param int|null $responsibleUserId
     * @return Accessory
     */
    public static function Create($name, $quantity, $responsibleUserId = null)
    {
        return new Accessory(null, $name, $quantity, $responsibleUserId);
    }

    /**
     * @return bool
     */
    public function HasUnlimitedQuantity()
    {
        return empty($this->quantityAvailable);
    }

    public function AddResource($resourceId, $minQuantity, $maxQuantity)
    {
        $this->resources[] = new ResourceAccessory($resourceId, $minQuantity, $maxQuantity);
    }

    /**
     * @param ResourceAccessory[] $resources
     */
    public function ChangeResources($resources)
    {
        $this->resources = $resources;
    }

    /**
     * @return bool
     */
    public function IsTiedToResource()
    {
        return count($this->resources) > 0;
    }

    /**
     * @param int $resourceId
     * @return ResourceAccessory
     */
    public function GetResource($resourceId)
    {
        foreach ($this->resources as $resource) {
            if ($resource->ResourceId == $resourceId) {
                return $resource;
            }
        }

        return null;
    }
}

class ResourceAccessory
{
    public $ResourceId;
    public $MinQuantity;
    public $MaxQuantity;

    public function __construct($resourceId, $minQuantity, $maxQuantity)
    {
        $this->ResourceId = $resourceId;
        $this->MinQuantity = empty($minQuantity) ? null : (int)$minQuantity;
        $this->MaxQuantity = empty($maxQuantity) ? null : (int)$maxQuantity;
        ;
    }
}
