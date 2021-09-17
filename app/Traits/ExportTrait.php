<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\StreamedResponse;

trait ExportTrait
{

    /**
     * @param $data
     * @param $name
     * @return StreamedResponse
     */
    public function someArrayExport($data, $name)
    {

        $filename = $name . '.csv';

        $this->setHeader = false;

        $response = new StreamedResponse(function ()  use( $data ){

            $handle = fopen('php://output', 'w');
            fputs($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

                foreach ($data as $k => $values) {

                    $rows = [];

                    foreach($values as $value) {
                        $rows[] = $value;
                    }

                    fputcsv($handle, $rows);
                }

            fclose($handle);

        }, 200, [
            'Content-Type' => 'text/csv',
            'charset'   => 'UTF-8',
            'Content-Disposition' => 'attachment; filename=' . $filename,
        ]);

        return $response;
    }

    /**
     * @param $exportData
     * @param string $fileName
     * @param string $methodName
     * @return StreamedResponse
     */
    public function baseExport($exportData, $fileName = 'products', $methodName = 'toExport')
    {

        $date = str_replace(' ', '-', now()->toDateTimeString());
        $filename = $fileName . '-' . $date . '.csv';

        $this->setHeader = false;

        $response = new StreamedResponse(function ()  use( $exportData, $methodName ){

            $handle = fopen('php://output', 'w');
            fputs($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            foreach($exportData->chunk(1000) as $chunk) {
                foreach ($chunk as $k => $model) {
                    if (!$this->setHeader) {
                        $headers = [];

                        if (method_exists($model, 'toExport')) {

                            $data = $model->{$methodName}();

                            if (array_key_exists('array', $data)) {
                                foreach ($data['array'][0] as $key => $value) {
                                    $headers[] = $key;
                                }
                            } else {
                                foreach ($model->{$methodName}() as $key => $value) {
                                    $headers[] = $key;
                                }
                            }

                        }

                        fputcsv($handle, $headers);
                        $this->setHeader = true;
                    }

                    if (method_exists($model, 'toExport')) {

                        $data = $model->{$methodName}();

                        if (array_key_exists('array', $data)) {
                            foreach($data['array'] as $array) {
                                fputcsv($handle, $array);
                            }
                        } else {
                            fputcsv($handle, $data);
                        }

                    }

                }
            }

            fclose($handle);

        }, 200, [
            'Content-Type' => 'text/csv',
            'charset'   => 'UTF-8',
            'Content-Disposition' => 'attachment; filename=' . $filename,
        ]);

        return $response;
    }

}
