<?php

namespace SSupport\Module\Referee\Resource\config\GridView;

use SSupport\Module\Core\Resource\config\GridView\AbstractGridViewSettings;
use SSupport\Module\Core\Resource\config\GridView\AgentGridViewSettingsInterface;
use SSupport\Module\Core\Resource\config\GridView\CustomerGridViewSettingsInterface;
use SSupport\Module\Core\Utils\ContainerAwareTrait;

class RefereeGridViewSettings extends AbstractGridViewSettings implements RefereeGridViewSettingsInterface
{
    use ContainerAwareTrait;

    /** @var AgentGridViewSettingsInterface */
    protected $agentSettings;
    /** @var CustomerGridViewSettingsInterface */
    protected $customerSettings;

    public function __construct($dataProvider, $searchModel, $urlCreator)
    {
        parent::__construct($dataProvider, $searchModel, $urlCreator);

        $this->agentSettings = $this->make(
            AgentGridViewSettingsInterface::class,
            [$dataProvider, $searchModel, $urlCreator]
        );
        $this->customerSettings = $this->make(
            CustomerGridViewSettingsInterface::class,
            [$dataProvider, $searchModel, $urlCreator]
        );
    }

    public function assign()
    {
        return $this->customerSettings->assign();
    }

    public function customer()
    {
        return $this->agentSettings->customer();
    }

    public function createdAt()
    {
        return $this->customerSettings->createdAt();
    }
}
