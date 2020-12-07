<?php

class YEAR
{
    private $year;
    private $label;

    public function __construct($year, $label)
    {
        $this->year = $year;
        $this->label = $label;
    }

    public static function createYear($year, $label)
    {
        try {
            DB::$db->query("INSERT INTO YEARS VALUES(DEFAULT, $year, \"$label\")");
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function modifyYear($id_year, $year, $label)
    {
        try {
            DB::$db->query("UPDATE YEARS SET year= $year, label= \"$label\" WHERE id_year=$id_year");
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function deleteYear($id_year)
    {
        try {
            DB::$db->query("DELETE FROM YEARS WHERE id_year=$id_year");
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
