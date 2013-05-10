/**
* ownCloud - Cloudpress
*
* @author Bastien Ho (EELV - Urbancube)
* @copyleft 2012 bastienho@urbancube.fr
* @projeturl http://ecolosites.eelv.fr
*
* Free Software under creative commons licence
* http://creativecommons.org/licenses/by-nc/3.0/
* Attribution-NonCommercial 3.0 Unported (CC BY-NC 3.0)
* 
* You are free:
* to Share — to copy, distribute and transmit the work
* to Remix — to adapt the work
*
* Under the following conditions:
* Attribution — You must attribute the work in the manner specified by the author or licensor (but not in any way that
* suggests  that they endorse you or your use of the work).
* Noncommercial — You may not use this work for commercial purposes.
*
*/
function publierdocument(domain,titre,lien) {
	 var pop=window.open('http://'+domain+'/wp-admin/press-this.php?u=&t='+titre+'&s='+t('user_wordpress','File shared from')+' '+location.host+'%0D%0D'+lien+'&v=4','pop','width:400,height:500');
  $('.wordpresshare').hide();
}
function wpsharedialog(str){
  alert(str);
}
function publishdialog(sites_list,type,itemSource,file){
	
	$.ajax({
        type: 'POST',
        url: '/index.php/core/ajax/share.php?fetch=getItem&itemType='+type+'&itemSource='+itemSource+'&checkReshare=false&checkShares=true',
        dataType: 'json',
        async: false,
        success: function (k_file) {
        	file_item = k_file['data']['shares'];
			for(var the_item in file_item){
				var link = parent.location.protocol+'//'+location.host+OC.linkTo('', 'public.php')+'?service=files%26t='+file_item[the_item]['token']+'%26f='+file;
				  console.log(link);
				  
				var html='<div id="wordpresshare" class="wordpresshare"><ul>';
				for(var i=0 ; i<sites_list.length ; i++){
				  html+='<li onclick="publierdocument(\''+sites_list[i]['domain']+'\',\''+file+'\',\''+link+'\')">'+sites_list[i]['domain']+'</li>'; 
				}
				html+='</ul></div>';
				$(html).appendTo($('tr').filterAttr('data-file',file).find('td.filename'));
				$('#wordpresshare').animate({height:'toggle'},1,
					function(){$(this).css('opacity','1').animate({height:'toggle'},500)
				});			
				break;
			}
        }
		
		
      });
	
      
}

$(document).ready(function () {
  var b = {};
  if (typeof FileActions !== 'undefined' && $('#dir').length>0) {
    
    FileActions.register('file', t('user_wordpress','Publish'), OC.PERMISSION_READ, function (file) {
      return OC.imagePath('user_wordpress', 'publish.png');
    }, function (file) {
    	if($('#wordpresshare').length>0){
	    	$('#wordpresshare').animate({height:0},500,function(){ $(this).remove()});
	    }
	    else{
		      //var r = $('#file').val() + '/' + d;
		      var filepath = $('#dir').val() + '/' + file;
		      $.ajax({
		        type: 'POST',
		        url: OC.linkTo('user_wordpress', 'ajax/sites.php?=f='+file),
		        dataType: 'json',
		        async: false,
		        success: function (sites_list) {
		          // Create a private link
					var itemSource = $('tr').filterAttr('data-file', String(file)).data('id');
					var type = $('tr').filterAttr('data-file', String(file)).data('type');
					
					the_item=OC.Share.loadItem(type,itemSource);
				
					//notshared
					if(the_item.shares.length==0){
					
						OC.Share.share(type, itemSource, OC.Share.SHARE_TYPE_LINK, '', OC.PERMISSION_READ, function() {
							publishdialog(sites_list,type,itemSource,file)
						});
					}
					else{
						//console.log('shared');
						publishdialog(sites_list,type,itemSource,file);	
					}
		        }			
				
		      });
      }	  
    });
    
  };
  
});