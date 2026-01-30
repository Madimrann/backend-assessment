<?php
require_once 'matching_algorithm.php';

// Sample Data from Assessment
$userRequests = [
    [
        "request_id" => "REQ001",
        "user_id" => "USER_101",
        "service_name" => "dog_walking",
        "coordinate" => ["lat" => 3.1390, "lng" => 101.6869],
        "pet_type" => "dog",
        "pet_weight" => "8kg",
        "pet_details" => [
            "breed" => "Golden Retriever",
            "is_aggressive" => false,
            "special_notes" => "Friendly, loves treats",
            "booking_type" => "scheduled"
        ]
    ],
    [
        "request_id" => "REQ002",
        "user_id" => "USER_102",
        "service_name" => "pet_sitting",
        "coordinate" => ["lat" => 3.1520, "lng" => 101.7123],
        "pet_type" => "dog",
        "pet_weight" => "22kg",
        "pet_details" => [
            "breed" => "German Shepherd",
            "is_aggressive" => true,
            "special_notes" => "Needs experienced handler",
            "booking_type" => "last_minute"
        ]
    ]
];

$serviceListings = [
    [
        "listing_id" => "LIST001",
        "user_id" => "PROVIDER_201",
        "service_name" => "dog_walking",
        "accepted_pet" => ["dog", "cat"],
        "coordinate" => ["lat" => 3.1405, "lng" => 101.6895],
        "distance_willing_to_travel" => 3,
        "pet_weight" => ["1-5kg", "5-10kg"],
        "profiling" => [
            "can_handle_aggressive" => false,
            "accept_last_minute_booking" => true,
            "experience_years" => 2
        ]
    ],
    [
        "listing_id" => "LIST002",
        "user_id" => "PROVIDER_202",
        "service_name" => "pet_sitting",
        "accepted_pet" => ["dog", "cat", "rabbit"],
        "coordinate" => ["lat" => 3.1580, "lng" => 101.7150],
        "distance_willing_to_travel" => 5,
        "pet_weight" => ["10-15kg", "15-25kg", "25kg+"],
        "profiling" => [
            "can_handle_aggressive" => true,
            "accept_last_minute_booking" => false,
            "experience_years" => 5
        ]
    ],
    [
        "listing_id" => "LIST003",
        "user_id" => "PROVIDER_203",
        "service_name" => "dog_walking",
        "accepted_pet" => ["dog"],
        "coordinate" => ["lat" => 3.1500, "lng" => 101.7000],
        "distance_willing_to_travel" => 2,
        "pet_weight" => ["1-5kg", "5-10kg", "10-15kg"],
        "profiling" => [
            "can_handle_aggressive" => false,
            "accept_last_minute_booking" => true,
            "experience_years" => 1
        ]
    ],
    [
        "listing_id" => "LIST004",
        "user_id" => "PROVIDER_201",
        "service_name" => "pet_sitting",
        "accepted_pet" => ["dog", "cat"],
        "coordinate" => ["lat" => 3.1405, "lng" => 101.6895],
        "distance_willing_to_travel" => 3,
        "pet_weight" => ["1-5kg", "5-10kg"],
        "profiling" => [
            "can_handle_aggressive" => false,
            "accept_last_minute_booking" => false,
            "experience_years" => 2
        ]
    ],
    [
        "listing_id" => "LIST005",
        "user_id" => "PROVIDER_204",
        "service_name" => "pet_sitting",
        "accepted_pet" => ["dog", "cat"],
        "coordinate" => ["lat" => 3.1510, "lng" => 101.7100],
        "distance_willing_to_travel" => 4,
        "pet_weight" => ["15-25kg", "25kg+"],
        "profiling" => [
            "can_handle_aggressive" => true,
            "accept_last_minute_booking" => true,
            "experience_years" => 7
        ]
    ],
    [
        "listing_id" => "LIST006",
        "user_id" => "PROVIDER_205",
        "service_name" => "dog_walking",
        "accepted_pet" => ["dog"],
        "coordinate" => ["lat" => 3.1420, "lng" => 101.6900],
        "distance_willing_to_travel" => 5,
        "pet_weight" => ["5-10kg", "10-15kg"],
        "profiling" => [
            "can_handle_aggressive" => false,
            "accept_last_minute_booking" => true,
            "experience_years" => 3
        ]
    ]
];

echo "Running Matching Algorithm...\n";
$matches = matchRequestsToListings($userRequests, $serviceListings);

echo "Results:\n";
print_r($matches);

// Expected Logic Checks:
// REQ001 (Dog Walking, 8kg, Non-Aggressive, Scheduled)
// - LIST001: Correct Service, distance OK, weight 5-10kg ok. MATCH.
// - LIST006: Correct Service, distance OK, weight 5-10kg ok. MATCH.

// REQ002 (Pet Sitting, 22kg, Aggressive, Last Minute)
// - LIST002: Service OK, Weight OK (15-25kg), Aggressive OK, But Last Minute NO. (Reject)
// - LIST005: Service OK, Weight OK (15-25kg), Aggressive OK, Last Minute OK. MATCH.

echo "\nVerification:\n";
if (in_array("LIST001", $matches["REQ001"]) && in_array("LIST006", $matches["REQ001"])) {
    echo "REQ001 Matches: PASS\n";
} else {
    echo "REQ001 Matches: FAIL\n";
}

if (in_array("LIST005", $matches["REQ002"]) && !in_array("LIST002", $matches["REQ002"])) {
    echo "REQ002 Matches: PASS\n";
} else {
    echo "REQ002 Matches: FAIL\n";
}
?>