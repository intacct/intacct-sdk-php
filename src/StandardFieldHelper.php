<?php
/**
 * Copyright 2016 Intacct Corporation.
 *
 *  Licensed under the Apache License, Version 2.0 (the "License"). You may not
 *  use this file except in compliance with the License. You may obtain a copy
 *  of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * or in the "LICENSE" file accompanying this file. This file is distributed on
 * an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 *
 */

namespace Intacct;

use Intacct\Xml\ParameterListException;

class StandardFieldHelper
{
    /**
     * @param array $params
     * @param array $standard_fields_list
     * @throws ParameterListException
     */
    public function verifyStandardFieldParameters(array $params, array $standard_fields_list)
    {
        if (array_key_exists('standard_fields', $params))
        {
            foreach ($params['standard_fields'] as $standard_field_key => $standard_field_value) {
                if (in_array($standard_field_key, $standard_fields_list) === false) {
                    throw new ParameterListException('Invalid standard_field given: ' . $standard_field_key, $params);
                }
            }
        }
    }
}