<?php
namespace Vhit\StockManagement\Setup;

use \Magento\Framework\Setup\InstallDataInterface;
use \Magento\Framework\Setup\ModuleDataSetupInterface;
use \Magento\Framework\Setup\ModuleContextInterface;
use \Magento\Authorization\Model\Acl\Role\Group as RoleGroup;
use \Magento\Authorization\Model\UserContextInterface;
use \Magento\Authorization\Model\RoleFactory;
use \Magento\Authorization\Model\RulesFactory;

class InstallData implements InstallDataInterface
{
    /**
     * RoleFactory
     *
     * @var roleFactory
     */
    private $roleFactory;

    /**
     * RulesFactory
     *
     * @var rulesFactory
     */
    private $rulesFactory;

    /**
     * Init
     *
     * @param RoleFactory $roleFactory
     * @param RulesFactory $rulesFactory
     */
    public function __construct(
        RoleFactory $roleFactory,
        RulesFactory $rulesFactory
    ) {
        $this->roleFactory = $roleFactory;
        $this->rulesFactory = $rulesFactory;
    }

    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $role = $this->roleFactory->create();
        $role->setName('Stock Manager')
            ->setPid(0)
            ->setRoleType(RoleGroup::ROLE_TYPE)
            ->setUserType(UserContextInterface::USER_TYPE_ADMIN);
        $role->save();

        $resource = [
            'Magento_Backend::admin',
            'Magento_Catalog::catalog',
            'Magento_Catalog::catalog_inventory',
            'Magento_Catalog::products',
            'Magento_Catalog::edit_product_design',
            'Magento_Catalog::categories',
            'Magento_Catalog::edit_category_design',
            'Magento_Reports::report',
            'Vhit_StockManagement::Report_StockManagement',
            'Vhit_StockManagement::Report_Pending'
        ];
        $this->rulesFactory->create()
            ->setRoleId($role->getId())
            ->setResources($resource)
            ->saveRel();
    }
}