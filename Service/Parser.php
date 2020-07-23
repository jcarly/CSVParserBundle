<?php

namespace App\CSVParserBundle\Service;

class Parser {

    public function parseCSV($path)
    {
        $rows = array();
        if (($handle = fopen($path, "r")) !== FALSE)
        {
            while (($data = fgetcsv($handle, null, ";")) !== FALSE)
            {
                $row = array();
                foreach ($data as $key => $value)
                {
                    if(count($rows) && isset($rows[0][$key]))
                    {
                        $row[$rows[0][$key]] = $this->parseValue($rows[0][$key], $value);
                    }
                    else {
                        $row[$key] = $value;
                    }
                }
                $rows[] = $row;
            }
        }
        return $rows;
    }

    private function parseValue($key, $value)
    {
        switch($key)
        {
            case "created_at" :
                $value = date("l, d-M-Y H:i:s e", strtotime($value));
                break;
            case "price" :
                $value = number_format ( $value, 2, "," , " ");
                break;
            case "is_enabled" :
                $value = $value ? "Enabled" : "Disabled";
                break;
            case 'description':
                $value = (new \Html2Text\Html2Text(str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),"<br/>", $value)))->getText();
                break;
            default:
                break;
        }
        return $value;
    }
}
