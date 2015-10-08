$j = jQuery.noConflict(); 
var Document = Class.create({
  el:{
     body:jQuery('body'),
     wrapper:jQuery('<div/>').attr('id','wrapper'),
     content:jQuery('<div/>').attr('id','C-c').addClass('cnt'),
     ls:jQuery('<div/>').attr('id','ls'),
     contentBody:jQuery('<div/>').attr('id','content_body'),
     galleryContainer:jQuery('<div/>').attr('id','gallery_container')
  },
  e:function(e){
      return eval('this.el.'+e);
  },
  initialize: function(name){
      this.e('body').prepend(this.e('wrapper'));
      this.e('wrapper').prepend(this.e('content'));
      this.e('wrapper').prepend(this.e('ls'));
  },
  header:function(){
        var header = new EJS({url: root+'templates/header.ejs'}).render();
        $j('#wrapper').prepend(header);

        $j("body").click(function() {
            $j(".categories").hide();
        });
        $j(document).on('click','._m',function(e){e.preventDefault();
          $j(".categories").show();
        });
  },
  setTitle:function(title){
      jQuery('title').text(title + '' + ' - Logstaff');
  },
  sidebar:function(){
     
  },
  content:function(content){
      this.e('contentBody').html(content);
  },
  
  footer:function(){
     
            jQuery('body').append('<div class="_ld" style="display: none;">Loading...</div>');
             
  },
  getHome:function(){
       
  },get:function(params){
      this._showld(true);
      var d=this;
  },
  getPath:function(){
      var uri = window.location.href;
      if(uri!=config.base)
        return uri.split(/[/ ]+/).pop();
  },
  scroll:function(){
    
    var d=this;
       $j(window).scroll(function(){
            if(d.infst && d.page<d.pages){
                var s=$j(window).scrollTop();var h=$j(document).height();var w=$j(window).height();
                var f=h-w-350;
                   if  (s >= f){
                        d.infst=false;
                        d.page++;
                        d.get({page:d.page,limit:40,_path:d.getPath()});
                    }
             }   
        });  
      
  },
  getMod:function(){
      var url = window.location.href;
      url=url.replace(config.base,'');
      var args = url.split('/');
      var module=args[0];
      return module;
  },
  _showld:function(mode){(mode)?$j('._ld').show():$j('._ld').hide();},
  go:function(url){
    url = url.replace(/^\/|\/$/g, '');
    var params = url.split('?');
    var route=params[0];
    console.log(url);
    switch(route){
        case (route.match(/^timesheets/) || {}).input:
            d.setTitle('Timesheet');
            ts.fetch({_p:route,_a:(params[1]!=undefined)?params[1]:''});
            break;
        case (route.match(/^activities/) || {}).input:
            d.setTitle('User Activities');
            act.fetch({_p:route,_a:(params[1]!=undefined)?params[1]:''});
            break;
        case (route.match(/^organizations\/create/) || {}).input:
            d.setTitle('Create organization');
            var content = new EJS({url: root+'templates/org/create.ejs'}).render();
            d.updateContent(content);
            
            break;
        case (route.match(/^organizations\/[-a-z0-9]/i) || {}).input:
            d.setTitle('View Organization');
            org.fetch({_p:route,_a:(params[1]!=undefined)?params[1]:''});
            break;
        
        case (route.match(/^organizations/) || {}).input:
            d.setTitle('All Organization');
            org.fetchAll({_p:route,_a:(params[1]!=undefined)?params[1]:''});
            break;
        case (route.match(/^profile/) || {}).input:
            d.setTitle('Profile');
            usr.profile({_p:route,_a:(params[1]!=undefined)?params[1]:''});
            break;
        case (route.match(/^reports/) || {}).input:
             var content = new EJS({url: root+'templates/html/test.ejs'}).render();
             d.updateContent(content);
        break;
        default:
            console.log(route + 'not found');
            d.setTitle('Error - Page not found');
            var content = new EJS({url: root+'templates/err/404.ejs'}).render();
            d.updateContent(content)
            break;
    }
  },
  updateContent:function(c){
      this.e('content').html(c);
  }
});

var d = new Document();
d.header();
d.footer();