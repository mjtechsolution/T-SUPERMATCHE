<?php

function foreign_currency($fig, $currency_code)
{

    $figure = number_format($fig, 2, '.', '');

    $number = explode('.', $figure)[0];

    $decimal = (int)explode('.', $figure)[1];

    $sub_part = $decimal > 0 ? (" et " . ($decimal <= 19 ? handleXDigits($decimal) : handleTwoDigits($decimal)) . " Centimes " . getCurrencyCodeUnit($currency_code)['fraction']) : "";

    if ($number == 0) {
        $main_word = "Zero";
    } else if ($number <= 19 && $number >= 1) { //1-19
        $main_word = handleXDigits($number);
    } else if (strlen($number) == 2 || ($number < 100)) { //20-99
        $main_word = handleTwoDigits($number);
    } else if (strlen($number) == 3 || ($number < 1000)) {
        $main_word = handleHundreds($number);
    } else if (strlen($number) <= 6 || ($number < 1000000)) { //less than a million
        $main_word = handleThousands($number);
    } else if (strlen($number) <= 9 || ($number < 1000000000)) { //less than a billion
        $main_word = handleMillions($number);
    } else if (strlen($number) <= 12 || ($number < 1000000000000)) { //less than a trillion
        $main_word = handleBillions($number);
    } else {
        return "Number too large";
    }


    return $main_word . " Dirhams " . getCurrencyCodeUnit($currency_code)['main'] . $sub_part;
}



