<?php

use PHPUnit\Framework\TestCase;
require_once('PeopleImporter.php');

/**
 * Tests PeopleImporter class
 * Class PeopleImporterTest
 */
class PeopleImporterTest extends TestCase
{

    private $people = '{"data":[{"first_name":"jake","last_name":"bennett","age":31,"email":"jake@bennett.com","secret":"VXNlIHRoaXMgc2VjcmV0IHBocmFzZSBzb21ld2hlcmUgaW4geW91ciBjb2RlJ3MgY29tbWVudHM="},{"first_name":"jordon","last_name":"brill","age":85,"email": "jordon@brill.com","secret":"YWxidXF1ZXJxdWUuIHNub3JrZWwu"},]}';

    public function __construct() {
        parent::__construct();
    }

    public function test_people_importer_returns_csv_email_data(): void
    {
        $expectedEmailCSV = 'jake@bennett.com,jordon@brill.com';
        $pi = new PeopleImporter($this->people);

        $this->assertEquals(
            $expectedEmailCSV,
            $pi->emailAddresses()
        );
    }

    public function test_people_importer_returns_formatted_data(): void
    {
        $pi = new PeopleImporter($this->people);
        $data = $pi->getData();

        $this->assertEquals(2, sizeof($data));
        $this->assertTrue($data[0]->age > $data[1]->age);
        $this->assertEquals($data[0]->first_name.' '.$data[0]->last_name, $data[0]->name);
        $this->assertEquals($data[1]->first_name.' '.$data[1]->last_name, $data[1]->name);
    }
}