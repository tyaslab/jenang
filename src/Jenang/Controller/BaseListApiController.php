<?php

namespace Jenang\Controller\API;

class BaseListAPIController extends BaseAPIController {
    protected $limit = 20;
    protected $form_class;

    public function get() {
        $result = $this->paginate($this->getQueryList());

        return $this->response->withJson($result);
    }

    protected function getObjectId($object) {
        return $object->id;
    }

    public function post() {
        $form_class = $this->getFormClass();
        $form = new $form_class($this->request->getParsedBody());

        if ($form->isValid()) {
            $object = $form->save();

            return $this->response
                ->withHeader('Content-Type', 'application/json')
                ->withHeader('Id', $this->getObjectId($object))
                ->withStatus(201);
        } else {
            return $this->response->withJson($form->errors, 400);
        }
    }

    protected function getFormClass() {
        $form_class = $this->form_class;

        if (!$form_class) throw new \Exception("form_class is required.");

        return $form_class;
    }

    protected function getLimit() {
        $limit = $this->request->getQueryParams("limit");
        if (!$limit) $limit = $this->limit;

        return $limit;
    }

    protected function getCurrentPage() {
        $current_page = $this->request->getQueryParams("page");
        if (!$current_page) $current_page = 1;

        return $current_page;
    }

    protected function paginate($query_list) {
        $count = $query_list->count();
        $current_page = $this->getCurrentPage();
        $limit = $this->getLimit();


        $total_page = ceil($count / $limit);

        if ($total_page == 0) $total_page = 1;

        $next = $current_page < $total_page;
        $previous = $current_page > $total_page;

        $result_list = [];
        foreach($query_list->get() as $result_item) {
            array_push($result_list, $this->dehydrate($result_item));
        }

        $result = [
            'count' => $count,
            'items_per_page' => $limit,
            'current_page' => $current_page,
            'total_page' => $total_page,
            'next' => $next,
            'previous' => $previous,
            'results' => $result_list
        ];

        return $result;
    }

    protected function dehydrate($data) {
        return $data;
    }

    protected function getQueryList() {
        throw new \Exception("getQueryList method not implemented");
    }
}
