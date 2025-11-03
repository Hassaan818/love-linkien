<?php

namespace App\Services\Api\V1;

use App\Models\Venue;
use App\Services\Service;

class VenueService extends Service
{
    public function getVenues()
    {
        $venues = Venue::orderBy('created_at')->get();

        if ($venues) {
            $this->response['code'] = 2000;
            $this->response['data'] = [
                'venues' => $venues
            ];
            $this->response['message'] = 'Venues Found Successfully';
            return $this->response;
        }

        $this->response['code'] = 4004;
        $this->response['data'] = null;
        $this->response['message'] = 'No Venue Found';
    }
}
