function msg(a){function D(){b||(s.css({opacity:0,top:B-50,left:C}),s.css("background-image","url('"+msgBoxImagePath+"msgBoxBackGround.png')"),w.css({opacity:a.opacity}),a.beforeShow(),w.css({width:$(document).width(),height:F()}),$(g+","+k).fadeIn(0),s.animate({opacity:1,top:B,left:C},200),setTimeout(a.afterShow,200),b=!0,$(window).bind("resize",function(a){var b=s.width(),c=s.height(),d=$(window).height(),e=$(window).width(),f=d/2-c/2,g=e/2-b/2;s.css({top:f,left:g})}))}function E(){b&&(a.beforeClose(),s.animate({opacity:0,top:B-50,left:C},200),w.fadeOut(300),setTimeout(function(){s.remove(),w.remove()},300),setTimeout(a.afterClose,300),b=!1)}function F(){var a=document;return Math.max(Math.max(a.body.scrollHeight,a.documentElement.scrollHeight),Math.max(a.body.offsetHeight,a.documentElement.offsetHeight),Math.max(a.body.clientHeight,a.documentElement.clientHeight))}function G(){s.fadeOut(200).fadeIn(200)}var b=!1,c=typeof a,d={content:"string"==c?a:"Message",title:"Warning",type:"alert",autoClose:!1,timeOut:0,showButtons:!0,buttons:[{value:"OK"}],inputs:[{type:"text",name:"userName",header:"User Name"},{type:"password",name:"password",header:"Password"}],success:function(a){},beforeShow:function(){},afterShow:function(){},beforeClose:function(){},afterClose:function(){},opacity:.1};if(a="string"==c?d:a,null!=a.type)switch(a.type){case"alert":a.title=null==a.title?"Warning":a.title;break;case"info":a.title=null==a.title?"Information":a.title;break;case"error":a.title=null==a.title?"Error":a.title;break;case"confirm":a.title=null==a.title?"Confirmation":a.title,a.buttons=null==a.buttons?[{value:"Yes"},{value:"No"},{value:"Cancel"}]:a.buttons;break;case"prompt":a.title=null==a.title?"Log In":a.title,a.buttons=null==a.buttons?[{value:"Login"},{value:"Cancel"}]:a.buttons;break;default:e="alert.png"}a.timeOut=null==a.timeOut?null==a.content?500:70*a.content.length:a.timeOut,a=$.extend(d,a),a.autoClose&&setTimeout(E,a.timeOut);var e="";switch(a.type){case"alert":e="alert.png";break;case"info":e="info.png";break;case"error":e="error.png";break;case"confirm":e="confirm.png";break;default:e="alert.png"}var f="msgBox"+(new Date).getTime(),g=f,h=f+"Content",i=f+"Image",j=f+"Buttons",k=f+"BackGround",l="";$(a.buttons).each(function(a,b){l+='<input class="msgButton" type="button" name="'+b.value+'" value="'+b.value+'" />'});var m="";$(a.inputs).each(function(a,b){var c=b.type;m+="checkbox"==c||"radiobutton"==c?'<div class="msgInput"><input type="'+b.type+'" name="'+b.name+'" '+(null==b.checked?"":"checked ='"+b.checked+"'")+' value="'+("undefined"==typeof b.value?"":b.value)+'" /><text>'+b.header+"</text></div>":'<div class="msgInput"><span class="msgInputHeader">'+b.header+'<span><input type="'+b.type+'" name="'+b.name+'" value="'+("undefined"==typeof b.value?"":b.value)+'" /></div>'});var s,t,u,v,w,n="<div id="+k+' class="msgBoxBackGround"></div>',o='<div class="msgBoxTitle">'+a.title+"</div>",p='<div class="msgBoxContainer"><div id='+i+' class="msgBoxImage"><img src="'+msgBoxImagePath+e+'"/></div><div id='+h+' class="msgBoxContent"><p><span>'+a.content+"</span></p></div></div>",q="<div id="+j+' class="msgBoxButtons">'+l+"</div>",r='<div class="msgBoxInputs">'+m+"</div>";"prompt"==a.type?($("html").append(n+"<div id="+g+' class="msgBox">'+o+"<div>"+p+(a.showButtons?q+"</div>":"</div>")+"</div>"),s=$("#"+g),t=$("#"+h),u=$("#"+i),v=$("#"+j),w=$("#"+k),u.remove(),v.css({"text-align":"center","margin-top":"5px"}),t.css({width:"100%",height:"100%"}),t.html(r)):($("html").append(n+"<div id="+g+' class="msgBox">'+o+"<div>"+p+(a.showButtons?q+"</div>":"</div>")+"</div>"),s=$("#"+g),t=$("#"+h),u=$("#"+i),v=$("#"+j),w=$("#"+k));var x=s.width(),y=s.height(),z=$(window).height(),A=$(window).width(),B=z/2-y/2,C=A/2-x/2;D(),$("input.msgButton").click(function(b){b.preventDefault();var c=$(this).val();if("prompt"!=a.type)a.success(c);else{var d=[];$("div.msgInput input").each(function(a,b){var c=$(this).attr("name"),e=$(this).val(),f=$(this).attr("type");"checkbox"==f||"radiobutton"==f?d.push({name:c,value:e,checked:$(this).attr("checked")}):d.push({name:c,value:e})}),a.success(c,d)}E()}),w.click(function(b){!a.showButtons||a.autoClose?E():G()})}var msgBoxImagePath="images/";jQuery.msgBox=msg;