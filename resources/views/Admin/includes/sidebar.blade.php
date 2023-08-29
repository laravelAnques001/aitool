<!-- Main sidebar -->
<div class="sidebar sidebar-main">
    <div class="sidebar-content">
        <!-- Main navigation -->
        <div class="sidebar-category sidebar-category-visible">
            <div class="category-content no-padding">
                <ul class="navigation navigation-main navigation-accordion">
                    <li class="{{ Route::currentRouteName() == 'catagory.*' ? 'active' : '' }}"><a
                            href="{{ route('dashboard') }}"><i class="icon-home4"></i> <span>DashBoard</span></a>
                    </li>
                    <li class="{{ Route::currentRouteName() == 'tool.*' ? 'active' : '' }}"><a
                            href="{{ route('tool.index') }}"><i class="icon-wrench"></i>
                            <span>Tools</span></a>
                    </li>
                    <li class="{{ Route::currentRouteName() == 'generator.*' ? 'active' : '' }}"><a
                            href="{{ route('generator.index') }}"><i class="icon-books"></i>
                            <span>Generator</span></a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /main navigation -->

    </div>
</div>
<!-- /main sidebar -->
