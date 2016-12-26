<?php
namespace Smile\ContactsPro\Model\ResourceModel\Question\Relation\Store;

use Smile\ContactsPro\Model\ResourceModel\Question;
use Magento\Framework\EntityManager\Operation\ExtensionInterface;

/**
 * Class ReadHandler
 */
class ReadHandler implements ExtensionInterface
{
    /**
     * @var Question
     */
    protected $resourceQuestion;

    /**
     * @param Question $resourceBlock
     */
    public function __construct(
        Question $resourceQuestion
    ) {
        $this->resourceQuestion = $resourceQuestion;
    }

    /**
     * @param object $entity
     * @param array $arguments
     * @return object
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute($entity, $arguments = [])
    {
        if ($entity->getId()) {
            $stores = $this->resourceQuestion->lookupStoreIds((int)$entity->getId());
            $entity->setData('store_id', $stores);
            $entity->setData('stores', $stores);
        }
        return $entity;
    }
}
