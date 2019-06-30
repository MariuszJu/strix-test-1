<?php

namespace StrixTask\Model\Entity\Feature;

use StrixTask\Model\Helper\Inflector;

trait EntityExchange
{

    /**
     * @param array $data
     */
    public function exchangeArray(array $data)
    {
        $fields = get_object_vars($this);

        foreach ($fields as $fieldName => $fieldValue) {
            if ($fieldName != 'tableGateway') {
                $newFieldName = Inflector::to_underscore($fieldName);
            } else {
                $newFieldName = 'tableGateway';
            }

            if (isset($data[$newFieldName])) {
                $this->$fieldName = $data[$newFieldName];
            } else {
                $this->$fieldName = null;
            }
        }
    }

}
