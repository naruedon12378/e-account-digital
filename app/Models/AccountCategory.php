<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountCategory extends Model
{
    use HasFactory;
    protected $table = 'account_categories';
    protected $fillable = [
        'name_th',
        'name_en',
        'account_code',
        'publish',
    ];

    const group_item =
    [
        [
            'name_th' => 'สินทรัพย์',
            'name_en' => 'Assets',
            'account_code' => '1',
            'main_item' => [
                [
                    'name_th' => 'สินทรัพย์หมุนเวียน',
                    'name_en' => 'Current assets',
                    'code' => '11',
                    'sort' => '1',
                    'secondary_item' =>
                    [
                        [
                            'name_th' => 'เงินสดและรายการเทียบเท่าเงินสด',
                            'name_en' => 'Cash and cash equivalents',
                            'code' => '1',
                            'sort' => '1',
                            'sub_item' =>
                            [
                                [
                                    'name_th' => 'เงินสด',
                                    'name_en' => 'Cash',
                                    'code' => '1',
                                    'account_item' =>
                                    [
                                        [
                                            'account_code' => '111101',
                                            'name_th' => 'เงินสด',
                                            'name_en' => 'Cash',
                                        ],

                                    ]
                                ],
                                [
                                    'name_th' => 'บัญชีกระแสรายวัน',
                                    'name_en' => 'Current accounts',
                                    'code' => '2',
                                    'account_item' =>
                                    [
                                        [
                                            'account_code' => '111201',
                                            'name_th' => 'ธนาคาร - บัญชีกระแสรายวัน',
                                            'name_en' => 'Current account',
                                        ],
                                    ]
                                ],
                                [
                                    'name_th' => 'บัญชีออมทรัพย์',
                                    'name_en' => 'Saving accounts',
                                    'code' => '3',
                                    'account_item' =>
                                    [
                                        [
                                            'account_code' => '111301',
                                            'name_th' => 'ธนาคาร - บัญชีออมทรัพย์',
                                            'name_en' => 'Saving account',
                                        ],
                                    ]
                                ],
                                [
                                    'name_th' => 'เช็ค',
                                    'name_en' => 'Uncash accounts',
                                    'code' => '4',
                                    'account_item' =>
                                    [
                                        [
                                            'account_code' => '111401',
                                            'name_th' => 'เช็ครับที่ครบกำหนดแต่ยังมิได้ฝาก',
                                            'name_en' => 'Uncash account',
                                        ],
                                    ]
                                ],
                                [
                                    'name_th' => 'กระเป๋าเงินอิเล็กทรอนิกส์',
                                    'name_en' => 'e - Wallet',
                                    'code' => '5',
                                    'account_item' =>
                                    [
                                        [
                                            'account_code' => '111501',
                                            'name_th' => 'กระเป๋าเงินอิเล็กทรอนิกส์',
                                            'name_en' => 'e - Wallet',
                                        ],
                                    ]
                                ],
                            ]
                        ],
                        [
                            'name_th' => 'เงินลงทุนชั่วคราว',
                            'name_en' => 'Short-term investments',
                            'code' => '2',
                            'sort' => '1',
                            'sub_item' =>
                            [
                                [
                                    'name_th' => 'บัญชีฝากประจำไม่เกิน 1 ปี',
                                    'name_en' => 'Fixed deposites',
                                    'code' => '1',
                                    'account_item' =>
                                    [
                                        [
                                            'account_code' => '112101',
                                            'name_th' => 'ธนาคาร - ฝากประจำ',
                                            'name_en' => 'Fixed deposites',
                                        ],

                                    ]
                                ],
                                [
                                    'name_th' => 'เงินลงทุนชั่วคราวอื่น',
                                    'name_en' => 'Other short-term investments',
                                    'code' => '2',
                                    'account_item' =>
                                    [
                                        [
                                            'account_code' => '112201',
                                            'name_th' => 'เงินลงทุนชั่วคราวอื่น',
                                            'name_en' => 'Other short-term investments',
                                        ],

                                    ]
                                ],

                            ]
                        ],
                        [
                            'name_th' => 'ลูกหนี้การค้าและลูกหนี้อื่น',
                            'name_en' => 'Accunts receivables and other receivables',
                            'code' => '2',
                            'sort' => '1',
                            'sub_item' =>
                            [
                                [
                                    'name_th' => 'ลูกหนี้การค้า',
                                    'name_en' => 'Accounts receivable',
                                    'code' => '1',
                                    'account_item' =>
                                    [
                                        [
                                            'account_code' => '113101',
                                            'name_th' => 'ลูกหนี้การค้า',
                                            'name_en' => 'Accounts receivable',
                                        ],
                                        [
                                            'account_code' => '113102',
                                            'name_th' => 'เช็ครับลงวันที่ล่วงหน้า',
                                            'name_en' => 'Cheques received in advance',
                                        ],
                                        [
                                            'account_code' => '113103',
                                            'name_th' => 'ค่าเผื่อหนี้สงสัยจะสูญ',
                                            'name_en' => 'Allowances for doubtful accounts',
                                        ],

                                    ]
                                ],
                                [
                                    'name_th' => 'เงินให้กู้ยืม',
                                    'name_en' => 'Short-term lendings',
                                    'code' => '2',
                                    'account_item' =>
                                    [
                                        [
                                            'account_code' => '112201',
                                            'name_th' => 'เงินให้กู้ยืม - บุคคลที่เกี่ยวข้องกัน',
                                            'name_en' => 'Short-term lendings to related parties',
                                        ],
                                        [
                                            'account_code' => '112201',
                                            'name_th' => 'เงินให้กู้ยืม - บุคคลอื่น',
                                            'name_en' => 'Short-term lendings to others',
                                        ],
                                        [
                                            'account_code' => '112201',
                                            'name_th' => 'เงินรับล่วงหน้าที่พนักงาน',
                                            'name_en' => 'Cash received at employee',
                                        ],

                                    ]
                                ],
                                [
                                    'name_th' => 'ลูกหนี้อื่น',
                                    'name_en' => 'Other receivables',
                                    'code' => '2',
                                    'account_item' =>
                                    [
                                        [
                                            'account_code' => '112201',
                                            'name_th' => 'ลูกหนี้อื่น',
                                            'name_en' => 'Other receivables',
                                        ],
                                    ]
                                ],

                            ]
                        ],
                        [
                            'name_th' => 'สินค้าคงเหลือ',
                            'name_en' => 'Inventory',
                            'code' => '2',
                            'sort' => '1',
                            'sub_item' =>
                            [
                                [
                                    'name_th' => 'สินค้าคงเหลือ',
                                    'name_en' => 'Inventory',
                                    'code' => '1',
                                    'account_item' =>
                                    [
                                        [
                                            'account_code' => '112101',
                                            'name_th' => 'วัตถุดิบคงเหลือ',
                                            'name_en' => 'Raw Material',
                                        ],
                                        [
                                            'account_code' => '112101',
                                            'name_th' => 'สินค้าสำเร็จูป',
                                            'name_en' => 'Finished goods',
                                        ],
                                        [
                                            'account_code' => '112101',
                                            'name_th' => 'งานระหว่างทำ',
                                            'name_en' => 'Work-in-progress',
                                        ],

                                    ]
                                ],
                            ]
                        ],
                    ]
                ],
                [
                    'name_th' => 'สินทรัพย์ไม่หมุนเวียน',
                    'name_en' => 'Non-current assets',
                    'code' => '12',
                    'sort' => '1',
                    'secondary_item' =>
                    [
                        [
                            'name_th' => 'เงินลงทุนระยะยาว',
                            'name_en' => 'Long-term investments',
                            'code' => '1',
                            'sort' => '1',
                            'sub_item' =>
                            [
                                [
                                    'name_th' => 'เงินลงทุนระยะยาว',
                                    'name_en' => 'Long-term investments',
                                    'code' => '1',
                                    'account_item' =>
                                    [
                                        [
                                            'account_code' => '121101',
                                            'name_th' => 'เงินลงทุนเผื่อขาย',
                                            'name_en' => 'Long-term investments - avaiable for sale',
                                        ],
                                        [
                                            'account_code' => '121102',
                                            'name_th' => 'เงินลงทุนในบริษัทร่วม',
                                            'name_en' => 'Long-term investments - in associate',
                                        ],
                                        [
                                            'account_code' => '121103',
                                            'name_th' => 'เงินลงทุนในบริษัทย่อย',
                                            'name_en' => 'Long-term investments - in subsidary',
                                        ],
                                        [
                                            'account_code' => '121104',
                                            'name_th' => 'เงินลงทุนในการร่วมค้า',
                                            'name_en' => 'Long-term investments - in joint venture',
                                        ],
                                        [
                                            'account_code' => '121105',
                                            'name_th' => 'เงินลงทุนระยะยาวอื่น',
                                            'name_en' => 'Long-term investments - other',
                                        ],

                                    ]
                                ],
                            ]
                        ],
                        [
                            'name_th' => 'เงินให้กู้ยืมระยะยาว',
                            'name_en' => 'Long-term lendings',
                            'code' => '2',
                            'sort' => '1',
                            'sub_item' =>
                            [
                                [
                                    'name_th' => 'เงินให้กู้ยืมระยะยาว',
                                    'name_en' => 'Long-term lendings',
                                    'code' => '1',
                                    'account_item' =>
                                    [
                                        [
                                            'account_code' => '122101',
                                            'name_th' => 'เงินให้กู้ยืมระยะยาวแก่บุคคลที่เกี่ยวข้องกัน',
                                            'name_en' => 'Long-term lendings to related parties',
                                        ],
                                        [
                                            'account_code' => '122102',
                                            'name_th' => 'เงินให้กู้ยืมระยะยาวแก่บุคคลอื่น',
                                            'name_en' => 'Long-term lendings to others',
                                        ],

                                    ]
                                ],
                            ]
                        ],
                        [
                            'name_th' => 'อสังหาริมทรัพย์เพื่อการลงทุน',
                            'name_en' => 'Propety investments',
                            'code' => '3',
                            'sort' => '1',
                            'sub_item' =>
                            [
                                [
                                    'name_th' => 'อสังหาริมทรัพย์เพื่อการลงทุน',
                                    'name_en' => 'Investments - property',
                                    'code' => '1',
                                    'account_item' =>
                                    [
                                        [
                                            'account_code' => '123101',
                                            'name_th' => 'อสังหาริมทรัพย์เพื่อการลงทุน',
                                            'name_en' => 'Investments - properties',
                                        ],

                                    ]
                                ],
                                [
                                    'name_th' => 'สินทรัพย์ไม่หมุนเวียนที่ถือไว้เพื่อขาย',
                                    'name_en' => 'Non-current assets held for sale and discontinued operations',
                                    'code' => '',
                                    'account_item' =>
                                    [
                                        [
                                            'account_code' => '123201',
                                            'name_th' => 'สินทรัพย์ไม่หมุนเวียนที่ถือไว้เพื่อขาย',
                                            'name_en' => 'Non-current assets held for sale and discontinued operations',
                                        ],

                                    ]
                                ],
                            ]
                        ],
                        [
                            'name_th' => 'ที่ดิน อาคาร และอุปกรณ์',
                            'name_en' => 'Property, plants and equipments',
                            'code' => '4',
                            'sort' => '1',
                            'sub_item' =>
                            [
                                [
                                    'name_th' => 'ที่ดิน อาคาร และอุปกรณ์',
                                    'name_en' => 'Property, plants and equipments',
                                    'code' => '1',
                                    'account_item' =>
                                    [
                                        [
                                            'account_code' => '124101',
                                            'name_th' => 'ที่ดิน',
                                            'name_en' => 'Lands',
                                        ],
                                        [
                                            'account_code' => '124102',
                                            'name_th' => 'งานระหว่างก่อสร้าง',
                                            'name_en' => 'Construction in progress',
                                        ],
                                        [
                                            'account_code' => '124103',
                                            'name_th' => 'อาคาร',
                                            'name_en' => 'Buildings',
                                        ],
                                        [
                                            'account_code' => '124104',
                                            'name_th' => 'ส่วนปรับปรุงอาคาร',
                                            'name_en' => 'Building improvements',
                                        ],
                                        [
                                            'account_code' => '124105',
                                            'name_th' => 'เครื่องจักร และอุปกรณ์',
                                            'name_en' => 'Machineries',
                                        ],
                                        [
                                            'account_code' => '124106',
                                            'name_th' => 'อุปกรณ์สำนักงาน',
                                            'name_en' => 'Office equipments',
                                        ],
                                        [
                                            'account_code' => '124107',
                                            'name_th' => 'เครื่องตกแต่งสำนักงาน',
                                            'name_en' => 'Furniture and fixfures',
                                        ],
                                        [
                                            'account_code' => '124108',
                                            'name_th' => 'ยานพาหนะ',
                                            'name_en' => 'Vehicles',
                                        ],
                                    ]
                                ],
                                [
                                    'name_th' => 'ค่าเสื่อมราคาสะสม',
                                    'name_en' => 'Accumulated depreciations',
                                    'code' => '1',
                                    'account_item' =>
                                    [
                                        [
                                            'account_code' => '124203',
                                            'name_th' => 'ค่าเสื่อมราคาสะสม - อาคาร',
                                            'name_en' => 'Accumulated depreciations - buildings',
                                        ],
                                        [
                                            'account_code' => '124204',
                                            'name_th' => 'ค่าเสื่อมราคาสะสม - ส่วนปรับปรุงอาคาร',
                                            'name_en' => 'Accumulated depreciations - building improvements ',
                                        ],
                                        [
                                            'account_code' => '124205',
                                            'name_th' => 'ค่าเสื่อมราคาสะสม - เครื่องจักร',
                                            'name_en' => 'Accumulated depreciations - machineries',
                                        ],
                                        [
                                            'account_code' => '124206',
                                            'name_th' => 'ค่าเสื่อมราคาสะสม - อุปกรณ์สำนักงาน',
                                            'name_en' => 'Accumulated depreciations - equipments',
                                        ],
                                        [
                                            'account_code' => '124207',
                                            'name_th' => 'ค่าเสื่อมราคาสะสม - เครื่องตกแต่งสำนักงาน',
                                            'name_en' => 'Accumulated depreciations - furniture and fixfures',
                                        ],
                                        [
                                            'account_code' => '124208',
                                            'name_th' => 'ค่าเสื่อมราคาสะสม - ยานพาหนะ',
                                            'name_en' => 'Accumulated depreciations - vehicles',
                                        ],
                                    ]
                                ],
                            ]
                        ],
                        [
                            'name_th' => 'สินทรัพย์ไม่มีตัวตน ',
                            'name_en' => 'Intangible assets',
                            'code' => '5',
                            'sort' => '1',
                            'sub_item' =>
                            [
                                [
                                    'name_th' => 'สินทรัพย์ไม่มีตัวตน',
                                    'name_en' => 'Intangible assets',
                                    'code' => '1',
                                    'account_item' =>
                                    [
                                        [
                                            'account_code' => '125101',
                                            'name_th' => 'ซอฟต์แวร์',
                                            'name_en' => 'Softwares',
                                        ],
                                        [
                                            'account_code' => '125102',
                                            'name_th' => 'สิทธิการเช่าหรือใช้ทรัพย์สิน',
                                            'name_en' => 'Leasehold rights',
                                        ],
                                        [
                                            'account_code' => '125103',
                                            'name_th' => 'สินทรัพย์ไม่มีตัวตนอื่น',
                                            'name_en' => 'Other intangible assets',
                                        ],
                                    ]
                                ],
                                [
                                    'name_th' => 'ค่าตัดจำหน่ายสะสม',
                                    'name_en' => 'Accumulated amortization',
                                    'code' => '2',
                                    'account_item' =>
                                    [
                                        [
                                            'account_code' => '125201',
                                            'name_th' => 'ค่าตัดจำหน่ายสะสม - ซอฟต์แวร์',
                                            'name_en' => 'Accumulated amortization - softwars',
                                        ],
                                        [
                                            'account_code' => '125202',
                                            'name_th' => 'ค่าตัดจำหน่ายสะสม - สิทธิการเช่าหรือใช้ทรัพย์สิน',
                                            'name_en' => 'Accumulated amortization - leasehold rights',
                                        ],
                                        [
                                            'account_code' => '125203',
                                            'name_th' => 'ค่าตัดจำหน่ายสะสม - สินทรัพย์ไม่มีตัวตนอื่น',
                                            'name_en' => 'Accumulated amortization - other intangible assets ',
                                        ],

                                    ]
                                ],
                            ]
                        ],
                        [
                            'name_th' => 'สินทรัพย์ไม่หมุนเวียนอื่น ',
                            'name_en' => 'Other non-current assets',
                            'code' => '6',
                            'sort' => '1',
                            'sub_item' =>
                            [
                                [
                                    'name_th' => 'สินทรัพย์ไม่หมุนเวียนอื่น',
                                    'name_en' => 'Other non-current assets',
                                    'code' => '1',
                                    'account_item' =>
                                    [
                                        [
                                            'account_code' => '126101',
                                            'name_th' => 'สินทรัพย์ไม่หมุนเวียนอื่น',
                                            'name_en' => 'Other non-current assets',
                                        ],
                                    ]
                                ],

                            ]
                        ],
                    ]
                ],
            ]

        ],
        [
            'name_th' => 'หนี้สิน',
            'name_en' => 'Liabilities',
            'account_code' => '2',
            'main_item' => [
                [
                    'name_th' => 'หนี้สินหมุนเวียน',
                    'name_en' => 'Current assets',
                    'code' => '21',
                    'sort' => '1',
                    'secondary_item' =>
                    [
                        [
                            'name_th' => 'เงินเบิกเกินบัญชีธนาคารและเงินกู้ยืมระยะสั้นจากสถาบันการเงิน',
                            'name_en' => 'Cash and cash equivalents',
                            'code' => '1',
                            'sort' => '1',
                            'sub_item' =>
                            [
                                [
                                    'name_th' => 'เงินเบิกเกินบัญชีธนาคาร',
                                    'name_en' => 'Cash',
                                    'code' => '1',
                                    'account_item' =>
                                    [
                                        [
                                            'account_code' => '211101',
                                            'name_th' => 'เงินเบิกเกินบัญชีธนาคาร',
                                            'name_en' => 'Cash',
                                        ],

                                    ]
                                ],
                                [
                                    'name_th' => 'เงินกู้ยืมระยะสั้นไม่มีหลักประกัน',
                                    'name_en' => 'Current accounts',
                                    'code' => '2',
                                    'account_item' =>
                                    [
                                        [
                                            'account_code' => '211201',
                                            'name_th' => 'เงินกู้ยืมระยะสั้นธนาคารไม่มีหลักประกัน',
                                            'name_en' => 'Current account',
                                        ],
                                    ]
                                ],
                                [
                                    'name_th' => 'เงินกู้ยืมระยะสั้นมีหลักประกัน',
                                    'name_en' => 'Saving accounts',
                                    'code' => '3',
                                    'account_item' =>
                                    [
                                        [
                                            'account_code' => '211301',
                                            'name_th' => 'เงินกู้ยืมระยะสั้นธนาคารมีหลักประกัน',
                                            'name_en' => 'Saving account',
                                        ],
                                    ]
                                ],

                            ]
                        ],
                        [
                            'name_th' => 'เจ้าหนี้การค้าและเจ้าหนี้อื่น',
                            'name_en' => 'Short-term investments',
                            'code' => '2',
                            'sort' => '1',
                            'sub_item' =>
                            [
                                [
                                    'name_th' => 'เจ้าหนี้การค้า',
                                    'name_en' => 'Fixed deposites',
                                    'code' => '1',
                                    'account_item' =>
                                    [
                                        [
                                            'account_code' => '212101',
                                            'name_th' => 'เจ้าหนี้การค้า',
                                            'name_en' => 'Fixed deposites',
                                        ],
                                        [
                                            'account_code' => '212102',
                                            'name_th' => 'เช็คจ่าย',
                                            'name_en' => 'Fixed deposites',
                                        ],
                                        [
                                            'account_code' => '212103',
                                            'name_th' => 'รายได้รับล่วงหน้า',
                                            'name_en' => 'Fixed deposites',
                                        ],
                                        [
                                            'account_code' => '212104',
                                            'name_th' => 'เงินรับล่วงหน้า - เงินมัดจำ',
                                            'name_en' => 'Fixed deposites',
                                        ],
                                        [
                                            'account_code' => '212105',
                                            'name_th' => 'เงินรับล่วงหน้า - เงินประกัน',
                                            'name_en' => 'Fixed deposites',
                                        ],

                                    ]
                                ],
                                [
                                    'name_th' => 'เงินกู้ยืมระยะสั้น',
                                    'name_en' => 'Other short-term investments',
                                    'code' => '2',
                                    'account_item' =>
                                    [
                                        [
                                            'account_code' => '212201',
                                            'name_th' => ' เงินกู้ยืมระยะสั้นจากบุคคลที่เกี่ยวข้องกัน',
                                            'name_en' => 'Other short-term investments',
                                        ],
                                        [
                                            'account_code' => '212202',
                                            'name_th' => ' เงินกู้ยืมระยะสั้นจากบุคคลอื่น',
                                            'name_en' => 'Other short-term investments',
                                        ],
                                        [
                                            'account_code' => '212203',
                                            'name_th' => ' สำรองจ่ายแทนกิจการที่ยังไม่ได้คืนเงิน',
                                            'name_en' => 'Other short-term investments',
                                        ],

                                    ]
                                ],
                                [
                                    'name_th' => 'เจ้าหนี้อื่น',
                                    'name_en' => 'Other short-term investments',
                                    'code' => '2',
                                    'account_item' =>
                                    [
                                        [
                                            'account_code' => '212301',
                                            'name_th' => 'เงินเดือนค้างจ่าย',
                                            'name_en' => 'Other short-term investments',
                                        ],
                                        [
                                            'account_code' => '212302',
                                            'name_th' => 'กองทุนสำรองเลี้ยงชีพค้างจ่าย',
                                            'name_en' => 'Other short-term investments',
                                        ],
                                        [
                                            'account_code' => '212303',
                                            'name_th' => ' ค่าสอบบัญชีค้างจ่าย',
                                            'name_en' => 'Other short-term investments',
                                        ],
                                        [
                                            'account_code' => '212304',
                                            'name_th' => ' ค่าทำบัญชีค้างจ่าย',
                                            'name_en' => 'Other short-term investments',
                                        ],
                                        [
                                            'account_code' => '212305',
                                            'name_th' => ' ค่าใช้จ่ายค้างจ่ายอื่น',
                                            'name_en' => 'Other short-term investments',
                                        ],
                                        [
                                            'account_code' => '212306',
                                            'name_th' => ' เจ้าหนี้อื่น',
                                            'name_en' => 'Other short-term investments',
                                        ],
                                        [
                                            'account_code' => '212307',
                                            'name_th' => ' เจ้าหนี้เช่าซื้อ',
                                            'name_en' => 'Other short-term investments',
                                        ],

                                    ]
                                ],

                            ]
                        ],
                        [
                            'name_th' => 'เงินกู้ยืมระยะยาวที่ถึงกำหนดชำระภายใน 1 ปี',
                            'name_en' => 'Accunts receivables and other receivables',
                            'code' => '3',
                            'sort' => '1',
                            'sub_item' =>
                            [
                                [
                                    'name_th' => 'เงินกู้ยืมระยะยาวที่ถึงกำหนดชำระภายใน 1 ปี',
                                    'name_en' => 'Accounts receivable',
                                    'code' => '1',
                                    'account_item' =>
                                    [
                                        [
                                            'account_code' => '213101',
                                            'name_th' => 'เงินกู้ยืมระยะยาวที่ถึงกำหนดชำระภายใน 1 ปี',
                                            'name_en' => 'Accounts receivable',
                                        ],
                                        [
                                            'account_code' => '213102',
                                            'name_th' => 'หนี้สินสัญญาเช่าทางการเงินภายใน 1 ปี',
                                            'name_en' => 'Cheques received in advance',
                                        ],

                                    ]
                                ],

                            ]
                        ],
                        [
                            'name_th' => 'สินค้าคงเหลือ',
                            'name_en' => 'Inventory',
                            'code' => '2',
                            'sort' => '1',
                            'sub_item' =>
                            [
                                [
                                    'name_th' => 'สินค้าคงเหลือ',
                                    'name_en' => 'Inventory',
                                    'code' => '1',
                                    'account_item' =>
                                    [
                                        [
                                            'account_code' => '112101',
                                            'name_th' => 'วัตถุดิบคงเหลือ',
                                            'name_en' => 'Raw Material',
                                        ],
                                        [
                                            'account_code' => '112101',
                                            'name_th' => 'สินค้าสำเร็จูป',
                                            'name_en' => 'Finished goods',
                                        ],
                                        [
                                            'account_code' => '112101',
                                            'name_th' => 'งานระหว่างทำ',
                                            'name_en' => 'Work-in-progress',
                                        ],

                                    ]
                                ],
                            ]
                        ],
                    ]
                ],

            ]
        ],
        [
            'name_th' => 'ส่วนของเจ้าของ',
            'name_en' => "Owner's Equity",
            'account_code' => '3',

        ],
        [
            'name_th' => 'รายได้',
            'name_en' => 'Income or Revenue',
            'account_code' => '4',

        ],
        [
            'name_th' => 'สินทรัพย์',
            'name_en' => 'Expenses',
            'account_code' => '5',

        ],
    ];
}
