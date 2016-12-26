<?php
namespace Smile\ContactsPro\Api;

interface QuestionRepositoryInterface
{
    public function save(Data\QuestionInterface $question);

    public function getById($questionId);

    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    public function delete(Data\QuestionInterface $question);

    public function deleteById($questionId);
}
