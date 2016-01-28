<?php

/*
 * Copyright 2016 Intacct Corporation.
 * 
 * Licensed under the Apache License, Version 2.0 (the "License"). You may not
 * use this file except in compliance with the License. You may obtain a copy 
 * of the License at
 * 
 * http://www.apache.org/licenses/LICENSE-2.0
 * 
 * or in the "LICENSE" file accompanying this file. This file is distributed on 
 * an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either 
 * express or implied. See the License for the specific language governing 
 * permissions and limitations under the License.
 */

namespace Intacct\Xml\Request\Operation\Content;

class StandardObjects
{

    /**
     * This is not an all encompassing list.  It is meant to catch a majority
     * of developer's doing silly things that should never have been allowed
     * in the v3.0 API of the product.
     *
     * @return array
     */
    public static function getMethodsNotAllowed($objectName)
    {
        $objects = [
            'ACTIVITYLOG' => [
                'create',
                'update',
                'delete',
            ],
            'APADJUSTMENTITEM' => [
                'create',
                'update',
                'delete',
            ],
            'APADVANCEITEM' => [
                'create',
                'update',
                'delete',
            ],
            'APBILLITEM' => [
                'create',
                'update',
                'delete',
            ],
            'APDETAIL' => [
                'create',
                'update',
                'delete',
            ],
            'APIUSAGEDETAIL' => [
                'create',
                'update',
                'delete',
            ],
            'APIUSAGESUMMARY' => [
                'create',
                'update',
                'delete',
            ],
            'APPAYMENTITEM' => [
                'create',
                'update',
                'delete',
            ],
            'APPYMTENTRY' => [
                'create',
                'update',
                'delete',
            ],
            'APRECORD' => [
                'create',
                'update',
                'delete',
            ],
            'ARADJUSTMENTITEM' => [
                'create',
                'update',
                'delete',
            ],
            'ARADVANCEITEM' => [
                'create',
                'update',
                'delete',
            ],
            'ARINVOICEITEM' => [
                'create',
                'update',
                'delete',
            ],
            'ARPAYMENTITEM' => [
                'create',
                'update',
                'delete',
            ],
            'ARRECORD' => [
                'create',
                'update',
                'delete',
            ],
            'ARDETAIL' => [
                'create',
                'update',
                'delete',
            ],
            'AUDUSERTRAIL' => [
                'create',
                'update',
                'delete',
            ],
            'BANKACCOUNT' => [
                'create',
                'update',
                'delete',
            ],
            'BANKFEEENTRY' => [
                'create',
                'update',
                'delete',
            ],
            'BILLABLEEXPENSES' => [
                'create',
                'update',
                'delete',
            ],
            'CHECKLAYOUT' => [
                'create',
                'update',
                'delete',
            ],
            'CCTRANSACTIONENTRY' => [
                'create',
                'update',
                'delete',
            ],
            'CHARGEPAYOFFENTRY' => [
                'create',
                'update',
                'delete',
            ],
            'CLOSEBOOKS' => [
                'create',
                'update',
                'delete',
            ],
            'CMDETAIL' => [
                'create',
                'update',
                'delete',
            ],
            'CMRECORD' => [
                'create',
                'update',
                'delete',
            ],
            'COMMENTS' => [
                'create',
                'update',
                'delete',
            ],
            'COMPANY' => [
                'create',
                'update',
                'delete',
            ],
            'COMPANYPREF' => [
                'create',
                'update',
                'delete',
            ],
            'CREDITCARDFEEENTRY' => [
                'create',
                'update',
                'delete',
            ],
            'CUSTAGING' => [
                'create',
                'update',
                'delete',
            ],
            'DEPOSITENTRY' => [
                'create',
                'update',
                'delete',
            ],
            'EXPENSEADJUSTMENTSITEM' => [
                'create',
                'update',
                'delete',
            ],
            'EXPENSESAPPROVAL' => [
                'create',
                'update',
                'delete',
            ],
            'EEDETAIL' => [
                'create',
                'update',
                'delete',
            ],
            'EERECORD' => [
                'create',
                'update',
                'delete',
            ],
            'EEXPENSESITEM' => [
                'create',
                'update',
                'delete',
            ],
            'EPPAYMENTITEM' => [
                'create',
                'update',
                'delete',
            ],
            'FINANCIALACCOUNT' => [
                'create',
                'update',
                'delete',
            ],
            'FUNDSTRANSFERENTRY' => [
                'create',
                'update',
                'delete',
            ],
            'GLACCOUNTBALANCE' => [
                'create',
                'update',
                'delete',
            ],
            'GLACCTGRPHIERARCHY' => [
                'create',
                'update',
                'delete',
            ],
            'GLDETAIL' => [
                'create',
                'update',
                'delete',
            ],
            'GLDOCDETAIL' => [
                'create',
                'update',
                'delete',
            ],
            'GLENTRY' => [
                'create',
                'update',
                'delete',
            ],
            'GLJOURNAL' => [
                'create',
                'update',
                'delete',
            ],
            'GLRESOLVE' => [
                'create',
                'update',
                'delete',
            ],
            'INVDOCUMENTENTRY' => [
                'create',
                'update',
                'delete',
            ],
            'INVDOCUMENTSUBTOTALS' => [
                'create',
                'update',
                'delete',
            ],
            'OPENBOOKS' => [
                'create',
                'update',
                'delete',
            ],
            'OTHERRECEIPTSENTRY' => [
                'create',
                'update',
                'delete',
            ],
            'PODOCUMENTAPPROVAL' => [
                'create',
                'update',
                'delete',
            ],
            'PODOCUMENTENTRY' => [
                'create',
                'update',
                'delete',
            ],
            'PODOCUMENTSUBTOTALS' => [
                'create',
                'update',
                'delete',
            ],
            'PROJECTTOTALS' => [
                'create',
                'update',
                'delete',
            ],
            'PRENTRY' => [
                'create',
                'update',
                'delete',
            ],
            'PRTAXENTRY' => [
                'create',
                'update',
                'delete',
            ],
            'PSADOCUMENTENTRY' => [
                'create',
                'update',
                'delete',
            ],
            'REVRECCHANGELOG' => [
                'create',
                'update',
                'delete',
            ],
            'SODOCUMENTENTRY' => [
                'create',
                'update',
                'delete',
            ],
            'SODOCUMENTSUBTOTALS' => [
                'create',
                'update',
                'delete',
            ],
            'STKITDOCUMENTENTRY' => [
                'create',
                'update',
                'delete',
            ],
            'TIMESHEETAPPROVAL' => [
                'create',
                'update',
                'delete',
            ],
            'TIMESHEETENTRY' => [
                'create',
                'update',
                'delete',
            ],
            'USERRIGHTS' => [
                'create',
                'update',
                'delete',
            ],
            'VENDAGING' => [
                'create',
                'update',
                'delete',
            ],
        ];

        $methods = [];
        if (isset($objects[$objectName])) {
            $methods = $objects[$objectName];
        }

        return $methods;
    }

}