function getCurrencyCodeUnit($currency_code = ''): array
{
    $supported_currencies = [
        'AED' => ['main' => 'United Arab Emirates dirham', 'fraction' => 'Fils'],
        'AFN' => ['main' => 'Afghan afghani', 'fraction' => 'Pul'],
        'ANG' => ['main' => 'Netherlands Antillean guilder', 'fraction' => 'Cent'],
        'ARS' => ['main' => 'Argentine peso', 'fraction' => 'Centavo'],
        'AUD' => ['main' => 'Australian dollar', 'fraction' => 'Cent'],
        'BRL' => ['main' => 'real', 'fraction' => 'Centavo'],
        'CAD' => ['main' => 'Canadian dollar', 'fraction' => 'Cent'],
        'CHF' => ['main' => 'Swiss franc', 'fraction' => 'Rappen'],
        'CNY' => ['main' => 'yuan', 'fraction' => 'Fen'],
        'DKK' => ['main' => 'Danish krone', 'fraction' => 'Øre'],
        'DZD' => ['main' => 'Algerian dinar', 'fraction' => 'Santeem'],
        'EGP' => ['main' => 'Egyptian pound', 'fraction' => 'Piastre'],
        'EUR' => ['main' => 'Euro', 'fraction' => "Cent"],
        'GBP' => ['main' => 'Pound', 'fraction' => "Penny"],
        'GHC' => ['main' => "Ghana Cedi", 'fraction' => 'Pesewa'],
        'GHS' => ['main' => "Ghana Cedi", 'fraction' => 'Pesewa'],
        'HKD' => ['main' => 'Hong Kong dollar', 'fraction' => 'Cent'],
        'ILS' => ['main' => 'Israeli new shekel', 'fraction' => 'Agora'],
        'INR' => ['main' => 'Indian rupee', 'fraction' => 'Paisa'],
        'IQD' => ['main' => 'Iraqi dinar', 'fraction' => 'Fils'],
        'IRR' => ['main' => 'Iranian rial', 'fraction' => 'Dinar'],
        'JMD' => ['main' => 'Jamaican dollar', 'fraction' => 'Cent'],
        'JOD' => ['main' => 'Jordanian dinar', 'fraction' => 'Piastre'],
        'JPY' => ['main' => 'Japanese yen', 'fraction' => 'Sen'],
        'KES' => ['main' => 'Kenyan shilling', 'fraction' => 'Cent'],
        'KPW' => ['main' => 'North Korean won', 'fraction' => 'Chon'],
        'KRW' => ['main' => 'South Korean won', 'fraction' => 'Jeon'],
        'KWD' => ['main' => 'Kuwaiti dinar', 'fraction' => 'Fils'],
        'LYD' => ['main' => 'Libyan dinar', 'fraction' => 'Dirham'],
        'MXN' => ['main' => 'Mexican peso', 'fraction' => 'Centavo'],
        'MAD' => ['main' => 'Moroccan dirham', 'fraction' => 'Centime'],
        'MUR' => ['main' => 'Rupee', 'fraction' => "Cent"],
        'NGN' => ['main' => "Naira", 'fraction' => 'Kobo'],
        'NZD' => ['main' => 'New Zealand dollar', 'fraction' => 'Cent'],
        'PEN' => ['main' => 'Peruvian sol', 'fraction' => 'Céntimo'],
        'PHP' => ['main' => 'Philippine peso', 'fraction' => 'Sentimo'],
        'PYG' => ['main' => 'Paraguayan guaraní', 'fraction' => 'Céntimo'],
        'QAR' => ['main' => 'Qatari riyal', 'fraction' => 'Dirham'],
        'RON' => ['main' => 'Romanian leu', 'fraction' => 'Ban'],
        'RSD' => ['main' => 'Serbian dinar', 'fraction' => 'Para'],
        'RUB' => ['main' => 'Russian ruble', 'fraction' => 'Kopek'],
        'RWF' => ['main' => 'Rwandan franc', 'fraction' => 'Centime'],
        'SAR' => ['main' => 'Saudi riyal', 'fraction' => 'Halala'],
        'SDG' => ['main' => 'Sudanese pound', 'fraction' => 'Piastre'],
        'SEK' => ['main' => 'Swedish krona', 'fraction' => 'Öre'],
        'SGD' => ['main' => 'Singapore dollar', 'fraction' => 'Cent'],
        'SHP' => ['main' => 'Saint Helena pound', 'fraction' => 'Penny'],
        'SYP' => ['main' => 'Syrian pound', 'fraction' => 'Piastre'],
        'THB' => ['main' => 'Thai baht', 'fraction' => 'Satang'],
        'TND' => ['main' => 'Tunisian dinar', 'fraction' => 'Millime'],
        'TRY' => ['main' => 'Turkish lira', 'fraction' => 'Kuruş'],
        'TWD' => ['main' => 'New Taiwan dollar', 'fraction' => 'Cent'],
        'UGX' => ['main' => 'Ugandan shilling', 'fraction' => 'Cent'],
        'USD' => ['main' => "US Dollar", 'fraction' => "Cent"],
        'VES' => ['main' => 'Venezuelan bolívar soberano', 'fraction' => 'Céntimo'],
        'XAF' => ['main' => 'Central African CFA franc', 'fraction' => "Centime"],
        'XCD' => ['main' => 'Eastern Caribbean dollar', 'fraction' => 'Cent'],
        'XOF' => ['main' => 'West African CFA franc', 'fraction' => "Centime"],
        'XPF' => ['main' => 'CFP franc', 'fraction' => 'Centime'],
        'YER' => ['main' => 'Yemeni rial', 'fraction' => 'Fils'],
        'ZAR' => ['main' => 'South African rand', 'fraction' => 'Cent']
    ];


    return $supported_currencies[strtoupper($currency_code)] ?? ['main' => '', 'fraction' => ''];
}



function xml()
{
    return [
        'x' => [
            "0" => "", "00" => "",
            "1" => "Un", "01" => "Un",
            "2" => "Deux", "02" => "Deux",
            "3" => "Trois", "03" => "Trois",
            "4" => "Quatre", "04" => "Quatre",
            "5" => "Cinq", "05" => "Cinq",
            "6" => "Six", "06" => "Six",
            "7" => "Sept", "07" => "Sept",
            "8" => "Huit", "08" => "Huit",
            "9" => "Neuf", "09" => "Neuf",
            "10" => "Dix",
            "11" => "Onze",
            "12" => "Douze",
            "13" => "Treize",
            "14" => "
            Quatorze",
            "15" => "Quinze",
            "16" => "Seize",
            "17" => "Dix-Sept",
            "18" => "Dix-Huit",
            "19" => "Dix-Neuf"
        ],

        'm' => [
            "2" => "Vingt",
            "3" => "
            Trente",
            "4" => "
            Quarante",
            "5" => "
            Cinquante",
            "6" => "
            Soixante",
            "7" => "
            Soixante-Dix",
            "8" => "
            Quatre-Vingt",
            "9" => "
            Quatre-Vingt-Dix"
        ]
    ];
}



