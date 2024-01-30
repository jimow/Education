<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 18,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 19,
                'title' => 'user_alert_create',
            ],
            [
                'id'    => 20,
                'title' => 'user_alert_show',
            ],
            [
                'id'    => 21,
                'title' => 'user_alert_delete',
            ],
            [
                'id'    => 22,
                'title' => 'user_alert_access',
            ],
            [
                'id'    => 23,
                'title' => 'setting_access',
            ],
            [
                'id'    => 24,
                'title' => 'county_create',
            ],
            [
                'id'    => 25,
                'title' => 'county_edit',
            ],
            [
                'id'    => 26,
                'title' => 'county_show',
            ],
            [
                'id'    => 27,
                'title' => 'county_delete',
            ],
            [
                'id'    => 28,
                'title' => 'county_access',
            ],
            [
                'id'    => 29,
                'title' => 'constituency_create',
            ],
            [
                'id'    => 30,
                'title' => 'constituency_edit',
            ],
            [
                'id'    => 31,
                'title' => 'constituency_show',
            ],
            [
                'id'    => 32,
                'title' => 'constituency_delete',
            ],
            [
                'id'    => 33,
                'title' => 'constituency_access',
            ],
            [
                'id'    => 34,
                'title' => 'ward_create',
            ],
            [
                'id'    => 35,
                'title' => 'ward_edit',
            ],
            [
                'id'    => 36,
                'title' => 'ward_show',
            ],
            [
                'id'    => 37,
                'title' => 'ward_delete',
            ],
            [
                'id'    => 38,
                'title' => 'ward_access',
            ],
            [
                'id'    => 39,
                'title' => 'principal_create',
            ],
            [
                'id'    => 40,
                'title' => 'principal_edit',
            ],
            [
                'id'    => 41,
                'title' => 'principal_show',
            ],
            [
                'id'    => 42,
                'title' => 'principal_delete',
            ],
            [
                'id'    => 43,
                'title' => 'principal_access',
            ],
            [
                'id'    => 44,
                'title' => 'school_gender_type_create',
            ],
            [
                'id'    => 45,
                'title' => 'school_gender_type_edit',
            ],
            [
                'id'    => 46,
                'title' => 'school_gender_type_show',
            ],
            [
                'id'    => 47,
                'title' => 'school_gender_type_delete',
            ],
            [
                'id'    => 48,
                'title' => 'school_gender_type_access',
            ],
            [
                'id'    => 49,
                'title' => 'school_category_create',
            ],
            [
                'id'    => 50,
                'title' => 'school_category_edit',
            ],
            [
                'id'    => 51,
                'title' => 'school_category_show',
            ],
            [
                'id'    => 52,
                'title' => 'school_category_delete',
            ],
            [
                'id'    => 53,
                'title' => 'school_category_access',
            ],
            [
                'id'    => 54,
                'title' => 'school_create',
            ],
            [
                'id'    => 55,
                'title' => 'school_edit',
            ],
            [
                'id'    => 56,
                'title' => 'school_show',
            ],
            [
                'id'    => 57,
                'title' => 'school_delete',
            ],
            [
                'id'    => 58,
                'title' => 'school_access',
            ],
            [
                'id'    => 59,
                'title' => 'school_stream_create',
            ],
            [
                'id'    => 60,
                'title' => 'school_stream_edit',
            ],
            [
                'id'    => 61,
                'title' => 'school_stream_show',
            ],
            [
                'id'    => 62,
                'title' => 'school_stream_delete',
            ],
            [
                'id'    => 63,
                'title' => 'school_stream_access',
            ],
            [
                'id'    => 64,
                'title' => 'student_form_create',
            ],
            [
                'id'    => 65,
                'title' => 'student_form_edit',
            ],
            [
                'id'    => 66,
                'title' => 'student_form_show',
            ],
            [
                'id'    => 67,
                'title' => 'student_form_delete',
            ],
            [
                'id'    => 68,
                'title' => 'student_form_access',
            ],
            [
                'id'    => 69,
                'title' => 'student_create',
            ],
            [
                'id'    => 70,
                'title' => 'student_edit',
            ],
            [
                'id'    => 71,
                'title' => 'student_show',
            ],
            [
                'id'    => 72,
                'title' => 'student_delete',
            ],
            [
                'id'    => 73,
                'title' => 'student_access',
            ],
            [
                'id'    => 74,
                'title' => 'student_transfer_create',
            ],
            [
                'id'    => 75,
                'title' => 'student_transfer_edit',
            ],
            [
                'id'    => 76,
                'title' => 'student_transfer_show',
            ],
            [
                'id'    => 77,
                'title' => 'student_transfer_delete',
            ],
            [
                'id'    => 78,
                'title' => 'student_transfer_access',
            ],
            [
                'id'    => 79,
                'title' => 'year_create',
            ],
            [
                'id'    => 80,
                'title' => 'year_edit',
            ],
            [
                'id'    => 81,
                'title' => 'year_show',
            ],
            [
                'id'    => 82,
                'title' => 'year_delete',
            ],
            [
                'id'    => 83,
                'title' => 'year_access',
            ],
            [
                'id'    => 84,
                'title' => 'school_attendance_create',
            ],
            [
                'id'    => 85,
                'title' => 'school_attendance_edit',
            ],
            [
                'id'    => 86,
                'title' => 'school_attendance_show',
            ],
            [
                'id'    => 87,
                'title' => 'school_attendance_delete',
            ],
            [
                'id'    => 88,
                'title' => 'school_attendance_access',
            ],
            [
                'id'    => 89,
                'title' => 'bursary_create',
            ],
            [
                'id'    => 90,
                'title' => 'bursary_edit',
            ],
            [
                'id'    => 91,
                'title' => 'bursary_show',
            ],
            [
                'id'    => 92,
                'title' => 'bursary_delete',
            ],
            [
                'id'    => 93,
                'title' => 'bursary_access',
            ],
            [
                'id'    => 94,
                'title' => 'report_form_create',
            ],
            [
                'id'    => 95,
                'title' => 'report_form_edit',
            ],
            [
                'id'    => 96,
                'title' => 'report_form_show',
            ],
            [
                'id'    => 97,
                'title' => 'report_form_delete',
            ],
            [
                'id'    => 98,
                'title' => 'report_form_access',
            ],
            [
                'id'    => 99,
                'title' => 'student_bursary_register_create',
            ],
            [
                'id'    => 100,
                'title' => 'student_bursary_register_edit',
            ],
            [
                'id'    => 101,
                'title' => 'student_bursary_register_show',
            ],
            [
                'id'    => 102,
                'title' => 'student_bursary_register_delete',
            ],
            [
                'id'    => 103,
                'title' => 'student_bursary_register_access',
            ],
            [
                'id'    => 104,
                'title' => 'school_permission_create',
            ],
            [
                'id'    => 105,
                'title' => 'school_permission_edit',
            ],
            [
                'id'    => 106,
                'title' => 'school_permission_show',
            ],
            [
                'id'    => 107,
                'title' => 'school_permission_delete',
            ],
            [
                'id'    => 108,
                'title' => 'school_permission_access',
            ],
            [
                'id'    => 109,
                'title' => 'termsetting_create',
            ],
            [
                'id'    => 110,
                'title' => 'termsetting_edit',
            ],
            [
                'id'    => 111,
                'title' => 'termsetting_show',
            ],
            [
                'id'    => 112,
                'title' => 'termsetting_delete',
            ],
            [
                'id'    => 113,
                'title' => 'termsetting_access',
            ],
            [
                'id'    => 114,
                'title' => 'student_count_per_term_access',
            ],
            [
                'id'    => 115,
                'title' => 'fee_balance_access',
            ],
            [
                'id'    => 116,
                'title' => 'fee_balance_school_access',
            ],
            [
                'id'    => 117,
                'title' => 'other_setting_create',
            ],
            [
                'id'    => 118,
                'title' => 'other_setting_edit',
            ],
            [
                'id'    => 119,
                'title' => 'other_setting_show',
            ],
            [
                'id'    => 120,
                'title' => 'other_setting_delete',
            ],
            [
                'id'    => 121,
                'title' => 'other_setting_access',
            ],
            [
                'id'    => 122,
                'title' => 'allocation_create',
            ],
            [
                'id'    => 123,
                'title' => 'allocation_edit',
            ],
            [
                'id'    => 124,
                'title' => 'allocation_show',
            ],
            [
                'id'    => 125,
                'title' => 'allocation_delete',
            ],
            [
                'id'    => 126,
                'title' => 'allocation_access',
            ],
            [
                'id'    => 127,
                'title' => 'payment_access',
            ],
            [
                'id'    => 128,
                'title' => 'student_managent_access',
            ],
            [
                'id'    => 129,
                'title' => 'school_management_access',
            ],
            [
                'id'    => 130,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
