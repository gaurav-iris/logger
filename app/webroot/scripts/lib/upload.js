;(function ($, window, document, undefined ) {
    var pluginName = 'upload',
        defaults = {
            multiple:false,
            input:'files'
        };

    function Plugin( element, args ) {
        this.element = element;
        $.fn.upload.settings = $.extend( {}, defaults, args) ;
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    Plugin.prototype.init = function () {
        this.element.addEventListener("change", function () {
            var formdata = new FormData();
            traverseFiles(this.files);
        }, false);
        
    };
    
    function traverseFiles (files) {
        if (typeof files !== "undefined") {
            for (var i=0, l=files.length; i<l; i++) {
                uploadFile(files[i]);
            }
        }
        else {
            fileList.innerHTML = "No support for the File API in this web browser";
        }	
    }
    
    function uploadFile(file){
        var li = document.createElement("div"),div = document.createElement("div"),img,progressBarContainer = document.createElement("div"),			
                progressBar = document.createElement("div"),reader,xhr,fileInfo;
		var wrap=$('<div class="wfiles">');
                var itm =$('<div class="fitm prog">');
                var img = $('<img />');
                var bar = $('<div aria-valuemax="100" aria-valuemin="0" role="progressbar" class="ps ps-strip"></div>');
		var pBar = $('<div class="ps-bar"></div>').append(bar);
		
                itm.html(pBar.html(bar));
                if($('.fileList').length){
                    $('.fileList').html(itm);
                }
                if(typeof FileReader !== "undefined" && (/image/i).test(file.type)) {
			img.width(100);
                        reader = new FileReader();
			reader.onload = (function (img) {
				return function (evt) {
                                    img.attr('src',evt.target.result);
				};
			}(img));
                        itm.prepend(img);
			reader.readAsDataURL(file);
		}
                
                xhr = new XMLHttpRequest();
		xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var w = (evt.loaded / evt.total) * 100 + "%";
                        bar.width(w);
                        
                    }
                    else {
                            // No data to calculate on
                    }
		}, false);
		
		// File uploaded
		xhr.addEventListener("load", function () {
			progressBarContainer.className += " uploaded";
			progressBar.innerHTML = "Uploaded!";
		}, false);

		xhr.open("post", $.fn.upload.settings.post, true);
		
		// Set appropriate headers
//		xhr.setRequestHeader("Content-Type", "multipart/form-data");
		xhr.setRequestHeader("X-File-Name", file.name);
		xhr.setRequestHeader("X-File-Size", file.size);
		xhr.setRequestHeader("X-File-Type", file.type);
                xhr.send(file);
                xhr.onreadystatechange=function(){
                    if(xhr.readyState==4 && xhr.status==200){
                        var response = $.parseJSON(xhr.responseText);
                        $( $.fn.upload.settings.input).val(response.file);
                    }
                }
		
		// Present file info and append it to the list of files
		fileInfo = "<div>" + file.name + "</div>";
//		fileInfo += "<div><strong>Size:</strong> " + parseInt(file.size / 1024, 10) + " kb</div>";
//		fileInfo += "<div><strong>Type:</strong> " + file.type + "</div>";
		div.innerHTML = fileInfo;
		$('.fileList ul').html(li);
    }

    $.fn[pluginName] = function ( options ) {
        return this.each(function () {
            if (!$.data(this, 'plugin_' + pluginName)) {
                $.data(this, 'plugin_' + pluginName, 
                new Plugin( this, options ));
            }
        });
    }

})( jQuery, window, document );


function _(elementID){
    return document.getElementById(elementID);
}
function uploadFile(){
    var file = _("image1").files[0];
    var formdata = new FormData();
    formdata.append("file1", file);
    var ajax = new XMLHttpRequest();
    ajax.upload.addEventListener("progress", myProgressHandler, false);
    ajax.addEventListener("load", myCompleteHandler, false);
    ajax.addEventListener("error", myErrorHandler, false);
    ajax.addEventListener("abort", myAbortHandler, false);
    ajax.open("POST", "ajaxupload2.php"); ajax.send(formdata);
}

function myProgressHandler(event){
    _("loaded_n_total").innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
    var percent = (event.loaded / event.total) * 100;
    _("progressBar").value = Math.round(percent);
    _("status").innerHTML = Math.round(percent)+"% uploaded... please wait";
}
function myCompleteHandler(event){
    _("status").innerHTML = event.target.responseText;
    _("progressBar").value = 0;
}
function myErrorHandler(event){
    _("status").innerHTML = "Upload Failed";
}
function myAbortHandler(event){
    _("status").innerHTML = "Upload Aborted";
}