function handleXDigits($digits)
{ //1-19

    return xml()['x'][$digits];
}


function handleTwoDigits($digits)
{
    if ($digits <= 19) {
        return handleXDigits($digits);
    } else {
        $tens = intval($digits / 10);
        $units = $digits % 10;

      

        $tens_word = xml()['m'][$tens];
        if ($units == 1) {
            $tens_word .= ' et ';
        }
        // Handle special cases for numbers in the range 70-79 and 90-99
        if ($tens == 7 && $units > 0) {
            $tens_word = "Soixante-" . xml()['x'][10 + $units];
        } elseif ($tens == 9 && $units > 0) {
            $tens_word = "Quatre-Vingt-" . xml()['x'][10 + $units];
        } else {
            // Handle other tens (20-69 and 80-89)
            if ($tens > 1) {
                $tens_word .= ' ' . xml()['x'][$units];
            } else {
                $tens_word = xml()['x'][$units];
            }
        }

        return trim($tens_word);
    }
}


function handleHundreds($digits)
{

    $first_digit_word = handleXDigits(substr($digits, 0, 1));
    $other_two_digits_word = handleTwoDigits(substr($digits, 1));
    if ($first_digit_word == "Un") {
        $first_digit_word = "";
    }

    return (trim($first_digit_word) ? $first_digit_word . " Cent" : "Cent") . (trim($other_two_digits_word) ? " {$other_two_digits_word}" : "");
}



function handleThousands($digits)
{

    // $digits should be min 4 char and max 6 char in length
    $th = substr($digits, 0, -3); //get everything excluding the last three digits.

    $dred = substr($digits, -3); //get last three digits
    $dred_word = handleHundreds($dred);



    $th_word = strlen($th) == 3 ? handleHundreds($th) : (strlen($th) == 2 ? handleTwoDigits($th) : handleXDigits($th));


    if ($th_word == "Un") {
        $th_word = "";
    }
    return (trim($th_word) && trim($dred_word) ? $th_word . " Mille " : (trim($th_word) ? $th_word . " Mille " : " Mille ")) . (trim($dred_word) ? "{$dred_word}" : "");
}



function handleMillions($digits)
{

    // $digits should be min 7 char and max 9 char in length
    $th_word = handleThousands(substr($digits, -6)); //get the last six digits.

    $mill = substr($digits, 0, -6); //get everything excluding the last six digits.
    $mill_word = strlen($mill) == 3 ? handleHundreds($mill) : (strlen($mill) == 2 ? handleTwoDigits($mill) : handleXDigits($mill));


    if ($mill_word == "Un") {
        $mill_word = "";
    }
    return (trim($mill_word) && trim($th_word) ? $mill_word . " Million, " : (trim($mill_word) ? $mill_word . "  Million " : " Million ")) . (trim($th_word) ? "{$th_word}" : "");
}



function handleBillions($digits)
{

    // $digits should be min 10 char and max 12 char in length
    $mill_word = handleMillions(substr($digits, -9)); //get the last nine digits.

    $bill = substr($digits, 0, -9); //get everything excluding the last nine digits.
    $bill_word = strlen($bill) == 3 ? handleHundreds($bill) : (strlen($bill) == 2 ? handleTwoDigits($bill) : handleXDigits($bill));

    return (trim($bill_word) ? $bill_word . " Billion" : "") . (trim($mill_word) ? ", {$mill_word}" : "");
}
