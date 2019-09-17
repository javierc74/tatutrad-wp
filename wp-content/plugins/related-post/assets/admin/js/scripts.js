
jQuery(document).ready(function($)
	{
		
		jQuery('.related-post-color').wpColorPicker();


		
		$(document).on('click', '.related-post-admin .tab-nav li', function()
			{
				$(".active").removeClass("active");
				$(this).addClass("active");
				
				var nav = $(this).attr("nav");
				
				$(".box li.tab-box").css("display","none");
				$(".box"+nav).css("display","block");
		
			})




		$(document).on('click', ".suggest-post-list .item", function() {
			
			//alert('Hello');
			
			post_id = $(this).attr('post_id');
			post_title = $(this).attr('post_title');
			
			html = '<div class="items"><div class="header"><span class="remove rt-tooltip tooltipstered"><i class="fa fa-times"></i></span><span class="move rt-tooltip tooltipstered"><i class="fa fa-bars"></i></span><span class="title">'+post_title+'</span></div><input type="hidden" name="related_post_ids[]" value="'+post_id+'" /></div>';
			
			$('.related-post-meta .expandable').append(html);
		})



		$(document).on('keyup', ".related-post-meta .related_post_get_ids", function() {
			
			//alert('Hello');
			
			post_id = $(this).attr('post_id');
			title = $(this).val();
			
			$.ajax(
				{
			type: 'POST',
			context: this,
			url:related_post_ajax.related_post_ajaxurl,
			data: {
				"action"	: "related_post_ajax_get_post_ids", 
				"title"		: title,
				"post_id"	: post_id,
			},
			success: function(data) {
					
						
						var response = JSON.parse(data)
						
						html = response['html'];
						//console.log(html);
			
						$('.suggest-post-list').html(html);
		
					}
				});
			
			
			})












	});	







