		<!--BEGIN #sidebar .aside-->
		<div id="sidebar" class="aside">
			
			<?php	/* Widgetised Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Sidebar Page') ) ?>
			
			<!-- BEGIN #sidebar-narrow-container -->
			<div id="sidebar-narrow-container" class="clearfix">
			
				<!-- BEGIN .sidebar-narrow -->
				<div class="sidebar-narrow alignleft">
				
					<?php	/* Widgetised Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Narrow Left Page') ) ?>
				
				<!-- END .sidebar-narrow -->
				</div>
				
				<!-- BEGIN .sidebar-narrow -->
				<div class="sidebar-narrow alignright">
				
					<?php	/* Widgetised Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Narrow Right Page') ) ?>
				
				<!-- END .sidebar-narrow -->
				</div>
				
			
			<!-- END .sidebar-narrow -->
			</div>
		
		<!--END #sidebar .aside-->
		</div>