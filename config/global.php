<?php
return [
    'pagesize' => 10,

    'pagesizeList' => ['10', '15', '20', '30','50', '100'],

    'dataTablePagesize' => '10, 15, 20, 30, 50, 100',

    'arr_file_status' => [
        "2" => "Deposit Completed", 
        //"16" => "Deposit Completed - Final Payment by Credit Card", 
        "3" => "Paid in Full by Credit Card", 
        "9" => "In Progress", 
        "10" => "Quotation Sent - Waiting for Response", 
        "11" => "To Be Assigned", 
        "12" => "To Be Revised", 
        "15" => "Confirmed & Waiting for Credit Card", 
        "13" => "Confirmed",
        "58" => "All Services Booked",
        "8" => "Abandoned", 
        "14" => "Need to Follow Up", 
        "17" => "Information Request",
        "51" => "Need to follow up with a call",
        "52" => "Waiting on vendor",
        "53" => "No response from client",
        "54" => "Client canceled trip",
        "55" => "Emailed client for more information",
        //"56" => "Emailed client for more information",
        //"57" => "Response sent received email – need to follow up",    
    ],

    'arr_file_types' => ["1" => "FIT", "5" => "IVS", "6" => "DII", "2" => "Group", "7" => "Visits Italy", "9" => "Wine Tours Italia", "8" => "ILT", "3" => "Special Group", "4" => "Online", "10" => "Motivation", "11" => "Information Request", "12"=>"Transfers & Tours", "13"=>"FAM Trip", "14"=>"Summit Retreats", "15"=>"Honeymoon", "16"=>"Transfers", "17"=>"Zicasso"],

    'status_color' => [
        '2' => 'rowst2bg',
        '3' => 'rowst3bg',
        '9' => 'rowst4bg',
        '10' => 'rowst5bg',
        '11' => 'rowst6bg',
        '12' => 'rowst7bg',
        '13' => 'rowst8bg',
        '8' => 'rowst9bg',
        '14' => 'rowst10bg',
        '15' => 'rowst11bg',
        '58' => 'rowst13bg',
    ],

    'sortTypeArr' => ['' => 'Select Display By', "1" => "Display by Departure date", "3" => "Display by Arrival date", "2" => "Display by Recently added"],

    'cardTypeArr' => ['Visa'=>'Visa', 'Mastercard'=>'Mastercard', 'American Express'=>'American Express'],

    'ARR_SALUTATION' => ["Mr/Ms" => "Mr/Ms", "Mr" => "Mr", "Ms" => "Ms", "Mrs" => "Mrs", "Dr" => "Dr", "Rev" => "Rev", "Father" => "Father"],

    'loadingImg' => 'loading.gif',

    'arr_file_received_by' => ["1" => "Phone", "2" => "Email"],
    'arr_file_request' => ["1" => "Full Itinerary", "2" => "Services"],

    'currency_to_import' => ["EUR", "USD", "CAD", "GBP", "AUD"],
    'ARR_CURRENCY' => [
        'EUR' => 'EUR',
        'USD' => 'USD',
        'CAD' => 'CAD',
        'GBP' => 'GBP',
        'AUD' => 'AUD'
    ],
    'ARR_CURRENCY_SYMBOL' => [
        'EUR' => '&euro;',
        'USD' => '$',
        'CAD' => 'C$',
        'GBP' => '&pound;',
        'AUD' => 'A$'
    ],

    'arr_tour_classification' => ["1" => "Multi Day", "2" => "Sight Seeing", "3" => "Activity"],

    'ARR_SERVICE_TYPE' => ["1" => "Hotel", "9" => "Unit Rental", "2" => "Transfer", "3" => "Ferry", "4" => "Train", "5" => "Flight", "6" => "Car Rental", "7" => "Tours & Activites", "8" => "Misc"],
    
    'nfm' => 'Record(s) not available.',

    'arr_business_type' => ["1" => "Hotel", "5" => "Unit Rental", "3" => "DMC", "4" => "Booking Engine", "7" => "Business", "8" => "Wineries", "9" => "Enoteca - Wine Bars", "10" => "Restaurants", "11" => "Events", "12" => "Guides", "13" => "Transportation & Drivers", "14" => "Sea-side Resorts", "15" => "Spas and Thermal Baths", "16" => "Olive Oil Estates", "17" => "Agriturismo", "18" => "Boat"],

    'arr_business_type_code' => ["1" => "HTL", "5" => "UNR", "3" => "DMC", "4" => "BOE", "6" => "CRU", "7" => "BUS", "8" => "WIN", "9" => "ENO", "10" => "RES", "11" => "EVE", "12" => "GUI", "13" => "DAC", "14" => "SSR", "15" => "STB", "16" => "OOE", "17" => "FSA", "18" => "BOA"],

    'noOfAdutls' => array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '10+' => '10+'),

    'perPersonBudget' => array(
        'Per Person: €1,000 - €2,000 Euro'=>'Per Person: €1,000 - €2,000 Euro',
        'Per Person: €2,000 - €3,000 Euro'=>'Per Person: €2,000 - €3,000 Euro',
        'Per Person: €3,000 - €4,000 Euro'=>'Per Person: €3,000 - €4,000 Euro',
        'Per Person: €4,000 - €5,000 Euro'=>'Per Person: €4,000 - €5,000 Euro',
        'Per Person: €5,000 - €6,000 Euro'=>'Per Person: €5,000 - €6,000 Euro',
        'Per Person: €6,000 - €7,000 Euro'=>'Per Person: €6,000 - €7,000 Euro',
        'Per Person: €7,000 - €8,000 Euro'=>'Per Person: €7,000 - €8,000 Euro',
        'Per Person: €8,000 - €9,000 Euro'=>'Per Person: €8,000 - €9,000 Euro',
        'Per Person: €9,000 - €10,000 Euro'=>'Per Person: €9,000 - €10,000 Euro',
        'Per Person: Over €10,000 Euro'=>'Per Person: Over €10,000 Euro',
    ),

    'isBudgetFlexible' => array(
        '1'=>'The above is my maximum budget',
        '2'=>'Flexible: I can increase up to 20% if needed',
        '3'=>"Very flexible: Plan me the trip I want. Don't focus on specific budget"
    ),
    
    'stageInPlaning' => array(
        '1'=>"Still dreaming . . . not sure I'm going to take this trip",
        //'2'=>"I know I'm going somewhere, just not sure which country",
        '3'=>"I'm definitely going...let's go!"
    ),
    
    'agrGroupAdult' => array('18-30'=>'18-30', '31-50'=>'31-50', '51-64'=>'51-64', '65+'=>'65+'),
    'agrGroupChild' => array('0-2'=>'0-2', '3-7'=>'3-7', '8-12'=>'8-12', '13-17'=>'13-17'),
    
    'typeOfTravel' => array(
        '1'=>"Custom Trip Package:<br> <span>Be on your own schedule. Activities or day tours can be private or shared.</span> ",
        '2'=>"Scheduled Group Tour:<br> <span>Join a multi-day, guided group tour with fixed departure dates.</span> ",
        '3'=>"I would like my Travel Specialists to make suggestions based on my interests."
    ),
    
    'levelOfAccom' => array('5 Stars'=>'5 Stars', '4 Stars'=>'4 Stars', '3 Stars'=>'3 Stars', 'Private Villa (from Saturday to Saturday)'=>'Private Villa (from Saturday to Saturday)', 'Agriturismo/Wine Resort'=>'Agriturismo/Wine Resort'),
    
    'otherServicesNeeded' => array(
        '1'=>' Activities, Tour Guides, & Unique experiences',
        '2'=>' Transportation',
    ),

    'filetypehotels' => array(
        'Contract'=>'Contract',
    ), 
    
    'locImgPath' => 'uploaded_files/location/',
    'hotelImgPath' => 'uploaded_files/hotel/',

    'tourImgPath' => 'uploaded_files/tour/',

    'notDisplaySliderPageArr' => array('transportation', 'trip-planning'),
];