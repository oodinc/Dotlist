<div class="sidebar">
  <ul class="nav-list">
    <li class="{{ Request::is('tasks.index') ? 'active' : '' }}">
      <a href="{{ route('tasks.index') }}">
        <i class="bi bi-calendar2-check"></i>
        <span class="link_name">@lang('sidebar.today')</span>
      </a>
      <span class="tooltip shadow-sm shadow-sm">@lang('sidebar.today')</span>
    </li>
    
    <li class="{{ Request::is('tasks.priority') ? 'active' : '' }}">
      <a href="{{ route('tasks.priority') }}">
        <i class="bi bi-exclamation-square"></i>
        <span class="link_name">@lang('sidebar.priority')</span>
      </a>
      <span class="tooltip shadow-sm">@lang('sidebar.priority')</span>
    </li>
    
    <li class="{{ Request::is('tasks.upcoming') ? 'active' : '' }}">
      <a href="{{ route('tasks.upcoming') }}">
        <i class="bi bi-calendar2-week"></i>
        <span class="link_name">@lang('sidebar.upcoming')</span>
      </a>
      <span class="tooltip shadow-sm">@lang('sidebar.upcoming')</span>
    </li>

    <li class="{{ Request::is('tasks.labels') ? 'active' : '' }}">
      <a href="{{ route('tasks.labels') }}">
        <i class="bi bi-tags"></i>
        <span class="link_name">@lang('sidebar.labels')</span>
      </a>
      <span class="tooltip shadow-sm">@lang('sidebar.labels')</span>
    </li>

    <li class="{{ Request::is('tasks.history') ? 'active' : '' }}">
      <a href="{{ route('tasks.history') }}">
        <i class="bi bi-clock-history"></i>
        <span class="link_name">@lang('sidebar.history')</span>
      </a>
      <span class="tooltip shadow-sm">@lang('sidebar.history')</span>
    </li>
  </ul>
  <div class="copyright">
    <p title="&copy; <?php echo date("Y"); ?> UdinTechnology. All rights reserved.">&copy; <?php echo date("Y"); ?> @lang('sidebar.UdinTechnology. All rights reserved')</p>
  </div>
</div>