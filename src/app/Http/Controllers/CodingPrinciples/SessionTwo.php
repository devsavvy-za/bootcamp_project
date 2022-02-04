<?php

namespace App\Http\Controllers\CodingPrinciples;

use App\Http\Controllers\Controller;

class SessionTwoController extends Controller
{
    /**
     * Chained commands
     */
    public function chainedCommands()
    {
        // helper
        $userInvoiceFileUploadPath = $user->invoices()->where('id', $invoiceId)->get()->first()->storage()->getUploadPath();

        // database
        $customer_hierarchy_item->customer_job_roles()->active()->activeDateRange()->whereHas('customer_job_role_audit_types', function ($query) use ($audit_type_id) {
            $query->where('audit_type_id', $audit_type_id)->where('receive_audit_report', 1);
        })->where('customer_job_role.customer_site_id', null)->get();
    }

    /**
     * Catch errors.
     */
    public function catchErrors()
    {
        // init guzzle
        $client = new Client();

        // merge
        $params = array_merge([
            'allow_redirects' => true,
            'timeout' => 2000,
            'http_errors' => false,
            'exceptions' => false,
        ], $params);

        // set
        $url = self::$url.ltrim($api_method, '/');

        // call
        $response = $client->request($type, $url, $params);

        // try/catch
        try {
            // set
            $status_code = $response->getStatusCode();

            // check
            if($status_code == 200){
                // set
                $status_code = $response->getStatusCode();
                $body = $response->getBody();

                // set
                self::$response_code = (int) $status_code;
                self::$response = (string) $body;
            }else{
                // set
                $status_code = $response->getStatusCode();
                $body = $response->getBody();

                // set
                self::$status = 0;
                self::$response_code = (int) $status_code;
                self::$response = (string) $body;
                self::$response = str_replace(["\n", "\r"], '', self::$response);
                self::$error_msg_arr[] = 'Could not complete the request, Status Code: '.$status_code;
            }
        } catch (RequestException $e) {
            // check
            if ($e->hasResponse()){
                // set
                $response = $e->getResponse();
                $status_code = $response->getStatusCode();
                $body = $response->getBody();

                // set
                self::$status = 0;
                self::$response_code = (int) $status_code;
                self::$response = (string) $body;
                self::$response = str_replace(["\n", "\r"], '', self::$response);
                self::$error_msg_arr[] = 'Could not complete the request, Status Code: '.$status_code;
            }else{
                // set
                self::$status = 0;
                self::$response_code = 404;
                self::$error_msg_arr[] = 'Request exception with no response.';
            }
        } catch (\Exception $e) {
            // set
            self::$status = 0;
            self::$response_code = 500;
            self::$error_msg_arr[] = $e->getMessage();
        }
    }

    /**
     * Boundaries.
     */
    public function boundaries()
    {
        // try/catch
        try {
            // init
            $pdf_wrapper = resolve(\Barryvdh\Snappy\PdfWrapper::class);

            // load
            $pdf = $pdf_wrapper->loadView($load_pdf_view, $view_data);

            // set
            $pdf->setOptions([
                'disable-smart-shrinking' => true,
                'footer-right' => 'Page: [page] of [topage]',
                'footer-font-size' => 8,
            ]);

            // save
            $pdf->save($uploads_dir.'/'.$filename, true);
        } catch (\Exception $e) {
            // set
            Log::critical($e->getMessage());
        }
    }

    /**
     * Practising naming conventions.
     */
    public function unitTests()
    {

    }
    /**
     * Practising naming conventions.
     */
    public function classes()
    {

    }
    /**
     * Practising naming conventions.
     */
    public function FunctionsYo()
    {

    }
}
