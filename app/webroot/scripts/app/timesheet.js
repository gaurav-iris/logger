var Activity = Class.create({
    fetch:function(params){
        call('activities/ajax',params,function(r){ r=$j.parseJSON(r)
            var content = new EJS({url: root+'templates/actsi.ejs'}).render({data:r});
            d.updateContent(content)
        });
    }
});

var Timesheet = Class.create({
    fetch:function(params){
        call('timesheets/ajax',params,function(r){ r=$j.parseJSON(r)
            var content = new EJS({url: root+'templates/tsheets.ejs'}).render({data:r});
            d.updateContent(content)
        });
    }
});

var Organ = Class.create({
    fetchAll:function(params){
        call('organizations/ajax',params,function(r){ r=$j.parseJSON(r)
            var content = new EJS({url: root+'templates/org/organs.ejs'}).render({data:r});
            d.updateContent(content)
        });
    },
    fetch:function(params){
        call('organizations/ajax',params,function(r){ r=$j.parseJSON(r)
            jQuery('._ld').show();
            var content = new EJS({url: root+'templates/org/views.ejs'}).render({data:r});
            d.updateContent(content);
            jQuery('._ld').hide();
        });
    }
});

var User = Class.create({
    profile:function(params){
        call('users/ajax',params,function(r){ r=$j.parseJSON(r)
            var content = new EJS({url: root+'templates/usr/profile.ejs'}).render({data:r});
            d.updateContent(content);
            $j('select').chosen();
        });
    }
});

var ts = new Timesheet;
var act = new Activity;
var org = new Organ;
var usr = new User;