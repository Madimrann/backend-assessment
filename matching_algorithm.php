<?php
/* TASK 2: Pet Service Matching Algorithm
Approach: 
I iterate through each user request and compare it against every service listing. 
For each pair, I perform a series of checks: service name, pet type compatibility, weight range compliance, distance within provider's limit, aggressive pet handling, and last-minute booking acceptance. 
Helper functions are used for distance calculation and weight range parsing to keep the main logic clean. 
If a listing passes all checks, it's added to the matches for that request.

Assumptions:
- 'coordinate' always contains 'lat' and 'lng' keys with valid numeric values.
- 'pet_weight' in requests is a string like "8kg".
- 'pet_weight' in listings is an array of strings like "1-5kg", "25kg+".
*/

function matchRequestsToListings($userRequests, $serviceListings) {
    $matches = [];

    foreach ($userRequests as $request) {
        $requestId = $request['request_id'];
        $matches[$requestId] = [];

        foreach ($serviceListings as $listing) {
            if (isValidMatch($request, $listing)) {
                $matches[$requestId][] = $listing['listing_id'];
            }
        }
    }

    return $matches;
}

function isValidMatch($request, $listing) {
    // 1. Service Type
    if ($request['service_name'] !== $listing['service_name']) {
        return false;
    }

    // 2. Pet Type
    if (!in_array($request['pet_type'], $listing['accepted_pet'])) {
        return false;
    }

    // 3. Pet Weight
    if (!isWeightAccepted($request['pet_weight'], $listing['pet_weight'])) {
        return false;
    }

    // 4. Distance
    $distance = calculateDistance(
        $request['coordinate']['lat'], 
        $request['coordinate']['lng'], 
        $listing['coordinate']['lat'], 
        $listing['coordinate']['lng']
    );
    if ($distance > $listing['distance_willing_to_travel']) {
        return false;
    }

    // 5. Aggressive Handling
    if (isset($request['pet_details']['is_aggressive']) && $request['pet_details']['is_aggressive']) {
        if (!$listing['profiling']['can_handle_aggressive']) {
            return false;
        }
    }

    // 6. Booking Type
    if (isset($request['pet_details']['booking_type']) && $request['pet_details']['booking_type'] === 'last_minute') {
        if (!$listing['profiling']['accept_last_minute_booking']) {
            return false;
        }
    }

    return true;
}

function isWeightAccepted($requestWeightStr, $listingWeightRanges) {
    // Parse request weight (e.g., "8kg" -> 8)
    $requestWeight = floatval(preg_replace('/[^0-9.]/', '', $requestWeightStr));

    foreach ($listingWeightRanges as $range) {
        if (strpos($range, '+') !== false) {
            // Case: "25kg+"
            $min = floatval(preg_replace('/[^0-9.]/', '', $range));
            if ($requestWeight >= $min) {
                return true;
            }
        } else {
            // Case: "1-5kg"
            $parts = explode('-', $range);
            if (count($parts) === 2) {
                $min = floatval(preg_replace('/[^0-9.]/', '', $parts[0]));
                $max = floatval(preg_replace('/[^0-9.]/', '', $parts[1]));
                if ($requestWeight >= $min && $requestWeight <= $max) {
                    return true;
                }
            }
        }
    }
    return false;
}

// Provided Distance Calculation Helper
function calculateDistance($lat1, $lng1, $lat2, $lng2) {
    $earthRadius = 6371; // km
    $dLat = deg2rad($lat2 - $lat1);
    $dLng = deg2rad($lng2 - $lng1);
    $a = sin($dLat/2) * sin($dLat/2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLng/2) * sin($dLng/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    return $earthRadius * $c;
}
?>
