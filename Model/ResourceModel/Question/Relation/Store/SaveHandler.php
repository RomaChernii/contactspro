<?php
namespace Smile\ContactsPro\Model\ResourceModel\Question\Relation\Store;

use Magento\Framework\EntityManager\Operation\ExtensionInterface;
use Smile\ContactsPro\Api\Data\QuestionInterface;
use Smile\ContactsPro\Model\ResourceModel\Question;
use Magento\Framework\EntityManager\MetadataPool;

/**
 * Class SaveHandler
 */
class SaveHandler implements ExtensionInterface
{
    /**
     * @var MetadataPool
     */
    protected $metadataPool;

    /**
     * @var Question
     */
    protected $resourceQuestion;

    /**
     * @param MetadataPool $metadataPool
     * @param Question $resourceQuestion
     */
    public function __construct(
        MetadataPool $metadataPool,
        Question $resourceQuestion
    ) {
        $this->metadataPool = $metadataPool;
        $this->resourceQuestion = $resourceQuestion;
    }

    /**
     * @param object $entity
     * @param array $arguments
     * @return object
     * @throws \Exception
     */
    public function execute($entity, $arguments = [])
    {
        $entityMetadata = $this->metadataPool->getMetadata(QuestionInterface::class);
        $linkField = $entityMetadata->getLinkField();

        $connection = $entityMetadata->getEntityConnection();

        $oldStores = $this->resourceQuestion->lookupStoreIds((int)$entity->getId());
        $newStores = (array)$entity->getStores();

        $table = $this->resourceQuestion->getTable('smile_question_store');

        $delete = array_diff($oldStores, $newStores);
        if ($delete) {
            $where = [
                $linkField . ' = ?' => (int)$entity->getData($linkField),
                'store_id IN (?)' => $delete,
            ];
            $connection->delete($table, $where);
        }

        $insert = array_diff($newStores, $oldStores);
        if ($insert) {
            $data = [];
            foreach ($insert as $storeId) {
                $data[] = [
                    $linkField => (int)$entity->getData($linkField),
                    'store_id' => (int)$storeId,
                ];
            }
            $connection->insertMultiple($table, $data);
        }

        return $entity;
    }
}
