<li class="{{ Request::is('businesses*') ? 'active' : '' }}">
    <a href="{!! route('admin.businesses.index') !!}"><i class="fa fa-edit"></i><span>Businesses</span></a>
</li>

<li class="{{ Request::is('regions*') ? 'active' : '' }}">
    <a href="{!! route('regions.index') !!}"><i class="fa fa-edit"></i><span>Regions</span></a>
</li>

<li class="{{ Request::is('indicators*') ? 'active' : '' }}">
    <a href="{!! route('indicators.index') !!}"><i class="fa fa-edit"></i><span>Indicators</span></a>
</li>

