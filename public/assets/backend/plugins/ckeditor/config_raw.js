/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

 CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.language = 'vi';
	// config.uiColor = '#AADC6E';
	// config.filebrowserBrowseUrl = '/admin/connectorext';
    //config.filebrowserBrowseUrl = '/admin/filemanager/';

	config.extraPlugins = 'dialog';
	config.extraPlugins = 'clipboard';
	config.extraPlugins = 'lineutils';
	config.extraPlugins = 'widget';
	config.extraPlugins = 'dialogui';
	config.extraPlugins = 'image2';
	config.extraPlugins = 'tabletools';
	config.extraPlugins = 'tableresize';
	config.extraPlugins = 'oembed';



};

CKEDITOR.on('dialogDefinition', function(ev) {
    // Take the dialog name and its definition from the event data.
    var dialogName = ev.data.name;
    var dialogDefinition = ev.data.definition;

    if (dialogName == 'image2') {
    	var infoTab = dialogDefinition.getContents('info');
    	var field = infoTab.get('alt');
    	field['label'] = 'Mô tả khi không tải được ảnh.';
    }
});