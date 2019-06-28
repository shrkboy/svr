<div class="bg-primary navbar-dark border-right" id="sidebar-wrapper">
    <div class="sidebar-heading">
        <a class="navbar-brand" href="{{ url('/reports') }}">
            {{ "Executive Information System" }}
        </a>
    </div>

    <div class="list-group" style="width: 100%">
{{--        <a href="dashboard" class="list-group-item list-group-item-action  @if(\Illuminate\Support\Facades\Request::is('dashboard'))
                list-group-item-light @else bg-info text-white @endif" style="border: none">Dashboard</a>--}}
        <a href="reports" class="list-group-item list-group-item-action  @if(\Illuminate\Support\Facades\Request::is('reports'))
                list-group-item-light @else bg-info text-white @endif" style="border: none">Sales Visit Report</a>
    </div>
</div>