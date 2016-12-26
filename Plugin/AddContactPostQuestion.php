<?php
namespace Smile\ContactsPro\Plugin;

use Magento\Contact\Controller\Index\Post as Subject;
use Magento\Framework\Json\EncoderInterface as Encoder;

class AddContactPostQuestion
{
    protected $_request;
    protected $_questionFactory;
    protected $_storeManager;

    public function __construct(
        \Magento\Framework\App\Request\Http $_request,
        \Smile\ContactsPro\Model\QuestionFactory $_questionFactory,
        \Magento\Store\Model\StoreManagerInterface $_storeManager
    ) {
        $this->_request = $_request;
        $this->_questionFactory = $_questionFactory;
        $this->_storeManager = $_storeManager;
    }

    public function beforeExecute(Subject $subject)
    {
        $post = $this->_request->getPostValue();
        if (!$post) {
            return;
        }
        try {
            $error = false;
            if (!\Zend_Validate::is(trim($post['name']), 'NotEmpty')) {
                $error = true;
            }
            if (!\Zend_Validate::is(trim($post['comment']), 'NotEmpty')) {
                $error = true;
            }
            if (!\Zend_Validate::is(trim($post['email']), 'EmailAddress')) {
                $error = true;
            }
            if (\Zend_Validate::is(trim($post['hideit']), 'NotEmpty')) {
                $error = true;
            }
            if (!$error) {
                $storeId = $this->_storeManager->getStore()->getStoreId();
                $question = $this->_questionFactory->create();
                $question->setData($post)
                    ->setPhone(trim($post['telephone']))
                    ->setContent(trim($post['comment']))
                    ->setStoreId($storeId)
                    ->save();
            }
        } catch (\Exception $e) {
            return;
        }
    }
}
