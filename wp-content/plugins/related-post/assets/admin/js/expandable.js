jQuery(document).ready(function($)
	{

		$(document).on('click', '.expandable .expand-collapse', function()
			{
				if($(this).parent().parent().hasClass('active'))
					{
						$(this).parent().parent().removeClass('active');
					}
				else
					{
						$(this).parent().parent().addClass('active');	
					}
				
			
			})	
			
			
		$(document).on('click', '.expandable .remove', function()
			{
				$(this).parent().parent().remove();
				
			
			})				
			
			
			
			



		



	});	







