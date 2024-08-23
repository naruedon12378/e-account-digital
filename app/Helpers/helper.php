<?php

use App\Models\AccountCode;
use App\Models\Branch;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\StatusTab;
use App\Models\Tax;
use App\Models\Unit;
use App\Models\Warehouse;
use Carbon\Carbon;

/**
 * storage path
 */
if (!function_exists('serverPath')) {
    function serverPath($file = null)
    {
        if ($file)
            return url($file);

        return null;
    }
}

/**
 * replace regular expression
 */
if (!function_exists('replaceRegx')) {
    function replaceRegx($string)
    {
        $pattern = "#[^a-zA-Z0-9_ %\[\]\.,/\(\)%&-ก-๙]#i";

        return preg_replace($pattern, '', $string);
    }
}


if (!function_exists('accountClass')) {
    function accountClass()
    {
        return [
            1 => "Assets",
            2 => "Liabilities",
            3 => "Equity",
            4 => "Revenues",
            5 => "Expenses",
        ];
    }
}

if (!function_exists('getRunningNumber')) {
    function getRunningNumber($number, $length)
    {
        return str_pad($number, $length, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('getAccountCodes')) {
    function getAccountCodes($accClass = [])
    {
        $accountCodes = AccountCode::whereIn('primary_prefix', $accClass)->get();
        $selectItem = collect();
        if (count($accountCodes) > 0) {
            foreach ($accountCodes as $account) {
                $_account = [
                    'text' => $account->account_code . ' - ' . $account->name_th,
                    'value' => $account->account_code,
                ];
                $selectItem->push($_account);
            }
        }
        return $selectItem->pluck('text', 'value');
    }
}

/**
 * convert array to json that allow thai font
 */
if (!function_exists('jsonEncode')) {
    function jsonEncode($array = [])
    {
        return json_encode($array, JSON_UNESCAPED_UNICODE);
    }
}

if (!function_exists('getVatRate')) {
    function getVatRate()
    {
        $taxes = Tax::where('is_active', true)->get();
        $selectItem = collect();
        if (count($taxes) > 0) {
            foreach ($taxes as $tax) {
                $_tax = [
                    'text' => $tax->name_th,
                    'value' => $tax->rate,
                ];
                $selectItem->push($_tax);
            }
        }
        return $selectItem->pluck('text', 'value');
    }
}

if (!function_exists('getWhtRate')) {
    function getWhtRate()
    {
        return [
            "1" => "1%",
            "2" => "2%",
            "3" => "3%",
            "10" => "10%",
        ];
    }
}

if (!function_exists('getUnits')) {
    function getUnits($type = 'product')
    {
        $units = Unit::where([
            ['is_active', true],
            ['type', $type]
        ])->get();
        $selectItem = collect();
        if (count($units) > 0) {
            foreach ($units as $unit) {
                $_unit = [
                    'text' => $unit->name_th,
                    'value' => $unit->id,
                ];
                $selectItem->push($_unit);
            }
        }
        return $selectItem->pluck('text', 'value');
    }
}

if (!function_exists("businsessType")) {
    function businsessType()
    {
        $businessType = [
            "corporate" => [
                "Company Limited" => "บริษัทจำกัด",
                "Public Company Limited" => "บริษัทมหาชนจำกัด",
                "Foundation" => "มูลนิธิ",
                "Association" => "สมาคม",
                "Joint Venture" => "กิจการร่วมค้า",
                "Others" => "อื่น ๆ",
            ],
            "personal" => [
                "Human" => "บุคคลธรรมดา",
                "Ordinary Partnership" => "ห้างหุ้นส่วนสามัญ",
                "Shop" => "ร้านค้า",
                "Group of People" => "คณะบุคคล",
            ],
        ];

        return $businessType;
    }
}

if (!function_exists('prefix')) {
    function prefix()
    {
        return [
            'None' => 'None',
            'Khun' => 'Khun',
            'Mr' => 'Mr',
            'Mrs' => 'Mrs',
            'Ms' => 'Ms',
            'Other' => 'Other',
        ];
    }
}

if (!function_exists('departments')) {
    function departments()
    {
        return [
            'None' => 'None',
            'General Management' => 'General Management',
            'General Administration' => 'General Administration',
            'Sales' => 'Sales',
            'Marketing' => 'Marketing',
            'Accounting' => 'Accounting',
            'Finance' => 'Finance',
            'Human Resource' => 'Human Resource',
            'Production' => 'Production',
            'Operation' => 'Operation',
            'Information Technology' => 'Information Technology',
            'Purchasing' => 'Purchasing',
            'Research and Development' => 'Research and Development',
            'Other' => 'Other',
        ];
    }
}

if (!function_exists('socials')) {
    function socials()
    {
        return [
            'None' => 'None',
            'Facebook' => 'Facebook',
            'Line' => 'Line',
            'Whatsapp' => 'Whatsapp',
            'Wechat' => 'Wechat',
            'Telegram' => 'Telegram',
        ];
    }
}

if (!function_exists("bankList")) {
    function bankList()
    {
        $banks = [
            1 => 'กสิกรไทย',
            2 => 'กรุงไทย',
            3 => 'กรุงเทพ',
            4 => 'กรุงศรี',
            5 => 'ซีไอเอ็มบี',
            6 => 'ทหารไทยธนชาติ',
            7 => 'ไทยพาณิชย์',
            8 => 'ยูโอบี',
            9 => 'แลนด์ แอนด์ เฮ้าส์',
            10  => 'สแตนดาร์ดฯ',
            11  => 'ออมสิน',
            12  => 'เกียรตินาคินภัทร',
            13  => 'ซีตี้แบงก์',
            14  => 'อาคารสงเคราะห์',
            15  => 'ธ.ก.ส',
            16  => 'มิซูโฮ',
            17  => 'ธ.อิสลาม',
            18  => 'ทิสโก้',
            19  => 'ไอซีบีซี(ไทย)',
            20  => 'ไทยเครดิต',
            21  => 'ซูมิโตโม มิตซุย',
            22  => 'เอชเอสบีซี',
            23  => 'บีเอ็นพี พารีบาส์',
            24  => 'ดอยซ์แบงก์ เอจี',
            25  => 'ธนาคารแห่งประเทศจีน',
            26  => 'ธนาคารเอเอ็นแซด',
            27  => 'อินเดียนโอเวอร์ซี',
        ];

        return $banks;
    }
}

if (!function_exists("creditTerms")) {
    function creditTerms()
    {
        $creditTerms = [
            "Use default setting" => "ตามการตั้งค่าของกิจการ",
            "X day(s) after issued date" => "X วันหลังวันที่ออกเอกสาร",
            "Date X of the following month" => "วันที่ X ของเดือนถัดไป",
            "End of issued month" => "สิ้นเดือนของวันที่ออกเอกสาร",
            "End of following month" => "สิ้นเดือนของเดือนถัดไป",
        ];
        return $creditTerms;
    }
}

if (!function_exists("creditLimit")) {
    function creditLimit()
    {
        $creditLimit = [
            "Default" => "ค่าเริ่มต้น",
            "Unlimit" => "ไม่กำหนดวงเงิน",
            "Custom" => "กำหนดเอง",
        ];
        return $creditLimit;
    }
}

/**
 * product list for auto search complete
 */
if (!function_exists("productList")) {
    function productList()
    {
        $product_list = Product::selectRaw("
                CONCAT(code, ' (', name_en, ')') AS name
            ")
            ->pluck('name');

        return $product_list;
    }
}

// random string
if (!function_exists('genRandCode')) {
    function genRandCode($lan, $charset = null)
    {
        if ($charset == 1) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        } elseif ($charset == 2) {
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        } else {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        str_shuffle($characters);
        $rand_char = substr(str_shuffle($characters), 0, $lan);

        return $rand_char;
    }
}

if (!function_exists('setParamEmptyIsNull')) {
    function setParamEmptyIsNull($param, $return = null)
    {

        if (isset($param) && !empty($param)) {
            return $param;
        } else {
            return $return;
        }
    }
}

/**
 * status tabs bar in datatable
 */
if (!function_exists('statusTabs')) {
    function statusTabs($tabArr, $para = '')
    {
        $tabs = collect();
        foreach ($tabArr as $value) {
            $tab = new StatusTab($value);
            if ($para == $value['value']) {
                $tab->class = 'active';
            } else {
                $tab->class = '';
            }
            $tabs->push($tab);
        }
        return $tabs;
    }
}

/**
 * currency codes
 */
if (!function_exists('currencies')) {
    function currencies()
    {
        return [
            1 => 'THB',
            35 => 'USD'
        ];
    }
}

function contacts()
{
    return [
        1 => 'contact 1',
        2 => 'contact 2'
    ];
}

/**
 * date range
 */
if (!function_exists('dateRange')) {
    function dateRange($date)
    {
        if ($date) {
            $date = explodeDate($date);
            $fromDate = $date[0];
            $toDate = $date[1];
        } else {
            $fromDate = startingDate();
            $toDate = endingDate();
        }
        return ['from' => $fromDate, 'to' => $toDate];
    }
}

/**
 * explode from to date
 */
if (!function_exists('explodeDate')) {
    function explodeDate($date): array
    {
        $value = explode('-', $date);
        $fromDate = Carbon::parse(trim($value[0], ' '))->format('Y-m-d');
        $toDate = Carbon::parse(trim($value[1], ' '))->format('Y-m-d');

        return [$fromDate, $toDate];
    }
}

/**
 * starting date
 */
if (!function_exists('startingDate')) {
    function startingDate($days = '-30')
    {
        return date('Y-m-d', strtotime(date('Y-m-d', strtotime($days . 'days', strtotime(date('Y-m-d'))))));
    }
}


/**
 * ending date
 */
if (!function_exists('endingDate')) {
    function endingDate()
    {
        return date('Y-m-d');
    }
}

/**
 * pricing type
 */
if (!function_exists('pricingTypes')) {
    function pricingTypes()
    {
        return [
            'E' => 'Exclude VAT',
            'I' => 'Include VAT',
            'N' => 'None'
        ];
    }
}
function generateUniqueCode($prefix,$beginningBalance)
{
    do {
        $code = $prefix .rand(10, 9999999);
    } while (in_array($code, $beginningBalance));
    return $code;
}

if (!function_exists('getProductCategoryOptions')) {
    function getProductCategoryOptions()
    {
        $product_categories = ProductCategory::myCompany()->get();
        $selectItem = collect();
        if (count($product_categories) > 0) {
            foreach ($product_categories as $item) {
                $_item = [
                    'text' => $item->name_th,
                    'value' => $item->id,
                ];
                $selectItem->push($_item);
            }
        }
        return $selectItem->pluck('text', 'value');
    }
}

if (!function_exists('getProductOptions')) {
    function getProductOptions()
    {
        $products = Product::myCompany()->where('is_active', true)->get();
        $selectItem = collect();
        if (count($products) > 0) {
            foreach ($products as $item) {
                $_item = [
                    'text' => $item->name_th,
                    'value' => $item->id,
                ];
                $selectItem->push($_item);
            }
        }
        return $selectItem->pluck('text', 'value');
    }
}

if (!function_exists('getWarehouseOptions')) {
    function getWarehouseOptions()
    {
        $queries = Warehouse::myCompany()->where('is_active', true)->get();
        $selectItem = collect();
        if (count($queries) > 0) {
            foreach ($queries as $item) {
                $_item = [
                    'text' => $item->name_th,
                    'value' => $item->id,
                ];
                $selectItem->push($_item);
            }
        }
        return $selectItem->pluck('text', 'value');
    }
}

if (!function_exists('getBranchOptions')) {
    function getBranchOptions()
    {
        $queries = Branch::myCompany()->get();
        $selectItem = collect();
        if (count($queries) > 0) {
            foreach ($queries as $item) {
                $_item = [
                    'text' => $item->name,
                    'value' => $item->id,
                ];
                $selectItem->push($_item);
            }
        }
        return $selectItem->pluck('text', 'value');
    }
}

if (!function_exists('trxTypes')) {
    function trxTypes()
    {
        return [
            'Quotation' => 'Quotation',
            'INV' => 'Invoice',
            'RV' => 'Receipt/Record Revenue',
            'CN' => 'Credit Note',
            'BN' => 'Billing Note',
            'DN' => 'Debit Note',
        ];
    }
}

if (!function_exists('trxStatus')) {
    function trxStatus()
    {
        return [
            'Await' => 'Await Approval',
            'Outstanding' => 'Outstanding',
            'Paid' => 'Paid',
            'Overdue' => 'Overdue',
        ];
    }
}

function assetCategories()
{
    return [
        '' => '',
        '' => '',
        '' => '',
        '' => '',
        '' => '',
        '' => '',
        '' => '',
        '' => '',
    ];
}

function assetSubCategories()
{
    return [
        '' => '',
        '' => '',
        '' => '',
        '' => '',
        '' => '',
        '' => '',
        '' => '',
        '' => '',
    ];
}

if (!function_exists('setInputError')) {
    function setInputError($input_name, $message) {
        return [
            'input_name' => $input_name,
            'message' => $message,
        ];
     }
}

function businessParties()
{
    $party = [
        'name' => 'Orange Technology Solution Company Limited',
        'address' => '32 1 Charan Sanit Wong Rd, Bang O, Bang Phlat, Bangkok 10160',
        'phone' => ' 081 591 xxxx',
    ];
    return $party;
}

if (!function_exists('paymentMethods')) {
    function paymentMethods()
    {
        return [
            'cash' => 'Cash',
            'kbank' => 'K-BANK',
            'scb' => 'SCB',
        ];
    }
}

if (!function_exists('years')) {
    function years()
    {
        $years = [
            1 => date('Y'),
            2 => date('Y') + 543,
            3 => date('y'),
            4 => date('y') + 43,
        ];
        return $years;
    }
}
