<?php

namespace App\Http\Controllers\CodingPrinciples;

use App\Http\Controllers\Controller;

class SessionOneController extends Controller
{
    /**
     * Practising naming conventions.
     */
    public function namingConventions()
    {
        // reveal
        $numberOfDays =30;
        $maxDaysWithoutWater = 2;

        // meaningful
        createUserDir($dirName, $path);
        getCustomerInvoiceData();
        getCustomerData();

        // searchable
        MINIMUM_DAYS_LEAVE = 10;
        END_DATE_TIMESTAMP = now();

        // class nouns
        $systemUser = new SystemUser;
        $mediaPlayer = new Media;

        // function verbs
        getCustomer();
        getInvoices();
    }

    /**
     * Practising naming conventions.
     */
    public function namingIsTheGame()
    {
        // cute
        displayError();
        logPriority();
        sendBulkEmail();

        // one word
        getAPIResponse();
        getCustomerAddress();
        getWeatherAPIStatus();

        // context
        $companyName = 'Umbrella Corp';
        $secondName = 'Jane';

        // naming
        $testString = 'A String!';
        getLatestCustomerId();
    }

    /**
     * Practising naming conventions.
     */
    public function functionNaming()
    {
        // small + one thing + hidden
        function getInvoice()
        {
            // update invoice data <-- hidden
            [17 lines]

            // get invoice data
            [8 lines]

            // clean data <--extract
            [12]

            // create pdf <-- hidden
            [36 lines]

            // send e-mail <-- hidden
            [23 lines]
        }

        // dry
        function getClient()
        {
            // get client
            [5 lines]

            // update invoice data <-- repeated
            [17 lines]

            // get invoice data
            [8 lines]

            // clean data
            [12]

            // create pdf
            [36 lines]

            // send e-mail
            [23 lines]
        }
    }

    /**
     * Practising naming conventions.
     */
    public function comments()
    {
        // had to type out the whole alphabet because loops are scary <-- refactor and fix
        $al = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // intent
        clear_queue_now(); <-- why is this here

        // loop
        foreach($arr as $new) <-- explain why
        {
            // call
            clear_queue_now(); <-- explain why

            /*
            send_cool_email(); <-- explain why + add TODO
             */

            [112 lines]
        } // end-foreach
    }

    /**
     * Practising naming conventions.
     */
    public function formatting()
    {
        // vertical
        $numDays = 20;

        $id = createNewClient();

        // TODO: why is this compared to 0 [rd]?
        if($id != 0){
             // loop
            foreach($clients as $client){
                // check
                if($time == $initiatedAt){

                }
            }
        }

        // class - affinity
        init();
        startSesssion();
        getClient();
        getInvoice();
        createInvoice();
        createDir();
        getEmailAddresses();

        // team rules
        getAllClients();
        getAllCustomers();
    }
}
