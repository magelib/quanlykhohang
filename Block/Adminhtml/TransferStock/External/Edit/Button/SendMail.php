<?php


namespace Magestore\InventorySuccess\Block\Adminhtml\TransferStock\External\Edit\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magestore\InventorySuccess\Model\TransferStock;
use Magestore\InventorySuccess\Api\Data\TransferStock\TransferPermission;

/**
 * Class SaveButton
 */
class SendMail extends \Magestore\InventorySuccess\Block\Adminhtml\TransferStock\AbstractTransferStock
                 implements ButtonProviderInterface
{
    /**
     * Save button
     *
     * @return array
     */
    public function getButtonData()
    {
        if ($this->getRequest()->getParam('id')) {
            $transferStock = $this->_transferStockFactory->create()->load($this->getRequest()->getParam('id'));
            if(($transferStock->getStatus() == TransferStock::STATUS_PENDING)
                && $this->_permissionManagement->checkPermission(TransferPermission::EXTERNAL_TRANSFER_STOCK_EDIT_GENERAL)){
                    return [
                        'label' => __('Send Email'),
                        'class' => 'save primary',
                        'on_click' => '',
                        'data_attribute' => [
                            'mage-init' => [
                                'buttonAdapter' => [
                                    'actions' => [
                                        [
                                            'targetName' => 'os_transferstock_external_form.os_transferstock_external_form',
                                            'actionName' => 'save',
                                            'params' => [
                                                true,
                                                [
                                                    'id' => $this->getRequest()->getParam('id'),
                                                    'action' => 'send_email'
                                                ],
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        'sort_order' => 30,
                    ];
            }
        }
        return [];
    }
}
