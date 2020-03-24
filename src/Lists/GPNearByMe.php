<?php

namespace App\Lists;

/**
 * Google Place NearBy search results ListPresenter implementation
 */
class GPNearByMe extends ListPresenter {

    public function __construct($stdio = NULL) {
        parent::__construct($stdio);
    }

    /**
     * Display the results formatted with some coloring of the output.
     */
    public function displayResults($results) {
        foreach($results as $item) {
            $formattedOpeningTimes = "";
            // GP returns the weekly opening times as an array - need to add basic formatting
            // If we wanted to add something special would probably need to format ourselves 
            // using the period array instead
            foreach($item->getOpeningHours()['weekday_text'] as $weekday) {
                $formattedOpeningTimes .= "\t\t{$weekday}\n";
            }

            $this->writeResults(
                        "\n\tName: \e[1;33;40m{$item->getname()}\e[0m\n" .
                        "\tAddress: {$item->getFormattedAddress()}\n" .
                        "\tRating: {$item->getRating()} / {$item->getTotalRatings()}\n" .
                        "\tOpening Hours: \e[0;31;42m{$item->getOpenNow()}\e[0m\n\n{$formattedOpeningTimes}");
                         
        }
    }
}