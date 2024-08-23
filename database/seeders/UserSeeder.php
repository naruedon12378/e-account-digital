<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $abilities = [
            'all',
            'view',
            'create',
            'edit',
            'delete'
        ];

        $group_permissions =  [
            ['en' => 'article', 'th' => 'ข่าวสาร'],
            ['en' => 'user', 'th' => 'ผู้ใช้งาน'],
            ['en' => 'member', 'th' => 'สมาชิก'],
            ['en' => 'prefix', 'th' => 'คำนำหน้า'],
            ['en' => 'bank', 'th' => 'ธนาคาร'],
            ['en' => 'role', 'th' => 'บทบาท'],
            ['en' => 'permission', 'th' => 'สิทธิ์การใช้งาน'],
            ['en' => 'user_history', 'th' => 'ประวัติผู้ใช้งาน'],
            ['en' => 'member_history', 'th' => 'ประวัติสมาชิก'],
            ['en' => 'contact', 'th' => 'ติดต่อ'],
            ['en' => 'package_manage', 'th' => 'แพ็คเกจ'],
            ['en' => 'feature_title', 'th' => 'หัวข้อฟีเจอร์'],
            ['en' => 'feature', 'th' => 'ฟีเจอร์'],

            // payroll
            ['en' => 'payroll_salary', 'th' => 'เงินเดือน'],
            ['en' => 'payroll_salary_summary', 'th' => 'สรุปเงินเดือน'],
            ['en' => 'payroll_employee', 'th' => 'พนักงาน'],
            ['en' => 'payroll_department', 'th' => 'แผนก'],
            ['en' => 'payroll_financial_record', 'th' => 'เงินได้/เงินหัก'],

            //products
            ['en' => 'product', 'th' => 'สินค้า'],
            ['en' => 'products', 'th' => 'สินค้า'],
            ['en' => 'product_set', 'th' => 'สินค้าส่วนประกอบ'],
            ['en' => 'product_category', 'th' => 'กลุ่มสินค้า'],
            ['en' => 'product_type', 'th' => 'ประเภทสินค้า'],
            ['en' => 'unit', 'th' => 'หน่วยนับ'],
            ['en' => 'unit_set', 'th' => 'หน่วยนับย่อย'],

            //sale
            ['en' => 'sales', 'th' => 'งานขาย'],
            ['en' => 'sale_promotion', 'th' => 'ส่งเสริมการขาย'],

            //warehouse
            ['en' => 'warehouse', 'th' => 'คลังสินค้า'],
            ['en' => 'inventory', 'th' => 'สินค้าคงคลัง'],
            ['en' => 'inventory_lot', 'th' => 'เพิ่มล็อคสินค้า'],
            ['en' => 'inventory_stock_adjustment', 'th' => 'ปรับสต็อกสินค้า'],
            ['en' => 'inventory_stock_history', 'th' => 'ประวัติสต็อกสินค้า'],
            ['en' => 'inventory_stock', 'th' => 'สต็อกสินค้า'],
            ['en' => 'issue_requisition', 'th' => 'ขอเบิกสินค้า'],
            ['en' => 'reture_issue_stock', 'th' => 'รับคืนจากการเบิก'],
            ['en' => 'receipt_planning', 'th' => 'แผนรับสินค้า'],
            ['en' => 'receive_finish_stock', 'th' => 'รับสินค้าผลิตเสร็จ'],
            ['en' => 'return_finish_stock', 'th' => 'ส่งคืนสืนค้าผลิตเสร็จ'],
            ['en' => 'tranfer_requistion', 'th' => 'ขอโอนย้ายสินค้า'],
            ['en' => 'tranfer_stock', 'th' => 'โอนย้ายสินค้า'],
            ['en' => 'beginning_balance', 'th' => 'สินค้าคงเหลือยกมา'],

            // ผังบัญชี
            ['en' => 'chart_of_account', 'th' => 'ผังบัญชี'],

            // Payroll
            ['en' => 'payroll_setting', 'th' => 'ตั้งค่าระบบเงินเดือน'],
        ];

        foreach ($group_permissions as $key => $group_perm) {
            foreach ($abilities as $akey => $ability) {
                Permission::create([
                    'name' => $ability . ' ' . $group_perm['en'],
                    'description' => ($ability == 'all' ? 'จัดการ' . $group_perm['th'] . 'ทั้งหมด' : ($ability == 'view' ? 'เข้าชม' . $group_perm['th'] : ($ability == 'create' ? 'เพิ่ม' . $group_perm['th'] : ($ability == 'edit' ? 'แก้ไข' . $group_perm['th'] : ($ability == 'delete' ? 'ลบ' . $group_perm['th'] : ''))))),
                    'group_th' => $group_perm['th'],
                    'group_en' => $group_perm['en']
                ]);
            }
        }

        Permission::create(['name' => '*', 'description' => 'Developer']);
        Permission::create(['name' => 'website_setting', 'description' => 'จัดการหน้าตั้งค่าเว็บไซต์']);
        Permission::create(['name' => 'doc_setting', 'description' => 'ตั้งค่าเอกสาร']);
        Permission::create(['name' => 'payment_setting', 'description' => 'ตั้งค่าการรับชำระเงิน']);
        Permission::create(['name' => 'approve_payrun', 'description' => 'สิทธิอนุมัติเงินเดือน']);

        $developer_role = Role::create(['name' => 'developer', 'description' => 'ผู้พัฒนาระบบ']);
        $developer_role->syncPermissions(['*']);

        $superadmin_role = Role::create(['name' => 'superadmin', 'description' => 'ผู้ดูแลระบบระดับสูง']);
        $superadmin_role->syncPermissions([
            'all user',
            'all article',
            'all member',
            'all user_history',
            'all member',
            'all role',
            'doc_setting',
            'payment_setting',
            'all payroll_salary',
            'all payroll_salary_summary',
            'all payroll_employee',
            'all payroll_department',
            'all payroll_financial_record',
            'all chart_of_account',
            //product
            'all product_category',
            'all product_type',
            'all product',
            'all product_set',
            'all unit',
            'all unit_set',
            //sale
            'all sales',
            'all sale_promotion',
            //warehouse
            'all inventory',
            'all inventory_stock_adjustment',
            'all inventory_lot',
            'all inventory_stock',
            'all inventory_stock_history',
            'all warehouse',
            'all issue_requisition',
            'all reture_issue_stock',
            'all receipt_planning',
            'all receive_finish_stock',
            'all return_finish_stock',
            'all tranfer_requistion',
            'all tranfer_stock',
            'all beginning_balance',
            'all payroll_setting',
            'website_setting',
        ]);

        $admin_role = Role::create(['name' => 'admin', 'description' => 'ผู้ดูแลระบบ']);
        $admin_role->syncPermissions([
            'all member',
            'all member_history',
            'doc_setting',
            'payment_setting',
            'all payroll_salary',
            'all payroll_salary_summary',
            'all payroll_employee',
            'all payroll_department',
            'all payroll_financial_record',
            'all chart_of_account',
            //product
            'all product_category',
            'all product_type',
            'all product',
            'all product_set',
            'all unit',
            'all unit_set',
            //sale
            'all sales',
            'all sale_promotion',
            //warehouse
            'all inventory',
            'all inventory_stock',
            'all inventory_stock_history',
            'all inventory_stock_adjustment',
            'all inventory_lot',
            'all warehouse',
            'all issue_requisition',
            'all reture_issue_stock',
            'all receipt_planning',
            'all receive_finish_stock',
            'all return_finish_stock',
            'all tranfer_requistion',
            'all tranfer_stock',
            'all beginning_balance',
            'all payroll_setting'
        ]);

        $user_role = Role::create(['name' => 'user', 'description' => 'ผู้ใช้งาน']);

        $user1 = User::factory()->create([
            'firstname' => 'พิชญสุดา',
            'lastname' => 'ชุลีวรรณ์',
            'user_code' => 'ORANGE-000',
            'slug' => 'ORANGE-000',
            'email' => 'organpcysd@gmail.com',
            'status' => 1,
            'password' => bcrypt('Organpcysd'),
        ]);

        $user2 = User::factory()->create([
            'firstname' => 'ธนัญศักดิ์',
            'lastname' => 'ปิ่นทอง',
            'user_code' => 'ORANGE-001',
            'slug' => 'ORANGE-001',
            'email' => 'thanansak123@gmail.com',
            'company_id' => '1',
            'status' => 1,
            'password' => bcrypt('thanansak'),
        ]);

        $user3 = User::factory()->create([
            'firstname' => 'N.',
            'lastname' => 'Yim',
            'user_code' => 'ORANGE-002',
            'slug' => 'ORANGE-002',
            'email' => 'naruedon@gmail.com',
            'company_id' => '1',
            'status' => 1,
            'password' => bcrypt('naruedon'),
        ]);

        $user4 = User::factory()->create([
            'firstname' => 'superadmin',
            'lastname' => 'superadmin',
            'user_code' => 'ORANGE-003',
            'slug' => 'ORANGE-003',
            'email' => 'superadmin@gmail.com',
            'company_id' => '1',
            'status' => 1,
            'password' => bcrypt('password'),
        ]);

        $user5 = User::factory()->create([
            'firstname' => 'admin',
            'lastname' => 'admin',
            'user_code' => 'ORANGE-004',
            'slug' => 'ORANGE-004',
            'email' => 'admin@gmail.com',
            'status' => 1,
            'company_id' => 1,
            'password' => bcrypt('password'),
        ]);

        $user6 = User::factory()->create([
            'firstname' => 'user',
            'lastname' => 'user',
            'user_code' => 'USER-005',
            'slug' => 'USER-005',
            'email' => 'user@gmail.com',
            'status' => 1,
            'company_id' => 1,
            'password' => bcrypt('password'),
        ]);

        $user7 = User::factory()->create([
            'firstname' => 'AUNG NAING',
            'lastname' => 'OO',
            'user_code' => 'ORANGE-006',
            'slug' => 'ORANGE-006',
            'email' => 'aungnaiu.dev@gmail.com',
            'company_id' => '1',
            'status' => 1,
            'password' => bcrypt('admin'),
        ]);
        $user8 = User::factory()->create([
            'firstname' => 'MAUNG',
            'lastname' => 'MYINT',
            'user_code' => 'ORANGE-007',
            'slug' => 'ORANGE-007',
            'email' => 'mgmyint7850@gmail.com',
            'company_id' => '1',
            'status' => 1,
            'password' => bcrypt('password'),
        ]);
        $user1->assignRole($developer_role);
        $user2->assignRole($developer_role);
        $user3->assignRole($developer_role);
        $user4->assignRole($superadmin_role);
        $user5->assignRole($admin_role);
        $user6->assignRole($user_role);
        $user7->assignRole($developer_role);
        $user8->assignRole($developer_role);
    }
}
