<?php

/**
 * Instructions:
 *
 * Given the above JSON, build a simple PHP script to import it.
 *
 * Your script should create two variables:
 *
 * - a comma-separated list of email addresses
 * - the original data, sorted by age descending, with a new field on each record
 *   called "name" which is the first and last name joined.
 *
 * Please deliver your code in either a GitHub Gist or some other sort of web-hosted code snippet platform.
 */
class PeopleImporter{

    private $people;

    public function __construct($people){
        $this->import($people);
    }

    /**
     * Imports, decodes the data and stores it in $people field
     * @param $people
     */
    private function import($people){
        $people = $this->removeTrailingCommas($people);
        $this->people = json_decode($people);
    }

    /**
     * Returns CSV emails
     * @return string
     */
    public function emailAddresses(){
        $emails = [];
        foreach($this->people->data as $p){
            $emails[] = $p->email;
        }
        return implode(',', $emails);
    }

    /**
     * Original data array sorted by age field and expanded with name field
     * @return array
     */
    public function getData(){
        $data = $this->people->data;
        usort($data, [$this, 'sortByAge']);
        $data = array_map([$this, 'addNameField'], $data);
        return $data;
    }

    /**
     * Sorts an array by the age field, descending
     * @param $a
     * @param $b
     * @return mixed
     */
    private function sortByAge($a, $b) {
        return  $b->age - $a->age;
    }

    /**
     * Adds a name field in an array from the first name and last name
     * @param $item
     * @return mixed
     */
    private function addNameField($item){
        $item->name = $item->first_name . ' ' . $item->last_name;
        return $item;
    }

    /**
     * Removes trailing comma in the JSON code to make it valid for
     * json_decode function
     * @param $json
     * @return mixed
     */
    private function removeTrailingCommas($json)
    {
        return preg_replace('/,\s*([\]}])/m', '$1', $json);
    }
}