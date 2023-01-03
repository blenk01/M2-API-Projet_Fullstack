<?php

namespace App\DataFixtures;

use App\Entity\Sale;
use DateTime;
use DirectoryIterator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{   
    private const SEPARATOR = "|";
    private const INDEX_DATE_MUTATION = 8;
    private const INDEX_NATURE_MUTATION = 9;
    private const INDEX_VALEUR_FONCIERE = 10;
    private const INDEX_CODE_DEPARTEMENT = 18;
    private const INDEX_CODE_TYPE_LOCAL = 35;
    private const INDEX_SURFACE_REELLE_BATI = 38;

    private const VALUE_MUTATION = "vente";
    private const TYPES_LOCAL_ACCEPTED = [1, 2];

    /**
     * keys is index in header of files and values are lowercase title
     */
    private const EXPECTED_HEADER = [
        self::INDEX_DATE_MUTATION => "date mutation",
        self::INDEX_NATURE_MUTATION => "nature mutation",
        self::INDEX_VALEUR_FONCIERE => "valeur fonciere",
        self::INDEX_CODE_DEPARTEMENT => "code departement",
        self::INDEX_CODE_TYPE_LOCAL => "code type local",
        self::INDEX_SURFACE_REELLE_BATI => "surface reelle bati",
    ];

    public function load(ObjectManager $manager): void
    {        
        $path = sprintf('%s/data', dirname(__FILE__));
        foreach (new DirectoryIterator($path) as $fileInfo) {
            if($fileInfo->isDot()) continue;
            if ( $fileInfo->getFilename() === ".DS_Store" ) continue;

            $file = fopen($fileInfo->getPathname(), 'r');

            if ( feof($file) ) { 
                echo sprintf("Empty file found -> %s... skipping\n", $fileInfo->getFilename());
                continue; 
            }

            echo $fileInfo->getFilename() . "\n";

            $lineTitles = fgets($file);
            $foundTitles = explode(self::SEPARATOR, $lineTitles);
            
            $expectedIndexes = array_keys(self::EXPECTED_HEADER);
            foreach($expectedIndexes as $index) {
                $title = trim(strtolower($foundTitles[$index]));
                $expectedTitle = self::EXPECTED_HEADER[$index];
                if ( $title !== $expectedTitle ) {
                    echo sprintf("%s is not equal to %s\nInvalid header in file -> %s... skipping\n",
                        $title, $expectedTitle, $fileInfo->getFilename());
                    continue;
                }
            }

            $i = 0;
            while(!feof($file)) {
                $i++;
                $line = fgets($file);
                $data = explode(self::SEPARATOR, $line);
                if ( $line && count($data) >= count(self::EXPECTED_HEADER) ) {                    
                    $mutation = trim(strtolower($data[self::INDEX_NATURE_MUTATION]));
                    $typeLocal = $data[self::INDEX_CODE_TYPE_LOCAL];
    
                    if ( $mutation === self::VALUE_MUTATION && in_array($typeLocal, self::TYPES_LOCAL_ACCEPTED) ) {
                        $date = trim($data[self::INDEX_DATE_MUTATION]);
                        $soldAt = DateTime::createFromFormat('d/m/Y', $date);
                        $codeDepartement = $data[self::INDEX_CODE_DEPARTEMENT];
                        $surfaceB = trim($data[self::INDEX_SURFACE_REELLE_BATI]);
                        $value = trim(str_replace(',', '.', str_replace('.', '', $data[self::INDEX_VALEUR_FONCIERE])));
                        
                        if ( isset($soldAt) && isset($codeDepartement) && isset($value) && !empty($value) && isset($surfaceB) && !empty($surfaceB) ) {
                            $sale = new Sale();
                            $sale->setSoldAt($soldAt);
                            $sale->setCodeDepartement($codeDepartement);
                            $sale->setValue($value);
                            $sale->setSurface($surfaceB);
    
                            $manager->persist($sale);
                        }
                    }
                }
    
                if ( $i % 1000 === 0 ) {
                    $manager->flush();
                    $manager->clear();
                }   
            }

            $manager->flush();
            $manager->clear();
            fclose($file);
        }
            
    }
}
