<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li>
            <select class="searchable-field form-control">

            </select>
        </li>
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/users*") ? "c-show" : "" }} {{ request()->is("admin/audit-logs*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('audit_log_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.audit-logs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/audit-logs") || request()->is("admin/audit-logs/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-file-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.auditLog.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('user_alert_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.user-alerts.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/user-alerts") || request()->is("admin/user-alerts/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-bell c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userAlert.title') }}
                </a>
            </li>
        @endcan
        @can('setting_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/wards*") ? "c-show" : "" }} {{ request()->is("admin/constituencies*") ? "c-show" : "" }} {{ request()->is("admin/counties*") ? "c-show" : "" }} {{ request()->is("admin/years*") ? "c-show" : "" }} {{ request()->is("admin/termsettings*") ? "c-show" : "" }} {{ request()->is("admin/other-settings*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.setting.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('ward_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.wards.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/wards") || request()->is("admin/wards/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-angle-right c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.ward.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('constituency_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.constituencies.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/constituencies") || request()->is("admin/constituencies/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.constituency.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('county_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.counties.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/counties") || request()->is("admin/counties/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-closed-captioning c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.county.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('year_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.years.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/years") || request()->is("admin/years/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.year.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('termsetting_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.termsettings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/termsettings") || request()->is("admin/termsettings/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.termsetting.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('other_setting_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.other-settings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/other-settings") || request()->is("admin/other-settings/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.otherSetting.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('payment_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/student-bursary-registers*") ? "c-show" : "" }} {{ request()->is("admin/bursaries*") ? "c-show" : "" }} {{ request()->is("admin/fee-balances*") ? "c-show" : "" }} {{ request()->is("admin/fee-balance-schools*") ? "c-show" : "" }} {{ request()->is("admin/allocations*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.payment.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('student_bursary_register_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.student-bursary-registers.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/student-bursary-registers") || request()->is("admin/student-bursary-registers/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.studentBursaryRegister.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('bursary_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.bursaries.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/bursaries") || request()->is("admin/bursaries/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.bursary.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('fee_balance_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.fee-balances.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/fee-balances") || request()->is("admin/fee-balances/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.feeBalance.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('fee_balance_school_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.fee-balance-schools.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/fee-balance-schools") || request()->is("admin/fee-balance-schools/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.feeBalanceSchool.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('allocation_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.allocations.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/allocations") || request()->is("admin/allocations/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.allocation.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('student_managent_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/student-forms*") ? "c-show" : "" }} {{ request()->is("admin/students*") ? "c-show" : "" }} {{ request()->is("admin/student-transfers*") ? "c-show" : "" }} {{ request()->is("admin/report-forms*") ? "c-show" : "" }} {{ request()->is("admin/student-count-per-terms*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-user-graduate c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.studentManagent.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('student_form_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.student-forms.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/student-forms") || request()->is("admin/student-forms/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.studentForm.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('student_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.students.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/students") || request()->is("admin/students/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user-graduate c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.student.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('student_transfer_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.student-transfers.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/student-transfers") || request()->is("admin/student-transfers/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.studentTransfer.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('report_form_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.report-forms.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/report-forms") || request()->is("admin/report-forms/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.reportForm.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('student_count_per_term_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.student-count-per-terms.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/student-count-per-terms") || request()->is("admin/student-count-per-terms/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.studentCountPerTerm.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('school_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/school-gender-types*") ? "c-show" : "" }} {{ request()->is("admin/school-streams*") ? "c-show" : "" }} {{ request()->is("admin/school-categories*") ? "c-show" : "" }} {{ request()->is("admin/school-permissions*") ? "c-show" : "" }} {{ request()->is("admin/schools*") ? "c-show" : "" }} {{ request()->is("admin/principals*") ? "c-show" : "" }} {{ request()->is("admin/school-attendances*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-school c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.schoolManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('school_gender_type_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.school-gender-types.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/school-gender-types") || request()->is("admin/school-gender-types/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.schoolGenderType.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('school_stream_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.school-streams.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/school-streams") || request()->is("admin/school-streams/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.schoolStream.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('school_category_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.school-categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/school-categories") || request()->is("admin/school-categories/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.schoolCategory.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('school_permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.school-permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/school-permissions") || request()->is("admin/school-permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.schoolPermission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('school_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.schools.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/schools") || request()->is("admin/schools/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-graduation-cap c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.school.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('principal_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.principals.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/principals") || request()->is("admin/principals/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.principal.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('school_attendance_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.school-attendances.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/school-attendances") || request()->is("admin/school-attendances/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.schoolAttendance.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @php($unread = \App\Models\QaTopic::unreadCount())
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.messenger.index") }}" class="{{ request()->is("admin/messenger") || request()->is("admin/messenger/*") ? "c-active" : "" }} c-sidebar-nav-link">
                    <i class="c-sidebar-nav-icon fa-fw fa fa-envelope">

                    </i>
                    <span>{{ trans('global.messages') }}</span>
                    @if($unread > 0)
                        <strong>( {{ $unread }} )</strong>
                    @endif

                </a>
            </li>
            @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                @can('profile_password_edit')
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                            <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                            </i>
                            {{ trans('global.change_password') }}
                        </a>
                    </li>
                @endcan
            @endif
            <li class="c-sidebar-nav-item">
                <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
    </ul>

</div>