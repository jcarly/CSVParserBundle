<?php

namespace App\CSVParserBundle\Service;

class Helper {
    public function reformateArray($rows)
    {
        foreach ($rows as $key => $row) {
            if($key > 0)
            {
                $rows[$key]["price"] = $row["price"] . $row["currency"];
                unset($rows[$key]["currency"]);
                $rows[$key]["slug"] = preg_replace('/[^A-Za-z0-9\-]/', '-', str_replace(" ", "_", strtolower($row["title"])));
            }
            else{
                foreach ($row as $id => $value)
                {
                    switch($value)
                    {
                        case "is_enabled" :
                            $rows[$key][$id] = "Status";
                            break;
                        case "currency" :
                            unset($rows[$key][$id]);
                            break;
                        default:
                            $rows[$key][$id] = ucwords(str_replace("_", " ", $value));
                            break;
                    }
                }
                $rows[$key][] = "Slug";
            }
        }
        return $rows;
    }
}
