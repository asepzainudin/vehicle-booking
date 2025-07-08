"use strict";

//
// CKEditor Classic Initialization
//

import "@ckeditor/ckeditor5-build-decoupled-document/build/translations/id.js";
// import DecoupledEditor from "@ckeditor/ckeditor5-build-decoupled-document";

DecoupledEditor.defaultConfig.language = 'id';

export const DocumentEditor = DecoupledEditor;
