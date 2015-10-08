(function($){
      $.fn.grvLiveModal = function(options) {  
        var record = $(this),body = $('body'), ovrlay = $('.overlay');
        var defaults = {  
         auto:true,  
         event:'click',
         post:false,
         content:false,
         element:false,
         callback:false
        };  
      var options = $.extend(defaults, options);  
         return this.each(function() { 
            function init(){
              if (ovrlay.length > 0) {
                ovrlay.show();
              }else{
                  var overlay = $('<div>').addClass('overlay');
                  overlay.css({'top':'0','display':'none','opacity':'.5','left':'0','width':'100%','height':'100%','background-color':'#000','text-align':'center'});
                  body.append(overlay);
                  overlay.fadeIn(1000);
                }
                if($(document).find('.content-wrap').lenght){
                  
                }else{
                    var contentWrap = $('<div>').addClass('content-wrap').height(options.height).width(options.width);
                    $('.overlay').after(contentWrap);
                }
                if(options.post)
                    loadPostContent();
                else if(options.content)
                    loadContent();
                else if(options.element)
                    loadElementContent();
            }
            
            function loadPostContent(){
                $.post(options.url,options.data,function(r){ r=$.parseJSON(r);
                    if(r){
                      options.content = new EJS({url: '/scripts/templates/'+options.tpl+'.ejs'}).render({photo:r});
                      loadContent();
                    }
                });
            }
            
            function loadContent(){
                
                    $('.content-wrap').html(options.content).center();
                    $('.xi img').each(function(){
                        $(this).attr('isrc',$(this).attr('src'));
                        $(this).attr('src','http://wwwalls.com/static/images/ld.gif');
                    });
                
                $('.xi img').load(function(){
                    $(this).attr('src',$(this).attr('isrc'));
                })
                if(options.callback)options.callback();
            }
            
            function loadElementContent(){
                if($(document).find('.content-wrap').lenght){
                    $('.content-wrap').html(options.content).center();
                }else{
                      var contentWrap = $('<div>').addClass('content-wrap');
                      $('.overlay').after(contentWrap);
                      $('.content-wrap').html(options.content).center();
                }
                callback();
            }
            $(document).on('click','.overlay',function(){
//            ovrlay.on('click',function(){
              $(this).hide();
              $('.content-wrap').remove();
            });
            
            $(window).resize(function(){
                $('.content-wrap').center();
            });
            
            $(window).scroll(function(){
                $('.content-wrap').center()
                $('.content-wrap').animate({
                    top:Math.max(0, (($(window).height() - this.outerHeight()) / 2)+$(window).scrollTop()) + "px",
                    left:Math.max(0, (($(window).width() - this.outerWidth()) / 2)+$(window).scrollLeft()) + "px"
                },{
                    duration:400,
                    easing:'swing'
                }
                ).clearQueue();
            });
            
            init();
         });  
         
      };  
      
      
  })(jQuery);  
  
(function($){$.fn.center = function () {
this.css("position","absolute");
this.css("top", Math.max(0, (($(window).height() - this.outerHeight()) / 2) + $(window).scrollTop()) + "px");
this.css("left", Math.max(0, (($(window).width() - this.outerWidth()) / 2) + $(window).scrollLeft()) + "px");
return this;
}})(jQuery);  