(function() {
 	window.CyberFM = {
 		filebrowserCallBack: function(field, url, type, wind){
			
			f = {
				x : parseInt(screen.width / 2.0) - (wind.width / 2.0),
				y : parseInt(screen.height / 2.0) - (wind.height / 2.0),
				width : 810,
				height : 500,
				inline : 1,
				url: CyberFM.url + '/index.php',
				title: 'Cyber File Manager'
			};	
			
			CyberFM.params = {field: field, wind: wind};
			
			// Use TinyMCE window API
			if (window.tinymce && tinyMCE.activeEditor){
				CyberFM.w = tinyMCE.activeEditor.windowManager.open(f);
				return CyberFM.w;	
			}
				
			// Use jQuery WindowManager
			if (window.jQuery && jQuery.WindowManager){
				CyberFM.w =  jQuery.WindowManager.open(f);
				return CyberFM.w; 	
			}
				
			// Use native dialogs
			CyberFM.w = window.open(f.url, 'mcFileManagerWin', 'left=' + f.x + 
				',top=' + f.y + ',width=' + f.width + ',height=' + 
				f.height + ',scrollbars=' + (f.scrollbars ? 'yes' : 'no') + 
				',resizable=' + (f.resizable ? 'yes' : 'no') + 
				',statusbar=' + (f.statusbar ? 'yes' : 'no')
			);

			try {
				CyberFM.w.focus();
			} catch (ex) {
				// Ignore
			}
		},
		
		
		execute : function (d){
			CyberFM.params.wind.document.forms[0].elements[CyberFM.params.field].value = d.Data;
			CyberFM.params.wind.document.forms[0].elements[CyberFM.params.field].onchange();
			tinyMCE.activeEditor.windowManager.close(d.w);
		},
		
		getInfo : function (){
			return {
				longname : 'Cyber File Manager',
				author : 'WSDLab',
				authorurl : 'http://www.wsdlab.ru/',
				infourl : 'http://www.wsdlab.ru/',
				version : '1.0'
			};
		}
	 }
	
	tinymce.create('tinymce.plugins.CyberFMPlugin', {
		init : function(ed, url) {
			ed.settings.file_browser_callback = CyberFM.filebrowserCallBack;
			CyberFM.editor = ed;
			CyberFM.url = url;
		},

		getInfo : function() {
			return CyberFM.getInfo();
		}
	});

	tinymce.PluginManager.add('cyberfm', tinymce.plugins.CyberFMPlugin);
})();