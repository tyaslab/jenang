<?php

namespace Jenang\Controller\API;

class BaseDetailAPIController extends BaseAPIController {
    protected $form_class;
    protected $allowed_methods = ['GET', 'PUT', 'DELETE'];

    protected function getFormClass() {
        $form_class = $this->form_class;

        if (!$form_class) throw new \Exception("form_class is required.");

        return $form_class;
    }

    protected function permissionObject($object) {

    }

    protected function get() {
        $object = $this->getObject();

        if ($object == null) $this->immediateResponse(404);
        $this->permissionObject($object);

        $result = $this->dehydrate($object);

        return $this->response->withJson($result);
    }

    public function put() {
        $object = $this->getObject();
        $form_class = $this->getFormClass();
        if ($object == null) $this->immediateResponse(404);
        $this->permissionObject($object);

        $form = new $form_class($this->request->getParsedBody(), $object);

        if ($form->isValid()) {
            $object = $form->save();

            $this->immediateResponse(204);
        } else {
            return $this->response->withJson($form->errors, 400);
        }
    }

    public function delete() {
        $object = $this->getObject();
        if ($object == null) $this->immediateResponse(404);
        $this->permissionObject($object);

        $object->delete();
        $this->immediateResponse(204);
    }

    protected function getObject() {
        throw new \Exception("getObject method not implemented");
    }
}