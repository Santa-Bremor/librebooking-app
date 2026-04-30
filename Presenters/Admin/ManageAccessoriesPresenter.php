<?php

require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');

class ManageAccessoriesActions
{
    public const Add = 'addAccessory';
    public const Change = 'changeAccessory';
    public const Delete = 'deleteAccessory';
    public const ChangeAccessoryResource = 'changeAccessoryResource';
}

class ManageAccessoriesPresenter extends ActionPresenter
{
    /**
     * @var IManageAccessoriesPage
     */
    private $page;

    /**
     * @var IAccessoryRepository
     */
    private $accessoryRepository;

    /**
     * @var IResourceRepository
     */
    private $resourceRepository;

    /**
     * @var IUserRepository
     */
    private $userRepository;

    /**
     * @param IManageAccessoriesPage $page
     * @param IResourceRepository $resourceRepository
     * @param IAccessoryRepository $accessoryRepository
     * @param IUserRepository $userRepository
     */
    public function __construct(
        IManageAccessoriesPage $page,
        IResourceRepository $resourceRepository,
        IAccessoryRepository $accessoryRepository,
        IUserRepository $userRepository
    )
    {
        parent::__construct($page);

        $this->page = $page;
        $this->resourceRepository = $resourceRepository;
        $this->accessoryRepository = $accessoryRepository;
        $this->userRepository = $userRepository;

        $this->AddAction(ManageAccessoriesActions::Add, 'AddAccessory');
        $this->AddAction(ManageAccessoriesActions::Change, 'ChangeAccessory');
        $this->AddAction(ManageAccessoriesActions::Delete, 'DeleteAccessory');
        $this->AddAction(ManageAccessoriesActions::ChangeAccessoryResource, 'ChangeAccessoryResources');
    }

    public function PageLoad()
    {
        $accessories = $this->resourceRepository->GetAccessoryList($this->page->GetSortField(), $this->page->GetSortDirection());
        $resources = $this->resourceRepository->GetResourceList();
        $users = $this->userRepository->GetAll();

        $this->page->BindAccessories($accessories);
        $this->page->BindResources($resources);
        $this->page->BindUsers($users);
    }

    public function AddAccessory()
    {
        $name = $this->page->GetAccessoryName();
        $quantity = $this->page->GetQuantityAvailable();
        $responsibleUserId = $this->page->GetResponsibleUserId();

        Log::Debug('Adding new accessory with name %s and quantity %s, responsible user %s', $name, $quantity, $responsibleUserId);

        $this->accessoryRepository->Add(Accessory::Create($name, $quantity, $responsibleUserId));
    }

    public function ChangeAccessory()
    {
        $id = $this->page->GetAccessoryId();
        $name = $this->page->GetAccessoryName();
        $quantity = $this->page->GetQuantityAvailable();
        $responsibleUserId = $this->page->GetResponsibleUserId();

        Log::Debug('Changing accessory with id %s to name %s and quantity %s, responsible user %s', $id, $name, $quantity, $responsibleUserId);

        $accessory = $this->accessoryRepository->LoadById($id);
        $accessory->SetName($name);
        $accessory->SetQuantityAvailable($quantity);
        $accessory->SetResponsibleUserId($responsibleUserId);

        $this->accessoryRepository->Update($accessory);
    }

    public function DeleteAccessory()
    {
        $id = $this->page->GetAccessoryId();

        Log::Debug('Deleting accessory with id %s', $id);

        $this->accessoryRepository->Delete($id);
    }

    public function ProcessDataRequest($dataRequest)
    {
        $accessory = $this->accessoryRepository->LoadById($this->page->GetAccessoryId());
        $this->page->SetAccessoryResources($accessory->Resources());
    }

    public function ChangeAccessoryResources()
    {
        $accessoryResources = [];
        $resources = $this->page->GetAccessoryResources();
        $min = $this->page->GetAccessoryResourcesMinimums();
        $max = $this->page->GetAccessoryResourcesMaximums();

        foreach ($resources as $resourceId) {
            $accessoryResources[] = new ResourceAccessory($resourceId, $min[$resourceId], $max[$resourceId]);
        }

        $accessory = $this->accessoryRepository->LoadById($this->page->GetAccessoryId());
        $accessory->ChangeResources($accessoryResources);
        $this->accessoryRepository->Update($accessory);
    }
}
