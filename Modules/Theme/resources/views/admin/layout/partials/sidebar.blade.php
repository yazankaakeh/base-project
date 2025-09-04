<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                @can('admin.dashboard.index')
                    <li class="submenu-open">
                        <h6 class="submenu-hdr">{{trans('core::core.sidebar.dashboard')}}</h6>
                        <ul>
                            <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
                                <a href="{{ route('admin.dashboard.index') }}">
                                    <i data-feather="inbox"></i>
                                    <span>
                                    {{trans('core::core.sidebar.dashboard')}}
                                </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @canany('admin.payments.index', 'admin.payments.create', 'admin.payments.refund')
                    <li class="submenu-open">
                        <h6 class="submenu-hdr">{{trans('core::core.sidebar.payments')}}</h6>
                        <ul>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                   class="{{ Request::is('admin/payment/refund','admin/show/*','admin/payment','admin/payment/create') ? 'active subdrop' : '' }}">
                                    <i data-feather="grid"></i>
                                    <span>
                                    {{trans('core::core.sidebar.payments')}}
                                </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    @can('admin.payments.index')
                                        <li>
                                            <a href="{{ route('admin.payments.index') }}"
                                               class="{{ Request::is('admin/payment') ? 'active' : '' }}">
                                                {{trans('core::core.sidebar.payments')}}

                                            </a>
                                        </li>
                                    @endcan
                                    @can('admin.payments.create')
                                        <li>
                                            <a href="{{ route('admin.payments.create') }}"
                                               class="{{ Request::is('admin/payment/create') ? 'active' : '' }}">
                                                {{trans('core::core.sidebar.createPayment')}}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('admin.payments.refund')
                                        <li>
                                            <a href="{{ route('admin.payments.refund') }}"
                                               class="{{ Request::is('admin/payment/refund') ? 'active' : '' }}">
                                                {{trans('core::core.sidebar.refund')}}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endcanany
                @canany('admin.accounting.paymentReports', 'admin.accounting.extractsReports', 'admin.accounting.consensusReports', 'admin.accounting.protectionAccountReport','admin.accounting.paMoneyTransfer')
                    <li class="submenu-open">
                        <h6 class="submenu-hdr">{{trans('core::core.sidebar.accounting')}}</h6>
                        <ul>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                   class="{{ Request::is('admin/accounting/payment/report','admin/accounting/extracts/report'
                               ,'admin/accounting/consensus/report'
                               ,'admin/accounting/consensus/PAMoneyTransfer'
                               ,'admin/accounting/consensus/PAR') ? 'active subdrop' : '' }}">
                                    <i data-feather="grid"></i>
                                    <span>
                                    {{trans('core::core.sidebar.accounting')}}
                                </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    @can('admin.accounting.paymentReports')
                                        <li>
                                            <a href="{{ route('admin.accounting.paymentReports') }}"
                                               class="{{ Request::is('admin/accounting/payment/report') ? 'active' : '' }}">
                                                {{trans('core::core.sidebar.paymentReports')}}

                                            </a>
                                        </li>
                                    @endcan
                                    @can('admin.accounting.extractsReports')
                                        <li>
                                            <a href="{{ route('admin.accounting.extractsReports') }}"
                                               class="{{ Request::is('admin/accounting/extracts/report') ? 'active' : '' }}">
                                                {{trans('core::core.sidebar.extracts')}}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('admin.accounting.consensusReports')
                                        <li>
                                            <a href="{{ route('admin.accounting.consensusReports') }}"
                                               class="{{ Request::is('admin/accounting/consensus/report') ? 'active' : '' }}">
                                                {{trans('core::core.sidebar.consensus')}}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('admin.accounting.protectionAccountReport')
                                        <li>
                                            <a href="{{ route('admin.accounting.protectionAccountReport') }}"
                                               class="{{ Request::is('admin/accounting/consensus/PAR') ? 'active' : '' }}">
                                                {{trans('core::core.sidebar.protectionAccountReport')}}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('admin.accounting.paMoneyTransfer')
                                        <li>
                                            <a href="{{ route('admin.accounting.paMoneyTransfer') }}"
                                               class="{{ Request::is('admin/accounting/consensus/PAMoneyTransfer') ? 'active' : '' }}">
                                                {{trans('core::core.sidebar.paMoneyTransfer')}}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endcanany
                @can('admin.client.index')
                    <li class="submenu-open">
                        <h6 class="submenu-hdr">{{trans('core::core.sidebar.clients')}}</h6>
                        <ul>
                            <li class="{{ Request::is('admin/client', 'admin/client/create', 'admin/client/show/*') ? 'active' : '' }}">
                                <a href="{{ route('admin.client.index') }}">
                                    <i data-feather="inbox"></i>
                                    <span>
                                    {{trans('core::core.sidebar.userManagement')}}
                                </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @canany('admin.frauds.index', 'admin.frauds.fraudScenario')
                    <li class="submenu-open">
                        <h6 class="submenu-hdr">{{trans('core::core.sidebar.posFraudManagement')}}</h6>
                        <ul>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                   class="{{ Request::is('admin/frauds','admin/frauds/fraudScenario') ? 'active subdrop' : '' }}">
                                    <i data-feather="grid"></i>
                                    <span>
                                    {{trans('core::core.sidebar.fraudManagement')}}

                                </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    @can('admin.frauds.index')
                                        <li>
                                            <a href="{{ route('admin.frauds.index') }}"
                                               class="{{ Request::is('admin/frauds') ? 'active' : '' }}">
                                                {{trans('core::core.sidebar.fraudTransactions')}}

                                            </a>
                                        </li>
                                    @endcan
                                    @can('admin.frauds.fraudScenario')
                                        <li>
                                            <a href="{{ route('admin.frauds.fraudScenario') }}"
                                               class="{{ Request::is('admin/frauds/fraudScenario') ? 'active' : '' }}">
                                                {{trans('core::core.sidebar.fraudScenarios')}}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endcanany
                @can('admin.complaints.index')
                    <li class="submenu-open">
                        <h6 class="submenu-hdr">{{trans('core::core.sidebar.complaints')}}</h6>
                        <ul>
                            <li>
                                <a href="{{ route('admin.complaints.index') }}"
                                   class="{{ Request::is('admin/complaints') ? 'active' : '' }}">
                                    <i data-feather="grid"></i>
                                    {{trans('core::core.sidebar.complaints')}}
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @canany('admin.banks.index', 'admin.agreements.index', 'admin.documents.index')
                    <li class="submenu-open">
                        <h6 class="submenu-hdr">{{trans('core::core.sidebar.POSSettings')}}</h6>
                        <ul>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                   class="{{ Request::is('admin/banks','admin/agreements','admin/complaints','admin/documents') ? 'active subdrop' : '' }}">
                                    <i data-feather="grid"></i>
                                    <span>
                                    {{trans('core::core.sidebar.POSSettings')}}
                                </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    @can('admin.banks.index')
                                        <li>
                                            <a href="{{ route('admin.banks.index') }}"
                                               class="{{ Request::is('admin/banks') ? 'active' : '' }}">
                                                {{trans('core::core.sidebar.banks')}}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('admin.agreements.index')
                                        <li>
                                            <a href="{{ route('admin.agreements.index') }}"
                                               class="{{ Request::is('admin/agreements') ? 'active' : '' }}">
                                                {{trans('core::core.sidebar.agreements')}}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('admin.documents.index')
                                        <li>
                                            <a href="{{ route('admin.documents.index') }}"
                                               class="{{ Request::is('admin/documents') ? 'active' : '' }}">
                                                {{trans('core::core.sidebar.documents')}}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endcanany
                @canany('admin.user_management.index', 'admin.role_management.index', 'admin.env.getEnv', 'admin.audits.index')
                    <li class="submenu-open">
                        <h6 class="submenu-hdr">
                            {{trans('core::core.sidebar.settings')}}
                        </h6>
                        <ul>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                   class="{{ Request::is('admin/role-management', 'admin/user-management','admin/role-management/create' ,'admin/role-management/*/edit') ? 'active subdrop' : '' }}">
                                    <i data-feather="grid"></i>
                                    <span>
                                    {{trans('core::core.sidebar.adminManagement')}}
                                </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    @can('admin.user_management.index')
                                        <li>
                                            <a href="{{ route('admin.user_management.index') }}"
                                               class="{{ Request::is('admin/user-management') ? 'active' : '' }}">
                                                {{trans('core::core.sidebar.adminManagement')}}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('admin.role_management.index')
                                        <li>
                                            <a href="{{ route('admin.role_management.index') }}"
                                               class="{{ Request::is('admin/role-management','admin/role-management/create' ,'admin/role-management/*/edit') ? 'active' : '' }}">
                                                {{trans('core::core.sidebar.roles')}}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                   class="{{ Request::is('admin/get/env', 'admin/audit-log') ? 'active subdrop' : '' }}">
                                    <i data-feather="grid"></i>
                                    <span>
                                    {{trans('core::core.sidebar.settings')}}

                                </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    @can('admin.env.getEnv')
                                        <li><a href="{{ route('admin.env.getEnv') }}"
                                               class="{{ Request::is('admin/get/env') ? 'active' : '' }}">
                                                {{trans('core::core.sidebar.updateSMTP')}}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('admin.audits.index')
                                        <li><a href="{{ route('admin.audits.index') }}"
                                               class="{{ Request::is('admin/audit-log') ? 'active' : '' }}">
                                                {{trans('core::core.sidebar.auditingLog')}}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>

                        </ul>
                    </li>
                @endcanany
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
