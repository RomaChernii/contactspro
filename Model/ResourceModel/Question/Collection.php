<?php
namespace Smile\ContactsPro\Model\ResourceModel\Question;

use Smile\ContactsPro\Api\Data\QuestionInterface;
use Magento\Cms\Model\ResourceModel\AbstractCollection;

/**
 * ContactsPro Question Collection
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'question_id';

    /**
     * Perform operations after collection load
     *
     * @return $this
     */
    protected function _afterLoad()
    {
        $entityMetadata = $this->metadataPool->getMetadata(QuestionInterface::class);

        $this->performAfterLoad('smile_question_store', $entityMetadata->getLinkField());

        return parent::_afterLoad();
    }

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Smile\ContactsPro\Model\Question', 'Smile\ContactsPro\Model\ResourceModel\Question');
        $this->_map['fields']['store'] = 'store_table.store_id';
    }

    /**
     * Add filter by store
     *
     * @param int|array|\Magento\Store\Model\Store $store
     * @param bool $withAdmin
     * @return $this
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        $this->performAddStoreFilter($store, $withAdmin);

        return $this;
    }

    /**
     * Join store relation table if there is store filter
     *
     * @return void
     */
    protected function _renderFiltersBefore()
    {
        $entityMetadata = $this->metadataPool->getMetadata(QuestionInterface::class);
        $this->joinStoreRelationTable('smile_question_store', $entityMetadata->getLinkField());
    }
}
