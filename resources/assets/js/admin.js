require('./bootstrap');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


// Packacges and tools
import 'summernote/dist/summernote-bs4.min'
import './admin/init.summernote';
import './dropzone';

// Custom JS
import './admin/media-upload';
import './admin/top-bar';
import './admin/list';
import './admin/misc';
import './admin/upload-preview';
import './admin/upload-preview-config';
import './admin/image-picker';
import './admin/tags';
import './admin/permissions';
import './admin/media-details';
import './admin/article-type';
import './admin/page-builder';
import './admin/layout';
import './admin/popup';
import './admin/article-preview';

import '../../../node_modules/dragula/dist/dragula.min'