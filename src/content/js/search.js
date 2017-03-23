function Get_More_Search (e) {
   
        $.ajax({
			type 	 : "GET",
			dataType : 'json',
			async  	 : false,
			url 	 : "/api/more_search/",
			
			data: ({nextpage 	: $(e).data('nextpage'), keyword : $(e).data('search')}),
			
			success: function(data){
			    
				if(data.ok){
                    $(".btn_more").remove();
                    $('.search_list').append(data.data);
				}
				return false;
			}
        
        });
}