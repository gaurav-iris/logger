function trimSlash(site){return site.replace(/\/$/, "");}
function site(url){return config.home+url;}
function is_email(email) {var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;return regex.test(email);}
function toQS(key, value) {
      uri = window.location.href;
      var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
      var separator = uri.indexOf('?') !== -1 ? "&" : "?";
      if (uri.match(re)) {
        return uri.replace(re, '$1' + key + "=" + value + '$2');
      }
      else {
        return uri + separator + key + "=" + value;
      }
}
var xhr;
call=function(action,data,func,params){
	if(typeof xhr !== 'undefined')
		xhr.abort();
	
    xhr = $j.ajax({
        type:'POST',
        url: config.home+action,
        data: data,
        
        beforeSend:function(){
            $j('._ld').show();
        },
        success:function(r){
            $j('._ld').hide();
            func(r);
        },
        error:function(xhr, ajaxOptions, thrownError){
            if(xhr.status==403) {
                 $j('.msg').html('Session has expired!');
            }
            $j('._ld').hide();
            if($j('body .msg').length)
                $j('body .msg').html('Some error occured, Please try again').show();
            else
                $j('body').append('<div class="msg">');
                $j('.msg').html('Some error occured, Please try again');
        }
    });
}
steal(root+'prototype.min.js',root+'core.js',root+'lib/ch/choosen.js',function(){
    EJS.config({cache: false});
    _view = function(p){
         var st='http://static.logstaff.com/templates/';
         var content = new EJS({url: st+p+'.ejs'}).render();
         return content;
    }
    steal(root+'lib/upload.js',root+'app',root+'app/timesheet.js',function(){
        var j=jQuery.noConflict();
        j.ajaxSetup({cache:false});
     
    // 
   
var State = History.getState();
//console.log(State);
if(State.data.state == undefined) State.data.state = window.location.href;
State.data.state = State.data.state.replace(config.home,'');
d.go(State.data.state);

  /////////////////////////route manager/////////////////////////
  $j('body').on('click','a',function(e){ if($j(this).hasClass('ext')) return true;
      var href = $j(this).attr('href');
      if(href==';' || href=='' || href=='#') return true;
      e.preventDefault();
      
      History.pushState({state:href,rand:Math.random()},$j(this).attr('title'),href);
   });
   $j('body').on('click','#pg-l',function(e){
      var href = window.location.href;
      e.preventDefault();
      href = href.replace(config.home,'');
      d.go(href);
   });
   
   History.Adapter.bind(window,'statechange',function(){
        var State = History.getState();
        if(State.data.state != undefined){
            State.data.state = State.data.state.replace(config.home,'');
            if(State.data.state == undefined) State.data.state = config.home;
                d.go(State.data.state);
        }
    });    
        /////////////////////  init //////////////
    
    });
});

