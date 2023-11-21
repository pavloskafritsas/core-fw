<?php

namespace Pk\Core\Helpers;

class Report
{
        /**
         * @param  string
         * 
         * @return void
         */
        public static function addDtdToXmlFile(string $filename = '/xml/report.xml')
        {
                $dtd =
                        "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n" .
                        "<?xml-stylesheet type=\"text/xsl\" href=\"/xml/report.xsl\"?>\n" .
                        "<!DOCTYPE list [
        <!ELEMENT list (Doctor|VaccinationCenter|Appointments)*>
        <!ELEMENT Doctor (#PCDATA)>
        <!ATTLIST Doctor
                adt CDATA #REQUIRED
                email CDATA #IMPLIED
                first_name CDATA #REQUIRED
                last_name CDATA #REQUIRED>
        <!ELEMENT VaccinationCenter (#PCDATA)>
        <!ATTLIST VaccinationCenter
                address CDATA #REQUIRED
                phone CDATA #REQUIRED
                zip_code CDATA #REQUIRED>
        <!ELEMENT Appointments (Appointment)*>
        <!ELEMENT Appointment (Citizen)*>
        <!ATTLIST Appointment
                date CDATA #REQUIRED
                status CDATA #REQUIRED
                time CDATA #REQUIRED>
        <!ELEMENT Citizen (#PCDATA)>
        <!ATTLIST Citizen
                age CDATA #REQUIRED
                amka CDATA #REQUIRED
                first_name CDATA #REQUIRED
                last_name CDATA #REQUIRED>
        ]>\n";

                // Create the file handler
                $file = file($filename);

                $tmp = array_slice($file, 1);

                file_put_contents($filename, [...[$dtd], ...$tmp]);
        }
}
