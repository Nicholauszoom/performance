<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CountryCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('country_codes')->insert([
           [
            'id' => 1,
            'item_code' =>"1",
            'item_value' =>"AD",
            'description'=>"ANDORRA"
           ],
           [
            'id' => 2,
            'item_code' =>"2",
            'item_value' =>"AE",
            'description'=>"UNITED ARAB EMIRATES"
           ],
           [
            'id'=> 3,
            'item_code' =>"3",
            'item_value' =>"AF",
            'description'=>"AFGHANISTAN",
           ],
           [
             'id'=> 4,
            'item_code' =>"4",
            'item_value'=>"AG",
            'description' =>"ANTIGUA AND BARBUDA"
           ],
           [
            'id'=> 5,
           'item_code'=>"5",
           'item_value'=>"AI",
           'description'=>"ANGUILLA"
           ],
           [
            'id'=> 6,
            'item_code'=>"6",
            'item_value'=>"AL",
            'description'=>"ALBANIA"
           ],
           [
            'id'=> 7,
            'item_code'=>"7",
            'item_value'=>"AM",
            'description'=>"ARMENIA"
           ],
        [
            'id'=> 8,
            'item_code'=>"8",
            'item_value'=>"AN",
            'description'=>"NETHERLANDS ANTILLES"
        ],
        [
            'id'=> 9,
            'item_code'=>"9",
            'item_value'=>"AO",
            'description'=>"AN`GOLA"
        ],
        [
            'id'=> 10,
            'item_code'=>"10",
            'item_value'=>"AQ",
            'description'=>"ANTARCTICA"
        ],
        [
            'id'=> 11,
            'item_code'=>"11",
            'item_value'=>"AR",
            'description'=>"ARGENTINA"
        ],
        [
            'id'=> 12,
            'item_code'=>"12",
            'item_value'=>"AS",
            'description'=>"AMERICAN SAMOA"
        ],
        [
            'id'=> 13,
            'item_code'=>"13",
            'item_value'=>"AT",
            'description'=>"AUSTRIA"
        ],
        [
            'id'=> 14,
            'item_code'=>"14",
            'item_value'=>"AU",
            'description'=>"AUSTRALIA"
        ],
        [
            'id'=> 15,
            'item_code'=>"15",
            'item_value'=>"AW",
            'description'=>"ARUBA"
        ],
        [
            'id'=> 16,
            'item_code'=>"16",
            'item_value'=>"AZ",
            'description'=>"AZERBAIJAN"
        ],
        [
            'id'=> 17,
            'item_code'=>"17",
            'item_value'=>"BA",
            'description'=>"BOSNIA AND HERZEGOVINA"
        ],
        [
            'id'=> 18,
                'item_code'=>"18",
                'item_value'=>"BB",
                'description'=>"BARBADOS"],
        [
                    'id'=> 19,
                    'item_code'=>"19",
                    'item_value'=>"BD",
                    'description'=>"BANGLADESH"
                ],
                [
                         'id'=> 20,
                         'item_code'=>"20",
                         'item_value'=>"BE",
                         'description'=>"BELGIUM"
                        ],
                         [
                              'id'=> 21,
                              'item_code'=>"21",
                              'item_value'=>"BF",
                              'description'=>"BURKINA FASO"
                            ],
                            [
                                  'id'=> 22,
                                  'item_code'=>"22",
                                  'item_value'=>"BG",'description'=>"BULGARIA"
                                ],
                         [
                            'id'=> 23,
                            'item_code'=>"23",
                            'item_value'=>"BH",
                            'description'=>"BAHRAIN"
                        ],
                            [
                                  'id'=> 24,
                                  'item_code'=>"24",
                                  'item_value'=>"BI",'description'=>"BURUNDI"
                                  ],
                                  [
                                  'id'=> 25,
                                  'item_code'=>"25",
                                  'item_value'=>"BJ",'description'=>"BENIN"
                                ],
                                [
                                 'id'=> 26,
                                'item_code'=>"26",
                                'item_value'=>"BM",'description'=>"BERMUDA"
                            ],
                            [
                                'id'=> 27,
                                'item_code'=>"27",
                                'item_value'=>"BN",'description'=>"BRUNEI DARUSSALAM"
                            ],
                             [
                                'id'=>28,
                                 'item_code'=>"28",
                                 'item_value'=>"BO",'description'=>"BOLIVIA"
                                ],
                                  [
                                    'id'=>29,
                                     'item_code'=>"29",'item_value'=>"BR",'description'=>"BRAZIL"
                                    ],
                                  [
                                    'id'=>30,
                                     'item_code'=>"30",'item_value'=>"BS",'description'=>"BAHAMAS"
                                    ],
                                  [
                                    'id'=>31,
                                     'item_code'=>"31",'item_value'=>"BT",'description'=>"BHUTAN"
                                    ],
                                  [
                                    'id'=>32,
                                     'item_code'=>"32",'item_value'=>"BV",'description'=>"BOUVET ISLAND"
                                    ],
                                  [
                                    'id'=>33,
                                    'item_code'=>"33",
                                    'item_value'=>"BW",'description'=>"BOTSWANA"
                                ],
                                  [
                                    'id'=>34,
                                    'item_code'=>"34",
                                    'item_value'=>"BY",'description'=>"BELARUS"
                                ],
                                  [
                                    'id'=>35,
                                    'item_code'=>"35",
                                    'item_value'=>"BZ",'description'=>"BELIZE"
                                ],
                                  [
                                    'id'=>36,
                                     'item_code'=>"36",'item_value'=>"CA",'description'=>"CANADA"
                                    ],
                                  [
                                    'id'=>37,
                                    'item_code'=>"37",
                                    'item_value'=>"CC",'description'=>"COCOS (KEELING) ISLANDS"],
                                  [
                                    'id'=>38,
                                     'item_code'=>"38",'item_value'=>"CD",'description'=>"CONGO, THE DEMOCRATIC REPUBLIC OF THE"
                                    ],
                                  [
                                    'id'=>39,
                                     'item_code'=>"39",'item_value'=>"CF",'description'=>"CENTRAL AFRICAN REPUBLIC"
                                    ],
                                  [
                                    'id'=>40,
                                     'item_code'=>"40",'item_value'=>"CG",'description'=>"CONGO"
                                    ],
                                  [
                                    'id'=>41,
                                     'item_code'=>"41",'item_value'=>"CI",'description'=>"CÔTE D'IVOIRE"
                                    ],
                                  [
                                    'id'=>42,
                                     'item_code'=>"42",'item_value'=>"CK",'description'=>"COOK ISLANDS"
                                    ],
                                  [
                                    'id'=>43, 'item_code'=>"43",'item_value'=>"CL",'description'=>"CHILE"],
                                  ['id'=>44, 'item_code'=>"44",'item_value'=>"CM",'description'=>"CAMEROON"],
                                  ['id'=>45, 'item_code'=>"45",'item_value'=>"CN",'description'=>"CHINA"],  ['id'=>46, 'item_code'=>"46",'item_value'=>"CO",'description'=>"COLOMBIA"],
                                  ['id'=>47, 'item_code'=>"47",'item_value'=>"CR",'description'=>"COSTA RICA"],
                                  ['id'=>48, 'item_code'=>"48",'item_value'=>"CU",'description'=>"CUBA"],
                                  ['id'=>49, 'item_code'=>"49",'item_value'=>"CV",'description'=>"CAPE VERDE"],
                                  ['id'=>50, 'item_code'=>"50",'item_value'=>"CX",'description'=>"CHRISTMAS ISLAND"],
                                  ['id'=>51, 'item_code'=>"51",'item_value'=>"CY",'description'=>"CYPRUS"],
                                  ['id'=>52, 'item_code'=>"52",'item_value'=>"CZ",'description'=>"CZECH REPUBLIC"],
                                  ['id'=>53, 'item_code'=>"53",'item_value'=>"DE",'description'=>"GERMANY"],
                                  ['id'=>54, 'item_code'=>"54",'item_value'=>"DJ",'description'=>"DJIBOUTI"],
                                  ['id'=>55, 'item_code'=>"55",'item_value'=>"DK",'description'=>"DENMARK"],
                                  ['id'=>56, 'item_code'=>"56",'item_value'=>"DM",'description'=>"DOMINICA"],
                                  ['id'=>57, 'item_code'=>"57",'item_value'=>"DO",'description'=>"DOMINICAN REPUBLIC"],
                                  ['id'=>58, 'item_code'=>"58",'item_value'=>"DZ",'description'=>"ALGERIA"],
                                  ['id'=>59, 'item_code'=>"59",'item_value'=>"EC",'description'=>"ECUADOR"],
                                  ['id'=>60, 'item_code'=>"60",'item_value'=>"EE",'description'=>"ESTONIA"],
                                  ['id'=>61, 'item_code'=>"61",'item_value'=>"EG",'description'=>"EGYPT"],['id'=>62,'item_code'=>"62",'item_value'=>"EH",'description'=>"WESTERN SAHARA"],['id'=>63,'item_code'=>"63",'item_value'=>"ER",'description'=>"ERITREA"],['id'=>64,'item_code'=>"64",'item_value'=>"ES",'description'=>"SPAIN"],['id'=>65,'item_code'=>"65",'item_value'=>"ET",'description'=>"ETHIOPIA"],['id'=>66,'item_code'=>"66",'item_value'=>"FI",'description'=>"FINLAND"],['id'=>67,'item_code'=>"67",'item_value'=>"FJ",'description'=>"FIJI"],['id'=>68,'item_code'=>"68",'item_value'=>"FK",'description'=>"FALKLAND ISLANDS (MALVINAS)"],['id'=>69,'item_code'=>"69",'item_value'=>"FM",'description'=>"MICRONESIA, FEDERATED STATES OF"],['id'=>70,'item_code'=>"70",'item_value'=>"FO",'description'=>"FAROE ISLANDS"],['id'=>71,'item_code'=>"71",'item_value'=>"FR",'description'=>"FRANCE"],['id'=>72,'item_code'=>"72",'item_value'=>"GA",'description'=>"GABON"],['id'=>73,'item_code'=>"73",'item_value'=>"GB",'description'=>"UNITED KINGDOM"],['id'=>74,'item_code'=>"74",'item_value'=>"GD",'description'=>"GRENADA"],['id'=>75,'item_code'=>"75",'item_value'=>"GE",'description'=>"GEORGIA"],['id'=>76,'item_code'=>"76",'item_value'=>"GF",'description'=>"FRENCH GUIANA"],['id'=>77,'item_code'=>"77",'item_value'=>"GH",'description'=>"GHANA"],['id'=>78,'item_code'=>"78",'item_value'=>"GI",'description'=>"GIBRALTAR"],['id'=>79,'item_code'=>"79",'item_value'=>"GL",'description'=>"GREENLAND"],['id'=>80,'item_code'=>"80",'item_value'=>"GM",'description'=>"GAMBIA"],['id'=>81,'item_code'=>"81",'item_value'=>"GN",'description'=>"GUINEA"],['id'=>82,'item_code'=>"82",'item_value'=>"GP",'description'=>"GUADELOUPE"],['id'=>83,'item_code'=>"83",'item_value'=>"GQ",'description'=>"EQUATORIAL GUINEA"],['id'=>84,'item_code'=>"84",'item_value'=>"GR",'description'=>"GREECE"],['id'=>85,'item_code'=>"85",'item_value'=>"GS",'description'=>"SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS"],['id'=>86,'item_code'=>"86",'item_value'=>"GT",'description'=>"GUATEMALA"],['id'=>87,'item_code'=>"87",'item_value'=>"GU",'description'=>"GUAM"],['id'=>88,'item_code'=>"88",'item_value'=>"GW",'description'=>"GUINEA-BISSAU"],['id'=>89,'item_code'=>"89",'item_value'=>"GY",'description'=>"GUYANA"],['id'=>90,'item_code'=>"90",'item_value'=>"HK",'description'=>"HONG KONG"],['id'=>91,'item_code'=>"91",'item_value'=>"HM",'description'=>"HEARD ISLAND AND MCDONALD ISLANDS"],['id'=>92,'item_code'=>"92",'item_value'=>"HN",'description'=>"HONDURAS"],['id'=>93,'item_code'=>"93",'item_value'=>"HR",'description'=>"CROATIA"],['id'=>94,'item_code'=>"94",'item_value'=>"HT",'description'=>"HAITI"],['id'=>95,'item_code'=>"95",'item_value'=>"HU",'description'=>"HUNGARY"],['id'=>96,'item_code'=>"96",'item_value'=>"CH",'description'=>"SWITZERLAND"],['id'=>97,'item_code'=>"97",'item_value'=>"ID",'description'=>"INDONESIA"],['id'=>98,'item_code'=>"98",'item_value'=>"IE",'description'=>"IRELAND"],['id'=>99,'item_code'=>"99",'item_value'=>"IL",'description'=>"ISRAEL"],['id'=>100,'item_code'=>"100",'item_value'=>"IN",'description'=>"INDIA"],['id'=>101,'item_code'=>"101",'item_value'=>"IO",'description'=>"BRITISH INDIAN OCEAN TERRITORY"],['id'=>102,'item_code'=>"102",'item_value'=>"IQ",'description'=>"IRAQ"],['id'=>103,'item_code'=>"103",'item_value'=>"IR",'description'=>"IRAN, ISLAMIC REPUBLIC OF"],['id'=>104,'item_code'=>"104",'item_value'=>"IS",'description'=>"ICELAND"],['id'=>105,'item_code'=>"105",'item_value'=>"IT",'description'=>"ITALY"],['id'=>106,'item_code'=>"106",'item_value'=>"JM",'description'=>"JAMAICA"],['id'=>107,'item_code'=>"107",'item_value'=>"JO",'description'=>"JORDAN"],['id'=>108,'item_code'=>"108",'item_value'=>"JP",'description'=>"JAPAN"],['id'=>109,'item_code'=>"109",'item_value'=>"KE",'description'=>"KENYA"],['id'=>110,'item_code'=>"110",'item_value'=>"KG",'description'=>"KYRGYZSTAN"],['id'=>111,'item_code'=>"111",'item_value'=>"KH",'description'=>"CAMBODIA"],['id'=>112,'item_code'=>"112",'item_value'=>"KI",'description'=>"KIRIBATI"],['id'=>113,'item_code'=>"113",'item_value'=>"KM",'description'=>"COMOROS"],['id'=>114,'item_code'=>"114",'item_value'=>"KN",'description'=>"SAINT KITTS AND NEVIS"],['id'=>115,'item_code'=>"115",'item_value'=>"KP",'description'=>"KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF"],['id'=>116,'item_code'=>"116",'item_value'=>"KR",'description'=>"KOREA, REPUBLIC OF"],['id'=>117,'item_code'=>"117",'item_value'=>"KW",'description'=>"KUWAIT"],['id'=>118,'item_code'=>"118",'item_value'=>"KY",'description'=>"CAYMAN ISLANDS"],['id'=>119,'item_code'=>"119",'item_value'=>"KZ",'description'=>"KAZAKSTAN"],['id'=>120,'item_code'=>"120",'item_value'=>"LA",'description'=>"LAOS, PEOPLE'S DEMOCRATIC REPUBLIC OF"],['id'=>121,'item_code'=>"121",'item_value'=>"LB",'description'=>"LEBANON"],['id'=>122,'item_code'=>"122",'item_value'=>"LC",'description'=>"SAINT LUCIA"],['id'=>123,'item_code'=>"123",'item_value'=>"LI",'description'=>"LIECHTENSTEIN"],['id'=>124,'item_code'=>"124",'item_value'=>"LK",'description'=>"SRI LANKA"],['id'=>125,'item_code'=>"125",'item_value'=>"LR",'description'=>"LIBERIA"],['id'=>126,'item_code'=>"126",'item_value'=>"LS",'description'=>"LESOTHO"],['id'=>127,'item_code'=>"127",'item_value'=>"LT",'description'=>"LITHUANIA"],['id'=>128,'item_code'=>"128",'item_value'=>"LU",'description'=>"LUXEMBOURG"],['id'=>129,'item_code'=>"129",'item_value'=>"LV",'description'=>"LATVIA"],['id'=>130,'item_code'=>"130",'item_value'=>"LY",'description'=>"LIBYAN ARAB JAMAHIRIYA"],['id'=>131,'item_code'=>"131",'item_value'=>"MA",'description'=>"MOROCCO"],['id'=>132,'item_code'=>"132",'item_value'=>"MC",'description'=>"MONACO"],['id'=>133,'item_code'=>"133",'item_value'=>"MD",'description'=>"MOLDOVA, REPUBLIC OF"],['id'=>134,'item_code'=>"134",'item_value'=>"MG",'description'=>"MADAGASCAR"],['id'=>135,'item_code'=>"135",'item_value'=>"MH",'description'=>"MARSHALL ISLANDS"],['id'=>136,'item_code'=>"136",'item_value'=>"MK",'description'=>"MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF"],['id'=>137,'item_code'=>"137",'item_value'=>"ML",'description'=>"MALI"],['id'=>138,'item_code'=>"138",'item_value'=>"MM",'description'=>"MYANMAR"],['id'=>139,'item_code'=>"139",'item_value'=>"MN",'description'=>"MONGOLIA"],['id'=>140,'item_code'=>"140",'item_value'=>"MO",'description'=>"MACAU"],['id'=>141,'item_code'=>"141",'item_value'=>"MP",'description'=>"NORTHERN MARIANA ISLANDS"],['id'=>142,'item_code'=>"142",'item_value'=>"MQ",'description'=>"MARTINIQUE"],['id'=>143,'item_code'=>"143",'item_value'=>"MR",'description'=>"MAURITANIA"],['id'=>144,'item_code'=>"144",'item_value'=>"MS",'description'=>"MONTSERRAT"],['id'=>145,'item_code'=>"145",'item_value'=>"MT",'description'=>"MALTA"],['id'=>146,'item_code'=>"146",'item_value'=>"MU",'description'=>"MAURITIUS"],['id'=>147,'item_code'=>"147",'item_value'=>"MV",'description'=>"MALDIVES"],['id'=>148,'item_code'=>"148",'item_value'=>"MW",'description'=>"MALAWI"],['id'=>149,'item_code'=>"149",'item_value'=>"MX",'description'=>"MEXICO"],['id'=>150,'item_code'=>"150",'item_value'=>"MY",'description'=>"MALAYSIA"],['id'=>151,'item_code'=>"151",'item_value'=>"MZ",'description'=>"MOZAMBIQUE"],['id'=>152,'item_code'=>"152",'item_value'=>"NA",'description'=>"NAMIBIA"],['id'=>153,'item_code'=>"153",'item_value'=>"NC",'description'=>"NEW CALEDONIA"],['id'=>154,'item_code'=>"154",'item_value'=>"NE",'description'=>"NIGER"],['id'=>155,'item_code'=>"155",'item_value'=>"NF",'description'=>"NORFOLK ISLAND"],['id'=>156,'item_code'=>"156",'item_value'=>"NG",'description'=>"NIGERIA"],['id'=>157,'item_code'=>"157",'item_value'=>"NI",'description'=>"NICARAGUA"],['id'=>158,'item_code'=>"158",'item_value'=>"NL",'description'=>"NETHERLANDS"],['id'=>159,'item_code'=>"159",'item_value'=>"NO",'description'=>"NORWAY"],['id'=>160,'item_code'=>"160",'item_value'=>"NP",'description'=>"NEPAL"],['id'=>161,'item_code'=>"161",'item_value'=>"NR",'description'=>"NAURU"],['id'=>162,'item_code'=>"162",'item_value'=>"NU",'description'=>"NIUE"],['id'=>163,'item_code'=>"163",'item_value'=>"NZ",'description'=>"NEW ZEALAND"],['id'=>164,'item_code'=>"164",'item_value'=>"OM",'description'=>"OMAN"],['id'=>165,'item_code'=>"165",'item_value'=>"PA",'description'=>"PANAMA"],['id'=>166,'item_code'=>"166",'item_value'=>"PE",'description'=>"PERU"],['id'=>167,'item_code'=>"167",'item_value'=>"PF",'description'=>"FRENCH POLYNESIA"],['id'=>168,'item_code'=>"168",'item_value'=>"PG",'description'=>"PAPUA NEW GUINEA"],['id'=>169,'item_code'=>"169",'item_value'=>"PH",'description'=>"PHILIPPINES"],['id'=>170,'item_code'=>"170",'item_value'=>"PK",'description'=>"PAKISTAN"],['id'=>171,'item_code'=>"171",'item_value'=>"PL",'description'=>"POLAND"],['id'=>172,'item_code'=>"172",'item_value'=>"PM",'description'=>"SAINT PIERRE AND MIQUELON"],['id'=>173,'item_code'=>"173",'item_value'=>"PN",'description'=>"PITCAIRN"],['id'=>174,'item_code'=>"174",'item_value'=>"PR",'description'=>"PUERTO RICO"],['id'=>175,'item_code'=>"175",'item_value'=>"PS",'description'=>"PALESTINIAN TERRITORY, OCCUPIED"],['id'=>176,'item_code'=>"176",'item_value'=>"PT",'description'=>"PORTUGAL"],['id'=>177,'item_code'=>"177",'item_value'=>"PW",'description'=>"PALAU"],['id'=>178,'item_code'=>"178",'item_value'=>"PY",'description'=>"PARAGUAY"],['id'=>179,'item_code'=>"179",'item_value'=>"QA",'description'=>"QATAR"],['id'=>180,'item_code'=>"180",'item_value'=>"RE",'description'=>"RÉUNION"],['id'=>181,'item_code'=>"181",'item_value'=>"RO",'description'=>"ROMANIA"],['id'=>182,'item_code'=>"182",'item_value'=>"RU",'description'=>"RUSSIAN FEDERATION"],['id'=>183,'item_code'=>"183",'item_value'=>"RW",'description'=>"RWANDA"],['id'=>184,'item_code'=>"184",'item_value'=>"SA",'description'=>"SAUDI ARABIA"],['id'=>185,'item_code'=>"185",'item_value'=>"SB",'description'=>"SOLOMON ISLANDS"],['id'=>186,'item_code'=>"186",'item_value'=>"SC",'description'=>"SEYCHELLES"],['id'=>187,'item_code'=>"187",'item_value'=>"SD",'description'=>"SUDAN"],['id'=>188,'item_code'=>"188",'item_value'=>"SE",'description'=>"SWEDEN"],['id'=>189,'item_code'=>"189",'item_value'=>"SG",'description'=>"SINGAPORE"],['id'=>190,'item_code'=>"190",'item_value'=>"SH",'description'=>"SAINT HELENA"],['id'=>191,'item_code'=>"191",'item_value'=>"SI",'description'=>"SLOVENIA"],['id'=>192,'item_code'=>"192",'item_value'=>"SJ",'description'=>"SVALBARD AND JAN MAYEN"],['id'=>193,'item_code'=>"193",'item_value'=>"SK",'description'=>"SLOVAKIA"],['id'=>194,'item_code'=>"194",'item_value'=>"SL",'description'=>"SIERRA LEONE"],['id'=>195,'item_code'=>"195",'item_value'=>"SM",'description'=>"SAN MARINO"],['id'=>196,'item_code'=>"196",'item_value'=>"SN",'description'=>"SENEGAL"],['id'=>197,'item_code'=>"197",'item_value'=>"SO",'description'=>"SOMALIA"],['id'=>198,'item_code'=>"198",'item_value'=>"SR",'description'=>"SURINAME"],['id'=>199,'item_code'=>"199",'item_value'=>"ST",'description'=>"SAO TOME AND PRINCIPE"],['id'=>200,'item_code'=>"200",'item_value'=>"SV",'description'=>"EL SALVADOR"],['id'=>201,'item_code'=>"201",'item_value'=>"SY",'description'=>"SYRIAN ARAB REPUBLIC"],['id'=>202,'item_code'=>"202",'item_value'=>"SZ",'description'=>"SWAZILAND"],['id'=>203,'item_code'=>"203",'item_value'=>"TC",'description'=>"TURKS AND CAICOS ISLANDS"],['id'=>204,'item_code'=>"204",'item_value'=>"TD",'description'=>"CHAD"],['id'=>205,'item_code'=>"205",'item_value'=>"TF",'description'=>"FRENCH SOUTHERN TERRITORIES"],['id'=>206,'item_code'=>"206",'item_value'=>"TG",'description'=>"TOGO"],['id'=>207,'item_code'=>"207",'item_value'=>"TH",'description'=>"THAILAND"],['id'=>208,'item_code'=>"208",'item_value'=>"TJ",'description'=>"TAJIKISTAN"],['id'=>209,'item_code'=>"209",'item_value'=>"TK",'description'=>"TOKELAU"],['id'=>210,'item_code'=>"210",'item_value'=>"TM",'description'=>"TURKMENISTAN"],['id'=>211,'item_code'=>"211",'item_value'=>"TN",'description'=>"TUNISIA"],['id'=>212,'item_code'=>"212",'item_value'=>"TO",'description'=>"TONGA"],['id'=>213,'item_code'=>"213",'item_value'=>"TP",'description'=>"EAST TIMOR"],['id'=>214,'item_code'=>"214",'item_value'=>"TR",'description'=>"TURKEY"],['id'=>215,'item_code'=>"215",'item_value'=>"TT",'description'=>"TRINIDAD AND TOBAGO"],['id'=>216,'item_code'=>"216",'item_value'=>"TV",'description'=>"TUVALU"],['id'=>217,'item_code'=>"217",'item_value'=>"TW",'description'=>"TAIWAN, PROVINCE OF CHINA"],['id'=>218,'item_code'=>"218",'item_value'=>"TZ",'description'=>"TANZANIA, UNITED REPUBLIC OF"],['id'=>219,'item_code'=>"219",'item_value'=>"UA",'description'=>"UKRAINE"],['id'=>220,'item_code'=>"220",'item_value'=>"UG",'description'=>"UGANDA"],['id'=>221,'item_code'=>"221",'item_value'=>"UM",'description'=>"UNITED STATES MINOR OUTLYING ISLANDS"],['id'=>222,'item_code'=>"222",'item_value'=>"US",'description'=>"UNITED STATES"],['id'=>223,'item_code'=>"223",'item_value'=>"UY",'description'=>"URUGUAY"],['id'=>224,'item_code'=>"224",'item_value'=>"UZ",'description'=>"UZBEKISTAN"],['id'=>225,'item_code'=>"225",'item_value'=>"VA",'description'=>"HOLY SEE (VATICAN CITY STATE)"],
                                  ['id'=>226,'item_code'=>"226",'item_value'=>"VC",'description'=>"SAINT VINCENT AND THE GRENADINES"],['id'=>227,'item_code'=>"227",'item_value'=>"VE",'description'=>"VENEZUELA"],
                                  ['id'=>228,'item_code'=>"228",'item_value'=>"VG",'description'=>"VIRGIN ISLANDS, BRITISH"],['id'=>229,'item_code'=>"229",'item_value'=>"VI",'description'=>"VIRGIN ISLANDS, U.S."], ['id'=>230, 'item_code'=>"230",'item_value'=>"VN",'description'=>"VIET NAM"],
    [
        'id'=>231,
        'item_code'=>"231",
        'item_value'=>"VU",
        'description'=>"VANUATU"],
    [
        'id'=>232,
        'item_code'=>"232",
        'item_value'=>"WF",
        'description'=>"WALLIS AND FUTUNA"
    ],
    [
        'id'=>233,
        'item_code'=>"233",
        'item_value'=>"WS",
        'description'=>"SAMOA"
    ],
    [
        'id'=>234,
        'item_code'=>"234",
        'item_value'=>"YE",
        'description'=>"YEMEN"
    ],
    [
        'id'=>235,
        'item_code'=>"235",
        'item_value'=>"YT",
        'description'=>"MAYOTTE"
    ],
    [
        'id'=>236,
         'item_code'=>"236",
         'item_value'=>"YU",
         'description'=>"YUGOSLAVIA"
        ],
    [
        'id'=>237,
         'item_code'=>"237",
         'item_value'=>"ZA",
         'description'=>"SOUTH AFRICA"
        ],
    [
        'id'=>238,
         'item_code'=>"238",
         'item_value'=>"ZM",
         'description'=>"ZAMBIA"
    ],
    [
        'id'=>239,
        'item_code'=>"239",
        'item_value'=>"ZW",
        'description'=>"ZIMBABWE"
        ]
        ]);


    }
}
