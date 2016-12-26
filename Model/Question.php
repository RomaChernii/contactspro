<?php
namespace Smile\ContactsPro\Model;

use Smile\ContactsPro\Api\Data\QuestionInterface;
use Smile\ContactsPro\Model\ResourceModel\Question as ResourceQuestion;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Smile question model
 */
class Question extends AbstractModel implements QuestionInterface, IdentityInterface
{
    /**
     * Smile question cache tag
     */
    const CACHE_TAG = 'smile_question';

    /**#@+
     * Question's statuses
     */
    const STATUS_NEW = 1;
    const STATUS_ANSWERED = 2;

    /**#@-*/
    /**
     * @var string
     */
    protected $_cacheTag = 'smile_question';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'smile_question';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Smile\ContactsPro\Model\ResourceModel\Question');
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Retrieve question id
     *
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::QUESTION_ID);
    }

    /**
     * Retrieve question entity name
     *
     * @return string
     */
    public function getName()
    {
        return (string)$this->getData(self::NAME);
    }

    /**
     * Retrieve question entity email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * Retrieve question entity phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->getData(self::PHONE);
    }

    /**
     * Retrieve question content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * Retrieve question creation time
     *
     * @return string
     */
    public function getCreationTime()
    {
        return $this->getData(self::CREATION_TIME);
    }

    /**
     * Retrieve question update time
     *
     * @return string
     */
    public function getUpdateTime()
    {
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * Retrieve question status
     *
     * @return bool
     */
    public function getStatus()
    {
        return (bool)$this->getData(self::STATUS);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return QuestionInterface
     */
    public function setId($id)
    {
        return $this->setData(self::QUESTION_ID, $id);
    }

    /**
     * Set entity name
     *
     * @param string $name
     * @return QuestionInterface
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Set entity email
     *
     * @param string $email
     * @return QuestionInterface
     */
    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * Set entity phone
     *
     * @param string $phone
     * @return QuestionInterface
     */
    public function setPhone($phone)
    {
        return $this->setData(self::PHONE, $phone);
    }

    /**
     * Set content
     *
     * @param string $content
     * @return QuestionInterface
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return QuestionInterface
     */
    public function setCreationTime($creationTime)
    {
        return $this->setData(self::CREATION_TIME, $creationTime);
    }

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return QuestionInterface
     */
    public function setUpdateTime($updateTime)
    {
        return $this->setData(self::UPDATE_TIME, $updateTime);
    }

    /**
     * Set question status
     *
     * @param bool|int $status
     * @return BlockInterface
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Receive question store id
     *
     * @return int[]
     */
    public function getStores()
    {
        return $this->getData('store_id');
    }

    /**
     * Prepare question's statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_NEW => __('New'), self::STATUS_ANSWERED => __('Answered')];
    }
}
