<?php

namespace App\Lists;

class GPNearByMe extends ListPresenter {

    public function __construct($stdio) {
        parent::__construct($stdio);
    }

    public function displayResults($results) {
        foreach($results as $item) {
            $formattedOpeningTimes = "";
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