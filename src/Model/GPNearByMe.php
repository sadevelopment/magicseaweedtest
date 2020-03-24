<?php
namespace App\Model;

class GPNearByMe {

    private 
        $name,
        $rating,
        $total_ratings,
        $formatted_address,
        $open_now,
        $opening_hours;

    public function __construct($data) {
        $this->name = $data['name'];
        $this->rating = $data['rating'];
        $this->total_ratings = $data['user_ratings_total'];
        $this->formatted_address = $data['formatted_address'];
        $this->open_now = $data['opening_hours']['open_now']==1?"Open now":"Currently Closed";
        $this->opening_hours = $data['opening_hours'];
    }

    public function getName() { return $this->name; }
    public function getRating() { return $this->rating; }
    public function getTotalRatings() { return $this->total_ratings; }
    public function getFormattedAddress() { return $this->formatted_address; }
    public function getOpenNow() { return $this->open_now; }
    public function getOpeningHours() { return $this->opening_hours; }
}