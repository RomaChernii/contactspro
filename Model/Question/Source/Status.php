<?php
namespace Smile\ContactsPro\Model\Question\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Question Status
 */
class Status implements OptionSourceInterface
{
    /**
     * @var \Smile\ContactsPro\Model\Question
     */
    protected $question;

    /**
     * Constructor
     *
     * @param \Smile\ContactsPro\Model\Question $question
     */
    public function __construct(\Smile\ContactsPro\Model\Question $question)
    {
        $this->question = $question;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->question->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
