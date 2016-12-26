<?php
namespace Smile\ContactsPro\Model;

use Smile\ContactsPro\Api\Data;
use Smile\ContactsPro\Api\QuestionRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Smile\ContactsPro\Model\ResourceModel\Question as ResourceQuestion;
use Smile\ContactsPro\Model\ResourceModel\Question\CollectionFactory as QuestionCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class QuestionRepository
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class QuestionRepository implements QuestionRepositoryInterface
{
    /**
     * @var ResourceQuestion
     */
    protected $resource;

    /**
     * @var ResourceQuestionFactory
     */
    protected $questionFactory;

    /**
     * @var QuestionCollectionFactory
     */
    protected $questionCollectionFactory;

    /**
     * @var Data\QuestionSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var \Smile\ContactsPro\Api\Data\QuestionInterfaceFactory
     */
    protected $dataQuestionFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        ResourceQuestion $resource,
        QuestionFactory $questionFactory,
        \Smile\ContactsPro\Api\Data\QuestionInterfaceFactory $dataQuestionFactory,
        QuestionCollectionFactory $questionCollectionFactory,
        Data\QuestionSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->questionFactory = $questionFactory;
        $this->questionCollectionFactory = $questionCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataQuestionFactory = $dataQuestionFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * Save Question data
     *
     * @param \Smile\ContactsPro\Api\Data\QuestionInterface $question
     * @return Question
     * @throws CouldNotSaveException
     */
    public function save(Data\QuestionInterface $question)
    {
        $storeId = $this->storeManager->getStore()->getId();
        $question->setStoreId($storeId);
        try {
            $this->resource->save($question);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $question;
    }

    /**
     * Load Question data by given Question Identity
     *
     * @param string $questionId
     * @return Question
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($questionId)
    {
        $question = $this->questionFactory->create();
        $this->resource->load($question, $questionId);
        if (!$question->getId()) {
            throw new NoSuchEntityException(__('Question with id "%1" does not exist.', $questionId));
        }
        return $question;
    }

    /**
     * Load Question data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Smile\ContactsPro\Model\ResourceModel\Question\Collection
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $collection = $this->questionCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $questions = [];
        /** @var Question $questionModel */
        foreach ($collection as $questionModel) {
            $questionData = $this->dataQuestionFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $questionData,
                $questionModel->getData(),
                'Smile\ContactsPro\Api\Data\QuestionInterface'
            );
            $questions[] = $this->dataObjectProcessor->buildOutputDataArray(
                $questionData,
                'Smile\ContactsPro\Api\Data\QuestionInterface'
            );
        }
        $searchResults->setItems($questions);
        return $searchResults;
    }

    /**
     * Delete Question
     *
     * @param \Smile\ContactsPro\Api\Data\QuestionInterface $question
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(Data\QuestionInterface $question)
    {
        try {
            $this->resource->delete($question);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Delete Question by given Question Identity
     *
     * @param string $questionId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($questionId)
    {
        return $this->delete($this->getById($questionId));
    }
}
