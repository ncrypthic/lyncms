(function(App, $) {
    function getUrlParam(paramName) {
        var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
        var match = window.location.search.match(reParam) ;

        return (match && match.length > 1) ? match[1] : '' ;
    }
    
    var funcNum = getUrlParam('CKEditorFuncNum');
    var mode = getUrlParam('mode');
    App.directives.push(new App.Directive("elfinder", {
        restrict: 'A',
        link: function() {
            if(!$('.elfinder').elfinder) {
                return;
            }
            $('.elfinder').elfinder({
                url : App.baseUrl+'/efconnect'+'?mode='+mode,
                lang : 'en',
                onlyMimes: [],
                getFileCallback : function(file) {
                    if (funcNum) {
                        window.opener.CKEDITOR.tools.callFunction(funcNum, '/'+file.url.replace("http://localhost/", ""));
                        window.close();
                    }
                }
            });
            $(window).resize(function(){
                var h = $(window).height();
                var $ef = $('.elfinder');
                if($ef.height() != h - 20){
                    $ef.height(h -20).resize();
                }
            });
        }
    }));
})(App, jQuery);