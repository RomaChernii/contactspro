<?php
namespace Smile\ContactsPro\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface QuestionSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get questions list.
     *
     * @return \Smile\ContactsPro\Api\Data\QuestionInterface[]
     */
    public function getItems();

    /**
     * Set questions list.
     *
     * @param \Smile\ContactsPro\Api\Data\QuestionInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
