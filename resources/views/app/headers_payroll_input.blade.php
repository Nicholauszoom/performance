<ul class="nav nav-tabs nav-tabs-underline nav-justified mb-3" id="tabs-target-right" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="{{ url('/flex/financial_group')}}" class="nav-link{{ Request::is('flex/financial_group*') ? ' active' : '' }}" aria-selected="false" role="tab" tabindex="-1">
            <i class="ph-package me-2"></i>
            Packages
        </a>
    </li>

    <li class="nav-item" role="presentation">
        <a href="{{ url('/flex/allowance_overtime')}}" class="nav-link{{ Request::is('flex/allowance_overtime*') || Request::is('flex/overtime_category_info*') ? ' active' : '' }}" aria-selected="false" role="tab" tabindex="-1">
            <i class="ph-timer me-2"></i>
            Overtimes
        </a>
    </li>

    <li class="nav-item" role="presentation">
        <a href="{{ url('/flex/allowance')}}" class="nav-link{{ Request::is('flex/allowance') ? ' active' : '' }}{{ Request::is('flex/allowance_info*') ? ' active' : '' }}" aria-selected="false" role="tab" tabindex="-1">
            <i class="ph-plus-circle me-2"></i>
            Allowances
        </a>
    </li>

    <li class="nav-item" role="presentation">
        <a href="{{ url('/flex/statutory_deductions')}}" class="nav-link{{ Request::is('flex/statutory_deductions*') ? ' active' : '' }}" aria-selected="false" role="tab" tabindex="-1">
            <i class="ph-minus-circle me-2"></i>
            Statutory Deductions
        </a>
    </li>

    <li class="nav-item" role="presentation">
        <a href="{{ url('/flex/non_statutory_deductions')}}" class="nav-link{{ Request::is('flex/non_statutory_deductions*') ? ' active' : '' }}" aria-selected="false" role="tab" tabindex="-1">
            <i class="ph-minus me-2"></i>
            Non Statutory Deductions
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="{{ url('/flex/allowance_category')}}" class="nav-link{{ Request::is('flex/allowance_category*') ? ' active' : '' }}" aria-selected="false" role="tab" tabindex="-1">
            <i class="ph-git-branch me-2"></i>
            Allowance Categories
        </a>
    </li>
</ul>
