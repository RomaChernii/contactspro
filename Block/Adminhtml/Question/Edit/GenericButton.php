<?php
namespace Smile\ContactsPro\Block\Adminhtml\Question\Edit;

use Magento\Backend\Block\Widget\Context;
use Smile\ContactsPro\Api\QuestionRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var QuestionRepositoryInterface
     */
    protected $questionRepository;

    /**
     * @param Context $context
     * @param QuestionRepositoryInterface $questionRepository
     */
    public function __construct(
        Context $context,
        QuestionRepositoryInterface $questionRepository
    ) {
        $this->context = $context;
        $this->questionRepository = $questionRepository;
    }

    /**
     * Return CMS block ID
     *
     * @return int|null
     */
    public function getQuestionId()
    {
        try {
            return $this->questionRepository->getById(
                $this->context->getRequest()->getParam('question_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
